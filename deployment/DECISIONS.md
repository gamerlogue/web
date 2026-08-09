# Deployment decisions

The decisions taken on this template's Docker/Compose/Vite setup, each with its reason, its price and the
evidence behind it. The point is to avoid relitigating the same questions in six months, and to know what
breaks if you change them.

Every claim marked *Verified* was established by running the thing in the real image, not by reading the
source. Where a number of runs is given, it is because the behaviour turned out to be a race and a single
run was misleading.

---

## Architecture

### We use the image's Caddyfile, not Octane's stub
`--caddyfile=/etc/frankenphp/Caddyfile`, both in `compose.prod.yaml` and in `start-container-dev.sh`.

**Why**: that Caddyfile ships `trusted_proxies static` with the Docker/private/loopback ranges plus
Cloudflare's, `client_ip_headers CF-Connecting-IP X-Forwarded-For`, `import performance`,
`import security`, `encode zstd br gzip` and the healthcheck endpoint with `log_skip`. Octane's stub has
none of that: without `trusted_proxies`, behind a proxy Laravel sees the proxy's IP instead of the
client's. It also means dev and prod share the same configuration, which rules out a class of bugs that
only show up in production.

**Consequence**: `CADDY_GLOBAL_OPTIONS`, `CADDY_PHP_SERVER_OPTIONS`, `CADDY_SERVER_EXTRA_DIRECTIVES` and
`FRANKENPHP_CONFIG` become the variables that actually matter — with Octane's stub the first two are
either ignored or overwritten. In particular **the `worker` block comes exclusively from
`FRANKENPHP_CONFIG`**: if that variable is empty or points at the wrong path, the server does not start
(`worker filename is invalid … no such file or directory`). Note that Octane installs the worker under
`public/`, not in the project root. `config/octane.php` forwards these variables to the child process
through `octane.caddy.env`, which is spread last in `StartFrankenPhpCommand` and therefore wins over the
values Octane generates.

**If you go back to the stub**, `CADDY_SERVER_EXTRA_DIRECTIVES` has to be removed: there it is
interpolated inside `route { }`, where `log` is not a handler directive, so config adaptation fails and
the server never starts.

### Vite runs in plaintext behind Caddy, on the same public port
Vite listens on `127.0.0.1:5174` without TLS; Caddy terminates TLS on 5173 and proxies to it
(`deployment/dev/vite.caddyfile`).

**Why**: when Vite handles TLS itself, Vite 8 builds the dev server with `node:http2.createSecureServer`
— hard-coded in `resolveHttpServer`, with no opt-out — and the HTTP/1.1 `Upgrade` of the WebSocket
handshake never reaches its listener, so HMR gets a 403 on every attempt.

*Verified*, with `websocat --protocol vite-hmr --origin https://<host>`:

| Setup | Result |
|---|---|
| isolated, `server.https` set, WS on the dev server port | `403 Forbidden` |
| isolated, no `server.https`, WS on the same port | `{"type":"connected"}` |
| isolated, `server.ws.port = 24678` (dedicated HMR port) | `{"type":"connected"}` |
| **adopted**: Vite plaintext on 5174 + Caddy TLS on 5173 | `{"type":"connected"}` |

On the same TLS port, HTTP/2 requests answer 200 while HTTP/1.x requests answer 403 — including the WS
handshake, and including the `vite-ping` subprotocol, which in Vite's `shouldHandle` bypasses both the
host check and the token check. If even `vite-ping` is refused, Vite's own code was never reached: it is
neither the token nor `allowedHosts`.

The dedicated-port variant works because of `createWebSocketServer`:
`const wsServer = wsCustomServer || (!wsPort || wsPort === config.server.port) && server;` — with
`ws.port ≠ server.port` Vite spins up a separate server through `node:https.createServer` (HTTP/1.1),
where the upgrade works. We preferred the reverse proxy so as not to publish a second port.

**Consequence**: the Caddy site block **must not carry any `tls` directive**. *Verified* with an empty
`XDG_DATA_HOME`, i.e. simulating a brand new project's first boot — the normal case for a template:

| Variant | Result |
|---|---|
| `tls <crt> <key>` pointing at Caddy's own certificates | ❌ `open …/<host>.crt: no such file or directory` → **Caddy does not start at all** |
| `tls internal` | ❌ `hostname appears in more than one automation policy, making certificate management ambiguous` |
| **no `tls` directive** | ✅ `certificate obtained successfully {"issuer":"local"}` from empty volumes, handshake OK |

With `CADDY_AUTO_HTTPS=on` (set by the `dev` stage) the block inherits the main site's automation policy,
so Caddy issues the certificate on the fly from its internal CA.

**Worth knowing when debugging HMR**: the client's `directSocketHost` stays on the internal port, 5174.
That is only the *fallback* URL — the primary one is `ws.host:clientPort`, i.e. 5173, and it works. An HMR
error message naming 5174 is the fallback, not the cause.

### PHP hot reload does not use Octane's `--watch`
The `watch` directives are injected inside `worker { }` through `FRANKENPHP_CONFIG`, built by
`start-container-dev.sh`.

**Why**: Octane's `buildWatchConfig()` generates `CADDY_SERVER_WATCH_DIRECTIVES` for its own stub, where
the placeholder sits inside `worker { }`. In the image's Caddyfile it sits one level up, under
`frankenphp { }`, where `watch` is not a valid subdirective.

| Variant | Result |
|---|---|
| `watch` under `frankenphp { }` (i.e. `--watch`) | ❌ `unknown "frankenphp" subdirective: watch` |
| `{$CADDY_SERVER_WATCH_DIRECTIVES}` nested inside `FRANKENPHP_CONFIG` | ❌ `{$…}` placeholders are **not** re-expanded: substitution is single-pass |
| `watch` written literally inside `worker { }` in `FRANKENPHP_CONFIG` | ✅ |

**Consequence**: `config/octane.php` remains the single source of truth for the path list — the script
reads it with `php artisan config:show octane.watch --no-ansi` — but that list **has to be adapted**, and
neither transformation is optional:

- **single file paths must be dropped**: a `watch <file>` segfaults FrankenPHP (SIGSEGV, exit 139) when
  the watcher restarts the workers while they are still booting. Twelve runs of the real dev script
  (`octane:start` + `bun dev` under `concurrently`):

  | `watch` list | Runs | Crashes |
  |---|---|---|
  | contains `composer.lock` and/or `.env` (file paths) | 6 | **5** |
  | only `<dir>/**/*.php` patterns | 6 | **0** |

  It is a race, not a deterministic failure, so do not conclude anything from a single clean run. Note
  that the default list in `config/octane.php` contains `composer.lock` and `.env` — tested verbatim, it
  crashed 2 out of 2;
- **directories must be narrowed to PHP files**, otherwise the `resources/ts` rewrites done by
  Vite/wayfinder and the `bootstrap/cache` ones done by Laravel cause a reload storm.

**The `set -f` around the loop in the script is mandatory, not cosmetic.** Without noglob the shell
expands the patterns (`database/**/*.php` becomes the list of matching files), which the `-d` test then
drops, **silently losing the pattern**. That is how `database/**/*.php` and `resources/**/*.php` went
missing in the first draft while the watcher still appeared to work.

Side effect: we lose automatic reload on `composer.lock` and `.env`, which need manual intervention
anyway (`config:clear` after an `.env` change).

*Verified*: all 8 patterns present, `composer.lock` and `.env` dropped; `WEBSERVER=octane-watch` starts
clean 2 runs out of 2; and the reload really fires — writing to `routes/web.php` makes FrankenPHP log
`shutting down` + `restarting {"exit_status": 0}` on every thread. A bare `touch` (mtime only) does not
trigger it, an actual write does.

---

## Build

### No database during the build
The image does not create a dummy SQLite file, nor run `migrate --force`, nor `optimize:clear`.

**Why**: the command that needed a database was `optimize:clear`, not wayfinder. *Verified* by running the
build commands in the image with no `.env` and no database at all:

```
php artisan package:discover   → DONE
php artisan wayfinder:generate → EXIT=0
php artisan optimize:clear     → QueryException, EXIT=1
```

`config/cache.php` uses `env('CACHE_STORE','database')` and `.env` is dockerignored, so during the build
the store is `database` and `cache:clear` queries the `cache` table. And there was nothing to clear at
build time anyway: `bootstrap/cache/**/*` is already excluded by `.dockerignore`. What is left is:

```dockerfile
RUN composer dump-autoload --optimize --apcu --no-dev
RUN php artisan wayfinder:generate --path=resources/ts
```

**Consequence**: the build no longer depends on the migrations, so it cannot break because of a
`fullText()` or an `ALTER` that SQLite does not support, and no dummy database is left in the layers. The
config/route/view caches are built at boot through `AUTORUN_ENABLED=on`, which is the right place since
they depend on the runtime environment.

### `opcache.validate_timestamps` stays at 1, in production too
**Why**: in Octane worker mode `include`s happen once per worker lifetime, not per request, so the cost is
roughly one `stat()` per file, once — unlike PHP-FPM, where it would be per request. In exchange it lets
you edit a file inside a production container and see the effect after an `octane:reload`, without
recreating the container.

### JIT in production only
`PHP_OPCACHE_JIT=tracing` + `PHP_OPCACHE_JIT_BUFFER_SIZE=64M` in the `prod-base` stage, not in `base`.

**Why**: the base image default is `JIT_BUFFER_SIZE=0`, which keeps the JIT **off** even with
`PHP_OPCACHE_JIT=1` — *verified* with `php -i`. The buffer has to be set, otherwise it is a configuration
that looks enabled and isn't. In dev, with Xdebug loaded, the JIT is counterproductive anyway.

---

## Observability

### Logs to file **and** to stdout
`CADDY_GLOBAL_OPTIONS` writes the runtime log to `/var/log/frankenphp/frankenphp.log`,
`CADDY_SERVER_EXTRA_DIRECTIVES` writes the access log to `access.log`, both with `roll_size`/`roll_keep`.

**Why the rotation**: Docker does not rotate files inside the container; `logging: json-file` with
`max-size` only covers stdout.

**Why two distinct logger names** (`file` and `access`): with the same name one of the two is silently
dropped — *verified*, only `access.log` was being written.

**Why stdout as well**: in the global block of the image's Caddyfile an unnamed logger is rejected
(`duplicate global log option for: default`, since the image already imports one), so the default logger
stays on stdout and the runtime logs end up in both places. That is not a flaw: it is the only copy that
survives a redeploy, see the accepted risks.

`/var/log/frankenphp` is created and chowned in the `Dockerfile`, and chowned **again** in the `dev` stage
after `docker-php-serversideup-set-id`, which changes www-data's uid and would otherwise leave the
directory owned by an orphan uid.

### `FORCE_COLOR=1` instead of `unbuffer`
Coloured output used to come from wrapping commands in `unbuffer`, which fakes a pty so that the tools'
"am I on a terminal?" check passes. The cost was that PID 1 became `tclsh`: `/usr/bin/unbuffer` is an
expect script with no signal handlers, so on `docker stop` SIGTERM killed `tclsh`, the pty closed and
Octane got **SIGHUP** instead — no graceful shutdown, in-flight requests cut on every deploy, and no
zombie reaping either.

Every tool involved can be told to colour explicitly instead. *Verified* in the image, output piped to a
file:

| Tool | No pty | With `FORCE_COLOR=1` |
|---|---|---|
| artisan / Symfony Console | no colours | ✅ (`--ansi` works too) |
| `concurrently` prefixes | no colours | ✅ |
| Vite (`bun dev`) | no colours | ✅ |

`FORCE_COLOR=1` is set as an `ENV` in the Dockerfile's `base` stage, so it covers all three plus the
services whose `command` runs straight in its own container — `task`, `queue`, `horizon` and the
production `laravel` never go through the dev script. Symfony reads it in `Output/StreamOutput.php`, so
it applies to every artisan command without touching them one by one.

The off switch is **`NO_COLOR=1`, not `FORCE_COLOR=0`** — *verified*: Symfony only looks at the first
character of the value, so `0` still reads as enabled. Set `NO_COLOR=1` on a service if a log collector
ever chokes on the ANSI escapes.

The flushing half of `unbuffer`'s name was never needed here: PHP CLI runs with `implicit_flush=On` and
`output_buffering=0`, *verified* — a script that prints, sleeps 4s and prints again has its first line in
the pipe after 2s.

**Consequence**: in production the commands are plain `["php", "artisan", …]`, so `php` is PID 1, gets
SIGTERM directly and Octane drains gracefully. In dev the script ends with `exec bunx concurrently`, which
becomes PID 1 and forwards SIGHUP/SIGINT/SIGTERM to its children.

---

## Security

### Service ports are published in dev only
MySQL, Redis, 443 and Caddy's admin API live in `compose.yaml`. `compose.common.yaml` — which
`compose.prod.yaml` also extends — publishes only the application port. Likewise
`MYSQL_ALLOW_EMPTY_PASSWORD` and `MYSQL_ROOT_HOST: '%'` exist in dev only.

Beware when editing `compose.prod.yaml`: `depends_on` in short form **wins over** the long form inherited
through `extends`, silently downgrading `service_healthy` to `service_started`. Check with
`docker compose config` after touching it.

### `CADDY_ADMIN="localhost:2019"`
With the image's Caddyfile, `CADDY_ADMIN=":2019"` binds on every interface — *verified* on the adapted
config: `"admin":{"listen":":2019"}` — and Caddy's admin API accepts `POST /load` with an arbitrary
configuration, which is a full server takeover. `localhost:2019` confines it to the container's loopback;
`start-container-dev.sh` still extracts the port from it with `awk -F:`.

### `cap_drop: [ALL]` on mysql and redis, not on laravel
On mysql and redis adding back `CHOWN`, `SETUID`, `SETGID` and `DAC_OVERRIDE` is enough — *verified*, both
come up healthy from a clean volume, database init included, with no permission errors. On the `laravel`
service it is not: FrankenPHP binds port 80, so it would need `CAP_NET_BIND_SERVICE` plus the capabilities
the entrypoint uses as root before dropping to `www-data` — a six-entry list that breaks on the first base
image update. `no-new-privileges`, enabled on every service, already closes the main privilege escalation
path.

### `MYSQL_ROOT_PASSWORD` can be separated
`${DB_ROOT_PASSWORD:-$DB_PASSWORD}`: where it matters you set a root password distinct from the
application user's, where it doesn't nothing changes.

### `env_file: .env` only where it is needed
Not on `mysql` and `redis`. It would inject `APP_KEY`, SMTP credentials and API tokens into containers
that have no use for them — readable via `docker inspect` and `/proc/1/environ` — and it does not help
`${…}` interpolation anyway, which Compose resolves from the project directory's `.env`.

### log-viewer stays installed in production
It is fail-closed on its own: with `require_auth_in_production` (default `true`), in production and with
neither a `viewLogViewer` gate nor an auth callback, `AuthorizeLogViewer` calls `abort(403)`. If you ever
do want it in production, the gate has to be defined explicitly.

---

## Accepted risks

Known and deliberate. Each one has a price, written down here so that it stays a choice and does not
become a surprise.

### No volume for `/var/log/frankenphp`
The log files live in the container layer and disappear on every `docker compose up --force-recreate`.
The stdout copy, with `json-file` rotation, is the one that survives.

### Redis without a password
In dev the port is published on `0.0.0.0`, so Redis is reachable from the local network with no
authentication — the container says so in its own logs. In production the password is set by CI at deploy
time.

### Unpinned images
`mysql`, `redis:alpine`, `axllent/mailpit:latest` and the base image's floating tag: we want automatic
updates. The risk is a MySQL major bump that makes the existing data directory unreadable.

### Development tooling in the `base` stage
`vim`, `fish`, `git`, `mariadb-client`, `micro`, `nss-tools`, `xh`, `wget` and `iputils` sit in `base` and
are therefore inherited by `prod`, because debugging in production does happen. The price is image size
and attack surface: an attacker who gets code execution finds a DB client and network tools ready to use.
`unzip` is genuinely needed, for Composer. `expect` used to be, for `unbuffer`, and was dropped once
`FORCE_COLOR` replaced it — verified first that nothing in the image or the repo invokes `unbuffer` and
that `apk info --rdepends expect` lists no dependent package.

### No resource limits in the compose files
They depend on the host, so they are set per deployment. If you do add them: `--workers=auto` reads the
**host's** CPU count, not the cgroup limit, so it must be paired with an explicit `OCTANE_WORKERS`,
otherwise you get N workers fighting over a fraction of a CPU. Redis is the other one worth sizing:
without `--maxmemory` it grows until the OOM killer takes it, losing the whole cache instead of evicting
old keys, which is why `--maxmemory` + `allkeys-lru` are already set.

### The `horizon` service is defined but unused
Neither `compose.yaml` nor `compose.prod.yaml` extends it: both use `queue` with `queue:work`. It stays in
`compose.common.yaml` for applications that want it.

---

## Looks wrong, isn't

Things that read like bugs and have already been checked. Please do not "fix" them without re-measuring.

| Apparent problem | Why it is fine |
|---|---|
| Healthchecks specify only `start_period`, no `interval`/`retries` | Compose **merges** with the image's `HEALTHCHECK`. Verified on a running container: `Interval:10s Timeout:3s StartInterval:3s Retries:3` all come from the image |
| log-viewer assets are never published in the image | v3.24.2 inlines them in the `@else` branch of its `index.blade.php`, and marks `assetsAreCurrent()` as `@deprecated — Publishing assets is no longer required` |
| `opcache.validate_timestamps` is 1 in production | See the Build section: in worker mode the cost is about one `stat()` per file, once, not per request |
| `bootstrap/cache` looks missing from `.dockerignore` | It is there, further down the file, as `bootstrap/cache/**/*` |
| The `CADDY_*` variables look unused | True only of Octane's stub. `/etc/frankenphp/Caddyfile`, which is the one in use, references all of them |
| `EXPOSE 80` without 2019 in the prod stage | Deliberate: the admin API is on loopback and no compose file publishes it |

### How to test the HMR WebSocket without wasting a day
**Any WebSocket test without `--protocol vite-hmr` is invalid.** Vite's `hmrServerWsListener` only handles
the upgrade if `sec-websocket-protocol` is `vite-hmr` or `vite-ping` **and** `pathname === config.base`;
anything else is dropped before any check and answers 403 for the wrong reason. Likewise `busybox wget`
speaks HTTP/1.0 and gets a 403 from Vite's TLS dev server regardless of configuration — a probe artifact,
not a finding. The command that gives a straight answer, from inside the container:

```sh
TOK=$(xh --verify=no -b GET "https://$SERVER_NAME:5173/@vite/client" | grep -aoE 'wsToken ?= ?"[^"]+"' | sed 's/.*"\(.*\)"/\1/')
websocat -k --protocol vite-hmr --origin "https://$SERVER_NAME" "wss://$SERVER_NAME:5173/?token=$TOK"
```

`{"type":"connected"}` means the whole chain is healthy and the problem, if any, is in the browser.

Two more probe traps worth remembering: `pgrep -f "<pattern>"` also matches the shell running the
command, so reading `/proc/<pid>/environ` that way can silently show you the shell's environment instead
of the server's — match on `/proc/*/comm` instead; and inside the container the Caddy local CA is not in
the system trust store, so any TLS client needs `-k`/`--verify=no` or it fails for reasons unrelated to
what you are testing.
