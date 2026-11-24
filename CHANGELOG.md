# Changelog

<a name="0.1.0"></a>
## 0.1.0

> Released on November 24, 2026

### ✨ Features

- [`71112bc`](https://github.com/gamerlogue/web/commit/71112bcf7a68af78fa3914c6179a69550139bab0) Remove unnecessary link type
- <details><summary><a href="https://github.com/gamerlogue/web/commit/26fa86b7e121e3e215d907c415c8ef39cf9c9289"><code>26fa86b</code></a> Add type hints for $this in routes&#x2F;console.php (#6559)</summary>

  > * feat: add type hints for $this in routes/console.php
  >
  > * Update console.php
  >
  > * Update console.php
  >
  > ---------

  </details>
- [`fba5b61`](https://github.com/gamerlogue/web/commit/fba5b61b6087f5fcd37d797163cbf0a442ed31b2) Initial commit
- [`b96ac65`](https://github.com/gamerlogue/web/commit/b96ac652a7cc219dd7e8dcfa1b36aaabd1e183fd) Update Telescope access control to use environment variable for admin email
- [`5be7855`](https://github.com/gamerlogue/web/commit/5be7855632e42dd26ed781cdcd3a2cae8b89fd5b) Migrate tests to Pest framework and update composer dependencies
- [`d57e62d`](https://github.com/gamerlogue/web/commit/d57e62dfa989ad9d12603461190f419ea417650a) Remove unused socialite service configurations
- [`996994e`](https://github.com/gamerlogue/web/commit/996994eb61dcc8f1cba48541c7f7742c703c5ca2) Configure Pest as the testing framework and update project settings
- [`f7fa7d2`](https://github.com/gamerlogue/web/commit/f7fa7d2478e1b47b894998758e6d558713690a7e) Implement IGDB proxy controller with caching and rate limiting
- [`4d758ea`](https://github.com/gamerlogue/web/commit/4d758ea2a8a3922f64a96611a92ab812f3b794cd) Add IGDB proxy routes with throttling middleware
- [`77db741`](https://github.com/gamerlogue/web/commit/77db74167100624435e70ba37d4746b391afbb13) Integrate IGDB Laravel package and update proxy controller for caching
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2a5e536cf741685b27bc1f75b5b64ec8a4392482"><code>2a5e536</code></a> <b>auth:</b> 🔑 Integrate OpenID Connect authentication</summary>

  > Integrates OpenID Connect to enable single sign-on (SSO) and leverage external identity providers for user authentication. This enhances security and simplifies user management by delegating authentication responsibilities.
  >
  > The `User` model is updated to utilize the OIDC trait for user mapping, simplifying its structure by removing direct activity logging which can be handled by other means or is not directly relevant to the OIDC user synchronization.
  >
  > Additional proxy ranges are trusted to ensure correct IP resolution in containerized or load-balanced environments, which is crucial for secure OIDC interactions. IDE and static analysis configurations are added to maintain code quality and consistency with the new dependencies.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/47712832d7ab0c3a1ba9bed51e6b2f25f1d4997b"><code>4771283</code></a> <b>horizon:</b> :gear: Make Horizon admin email configurable</summary>

  > This change moves the Horizon admin email from a hardcoded value to an environment variable. This improves flexibility and maintainability, allowing the admin email to be configured without code changes. It also enhances security by not embedding a specific email in the codebase.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9e0b9032450f6acc693d89018290a21337cb3209"><code>9e0b903</code></a> ✨ Add specific trusted proxy headers</summary>

  > This change ensures the application correctly identifies the client's IP address, host, port, and protocol when deployed behind various proxy configurations. Explicitly trusting these `X-Forwarded-*` headers prevents issues with routing, session management, and security features that rely on accurate client information.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e2759a2c8be3d6e703ffcbe2bb783ae2f5462f9b"><code>e2759a2</code></a> <b>auth:</b> ✨ Add Sanctum API token generation endpoint</summary>

  > This change integrates Laravel Sanctum to enable secure API token generation. It allows authenticated users to obtain personal access tokens, which client applications can then use for stateless authentication when interacting with the API. This provides a robust solution for token-based authentication for SPAs and mobile applications.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9c1d798e6f8b4ae64427fb10e2fa9af4e7cc3331"><code>9c1d798</code></a> ✨ Create personal access tokens table</summary>

  > This migration establishes the database structure required for managing personal access tokens. It enables secure API authentication, allowing users to generate and manage tokens for accessing application resources.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8e5e61e83a32b09d18f44260d19bdcf2aa4b8b71"><code>8e5e61e</code></a> <b>auth:</b> ✨ Redirect with token and user ID</summary>

  > This change facilitates client-side authentication for external applications.
  > Redirecting with the token and user ID allows clients to directly capture details from the URL.
  > This streamlines the login process and improves integration with native applications.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b7b7ee49c1e63ce027d44d985da10b69f8484079"><code>b7b7ee4</code></a> <b>api:</b> ✨ Implement game library entries API</summary>

  > This change establishes the core infrastructure for users to manage their personal game libraries.
  > By integrating Api-Platform, it provides a robust and standardized JSON:API interface
  > for creating, reading, updating, and deleting `LibraryEntry` resources. This facilitates
  > future development of client-side applications that interact with user game data.
  > The setup includes custom serialization logic for plain IDs and error handling,
  > along with authentication redirects and user-specific data filtering to ensure security
  > and compliance with JSON:API specifications.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b114f4532eab5d2192421ad16627d972ccf31a4b"><code>b114f45</code></a> 📜 Add MIT license file</summary>

  > This ensures clear legal terms for the project, defining how the software can be used, modified, and distributed. It provides legal clarity for both contributors and users, fostering open-source collaboration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b1c4b8b7299b8090e7b447dbbc36c522a864f2f3"><code>b1c4b8b</code></a> <b>logging:</b> ✨ Add deprecations logging channel</summary>

  > This dedicated channel ensures that deprecation warnings are captured and can be monitored separately from general application logs. It helps proactively identify and address deprecated code usage.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f709446a7d7a300b34cea40c540eaed5e86bfe57"><code>f709446</code></a> <b>config:</b> ⚙️ Prioritize Redis for cache and queue failover</summary>

  > This change ensures that Redis is the first fallback option for both caching and queueing systems. This leverages Redis's in-memory data store for significantly faster and more resilient failover, improving overall application performance and reliability when primary connections are unavailable.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/77982ed17cbf10761e4df458c7ce648e27453ffd"><code>77982ed</code></a> 🔒 Define log viewer authorization gate</summary>

  > This gate restricts access to the log viewer to only the administrative user defined in the application configuration. This ensures sensitive log information remains protected and accessible only by authorized personnel.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e3c02855a4136c630187ee2d37394c193f35f548"><code>e3c0285</code></a> <b>logging:</b> ⚙️ Replace dynamic deprecation log channels with a file path</summary>

  > This update transitions the deprecation logging configuration from a dynamic set of channels to a fixed file path. This change simplifies the management and monitoring of PHP deprecation warnings by ensuring they are consistently written to a single, dedicated file. The previous setup, relying on `LOG_STACK` and server name, could lead to varied logging destinations, making it difficult to track all deprecation notices effectively.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/274e7d69ab0a1eba272dc2c01f7c098bfd0cd9be"><code>274e7d6</code></a> <b>logs:</b> 🛂 Allow local access to log viewer</summary>

  > This change simplifies local development by granting direct access to the log viewer. It removes the need for developers to configure a specific admin email or log in as an administrator when working in a local environment, streamlining debugging efforts.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5de96bc3b2ecd777fd3e9e9a432534066112e5be"><code>5de96bc</code></a> <b>dev-tools:</b> ✨ Replace Laravel Debugbar with Clockwork</summary>

  > This change swaps out Laravel Debugbar for Clockwork as the primary local development debugging tool. Clockwork offers a more performant and less intrusive debugging experience, reducing resource overhead and providing clearer insights into application requests directly within the browser developer tools.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/97cfc670f3eb0c562a01d0daa274293046c82a59"><code>97cfc67</code></a> <b>deps:</b> ✨ Add Laravel Boost package</summary>

  > Integrates Laravel Boost to leverage AI-assisted development. This package provides essential context and structure for AI models, aiming to enhance productivity and code quality within the Laravel application by streamlining the development process with intelligent assistance.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/705aff430b3c0defec3374120a673084b5c82eb7"><code>705aff4</code></a> <b>root:</b> ✨ Show user login status on root endpoint</summary>

  > Previously, the root endpoint only returned a static "OK". This change enhances its utility by dynamically displaying the current authentication status and the logged-in user's name, providing immediate feedback for testing and debugging.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/26cb7b8ffa5c3784bddc364574e4bf07f69c84e7"><code>26cb7b8</code></a> <b>prod-compose:</b> 🐳 Expose port 8000 for Laravel service</summary>

  > This port mapping is essential to make the Laravel application accessible from outside the Docker network in the production environment. It enables external systems, such as a reverse proxy or direct browser access, to connect to the web server running within the container.

  </details>
- [`4331085`](https://github.com/gamerlogue/web/commit/4331085f329bdb355f7b7a3479c2cb1fe07aa8d4) **db:** 🗃️ create notifications table migration
- [`a2e4ea9`](https://github.com/gamerlogue/web/commit/a2e4ea9ec2d752e8d3311f87be65732c2c571424) **auth:** 🔒 restrict PATCH user requests to resource owner via UserFormRequest
- [`bc4470b`](https://github.com/gamerlogue/web/commit/bc4470b1a40b269e24eb78b2cef3acde3b56e25e) **mcp:** 🚀 add MCP server configuration for Laravel Boost
- <details><summary><a href="https://github.com/gamerlogue/web/commit/83e6be8a78e726af8eb2bc9689aeb0186d713a4d"><code>83e6be8</code></a> <b>library:</b> ✨ add editions and platforms IDs to LibraryEntry model</summary>

  > - Updated LibraryEntryFormRequest to validate editions_ids and platforms_ids as arrays.
  > - Modified LibraryEntry model to include editions_ids and platforms_ids properties.
  > - Added migration to alter library_entries table for new editions_ids field.
  > - Enhanced LibraryEntryAuthorizationTest to check for new fields during entry creation.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/df2559a246db20f757ecf16ca61ed04cdd664398"><code>df2559a</code></a> <b>mcp:</b> 🚀 add MCP server configuration for Laravel Boost</summary>

  > - Introduced new configuration files for MCP server settings.
  > - Added command and arguments for Laravel Boost to streamline development.
  > - Updated .gitignore to exclude specific Laravel Boost files.

  </details>
- [`5966e24`](https://github.com/gamerlogue/web/commit/5966e246701cbec14c002be853c1dc08c4432f0e) ⬆️ Upgrade to Laravel 13
- [`986fbbc`](https://github.com/gamerlogue/web/commit/986fbbceae8222780cf019d513a30e6b8f3f2c53) Feat(validation): ✨ add new validation messages for encoding and credential formats
- [`122f659`](https://github.com/gamerlogue/web/commit/122f6594315b18c418bf6d581d1fdeb8dae9de08) ✨ Added Laravel Octane
- [`9cc23ee`](https://github.com/gamerlogue/web/commit/9cc23eefb5fe0b8be48cc411ab3fb537781aae31) ✨ Added debug bar and log viewer
- [`2824665`](https://github.com/gamerlogue/web/commit/28246654a60acf99800d2d1d77ddc72025c91b80) ✨ Added Laravel Pulse
- [`7e633c1`](https://github.com/gamerlogue/web/commit/7e633c13b7558b964c32bb55890652ae33dd188c) ✨ Added watch to octane server start command
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3b5522f5f2e12d9297bcba6bfdfd1aa66d9ff451"><code>3b5522f</code></a> ✨ Added Vite to Sail container</summary>

  > The custom command adds a supervisor config to automatically start Vite

  </details>
- [`418e3a1`](https://github.com/gamerlogue/web/commit/418e3a18806674f1019b108cf26c4477cb8cfb22) ✨ Use daily log file rotation
- [`158df23`](https://github.com/gamerlogue/web/commit/158df23a39f38c3678cabebb764019c39eada865) ✨ Added Sail venv
- [`c66c902`](https://github.com/gamerlogue/web/commit/c66c902c29e877310e73f7884e311786c9a8132f) ✨ Added Telescope
- [`386a875`](https://github.com/gamerlogue/web/commit/386a87566a83f9530f7f21ec33ddca8dba003555) 🎉 Initial commit
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8d6c7259acaf911fd6d1f2d39cdd5698e8abdfb9"><code>8d6c725</code></a> <b>base:</b> ✨ add initial README template</summary>

  > This commit introduces a basic README template.
  >
  > - Provides a starting point for new software projects.
  > - Includes placeholders for project description and TODOs.
  > - Prevents using the template as a standalone project.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0043c11c17740499739a2b33ff18a8e304d0631e"><code>0043c11</code></a> <b>pre-commit:</b> ✨ Add pre-commit configuration</summary>

  > Adds a .pre-commit-config.yaml file to enable pre-commit hooks.
  >
  > - Enables commit message checking.
  > - Checks branch name validity.
  > - Validates author name and email format.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9393289bbe2fb644357c13d8233568560ce3a7f5"><code>9393289</code></a> <b>config:</b> ✨ Add commit-check and update pre-commit config</summary>

  > Adds commit-check.yml for commit message, branch, author and rebase validation. Updates .pre-commit-config.yaml to include merge base check.
  >
  > - Enforces conventional commit message format.
  > - Validates branch naming conventions.
  > - Checks author name and email format.
  > - Verifies branch is rebased onto target branch.

  </details>
- [`a6070c3`](https://github.com/gamerlogue/web/commit/a6070c3be1f978c76e58b09025c588f3c33fbf52) ✨ Added Laravel Boost dependency and documentation guidelines
- [`8490a0e`](https://github.com/gamerlogue/web/commit/8490a0ecc75bbcc6784d0c71800ea25d36dfe38e) Upgraded commit check
- [`ceace91`](https://github.com/gamerlogue/web/commit/ceace91e7b456b45a452bb378356c74e5bc18330) Updated message regex
- [`1b39117`](https://github.com/gamerlogue/web/commit/1b391173aa1bbad1bf83f63d3b4165a40212d502) Added imperative check
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a9ec5c56ef3f4deee43ae2884bdfe9249d857f0a"><code>a9ec5c5</code></a> <b>caddyfile:</b> Add health check</summary>

  > - Adds a `/health` endpoint for health checks

  </details>
- [`b9372bf`](https://github.com/gamerlogue/web/commit/b9372bff2d0557c86ec979f58c8eaeecff1f5077) **vite:** Add support for additional plugins in Vite configuration
- [`83fd60f`](https://github.com/gamerlogue/web/commit/83fd60f4d3142942a49ebe4b9cf8846ab6bb488b) **docker:** Enhance Dockerfile for improved build process and dependencies
- [`50fd056`](https://github.com/gamerlogue/web/commit/50fd0569b4439e36aa8f0b48213936e902d9075a) **pint:** Add concat_space rule for consistent spacing in JSON
- [`3d9c9e1`](https://github.com/gamerlogue/web/commit/3d9c9e1d9a6071cee46cc339ac395fa3cb4ca4f1) **compose:** Add default terminal emulator configuration
- [`d4a607c`](https://github.com/gamerlogue/web/commit/d4a607c5221cdd835347ee52dd5687b4bde5596c) **docker:** Set PHP_INI_SCAN_DIR environment variable in Dockerfile
- [`2834bb3`](https://github.com/gamerlogue/web/commit/2834bb3e70dd72c962faff2da8d5e9ddd5ce7586) **docker:** Refine COPY commands for TypeScript resources in Dockerfile
- [`b3be06c`](https://github.com/gamerlogue/web/commit/b3be06c138cc5bda2be0c934f7742d70c94a7fde) **docker:** Update configuration for Caddy and PHP, add healthcheck script
- <details><summary><a href="https://github.com/gamerlogue/web/commit/35b83789e185da83c9c336054fbab0005b52552b"><code>35b8378</code></a> <b>supervisor:</b> Add SSR process configuration and health check</summary>

  > Synced up to https://github.com/exaco/laravel-docktane/commit/c4a71f4de749aa500c53415f24f46a4d8d38c088#diff-a3e2257ad00123df6f958b2093aee20fdef2ac38d3812b10a52988fec6118fb6

  </details>
- [`bb1cc7a`](https://github.com/gamerlogue/web/commit/bb1cc7a9213a92bfd35657869ed64bd53f469fe3) Update .gitignore and exclude additional folders from indexing
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1c2dae907c4aa4d2299f3d5d706568645be4f8be"><code>1c2dae9</code></a> <b>docker:</b> 🚀 update Docker configuration for improved service management</summary>

  > - Refactored Docker Compose files to enhance service definitions and health checks.
  > - Changed user permissions to use `www-data` for better compatibility with the application.
  > - Added health checks for Octane and task services to ensure reliability.
  > - Updated environment variables for better configuration management.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/040bcec0522b825a8a1b666757d52881d146733f"><code>040bcec</code></a> <b>mcp:</b> 🚀 add MCP server configuration and JSON schema files</summary>

  > - Introduced mcp.json for MCP server command configuration.
  > - Added jsonSchemas.xml for JSON schema mappings related to composer.json.
  > - Created mcpServer.xml for MCP server settings including auto-start and port configuration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b8947fa99abbcab5a536e136ad81df3ae3ba6e8c"><code>b8947fa</code></a> <b>vite:</b> ✨ add font support for Instrument Sans in Vite configuration</summary>

  > - Integrated the bunny function to include the Instrument Sans font with specified weights.
  > - Enhances the project's typography options for better design consistency.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c62fd211941189273431b21d257be86701d8749f"><code>c62fd21</code></a> <b>igdb:</b> Update event cache lifetime handling and improve tests</summary>

  > - Set a fixed cache lifetime of 5 seconds for event responses.
  > - Adjusted tests to verify caching behavior for event requests.
  > - Enhanced clarity and maintainability of cache logic in IgdbProxyController.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/533b774eb002860b1f22509f9342345b03b552b1"><code>533b774</code></a> 🔓 open the IGDB proxy to every endpoint and to guests</summary>

  > The allowlist limited the proxy to games and events, and auth:sanctum locked out
  > guests; both are gone. The route pattern keeps {path} to a single endpoint name,
  > so it cannot be used to reach anything but an IGDB endpoint.
  >
  > Rate limiting was already written to fall back to the client IP when there is no
  > authenticated user — until now dead code, since the middleware rejected guests
  > first. It is the main branch from here: IGDB_PROXY_RATE_LIMIT requests per minute
  > per IP.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2bacb0bc55a8d19850ca5d6bdba7c0f2fdb3b54a"><code>2bacb0b</code></a> <b>queue:</b> ✨ run the queue under Horizon on Redis</summary>

  > Horizon was installed but the container ran queue:work, so the dashboard had
  > nothing to show and no snapshots were ever taken. compose.yaml and
  > compose.prod.yaml now extend a horizon service; the plain queue service stays
  > in the common file as a template.
  >
  > Three details that would have failed quietly:
  >
  > - healthcheck-horizon, not healthcheck-queue. The latter greps for the
  >   "queue:work" process while Horizon's supervisors run "horizon:work", so it
  >   would have restarted a healthy container.
  > - Redis moves from allkeys-lru to volatile-lru. It holds the queue, and
  >   eviction is not a connection failure: at maxmemory, pending jobs were
  >   disappearing with nothing to fall back to. Queue lists carry no TTL, so
  >   volatile-lru can only take cache entries that have one.
  > - stop_grace_period, because Docker's default 10s is below the supervisor's
  >   60s job timeout and tries is 1, so a long job would be killed rather than
  >   retried on every deploy.
  >
  > config/horizon.php keys supervisors by APP_ENV, and an environment missing from
  > that list is not an error: Horizon starts, supervises nothing and the queue
  > never drains. HorizonConfigurationTest fails if that mapping breaks.
  >
  > The failover connection stays in config/queue.php so that an environment still
  > set to it degrades to something that works, but it cannot be the default:
  > Horizon only watches the connection its supervisors name.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/01f688cbdb8e00ad253106c9987ebf24ab368a8b"><code>01f688c</code></a> <b>auth:</b> 🔒 bind the native authorization code with PKCE</summary>

  > The code handed to a native client was not tied to anything: whoever
  > intercepted the redirect on gamerlogue://auth/callback could redeem it, and any
  > app is free to register that scheme. issue() now requires a code_challenge with
  > S256 as the only accepted method — plain would bind the code to a value
  > readable in the very redirect it was stolen from — and exchange() requires the
  > verifier. The code is pulled from the cache before the challenge is checked, so
  > a wrong verifier burns it instead of leaving it up for another attempt.
  >
  > state is required too, and returned to the client untouched. That is a second
  > break for the client on top of PKCE, but it is the same coordinated release and
  > leaving it optional means the cross-app request forgery hole never closes.
  >
  > Tokens now expire after 30 days and carry explicit abilities instead of ['*'],
  > enforced in the two form requests. Note this covers reads as well: API Platform
  > routes every operation declared in `rules:` through them, GET included. Browser
  > sessions are unaffected, because Sanctum authenticates them with a
  > TransientToken that grants every ability — there is a test for that, since it
  > is how this would have locked the web out without anyone noticing.
  >
  > The redirect is built with Uri::withQuery(), which merges, so an allowlisted
  > HTTPS App Link that already carries a query keeps it.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6d1ed253eee61719d4360078fd474ab4afca3e22"><code>6d1ed25</code></a> <b>auth:</b> ✨ serve the Digital Asset Links statement</summary>

  > NATIVE_AUTH_REDIRECT_URIS already accepted an HTTPS redirect, so the App Link
  > that replaces the private-use scheme needed no backend change — only the part
  > that makes it verifiable. Package name and certificate fingerprints come from
  > the environment, so the client's values stay out of the repository and debug
  > and release can be configured per environment. Unset, the route 404s.
  >
  > The path is reachable in production: Caddy's (security) snippet rejects
  > dot-prefixed path segments but exempts /.well-known/* per RFC 8615. That
  > exemption is also why this works while /api/.well-known/genid/{id} does not.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9c35780297590cd5d0d084a9312a1f9af9a4b2d3"><code>9c35780</code></a> <b>security:</b> 🔒 trust only the application&#x27;s own hosts</summary>

  > localhost is on the list deliberately: the base image's HEALTHCHECK calls
  > http://localhost:${CADDY_HTTP_PORT}${HEALTHCHECK_PATH}. Caddy answers that path
  > itself today, but pointing HEALTHCHECK_PATH at Laravel's /up would otherwise
  > turn every healthcheck into a 403 and restart-loop the container.
  >
  > Trusted proxies were already restricted to the private ranges the Compose
  > network uses, so they are left alone.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0be30f7d5257228265d919597c1392dea672c1d0"><code>0be30f7</code></a> <b>observability:</b> 🔒 gate the Pulse dashboard</summary>

  > Pulse samples everything at 100% and had no gate at all, unlike Telescope,
  > Horizon and the log viewer. It now shares the same admin check, and the gate
  > test covers all four.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/94db776ac0232cd01e25dbd8eb41a1aac8751116"><code>94db776</code></a> <b>jsonSchemas:</b> ✨ add schema for dependabot configuration</summary>

  > - Introduced a new entry for dependabot-v2.json schema.
  > - This allows for better validation and integration of dependabot configuration files.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6b780d0c068d7e4e0a8bda85524cb1c9b7b04c0d"><code>6b780d0</code></a> <b>auth:</b> ✨ make the native authorize endpoint navigable</summary>

  > A CustomTabsIntent cannot drive a POST, so the client had no way to start the
  > flow: it opens a URL. GET /sanctum/token now mirrors OAuth 2.0's /authorize,
  > which is GET for the same reason.
  >
  > Dropping CSRF protection is acceptable here only because of what replaced it.
  > A cross-site trigger mints a code bound to a challenge whose verifier the
  > triggering page cannot pair, landing on an allowlisted redirect it cannot read,
  > and the request creates no token by itself — prefetchers and scanners produce
  > codes that expire unredeemed. Both are covered by tests. Should PKCE ever
  > become optional again, this endpoint stops being safe as a GET.
  >
  > An unauthenticated visitor is sent through OIDC and the intended URL carries
  > the parameters back, so the client does not reissue the request after login.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/af22a2e8e14a11c1eda0837f8444eeda0e43d90a"><code>af22a2e</code></a> <b>api:</b> ✨ scope the user collection to the caller</summary>

  > The client authenticates before it knows its own id, so it needs a way to ask
  > who it is. Rather than a parallel /api/me with its own serialisation, the
  > collection becomes that endpoint: OwnedResourcesExtension narrows it to the
  > caller, the way it already did for library entries, so GET /api/users returns
  > exactly one resource in the same JSON:API shape as everything else.
  >
  > The extension covers item operations too, so another user's resource is now a
  > 404 rather than a 403: the query is scoped before authorization runs, and the
  > response no longer reveals that the resource exists. Same shape as library
  > entries.
  >
  > The test that asserted the collection was closed now asserts something more
  > useful — four users exist and the caller sees one. That is what fails if the
  > extension ever stops being applied, where the old assertion would have passed
  > while the endpoint leaked the whole table.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/243e078dccedfe1acc5dc23df2be0565a52fe77c"><code>243e078</code></a> <b>auth:</b> ✨ authenticate the web client through the session cookie</summary>

  > The web client was expected to hold a bearer token because the session could
  > not reach the API: statefulApi() was never called, and the API Platform routes
  > carry neither StartSession nor EnsureFrontendRequestsAreStateful. Both are
  > needed — statefulApi() alone would not have covered those routes, which are not
  > part of the 'api' middleware group.
  >
  > CORS moves off the wildcard, which a browser rejects outright once credentials
  > are allowed, to explicit origins from the environment. The native authorize
  > endpoint needs no CORS entry: the browser navigates to it rather than fetching
  > it.
  >
  > Not yet verified end to end. That needs the web client on its own subdomain and
  > a real OIDC session; what is verified here is the middleware chain, which is
  > the part that was missing. SANCTUM_STATEFUL_DOMAINS, SESSION_DOMAIN and
  > CORS_ALLOWED_ORIGINS have to be filled in per environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/690e17ab472eb5a9dda445f40f3f19bf109a7338"><code>690e17a</code></a> <b>auth:</b> ✨ answer the App Link callback instead of 404ing</summary>

  > Nothing serves ${APP_URL}/auth/callback, so whenever Android does not intercept
  > the link — a desktop browser, an unverified install, a debug build before asset
  > links are published — the user meets a 404 holding an authorization code, at
  > the moment something has already gone wrong.
  >
  > The page processes nothing: the code in its URL is inert without the verifier
  > that never left the app.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/04fef0bde4eed345113c60eafabc51cb4a2ede7d"><code>04fef0b</code></a> <b>dependencies:</b> ✨ add `phpdocumentor&#x2F;type-resolver` to project dependencies</summary>

  > - Updated `composer.json` and `composer.lock` to include `phpdocumentor/type-resolver@^2.0`.
  > - Ensures compatibility with PHP 7.4+ and resolves types for better static analysis.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b05c9c314ba048216dcc201767d464a315229b9a"><code>b05c9c3</code></a> <b>dependencies:</b> ✨ add `reiarseni&#x2F;sanctum-refresh-token` to project dependencies</summary>

  > Refresh tokens for Sanctum with token families, rotation and reuse detection. Its
  > own suite passes on our stack — PHP 8.5.9, Laravel 13.30.1, Sanctum 4.3.3 — with 150
  > tests green and the two concurrency cases skipped, since row-level locking needs the
  > MySQL or PostgreSQL the package proves them on in CI.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/95836609b2e18e9c06fd5b3db86efcd15d2aa0fc"><code>9583660</code></a> <b>auth:</b> ✨ leave a trace when a refresh token is replayed</summary>

  > A replayed refresh token means someone holds a credential they should not. The
  > family is already gone by the time the event fires, so without these listeners the
  > only symptom is a user complaining they were logged out.
  >
  > The listeners stay synchronous because they read the client address off the request;
  > the mail is queued because the request has already been refused and should not wait
  > on SMTP. The alert is deduped for five minutes per user — a stolen token gets
  > replayed in a loop, not once — and is skipped entirely when no ADMIN_EMAIL is set.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5d845eeee5ed89c672c126fa2e6d1de306260e5c"><code>5d845ee</code></a> <b>auth:</b> ✨ hand the native client a rotating token pair</summary>

  > The 30-day personal access token becomes a 15-minute access token plus a refresh
  > token that rotates on every use. /token/exchange keeps its PKCE entry point and
  > answers with the pair; /token/refresh trades a refresh token for the next
  > generation of its family, unauthenticated because the refresh token is the
  > credential and the access token it replaces is expected to be dead.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/45e8d28c38986975b4a7321eae7802dcc4dfbbe3"><code>45e8d28</code></a> <b>auth:</b> ✨ end a native session with `&#x2F;token&#x2F;revoke`</summary>

  > Without it a client that signs out only forgets its tokens: the family stays live,
  > and a refresh token lifted off a dismissed device keeps working until the 180-day
  > cap — worse than the personal access token it replaced, whose 30 days at least did
  > not slide.
  >
  > Idempotent, and unauthenticated for the same reason as refresh. An unknown token
  > answers 204 too: a logout that can fail is a logout a client retries, and there is
  > nothing here worth telling an unauthenticated caller apart.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/908f01b4dcf2aff2e4446787aa3b66dc0be7418b"><code>908f01b</code></a> <b>auth:</b> ✨ answer the web client&#x27;s sign-out with a POST</summary>

  > The client was calling POST /logout, which did not exist. The only logout was the
  > OIDC package's GET /oidc/logout: right behaviour, wrong shape — a 302, and a
  > navigable one, so it can be triggered from any page the user visits.
  >
  > This one is 204, not navigable, and inside the web group where the CSRF middleware
  > sees it. Unauthenticated on purpose so it is idempotent: a client whose session
  > already died gets the same 204 rather than a redirect into the flow it is trying to
  > leave. GET /oidc/logout still works and is untouched.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9368834fb2655c8ba2fd9d0f930470871d8fc1a4"><code>9368834</code></a> <b>api:</b> ✨ add JSON:API filters and sorting to library entries</summary>

  > Equality filters on status and completion_status, a boolean filter on
  > owned, date filters on start_date/end_date, range filters on rating and
  > played_time, and a JSON:API `sort` over the dates, rating, played time
  > and timestamps.
  >
  > The range filters require an operator map: RangeFilter iterates the value
  > and indexes its operator table with each key, so a scalar or an unknown
  > operator surfaced as a 500. The status filters validate against their
  > enums instead of silently matching nothing.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/357e4970b94fe15f5f3d0ad56b0fe25a704bb9f4"><code>357e497</code></a> <b>api:</b> ✨ add public user profiles and review metadata</summary>

  > Users can read each other's profiles: email, email_verified_at and
  > picture_edit_url only reach the owner, and a private profile shows
  > others just id, nickname, name, picture and visibility, also when the
  > user is included as a relationship. The owner edits bio, banner,
  > platforms, visibility and a case-insensitive unique
  > nickname; users can be searched with filter[search].
  >
  > Library entries gain review_spoiler, a read-only review_updated_at that
  > follows the review text only, and the filter[user] and
  > filter[has_review] filters. A private library answers 403 with the
  > stable profile_private code.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/899a41072ae440373b41fc866e8556cda84cb96f"><code>899a410</code></a> <b>api:</b> ✨ add cached profile statistics</summary>

  > GET /api/users/{id}/stats summarises a library, optionally for one
  > year: counts by status and completion status, owned entries, played
  > time, average rating and histogram, per-platform totals, completions
  > and starts by year, and reviews. Results are cached per user and year
  > and invalidated by any library entry write.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/408279af78d7f8df8bb28afdd4ad18ad6c471fe5"><code>408279a</code></a> <b>api:</b> ✨ add custom game lists</summary>

  > Users curate lists of IGDB games, public or private and optionally
  > ranked, with full CRUD limited to the owner. List items keep a
  > position, appended at the end by default, and a whole list is reordered
  > transactionally through POST /api/lists/{id}/reorder. Lists are
  > filtered by owner and by contained game; someone else's private list
  > is a 404, and every list of a private profile is a 403 profile_private.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/bc122b1bb2b88307ecafd838c46c4e29f6ee5f1f"><code>bc122b1</code></a> <b>api:</b> ✨ add follows, blocks, reports and activities</summary>

  > Users follow each other through overtrue/laravel-follow and expose
  > followers_count, following_count, is_followed_by_me and follows_me,
  > computed in subqueries; followers and following are listed per user.
  > Blocking ends follows in both directions and hides each user from the
  > other everywhere, answering 403 with the stable user_blocked code.
  >
  > Reports of users, library entries and lists are stored for moderation,
  > one per author and subject.
  >
  > Library, list and follow writes record activities, folded within a
  > 30-minute window and removed with their subject. Writes sent with an
  > X-Library-Import batch header record a single library_imported
  > activity per batch instead. Profiles and the follow feed read them
  > back under the privacy and block rules.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/758f0d17eca5f6be45e23f471213821db5ed7c35"><code>758f0d1</code></a> <b>api:</b> ✨ add reactions, comments and notifications</summary>

  > Reviews and lists are liked through the `like` reaction of
  > qirolab/laravel-reactions; comments take any single emoji. Counters
  > (likes_count, liked_by_me, comments_count, replies_count, the reaction
  > summary) are computed in subqueries.
  >
  > Comments use beyondcode/laravel-comments: a reply is a comment on a
  > comment, to any depth, published at once with profanity masked by
  > blaspsoft/blasp against Italian and English dictionaries. The author
  > edits; the author or the thread's owner deletes, taking the whole
  > subtree along. Clearing a review or deleting content removes its
  > likes, comments and notifications. Hidden content, private profiles
  > and blocks are enforced on every interaction.
  >
  > Likes, comments, replies, reactions and follows notify their recipient
  > as database notifications, readable, markable and countable through
  > /api/notifications.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b24b75187322e729a233d0e338ffc60bae807fca"><code>b24b751</code></a> <b>api:</b> ✨ add account deletion and data export</summary>

  > DELETE /api/account removes the user for good with all their content,
  > the interactions hanging off it, tokens, refresh tokens and sessions;
  > reports about the user stay for moderation. GET /api/account/export
  > downloads their data as one JSON document.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8ebd0ffad52355b4e1907706cb439e8dc31fbec5"><code>8ebd0ff</code></a> ✨ count rating details or a rating alone as a review</summary>

  > An entry has a review when its text, its rating_details or its rating is
  > set. filter[has_review], review_required, reviews_count and the clearing of
  > likes and comments follow this rule. The reviewed activity requires text or
  > details: a rating alone is already reported by rated.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6faf994200f44df3e5110c0b710ab662668a932b"><code>6faf994</code></a> ✨ list a game&#x27;s reviews from every visible user</summary>

  > filter[game_id] with filter[has_review]=true, and neither filter[user] nor
  > current_user, returns the reviews of that game by every user the caller may
  > see: private profiles other than the caller's and blocks in either direction
  > are excluded. meta.average_rating carries the mean rating over the same
  > filters, added by a decorator of the JSON:API collection normalizer. sort
  > also accepts likes_count.

  </details>
- [`9f45e6f`](https://github.com/gamerlogue/web/commit/9f45e6f4de6010401271a3b03ba4b8cd50c5d218) ✨ Added Laravel Octane
- [`d2793ff`](https://github.com/gamerlogue/web/commit/d2793ffddd29f3b86fb7946a67d74a9a2f88fb2d) ✨ Added debug bar and log viewer
- [`869621b`](https://github.com/gamerlogue/web/commit/869621b6abffba1734c8172059f101b94074bdea) ✨ Added Laravel Pulse
- [`7bd66ad`](https://github.com/gamerlogue/web/commit/7bd66ad8b68f9f2683bae142c2b8c9fcf3a7d02a) ✨ Added watch to octane server start command
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7ba427e608a2520342892902f0e657c58ec604ce"><code>7ba427e</code></a> ✨ Added Vite to Sail container</summary>

  > The custom command adds a supervisor config to automatically start Vite

  </details>
- [`e51c6c7`](https://github.com/gamerlogue/web/commit/e51c6c7e9614bafd0a65a937f90dacf27b86929d) ✨ Use daily log file rotation
- [`4421dfc`](https://github.com/gamerlogue/web/commit/4421dfc33648c8e69c735b3d82a5cdcd1851994d) ✨ Added Sail venv
- [`7cf1736`](https://github.com/gamerlogue/web/commit/7cf17368334d4f02b458df95b1b1c1846ca92c0e) ✨ Added Telescope
- [`d8467c5`](https://github.com/gamerlogue/web/commit/d8467c5fc288c8a4d86db80e762beb59123fa9df) 🎉 Initial commit
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c1ea3710464bf0ad35b039e34e474fe2d95a2e51"><code>c1ea371</code></a> <b>base:</b> ✨ add initial README template</summary>

  > This commit introduces a basic README template.
  >
  > - Provides a starting point for new software projects.
  > - Includes placeholders for project description and TODOs.
  > - Prevents using the template as a standalone project.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ea1e888f1b423d49d32d93dc1a09dbaf1ff4a49b"><code>ea1e888</code></a> <b>pre-commit:</b> ✨ Add pre-commit configuration</summary>

  > Adds a .pre-commit-config.yaml file to enable pre-commit hooks.
  >
  > - Enables commit message checking.
  > - Checks branch name validity.
  > - Validates author name and email format.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/388aec5d16a221df2f1caaf2f992db5e0edda713"><code>388aec5</code></a> <b>config:</b> ✨ Add commit-check and update pre-commit config</summary>

  > Adds commit-check.yml for commit message, branch, author and rebase validation. Updates .pre-commit-config.yaml to include merge base check.
  >
  > - Enforces conventional commit message format.
  > - Validates branch naming conventions.
  > - Checks author name and email format.
  > - Verifies branch is rebased onto target branch.

  </details>
- [`933895f`](https://github.com/gamerlogue/web/commit/933895f5690d48f5775e15d627da5931638a4b0a) ✨ Added Laravel Boost dependency and documentation guidelines
- [`3fc90c4`](https://github.com/gamerlogue/web/commit/3fc90c41336877899a925bf47274d54ffa796e81) Upgraded commit check
- [`b60884c`](https://github.com/gamerlogue/web/commit/b60884c53304003acf2bcce80bf15a8e7210f199) Updated message regex
- [`fa7be18`](https://github.com/gamerlogue/web/commit/fa7be1837db6bc90ba08d8d0729e7d0e8c970fe0) Added imperative check
- [`89773ef`](https://github.com/gamerlogue/web/commit/89773ef482f593f913fec181c121e3b2ed17b50b) Optimized GitLab CI build job
- <details><summary><a href="https://github.com/gamerlogue/web/commit/529c1a26389bc369ea32fa29b9ac904e415bf438"><code>529c1a2</code></a> <b>caddyfile:</b> Add health check</summary>

  > - Adds a `/health` endpoint for health checks

  </details>
- [`24584bd`](https://github.com/gamerlogue/web/commit/24584bdf9b42a001828c5eacba4a017601ae47be) **vite:** Add support for additional plugins in Vite configuration
- [`ae2b43f`](https://github.com/gamerlogue/web/commit/ae2b43f3a799f7175cee41b515864f4657cc5917) **docker:** Enhance Dockerfile for improved build process and dependencies
- [`4b11689`](https://github.com/gamerlogue/web/commit/4b11689bc19d3bccc72223fd1a22de65428a9e9b) **pint:** Add concat_space rule for consistent spacing in JSON
- [`d56e12c`](https://github.com/gamerlogue/web/commit/d56e12c2f4a459605fb2f116e071715dc8f5fa9f) **compose:** Add default terminal emulator configuration
- [`117e235`](https://github.com/gamerlogue/web/commit/117e235df0ac1213f16f2edb10395d8de6337dad) **docker:** Set PHP_INI_SCAN_DIR environment variable in Dockerfile
- [`b794d75`](https://github.com/gamerlogue/web/commit/b794d75fd174126f60bf6f878e5e4565db1981b7) **docker:** Refine COPY commands for TypeScript resources in Dockerfile
- [`5756051`](https://github.com/gamerlogue/web/commit/57560510581c35f3c1b297a9e3a76cb4900fb3c8) **docker:** Update configuration for Caddy and PHP, add healthcheck script
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fe25d4d15e4ab938329d2510d22fe92d31145f1b"><code>fe25d4d</code></a> <b>supervisor:</b> Add SSR process configuration and health check</summary>

  > Synced up to https://github.com/exaco/laravel-docktane/commit/c4a71f4de749aa500c53415f24f46a4d8d38c088#diff-a3e2257ad00123df6f958b2093aee20fdef2ac38d3812b10a52988fec6118fb6

  </details>
- [`ef3a758`](https://github.com/gamerlogue/web/commit/ef3a7582bdc57930b9914aef03d1c31ad212e8d2) Update .gitignore and exclude additional folders from indexing
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f29bd50909ee4756dad8215c10ff883d6513633f"><code>f29bd50</code></a> <b>docker:</b> 🚀 update Docker configuration for improved service management</summary>

  > - Refactored Docker Compose files to enhance service definitions and health checks.
  > - Changed user permissions to use `www-data` for better compatibility with the application.
  > - Added health checks for Octane and task services to ensure reliability.
  > - Updated environment variables for better configuration management.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9eca8f415c04e9b2065922faad76e5d0cecf2fd9"><code>9eca8f4</code></a> <b>mcp:</b> 🚀 add MCP server configuration and JSON schema files</summary>

  > - Introduced mcp.json for MCP server command configuration.
  > - Added jsonSchemas.xml for JSON schema mappings related to composer.json.
  > - Created mcpServer.xml for MCP server settings including auto-start and port configuration.

  </details>
- [`e40dfc6`](https://github.com/gamerlogue/web/commit/e40dfc6b4d1e8f0e3994471b583e821f3a0710d8) Remove unnecessary link type
- <details><summary><a href="https://github.com/gamerlogue/web/commit/139067230229d16805cf5bd865acb8a9b59ab6b9"><code>1390672</code></a> Add type hints for $this in routes&#x2F;console.php (#6559)</summary>

  > * feat: add type hints for $this in routes/console.php
  >
  > * Update console.php
  >
  > * Update console.php
  >
  > ---------

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/85ce63c577c2f1e7913a1f86e4219a135d89ba6a"><code>85ce63c</code></a> <b>vite:</b> ✨ add font support for Instrument Sans in Vite configuration</summary>

  > - Integrated the bunny function to include the Instrument Sans font with specified weights.
  > - Enhances the project's typography options for better design consistency.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1822bf5203118819e0b70c53cc349a9940c3c58c"><code>1822bf5</code></a> ✨ ship the Caddy and FrankenPHP worker config in the image</summary>

  > CADDY_PHP_SERVER_OPTIONS, CADDY_SERVER_EXTRA_DIRECTIVES and
  > FRANKENPHP_CONFIG lived in compose.common.yaml, so an image run outside
  > Compose had no worker block and could not start. The first two move to
  > deployment/php-server.caddyfile and deployment/site.caddyfile, imported
  > through ENV in the Dockerfile; FRANKENPHP_CONFIG becomes the one-line
  > `worker <file>` form, since a Dockerfile ENV cannot hold newlines. The
  > dev script still overrides it with the `watch` directives.
  >
  > Verified on the base image: the config adapts and requests reach the
  > worker.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/71f90e2fd81868423afe0e8f6c44d18779f1115a"><code>71f90e2</code></a> ✨ start Octane by default in the prod image</summary>

  > The prod stage had no CMD, so an orchestrator running the image as-is
  > (Kubernetes) got the base image's plain `frankenphp run` instead of
  > Octane. The CMD matches compose.prod.yaml.
  >
  > Known issue, documented in the Dockerfile: a numeric OCTANE_WORKERS makes
  > Octane emit `num N` under `frankenphp {}`, which the image Caddyfile
  > rejects, so only `auto` works and it counts the host's CPUs.
  >
  > Verified with the base image and the repository mounted: Octane starts
  > and /up answers 200.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d677d37f1f497997d9c376823092f348314f7387"><code>d677d37</code></a> <b>ci:</b> ✨ add GitLab CI schema configuration</summary>

  > - Introduced a new entry for GitLab CI in jsonSchemas.xml to support CI configuration.
  > - Added conventionalCommit.xml and discord.xml for project settings.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e777e82b2f1804968d1d9942071cea80766f515d"><code>e777e82</code></a> ✨ write the access log to stdout in production</summary>

  > The access log goes to the container output only in the prod stage (CADDY_ACCESS_LOG_OUTPUT) and is discarded on stdout elsewhere. A global logger keeps the access.log file in every stage, and frankenphp.log no longer duplicates the access entries.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d78b201b42b695736c4c0722cd5b56884ee640e7"><code>d78b201</code></a> ✨ set the chart probes in the template</summary>

  > The liveness and readiness probes move here from the values file
  > sitekit creates for each new site: they depend on the image, which
  > the template owns. Same probes as before: liveness on Caddy's port,
  > readiness on /healthcheck, answered by Caddy without the database.
  >
  > Existing sites keep the probes in their own values files, which win.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cab1a7fc6e2d9ad6567db64af58309710ffd0a2d"><code>cab1a7f</code></a> ✨ set the files mount path in the template</summary>

  > deployment.mountPath moves here from the APP_FILES_DIR variable, which
  > sitekit wrote in each site's values file. Existing sites keep theirs.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f77041864e6e177f3ed74f74693a97e0a8227330"><code>f770418</code></a> ✨ register native clients&#x27; FCM device tokens</summary>

  > POST /api/device-tokens upserts by token, so a token re-registered by another user moves to them. Tokens go with the account through the foreign key cascade.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/74f85f7b042913106c7fe263e2a8f8da67288955"><code>74f85f7</code></a> ✨ push social notifications through FCM</summary>

  > SocialNotification adds the FCM channel for recipients with a device, queued while the database row stays synchronous. Tokens FCM reports as unregistered or invalid are deleted.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a5c625571587d285ff45fe6357eed40bc0630d7c"><code>a5c6255</code></a> ✨ push new-follower notifications on their own Android channel</summary>

  > The channel follows the client's NotificationChannel.ofNotificationType; every type without a channel of its own stays on social.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/57fa7accc88571c2aa8028a16c3cd1a933d475f8"><code>57fa7ac</code></a> ✨ notify the users a new comment mentions</summary>

  > Every distinct @nickname among the first ten of a comment, case-insensitive, naming a user who can read the thread. Whoever already gets the comment's own notification gets only that one; edits notify nobody.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c8b78fe09caf8eb0172fee23b6ffd2ed72177798"><code>c8b78fe</code></a> ✨ notify followers of what followed users complete, review or list</summary>

  > One followed_user_activity per follower who can see the subject, sent from a queued job that looks the game name up on IGDB. Deleting the activity deletes them.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c187674844bffc92977c46caed9216d975732982"><code>c187674</code></a> ✨ notify users of the badges they earn</summary>

  > Sent with the badge_earned activity, to the user who earned it and with that user as actor, pushed on the badges channel. Nothing records that activity yet.

  </details>

### 🐛 Bug Fixes

- [`b66be28`](https://github.com/gamerlogue/web/commit/b66be283d404f6f06a722927d683bd79814945fb) Fixed comment in session class.
- [`285cdcc`](https://github.com/gamerlogue/web/commit/285cdcc8f2f93233bc3c33f9b551b4bfc04e7f42) Fixed bug when deleting eloquent models.
- [`5ddab2b`](https://github.com/gamerlogue/web/commit/5ddab2bf9666d46c1b2dd034275041d3c29d827c) Fixed typo in form class.
- [`dae7912`](https://github.com/gamerlogue/web/commit/dae7912c40209d49fe103e81b8821a04bc669fd0) Fixed request uri determination bug.
- [`4669911`](https://github.com/gamerlogue/web/commit/4669911d618daf7f1c3742e509838cba2d3c01ee) Fixed bug in html link methods.
- [`3038ed7`](https://github.com/gamerlogue/web/commit/3038ed7a49a640e08b0ce1fb3ea7134898199a7f) Fix view handling to properly catch exceptions when rendering.
- [`73d8e2f`](https://github.com/gamerlogue/web/commit/73d8e2f2fab62207c9264f2f3d09cb6bcbfc88f0) Fixed arr::get argument order.
- [`bc8fa35`](https://github.com/gamerlogue/web/commit/bc8fa3570e6854cff7283940a8181ceb6781aaf4) Fixed bug in route parameterizer.
- [`8f8c5f6`](https://github.com/gamerlogue/web/commit/8f8c5f6dd4ff52f78191211ca00d79d0049b80e0) Fix bug in route loader that caused exception to be thrown when 404 should have been shown.
- [`c751844`](https://github.com/gamerlogue/web/commit/c751844aab1b53e66fa43a7bf5a275f4296a6725) Fixed belongs_to eager loading bug when parent does not exist.
- [`8a4db9f`](https://github.com/gamerlogue/web/commit/8a4db9ff2dc8ffce7b14a3465248480bc12fcdb3) Fixed attribute setting bug in hydrator.
- [`4f361a1`](https://github.com/gamerlogue/web/commit/4f361a1b379ea883b750909a4ecc366f8595bb94) Fixed messed up cache driver commit.
- [`fcd6cd7`](https://github.com/gamerlogue/web/commit/fcd6cd77efe26f94d4a9c42173d60adcc524c0ed) Fixed messed up commit of file cache driver.
- [`9b8942f`](https://github.com/gamerlogue/web/commit/9b8942fa1d54cc31d5503e5e40f8518a17edbf3e) Fixed equality check in validator.
- [`78301fb`](https://github.com/gamerlogue/web/commit/78301fb8c7ee10a3bb0d67ac911c56ba3d42ec96) Fixed bugs in validation classes.
- [`2289570`](https://github.com/gamerlogue/web/commit/2289570c9591d661eeb8a0d64a5f0b2cce3ca12e) Fixed exception message in validation/rule.
- [`fef1809`](https://github.com/gamerlogue/web/commit/fef1809982e2b6fb726168f25192f9a084f44748) Fix syntax error in upload_of... add types to file_wrong_type lang message.
- [`ad82434`](https://github.com/gamerlogue/web/commit/ad824341a6ff882b1d85eba849894428d1bdb54d) Fixed bug in input class causing entire array to not be returned.
- [`95528ad`](https://github.com/gamerlogue/web/commit/95528adab5e4f409d20f81c935e8ffdfee263f8d) Fix syntax error in error class.
- [`c75f298`](https://github.com/gamerlogue/web/commit/c75f298c34a281e0a30959ceafcf515271ce945d) Fix typo in error class.
- [`7e15278`](https://github.com/gamerlogue/web/commit/7e15278f7d3c966ac69929b5ae242bc7fb7335d9) Fixing typo in validator documentation.
- [`d73dd3e`](https://github.com/gamerlogue/web/commit/d73dd3eb9b731deebfad83c2396452cad5555786) Fixed readme.
- [`40b8365`](https://github.com/gamerlogue/web/commit/40b836511f64484ba5ced7347755d8716a2061f1) Fixed broken documentation link on welcome page.
- [`55a201a`](https://github.com/gamerlogue/web/commit/55a201ac6170cba61ede7a2dbd616416c95a94a5) Fixed bug in route finder when looking for routes in route directory.
- [`3dfc8d4`](https://github.com/gamerlogue/web/commit/3dfc8d4aaa9ed123c963eece54fc5d20d7cee5db) Fixed routing issue.
- [`8085438`](https://github.com/gamerlogue/web/commit/808543844d473bd63a252fad142408d9ec4bb290) Fix typo in validator class comment.
- [`72658bd`](https://github.com/gamerlogue/web/commit/72658bd09a7ad91387020dde529081e8a7b03adb) Fixed bug in validator->image rule.
- [`e9a4332`](https://github.com/gamerlogue/web/commit/e9a43326a7d071f03e6e8f986bb1e9f9dcc8557c) Fix bug in validator class required check.
- [`7e439ab`](https://github.com/gamerlogue/web/commit/7e439ab52efb54621ca7fade65480f6d7b4a5310) Fixed bug in config has method.
- [`4609528`](https://github.com/gamerlogue/web/commit/4609528d9319fb47e99ab257e7bb4cd09f329306) Fixed bug in session and cache factories.
- [`2bb7125`](https://github.com/gamerlogue/web/commit/2bb7125127d76f95a8938dc51343fd35cbf2aea6) Fixed routing bug.
- [`a7e39e9`](https://github.com/gamerlogue/web/commit/a7e39e9cf011a99b7652989f9dc8e0b0d8a404b0) Fixed routing bug when using nested route directories.
- [`3f6aa54`](https://github.com/gamerlogue/web/commit/3f6aa5448713c928aa6ead0fa9c9ad9a60c3139e) Fixed router conflicts.
- [`e3b6328`](https://github.com/gamerlogue/web/commit/e3b632839423507feeab5f45c2ed27e825190c5c) Fix connector conflict.
- [`ec3e059`](https://github.com/gamerlogue/web/commit/ec3e0598366b996b277f1879a7403d78acad68a6) Fixed bug in view class module loading and made loader properties public.
- [`aa1e20b`](https://github.com/gamerlogue/web/commit/aa1e20bcefa88e18e971cb37252750f07c678923) Fixed bug in auto-loader that caused module classes to not load correctly.
- [`e4bc62d`](https://github.com/gamerlogue/web/commit/e4bc62da730067f71176784114b8a828f888470e) Fix bug in route loader causing requests for specific formats to not be returned correctly.
- [`3ac2287`](https://github.com/gamerlogue/web/commit/3ac228732954ad2e7a09e41f8f6534b70a5c5f84) Fixing API comments.
- [`47d2207`](https://github.com/gamerlogue/web/commit/47d2207c670b68a8096deccbbe68f7631acd19c0) Fixing API comments.
- [`23e100a`](https://github.com/gamerlogue/web/commit/23e100aa80e65721f9e02db1cd48a961bc52bc47) Fix comment on arr::set.
- [`766e54a`](https://github.com/gamerlogue/web/commit/766e54aa2d605f2eafd53017536c22386e51b470) Fixed changelog
- [`c4e2828`](https://github.com/gamerlogue/web/commit/c4e28286058a614727b2231ef415b7231628628a) Fixed changelog.
- [`5895f36`](https://github.com/gamerlogue/web/commit/5895f36bbba10550522882965005a10298a13bed) Fixed view namespace bug.
- [`d943f8b`](https://github.com/gamerlogue/web/commit/d943f8b7492f577ca947ce5aab5b1008e7d0e2b4) Fix view namespace.
- [`0a5c442`](https://github.com/gamerlogue/web/commit/0a5c4422954b410ab35a25bbc7a6073f34616c85) Fixed vie errors.
- [`03b58e8`](https://github.com/gamerlogue/web/commit/03b58e8ec6ff19ebc9d072a26e7b8be3f53dd9ef) Fixed belongs_to eager loading bug.
- [`4569ebe`](https://github.com/gamerlogue/web/commit/4569ebec46866820c387c0c534a43172b7472c17) Fixed merge conflict.
- [`a940fc4`](https://github.com/gamerlogue/web/commit/a940fc4867306c4496be6994b004fe77e3684af3) Fixed wrapper method on mysql query driver.
- [`39c9211`](https://github.com/gamerlogue/web/commit/39c9211f288c7988915969698edf91b783a49416) Fixing comment in benchmark class.
- [`0a3208e`](https://github.com/gamerlogue/web/commit/0a3208e0f2e53d401c80cb1e9358beefda70b8ca) Fix session option extract bug.
- [`a9f6fbd`](https://github.com/gamerlogue/web/commit/a9f6fbd75afd78414dc2812b8053dae3b9edfe96) Fixed session extraction bug.
- [`f580ef7`](https://github.com/gamerlogue/web/commit/f580ef7f71e28c4a8cf2bdcefe38abb8db2a8803) Fixed merge conflict.
- [`99adf09`](https://github.com/gamerlogue/web/commit/99adf09ac7dbfb7b091fcb13338fb78030ba3a01) Fixed conflicts.
- [`cda4567`](https://github.com/gamerlogue/web/commit/cda456744667a2d69b1e6f7254c6f1603b61b718) Fixed bug that prevented view exception from being shown.
- [`46dd65f`](https://github.com/gamerlogue/web/commit/46dd65fa747d29cbdaf668db412772bb1c1c1356) Fixed merge conflicts.
- [`3fbb857`](https://github.com/gamerlogue/web/commit/3fbb85768ad430f0cf453d6e7b176af34be6f69b) Fix typo in change log.
- [`e0a9f57`](https://github.com/gamerlogue/web/commit/e0a9f57515d0e5b61eec2b0e120ffb21ca81d744) Fixed database namespacing.
- [`195f786`](https://github.com/gamerlogue/web/commit/195f7862cbc4c3dca5def750368568056d850ca9) Fixed a few controller delegation issues.
- [`d65ddb5`](https://github.com/gamerlogue/web/commit/d65ddb53a842b83810f7e728107b8f1aa5d3f03a) Fix bug in query class.
- [`429c9ce`](https://github.com/gamerlogue/web/commit/429c9cee84caea9df3c2a02471a507ee8c09294a) Fix session related bugs.
- [`ab02e46`](https://github.com/gamerlogue/web/commit/ab02e4649093ff69725ff4f5f46deb34dba17f5a) Fixed module composer view when using named views.
- [`0e6859f`](https://github.com/gamerlogue/web/commit/0e6859fb45878a2247b180d102bae5aa9b0bb05e) Fixed merge conflict.
- [`86da3af`](https://github.com/gamerlogue/web/commit/86da3af7a1be037b2e449ebaaaa6857bd3d00318) Fixed merge conflicts and merged master.
- [`c2f5e7e`](https://github.com/gamerlogue/web/commit/c2f5e7eeb5c9b6ab51b466cb1eacd5cad7fe99d3) Fix config calls in error views.
- [`174d50c`](https://github.com/gamerlogue/web/commit/174d50c044dea95dd9c08d307f2fee0bd1a6bfec) Fixed bug in form class that prevented name attribute from being set properly on input elements.
- [`f31bf1c`](https://github.com/gamerlogue/web/commit/f31bf1c8e4cccf913421a0c0087018951222a2d3) Fixed merge conflicts.
- [`68b0d29`](https://github.com/gamerlogue/web/commit/68b0d291100e6a07c8a290bd7970613df5a97fbd) Fix namespacing issue.
- [`8688270`](https://github.com/gamerlogue/web/commit/8688270f2233e3dc59d9cd6359028d151f67b380) Fixed database bugs.
- [`6904cf1`](https://github.com/gamerlogue/web/commit/6904cf119d359f51c12da326e5dc0f2b046cae43) Fixed bug in eloquent causing ids to overlap.
- [`5196d01`](https://github.com/gamerlogue/web/commit/5196d015b8009ec6f21efa254cf75d7185766935) Fixed merge conflicts.
- [`220c359`](https://github.com/gamerlogue/web/commit/220c359eee5d73b279fe540e2148c7618ad881ac) Fixed changes.
- [`c3f5abc`](https://github.com/gamerlogue/web/commit/c3f5abc37a9b55ac1d81e8be12d2a98d37a0820d) Fixed bug in database manager.
- [`c502f8d`](https://github.com/gamerlogue/web/commit/c502f8da1a6a3086f9964be4ba35f16f4f6de8f3) Fixed merge conflicts.
- [`48715bb`](https://github.com/gamerlogue/web/commit/48715bbb7d70f5c1bfeb07972d8d4b93603e1714) Fixed bug in view composers. changed crypter alias.
- [`f50a492`](https://github.com/gamerlogue/web/commit/f50a4925104815949449aa566d4a2e301c36751b) Fixed bug in ioc container singleton resolution.
- [`4edcc32`](https://github.com/gamerlogue/web/commit/4edcc321aa5c763d53f45ca8d3175a4c5cc72790) Fixed bug in route to controller delegation.
- [`8c9bd12`](https://github.com/gamerlogue/web/commit/8c9bd12003c2880018d3bde53314b3c7e1d6dfda) Fixed old uri ioc container reference.
- [`08ea1db`](https://github.com/gamerlogue/web/commit/08ea1dbbc8d2f7dc41fdcd5e1fcae582dd557643) Fixed bug in request uri method.
- [`17ea093`](https://github.com/gamerlogue/web/commit/17ea09364d5b9192fe0b9015ac328a4bb0e79325) Fixed str test cases and str::limit function.
- [`4a5e7c6`](https://github.com/gamerlogue/web/commit/4a5e7c6f61816256b7f528180c92b610ee50b913) Fixed controller routing bug.
- [`b40e69c`](https://github.com/gamerlogue/web/commit/b40e69c47a63619004b3d675be68f6c6cc9b4998) Fixed controller routing bug.
- [`a7e98e8`](https://github.com/gamerlogue/web/commit/a7e98e8e9a3f5999f49099c456b5b9b33da5a076) Fixing bugs and refactoring.
- [`4553862`](https://github.com/gamerlogue/web/commit/45538620dae686d57882579595c4307974158552) Fixing bugs and refactoring.
- [`e985057`](https://github.com/gamerlogue/web/commit/e985057b4cacc62f72d525987437a5f1f4f11ced) Fixed connector definition in container.
- [`ba29a0b`](https://github.com/gamerlogue/web/commit/ba29a0bd382ba8908f495d488704641d48b169fc) Fix request tests.
- [`cb02798`](https://github.com/gamerlogue/web/commit/cb027980ae229169f427c3a070bcd54c96e8fda4) Fix array tests.
- [`0a2587d`](https://github.com/gamerlogue/web/commit/0a2587d2913c9d590209190e059e2a1eb44b30bd) Fixed bug in redis class.
- [`6e916ea`](https://github.com/gamerlogue/web/commit/6e916ea69d854896489ba8202cf03ec597407e68) Fix bug in routing that prevented comma delimited routes.
- [`b6d7df4`](https://github.com/gamerlogue/web/commit/b6d7df4510252b44c4814f12d62537218f640d2c) Fix cache manager alias.
- [`e44eec1`](https://github.com/gamerlogue/web/commit/e44eec106d4ddb1f10c28bc26f9dbd5ccd817f6d) Fixed old input persistence bug.
- [`a2aebdb`](https://github.com/gamerlogue/web/commit/a2aebdb03f98f31077925112c2c51f561563c2e6) Fix routing provides bug.
- [`36ff7b8`](https://github.com/gamerlogue/web/commit/36ff7b81aa351b336c1c80083587debca0069583) Fix bug in listing method.
- [`527340d`](https://github.com/gamerlogue/web/commit/527340d793f2ac0de3d61938770b9407b61ec8c7) Fix bug in request uri parsing.
- [`895d876`](https://github.com/gamerlogue/web/commit/895d8764630e16cac8e65f68c674e081ff7dfd37) Fixed bugs found when unit testing.
- [`23fcf35`](https://github.com/gamerlogue/web/commit/23fcf358045cca2c022e9ff612d314e26bfb8128) Fixed validator bug.
- [`3b8f586`](https://github.com/gamerlogue/web/commit/3b8f5865a5eb789ec4723140a27b2878e8b6ed6c) Fix comment in validator.
- [`5e4e625`](https://github.com/gamerlogue/web/commit/5e4e625d68dd59d1f1289a76a1abf2cc495f6e53) Fixed merge conflicts.
- [`16a6219`](https://github.com/gamerlogue/web/commit/16a62193fcbdac7394dcde49d567dbde592731b2) Fix function namespacing.
- [`4bfcb06`](https://github.com/gamerlogue/web/commit/4bfcb064bfc8468d0f47fc270838d1ae7a4c5872) Fix controller comment.
- [`6f60c44`](https://github.com/gamerlogue/web/commit/6f60c44804452e74b08ae83a9faec6abe6faed69) Fix default controller method.
- [`b9e9183`](https://github.com/gamerlogue/web/commit/b9e91835ec9d8d66e94452c676a632ac9887a6c7) Fix bug in session class.
- [`dcc334b`](https://github.com/gamerlogue/web/commit/dcc334b6175553927ad30f8e5b38cacd4a14c977) Fixed bug in controller filter method.
- [`270e0d4`](https://github.com/gamerlogue/web/commit/270e0d499423dd43b3781507b88158e95ec93ff5) Fixed a few bugs.
- [`0e8432e`](https://github.com/gamerlogue/web/commit/0e8432e373f6d28f2ddc6de7ab79836c674db6b8) Fixed messages namespace in view.
- [`32684fa`](https://github.com/gamerlogue/web/commit/32684fa12e28645295c106c2a28c16f8b0ec1742) Fixed router ioc bug.
- [`a5aaf33`](https://github.com/gamerlogue/web/commit/a5aaf33fe5c878d32af4ca7ce294242c08e527ed) Fix error detail view.
- [`a664113`](https://github.com/gamerlogue/web/commit/a6641130c4f502420dc20cb7324182a2b56e7fa0) Fixing bugs in validator and file classes.
- [`d3f9391`](https://github.com/gamerlogue/web/commit/d3f9391981ea56aa716f77fecff801a150c295e3) Fixing some bugs.
- [`a675b05`](https://github.com/gamerlogue/web/commit/a675b05237f8b5ef8f7b5741c7ca77f76dfe941b) Fixing some commits i accidently overwrote.
- [`783101c`](https://github.com/gamerlogue/web/commit/783101cc7a478cbbf7da4cd0ef9f88c91fa1c605) Fixed bug in autoloader.
- [`3ccad7d`](https://github.com/gamerlogue/web/commit/3ccad7de604ae39fa8e78189455b5f08632c753c) Fix bug in link_to_asset method.
- [`f575efb`](https://github.com/gamerlogue/web/commit/f575efbf2d6c75f77d9d496d59ee44efbc16b36e) Fixing readme typos.
- [`bf01e93`](https://github.com/gamerlogue/web/commit/bf01e932c3a973fb6f6e1739f9a527f17dbdf066) Fixed variable typo in routing filter class.
- [`472e377`](https://github.com/gamerlogue/web/commit/472e377b02a580f81106b7a96f9e4cee3195a819) Fix the validation of required file uploads.
- [`09b4471`](https://github.com/gamerlogue/web/commit/09b4471a5dbd67e29bf2de6276bcfd841c23e135) Fix file validation check in validator.
- [`cb306c9`](https://github.com/gamerlogue/web/commit/cb306c9091eb0f346703473ad3d5a297a5fa8592) Fixing a few bugs in the form class.
- [`1c97dcc`](https://github.com/gamerlogue/web/commit/1c97dccaefe58d73a5a741f590d41ffd1c54c836) Fix filter parameter merging bug and update changelog.
- [`4ec3f39`](https://github.com/gamerlogue/web/commit/4ec3f397cf0b0373a5d66fa06bb77b93656a5a1f) Fixed pagination bug affecting postgres.
- [`ddd6d44`](https://github.com/gamerlogue/web/commit/ddd6d4478239aa05e1a2b5cccbe87a3e0a91a407) Fix bug affecting using db::raw with eloquent.
- [`264cc51`](https://github.com/gamerlogue/web/commit/264cc512941efe39f63d3cb8cbe142e17e8dbb06) Fixed bug in auth cookie removal.
- [`339d3a8`](https://github.com/gamerlogue/web/commit/339d3a84074b824b59f04e9c84b094c4e5f048e3) Fixed version number.
- [`c47a30f`](https://github.com/gamerlogue/web/commit/c47a30fca631de586f2862f4f5d10a88aca18f21) Fix bug in router parameter parsing.
- [`f53ebbf`](https://github.com/gamerlogue/web/commit/f53ebbf6727c98accaa677e91d35b502e76b39c8) Fix glob error in bundle class.
- [`2bbb9e5`](https://github.com/gamerlogue/web/commit/2bbb9e55e9928f7fabe4c1881216b27b89691543) Fix bug in bundle assets method.
- [`9e690c8`](https://github.com/gamerlogue/web/commit/9e690c8af6ad14617f81850a898cfc21c590a30f) Fix problem with bundle assets.
- [`04f2138`](https://github.com/gamerlogue/web/commit/04f21380ca2304a2aa95f8dfcd76675b83d58437) Fix glob problem in migration resolver.
- [`471b7aa`](https://github.com/gamerlogue/web/commit/471b7aaa814dcd406a280e0bcba2df7c10dc435c) Fix glob problem in file cache driver.
- [`d8597e2`](https://github.com/gamerlogue/web/commit/d8597e2095292a3855caee87c9a11f5fbc7bbb34) Fix comment in bundler.
- [`d95c371`](https://github.com/gamerlogue/web/commit/d95c371867e4a47d2e6efc6f8fdcfb8602fe1c17) Fix bug in controller filters.
- [`73c09f2`](https://github.com/gamerlogue/web/commit/73c09f2f29057b78fcb38385fc20d083ad29b757) Fixed bug in router.
- [`9bcbe6a`](https://github.com/gamerlogue/web/commit/9bcbe6a357a0f33aabdd7d529c447fe86ae6b04a) Fix bug in route handles method.
- [`3569edb`](https://github.com/gamerlogue/web/commit/3569edbb0b5b047241653c7239136a34b9470b0a) Fixed comment in grammar.
- [`2750291`](https://github.com/gamerlogue/web/commit/27502918fb55e117a01114e794644772eda36274) Fix bundle dependency error possibility. fix WSOD in view rendering.
- [`ec2fc6d`](https://github.com/gamerlogue/web/commit/ec2fc6ddd05adfd92a7b0fd51bff4daa14309ee5) Fixed infinite loop when removing magic.
- [`62571b3`](https://github.com/gamerlogue/web/commit/62571b3971d57de74d4708701f2e67c9c211e995) Fix some problems on the CLI and allow specification of environment and database.
- [`6d6fc1b`](https://github.com/gamerlogue/web/commit/6d6fc1b13e194036389a6e8c54e1316a506a8c15) Fix bug in backreference.
- [`3a3c5ba`](https://github.com/gamerlogue/web/commit/3a3c5ba561833cc5ca0ca8b09593ab378d07b5ef) Fix typo.
- [`29fc846`](https://github.com/gamerlogue/web/commit/29fc846f3991bb092184dafdaa87a52aba78764d) Fix comment
- [`6b1b0ee`](https://github.com/gamerlogue/web/commit/6b1b0ee5e19707d9d7a3e3791947709fcbe35941) Fix bundle publishing problem.
- [`a351e91`](https://github.com/gamerlogue/web/commit/a351e91aef08fef33c2b9294ea103050ceae7f81) Fix testing of the core.
- [`c44b626`](https://github.com/gamerlogue/web/commit/c44b6264dd12e5e0835384748ad66e8661939924) Fix autoloading system path issue.
- [`c81be6d`](https://github.com/gamerlogue/web/commit/c81be6d27bbcdd1a1986e84343c9a2192270e3a6) Fix config class bug.
- [`429ac00`](https://github.com/gamerlogue/web/commit/429ac00ff53dc5cc7d645258c2e40504129ec793) Fixed misleading comment.
- [`75abe22`](https://github.com/gamerlogue/web/commit/75abe2237bc286c247e2fe86e0b15d25389208bc) Fix migrator.
- [`ea13ddf`](https://github.com/gamerlogue/web/commit/ea13ddfb7f29d2a1f29b1abf92874b0e001e9679) Fix aggregate selecting bug.
- [`3636321`](https://github.com/gamerlogue/web/commit/363632165cf5155b2900eec768a4f7391072ec1d) Fixed casing issues in inflection.
- [`fd446ae`](https://github.com/gamerlogue/web/commit/fd446aec624ff607e07c3d0f3aa38fbdfc40dd41) Fix bug in validation unique method.
- [`bd532ee`](https://github.com/gamerlogue/web/commit/bd532ee4b0ad55911124a2ecb7397471511fa123) Fix cache::remember method with closures.
- [`f3a7849`](https://github.com/gamerlogue/web/commit/f3a78490bd5e1b85e731a159ad5c57dd928fa880) Fix sorting of migrations.
- [`cf33cae`](https://github.com/gamerlogue/web/commit/cf33cae228a199ae304aada1584c00da7ecad86a) Fix github provider.
- [`2504f86`](https://github.com/gamerlogue/web/commit/2504f8693fbe3bb69b75cdc6033958cb15cb9ba5) Fix cookie bug.
- [`10ee41f`](https://github.com/gamerlogue/web/commit/10ee41f3b3306d5b29c05937f9b2086b538269d2) Fix bug in fluent class.
- [`d681f49`](https://github.com/gamerlogue/web/commit/d681f4992048af2ba16c7ec28f3438f36515fdde) Fix 404 route issue.
- [`b1f12b1`](https://github.com/gamerlogue/web/commit/b1f12b19bf5f5492ac85e93cb9647a8d8452032c) Fix comment on file::rmdir.
- [`ab5e861`](https://github.com/gamerlogue/web/commit/ab5e8615c5b366aa5d4db7730306df34bcccda20) Fixing segments bug.
- [`3dab550`](https://github.com/gamerlogue/web/commit/3dab5506814dae8739f0e7e38acbf6a968d22ffb) Fixing route bundle determination.
- [`e89082e`](https://github.com/gamerlogue/web/commit/e89082e3bae8034dc3a3204040edcb4692ed884f) Fix possible problem in provider zip extraction.
- [`cd17761`](https://github.com/gamerlogue/web/commit/cd17761f7220d193ec265a436b396ae5a1a640bc) Fix distinct problems in paginator.
- [`bbae90a`](https://github.com/gamerlogue/web/commit/bbae90adad1d22353bf59ae3a7163bc84184a173) Fix pagination comment.
- [`37c06a5`](https://github.com/gamerlogue/web/commit/37c06a50069d73833cf1a443b1a6fe13ad24d6b5) Fix bundle handles greediness.
- [`98ea0c0`](https://github.com/gamerlogue/web/commit/98ea0c0e6fe81ea4eee6af3af0142cace862d258) Fix bug in url::to.
- [`a0379ea`](https://github.com/gamerlogue/web/commit/a0379ea48d361a02deb9bb1a259a1341f2e192e0) Fix comment about bundle caching.
- [`5e59a72`](https://github.com/gamerlogue/web/commit/5e59a72b5b8629ea78b961e96bc57e42290007e2) Fix bug in paginator.
- [`874f02c`](https://github.com/gamerlogue/web/commit/874f02c7590e9e299515fc4157cef364b5cae111) Fix comment typo.
- [`597feed`](https://github.com/gamerlogue/web/commit/597feed4a740ba54cd97c0e48922886ccf1f4516) Fix bug with root routing.
- [`ae544b8`](https://github.com/gamerlogue/web/commit/ae544b85da996318c4ab724a07bb537982619829) Fix bug in router::route method.
- [`7488798`](https://github.com/gamerlogue/web/commit/74887986a70318dc5b333ce7aebda872116ddbbe) Fixing bugs in router.
- [`b353afd`](https://github.com/gamerlogue/web/commit/b353afdc79d5578d2a2396cb34e8137cf22b8c97) Fixing router bugs.
- [`620f3ba`](https://github.com/gamerlogue/web/commit/620f3ba91f2d1a14e8cdbb6a60b0c29863f03251) Fixing a bug and cleaning.
- [`ab17ea6`](https://github.com/gamerlogue/web/commit/ab17ea674a24245053a9384b05f0b7981d8b7719) Fix bug in db profiling.
- [`3507d15`](https://github.com/gamerlogue/web/commit/3507d15323edb56befbd4c900e3b277b9aa42894) Fix charset in mysql and pgsql connectors.
- [`3789972`](https://github.com/gamerlogue/web/commit/3789972a35924846ef77bba599500a828731a236) Fix bug in controller auto-loading.
- [`f624a68`](https://github.com/gamerlogue/web/commit/f624a6849f6d4b32ce6187bffaf6293cad5277c7) Fix handling of HEAD http requests.
- [`753c769`](https://github.com/gamerlogue/web/commit/753c769d103df6f7404d7f37c837f6011d9e0aa9) Fixing comment.
- [`ca5dfa4`](https://github.com/gamerlogue/web/commit/ca5dfa4061f98e097384c29aedeaa7d57ed9be15) Fixing underscored library auto-loading.
- [`425192a`](https://github.com/gamerlogue/web/commit/425192a05db7d5066a2ba62c4f844164c94ee21f) Fix bug in route.
- [`6535fca`](https://github.com/gamerlogue/web/commit/6535fca31ca766e001db53f6cc28432d09ea62ee) Fixing bug in event class.
- [`3ba6342`](https://github.com/gamerlogue/web/commit/3ba6342cf57871d510a3d74889f59d59a7438ea8) Fixing loading of namespaced classes.
- [`0e6312d`](https://github.com/gamerlogue/web/commit/0e6312d07676777a932d48fb661eba4a0d993a4d) Fix changelog.
- [`59ae60d`](https://github.com/gamerlogue/web/commit/59ae60d287fc17c64b2250276a6b2290220ee299) Fixing release script.
- [`fd725ac`](https://github.com/gamerlogue/web/commit/fd725aca210a91291b850f7bbd5ddc86c9860bf7) Fixing release script.
- [`023dacf`](https://github.com/gamerlogue/web/commit/023dacf5e0998f19f8bc779d0cd45eb3f3edc084) Fix replacement of optional parameters in the URL::transpose method.
- [`9e8acd1`](https://github.com/gamerlogue/web/commit/9e8acd1edafbc156690390454be8d14bc1a7a37b) Fix some input stuff and revert paginator changes.
- [`c6125ed`](https://github.com/gamerlogue/web/commit/c6125edc6625a423c1fd7729840a4dcdc3f02cd6) Fix bug in input::except method when passing a string.
- [`b870ac0`](https://github.com/gamerlogue/web/commit/b870ac09dd1ef2b4b4e86acd71f02c9b38ad0060) Fix front controller.
- [`062ae87`](https://github.com/gamerlogue/web/commit/062ae8756c32e935d3c8aed5e54445e36e47016a) Fix conflicts.
- [`8d16916`](https://github.com/gamerlogue/web/commit/8d169166308972158b380f2f8fb729882216026e) Fix magic quotes.
- [`75f6384`](https://github.com/gamerlogue/web/commit/75f63847673f241463c00f42134277039b0e38c2) Fix eloquent->delete bug.
- [`636d056`](https://github.com/gamerlogue/web/commit/636d05665c76145caaf96cda7eecf77fcfbe7ef4) Fix merge conflicts.
- [`b72f4e9`](https://github.com/gamerlogue/web/commit/b72f4e9fd95201dd752c1080d891841153468ec2) Fix change log.
- [`d2f3590`](https://github.com/gamerlogue/web/commit/d2f35900cd31d03bd15de1f20237af211287e1e9) Fix where in shortcut and response header casing problem.
- [`63ff049`](https://github.com/gamerlogue/web/commit/63ff04991b7ea6feeac817a2e89c77c0c0aff851) Fixing merge conflicts.
- [`f97f73a`](https://github.com/gamerlogue/web/commit/f97f73a83530069c7fceef3ae03e2247a4fd3e25) Fixing merge conflicts.
- [`d41b1db`](https://github.com/gamerlogue/web/commit/d41b1db722c9e6fa8b0453b8eace13c94d2b2a80) Fixing bug in view class.
- [`4c2406d`](https://github.com/gamerlogue/web/commit/4c2406db29af7a904b8196ffc5c662be39ec1a47) Fixing base url generation.
- [`3a0135a`](https://github.com/gamerlogue/web/commit/3a0135a6d3c19025ff827488d4f6bacdfa1d62d0) Fixing markdown
- [`c0a80d1`](https://github.com/gamerlogue/web/commit/c0a80d132f779974ec0898437b0a360a2564f5b8) Fix routing.
- [`6a9cc48`](https://github.com/gamerlogue/web/commit/6a9cc4816408b55df0c606af9ee97228c16f1aea) Fix handling of hash Urls.
- [`3cb1272`](https://github.com/gamerlogue/web/commit/3cb1272028651b491985c9740267ee5704868ed8) Fixed menu, added base styles, trying new header
- [`e1d4974`](https://github.com/gamerlogue/web/commit/e1d49749a3469bb32e192300bcb2e7c68467becc) Fixing conflicts.
- [`b58c637`](https://github.com/gamerlogue/web/commit/b58c6370ee273c015c955352b19553e05e930539) Fixing template.
- [`02db986`](https://github.com/gamerlogue/web/commit/02db9866274456d371f5b6a436e7662598898ac0) Fixing route.
- [`8f24d83`](https://github.com/gamerlogue/web/commit/8f24d832333001247aa5692fcb8a58376b145f44) Fixing profiler.
- [`3e00ce2`](https://github.com/gamerlogue/web/commit/3e00ce2efb954e2eb00f87093405ce2612583671) Fix bug regarding SSL cookies.
- [`10d9cd3`](https://github.com/gamerlogue/web/commit/10d9cd33ad4e46cb3028b7e556904ae2ae79e3f0) Fixing conflicts.
- [`a859455`](https://github.com/gamerlogue/web/commit/a85945561c0e291d0eeb5dd03e39f2e135c17fb3) Fixing conflicts.
- [`ffb4034`](https://github.com/gamerlogue/web/commit/ffb4034631a3840273b33b7d1031afaf4d1d80e3) Fix url parsing.
- [`232bf01`](https://github.com/gamerlogue/web/commit/232bf01ae2f26e560e629b8cc56527efe84ec557) Fix secure cookie issue.
- [`eda46a8`](https://github.com/gamerlogue/web/commit/eda46a815ee7e11116ff025fda8cfca827321472) Fix eloquent model attribute resolution.
- [`c31f001`](https://github.com/gamerlogue/web/commit/c31f001f22556a58028e514af5a031027ed72c96) Fix url https bug.
- [`b5847c1`](https://github.com/gamerlogue/web/commit/b5847c1f3aef9cc5af5076a76cf99275fa143ea7) Fixed logo bug
- [`01a7991`](https://github.com/gamerlogue/web/commit/01a7991bd52367fcb5eb1617950a9163899d8a80) Fix artisan.
- [`8a68705`](https://github.com/gamerlogue/web/commit/8a687053a85e16dd307ca16983381c327ec864f5) Fix conflicts.
- [`1a5d425`](https://github.com/gamerlogue/web/commit/1a5d4250d1b70480f464faabf557344f5be31715) Fix conflicts.
- [`1847a36`](https://github.com/gamerlogue/web/commit/1847a369fb35143b3db49038e3a0eaa141d8186a) Fixed eloquent datetime bug when determining dirty attributes.
- [`e16ab6f`](https://github.com/gamerlogue/web/commit/e16ab6f3d454a7ff52329cd7fd083211563101b1) Fixing conflicts.
- [`51f5fdd`](https://github.com/gamerlogue/web/commit/51f5fdd0c92d8de02f331151205473a9b88c58f5) Fix conflicts.
- [`ed2df89`](https://github.com/gamerlogue/web/commit/ed2df89c3ed865654ed248f3c837e43427bbb3c2) Fix double return.
- [`d142894`](https://github.com/gamerlogue/web/commit/d1428948eae23d5f5c257e3d66fae5c0b24de288) Fix docblock.
- [`09e456d`](https://github.com/gamerlogue/web/commit/09e456d2bff482c7767ef930db380660db5e090e) Fix docblock.
- [`58f69fd`](https://github.com/gamerlogue/web/commit/58f69fdf47c765a312a06c219e25bd6f16871da6) Fixing some issues related to environment.
- [`3241de0`](https://github.com/gamerlogue/web/commit/3241de0cc1b70167e1ab243c13a5526b9cafc712) Fix Input::merge method.
- [`39601e8`](https://github.com/gamerlogue/web/commit/39601e8a78ee3fe096749f316ddb21621600227e) Fix bugs in input class.
- [`47b6013`](https://github.com/gamerlogue/web/commit/47b60135bbeec9b527d71ccdb49e71816e70844e) Fix possible error loading error class.
- [`1dea985`](https://github.com/gamerlogue/web/commit/1dea9852a9106fbc9b8a1d9fb610eea0177f4fb9) Fix eager loading of belongs_to relationships when all keys are null.
- [`a994c30`](https://github.com/gamerlogue/web/commit/a994c30ab3a04f14e88b6d9bcf0cdad805ac9bd6) Fixed str::words php notice.
- [`affcad0`](https://github.com/gamerlogue/web/commit/affcad0948ecc263ab572b858c618a23c4adf5b9) Fix bug surrounding cookie session driver.
- [`68834a4`](https://github.com/gamerlogue/web/commit/68834a47d96384d72e1f4cd853a250bae8478cb3) Fixing conflicts.
- [`b8b0c08`](https://github.com/gamerlogue/web/commit/b8b0c0849574225473674ae8b916dc9786a66994) Fix html class.
- [`3a62036`](https://github.com/gamerlogue/web/commit/3a62036a9cfa544205dfee84b398066e91c1cd0a) Fix urlencode prob
- [`74022cf`](https://github.com/gamerlogue/web/commit/74022cfa5a63e06e1e449147678ffd9b9afadcbf) Fix typo.
- [`314f25b`](https://github.com/gamerlogue/web/commit/314f25bd28d5556045d1300a13a90054c6e22ccd) Fixing conflicts.
- [`11b9f52`](https://github.com/gamerlogue/web/commit/11b9f522398efd0b95de805082736471a0992f3c) Fix error in comment
- [`012663d`](https://github.com/gamerlogue/web/commit/012663ddbbb2803e652ff567673a823585a150ec) Fix conflicts.
- [`0f5ffdf`](https://github.com/gamerlogue/web/commit/0f5ffdfb56d2aeeb586e2febbc643b78838b12d1) Fix conflicts.
- [`992a5f7`](https://github.com/gamerlogue/web/commit/992a5f74ca5e86be8a9570d438d62bfe62b03ad3) Fix for forelse only matching $vars
- [`c062418`](https://github.com/gamerlogue/web/commit/c062418ee14283d4c79f89dcbd0147cf1716e440) Fixing conflicts.
- [`5f0e70a`](https://github.com/gamerlogue/web/commit/5f0e70a2ef63113d423b5857aaa73bc24e4a241f) Fixed a conflict with .hidden class when using twitter bootstrap and made animation smoother
- [`d1bb02a`](https://github.com/gamerlogue/web/commit/d1bb02ab6440a95a4430a20c720dc148e31c5d06) Fix conflicts.
- [`544821b`](https://github.com/gamerlogue/web/commit/544821bdebdc2edb0d5bfcb208f30d049f3739f4) Fix eloquent auth driver bug.
- [`d0afdf7`](https://github.com/gamerlogue/web/commit/d0afdf7bb291967e98b0c3c1ecb0d571567ba7ac) Fixing bug where parameters are not passed in IoC::resolve()
- [`5e83a58`](https://github.com/gamerlogue/web/commit/5e83a58e0012512eba468bc13a2c3c404b122deb) Fix spelling mistake pointed out by @andrey_butov
- [`ec0128b`](https://github.com/gamerlogue/web/commit/ec0128be8f23af403f1a7cf966dd96867fc6baec) Fixed optgroup closing tag
- [`36226b9`](https://github.com/gamerlogue/web/commit/36226b99bcaa469579dd13692b4c172085f0748a) Fixed link for query builder /query -> /fluent
- [`3732113`](https://github.com/gamerlogue/web/commit/37321136e47d7d1ff8018d8734f792c13bd6f8a9) Fixed missed umlauts
- [`a66eb44`](https://github.com/gamerlogue/web/commit/a66eb44809c76c3cae3934a81c6c51ff73035e8f) Fixed typo
- [`ee6adc2`](https://github.com/gamerlogue/web/commit/ee6adc26d9e651297833fa9a22a678793105de33) Fix merge
- [`85ec193`](https://github.com/gamerlogue/web/commit/85ec19367d034622f74683049db365fcf5d7113f) Fix merge
- [`7b5e37a`](https://github.com/gamerlogue/web/commit/7b5e37a316b230a7f5c04222053e11e03b6cee2e) Fixing merge issues on blade pull
- [`2c6ed23`](https://github.com/gamerlogue/web/commit/2c6ed23b4505a1b25e5a92a17e55f7f446485e67) Fixing merge issues
- [`27fb9d0`](https://github.com/gamerlogue/web/commit/27fb9d06122d46b38d4c4948ab3267779c13b2fe) Fixed "here" link
- [`1c92b90`](https://github.com/gamerlogue/web/commit/1c92b907d5f87198edd5f28152127d9d70c29a0a) Fixed two typos
- [`9d9d1d0`](https://github.com/gamerlogue/web/commit/9d9d1d010c5178fcc578f916ddb2187022189a14) Fixing merge for contribution docs
- [`2611c1f`](https://github.com/gamerlogue/web/commit/2611c1f27afb0632f6c282fa74e600bf90b1cc2b) Fixing merge issue for blade comments pull
- [`30175c2`](https://github.com/gamerlogue/web/commit/30175c2a52c7257000da1097bead94551de39029) Fixing merge issues for comment tweaks
- [`749948b`](https://github.com/gamerlogue/web/commit/749948bc9d4c5f84d7c5e3ff5443efc823168615) Fix conflicts.
- [`727afc1`](https://github.com/gamerlogue/web/commit/727afc1bfa4f4eb0033a5705895bc39309e2f63d) Fix namespace issue on exception
- [`43c3c2d`](https://github.com/gamerlogue/web/commit/43c3c2de6840d4face81c97ec142c9121e13c283) Fixes from testing
- [`9718d5c`](https://github.com/gamerlogue/web/commit/9718d5cd0de681c75a667efaa4076cbaab035380) Fix nested queries.
- [`e804684`](https://github.com/gamerlogue/web/commit/e8046847c4774788e88d0fca87d56a8b9fa9ba99) Fix tests.
- [`fdeb06e`](https://github.com/gamerlogue/web/commit/fdeb06e54c9c3a356760f670f98202e70269d0b7) Fixed readme.md wrong symbol
- [`02cb96a`](https://github.com/gamerlogue/web/commit/02cb96a00842a082d240b34101d5c5ddbd97e02b) Fix bug in eloquent model.
- [`d1c1fe4`](https://github.com/gamerlogue/web/commit/d1c1fe4446aecb33de3344b237e68448ba9466b2) Fix bug in eloquent model and update version.
- [`742eb4e`](https://github.com/gamerlogue/web/commit/742eb4ea8dfde766cd8dbdf58192c9bda920b85a) Fix link to #route-groups
- [`aa37c82`](https://github.com/gamerlogue/web/commit/aa37c826507427c8f79ff48583495e3775923469) Fixed issue #1206
- [`6f30ed7`](https://github.com/gamerlogue/web/commit/6f30ed7a79e2e8eb2dc083c1b7a4aa81663fbdde) Fixed issue #1206
- [`c63ed36`](https://github.com/gamerlogue/web/commit/c63ed36c73ada77a9fec40b2d10778b2237e2b86) Fixed white-on-white profiler text
- [`4de7510`](https://github.com/gamerlogue/web/commit/4de7510bfd34d0c2f72fd938cc35f1fc2bd57bac) Fixed typo
- [`106d3b7`](https://github.com/gamerlogue/web/commit/106d3b7287108e168af39da737102cc8f8859370) Fix namespace.
- [`ce0a7f6`](https://github.com/gamerlogue/web/commit/ce0a7f654511216fc9a3c9b8e7bc2a8b2069fa69) Fix typo.
- [`c1a8b83`](https://github.com/gamerlogue/web/commit/c1a8b83574869e0936182bf4bea7b6c5a8e7a2cd) Fix array input has.
- [`1541480`](https://github.com/gamerlogue/web/commit/15414808a12cd67a2676f70f220b68360e8d7e97) Fix padding bug in crypter.
- [`4046313`](https://github.com/gamerlogue/web/commit/4046313ecd4934e09a621ee930ee31f88262475e) Fix environment on tests.
- [`76db206`](https://github.com/gamerlogue/web/commit/76db206551622be1560fb68349da819807350a1b) Fix incorrect padding with multi-byte strings
- [`cb484a9`](https://github.com/gamerlogue/web/commit/cb484a9d470b1d2919635d7c653606b589782aba) Fix conflicts.
- [`fb4325c`](https://github.com/gamerlogue/web/commit/fb4325c94a79178a4ab053cc05c95238d5bf0503) Fixed artisan optimize crash
- [`ef6dc63`](https://github.com/gamerlogue/web/commit/ef6dc637ddbf7f42bc59437fd0bc6693f303d652) Fixed
- [`2c2488e`](https://github.com/gamerlogue/web/commit/2c2488e4bdb7ab5ce7ec876b1c9cd0cf2b38bb29) Fixed spacing issue
- [`338f5f1`](https://github.com/gamerlogue/web/commit/338f5f1cce65137f35ceed176a26355dcb9cf575) Fix conflicts.
- [`5e71bca`](https://github.com/gamerlogue/web/commit/5e71bcae3cbe1e60e3fff24afe7d4406009c13c7) Fix bad merge.
- [`5644e8e`](https://github.com/gamerlogue/web/commit/5644e8e320e63fe5463a6fb0f78fae3c4df633c7) Fix conflicts.
- [`3b7e6dc`](https://github.com/gamerlogue/web/commit/3b7e6dcdca9c686db6812cf7a1c778fb67b7cea0) Fix a bunch of stufF
- [`423eba9`](https://github.com/gamerlogue/web/commit/423eba968f6641c7fd7fb156c8c5e22ad3bd56e2) Fix email
- [`ff441ab`](https://github.com/gamerlogue/web/commit/ff441abd622893752ffc1ba58ce64200606d07ff) Fix conflicts
- [`936aa91`](https://github.com/gamerlogue/web/commit/936aa9159ef916a9b26444f8b70c6d93457b1d88) Fix doctype declarations
- [`44787b0`](https://github.com/gamerlogue/web/commit/44787b0c1044687039bad82e0b25572594e31921) Fix css
- [`804b9d7`](https://github.com/gamerlogue/web/commit/804b9d746078482ee4e644d680bd87ca4e47b003) Fix wording
- [`ecd52ef`](https://github.com/gamerlogue/web/commit/ecd52ef1d2887f3fbd27ab20315a435f99a57e18) Fix order
- [`395b69b`](https://github.com/gamerlogue/web/commit/395b69b54020e5fba899613509e2affe4a2f04e0) Fix status code
- [`c131299`](https://github.com/gamerlogue/web/commit/c131299976f322015988cea27ec05193324b8748) Fix conflicts
- [`9c66082`](https://github.com/gamerlogue/web/commit/9c66082972c58519b5df171ffa659735a0d45aba) Fix type hitns
- [`f047f80`](https://github.com/gamerlogue/web/commit/f047f80dc07a5b7cbbe60c187eea62ed70a10734) Fix incorrect method name in comment.
- [`a690bb7`](https://github.com/gamerlogue/web/commit/a690bb755265ab3c7054bd62c68f960cfed2cbdd) Fix conflicts
- [`4fba29c`](https://github.com/gamerlogue/web/commit/4fba29c0ec7da3e12b7d8a6e08fdff3de11826f0) Fix problems
- [`48fb951`](https://github.com/gamerlogue/web/commit/48fb9517d2a1d52e19ffe5988a02b056b4dba2cd) Fix conclits
- [`e52b1f7`](https://github.com/gamerlogue/web/commit/e52b1f71d56a068fd545e47141c72c91ff4eeaca) Fix wording
- [`a97b9e0`](https://github.com/gamerlogue/web/commit/a97b9e0c7c24aadf84cb620bb0d26ed37bc0120f) Fix comment
- [`c332ad9`](https://github.com/gamerlogue/web/commit/c332ad9582e71d4f77aec018c388ea0239997cd6) Fix typo
- [`19f8537`](https://github.com/gamerlogue/web/commit/19f85378298e81dd227c814ed9e9bbd7f9c0b5da) Fix namespace
- [`d72e3f3`](https://github.com/gamerlogue/web/commit/d72e3f3af558acc00448273b5bf18469af975c4d) Fix conflicts
- [`813c941`](https://github.com/gamerlogue/web/commit/813c9411b600487a828088b4aa01cee2f150a743) Fix wrong spelling
- [`ca7c973`](https://github.com/gamerlogue/web/commit/ca7c9732809cb60b80b4be64e0cdefdc5c5b7834) Fix length
- [`64ae3d5`](https://github.com/gamerlogue/web/commit/64ae3d5a7e98111c1b75b3322ea0a9ec6bf55dfc) Fix cons
- [`89a4343`](https://github.com/gamerlogue/web/commit/89a43434e77aecb7fc94119f6fae7216296b0155) Fix cons
- [`727eda7`](https://github.com/gamerlogue/web/commit/727eda71f291574bc1723ef4af2c460e937a0ae3) Fix missing word in docblock
- [`8a9f89d`](https://github.com/gamerlogue/web/commit/8a9f89d3cfcaad12cacb74e9cb1a1eef9636811d) Fix wording
- [`2689538`](https://github.com/gamerlogue/web/commit/268953862ff649ccf186e6740cd2e9af40b8906a) Fix order
- [`6f68519`](https://github.com/gamerlogue/web/commit/6f6851946b359c4867c98d662c8dd473a6ecaac6) Fix conflicts
- [`f5dfa20`](https://github.com/gamerlogue/web/commit/f5dfa2057e800e15ecc1f5609016dfbc08fc643e) Fix typo
- [`30d0e2d`](https://github.com/gamerlogue/web/commit/30d0e2dcca9f673e1d364123571902872d7e88ea) Fix comments
- [`a37215d`](https://github.com/gamerlogue/web/commit/a37215d0447f3f29d5a39dc42c971cec54cacd31) Fix spacing
- [`ed9a82d`](https://github.com/gamerlogue/web/commit/ed9a82d6cc78c21f4da1fd98e1d10e1a32b9c423) Fix comment
- [`b64d1e3`](https://github.com/gamerlogue/web/commit/b64d1e3dc89f940ef36f8b14490620b9bd54c870) Fix example test
- [`a7481f6`](https://github.com/gamerlogue/web/commit/a7481f69d5e164fb8f7c76f13f05281d634b34c1) Fix assertion
- [`c679fb1`](https://github.com/gamerlogue/web/commit/c679fb1a1edc5403ed352a707c54299e251c675c) Fix spacing
- [`a9fad67`](https://github.com/gamerlogue/web/commit/a9fad67e1fb369779f4c5ebe454524a24e3698b7) Fix spacing
- [`b084653`](https://github.com/gamerlogue/web/commit/b0846539b1867e76af5c62369e5d6887fd139da0) Fix cascade
- [`722970d`](https://github.com/gamerlogue/web/commit/722970da8a17377203489e3ec91e48152c9ae513) Fix wording
- [`0c78ad3`](https://github.com/gamerlogue/web/commit/0c78ad3195cf874737ac3bd518e59fc77a721aab) Fix typo
- [`864a829`](https://github.com/gamerlogue/web/commit/864a82918ecfc357378a6a3c84a2f5ffda4b26c9) Fix comment
- [`9c480f1`](https://github.com/gamerlogue/web/commit/9c480f1f95bdb053926704428c15f67eed9384aa) Fix conflicts
- [`f6c6e41`](https://github.com/gamerlogue/web/commit/f6c6e41c9e154448f805e200fc7f707023626813) Fix artisan
- [`b86f7a3`](https://github.com/gamerlogue/web/commit/b86f7a39e698867b3847b13ae1e8d706edd1c88f) Fix conflicts
- [`8c57f4f`](https://github.com/gamerlogue/web/commit/8c57f4fdbbda7716c93a96f116ba281e4723023e) Fix error code
- [`4858c75`](https://github.com/gamerlogue/web/commit/4858c7517e0679fc6de6007f7e1e1dfcb776c8d6) Fixing conflicts
- [`f67cddc`](https://github.com/gamerlogue/web/commit/f67cddc68055911c414c6572303ed06f981aa903) Fix grammar
- [`b4735d6`](https://github.com/gamerlogue/web/commit/b4735d69e199ad82286399efd9c0687a04b3669f) Fix
- [`0b25fcc`](https://github.com/gamerlogue/web/commit/0b25fcc2333c12eac0f7e9634d6e9104f4a1a509) Fix name
- [`a77f0be`](https://github.com/gamerlogue/web/commit/a77f0be7957f2c3d9f640fcc9049ffe958c30c63) Fix
- [`e840fe0`](https://github.com/gamerlogue/web/commit/e840fe06adef51e240135f1164d0672f3b4686ab)    fix style
- [`6754230`](https://github.com/gamerlogue/web/commit/67542306b8b2c2f61e30ddb86888cf2ddb0ac381) Fix wording
- [`ac2e674`](https://github.com/gamerlogue/web/commit/ac2e6744eede3f4277faa517eac43d0fc259b17e) Fix conflicts
- [`da803c8`](https://github.com/gamerlogue/web/commit/da803c823da186d07414e35aa559d748f7d126e7) Fix styling
- [`902694c`](https://github.com/gamerlogue/web/commit/902694c32e4d099cb2f4998469d2f8e87d8bb4de) Alphabetical order
- [`78b6f79`](https://github.com/gamerlogue/web/commit/78b6f79ac3a23f4a1a606a858a2739d47ce74c38) Fix conflicts
- [`1312ddc`](https://github.com/gamerlogue/web/commit/1312ddcd2c914f611c89a26613cae33f3bb3af6c) Fix stub
- [`d633402`](https://github.com/gamerlogue/web/commit/d6334022116f67b583b9b1368dad02d27a553416) Fix running mix tasks error
- [`1118490`](https://github.com/gamerlogue/web/commit/11184909a4a7335becfc5b575ea1026440ac3b60) Fix conflicts
- [`2b739ce`](https://github.com/gamerlogue/web/commit/2b739cea05a8f6d8560906c3dc1b15e45cf38c08) Fix conflicts
- [`b201ff1`](https://github.com/gamerlogue/web/commit/b201ff1a537b74c2e51ea9caf6004d80f89ece12) Fix key
- [`cf236f4`](https://github.com/gamerlogue/web/commit/cf236f406ae342a854a2c1100027cb6f295f1cfe) Fix comment
- [`2f59f7d`](https://github.com/gamerlogue/web/commit/2f59f7d21f0f026412db27d4279cbb4148bfa962) Fix wording
- [`61d3ea3`](https://github.com/gamerlogue/web/commit/61d3ea32ebf507eb65df2db1eeb104bc6a198ad6) Fix doc block
- [`0d9e269`](https://github.com/gamerlogue/web/commit/0d9e26983418a43846c79581236ee87a11232f72) Fix formatting
- [`55e0253`](https://github.com/gamerlogue/web/commit/55e02539afa4c92815279fa16fa9081ae2013804) Fix comments
- [`01c3be5`](https://github.com/gamerlogue/web/commit/01c3be5ee61628a20651bdf2557810db8b16a88e) Fix version
- [`186a200`](https://github.com/gamerlogue/web/commit/186a200e7a9c7f97837d668b76b981b6e74ffcba) Fix conflicts
- [`77954d5`](https://github.com/gamerlogue/web/commit/77954d5f0c5b63429eec717c53da48048009c0b2) Fix spacing
- [`252e516`](https://github.com/gamerlogue/web/commit/252e516226719e1482e7d9682ad7ae1ba5981bd9) Fix docblock
- [`5215653`](https://github.com/gamerlogue/web/commit/52156536060e66ab1fe92964f5f5470c943e30ef) Fix conflicts
- [`b157344`](https://github.com/gamerlogue/web/commit/b157344db16e47abedfaac8e53cbd1195b4d787e) Fix conflicts
- [`9719266`](https://github.com/gamerlogue/web/commit/97192660831fa8f990beed197affd3c06ebd7ffc) Fix conflicts
- [`1b2ad16`](https://github.com/gamerlogue/web/commit/1b2ad161aab9ddb5ff3090eb9f6934fcfb569bc3) Fixing conflicts
- [`59f5a98`](https://github.com/gamerlogue/web/commit/59f5a98f2c1ce38e29cd90d651540ea8cec79a83) Fix conflicts
- [`3e67b8b`](https://github.com/gamerlogue/web/commit/3e67b8ba892bcfc26cd8381a333c3cad2bd65ce8) Fix conflicts
- [`e0e038c`](https://github.com/gamerlogue/web/commit/e0e038c917aada023c8985b696f76e743e041fb3) Fix merge conflict
- [`896f116`](https://github.com/gamerlogue/web/commit/896f116e161378cfca4cd9d740899117eeadb06d) Fix css whitespace invalid-calc (#6517)
- [`90b7fb3`](https://github.com/gamerlogue/web/commit/90b7fb3c3c3eaa803fccaa11f77a1fd5c5b26ae0) Fix alphabetical order (#6627)
- [`5a52b92`](https://github.com/gamerlogue/web/commit/5a52b92f0f6d6eecb083d5715586fa5c40c3220c) Fix
- [`143330e`](https://github.com/gamerlogue/web/commit/143330e97b2fa6c65bc055c13e97f785959a3641) Fix database
- [`bedb641`](https://github.com/gamerlogue/web/commit/bedb641cf36f4cacfc57f56c816e7831bd7437d4) **igdb:** 🐛 Use getContent to correctly retrieve raw request body
- [`2c53191`](https://github.com/gamerlogue/web/commit/2c53191513987f8886d7b48240a596a310c8d73e) **docker:** Update healthcheck ownership to use UID variable
- [`74e26c2`](https://github.com/gamerlogue/web/commit/74e26c22f605c482a42b962fc0148f12899d8867) **docker:** Create user home directory and subfolders to prevent root ownership
- [`a6af975`](https://github.com/gamerlogue/web/commit/a6af97530dec76f0a59901f0d27e0ccfecfcb209) **docker:** Create user home directory and subfolders to prevent root ownership
- [`49991cb`](https://github.com/gamerlogue/web/commit/49991cba0af2b2a24648e3191e41390933d1fcb6) **igdb:** Handle request exceptions in IGDB API calls
- [`f306951`](https://github.com/gamerlogue/web/commit/f306951ef505ec58dfdd3a16e4dd892b0dc92ac2) **tests:** Reduce PHP matrix versions to 8.4
- [`647eae2`](https://github.com/gamerlogue/web/commit/647eae2ae72526de60d51747b91bb20421b9e7c7) **navigation:** Comment out unused routes in NavigationDrawer and TopAppBar
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1f79daffffd31510ae26e72df0e80ba02230d4d5"><code>1f79daf</code></a> <b>docs:</b> 📝 Correct production compose file extension</summary>

  > The previous documentation used the `.yml` extension, which was a typo. This change updates the command to use the standard `.yaml` extension for Docker Compose files, ensuring the provided instructions are accurate and functional for users.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/dbe5d0d6e01adda18cbd9eabab5a780765af844d"><code>dbe5d0d</code></a> <b>i18n:</b> 🐛 Correct various translation errors and inconsistencies</summary>

  > These changes address several grammatical mistakes, spelling errors, and inconsistencies across Turkish, Romanian, Ukrainian, and Greek language files. The goal is to improve the overall quality and accuracy of the application's localization for a better user experience.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6df33590fdd74e536aa6a99afdf155958a485046"><code>6df3359</code></a> <b>config:</b> 🐛 Correct MariaDB connection port</summary>

  > The previous port 3307 was incorrect for the local MariaDB instance. This change ensures proper connection by using the standard port 3306.

  </details>
- [`053fa50`](https://github.com/gamerlogue/web/commit/053fa50d3f7372d3e4761a5068bf9314079beb7c) Cookies are not available for subdomains by default (#6705)
- [`4b59133`](https://github.com/gamerlogue/web/commit/4b591338e3daa6025be3e8401ed6e626c81f9dbc) Ensure APP_URL does not have trailing slash in filesystem public URL (#6728)
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7784ece7c54ca534810c97059892700d1f92e1b3"><code>7784ece</code></a> <b>locale:</b> 🐛 Ensure application locale is set correctly</summary>

  > The standard `App::setLocale()` method fires a `LocaleUpdated` event. This event causes Carbon to attempt loading the Laravel config service, which results in an application crash. To prevent this, the locale is now set directly on the translator service, Carbon, and the application configuration, effectively bypassing the problematic event. Additionally, the session access was updated for consistency.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8c7b5b11a46756c12699fa4b0b31ab347badabfb"><code>8c7b5b1</code></a> <b>locale:</b> 🐛 Simplify locale middleware by disabling Carbon auto-discovery</summary>

  > The `LocaleMiddleware` previously used a workaround to avoid a crash when setting the application locale, as `App::setLocale()` would trigger an event that caused issues with Carbon's service provider loading the Laravel config. Disabling Carbon's auto-discovery in `composer.json` resolves this conflict, enabling the use of the standard `app()->setLocale()` method and simplifying the middleware logic. This ensures a more robust and conventional approach to locale management without encountering service provider conflicts.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0836df3c528082d5fa84d922d7b0c7429b019ab4"><code>0836df3</code></a> 🐛 Register ApiPlatform DefinitionNameFactory as singleton</summary>

  > Registers the `DefinitionNameFactory` as a singleton to address a deprecation warning. ApiPlatform's default instantiation was triggering this warning, requiring an explicit binding.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d247e988e3076dada024b005a070905e25678cfc"><code>d247e98</code></a> <b>locale:</b> 🐛 Pass array of locales to getPreferredLanguage and add type hint</summary>

  > The `getPreferredLanguage` method expects an array of strings as its argument, but it was previously receiving a `Collection` object. Explicitly calling `->all()` ensures the correct argument type is passed, preventing potential implicit type coercion issues. The added PHPDoc type hint improves code readability and provides better static analysis for the `$available_locales` variable.

  </details>
- [`6a43b65`](https://github.com/gamerlogue/web/commit/6a43b6533b909f0c1501e928231232ce92cdf263) Fix SSL certificate installation in Sail container
- [`cbddc74`](https://github.com/gamerlogue/web/commit/cbddc742ca8bb73a8dc3cb44616a08cc28312eac) 🩺 Sail healthcheck command not working
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c2de47a2b093bc7ec41467a7d5229e07fef77a89"><code>c2de47a</code></a> 🐛 Added missing start details</summary>

  > (cherry picked from commit 9f4acc652022bf6ecf6f58026c7fa723b9608a27)

  </details>
- [`6963b91`](https://github.com/gamerlogue/web/commit/6963b918bbc2b14897214b5caed59d79e0260866) Fix some issue during the first time startup
- [`f9ef2ce`](https://github.com/gamerlogue/web/commit/f9ef2ce9a5b680639fcd2177e18b1d8b79b66acc) Terminal longer than viewport
- [`5783cb4`](https://github.com/gamerlogue/web/commit/5783cb430ad84a142ac8556eadc107a14c83c35e) Patch improper string interpolation in AddViteToSailSupervisorCommand.php and patch octane server type as per the latest Laravel docs in composer.json
- [`df7af81`](https://github.com/gamerlogue/web/commit/df7af81677eb2139391fe3c169c24d5a4aacf77b) Fix regex not supported by Python
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fceb769b66b5d3e3c9d0a2225067284c5da4c40b"><code>fceb769</code></a> <b>core:</b> 🔧 Update php.xml include paths</summary>

  > Update php.xml to include new vendor paths:
  > - Add paths for laravel/boost, laravel/mcp, laravel/roster.
  > - Correct placement of include path closing tag.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9e000d171f4ad09cf98a49d43533773217200e83"><code>9e000d1</code></a> <b>config:</b> 🔧 Use MYSQL_* env vars for database config</summary>

  > The database configuration now supports MYSQL_* environment variables as fallback for DB_* variables.
  >
  > - Adds MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD as alternative env vars.
  > - Ensures compatibility with different deployment environments.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b5064cc03ff448a63f2b16719b5b8e9106580c2c"><code>b5064cc</code></a> <b>core:</b> 🐛 Fix pnpm dev command</summary>

  > This commit updates the supervisord configuration to ensure proper execution of the `pnpm dev` command.
  >
  > - Added `unbuffer` to the command to prevent buffering issues.
  > - This ensures the command's output is displayed in real-time.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5bb6a72dbea71f46cd34a7c90d754d4bbb2027bf"><code>5bb6a72</code></a> <b>config:</b> 🔧 Update FrankenPHP port to 80</summary>

  > The FrankenPHP configuration was updated to use port 80. This resolves an issue where the application was not accessible on the standard HTTP port.
  >
  > - Changed port from 8000 to 80 in `supervisord.frankenphp.conf`
  > - Updated Caddyfile path

  </details>
- [`0389c36`](https://github.com/gamerlogue/web/commit/0389c36ff57904ad4e63233f94c5e071be523e99) **package:** 🔧 Update Vite to version 7.1.5
- <details><summary><a href="https://github.com/gamerlogue/web/commit/043773b92371cab8a7d9225a79bea8b284a9e36f"><code>043773b</code></a> <b>docker:</b> 🐳 Improve Dockerfile setup</summary>

  > This commit improves the Dockerfile for better setup.
  >
  > - Creates home directory for sail.
  > - Correctly set permissions for certs and supervisor.
  > - Reorders instruction for better readability.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/97674dff72439783ffd0faef3f91781cb60a5497"><code>97674df</code></a> <b>docker:</b> 🔧 Standardize user and permissions in container</summary>

  > This change prevents permission errors when mounting host directories as
  > volumes.
  >
  > Previously, tools like Composer or Caddy would create necessary
  > subdirectories (e.g., `.cache`, `.composer`) as the root user, causing
  > subsequent operations by the non-root `sail` user to fail. By creating
  > and setting ownership of these directories during the image build, they
  > have the correct permissions from the start.
  >
  > Additionally, user and group ownership is consistently set to `${WWWUSER}`
  > instead of `${UID}` for better clarity. The redundant PNPM environment
  > variables are also removed as `corepack` now manages the path.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/79655d0c63ae3cb6dc1a79b7dd568365fddab15f"><code>79655d0</code></a> <b>docker:</b> 🐛 Append to PHP_INI_SCAN_DIR instead of overwriting</summary>

  > The `PHP_INI_SCAN_DIR` variable was being completely overwritten, which could prevent PHP from loading configuration files from directories set in parent images or previous build stages.
  >
  > This ensures all specified directories are scanned, allowing for a more flexible and layered configuration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/66a787b1f71e2129da7ecf629e0b433c5c7caed8"><code>66a787b</code></a> <b>docker:</b> 🐛 Set absolute path and ownership for Composer cache mount</summary>

  > Using a relative path for the Composer cache could lead to it being created in the wrong directory. Specifying an absolute path ensures the cache is always located in the sail user's home directory as expected.
  >
  > Additionally, setting the UID and GID on the cache mount prevents potential permission errors, allowing Composer to reliably write to the cache directory inside the container.

  </details>
- [`53dcee7`](https://github.com/gamerlogue/web/commit/53dcee72c2570d20a5aaf578fc423cbf33a12539) **start-container:** 🐛 correct syntax in port check command
- [`34369f1`](https://github.com/gamerlogue/web/commit/34369f178de2c3114d6d67468137018f2234aedc) **start-container:** 🐛 correct logic in port check command
- [`e276416`](https://github.com/gamerlogue/web/commit/e2764160378eca63e6ea03b9fc5447f822e49899) Fix conflicts
- [`02e13ba`](https://github.com/gamerlogue/web/commit/02e13bad746b975811c68f144d6c299247e85e82) Fix comment
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1ce072668b869d983f18b58ad6961162114b87c2"><code>1ce0726</code></a> Fix SSL certs directory ownership in Dockerfile</summary>

  > - Updated ownership command to use correct `${USER_ID}` instead of `${USER}` for directories.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d33879ba9bc66849f0d69ff6083afb2511b2d52c"><code>d33879b</code></a> 🐛 run the test suite against sqlite instead of the real database</summary>

  > compose injects the whole .env into the container, so $_SERVER already held the
  > real values and phpunit.xml's <env> entries never took effect — not even with
  > force="true", which only writes putenv() and $_ENV. Laravel reads $_SERVER
  > first, so the suite has been writing to the development mariadb all along.
  > <server> entries are overwritten unconditionally.
  >
  > API Platform derives its routes from the Eloquent metadata it reads from the
  > database while the providers boot, so an empty schema produces item routes
  > without their {id} and every /api/<resource>/{id} request 404s. RefreshDatabase
  > migrates too late and :memory: is empty again on the next boot, so
  > tests/bootstrap.php migrates a file database up front. It refuses to run unless
  > DB_CONNECTION is sqlite, and restores the exception handlers Laravel installs,
  > which otherwise make PHPUnit flag every test as risky.
  >
  > users.nickname was NOT NULL without a default, inherited from the name column it
  > was renamed from, which made every User factory call fail.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/558678ed5f7a7c487bdb0209f5b76527bd0f64a6"><code>558678e</code></a> 🔒 assign the library entry owner server-side</summary>

  > API Platform persists the deserialized payload, not the validated data, so the
  > FormRequest could reject a foreign owner but never replace it: a POST carrying
  > someone else's user_id stored it verbatim, and one without it died on the NOT
  > NULL constraint. A creating hook on the model assigns auth()->id() instead.
  >
  > Deserialization also runs before validation, so an unknown enum case or an
  > ill-typed attribute surfaced as a 500; NotNormalizableValueException now maps to
  > 422.
  >
  > Drops CurrentUserFilter's query parameters and the eight array accessors: the
  > casts cover them, as the round-trip assertions on POST, GET and PATCH show. The
  > findOrFail in authorize() goes too, since OwnedLibraryEntriesExtension already
  > scopes item queries to the owner.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/870038e630b86aaa99f29f368d6035d4835c6cca"><code>870038e</code></a> 🔒 share one admin gate and register the Horizon provider</summary>

  > Four copies of the same "is this the admin" check, written three different ways,
  > become one 'admin' gate the others delegate to. HorizonServiceProvider was never
  > listed in bootstrap/providers.php, so its gate and mail routing never applied
  > and /horizon fell back to local-only; its hardcoded notification address now
  > comes from app.admin_email like everything else.
  >
  > The GDPR export listed an activities relation that does not exist — CausesActivity
  > only provides actions() — and hid passkeys columns for a relation the model does
  > not have.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/43c8da5498a148d87ee07eb76b8d7f5cda03b3eb"><code>43c8da5</code></a> 🔒 create the Sanctum token when the code is redeemed</summary>

  > The token was minted at issue time and parked in the cache, so a code that was
  > never redeemed left a valid token behind forever while the code itself expired
  > after a minute. Only the intent is stored now, and the token is created during
  > the exchange.
  >
  > Both halves move into SanctumTokenController, which also removes the cache key
  > convention that was duplicated verbatim across the two route files.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7da9c595e5f2f626458940ef7fe8221e9457c0f2"><code>7da9c59</code></a> 🐳 give the docker build a database to introspect</summary>

  > The build has been failing at composer dump-autoload: package:discover boots the
  > application, API Platform reads the Eloquent metadata from the database, and
  > there is none. Even past that point wayfinder:generate would have emitted routes
  > without their {id}, since an empty schema yields no identifiers.
  >
  > A throwaway sqlite database now provides the schema, and the metadata dump
  > generated right after carries it into the image so the workers no longer
  > introspect the real database on every boot. The dump stays out of git: its
  > fingerprint hashes migration mtimes, which git does not preserve.
  >
  > Telescope defaults its own connection to mysql, hence the explicit
  > DB_CONNECTION. Re-enables the inertia-modal copy into the frontend stage, without
  > which the bundle cannot resolve the module.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c688ae785f228810f33c1244f66982c8d1ac6754"><code>c688ae7</code></a> 🐛 reject a duplicate game with 422 instead of 500</summary>

  > A unique index covers (game_id, user_id), and adding the same game twice — an
  > ordinary mistake — let the QueryException reach the client as a 500. Validation
  > catches it now, scoped to the authenticated user so the same game can still sit
  > in other libraries.
  >
  > Also covers the declared filter[game_id] parameter and the pagination defaults,
  > neither of which had a test.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5ce2090948608813307b546f1a8d0bdf81192706"><code>5ce2090</code></a> 🔒 stop the API from serialising email, password and remember_token</summary>

  > #[Fillable] and #[Hidden] are applied by the model constructor, but API Platform
  > inspects models through newInstanceWithoutConstructor(): getHidden() came back
  > empty, so the serializer happily emitted every column. GET /api/users/{id}
  > returned the email, the password hash and the remember token.
  >
  > Declaring them as properties fixes it, since those are set at class level. The
  > new test asserts the response never carries the email, alongside the guest and
  > cross-user checks the API Platform routes never had — their middleware lives in
  > config/api-platform.php, where nothing in routes/ hints that dropping it would
  > open every resource.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f3a281672e07ab9fd0e5be07315fa00e454bff5d"><code>f3a2816</code></a> 👷 create the sqlite database before composer install in CI</summary>

  > composer install triggers package:discover, which boots the application, and
  > API Platform reads the Eloquent metadata from the database — so the file has to
  > exist by then. Same reason the docker build provisions one; the workflow needs
  > it too, and only an empty file, since the test suite migrates its own database
  > in tests/bootstrap.php.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7d732811f120004c7b239b422605eb22d197bcdb"><code>7d73281</code></a> 👷 point the CI at sqlite instead of the Sail services</summary>

  > .env.example configures mariadb, a database session driver and failover cache
  > and queue stores — none of which exist on the runner — and every artisan call
  > boots the application, so key:generate died resolving the mariadb host. Job-level
  > environment variables take precedence because Laravel loads .env immutably.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b91926892f679a87541c3ecd7776373076c4e3c8"><code>b919268</code></a> <b>compose:</b> 🔒 close the published MariaDB port in production</summary>

  > compose.common.yaml published 3306 while defaulting MARIADB_ROOT_PASSWORD to
  > DB_PASSWORD, so root was reachable from outside with the application password.
  > The port stays published in compose.yaml, where MARIADB_ALLOW_EMPTY_PASSWORD
  > makes it acceptable for development.
  >
  > The required-variable check cannot live in the common file: Compose interpolates
  > each file at load time, before the merge, so a `:?` there would fail every
  > `extends` from compose.yaml regardless of the override. It sits in
  > compose.prod.yaml instead.
  >
  > Also adds the restart policy the database was missing, which left the
  > application coming back up without it after a host reboot.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/04587767d499e311d45875463d85e6be7c2b771f"><code>0458776</code></a> <b>cache:</b> 🐛 stop the cache failing over to an in-memory store</summary>

  > The failover chain ended in `array`, so a Redis outage would have turned locks,
  > single-use authorization codes and rate limits into state local to one Octane
  > worker instead of failing loudly.
  >
  > Note the chain has the same blind spot the queue had: an out-of-memory reply
  > from Redis is not a connection failure, so the fallback to `database` may not
  > fire on its own.

  </details>
- [`e1a6ace`](https://github.com/gamerlogue/web/commit/e1a6ace98e803ff355c162553c42ff4465fa8c26) **mcpServer:** 🐛 update port configuration from 8643 to 8644
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5501ba3f6c5f220a76242b4f81df92f33c74a5e2"><code>5501ba3</code></a> <b>auth:</b> 🐛 let asset links describe more than one app</summary>

  > Debug and release ship as separate packages, so Digital Asset Links needs one
  > statement each: a single statement carrying both fingerprints verifies neither.
  > The previous shape could only express one package, and its test passed because
  > it only ever asserted one.
  >
  > Configured as `package=FINGERPRINT[,FINGERPRINT...]`, semicolon separated. The
  > separator is `=` rather than `:` because a SHA-256 fingerprint is itself
  > colon-separated, which made the earlier format unreadable. Parsing is exercised
  > against a real fingerprint rather than a placeholder.

  </details>
- [`79d17aa`](https://github.com/gamerlogue/web/commit/79d17aa6cc64590d603988dfe353b72ffc664c31) **api:** 🐛 update IGDB route path regex to allow optional .pb extension
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1da2833d76815e29f7f0050b09d5098768f0b2c3"><code>1da2833</code></a> <b>migration:</b> 🐛 change refresh_tokens tokenable_id to UUID</summary>

  > - Updated the tokenable_id column to use UUID instead of unsigned bigint.
  > - This change resolves issues with MariaDB truncating UUIDs, ensuring proper token exchanges.
  > - Aligns refresh tokens with Sanctum's personal_access_tokens table structure.

  </details>
- [`5f3fd31`](https://github.com/gamerlogue/web/commit/5f3fd318d0f045fa8c0aa477e1a90ae23d3e245a) 🐛 scope sqlite connection to build operations
- <details><summary><a href="https://github.com/gamerlogue/web/commit/21d7bdbdf84c38593e6f45d15d8d896df1c5da04"><code>21d7bdb</code></a> <b>script:</b> 🐛 surface artisan boot errors when reading octane.watch</summary>

  > Artisan prints boot failures (e.g. an unreachable database, which API
  > Platform reads at boot) on stdout, so piping it straight into awk
  > swallowed the error and left only a generic message.

  </details>
- [`2329ac2`](https://github.com/gamerlogue/web/commit/2329ac27fa2e5f3366102234f0388458d5a0c442) **api:** 🐛 stop offering the documentation as JSON:API
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5cf0706d21399e99d8e2bb35666cbe826caec588"><code>5cf0706</code></a> <b>auth:</b> 🐛 accept a loopback redirect uri on any port</summary>

  > A desktop client binds an ephemeral loopback port, so an allowlist entry pinned to one port never
  > matches. Per RFC 8252 §7.3, http redirects to 127.0.0.1, [::1] and localhost are now compared
  > without their port; every other host still needs an exact match.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f0b259903bffb0bc7665c43a033f14a20d503ff1"><code>f0b2599</code></a> <b>auth:</b> 🐛 show a rejected native authorization instead of redirecting back</summary>

  > The browser reaching /sanctum/token was sent to the session's previous URL on a validation
  > failure, which could be any page from another tab (e.g. a Telescope API entry). It now gets a 400
  > carrying the error; JSON requests keep the 422.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/140a5b797dd0cbbc7eeae9f1354b7bb24d079fb2"><code>140a5b7</code></a> <b>auth:</b> 🐛 isolate Sanctum token rate limits</summary>

  > Raise authorization to 30 requests per minute and give each token endpoint its own throttle counter. Cover quota isolation, limits, and expiry.

  </details>
- [`2108385`](https://github.com/gamerlogue/web/commit/2108385a464133ce9bfb78480bd3cc1120bab00a) **api:** 🐛 publish current API documentation assets
- <details><summary><a href="https://github.com/gamerlogue/web/commit/89e1de77a1cda2c812b4a49aa233ab99e28e9988"><code>89e1de7</code></a> <b>api:</b> 🐛 make the library entry user relationship read-only</summary>

  > A JSON:API client sending `relationships.user.data: null` crashed the
  > denormalizer with a 500: API Platform only accepts full resource linkage
  > for writable relations. The owner is assigned server-side, so the
  > relationship is now ignored on writes.

  </details>
- [`c4b0c6a`](https://github.com/gamerlogue/web/commit/c4b0c6a1559686b1c4fd016777b34759493ecf59) **db:** 🐛 support notification UUID migration on MariaDB
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7cdf60ef871e91347545a9a43b7bfddfdc44fb70"><code>7cdf60e</code></a> <b>user:</b> 🐛 always serialize picture as an http(s) URL or null</summary>

  > The identity provider may send the keyword "gravatar" instead of a URL.
  > The accessor falls back to the SHA-256 Gravatar of the email (d=404),
  > built with forxer/laravel-gravatar, or null without an email; the stored
  > value stays the provider's.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e7b18723355f562c0b5fa1e26fe7d0115e69aa44"><code>e7b1872</code></a> 🐛 serialize rating_details as an object or null, never []</summary>

  > Empty details now read back as null, and each entry is validated as
  > {rating: int 0-100, review: string} under a non-blank key.

  </details>
- [`71160bb`](https://github.com/gamerlogue/web/commit/71160bbf9769246c406a5842428375558bedb267) 🐛 run actionlint using the official Docker image
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b35e401b2dbe7f1e3adafb68597667b6ae031221"><code>b35e401</code></a> 🐛 correct Eloquent types for static analysis</summary>

  > Enable Larastan cast parsing and specify model types at API query boundaries. Align attribute assignments and cover missing OIDC nickname claims.

  </details>
- [`4d76885`](https://github.com/gamerlogue/web/commit/4d768856ae940cffc87012a0c71851d838ef4773) Fix SSL certificate installation in Sail container
- [`8408751`](https://github.com/gamerlogue/web/commit/8408751b34133e42e763fdd90da18706bab7f4e9) 🩺 Sail healthcheck command not working
- <details><summary><a href="https://github.com/gamerlogue/web/commit/71e9b4b628282045c48de01330fc13ff70411644"><code>71e9b4b</code></a> 🐛 Added missing start details</summary>

  > (cherry picked from commit a595592e6c4f093cd82e0e4fd093d775e1fbf1d7)

  </details>
- [`a8e6563`](https://github.com/gamerlogue/web/commit/a8e656334f57b8c33a305cfdfaea6d7676f19538) Fix some issue during the first time startup
- [`5ae40a7`](https://github.com/gamerlogue/web/commit/5ae40a7550473376f650e9e682772fc8798ece79) Terminal longer than viewport
- [`7eb1690`](https://github.com/gamerlogue/web/commit/7eb16906b9e55c006e2439d02d00ff96765c1c9a) Patch improper string interpolation in AddViteToSailSupervisorCommand.php and patch octane server type as per the latest Laravel docs in composer.json
- [`f964cd4`](https://github.com/gamerlogue/web/commit/f964cd41ffa6e59675519894682aba61d56547b7) Fix regex not supported by Python
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3e3bb9f8951d84dbf15ee9a14b4d772650084834"><code>3e3bb9f</code></a> <b>core:</b> 🔧 Update php.xml include paths</summary>

  > Update php.xml to include new vendor paths:
  > - Add paths for laravel/boost, laravel/mcp, laravel/roster.
  > - Correct placement of include path closing tag.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d1c443eb48e86a49be897b22459a0c04a24a6bd7"><code>d1c443e</code></a> <b>config:</b> 🔧 Use MYSQL_* env vars for database config</summary>

  > The database configuration now supports MYSQL_* environment variables as fallback for DB_* variables.
  >
  > - Adds MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD as alternative env vars.
  > - Ensures compatibility with different deployment environments.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a9fb9661cb204a12a81a841516a54b577a5a8e5a"><code>a9fb966</code></a> <b>core:</b> 🐛 Fix pnpm dev command</summary>

  > This commit updates the supervisord configuration to ensure proper execution of the `pnpm dev` command.
  >
  > - Added `unbuffer` to the command to prevent buffering issues.
  > - This ensures the command's output is displayed in real-time.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f276f1905d2b04d5e8e85bfcdb3db4a3cb498611"><code>f276f19</code></a> <b>config:</b> 🔧 Update FrankenPHP port to 80</summary>

  > The FrankenPHP configuration was updated to use port 80. This resolves an issue where the application was not accessible on the standard HTTP port.
  >
  > - Changed port from 8000 to 80 in `supervisord.frankenphp.conf`
  > - Updated Caddyfile path

  </details>
- [`c689636`](https://github.com/gamerlogue/web/commit/c689636ec64b7a222ba122574cf3c00101f8ea13) **package:** 🔧 Update Vite to version 7.1.5
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e9b2025c3fbb5a6c13d8d9a17f6c5b235a48003c"><code>e9b2025</code></a> <b>docker:</b> 🐳 Improve Dockerfile setup</summary>

  > This commit improves the Dockerfile for better setup.
  >
  > - Creates home directory for sail.
  > - Correctly set permissions for certs and supervisor.
  > - Reorders instruction for better readability.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8b6f4fb733fd15d2eb325fca17670e6efa5f54b5"><code>8b6f4fb</code></a> <b>docker:</b> 🔧 Standardize user and permissions in container</summary>

  > This change prevents permission errors when mounting host directories as
  > volumes.
  >
  > Previously, tools like Composer or Caddy would create necessary
  > subdirectories (e.g., `.cache`, `.composer`) as the root user, causing
  > subsequent operations by the non-root `sail` user to fail. By creating
  > and setting ownership of these directories during the image build, they
  > have the correct permissions from the start.
  >
  > Additionally, user and group ownership is consistently set to `${WWWUSER}`
  > instead of `${UID}` for better clarity. The redundant PNPM environment
  > variables are also removed as `corepack` now manages the path.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0f8169283349869490aa3c85637b6a017a7da3ed"><code>0f81692</code></a> <b>docker:</b> 🐛 Append to PHP_INI_SCAN_DIR instead of overwriting</summary>

  > The `PHP_INI_SCAN_DIR` variable was being completely overwritten, which could prevent PHP from loading configuration files from directories set in parent images or previous build stages.
  >
  > This ensures all specified directories are scanned, allowing for a more flexible and layered configuration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c7a770a979177ce10ae4187e4f2e581f985a1625"><code>c7a770a</code></a> <b>docker:</b> 🐛 Set absolute path and ownership for Composer cache mount</summary>

  > Using a relative path for the Composer cache could lead to it being created in the wrong directory. Specifying an absolute path ensures the cache is always located in the sail user's home directory as expected.
  >
  > Additionally, setting the UID and GID on the cache mount prevents potential permission errors, allowing Composer to reliably write to the cache directory inside the container.

  </details>
- [`a00551a`](https://github.com/gamerlogue/web/commit/a00551abb116d65deac3aaf208f67e3169942dc4) Remove latest from image tag
- [`0cc20e7`](https://github.com/gamerlogue/web/commit/0cc20e73e0f99a3e1f3a91e5c55e4aca32830779) **start-container:** 🐛 correct syntax in port check command
- [`c4bc7ab`](https://github.com/gamerlogue/web/commit/c4bc7abb04fb2b5b6df562853e36fce7e40d3994) **start-container:** 🐛 correct logic in port check command
- [`1598e7c`](https://github.com/gamerlogue/web/commit/1598e7cb70a05708676cca91fc2770c156aae951) Fix wording
- [`720e4ed`](https://github.com/gamerlogue/web/commit/720e4edce252110bc0e716309a6fc8266cac96ab) Fix typo
- [`4696e7b`](https://github.com/gamerlogue/web/commit/4696e7bcb61422e28f6c6889c604d66fa6a76dc6) Fix conflicts
- [`100f71e`](https://github.com/gamerlogue/web/commit/100f71e71a24fd8f339a7687557b77dd872b054b) Fix artisan
- [`11dfcf6`](https://github.com/gamerlogue/web/commit/11dfcf6d1a72532f288945c9ebbfef6eb5981adb) Fix conflicts
- [`cec1b1b`](https://github.com/gamerlogue/web/commit/cec1b1bf947ce47a2c218a37544dff2b24635db2) Fix error code
- [`a6c68c2`](https://github.com/gamerlogue/web/commit/a6c68c24c9938beef0128c3288502b8fbdf8e93d) Fixing conflicts
- [`648544a`](https://github.com/gamerlogue/web/commit/648544a95f004f4a1d3b40c1504eade70a328628) Fix grammar
- [`be6d4f2`](https://github.com/gamerlogue/web/commit/be6d4f2ec5a2da27ef308fcc23054bf05a22ce8b) Fix
- [`aa4b023`](https://github.com/gamerlogue/web/commit/aa4b02358a018ebc35123caeb92dcca0669e2816) Fix name
- [`c0cda4f`](https://github.com/gamerlogue/web/commit/c0cda4f81fd7a25851ed8069f0aa70c2d21a941c) Fix
- [`80b59fd`](https://github.com/gamerlogue/web/commit/80b59fd375effd36e56fec87112e7fc4dbc12283)    fix style
- [`10340d3`](https://github.com/gamerlogue/web/commit/10340d3a021e3a4d7a44b0072a049cbf67be27fd) Fix wording
- [`5c38dee`](https://github.com/gamerlogue/web/commit/5c38dee39e1061517d9cc2cc231a3d092cd31296) Fix conflicts
- [`d79e7cc`](https://github.com/gamerlogue/web/commit/d79e7ccb8b26d5ff77582f700fd83195b5e8184a) Fix styling
- [`7d8e91a`](https://github.com/gamerlogue/web/commit/7d8e91ab66d0e8cba4e24394f6340109fbce024e) Alphabetical order
- [`0c62780`](https://github.com/gamerlogue/web/commit/0c627804026968fb52bc5fd66d3e03de06bfb4f7) Fix conflicts
- [`ed3c8b2`](https://github.com/gamerlogue/web/commit/ed3c8b2d64ec18f9c3a3276d18a1fe14018a1459) Fix stub
- [`4202ec9`](https://github.com/gamerlogue/web/commit/4202ec978dccc1ff0a193b85b2f362055cbd85be) Fix running mix tasks error
- [`4070dc9`](https://github.com/gamerlogue/web/commit/4070dc98d434ccabc73879b53ce9b4b008b6ad7a) Fix conflicts
- [`4b78ba6`](https://github.com/gamerlogue/web/commit/4b78ba61eac32cefa41da09149e0500e23cb06ec) Fix conflicts
- [`953b488`](https://github.com/gamerlogue/web/commit/953b488b8bb681d4d6e12227645c7c1b7ac26935) Fix key
- [`e43d454`](https://github.com/gamerlogue/web/commit/e43d4546a9c0bde49dae51fd6f4e2766674f1152) Fix comment
- [`2a2522d`](https://github.com/gamerlogue/web/commit/2a2522d8824c0852e30a7e3e07d46a543eb4b33d) Fix wording
- [`c3f7dd9`](https://github.com/gamerlogue/web/commit/c3f7dd9af865ab060d7ff3b0086272e9ea4cd54b) Fix doc block
- [`c104891`](https://github.com/gamerlogue/web/commit/c10489131ef28ecd46529e37b558ae93a20e3fb8) Fix formatting
- [`d2db8d8`](https://github.com/gamerlogue/web/commit/d2db8d8159f3398bcd21d9db00940dbcc7af63a2) Fix comments
- [`a7b70fc`](https://github.com/gamerlogue/web/commit/a7b70fcc310fee9d78448e078fef9003150ee8aa) Fix version
- [`bdcb968`](https://github.com/gamerlogue/web/commit/bdcb9681a6c592089a7579364a19cdd9edb4ad06) Fix conflicts
- [`5ae2f24`](https://github.com/gamerlogue/web/commit/5ae2f24a0411d6907adca42ceb2d1e7f7ffa7fd9) Fix spacing
- [`d5d2b67`](https://github.com/gamerlogue/web/commit/d5d2b67dcbefdee6b04da06bcb0e82e689193614) Fix docblock
- [`135e35b`](https://github.com/gamerlogue/web/commit/135e35ba7c2cad2ca1e1a423b0fa8ed37ed17822) Fix conflicts
- [`a5fddf7`](https://github.com/gamerlogue/web/commit/a5fddf7bc3298d3987c7c94f597c68fa6a29c604) Fix conflicts
- [`17f94e3`](https://github.com/gamerlogue/web/commit/17f94e3081e3b399d76a0b809009f1767fec6756) Fix conflicts
- [`de6d4f5`](https://github.com/gamerlogue/web/commit/de6d4f58ccda1635c24e2bf7d7d69d84e885688d) Fixing conflicts
- [`645e13d`](https://github.com/gamerlogue/web/commit/645e13d69041f8ec32d5e9804f4c59a2571af005) Fix conflicts
- [`b7ae61b`](https://github.com/gamerlogue/web/commit/b7ae61bb43960f2539776742a2126963effb1fbd) Fix conflicts
- [`295bdfe`](https://github.com/gamerlogue/web/commit/295bdfeee961c760425a392942273febe1eb6cc9) Fix merge conflict
- [`cb7ab61`](https://github.com/gamerlogue/web/commit/cb7ab6170b7b71174743f5556a599c97cee067ad) Fix css whitespace invalid-calc (#6517)
- [`cd854af`](https://github.com/gamerlogue/web/commit/cd854afd59581e1a40b1023646467371b4bab98a) Fix alphabetical order (#6627)
- [`dd473ea`](https://github.com/gamerlogue/web/commit/dd473eaddc824aeada037f0dc702a3b68a51946c) Fix
- [`4d04f68`](https://github.com/gamerlogue/web/commit/4d04f68ef9c8ca5b7907fd9e160ce673648660eb) Fix database
- [`f6b2e79`](https://github.com/gamerlogue/web/commit/f6b2e79bdbfc5bf4a37ad16466cc06ad79cc9e8f) Cookies are not available for subdomains by default (#6705)
- [`591d3e8`](https://github.com/gamerlogue/web/commit/591d3e89030a5b6cb1ca479f4ecead3d87f03895) Ensure APP_URL does not have trailing slash in filesystem public URL (#6728)
- [`0712d7b`](https://github.com/gamerlogue/web/commit/0712d7b725f79feb80c9aec14b165a03f939fde1) Fix conflicts
- [`b8e3ce3`](https://github.com/gamerlogue/web/commit/b8e3ce39ef888c63d57669ecbc87f0aca79257f3) Fix comment
- <details><summary><a href="https://github.com/gamerlogue/web/commit/dbe6016511e130fd55f92fa259c35bb0a52fd379"><code>dbe6016</code></a> Fix SSL certs directory ownership in Dockerfile</summary>

  > - Updated ownership command to use correct `${USER_ID}` instead of `${USER}` for directories.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9c6a54493102afbd1b2e0d091c43f6b60c2c6135"><code>9c6a544</code></a> 🔧 drop the stylelint rules removed in v16</summary>

  > indentation and no-eol-whitespace no longer exist: stylelint failed on the config before linting anything.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6d63f0c24e07aeb8b45921c48ce45b83c7e5a79d"><code>6d63f0c</code></a> 🐛 make the type-aware ESLint rules resolve types again</summary>

  > TypeScript 6 rejects moduleResolution node10, so typed linting saw every
  > import as unresolved: switch to bundler, as Vite recommends. Include
  > eslint.config.ts in the project (skipLibCheck for the antfu typings) and
  > ignore SCSS and XML, which @antfu/eslint-config 9.5.1 lints with espree.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/16cc1a8919511db356a440a6cb67f4ed6c9eb431"><code>16cc1a8</code></a> 🐛 keep ESLint out of the CI bun cache</summary>

  > BUN_INSTALL_CACHE_DIR puts the cache inside the project, and eslint .
  > tried to load the eslint.config.js of a cached package. The shared
  > config reads .gitignore, so ignoring it there fixes the CI job.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7cf6e8a4c76f17176a3fcef3231538687fc48963"><code>7cf6e8a</code></a> 🐛 run the feature tests without the Vite manifest</summary>

  > CI runs the tests without building the assets, so @vite in the welcome
  > view threw on the missing manifest and / answered 500.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a9bd26e19e9947aa55a23bbea258f3d13828a408"><code>a9bd26e</code></a> <b>dev:</b> 🐛 pass APP_ENV from .env to the dev container</summary>

  > The image sets APP_ENV=production and Dotenv never overrides an existing env var, so the dev container ran as production whatever .env said.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9ebcfdb12f46e0adbfa545342b20310101fe5b36"><code>9ebcfdb</code></a> <b>config:</b> 🐛 flush the debugbar v4 class between Octane requests</summary>

  > debugbar 4 moved LaravelDebugbar to the Fruitcake\LaravelDebugbar namespace; the old class name flushed nothing.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/74f28f0a8d3f294f959e26e3c455601c9600961c"><code>74f28f0</code></a> 🐛 restore the sqlite test setup lost in the template merge</summary>

  > The template merge reverted phpunit.xml to the :memory:/<env> configuration, dropping tests/bootstrap.php, and re-added a second create_telescope_entries_table migration. Every test failed on the duplicate table.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/89674c115978de1a49b953734485a7e71edf9b7c"><code>89674c1</code></a> 🐛 restrict social notification types to the known kinds</summary>

  > toFcm() matches on the type without a default arm, so an unknown kind threw UnhandledMatchError in the queued push. The literal union makes PHPStan prove the match exhaustive and check every caller.

  </details>

### ⚡ Performance Improvements

- <details><summary><a href="https://github.com/gamerlogue/web/commit/f50ce1b69e87c4c7d289b0872e05ddc245dbb1e4"><code>f50ce1b</code></a> <b>octane:</b> ⚡ Exclude vendor files from Octane warm-up</summary>

  > Warming vendor files is often redundant as these files are static dependencies and rarely change during runtime. Removing them from the warm list reduces unnecessary overhead during Octane's boot process, potentially improving performance and reducing memory footprint.

  </details>
- [`2ff1e61`](https://github.com/gamerlogue/web/commit/2ff1e61135ef82f453ed7f4ed9c9a58d8c41d278) ⚡️ disable performance_schema in the dev database
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fbd966606eb7d17c4b59798bf6e6c619fd60322e"><code>fbd9666</code></a> <b>dev:</b> ⚡️ run two Octane workers in dev instead of one per host CPU</summary>

  > --workers=auto starts one worker per host CPU, each holding the whole app: on a 24-CPU host FrankenPHP took 830 MiB, 191 MiB with two. A numeric worker count works with the v5 image Caddyfile, so the Dockerfile's known-issue note is gone.

  </details>

### 💄 UI & Style

- [`2a49787`](https://github.com/gamerlogue/web/commit/2a49787e467b0c189a4b9d958432c39d592db938) Style fixes.
- [`a6c2805`](https://github.com/gamerlogue/web/commit/a6c28050e68f0b824db608aa490c89652032ae15) Style updates
- [`05ada38`](https://github.com/gamerlogue/web/commit/05ada38d8f6d3642a5d52a668c7b895a1e599a66) Style update
- [`7945927`](https://github.com/gamerlogue/web/commit/79459274f859a767d791688ddefabf06d894d152) Style-ci fix
- [`6ba4580`](https://github.com/gamerlogue/web/commit/6ba45803a12a54ae102b049285010e37a7cd5d53) Style fix
- [`7a35efc`](https://github.com/gamerlogue/web/commit/7a35efccdf1e08a16dc638341e8cc215688fa0d2) Style
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9ef51221808d11ab12d01c6a434bcbd067c510f2"><code>9ef5122</code></a> <b>tests:</b> 🎨 Improve formatting in IgdbProxyTest</summary>

  > These minor adjustments enhance code readability and consistency. Removing an unnecessary empty line reduces visual clutter, and standardizing spacing around the concatenation operator aligns with common PHP style guidelines.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/03aa25412a7a7f6d5b2696cc2cd8efb7a025edcd"><code>03aa254</code></a> 🎨 Add blank line to redirect route</summary>

  > This change improves code readability by visually separating the token generation and user ID assignment logic from the final redirect statement.

  </details>
- [`dc8f41d`](https://github.com/gamerlogue/web/commit/dc8f41d683499f8aec59fb91be39c52a75ef6e7d) 🎨 enforce strict types and apply Laravel Pint styling
- [`2ee56fe`](https://github.com/gamerlogue/web/commit/2ee56fe746674946ae0cb2290da197c617c16827) **lang:** 🎨 reformat validation messages and update Pint config
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1514c0e1448e0786502a49144e1c3c0ea03f8645"><code>1514c0e</code></a> 🎨 run pint over the whole repository</summary>

  > Migrations, config, lang files and a few stragglers had never been formatted, so
  > the CI's `pint --test` step failed regardless of the change under review. No
  > logic touched: declare(strict_types=1), import order and spacing only.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fc1d864b9028f2e4734845cf1120fa9fd85db208"><code>fc1d864</code></a> 🎨 format localization files for consistency</summary>

  > - Adjusted whitespace for better readability in auth.php, pagination.php, passwords.php, and validation.php.
  > - Ensured uniformity in key-value pairs across localization files.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9e71fb93b5c20fa41e06443d69f0e295e2f5ce54"><code>9e71fb9</code></a> 🎨 format localization files for consistency</summary>

  > - Adjusted spacing for better readability in localization files
  > - Ensured uniform formatting across multiple language files

  </details>
- [`010d713`](https://github.com/gamerlogue/web/commit/010d7138984bbc77a10eb1bdb2206be6e3abd1d2) Style-ci fix
- [`8ca5622`](https://github.com/gamerlogue/web/commit/8ca562265e9efdd3548b4a1573156d8f185d378e) Style fix
- [`42936c6`](https://github.com/gamerlogue/web/commit/42936c656c70dc39d71dae7e79a487a716f2b1a6) Style
- [`296295e`](https://github.com/gamerlogue/web/commit/296295ea99c2f6c3c4e25b290f746c4515cbae60) 🎨 apply pint to the skeleton files
- <details><summary><a href="https://github.com/gamerlogue/web/commit/dab99c4365898534f42382088f7f86e47b0003dd"><code>dab99c4</code></a> 🎨 format the CI and commit-check config for the templates&#x27; ESLint</summary>

  > The templates lint these shared files: drop redundant YAML quotes and put
  > one TOML array element per line.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a6cccef469f590ba103399ccb08627a3eca06ea2"><code>a6cccef</code></a> 🎨 fix the ESLint errors in the config files and docs</summary>

  > Apply eslint --fix to the YAML, JSON and package.json files and to the
  > vite.config.ts imports, and rewrite the em dashes and the overlong
  > vite.config.ts comment that slop/* flags.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d3bc64c0b467f470b92345d40f7203fff83aae8c"><code>d3bc64c</code></a> 🎨 declare strict types in the base controller</summary>

  > Pint's declare_strict_types rule failed the tests job before PHPStan and the test suite could run.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a15cd65afbb15b855d28568ce71788f0fdb16000"><code>a15cd65</code></a> 💄 fix the Stylelint errors</summary>

  > Drops indentation and no-eol-whitespace, removed in Stylelint 16, and disables the naming patterns only on the Cookiescript, Zoho and vue3-loading-shimmer selectors, which are not ours to rename. The rest is --fix.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/09a7a67bbc5a6b4c5283c9b76f37b062263f4567"><code>09a7a67</code></a> 🚨 fix the ESLint errors</summary>

  > Mostly --fix: import order, unused imports, comment spacing. The Credits link gets href="#" so the a11y rules see it as interactive.

  </details>

### ♻️ Code Refactoring

- [`70e35fb`](https://github.com/gamerlogue/web/commit/70e35fb3d7340cf8b180693d9a5debaddce86f88) Refactoring auth class.
- [`8203bd9`](https://github.com/gamerlogue/web/commit/8203bd9af53ee7c6627b94b17f23ef16eb36773c) Refactoring cache class.
- [`6e93237`](https://github.com/gamerlogue/web/commit/6e93237ec946279900b587a803fbb2857b3ac2b5) Refactoring config class.
- [`77d65b8`](https://github.com/gamerlogue/web/commit/77d65b89cb0400ef1f20a21689669016361f0d1c) Refactoring crypt class.
- [`4b063ac`](https://github.com/gamerlogue/web/commit/4b063ac042464840c040550627f62a247e22564f) Refactoring database and connector classes.
- [`6a77a98`](https://github.com/gamerlogue/web/commit/6a77a98f9561052dcad42eaf5b854da22eef0f57) Refactored error and file classes.
- [`ea6b58b`](https://github.com/gamerlogue/web/commit/ea6b58b28cb76bc7d06dac16ede0c3ab4916683c) Refactoring lang class.
- [`a86d447`](https://github.com/gamerlogue/web/commit/a86d4477ca01ba45cc704213bced78b9b7ddb796) Refactoring redirect class.
- [`8277694`](https://github.com/gamerlogue/web/commit/8277694693928d019784f959fad3a1fcee7f324f) Refactoring router.
- [`c30185e`](https://github.com/gamerlogue/web/commit/c30185eb27c81e01f2087bcdbe566d2f6e968c01) Refactoring eloquent.
- [`15328af`](https://github.com/gamerlogue/web/commit/15328afa4d671e293c3b76207d3a039a168b954e) Refactoring auto-loader.
- [`537139a`](https://github.com/gamerlogue/web/commit/537139a2ca67f2beaf6e9cdcf7556ea041a4ce0f) Refactoring test structure.
- [`121a15b`](https://github.com/gamerlogue/web/commit/121a15bbcff39bb3ab0b8e8192dc087dc5c56b27) Refactored route parameter parsing tests.
- [`82a0218`](https://github.com/gamerlogue/web/commit/82a021801102fcb17ba16084955459d2658384a3) Refactored query->select.
- [`e678b77`](https://github.com/gamerlogue/web/commit/e678b77b5b227d9135b7a91063c65c4771479a53) Refactored wrap method for readability.
- [`c19ab70`](https://github.com/gamerlogue/web/commit/c19ab70a0f595724da6dae50b3ad29860d158d04) Refactor paginator for readability.
- [`16a1f89`](https://github.com/gamerlogue/web/commit/16a1f899294f258b4c29ef5f7e076b3eb4b911cf) Refactor cache driver method.
- [`68e3b46`](https://github.com/gamerlogue/web/commit/68e3b468cf83048e9da80ca20fda01df4d561738) Refactoring config class.
- [`d53ae74`](https://github.com/gamerlogue/web/commit/d53ae7457a121f18e8413965edcb963fda902440) Refactoring input class.
- [`af4403b`](https://github.com/gamerlogue/web/commit/af4403bac5e82c79eec24201a57d74a70dcbe8b3) Refactor messages class.
- [`6c98f5f`](https://github.com/gamerlogue/web/commit/6c98f5faee503b6de07b24f2c765d3b7478ba991) Refactoring session class.
- [`4619947`](https://github.com/gamerlogue/web/commit/46199478d8a3a56d05693d19a5fdb0ee769c8196) Refactoring validation class.
- [`8130f2d`](https://github.com/gamerlogue/web/commit/8130f2da254dd993a342506a2ffde6e5a03af375) Refactoring view class.
- [`07d6ed5`](https://github.com/gamerlogue/web/commit/07d6ed570365ad81bd1081cf7edec1a730d5ff27) Refactoring the auto-loader.
- [`cb7a597`](https://github.com/gamerlogue/web/commit/cb7a59711aebc7b9cf30695ccdd71c70468aa504) Refactor the memcached class.
- [`7282954`](https://github.com/gamerlogue/web/commit/7282954e27fa8b427d8b4f6485e8ffb2463693bf) Refactor the lang class.
- [`3d48b32`](https://github.com/gamerlogue/web/commit/3d48b323c3120aee917291b7b2e699409a36acfc) Refactor the request class.
- [`f0db808`](https://github.com/gamerlogue/web/commit/f0db808fd13479e635eec8dd2926a6e920a1d7dd) Refactor the validator class.
- [`366f8da`](https://github.com/gamerlogue/web/commit/366f8dad39ed453df79d53e30f6054a166830055) Refactoring the view class.
- [`86fde93`](https://github.com/gamerlogue/web/commit/86fde936acbdda1a9c64c502cbcb0291cabf4c38) Refactor the route loader.
- [`7ebcdf5`](https://github.com/gamerlogue/web/commit/7ebcdf57c5b20e38ae5c8930b878069c33203b63) Refactor redirect class.
- [`0beec68`](https://github.com/gamerlogue/web/commit/0beec68355a414656dd14a4557b81164287ba407) Refactoring asset version handling.
- [`9d4d6e5`](https://github.com/gamerlogue/web/commit/9d4d6e52bd7617ae5fa039d5b3dead4781e73efb) Refactor database structure... moved db\manager back to system\db.php
- [`9f1edfa`](https://github.com/gamerlogue/web/commit/9f1edfaee3c17b1b5d48d0e519297adfa2982964) Refactoring comments and code.
- [`d72f2c6`](https://github.com/gamerlogue/web/commit/d72f2c642b8313981c9e2c1d05f4ce0576a8b1e3) Refactored the encryption class.
- [`b196313`](https://github.com/gamerlogue/web/commit/b196313bd078363c277fb889927984cdf9631f46) Refactoring database and error classes.
- [`0cc0b7a`](https://github.com/gamerlogue/web/commit/0cc0b7ac9769de9b880f3651520c865e21f80284) Refactoring lang class.
- [`20186dc`](https://github.com/gamerlogue/web/commit/20186dca0381896cf657b6384c190b8aac95bcb1) Refactoring loader class.
- [`60c317c`](https://github.com/gamerlogue/web/commit/60c317caba8ce95ef49ad7ccf3b088b8ad3c5584) Refactoring pagination class.
- [`48120ce`](https://github.com/gamerlogue/web/commit/48120ce4036d185f6bef808af64f85d842e1214e) Refactoring the response class.
- [`39d323c`](https://github.com/gamerlogue/web/commit/39d323c44f1ed79070f26cdbed108f3dc4fabca1) Refactoring response and session classes.
- [`81a8960`](https://github.com/gamerlogue/web/commit/81a89604f98a90aa8fe736c0192048f55eeaf6d4) Refactor the arr class to fix a few bugs.
- [`7225ec0`](https://github.com/gamerlogue/web/commit/7225ec0a9ed1b2305e46e77641b1061ae3ed3377) Refactoring classes.
- [`5c3c2e2`](https://github.com/gamerlogue/web/commit/5c3c2e2d9c7d7e41533579e516e9c74d99b6db62) Refactored error handling for better architecture.
- [`73b1cb7`](https://github.com/gamerlogue/web/commit/73b1cb78f410306b1eb81185a80753a051ec5926) Refactored config path checking.
- [`9d2a76b`](https://github.com/gamerlogue/web/commit/9d2a76b26fbfb9dc5b5c3383d966a24564484a51) Refactoring database.
- [`684bbeb`](https://github.com/gamerlogue/web/commit/684bbebb5cf348f929f01c5e41fe89e084ee209c) Refactoring the database layer.
- [`0700910`](https://github.com/gamerlogue/web/commit/0700910270a67eabe40622750e951abee2631725) Refactor the query compiler.
- [`25c78b8`](https://github.com/gamerlogue/web/commit/25c78b8c55320e1578c69020b270bb97efe76d37) Refactoring query compiler.
- [`1504334`](https://github.com/gamerlogue/web/commit/15043348c13b9d6855790fac818607255e984c02) Refactoring file class.
- [`b5de50f`](https://github.com/gamerlogue/web/commit/b5de50fab90684c76355f92aa88dfdef873b149d) Refactoring the file class.
- [`df84e36`](https://github.com/gamerlogue/web/commit/df84e36314be7c55f93c680bfbb8f8dd38ccde46) Refactoring.
- [`6a8aafc`](https://github.com/gamerlogue/web/commit/6a8aafc259128d31a74a037cf2357bd48b12556e) Refactoring and adding more dependency injection through ioc container.
- [`1e7850d`](https://github.com/gamerlogue/web/commit/1e7850d9bad824c1b67b3005580882fdc2355cef) Refactoring for dependency injection and testability.
- [`56044d3`](https://github.com/gamerlogue/web/commit/56044d31f5e89c5a6e070a68da30ff8f930e21c9) Refactoring bootstrap process.
- [`9be3d1a`](https://github.com/gamerlogue/web/commit/9be3d1a54bddb846faac5fc37daacda31c8a9ca1) Refactoring the view classes.
- [`15cde60`](https://github.com/gamerlogue/web/commit/15cde60794afb674aa87679085520833235d7533) Refactoring redirect and response classes.
- [`f113b5c`](https://github.com/gamerlogue/web/commit/f113b5c829f754d72f85cf725439af0b7582e90a) Refactoring for dependency injection.
- [`66af354`](https://github.com/gamerlogue/web/commit/66af3542e9176887c72a5102653f625daae1ebef) Refactored the lang class for dependency injection.
- [`501953f`](https://github.com/gamerlogue/web/commit/501953f2dbfe6e0bdb57f3a5b02a16bfe5d66f51) Refactoring for dependency injection.
- [`5e40e29`](https://github.com/gamerlogue/web/commit/5e40e296bd4743dad6b513114e69c5fbeadbeead) Refactoring routing and adding comments.
- [`d35e2ab`](https://github.com/gamerlogue/web/commit/d35e2abd77c94125e078738ebed573a69d989c73) Refactoring the routing engine.
- [`70b6cc5`](https://github.com/gamerlogue/web/commit/70b6cc5994d3b5a269e0b95ac4cb434dd874d45e) Refactoring.
- [`ed9e04d`](https://github.com/gamerlogue/web/commit/ed9e04db6f868eb6a0d5b2f9864e84c8eef58647) Refactoring.
- [`2521ab3`](https://github.com/gamerlogue/web/commit/2521ab3c1d7f3056bfd82774d754285e00249954) Refactoring the database layer.
- [`045858d`](https://github.com/gamerlogue/web/commit/045858d88d3a490594346533052be02c523a7882) Refactoring the database layer.
- [`ca8883d`](https://github.com/gamerlogue/web/commit/ca8883d727f80c0d4f60477501d73b2ca828f98c) Refactoring database connection.
- [`cd609d9`](https://github.com/gamerlogue/web/commit/cd609d9b39888f2958c364f80a2eab2279fa6c6b) Refactoring database layer.
- [`bae9553`](https://github.com/gamerlogue/web/commit/bae9553aac6f39c9003953ba505fec0dd80624a8) Refactoring router route delegation.
- [`2fae372`](https://github.com/gamerlogue/web/commit/2fae372c5951816f6d846788c9d3fb1008f2b912) Refactoring routing classes.
- [`15449c3`](https://github.com/gamerlogue/web/commit/15449c34b1b7fab8b10fb022c39fc517f03efaef) Refactoring database layer.
- [`49c9094`](https://github.com/gamerlogue/web/commit/49c9094f32560133db048b092a1802dceed88f5a) Refactored session and added unit tests for manager and driver.
- [`5a9696d`](https://github.com/gamerlogue/web/commit/5a9696da7739eae398dc7ff1e538bf99d9ffb0bc) Refactoring session for better architecture.
- [`de2eabd`](https://github.com/gamerlogue/web/commit/de2eabdf7995f1ac721c96494ab9ac8ca0019422) Refactoring session and wrote tests for session manager.
- [`77dc8d2`](https://github.com/gamerlogue/web/commit/77dc8d2014f990f9350bf2baad31a684e4cbb257) Refactoring various things.
- [`32391b7`](https://github.com/gamerlogue/web/commit/32391b7f32caa97349530062130b507227977095) Refactoring various classes.
- [`82f3784`](https://github.com/gamerlogue/web/commit/82f3784d2b5c8867f7ec0f071b3f9b8241351af8) Refactored and comment route loader.
- [`096280c`](https://github.com/gamerlogue/web/commit/096280c95878bd2940c04ce1d6c26ff0621465bc) Refactoring route loader and router.
- [`47db2ff`](https://github.com/gamerlogue/web/commit/47db2ff19ba9694608e57a129acd3c814905effa) Refactoring, added uri class.
- [`0c4018e`](https://github.com/gamerlogue/web/commit/0c4018ec88e25fcd1d8d71a6172c32d64a6229ad) Refactoring.
- [`bd4fe88`](https://github.com/gamerlogue/web/commit/bd4fe8838c431fd6d18ebaffe4f88537f37afdb6) Refactoring the view class.
- [`d9201be`](https://github.com/gamerlogue/web/commit/d9201be431672c1d77edc562c30128565e669e13) Refactoring view compilation.
- [`c6f9734`](https://github.com/gamerlogue/web/commit/c6f973460390ac16f93b4b2486981a06698f7d93) Refactoring.
- [`54c69d8`](https://github.com/gamerlogue/web/commit/54c69d8c9fa5f9654b6944316dfc9a38e827bae4) Refactoring.
- [`9c319ba`](https://github.com/gamerlogue/web/commit/9c319ba0fc39d7b1517dfc83bf38f3a290189f2c) Refactoring database layer.
- [`5cc7c3a`](https://github.com/gamerlogue/web/commit/5cc7c3a6bd797136bf5a4bd8df7a9e88becc7471) Refactoring.
- [`442904b`](https://github.com/gamerlogue/web/commit/442904b277c6d25567baee65cc2cf8250b7536f5) Refactoring.
- [`3c05f72`](https://github.com/gamerlogue/web/commit/3c05f7260c6b9021fa68ddf33aeb0e44d554ecaa) Refactoring string class.
- [`14186a0`](https://github.com/gamerlogue/web/commit/14186a00e0478e61b6d5380d32443d4ad489cf91) Refactoring and bug fixes.
- [`21592ec`](https://github.com/gamerlogue/web/commit/21592ec67f9c2a53f5f97694c3a8bba2c305f2c2) Refactoring and tweaking.
- [`52b68c0`](https://github.com/gamerlogue/web/commit/52b68c060bed09258f43435f5e48a17fcbf19512) Refactoring. adding back pagination.
- [`71b0ab8`](https://github.com/gamerlogue/web/commit/71b0ab8b8d482afee92777d8bf6a002c7359481f) Refactoring container for speed.
- [`bcb6f18`](https://github.com/gamerlogue/web/commit/bcb6f189f70b4af9c90016bd45e17eb7ee6609fa) Refactored bcrypt hashing engine.
- [`8ba0dfa`](https://github.com/gamerlogue/web/commit/8ba0dfacc792420f215f728cc0b1d5120d85b53a) Refactoring controller __get magic method ioc resolution.
- [`b7b5451`](https://github.com/gamerlogue/web/commit/b7b5451a7f0fd881ff29a91512bba626879bf5f4) Refactoring session handling.
- [`6cb79e6`](https://github.com/gamerlogue/web/commit/6cb79e66766d00285fd3460dc1ba3600e1b81a2a) Refactoring
- [`392caee`](https://github.com/gamerlogue/web/commit/392caeed9171e7ee21b02c64a2062853d6a7c592) Refactoring formatting.
- [`b3c9dc5`](https://github.com/gamerlogue/web/commit/b3c9dc59c09e5024bc2303c7b88070f22b95e886) Refactoring testing setup.
- [`7317b58`](https://github.com/gamerlogue/web/commit/7317b5857b2583b5b79ac4848e33232583b758e1) Refactored welcome pages.
- [`8846110`](https://github.com/gamerlogue/web/commit/8846110e8d7b0b1730f08a320317f6261b66b5ab) Refactored and prettified the default database grammar.
- [`4342f82`](https://github.com/gamerlogue/web/commit/4342f82aa91348a63b53cc77c42b6de9c579ddce) Refactoring cache and session classes.
- [`f68a918`](https://github.com/gamerlogue/web/commit/f68a918d6988ee748e4aabab8011f3b3e8db2f45) Refactoring session classes.
- [`3998066`](https://github.com/gamerlogue/web/commit/3998066eb7aa5b2385e16c91aa37509385248b6a) Refactored session tests.
- [`9fa69e0`](https://github.com/gamerlogue/web/commit/9fa69e084418efa97c24c2d0e5c6f8575e4571b6) Refactoring routing and class comments.
- [`a6eaa06`](https://github.com/gamerlogue/web/commit/a6eaa069810e0d100a9e660ae646974992e245b8) Refactoring routing and comments.
- [`76a5bc4`](https://github.com/gamerlogue/web/commit/76a5bc483a916d4b2d20382920b6c03728a39ca6) Refactoring various classes.
- [`87e8dbe`](https://github.com/gamerlogue/web/commit/87e8dbeb32e08d8bed2e9f329e74b2a189780c2c) Refactoring database query class.
- [`8bd6d34`](https://github.com/gamerlogue/web/commit/8bd6d34622f59120a929d029b80ff414b9b0766d) Refactoring validator.
- [`9fc9f88`](https://github.com/gamerlogue/web/commit/9fc9f88a41600596d3a9e5328ae61044dd36eb2d) Refactoring various pieces of the framework.
- [`df9130d`](https://github.com/gamerlogue/web/commit/df9130dafa4c7f44dbc19e9b589793cfb76000da) Refactoring and working on redis.
- [`21dccae`](https://github.com/gamerlogue/web/commit/21dccae75552ca52eed4f47dc2df1091dc3de669) Refactor sqlite connector to accept path in constructor.
- [`49b13e6`](https://github.com/gamerlogue/web/commit/49b13e69606ce4647056c12c6eb938308c6811e1) Refactoring lang and url classes.
- [`0be75fc`](https://github.com/gamerlogue/web/commit/0be75fc2d9fef4996f32efb890221fbfc9da53aa) Refactoring the crypter class.
- [`8d3151b`](https://github.com/gamerlogue/web/commit/8d3151b1341f862927bb129ad065ab1432f5262b) Refactoring the crypter class.
- [`80f810d`](https://github.com/gamerlogue/web/commit/80f810de241e87a927ba00094626b591b98d66aa) Refactoring the crypter class.
- [`d4ddb05`](https://github.com/gamerlogue/web/commit/d4ddb05abbfd25f8a016e5021b6f303861686692) Refactoring. added default controller. added uri class.
- [`a6d487e`](https://github.com/gamerlogue/web/commit/a6d487ecd407988a793855c8bddcb9691ad23a78) Refactoring the uri class.
- [`bd66958`](https://github.com/gamerlogue/web/commit/bd6695844e47e9b0bddea749275e462cfb11e8af) Refactoring.
- [`bf50b67`](https://github.com/gamerlogue/web/commit/bf50b67475dbf5091850b1bc84ae061f7741c65e) Refactoring the uri class.
- [`bce571b`](https://github.com/gamerlogue/web/commit/bce571bf2603dc7ed7a81b2b2e6eda458ec04bbe) Refactoring the uri class more.
- [`e454227`](https://github.com/gamerlogue/web/commit/e454227d32a5cedd423755d42e7d7bc93e90a7ae) Refactoring the uri class more.
- [`8595253`](https://github.com/gamerlogue/web/commit/8595253afe8baff89147a82a4b54df4798e64135) Refactoring the uri class... again
- [`7bf8406`](https://github.com/gamerlogue/web/commit/7bf84066bf0417203ca851ab2f50f9cbd80630c0) Refactoring. added redis drivers.
- [`bb2cd3e`](https://github.com/gamerlogue/web/commit/bb2cd3e3739b1c502211366ce77a698644dec375) Refactoring the auth class.
- [`faaea17`](https://github.com/gamerlogue/web/commit/faaea17fd3e28ad43fa7a8ae2b605487787eabf8) Refactoring the validator.
- [`932a70b`](https://github.com/gamerlogue/web/commit/932a70b6cf3d9679dc10c8dc866dd33436b9381e) Refactoring for better dependency injection on a few classes.
- [`92694da`](https://github.com/gamerlogue/web/commit/92694da3a3306c04e6cf2729d7a3417ecb94a269) Refactoring.
- [`f824cc0`](https://github.com/gamerlogue/web/commit/f824cc0f43c2dad4f178aec36fd0cc865d785f57) Refactoring the uri method.
- [`d44c076`](https://github.com/gamerlogue/web/commit/d44c076ebfbaf0d0d3fd4cbc5dea58ab923372b9) Refactoring the autoloader.
- [`a0bbc9d`](https://github.com/gamerlogue/web/commit/a0bbc9d4727b42ce8f7baeea478aeb3cfca2c684) Refactoring the auto loader.
- [`c0c8108`](https://github.com/gamerlogue/web/commit/c0c8108399d8c8c2fe761dd357cfae01f4f8c8ba) Refactoring the autoloader.
- [`82b7516`](https://github.com/gamerlogue/web/commit/82b75166ac7269c4bfa06d18034a7124c8e84189) Refactor the library detection in the autoloader.
- [`06bf0a4`](https://github.com/gamerlogue/web/commit/06bf0a40a67004a52c3dd1d9291a5df06f146c88) Refactoring the session payload.
- [`83d927c`](https://github.com/gamerlogue/web/commit/83d927c4f19f266f9afdf632c6afda4b507b75e2) Refactoring.
- [`88c8cf6`](https://github.com/gamerlogue/web/commit/88c8cf6c1041f6eafe8eec55769d7573c7e69093) Refactoring.
- [`2e1fed2`](https://github.com/gamerlogue/web/commit/2e1fed294f86a6434192fadf8640d4856e7c4fe6) Refactoring bootstrapping.
- [`6048d20`](https://github.com/gamerlogue/web/commit/6048d20921116e8c2ff5664c6458abe9c2836c5b) Refactoring the session class.
- [`2c108a9`](https://github.com/gamerlogue/web/commit/2c108a91881f82937af49bea95b069111a5bf320) Refactoring the filters.
- [`3854165`](https://github.com/gamerlogue/web/commit/38541655953ee7dbde98e728a61a22f7123b5669) Refactoring autoloader.
- [`c67a010`](https://github.com/gamerlogue/web/commit/c67a010c5c63b8b28224c8b40d4592d9f24b2ba9) Refactoring some classes.
- [`0a2c61e`](https://github.com/gamerlogue/web/commit/0a2c61ec29fb914478627707b9d4a5062c5f4aa2) Refactoring error handling.
- [`41ca816`](https://github.com/gamerlogue/web/commit/41ca8169513f69338b9618998ddbd96c35cf8de5) Refactoring the blade class.
- [`e226a46`](https://github.com/gamerlogue/web/commit/e226a463bf2914c563ea874a653312d8a3d6969e) Refactoring.
- [`bbffa96`](https://github.com/gamerlogue/web/commit/bbffa96c2d21285b4a287b4198aab03754a70b92) Refactoring the auth login method. allow the developer to just pass an integer.
- [`994949c`](https://github.com/gamerlogue/web/commit/994949c6ceccdc28d428ae1d0e58413da57b8d46) Refactoring various classes.
- [`ccb6bc6`](https://github.com/gamerlogue/web/commit/ccb6bc6b8ab59b04c2f85fbff0b0d3ee9062df93) Refactoring the input class.
- [`5f348b2`](https://github.com/gamerlogue/web/commit/5f348b2c6e20546f051dd3da95312b3ea90e45db) Refactoring various classes.
- [`1535eca`](https://github.com/gamerlogue/web/commit/1535eca1c9a2cdbe03b655f4fbc7035db30641a6) Refactoring pagination.
- [`927e675`](https://github.com/gamerlogue/web/commit/927e675cb8359ad22860b68fc2b429d3520f77d5) Refactor the paginator to reincorporate the google style slider.
- [`dae2839`](https://github.com/gamerlogue/web/commit/dae283943fed8639236fb30ef9127eb0bcc74cc9) Refactor the validate required method for clarity.
- [`ba1d2a6`](https://github.com/gamerlogue/web/commit/ba1d2a62380c1771699cd8e0546bca60c0ced483) Refactoring the file::is method.
- [`8cfb6d6`](https://github.com/gamerlogue/web/commit/8cfb6d621c7a7d7e113264366e09b3a70a558798) Refactoring the cli.
- [`33d62e7`](https://github.com/gamerlogue/web/commit/33d62e77534ae7a6db2734d8b569fedf45641a77) Refactoring the autoloader.
- [`d3d3ffc`](https://github.com/gamerlogue/web/commit/d3d3ffc168e1df0b7e3a895b008d1a5ca710a49b) Refactoring.
- [`7aecd78`](https://github.com/gamerlogue/web/commit/7aecd7857fc01ecc76fdf15e135929e166a60a18) Refactoring the router.
- [`ad24b08`](https://github.com/gamerlogue/web/commit/ad24b08b298b1fbeb4bfd8701f2e8754ed30060a) Refactor the validation replacement code.
- [`60f61f3`](https://github.com/gamerlogue/web/commit/60f61f318b0a1e7ccf3897382c0aeb4688eec425) Refactored authentication system.
- [`5f97030`](https://github.com/gamerlogue/web/commit/5f97030ce8a7b3490c77f820d30ab4434a937795) Refactored set_format to foromat.
- [`726866e`](https://github.com/gamerlogue/web/commit/726866ee08358ad4bdafaacb010a6457faf4bbaf) Comment out exception handling logic in app.php
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e9c605e7e155a91dcee6bc4dd72569a58e544bb1"><code>e9c605e</code></a> <b>core:</b> :fire: Remove Vite configuration</summary>

  > This commit removes the Vite configuration and related files.
  >
  > - Removes `app.js`, `bootstrap.js`, and `vite.config.js`.
  > - Simplifies the project structure.
  >
  > This change is part of a larger refactoring effort.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e05680151bc002d3bc55f3c7bca48cd15db8b226"><code>e056801</code></a> <b>lang-af:</b> 🌐 Refactor Afrikaans translation for &#x27;OK&#x27;</summary>

  > Change the Afrikaans translation of "OK" from "Ok" to "Goed" to use a more appropriate and natural term in the language.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a7fee6e6dac6af06a5418a1ded4255916d8e34a4"><code>a7fee6e</code></a> <b>vite:</b> 🔧 Align SSL certificate paths with XDG_DATA_HOME</summary>

  > Updates the paths to adhere to the XDG Base Directory Specification. Using XDG_DATA_HOME for configuration files ensures better compliance with modern Linux standards for user-specific data.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fc85d11844466110b35d33f86a26562973f7a156"><code>fc85d11</code></a> <b>docker:</b> 🏗️ Streamline Dockerfile with dedicated dev and prod stages</summary>

  > This commit introduces a significant refactoring of the Dockerfile structure to improve separation between development and production environments. By creating distinct `base`, `dev`, and `prod-base` stages, we aim to:
  > * Reduce the final production image size by separating build tools and development-only dependencies.
  > * Enhance clarity and maintainability of the Dockerfile configurations.
  > * Provide a more consistent and flexible user management system across environments, aligning with Laravel Sail's `WWWUSER` for development and a dedicated `laravel` user for production.
  > * Improve observability by enabling Caddy access logging and providing a utility script to parse its JSON output.
  > * Ensure immediate log output from supervised processes in development through the use of `unbuffer`.
  > * Optimize the development experience with dedicated PHP.ini settings for opcache and JIT.
  >
  > This refactor lays the groundwork for more robust and efficient container deployments.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ef3a1757a9a5d2f3d819639d1b6922f65fe53d66"><code>ef3a175</code></a> ♻️ Refactor admin email access to use config helper</summary>

  > This change updates how the `ADMIN_EMAIL` environment variable is accessed by routing it through the `config()` helper instead of direct `env()` calls. This centralizes environment variable access within the `config/app.php` file, promoting better maintainability and consistency. It also allows for defining default values and benefits from Laravel's configuration caching, which enhances performance in production environments.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/eecf548568cbca41e10aa5eb72b5f03ff06eacd1"><code>eecf548</code></a> <b>locale:</b> 🔧 Use LaravelLang to retrieve available locales</summary>

  > This change replaces the manual file system scan for available locales with the `LaravelLang\Locales` package. This provides a more robust and reliable method for discovering installed languages, ensuring better consistency and reducing the potential for errors compared to directly checking JSON files in the `lang` directory. It leverages a dedicated package designed for locale management within Laravel, offering a more maintainable approach.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b5056dfc820b8d7d1ec776b1219d3a2ddb78a0e9"><code>b5056df</code></a> <b>bootstrap:</b> 🔥 Remove DenormalizeIriMiddleware import</summary>

  > The `DenormalizeIriMiddleware` is no longer utilized by the application. Removing its import cleans up the bootstrap configuration and eliminates an unnecessary dependency.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9cf8cd075bbab3c8ea75caf10c2f92c55dff70d8"><code>9cf8cd0</code></a> <b>scripts:</b> 🚚 Rename Octane server script to .sh</summary>

  > This change explicitly communicates the file's type as a shell script. It improves clarity for developers and enhances compatibility with tools that rely on file extensions for proper identification and processing.

  </details>
- [`83a0871`](https://github.com/gamerlogue/web/commit/83a0871545300594072827e8d93abfeeab4f16dd) ♻️ extract Symfony serializer boilerplate to DecoratesSerializer trait
- <details><summary><a href="https://github.com/gamerlogue/web/commit/242f65b84459f49f81cfad64be21eca0e8670862"><code>242f65b</code></a> <b>core:</b> ♻️ Rename .sitekit.json to .sitekit.yaml</summary>

  > This commit renames the configuration file to use YAML.
  >
  > - Standardizes configuration format to YAML for consistency.
  > - Improves readability and maintainability.
  >
  > No breaking changes.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9c523c1b5dd3abb8f88e7bf321bc8ff836dba1a1"><code>9c523c1</code></a> <b>core:</b> ♻️ Improve activate.fish script</summary>

  > This commit refactors the `activate.fish` script for better compatibility and clarity.
  >
  > - Adds a check to prevent direct execution of the script.
  > - Updates the `deactivate` function to correctly reset environment variables and aliases.
  > - Enhances prompt handling for fish shell.
  >
  > This ensures the script functions as intended when sourced and avoids potential issues.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9e6fc731914514c3ec99bef28126d752344b1047"><code>9e6fc73</code></a> <b>core:</b> 🐛 Improve container startup script</summary>

  > This commit fixes several issues in the `start-container` script:
  >
  > - Uses `set -eu` for stricter error handling.
  > - Adds quotes to variable expansions to prevent word splitting.
  > - Fixes running migrations.
  > - Refactors the script for better readability and maintainability, including the function `initial_setup` and `run_supervisord`.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/dca6b2852a9136cff19fabe9a56294e46b726312"><code>dca6b28</code></a> <b>caddy:</b> ♻️ Refactor Caddyfile for logs and routing</summary>

  > This commit refactors the Caddyfile for improved logging and routing configurations.
  >
  > - Updates logging format and output paths.
  > - Simplifies routing and adds static file serving.
  > - Modernizes configuration directives.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/4b9fcf1309e16bae01e65caa253a96c62c4a0b4b"><code>4b9fcf1</code></a> <b>core:</b> ♻️ Update docker-compose config</summary>

  > Refactors docker-compose configuration for improved maintainability and consistency.
  >
  > - Updates compose files to reference `compose.common.yaml`.
  > - Migrates configuration for ports, environment, depends_on, and healthcheck to common file.
  > - Updates README to use `compose.prod.yaml` for production.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/70214624fc001706e389ce270f14691e4f3c2018"><code>7021462</code></a> <b>core:</b> ♻️ Update docker-compose config</summary>

  > Refactors docker-compose configuration for improved maintainability and consistency.
  >
  > - Updates compose files to reference `compose.common.yaml`.
  > - Migrates configuration for ports, environment, depends_on, and healthcheck to common file.
  > - Updates README to use `compose.prod.yaml` for production.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fa45936272b9be754761c872432e07bfe1c1f4da"><code>fa45936</code></a> <b>compose:</b> 🔥 remove memcached service</summary>

  > The Memcached service is redundant for a default template configuration since Redis is already included and can be used for caching.
  >
  > This change simplifies the Docker setup, reduces resource usage, and lowers the barrier to entry for new projects. Laravel defaults to the `file` cache driver, so this removal does not affect out-of-the-box functionality.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e7e366f0f35e0c5b0b903cde4c34753cebab5e52"><code>e7e366f</code></a> <b>vite:</b> ♻️ Reorder plugins and refactor imports</summary>

  > Move the `laravel` plugin to be the first one initialized to ensure it sets up the base configuration before other plugins are applied. This improves the predictability of the build process.
  >
  > Additionally, the `PluginOption` import is updated to be a type-only import for better TypeScript hygiene.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/29bf444d943a6c93dc28ebf75a7772dee678ef97"><code>29bf444</code></a> <b>docker:</b> ♻️ use multi-stage build for PHP extensions</summary>

  > This refactoring introduces a multi-stage Docker build to separate the compilation of PHP extensions from the final application images.
  >
  > Using a dedicated `ext-builder` stage significantly reduces the final image size by excluding build-time dependencies like compilers and `-dev` packages. It also improves build cache efficiency.
  >
  > The PHP base image is switched to the `-zts` (Zend Thread Safety) variant, which is required for modern, threaded PHP servers like FrankenPHP.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f91d7a5a41d0805d00bdefd738691b742799c35b"><code>f91d7a5</code></a> <b>docker:</b> ♻️ Remove WAYFINDER_WORKAROUND env variable</summary>

  > The environment variable was a temporary workaround for a build issue that has since been resolved, making this configuration obsolete.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a251f5dbecd8391cc1828fc8350dcf70dfb641da"><code>a251f5d</code></a> <b>docker:</b> ♻️ Use default XDG base directories</summary>

  > Removing the custom XDG environment variables simplifies the container configuration. This change allows tools to use their default paths within the user's home directory, which is a more standard and robust approach for containerized applications. It also prevents cluttering the main application directory with cache and config files.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c98891bf87584723a4bbbcaf5b13d7e000fe995c"><code>c98891b</code></a> ♻️ reorganize and reintroduce JIT config in Dockerfile</summary>

  > - Removed JIT-related configurations from the main ENV block and reintroduced them under AUTORUN_ENABLED for better grouping.
  > - Improved structure and clarity of Dockerfile configuration.

  </details>
- [`65f2210`](https://github.com/gamerlogue/web/commit/65f22105bd3f105676d0fdaa8c64692e1be2c45d) **app:** ♻️ update LogViewer auth callback to use admin email config
- [`bb810d8`](https://github.com/gamerlogue/web/commit/bb810d860824c6fc906799ed687b581c0d1a0f81) **vite:** ♻️ use node:path resolve in Vite configuration
- <details><summary><a href="https://github.com/gamerlogue/web/commit/95727b03c5277bdb317ea2033c063bbd82b42aec"><code>95727b0</code></a> ♻️ validate locales through Locales::isAvailable</summary>

  > The available-locale list was built in two places: cached for a day in the
  > middleware, recomputed on every request in the form request. The form request
  > asks the package directly instead.
  >
  > The middleware caches a plain array rather than a Collection: with
  > cache.serializable_classes set to false, a serialized object comes back as
  > __PHP_Incomplete_Class, which is what the "incomplete object" errors in the logs
  > were. The cache key is bumped accordingly.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/75b194abb77b520eb17b62b5998343675d91048a"><code>75b194a</code></a> ♻️ resolve JSON:API types from the resource metadata</summary>

  > buildIri matched the type against a hardcoded list of two classes, so every new
  > resource had to be added by hand. The mapping now comes from the short names API
  > Platform already knows, memoized per instance.
  >
  > An unknown type raises NotNormalizableValueException rather than
  > UnexpectedValueException, which turns it into a 422 through the existing mapping
  > instead of a 500.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a9c61bbad9cf86531b6fb5d1c1e66d7284e508fb"><code>a9c61bb</code></a> <b>auth:</b> 🔥 drop Fortify, since OIDC is the only way in</summary>

  > The guard is oidc, but Fortify kept registering registration, password reset,
  > two-factor and passkey routes that nothing could reach. No PHP file referenced
  > it and no frontend source imported the Wayfinder functions it generated, so
  > removing the package took laravel/passkeys with it and left nothing behind.
  >
  > One frontend site did depend on it: UserPopout imported the `logout` route that
  > Fortify registered, through the ~/routes barrel. It now points at oidc.logout,
  > and navigates rather than using router.visit — oidc.logout lands on
  > redirect_path_after_logout, a plain response Inertia would reject, and leaving
  > the SPA is the right semantics for a logout anyway.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/aab558550b9a1eff3ed3082e74a469c01f30a7e1"><code>aab5585</code></a> <b>DiscordProjectSettings:</b> 🔄 remove unused options from project settings</summary>

  > - Cleaned up the DiscordProjectSettings component by removing unnecessary options.
  > - This simplifies the configuration and improves maintainability.

  </details>
- [`b9cc615`](https://github.com/gamerlogue/web/commit/b9cc615d56c29a761b23a3101bf3bda27741931a) **auth:** ♻️ extract refresh token listeners
- <details><summary><a href="https://github.com/gamerlogue/web/commit/259cd53dff1761acc376e0cc01d4e457f62437a4"><code>259cd53</code></a> <b>api:</b> ♻️ migrate JSON:API serializer decorators to API Platform 5</summary>

  > API Platform 5 emits plain JSON:API ids (`use_iri_as_id` now defaults
  > to false) and string error statuses natively, so the decorators that
  > did both are gone. Denormalization moved to `ItemDenormalizer`, which
  > left the `type` check unreachable and accepted a mismatched type with
  > 200: it now lives in a decorator of that class and answers 409 Conflict,
  > as the JSON:API spec requires, instead of 422.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2d2687944b0f1641660ea3d7c35e655578b94ce1"><code>2d26879</code></a> <b>requests:</b> 🔧 remove unnecessary &#x27;relationships&#x27; validation rules from request classes</summary>

  > - Simplified validation rules in multiple request classes by removing 'data.relationships' entries that were not needed.
  > - This change enhances code clarity and maintainability.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0809274031393c645ff250c7ce2d87a6fa785588"><code>0809274</code></a> <b>core:</b> ♻️ Rename .sitekit.json to .sitekit.yaml</summary>

  > This commit renames the configuration file to use YAML.
  >
  > - Standardizes configuration format to YAML for consistency.
  > - Improves readability and maintainability.
  >
  > No breaking changes.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d90153db3de0f0eada356284a320cca29ccffe74"><code>d90153d</code></a> <b>core:</b> ♻️ Improve activate.fish script</summary>

  > This commit refactors the `activate.fish` script for better compatibility and clarity.
  >
  > - Adds a check to prevent direct execution of the script.
  > - Updates the `deactivate` function to correctly reset environment variables and aliases.
  > - Enhances prompt handling for fish shell.
  >
  > This ensures the script functions as intended when sourced and avoids potential issues.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cff637b778871232d7844bd6378482aabc4b4ceb"><code>cff637b</code></a> <b>core:</b> 🐛 Improve container startup script</summary>

  > This commit fixes several issues in the `start-container` script:
  >
  > - Uses `set -eu` for stricter error handling.
  > - Adds quotes to variable expansions to prevent word splitting.
  > - Fixes running migrations.
  > - Refactors the script for better readability and maintainability, including the function `initial_setup` and `run_supervisord`.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/208926f2bc819f675c29feca96dbcbdae39fbe06"><code>208926f</code></a> <b>caddy:</b> ♻️ Refactor Caddyfile for logs and routing</summary>

  > This commit refactors the Caddyfile for improved logging and routing configurations.
  >
  > - Updates logging format and output paths.
  > - Simplifies routing and adds static file serving.
  > - Modernizes configuration directives.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/03ff0015076d44318c4f0fa843e04cfd474b015b"><code>03ff001</code></a> <b>core:</b> ♻️ Update docker-compose config</summary>

  > Refactors docker-compose configuration for improved maintainability and consistency.
  >
  > - Updates compose files to reference `compose.common.yaml`.
  > - Migrates configuration for ports, environment, depends_on, and healthcheck to common file.
  > - Updates README to use `compose.prod.yaml` for production.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/86d5041329562ecf0595ffdb1f15227f16bf069a"><code>86d5041</code></a> <b>core:</b> ♻️ Update docker-compose config</summary>

  > Refactors docker-compose configuration for improved maintainability and consistency.
  >
  > - Updates compose files to reference `compose.common.yaml`.
  > - Migrates configuration for ports, environment, depends_on, and healthcheck to common file.
  > - Updates README to use `compose.prod.yaml` for production.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/899c70c03c30b58553594408d393d11885f417f4"><code>899c70c</code></a> <b>compose:</b> 🔥 remove memcached service</summary>

  > The Memcached service is redundant for a default template configuration since Redis is already included and can be used for caching.
  >
  > This change simplifies the Docker setup, reduces resource usage, and lowers the barrier to entry for new projects. Laravel defaults to the `file` cache driver, so this removal does not affect out-of-the-box functionality.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ae2810f692769d9414e218d65bc159eaad0a7ba0"><code>ae2810f</code></a> <b>vite:</b> ♻️ Reorder plugins and refactor imports</summary>

  > Move the `laravel` plugin to be the first one initialized to ensure it sets up the base configuration before other plugins are applied. This improves the predictability of the build process.
  >
  > Additionally, the `PluginOption` import is updated to be a type-only import for better TypeScript hygiene.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fa4bdc18fea8d0f1a358f53c6a1868412006abdb"><code>fa4bdc1</code></a> <b>docker:</b> ♻️ use multi-stage build for PHP extensions</summary>

  > This refactoring introduces a multi-stage Docker build to separate the compilation of PHP extensions from the final application images.
  >
  > Using a dedicated `ext-builder` stage significantly reduces the final image size by excluding build-time dependencies like compilers and `-dev` packages. It also improves build cache efficiency.
  >
  > The PHP base image is switched to the `-zts` (Zend Thread Safety) variant, which is required for modern, threaded PHP servers like FrankenPHP.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c92e78b461ff3b04dc34725e57b8ce7d3cb71e42"><code>c92e78b</code></a> <b>docker:</b> ♻️ Remove WAYFINDER_WORKAROUND env variable</summary>

  > The environment variable was a temporary workaround for a build issue that has since been resolved, making this configuration obsolete.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/84325dc4b5cb25577c726d2188c29b99fb8234b6"><code>84325dc</code></a> <b>docker:</b> ♻️ Use default XDG base directories</summary>

  > Removing the custom XDG environment variables simplifies the container configuration. This change allows tools to use their default paths within the user's home directory, which is a more standard and robust approach for containerized applications. It also prevents cluttering the main application directory with cache and config files.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b24d48ad9f66c139d33377ebdc8ecc8eb909a147"><code>b24d48a</code></a> ♻️ reorganize and reintroduce JIT config in Dockerfile</summary>

  > - Removed JIT-related configurations from the main ENV block and reintroduced them under AUTORUN_ENABLED for better grouping.
  > - Improved structure and clarity of Dockerfile configuration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d304b72e7076316589a8eb7a3161a01ed58c86b6"><code>d304b72</code></a> ♻️ ship the Caddy global log options in the image</summary>

  > The frankenphp.log logger lived in the Compose CADDY_GLOBAL_OPTIONS, so Kubernetes never wrote it. It now sits in deployment/global.caddyfile, imported the same way as site.caddyfile.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/765fd8ea792f1e19ef9967b22623d90aa4d02431"><code>765fd8e</code></a> 🔧 load .env through env_file only in production Compose</summary>

  > In dev the project is bind-mounted and Laravel loads .env itself, so only
  > the variables read outside PHP are passed to the container. The production
  > image ships without .env, so compose.prod.yaml keeps env_file.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c8572b87252621d336252f7babc27df05fe38171"><code>c8572b8</code></a> ♻️ load site.caddyfile from caddyfile-server.d</summary>

  > Octane overwrites CADDY_SERVER_EXTRA_DIRECTIVES, so config/octane.php
  > had to forward it through octane.caddy.env. The v5 folder is imported by
  > glob regardless, so the env var and the forwarding go; the symlink keeps
  > dev edits live through the bind mount.

  </details>

### 📝 Docs changes

- [`bf32b6f`](https://github.com/gamerlogue/web/commit/bf32b6f6ca47ec578dcffcceee172ceb09270721) Docs bundle in progress
- [`b28c5eb`](https://github.com/gamerlogue/web/commit/b28c5eb19f2ec7941522b6289f02e543c0ed7d1b) Docs edit: eager loading using $includes in model
- [`24761d2`](https://github.com/gamerlogue/web/commit/24761d24d53ccc5843794c17576d531373d8c34d) 📝 Updated README
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cfdb51274b00b38c720945de1f53c3af15b874ec"><code>cfdb512</code></a> <b>readme:</b> 📝 Add pre-commit setup instructions</summary>

  > This commit adds instructions for setting up pre-commit hooks.
  >
  > - Added badges and requirements sections.
  > - Explained how to install pre-commit.
  > - Included commands to run pre-commit.

  </details>
- [`7f2ac07`](https://github.com/gamerlogue/web/commit/7f2ac078d522d166fa4d17f46c54591b8e9e5230) 📝 Add troubleshooting section for webserver startup issues in README
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6e20f712550dd0bfc297af8a360b6d03116171b7"><code>6e20f71</code></a> 💡 add deployment decisions documentation</summary>

  > - Documented architectural decisions regarding Docker/Compose/Vite setup.
  > - Explained the rationale behind using specific configurations for Caddy and Octane.
  > - Provided insights on build processes, observability, and security considerations.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1ab26823c8543712a4f66ba923a68ee49b072b43"><code>1ab2682</code></a> 📝 record the API Platform metadata pitfalls</summary>

  > Boot-time database introspection is what shapes the routes, so it explains both
  > the test bootstrap and why api-platform.cache has to stay on the array store,
  > and writes go through the serializer rather than the validated data.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1d4a231d441706b54f7c3edb3990f95891fd7bc7"><code>1d4a231</code></a> 📝 regenerate the agent guidelines</summary>

  > They declared Laravel 12, Pest 4 and PHPUnit 12 against a project on 13, 5 and
  > 13. The current Boost guidelines no longer list package versions at all —
  > they point at `composer show` instead — so the mismatch cannot come back.
  > GEMINI.md is not one of Boost's targets and was aligned by hand.

  </details>
- [`4346a75`](https://github.com/gamerlogue/web/commit/4346a753345aeadf532aa61ac3b7fa2998e52fae) **auth:** 📝 record the native token contract
- [`66fad07`](https://github.com/gamerlogue/web/commit/66fad07785f436bac05a9387e3a98bbf29f6c9aa) **api:** 📝 document the profile API contracts
- [`2987be3`](https://github.com/gamerlogue/web/commit/2987be3808670f5416ca2f1aacb3b548a700b006) **api:** 📝 document the list API contracts
- [`a518f66`](https://github.com/gamerlogue/web/commit/a518f663b14b4eb55e19589ab5a8d87b13021594) **api:** 📝 document the social API contracts
- [`62c50ba`](https://github.com/gamerlogue/web/commit/62c50ba033a876390eea2cb81c53004a9751577b) **api:** 📝 document the interaction API contracts
- [`3cfd7c9`](https://github.com/gamerlogue/web/commit/3cfd7c96f0b0cba37e6677c60611a174b1cf28d7) **api:** 📝 document the account API contracts
- [`25f5cb4`](https://github.com/gamerlogue/web/commit/25f5cb4381b43a95d078535081b42095c256ab29) 📝 record the profile section conventions
- [`ec167db`](https://github.com/gamerlogue/web/commit/ec167dbcde18fd9f631c2aad79c7ef4c516a05e2) 📝 Updated README
- <details><summary><a href="https://github.com/gamerlogue/web/commit/baa6dc6492c51af1170c48ca24ab664d380cbda9"><code>baa6dc6</code></a> <b>readme:</b> 📝 Add pre-commit setup instructions</summary>

  > This commit adds instructions for setting up pre-commit hooks.
  >
  > - Added badges and requirements sections.
  > - Explained how to install pre-commit.
  > - Included commands to run pre-commit.

  </details>
- [`c17a6a5`](https://github.com/gamerlogue/web/commit/c17a6a51dd848c62d6da8ccf45e4159431d5e33d) 📝 Add troubleshooting section for webserver startup issues in README
- <details><summary><a href="https://github.com/gamerlogue/web/commit/023404f10b9d48d15fd5fe19e385cfc26fd9da68"><code>023404f</code></a> 💡 add deployment decisions documentation</summary>

  > - Documented architectural decisions regarding Docker/Compose/Vite setup.
  > - Explained the rationale behind using specific configurations for Caddy and Octane.
  > - Provided insights on build processes, observability, and security considerations.

  </details>
- [`756b45d`](https://github.com/gamerlogue/web/commit/756b45d9368d324742e7f6ac8ced1f9ff4ca7462) 💡 say where the git-cliff output goes now
- [`ba0422f`](https://github.com/gamerlogue/web/commit/ba0422fceec261ef9527560b28b182d87f1267d5) 📝 add a merge request template
- [`a5be2d9`](https://github.com/gamerlogue/web/commit/a5be2d9ffc43e06f3f95eb6f68adb116fa4d4e83) 💡 say where the git-cliff output goes now
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1c593b16d5cd417eac30e1e2604fed98a24d9246"><code>1c593b1</code></a> 📝 rewrite the README as README.template.md</summary>

  > Projects built on the base keep README.md for themselves. It now covers what the base contains, the git hooks, the commit format, releases, and how to create or update a template.

  </details>
- [`4f719c3`](https://github.com/gamerlogue/web/commit/4f719c3e47888d536732a5eb6cda82588c92611e) 📝 say that the templates are not released or deployed
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8703d369d1f1520af18f713fbea8ff967fb73006"><code>8703d36</code></a> 📝 say that each template replaces README.template.md</summary>

  > Each template replaces it with its own README.template.md, linking back here for the common parts; when the base one changes, a template keeps its own version on pull.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/feb9f491a02373c10274e9185e7741e92eb135b8"><code>feb9f49</code></a> 📝 move the template docs to README.template.md and rewrite them</summary>

  > README.template.md now documents this template, replacing the base one; README.md is left to the websites built from it, and the common parts (hooks, commits, releases) stay in the base template's README. Diagram of the local stack, quick start, Sail commands, tests, debugging, GitLab TOC and alerts; outdated parts fixed (source bin/activate, bun instead of pnpm/npm).

  </details>
- [`2aaba3c`](https://github.com/gamerlogue/web/commit/2aaba3c92fc2d33a11e902744015e09e6b105a3c) 📝 list the environment variables a deployment needs
- [`eb0c8c1`](https://github.com/gamerlogue/web/commit/eb0c8c1d40e63d8d5000d80d1a97b3f328270570) 📝 document the database created by the deploy
- [`3520de6`](https://github.com/gamerlogue/web/commit/3520de6056a515d7fe0102193ee8cc756a4579e4) 🗑️ remove outdated README template
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f3bbbb36f37dde4c16b75b9ed06a6dbe67bc3cf4"><code>f3bbbb3</code></a> 📝 specify mention, followed-user activity and badge notifications</summary>

  > Adds the three notification types the client handles, still marked as not implemented on the server, and the Android channel each push goes to.

  </details>

### ✅ Tests

- [`917d4cb`](https://github.com/gamerlogue/web/commit/917d4cb1e48b1567ee7789bd1812ba5f1ff644dd) Testing database.
- [`3c7ddc7`](https://github.com/gamerlogue/web/commit/3c7ddc71fa538a4704fb1174bd305c29fb40d45a) ✅ add authorization tests for users and library entries
- [`bf942ba`](https://github.com/gamerlogue/web/commit/bf942ba596ac7685f530b71bd17fe6ae0ce67044) **igdb:** 🧪 enhance IGDB proxy feature test assertions and HTTP mocking
- [`4fdb069`](https://github.com/gamerlogue/web/commit/4fdb069ee272a6c93611fce642e17fc7259718e0) ♻️ share the jsonApiHeaders helper across feature tests

### 👷 Building scripts changes

- [`963426c`](https://github.com/gamerlogue/web/commit/963426cb9e48b12ad5d5f798a405c97af407dae8) Building on http foundation.
- [`731b9c2`](https://github.com/gamerlogue/web/commit/731b9c2de17523a82df4162b3b8d60b1629ee991) **Dockerfile:** 🏗️ Refactor to use dedicated stages for PHP extensions and frontend assets
- <details><summary><a href="https://github.com/gamerlogue/web/commit/310a1f384f516b8f575f62b2cfca3bff69d99d01"><code>310a1f3</code></a> 🏗️ Update Dockerfile build context file list</summary>

  > This update modifies the files copied into the Docker build context. The `patches`
  > directory is now explicitly included to ensure that project-specific
  > modifications and dependency patches are available during the build process.
  > Simultaneously, `tailwind.config.js` and `postcss.config.js` are removed from
  > this specific `COPY` operation, as they are either no longer required in this
  > context or are handled by other means.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/639ffc752003316333586607140237520fcbb3fb"><code>639ffc7</code></a> <b>Dockerfile:</b> 📦 Copy patches directory before pnpm install</summary>

  > Ensure patches are available in the build context before `pnpm install`.
  > This prevents issues where subsequent steps might depend on these
  > modifications, avoiding potential build failures.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/99d23f793f024f2652981e98ae2fbfc078b2632d"><code>99d23f7</code></a> <b>vite:</b> 🔧 Conditionally load Wayfinder plugin</summary>

  > The Wayfinder plugin is only necessary during local development to generate frontend routes. Loading it conditionally avoids unnecessary processing and potential overhead in production environments, optimizing the build process for different deployment targets.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/90ec9768944efe0b5e788b093bcaee5a4905ea00"><code>90ec976</code></a> <b>docker:</b> 📦 Standardize user&#x2F;group IDs and add Inertia modal vendor</summary>

  > Standardize user and group IDs by replacing `WWWUSER`/`WWWGROUP` with `UID`/`GID` variables. This enhances flexibility and security by allowing arbitrary user and group IDs to be configured at build or runtime, improving host system integration. Additionally, explicitly copy the `emargareten/inertia-modal` vendor directory to ensure all application assets are correctly included in the image, preventing runtime errors related to missing dependencies.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7449f2aecb1974512076b1d5599470c7e5bab467"><code>7449f2a</code></a> <b>deps:</b> 🐳 Switch database driver to MySQL</summary>

  > The application utilizes MySQL, not PostgreSQL. This change updates the Dockerfile to remove PostgreSQL development dependencies and the `pdo_pgsql` extension, replacing it with `pdo_mysql` to align with the actual database requirements.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9f7e60ed25bb2040ff0f8dba42cecdd7ebcd6e52"><code>9f7e60e</code></a> <b>deployment:</b> 🚀 Enhance Docker image and runtime configuration</summary>

  > This commit aims to create a more robust and performant deployment environment.
  > Docker image optimizations reduce build complexity and improve maintainability.
  > PHP configuration adjustments significantly boost application runtime performance
  > and support larger data transfers. Supervisord changes ensure more reliable
  > process control and graceful shutdowns, preventing data loss or unexpected
  > service interruptions. Caddyfile updates streamline local development by
  > removing certificate management overhead.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/821e5b094b52a05e549580ba6efec95cb24b331e"><code>821e5b0</code></a> 🗑️ Remove Vite configuration file</summary>

  > The `vite.config.js` file has been deleted as the project no longer uses Vite for its build process. This file was obsolete and is no longer required for development or production builds.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7850728acb6b0218f5f627bf2e83f9f6352a4893"><code>7850728</code></a> <b>deps:</b> 📦 Add phpdocumentor&#x2F;type-resolver and update dependencies</summary>

  > The 'phpdocumentor/type-resolver' dependency is added to support improved static analysis and type checking within the project. This enhances code quality and maintainability by providing robust type resolution capabilities. Other package updates reflect the latest compatible versions pulled during the dependency refresh.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ba30b5f3f52db2c77de611c5e3f2fa2218b80ba1"><code>ba30b5f</code></a> <b>dev:</b> ⚙️ Wait for PHP server before starting Vite</summary>

  > This change ensures that the Vite development server only starts after the backend PHP server is available. This prevents errors that occur when Vite tries to communicate with a non-existent or uninitialized backend, improving the reliability and consistency of the development environment startup process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0616ed237074b3ad9e7552e0aeec935f3940959f"><code>0616ed2</code></a> <b>deps:</b> 📦 Move Laravel Pail to production dependencies</summary>

  > Laravel Pail is a crucial tool for real-time log monitoring and debugging in production environments. Moving it from `require-dev` to `require` ensures its availability for operational tasks and enhanced observability on deployed instances, supporting faster issue diagnosis and system health checks.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d94e650bc869ec361ca20ebe8b6f1bbccfb464f2"><code>d94e650</code></a> <b>deps:</b> 📦 Migrate Laravel Lang to modular package setup</summary>

  > Replaces the monolithic `laravel-lang/common` package with individual components. This change aligns with the new modular structure of the Laravel Lang ecosystem, allowing for more granular control over included translation features and reducing unnecessary dependencies.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b0a4f8076572fb6ba0b51ecbf7d2639dac6bf991"><code>b0a4f80</code></a> <b>docker:</b> 🔨 Make Docker scripts executable and remove .sh extensions</summary>

  > This change ensures that shell scripts copied into `/usr/local/bin` within the Docker image are made directly executable. By removing the `.sh` file extension, script invocation becomes simpler and more aligned with standard Unix practices for command-line tools, improving usability and consistency within the container environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/41b00f415b3d8d48bcd5aad7b2ec894330eb84b4"><code>41b00f4</code></a> ⚡ Optimize Dockerfile for production and permissions</summary>

  > These changes enhance the Docker build process by explicitly managing file permissions and implementing production optimizations. Setting file ownership with `--chown` during `COPY` operations and running `composer install` as the designated user prevents runtime permission errors. The new `composer dump-autoload` step optimizes the application's autoloader for production, improving performance. This approach simplifies the Dockerfile by removing redundant `chown` commands and explicit cache mounts, relying on consistent ownership management.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2b4da9148307d42b7f399d00678af1bc8c838f37"><code>2b4da91</code></a> <b>docker:</b> 🐳 Configure API Platform build steps and assets in Dockerfile</summary>

  > These changes are necessary to correctly integrate API Platform into the Docker image. API Platform requires database migrations and asset publishing to function. A dummy SQLite database is introduced for running migrations during the build without needing a persistent database connection, which is then removed. Additionally, clearing Laravel's caches prevents potential conflicts and ensures API Platform's proper initialization within the built application.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/654351e9f979a313ff13ffbbbc1d4277e6d775d4"><code>654351e</code></a> <b>docker:</b> 🐳 Manage &#x2F;tmp permissions, cleanup, and cache ownership</summary>

  > Relocating the /tmp directory cleanup and permission setup ensures that these critical settings are applied consistently at the appropriate build stages. This prevents potential permission issues with temporary files and directories, especially after user switches or file copies that could alter their state. Explicitly setting the opcache-file-cache ownership guarantees the application has the necessary write permissions.

  </details>
- [`72788c9`](https://github.com/gamerlogue/web/commit/72788c90f8d2263aa88777ea72909c3fa9da3119) **composer:** 🔧 update laravel/boost dependency to version 2.0
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3ba3d302a18dc26970f36e0a6016b3df07ac53b0"><code>3ba3d30</code></a> <b>docker:</b> 🐳 copy entire project into Docker image</summary>

  > This change ensures the entire application context is available during the `composer install` step. This prevents potential build failures caused by composer scripts, such as `post-install-cmd`, that require access to the full project source code.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c7e268583065cae5d9a1ccbfcbd43d6460a14953"><code>c7e2685</code></a> <b>docker:</b> 🐳 Clear Composer cache during build</summary>

  > Clearing the Composer cache after installation ensures a clean build state.
  > This prevents potential issues with outdated or corrupted dependency
  > packages, leading to a more reliable and reproducible Docker image.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6c2cf88cf98f81e0c40747717c6ca7b66f710407"><code>6c2cf88</code></a> <b>docker:</b> 🔧 Copy patches before dependency installation</summary>

  > The pnpm patch mechanism requires the `patches/` directory to be available in the build context before `pnpm install` is executed.
  >
  > This change ensures the patch files are copied into the build stage, allowing pnpm to apply necessary fixes to node modules during the installation process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0abf33ea9d9343e3b9e8ba0e7efe2a7d5ad88a75"><code>0abf33e</code></a> <b>docker:</b> 🐳 include lang directory in frontend build</summary>

  > The frontend build process requires access to the language files to
  > correctly compile and bundle translations into the final assets. This
  > ensures that all necessary translation strings are available at runtime.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ff09da1d135a1d1c6ee908981c115200b916a8c2"><code>ff09da1</code></a> <b>docker:</b> 🐳 publish log viewer assets</summary>

  > The log viewer's user interface was unstyled and non-functional when running inside the Docker container.
  >
  > This was caused by its front-end assets not being published to the public directory during the image build. This change ensures the necessary assets are always present, making the tool fully operational in the production environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ca7e02184ad5135c7b739c35b8edf0dceee1e96e"><code>ca7e021</code></a> 🔧 Streamline dev setup with host caches and certs</summary>

  > The Vite configuration is updated to point to the standard Caddy certificate path in the user's home directory. This avoids the need to manage a separate set of certificates within the project and aligns with a more conventional local development setup.
  >
  > Additionally, host volumes for Composer/Node caches and Composer authentication are mounted into the service container. This improves performance by reusing cached dependencies across container restarts and enhances security by leveraging the host's credentials.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/950e4ce20d54e57b50048df6ec64a11bfd62e843"><code>950e4ce</code></a> <b>vite:</b> ⚙️ Run Wayfinder plugin only in local environment</summary>

  > The Wayfinder plugin is a development-only utility for route discovery. It is not required for the production build and its inclusion adds unnecessary overhead.
  >
  > This change ensures the plugin is only loaded in the local environment, keeping production builds leaner and more focused.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/90f6127967b125d4540229b572b0d791b280e7d5"><code>90f6127</code></a> <b>docker:</b> 🔧 remove unnecessary COPY command from Dockerfile</summary>

  > - Simplified the Dockerfile by removing the redundant COPY command for patches.
  > - This change helps streamline the build process and reduces image size.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2f501e2d1933037398e75188f03c8cc14b6a8640"><code>2f501e2</code></a> <b>docker:</b> 🔧 update home directory creation in Dockerfile</summary>

  > - Simplified the creation of home directories by removing unnecessary paths.
  > - Ensures proper ownership and permissions for user directories.

  </details>
- [`e9b1e12`](https://github.com/gamerlogue/web/commit/e9b1e12c6154de7f92a4f5be9d29ff5a1cb5d4fc) **changelog:** 📝 configure git-cliff for backend releases
- [`2542128`](https://github.com/gamerlogue/web/commit/2542128db11f03b2637c962b1ace7528a00263dc) 🔧 update Dockerfile to use updated non-dev base PHP image
- [`53a569e`](https://github.com/gamerlogue/web/commit/53a569efb3e881a71ba78716766650b733201575) 🔧 ignore abandoned Composer packages in Docker build
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ce32afd63851e1ad9f08b0305e3b28919c768e6d"><code>ce32afd</code></a> 🔧 serve plaintext HTTP on any host in the dev container</summary>

  > Caddy served plaintext only for the listed addresses (SERVER_NAME,
  > 10.0.2.2, localhost). Any other host, like the LAN IP a physical device
  > uses, fell into the HTTP->HTTPS redirect and then failed the TLS
  > handshake with an internal_error alert, since Caddy has no certificate
  > for a bare IP. A :80 catch-all replaces the per-address list; HTTPS on
  > SERVER_NAME keeps working for the browser.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/65ead6d57d018260c26b93e15427bb2734b4bb44"><code>65ead6d</code></a> <b>docker:</b> 🐳 copy entire project into Docker image</summary>

  > This change ensures the entire application context is available during the `composer install` step. This prevents potential build failures caused by composer scripts, such as `post-install-cmd`, that require access to the full project source code.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b750f801ec2b929d7a9ca59f6866c8e59562bd56"><code>b750f80</code></a> <b>docker:</b> 🐳 Clear Composer cache during build</summary>

  > Clearing the Composer cache after installation ensures a clean build state.
  > This prevents potential issues with outdated or corrupted dependency
  > packages, leading to a more reliable and reproducible Docker image.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5f2afae9df5ed731dc4c860566ddb2b6868f3324"><code>5f2afae</code></a> <b>docker:</b> 🔧 Copy patches before dependency installation</summary>

  > The pnpm patch mechanism requires the `patches/` directory to be available in the build context before `pnpm install` is executed.
  >
  > This change ensures the patch files are copied into the build stage, allowing pnpm to apply necessary fixes to node modules during the installation process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0c39156d47ee00ee31eb0cff535599454f1538f2"><code>0c39156</code></a> <b>docker:</b> 🐳 include lang directory in frontend build</summary>

  > The frontend build process requires access to the language files to
  > correctly compile and bundle translations into the final assets. This
  > ensures that all necessary translation strings are available at runtime.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/54d6b9537bbecfce49bfbf5a053b131ead9e8e97"><code>54d6b95</code></a> <b>docker:</b> 🐳 publish log viewer assets</summary>

  > The log viewer's user interface was unstyled and non-functional when running inside the Docker container.
  >
  > This was caused by its front-end assets not being published to the public directory during the image build. This change ensures the necessary assets are always present, making the tool fully operational in the production environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2743c90e0bc288dfd62bbbae850cfd6efd8ec771"><code>2743c90</code></a> 🔧 Streamline dev setup with host caches and certs</summary>

  > The Vite configuration is updated to point to the standard Caddy certificate path in the user's home directory. This avoids the need to manage a separate set of certificates within the project and aligns with a more conventional local development setup.
  >
  > Additionally, host volumes for Composer/Node caches and Composer authentication are mounted into the service container. This improves performance by reusing cached dependencies across container restarts and enhances security by leveraging the host's credentials.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/bc9835e60c7ec8a4b7180aa58d1458c33f98eeb6"><code>bc9835e</code></a> <b>vite:</b> ⚙️ Run Wayfinder plugin only in local environment</summary>

  > The Wayfinder plugin is a development-only utility for route discovery. It is not required for the production build and its inclusion adds unnecessary overhead.
  >
  > This change ensures the plugin is only loaded in the local environment, keeping production builds leaner and more focused.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fc46995a613fbac19e11a954c8dcad9b443e8d2a"><code>fc46995</code></a> <b>docker:</b> 🔧 remove unnecessary COPY command from Dockerfile</summary>

  > - Simplified the Dockerfile by removing the redundant COPY command for patches.
  > - This change helps streamline the build process and reduces image size.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6a6e16687a2cf9fcf6b157d824ed431a1a9fc2af"><code>6a6e166</code></a> <b>docker:</b> 🔧 update home directory creation in Dockerfile</summary>

  > - Simplified the creation of home directories by removing unnecessary paths.
  > - Ensures proper ownership and permissions for user directories.

  </details>
- [`b066cad`](https://github.com/gamerlogue/web/commit/b066cad3ed43705d87ee693409ba50ca54e17839) 🔧 add the git-cliff config for the release notes
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d21185117ccd98a52f98146232708f28b007c6ee"><code>d211851</code></a> 🔒️ scan staged changes for secrets before each commit</summary>

  > Same betterleaks hook as the drupal template; the CI gitleaks job only sees a secret once it is pushed.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/67eab73a5574e6f2be5505bc92515d77b5b707df"><code>67eab73</code></a> 🔧 check commit messages with the CI rule, gitmoji included</summary>

  > commit-check's check-message rejects a gitmoji after the colon, i.e. every commit of this project; a pygrep hook now applies the same regex as the commit_lint job.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/63b40b77299e36772602f749e32bd77891fecde2"><code>63b40b7</code></a> ⬆️ betterleaks hook v1.9.0</summary>

  > Same version as the secret_detection job of ci-templates.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8bdf2dec4017cf1cc30ad4e195eb0b78b34ef31f"><code>8bdf2de</code></a> 🔧 install the commit-msg hook by default</summary>

  > sitekit init (pre-commit install) only installed the pre-commit hooks, so the commit message check never ran; default_install_hook_types adds commit-msg to a plain install.

  </details>
- [`29c95fb`](https://github.com/gamerlogue/web/commit/29c95fbb4427b892ce8862c2c96429f16edc1f6a) 🔧 add the git-cliff config for the release notes
- [`d91af0c`](https://github.com/gamerlogue/web/commit/d91af0ca21d5db715dbca7906a2c0c85a4c026b6) 🔧 extend the shared renovate preset
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5d3e216992272ba23299633b5fe3ce99a684b8e3"><code>5d3e216</code></a> 🔒️ scan staged changes for secrets before each commit</summary>

  > Same betterleaks hook as the drupal template; the CI gitleaks job only sees a secret once it is pushed.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f6294f5ff21b11a6abd74d50102acc182bab9fe7"><code>f6294f5</code></a> 🔧 check commit messages with the CI rule, gitmoji included</summary>

  > commit-check's check-message rejects a gitmoji after the colon, i.e. every commit of this project; a pygrep hook now applies the same regex as the commit_lint job.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d55759c47aeca0f6a05fc43595eb60b748cb53a7"><code>d55759c</code></a> ⬆️ betterleaks hook v1.9.0</summary>

  > Same version as the secret_detection job of ci-templates.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9ebc652ff44d0da64985a081bdb97a398e14da47"><code>9ebc652</code></a> 🔧 install the commit-msg hook by default</summary>

  > sitekit init (pre-commit install) only installed the pre-commit hooks, so the commit message check never ran; default_install_hook_types adds commit-msg to a plain install.

  </details>
- [`a1c8a9f`](https://github.com/gamerlogue/web/commit/a1c8a9fd46b994a0cd2146b4647726e0e395dabe) 🔧 update ci-templates reference to v2.2.0
- [`2d03124`](https://github.com/gamerlogue/web/commit/2d03124745a0f465571ffb7360be285111484456) 🔧 update ci-templates reference to v2.3.0
- [`579eaec`](https://github.com/gamerlogue/web/commit/579eaec119ef37180e2686886717739e711c9e78) 📌 pin the bun image
- [`4c49c37`](https://github.com/gamerlogue/web/commit/4c49c37e94895cfe72ad3c8d2b0fcba3fc41fdb8) 📌 update base image to ghcr.io/maicol07/docker-php
- [`606d978`](https://github.com/gamerlogue/web/commit/606d978de2bd7628e524182105f3bad5e1e8bf5d) 📌 pin MySQL to 9.7
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d844573abe5c2738d038ddce351e5c20e50c5a11"><code>d844573</code></a> 🐳 add the Fresh terminal editor to the images</summary>

  > Alpine doesn't package it: a stage downloads the static (musl) min-size
  > binary of its GitHub release, which Renovate bumps through the shared
  > platform/renovate preset.

  </details>
- [`bc6412d`](https://github.com/gamerlogue/web/commit/bc6412dc518a8acf0d556b786dce5ccba1b41bbe) 🐳 add jq to the images
- <details><summary><a href="https://github.com/gamerlogue/web/commit/34659403b8b3e238ca19e53252275c684bc24a7e"><code>3465940</code></a> ⬆️ switch base image to upstream serversideup&#x2F;php v5</summary>

  > The fork only added Octane and CI changes; upstream v5 ships a newer
  > FrankenPHP (1.13.5) and handles Octane natively. The tag is
  > release-pinned and bumped by Renovate, which tracks only the -vX.Y.Z
  > suffix so PHP version and variation stay fixed. PHP_VERSION goes:
  > Renovate skips tags with partial variables.
  >
  > v5 under Octane (LARAVEL_OCTANE=1) generates the worker block, the
  > worker routing and the admin address itself, and ignores
  > CADDY_GLOBAL_OPTIONS:
  > - FRANKENPHP_CONFIG no longer defines the worker (duplicate filenames
  >   would abort the start) and php-server.caddyfile is gone.
  > - global.caddyfile is symlinked into caddyfile-global.d/.
  > - Dev hot reload uses Octane's --watch, now placed inside worker {}; the
  >   watch list in config/octane.php is narrowed to PHP patterns, which the
  >   dev script used to do by hand.
  >
  > PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 keeps the documented choice (v5: 0);
  > OPcache overrides equal to (or below) the v5 defaults are dropped.

  </details>

### 👷 CI changes

- [`03bb2df`](https://github.com/gamerlogue/web/commit/03bb2dfbe5e741822a9cfac3773773d0b9ce064f) **docker:** Update build and push workflow for dynamic image tagging
- [`072a8eb`](https://github.com/gamerlogue/web/commit/072a8eb15e50e0859549808c29f0c6a988abe7b4) **docker:** Normalize image path for dynamic tagging in build workflow
- <details><summary><a href="https://github.com/gamerlogue/web/commit/51aecf302c0a3fe94c3374aaddebd944604475e6"><code>51aecf3</code></a> 🔒 Inject Twitch credentials into test workflow</summary>

  > This ensures that tests relying on Twitch API access can execute successfully within the CI environment. The application's Twitch integration requires these credentials, and their absence would lead to failures in automated checks.

  </details>
- [`6bfda0a`](https://github.com/gamerlogue/web/commit/6bfda0a984f6dfc641caeafd35b7d9c92b7cae26) Update package ecosystem to 'composer' in dependabot.yml
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e10f75b1bcbf90f2cf0d56c6311fc3607dfb7cf8"><code>e10f75b</code></a> 👷 audit dependencies and scan the published image</summary>

  > composer audit runs alongside the existing validate step. The Trivy scan runs
  > after the push rather than gating it: a failing scan should be visible on an
  > image that exists, not silently stop the branch tag from being published.

  </details>
- [`0f90b68`](https://github.com/gamerlogue/web/commit/0f90b680c078977f452dbe6d4a1eba963017daa0) 🚦 reuse validation and Docker builds for automated releases
- <details><summary><a href="https://github.com/gamerlogue/web/commit/69ad2c007fba23ed4150a20956fbe3fa903ea455"><code>69ad2c0</code></a> 🔧 configure composer audit to ignore abandoned packages</summary>

  > - Updated the CI configuration to allow composer audit to bypass specific abandoned packages required by Laravel Lang.
  > - This change ensures that the audit process does not fail due to these dependencies.

  </details>
- [`40d7469`](https://github.com/gamerlogue/web/commit/40d7469857f76fcc7cd23f31f6e7cd3188df55d1) 👷 move the CI to the maicol07/actions reusable workflows
- [`e6724e8`](https://github.com/gamerlogue/web/commit/e6724e8d38f8c59f122b3d1669462a56f0406adc) 👷 deploy to the Portainer stacks listed in PORTAINER_STACKS
- [`98a34b7`](https://github.com/gamerlogue/web/commit/98a34b7a93c10657b9dcf3dc60083f08f73efd7f) 👷 add the quality jobs
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1a4b35d914ab7a2445f2d2e314ad087bc1a2ddba"><code>1a4b35d</code></a> 🐳 Migrate Docker build from Buildah to Buildx</summary>

  > Migrate the Docker image build process from Buildah to Docker Buildx. This transition leverages Buildx's superior caching mechanisms and deeper integration with the Docker ecosystem, aiming to enhance build speed and reliability.
  >
  > Additionally, update the `create_template` job to download the `sitekit` binary directly via `curl` on a lightweight `alpine` image. This reduces CI image size and simplifies dependency management compared to using the `glab` image.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/bba1cb83dac7e442dbe9d9837c6c788fc5485ad6"><code>bba1cb8</code></a> 🔒️ include the shared pipeline, drop the hardcoded PAT</summary>

  > The previous inline pipeline carried a GitLab PAT in clear text; it must be revoked.

  </details>
- [`cf360dd`](https://github.com/gamerlogue/web/commit/cf360dd832cad86a0ac7026d91f57a75b44dafda) ⬆️ use ci-templates v2.0.0
- [`cc6befe`](https://github.com/gamerlogue/web/commit/cc6befeba0ff13cd85c8b38a8e5eac019251ecfa) 👷 run pint, stylelint and the tests
- <details><summary><a href="https://github.com/gamerlogue/web/commit/aa9a68b0de1e4d56442dc60377606fad47d22ea1"><code>aa9a68b</code></a> 🔧 update GitLab CI job to use JOB-TOKEN for artifact retrieval</summary>

  > - Changed the authentication method for the curl command to use JOB-TOKEN instead of a private token.
  > - This enhances security by utilizing the built-in CI job token mechanism.

  </details>
- [`702039f`](https://github.com/gamerlogue/web/commit/702039fa4e48bc54f35b7be43576060cec07671b) ♻️ include the shared pipeline from websites/utils/ci-templates
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5284c0f894df76b4dc3c7984eacbfee2b52a2360"><code>5284c0f</code></a> ⬆️ use ci-templates v2.0.0</summary>

  > Deploys with the web-app OCI chart; adds commit/Dockerfile/IaC lint, environments with a smoke test, git-cliff releases, the release MR and the promote-to-prod job.

  </details>
- [`f0ce96b`](https://github.com/gamerlogue/web/commit/f0ce96bb295a3c7666a86573e6d1fe552ee3e2b8) 📌 pin the bun image of stylelint, on Alpine
- <details><summary><a href="https://github.com/gamerlogue/web/commit/69a87439e0a5be65d2555536c2cdf92688545d01"><code>69a8743</code></a> ✨ update CACHE_STORE variable for test stage in GitLab CI configuration</summary>

  > - Set CACHE_STORE to array to avoid issues with phpredis in composer:2

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/970bffe1cc67912e395bf5450c831ce0fc799e03"><code>970bffe</code></a> ✨ update GitLab CI configuration for bun setup</summary>

  > - Introduced a shared bun setup to optimize install caching.
  > - Added caching for bun.lock to improve job performance.
  > - Extended stylelint and eslint jobs to utilize the new bun setup.

  </details>
- [`2168332`](https://github.com/gamerlogue/web/commit/21683324f92827cc79996c6ff7169dc8e289f845) Upgraded to 2.5.0
- [`35405a2`](https://github.com/gamerlogue/web/commit/35405a2deddc291f8e95d895682f664ca2b9aab1) 👷 update ci-templates reference to 2.6.0
- [`9fc3b36`](https://github.com/gamerlogue/web/commit/9fc3b36249f9343f3b54ba91c0a079bfcc44dfc5) 👷 update ci-templates reference to 2.6.0
- [`604fbb6`](https://github.com/gamerlogue/web/commit/604fbb6c28941b3af1f52b0178e747b760fc41f0) 👷 update ci-templates reference to 2.7.1
- [`07b37bf`](https://github.com/gamerlogue/web/commit/07b37bfcab12feea3b502112c33b5afcfda5fa35) 👷 update ci-templates reference to 2.7.2
- [`76d9b9c`](https://github.com/gamerlogue/web/commit/76d9b9cda787670bd601ced19149ff044ad513ea) Update CI to 2.8.2
- [`5ab3d4f`](https://github.com/gamerlogue/web/commit/5ab3d4f16862b39970febd8de2a4b5f5ed4628e1) 👷 gate the release on ESLint and Stylelint

### Other changes

- <details><summary><a href="https://github.com/gamerlogue/web/commit/2313ad20d691d12ca6b2df6d08559018cd0f0160"><code>2313ad2</code></a> Update typehint to be nullable (#5296)</summary>

  > By default, this property is null. Therefore, it should be marked as nullable

  </details>
- [`cd304b4`](https://github.com/gamerlogue/web/commit/cd304b4369358720559862f2a8665369922867ec) Update changelog CI permission
- [`2a5b77f`](https://github.com/gamerlogue/web/commit/2a5b77f1adf140119f1144df39448ff3470cf666) Update `update-changelog.yml`
- [`838b9dd`](https://github.com/gamerlogue/web/commit/838b9dd6f920221c577f67a13b03b6f51ce0fcae) **deps:** Updated dependencies
- [`cb694dd`](https://github.com/gamerlogue/web/commit/cb694dd173ac9a9a81601bfde84cb5cc327d95d4) **turnstile:** 🔧 Temporarily disable script meta tag
- <details><summary><a href="https://github.com/gamerlogue/web/commit/896a29ee7cc685acac92f336d54151f7d8b3f25e"><code>896a29e</code></a> ⚙️ Add TERMINAL_EMULATOR env var to compose</summary>

  > This variable allows the application inside the container to detect the host's terminal emulator. This enables better integration and feature support, especially when working with JetBrains IDEs, which can leverage this information for enhanced terminal interactions.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/69fba6c9b530dee343918ed9a805653210bef77a"><code>69fba6c</code></a> 🧹 Correct IntelliJ module file name</summary>

  > The `account.iml` file was an incorrectly named IntelliJ module file. This commit removes the erroneous file and updates `modules.xml` to correctly reference `gamerlogue_web.iml`, ensuring proper project recognition and structure within the IDE.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a67b69e435a1f9f52c75216c892783b8326c9607"><code>a67b69e</code></a> 🔧 update IntelliJ IDEA project configuration</summary>

  > This commit standardizes the project setup within the IDE. It ensures correct SQL dialect mappings and data source paths, integrates the AI Commit plugin, and refines TypeScript compiler settings for improved development workflow and consistency.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/97272fa738cdffaba0e37d287cc4fe41a1e5c9ce"><code>97272fa</code></a> <b>docker:</b> 🎨 standardize docker compose file extension to .yaml</summary>

  > The `.yaml` extension is the officially recommended file extension for YAML files. This change standardizes all Docker Compose files to use this extension for better consistency and to adhere to community best practices.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e9b98d9b9f5ac90ce32eecf9fedaf4ef2f8c0ad0"><code>e9b98d9</code></a> <b>idea:</b> ⚙️ Update TypeScript service types configuration</summary>

  > This commit updates the IntelliJ IDEA configuration for TypeScript's service-powered types. The option name and its corresponding value have been adjusted to align with the latest IDE standards, ensuring the project uses current and compatible settings for TypeScript compilation.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d958d54b3908aad649bfe77d2d91356bf4c76137"><code>d958d54</code></a> <b>config:</b> ⚙️ Update IDE settings for compose file extensions</summary>

  > This update aligns the IDE's internal configuration with the standardized `.yaml`
  > file extension for Docker Compose files. It ensures the IDE correctly recognizes
  > and processes these files, preventing issues with schema validation or service
  > management that rely on accurate file paths.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2308ff731c693d88294141faa3a33497cc2947f9"><code>2308ff7</code></a> <b>deps:</b> ⬆️ Bump PHP to 8.5 and Pest to v4</summary>

  > This update primarily raises the minimum PHP version requirement to 8.5 and upgrades Pest to its fourth major release. These bumps allow the project to leverage the latest language features, performance improvements, and testing framework enhancements. Additionally, other Composer dependencies are refreshed to their latest compatible versions to ensure security, stability, and ongoing compatibility with the updated core components.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fb9e5ac9d4773f087c1bc45aa8597ffabde9bda6"><code>fb9e5ac</code></a> <b>config:</b> ⚙️ Update example environment for failover connections</summary>

  > Update the `.env.example` file to reflect the new default connection strategy for queues and cache. Using `failover` instead of a direct `redis` connection improves application resilience by providing a robust fallback mechanism, ensuring higher availability and preventing service interruptions if the primary Redis instance fails.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/402a5e6dc476961fd2f7ad3bb2b2db5edc4bf0d5"><code>402a5e6</code></a> <b>config:</b> ⚙️ Update example environment for failover connections</summary>

  > Update the `.env.example` file to reflect the new default connection strategy for queues and cache. Using `failover` instead of a direct `redis` connection improves application resilience by providing a robust fallback mechanism, ensuring higher availability and preventing service interruptions if the primary Redis instance fails.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c724ced3c43a8ae03f19f78f1f68ac61524b2ed9"><code>c724ced</code></a> <b>composer:</b> 🎨 Reorder ext-pdo dependency</summary>

  > This change improves the readability and consistency of the `composer.json` file by ensuring that PHP extensions are listed in a logical order, making it easier to scan and maintain the project's dependencies.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cc6b646d3e74969434fcc426cc9bc322f05500a5"><code>cc6b646</code></a> <b>ide:</b> ⚙️ Sync PHPStorm vendor paths</summary>

  > Keeps the project's PHPStorm configuration in sync with the current Composer dependencies. This ensures accurate code analysis, autocompletion, and navigation within the IDE.

  </details>
- [`b01756a`](https://github.com/gamerlogue/web/commit/b01756ad6d684f42256e1d35dc5d5923defdbba2) **i18n:** 🌐 Updated language files
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ec4e2ac3e7af087c0a7dfe021230a20b1b9db9a7"><code>ec4e2ac</code></a> <b>ide:</b> ⚙️ Update PhpStorm configuration files</summary>

  > These changes reflect updates to the PhpStorm project configuration files.
  > They ensure the IDE correctly indexes project dependencies and excludes
  > generated Laravel Idea plugin files from version control, improving
  > IDE performance and consistency across development environments.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f1ad05283f6091f29b85d29e6fe7706044b39688"><code>f1ad052</code></a> <b>deps:</b> ⬆️ update composer dependencies</summary>

  > Updates the composer.lock file to reflect the latest versions of project dependencies.
  > This update ensures the application benefits from recent bug fixes, performance enhancements, and security patches. Keeping dependencies current maintains a stable and secure development environment.

  </details>
- [`ffda1c3`](https://github.com/gamerlogue/web/commit/ffda1c3a177137a4c5e421a361fbeb73231dc5c0) 🙈 Added Pail .gitignore
- [`27945e7`](https://github.com/gamerlogue/web/commit/27945e769bbb902775c8385bccc1ea40ce89fc4f) **i18n:** 🔥 🌐 Removed unused translations
- <details><summary><a href="https://github.com/gamerlogue/web/commit/07dbb1ad1a3a6dd1444815031ba18b490ec67d22"><code>07dbb1a</code></a> <b>config:</b> 🔒 Add .ash_history to .gitignore</summary>

  > This prevents local shell history files from being inadvertently committed to the repository, safeguarding user-specific data and maintaining a clean project history.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/20ea49d35fc2523f2f89c198d065e238ee6674bc"><code>20ea49d</code></a> <b>docker:</b> 🐳 Refactor Dockerfile for build optimization and clarity</summary>

  > The Dockerfile has been refactored to optimize build performance and improve maintainability. BuildKit cache mounts are now utilized for Composer and PNPM, dramatically reducing dependency installation times on subsequent builds. Virtual build dependencies ensure smaller final image sizes by allowing for their removal in production stages. Consolidating RUN commands reduces the number of image layers, which contributes to faster builds and more efficient caching. Additionally, the structure is clearer, and the development image now includes doas for a more familiar sudo-like experience.

  </details>
- [`253ec83`](https://github.com/gamerlogue/web/commit/253ec836b7c15aac765ff8ccadd06c6a84c7c6dc) **ide:** 🔧 update IDE settings and configuration files
- [`400384d`](https://github.com/gamerlogue/web/commit/400384d07d91df740e1bf4a48e6723593e3b6f41) **deps:** ➕ add Larastan/PHPStan and configure static analysis in CI
- [`f0040e6`](https://github.com/gamerlogue/web/commit/f0040e61209c391236084c4a2a25f0d94ef7b529) Upgraded Composer dependencies
- [`2eb81e8`](https://github.com/gamerlogue/web/commit/2eb81e851173355a00ff260c5a562c19c94049e0) Forced PNPM package manager
- [`ce0fc3a`](https://github.com/gamerlogue/web/commit/ce0fc3a7ded3c34f22c7e2f602e09fcea33bd6a7) Updated 🙈 gitignore file
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9b3d6b53301f1fba51a98d82fc6a28db6c188130"><code>9b3d6b5</code></a> <b>deps:</b> Added error solutions</summary>

  > Additional solutions displayed in the error page

  </details>
- [`f563530`](https://github.com/gamerlogue/web/commit/f5635305bd19dc508d794dad814739b97327fdf1) **deps:** Added ESLint
- [`06f1d72`](https://github.com/gamerlogue/web/commit/06f1d72d9c4fb137779c58109c166c9c6f55e718) **deps:** Added Stylelint
- [`0b5feb3`](https://github.com/gamerlogue/web/commit/0b5feb307d39c6d04680f89946e2162a87075043) **deps:** ➕ Added SCSS and TS support
- [`03ec21e`](https://github.com/gamerlogue/web/commit/03ec21e4781d4af0d0655e6768453f1f640d6609) **deps:** ⬆️ Upgraded Node dependencies
- [`92a5d1f`](https://github.com/gamerlogue/web/commit/92a5d1fd500849303ab9852ded775b5040b3a7d3) 🔧 Added configuration for Laravel Sail
- [`68590bc`](https://github.com/gamerlogue/web/commit/68590bc5942f85c9687316ba98e74b67a1c74203) 🔧 Added PHPStorm config files
- [`e360fdf`](https://github.com/gamerlogue/web/commit/e360fdff5e40a2b0068ef594fce905769d039e79) 🔧 Added PHPStorm config files
- [`3c6a6bc`](https://github.com/gamerlogue/web/commit/3c6a6bce54a6f6a4701815fec89909feb0bdc7a1) 🙈 Excluded public vendor folder in gitignore
- [`60d06c0`](https://github.com/gamerlogue/web/commit/60d06c0ed86a6640f6847a5b0e9f492fcdd44539) Changed DB host port
- [`5466916`](https://github.com/gamerlogue/web/commit/5466916db8ce12f9a556cfad93c4c6d63da754dd) Changed DB vars name
- [`d3fe7fa`](https://github.com/gamerlogue/web/commit/d3fe7fad2fb998c376d7a364956e9aa61946031c) **ide:** Remove project interpreter from PHPStorm config
- [`3c2b104`](https://github.com/gamerlogue/web/commit/3c2b10441b4f5c3ed6d4e6e98c79398fa8ce8b2b) **ide:** 🔧 Added new folders and blade directives to PHPStorm config
- [`93c8858`](https://github.com/gamerlogue/web/commit/93c8858b3290f0fde0644132d8dbc56af88479cd) 🙈 Added more excluded folders to gitignore
- [`9517de4`](https://github.com/gamerlogue/web/commit/9517de4819e324ba36aa85881235ffa42ae4c02f) 🙈 Added more excluded folders to gitignore
- [`6e7c3f8`](https://github.com/gamerlogue/web/commit/6e7c3f897fecf180f6e8a8e920bbccd107b8e765) **deps:** ⬆️ Upgraded dependencies
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c26e1d8cfe4b8306e1db5e5b770bcc7f04dcb5c9"><code>c26e1d8</code></a> <b>gitignore:</b> 📝 Update .gitignore with recommended templates</summary>

  > Updates the .gitignore file to include recommended templates from toptal.com.
  >
  > - Adds entries for Git, Linux, macOS, Windows, PhpStorm, and Visual Studio Code.
  > - Improves exclusion of IDE-specific files.
  > - Enhances general cleanup.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f1fda69d30bd28f48cfe89c4365a6379f47e21e6"><code>f1fda69</code></a> <b>gitignore:</b> 🙈 Update .gitignore with latest templates</summary>

  > Updates the .gitignore file to include more comprehensive templates.
  >
  > - Adds templates for Git, Linux, macOS, Windows, PhpStorm+iml, and VisualStudioCode.
  > - Includes specific exclusions for IDE-generated files and directories.
  > - Improves default ignore patterns for common development scenarios.

  </details>
- [`0fc20a5`](https://github.com/gamerlogue/web/commit/0fc20a5a09ca0e5bb6849b1681a833fd67b3955d) **ide:** Added IDE files
- [`fd6144b`](https://github.com/gamerlogue/web/commit/fd6144be2e05d3d128b67a50db8968a5df65b992) **editorconfig:** Update line length and file patterns
- [`26d598d`](https://github.com/gamerlogue/web/commit/26d598d9b5aed07c23b56ad57c535cfe0bf01555) Update project configuration files and exclude additional vendor directories
- [`427a70e`](https://github.com/gamerlogue/web/commit/427a70ecf7d58a862e0e391a4797d4a373314364) **composer:** Update dependencies and PHP version requirements
- [`0eabd93`](https://github.com/gamerlogue/web/commit/0eabd9359625643de2146dc4ecead2698b4a1332) Add Docker and Supervisor configuration for development environment
- [`c7d4208`](https://github.com/gamerlogue/web/commit/c7d4208f2783acc2d53c3b86856475b2ad7db625) 🔧 Removed sitekit old config file
- [`c079e3c`](https://github.com/gamerlogue/web/commit/c079e3c296640a472e805ed8c25099f88133827a) Update TypeScript configuration and add Vite configuration file
- [`60f615e`](https://github.com/gamerlogue/web/commit/60f615e07627898c92d0ee149bda9e87ed04c805) Add Pint configuration for Laravel with custom rules
- [`63bcee2`](https://github.com/gamerlogue/web/commit/63bcee25969c2869d85b08ee729edabcec3f7087) Update ESLint configuration and dependencies in package.json
- [`873c911`](https://github.com/gamerlogue/web/commit/873c911217164b8ca9f8b6b16b741c5afe173101) Update database configuration and aliases from mariadb to mysql
- [`31d8a1b`](https://github.com/gamerlogue/web/commit/31d8a1b71af235728cfdb1b883aec7f998a225ef) Add configuration files for code style, CIAid settings, JavaScript library mappings, and pnpm workspace
- [`8407998`](https://github.com/gamerlogue/web/commit/840799828328b4b5782974c45664fa37754414e5) Add SVG icon file
- [`8aeb0cf`](https://github.com/gamerlogue/web/commit/8aeb0cfb116741a5a301d2682d43a2e7d98b49e7) **commit-check:** 📝 Update regex for commit message validation and add imperative mood check
- [`f31e20a`](https://github.com/gamerlogue/web/commit/f31e20a12e0fce024c116b0e24ab8dc17e4b020d) 🔧 🔥 Removed old sitekit config file
- [`bf0c321`](https://github.com/gamerlogue/web/commit/bf0c321bcbb27150d87292411b52980ed8e246e5) ✨ Update .env.example to include APP_SERVICE for Laravel Sail
- [`6e46acc`](https://github.com/gamerlogue/web/commit/6e46accd68c52246c11435ee0297b06289e23a50) 🔥 Removed old AddViteToSailSupervisor command
- [`e31a9da`](https://github.com/gamerlogue/web/commit/e31a9da5555e037c41944997da6dbaba325d1253) ✨ Enhance activation scripts for Laravel Sail environment
- [`1d3fd5e`](https://github.com/gamerlogue/web/commit/1d3fd5e6976d9adeb14ccdc9162584582357e0dd) ✨ Update supercronic command to include --quiet option in supervisord configuration
- [`d17b956`](https://github.com/gamerlogue/web/commit/d17b9566ed2faddf266e4a3d838cf21a30349e02) ✨ Update supervisord configurations to use environment variables for autostart settings
- [`63cc89e`](https://github.com/gamerlogue/web/commit/63cc89e3dc3f764563f61d4afe85d657e82725c9) ✨ Disable Horizon in Dockerfile environment variables
- [`4be48d8`](https://github.com/gamerlogue/web/commit/4be48d8d40d2b0be22b0cc7ce253eb03a979ad7e) **deps:** ⬆️ Update dependencies in composer.lock to latest versions
- <details><summary><a href="https://github.com/gamerlogue/web/commit/4045ab6f4ecd805a3453e33742760db79ee8cd69"><code>4045ab6</code></a> <b>config:</b> 🔧 Update php.ini values</summary>

  > Update php.ini to adjust resource limits and opcache settings.
  >
  > - Increase memory limits (post_max_size, upload_max_filesize, realpath_cache_size)
  > - Configure opcache settings, including JIT options.
  > - Improve performance and stability.

  </details>
- [`1dc8376`](https://github.com/gamerlogue/web/commit/1dc83766e9450ea6f3933b2e47059d2fc13fe4f6) **ide:** 🔧 Update settings to reflect compose.yaml rename
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b41b00abe0c5efc19e15cc9d2bd698024f5ef3b4"><code>b41b00a</code></a> ⬆️ update dependencies in composer.lock and IDE config</summary>

  > Updates a batch of dependencies including:
  > - `laravel/framework` (v12.26.3 -> v12.34.0)
  > - `laravel/octane` (v2.12.1 -> v2.13.0)
  > - `laminas/laminas-diactoros` (v3.6.0 -> v3.8.0)
  > - `brick/math` (v0.13.1 -> v0.14.0)
  > - Various Symfony and development dependencies.
  >
  > Also includes an update to `.idea/php.xml` to reflect dependency changes.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ce434a71957c359faf03bfd5633da6e90143cdfd"><code>ce434a7</code></a> <b>ide:</b> 🔧 Enable validation for production compose file</summary>

  > This change configures the IDE to validate the `compose.prod.yaml` file.
  > Enabling this feature provides real-time syntax checking and autocompletion, helping to catch configuration errors early in the development process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/95081442bbf08ce406fd5eada91e22e6cceeccba"><code>9508144</code></a> <b>docker:</b> 🩺 Increase healthcheck interval and timeout</summary>

  > The previous healthcheck values were too aggressive, potentially causing containers to be marked as unhealthy and restart unnecessarily during periods of high load or slow startup.
  >
  > These new, more lenient values provide a larger window for the application to respond, enhancing the overall stability of the containerized environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c52e580e583b8909345d8d431e5c9bc59b2226a1"><code>c52e580</code></a> <b>deps:</b> ⬆️ update dependencies</summary>

  > This commit updates both frontend and backend dependencies to their latest versions.
  >
  > Keeping dependencies current is crucial for project health. It incorporates the latest security patches, bug fixes, and performance improvements from the upstream packages, ensuring the application remains stable, secure, and maintainable.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1d65bdcfcd1b2d4c302db18998d8d96bfb2bdece"><code>1d65bdc</code></a> <b>deps:</b> Replace laravel-debugbar with clockwork</summary>

  > Clockwork provides a more modern and less intrusive debugging experience compared to Laravel Debugbar. Its browser extension and dedicated app allow for inspecting application requests, including API calls, without injecting a visible bar into the application's UI.
  >
  > This switch improves the development workflow, especially for SPAs or API-heavy applications, by offering a cleaner and more powerful interface for debugging and profiling.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/45791ef379b18d615a4db67aa0698863f1a873c7"><code>45791ef</code></a> 🔧 update pre-commit configuration and rename commit-check file</summary>

  > - Upgraded commit-check hook version to v2.6.0 for improved functionality.
  > - Renamed configuration file from `.commit-check.yml` to `commit-check.toml` for consistency with naming conventions.
  > - Adjusted hook stages to ensure proper execution during commit message checks.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e3336827bc04dbedd251ce9fa811fb98b805ea2f"><code>e333682</code></a> <b>env:</b> 🔧 update environment configuration for caching and mail services</summary>

  > - Changed CACHE_STORE from database to redis for improved performance
  > - Updated MEMCACHED_HOST to use the new service name
  > - Adjusted REDIS_HOST to point to the redis service
  > - Modified MAIL_HOST and MAIL_PORT for compatibility with mailpit

  </details>
- [`2b69fa2`](https://github.com/gamerlogue/web/commit/2b69fa2fe02bd39a2f8f6c04e107ef4d015b126d) **deps:** ⬆️ update dependencies
- [`35eba52`](https://github.com/gamerlogue/web/commit/35eba521031d76ec5e89576922fa1b8d961694c4) 🔧 add .idea/claudeCodeEditorTabs.xml to .gitignore
- [`10c72dc`](https://github.com/gamerlogue/web/commit/10c72dc8852ed505600013ca0dba6f4c0101b00d) **mcp:** 🔥 remove deprecated MCP server configuration file
- [`229d1ee`](https://github.com/gamerlogue/web/commit/229d1ee529f81eda4bc03b026dea9748798da0ea) **lang:** 🔧 add .gitkeep file to preserve lang directory in version control
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c496425ffafbd9005cb01225ab03cc9e32d72432"><code>c496425</code></a> <b>start-container:</b> 🔧 add vendor and node modules installation checks</summary>

  > - Ensure the vendor directory is created by running composer install if it doesn't exist.
  > - Ensure the node_modules directory is created by running pnpm install if it doesn't exist.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/01acbcbde409c0af536df9979849096b630bfc84"><code>01acbcb</code></a> <b>docker:</b> 🔧 update project to use Bun as package manager</summary>

  > - Added bunfig.toml for Bun configuration.
  > - Updated package.json scripts to use Bun commands.
  > - Modified Dockerfile to install Bun and adjust build process.
  > - Changed cache paths in compose.yaml and .dockerignore to reflect Bun usage.
  > - Updated activation scripts to replace pnpm with Bun commands.

  </details>
- [`67cf273`](https://github.com/gamerlogue/web/commit/67cf273c01d46a744bf7b9dde828a1026099896c) Update outdated GitHub Actions version (#6743)
- [`36b0521`](https://github.com/gamerlogue/web/commit/36b052128473f8fb333b74e240053f84f0ac443c) Add missing comma in axios
- [`f76da77`](https://github.com/gamerlogue/web/commit/f76da7796a5dbc86c9ecf3d0c3d9d81e474ddd9c) **php:** 🔧 update PHP language level to 8.5
- [`0fcdd84`](https://github.com/gamerlogue/web/commit/0fcdd84861928fbebf66db314b9b2096dd9df79a) **gitattributes:** 🔧 remove CHANGELOG.md from export-ignore list
- [`da9afd5`](https://github.com/gamerlogue/web/commit/da9afd53313e7c02b6a26b9ac8e9e19f611f9dff) **vite:** 🔧 remove Vite configuration file (JS)
- [`145f888`](https://github.com/gamerlogue/web/commit/145f8880daff5d22046d026e7336c09544bc5ed4) Removed execution permission
- [`27cd31c`](https://github.com/gamerlogue/web/commit/27cd31c10457df9d295fb60d313b28cc9239c59e) 🔧 add public/fonts-manifest.dev.json to .gitignore
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c1f0a89e72734c33cbb320dc1505af8a9f4030d1"><code>c1f0a89</code></a> 🔧 update development dependencies in package.json</summary>

  > - Upgraded ESLint, TypeScript, Vite, and stylelint packages to their latest versions for improved performance and compatibility.
  > - Replaced `sass` with `sass-embedded` to align with current best practices.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7263fa48b73cca3e5701e8e638574c252c3de4f4"><code>7263fa4</code></a> 🔧 add fontaine package to dependencies</summary>

  > - Added `fontaine` version `0.8.0` to `package.json` and `bun.lock` for enhanced font management capabilities.

  </details>
- [`aef8eb1`](https://github.com/gamerlogue/web/commit/aef8eb15888647c9d9b2f7f5c902b13240ce9a37) 🔧 update base image in Dockerfile to use ghcr.io/maicol07/docker-php-dev
- [`a36dbaa`](https://github.com/gamerlogue/web/commit/a36dbaade8f4e3bd30968e9d2ee706510f7e6ddb) 🔧 update base image comment in Dockerfile
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b6cc438a719a5d2f83028be0b4fecf7ed9961729"><code>b6cc438</code></a> 🔧 remove redis extension from Dockerfile</summary>

  > Redis extension is already included in the base docker-php image
  >
  > - Simplified the PHP installation by removing the redis extension.
  > - This change helps streamline the Docker image and reduce potential overhead.

  </details>
- [`a573fb8`](https://github.com/gamerlogue/web/commit/a573fb8fd9977c30f613145c412b1b0eb5b860e5) 🔧 consolidate EXPOSE directives in Dockerfile
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6044ae7f96d271a24b502755ae880f4d1a58770c"><code>6044ae7</code></a> 🔧 update Docker Compose files to manage Caddy volumes</summary>

  > - Added volume definitions for Caddy configuration and data in `compose.common.yaml`
  > - Removed redundant volume definitions from `compose.prod.yaml` and `compose.yaml`
  > - Ensures consistent volume management across different environments

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fb851816f2ba066291ca5aeec184e715b4640293"><code>fb85181</code></a> 🔧 remove port mapping for HTTP in Docker Compose</summary>

  > - Eliminated the hardcoded port mapping for HTTP to allow flexibility in configuration.
  > - This change enables the use of environment variables for port management.

  </details>
- [`bfb78c7`](https://github.com/gamerlogue/web/commit/bfb78c70622f5a1a28966c3451dc4a17d31be83d) 🔧 update hostname in Docker Compose configuration
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c86f5a744360b176f6a8d4fd74fd610bf8af0fe0"><code>c86f5a7</code></a> 🔧 remove unused environment variables from Docker Compose</summary>

  > - Eliminated IGNITION_EDITOR and IGNITION_REMOTE_SITES_PATH as they are no longer needed.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/251dc4ea57abb4090d7a3a63ed7fd24f4d2d07f8"><code>251dc4e</code></a> 🔧 remove tail command from start-container-dev.sh</summary>

  > - Eliminated the tail command for xdebug.log to streamline the script execution.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d6297ef97a435148744abdd34f48b2ff0ac72039"><code>d6297ef</code></a> <b>serena:</b> 🔧 add .gitignore and project.yml for configuration management</summary>

  > - Introduced a .gitignore file to exclude cache and local configuration files.
  > - Added project.yml to define project settings and language server configurations.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b5e2915fcfc6e3864ce088ab27343d9ab4ecd192"><code>b5e2915</code></a> 🔧 update Docker Compose files for improved port and host configuration</summary>

  > - Added ports for HTTPS and optional database/Redis forwarding in `compose.yaml`.
  > - Removed redundant port mappings and environment variables from `compose.common.yaml`.
  > - Adjusted `extra_hosts` for better host resolution.

  </details>
- [`34eb966`](https://github.com/gamerlogue/web/commit/34eb966eeb290802633ec2968343bb3a6623a424) 🔧 update extra_hosts configuration in compose.common.yaml for default server name
- [`5658a03`](https://github.com/gamerlogue/web/commit/5658a032ee369c953c7a6c9cb26b81fcab71723c) 🔧 remove USER argument from laravel service build configuration
- <details><summary><a href="https://github.com/gamerlogue/web/commit/45b6f51e63fd1a538ff1311184d025f90daaa4f6"><code>45b6f51</code></a> 🔧 update PHP_OPCACHE_JIT settings in Dockerfile</summary>

  > - Changed PHP_OPCACHE_JIT from '1' to 'tracing' for improved performance.
  > - Added PHP_OPCACHE_JIT_BUFFER_SIZE to optimize JIT compilation.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8b2c91d15a614df2b333990558d566d31341d111"><code>8b2c91d</code></a> 🔧 update logging directory permissions in Dockerfile</summary>

  > - Created a new logging directory for FrankenPHP.
  > - Set appropriate ownership for the logging directory to ensure proper access.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d6eb32ce829146645abf9796eefc7c7ede0ee1f6"><code>d6eb32c</code></a> 🔧 update Bun cache directory in Dockerfile</summary>

  > - Changed Bun cache directory from /home/${USER}/.bun/install/cache to /root/.bun/install/cache for improved compatibility.
  > - Removed unnecessary script copying and execution steps to streamline the Docker build process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/11401251c383f77e59f2ca9eed33c04445c1f653"><code>1140125</code></a> 🔧 remove script copying and execution from Dockerfile</summary>

  > - Eliminated the copying and execution of deployment scripts to streamline the Docker build process.
  > - This change reduces unnecessary steps and potential errors during image creation.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/dec7d083cc6a6e784f64c4d5af0f0b838cedd0a4"><code>dec7d08</code></a> 🔧 update service dependencies to use health checks</summary>

  > - Added health check conditions for MySQL and Redis services in Docker Compose files.
  > - Ensures that dependent services only start when MySQL and Redis are healthy, improving reliability.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/af9a40739e218f85c506fe624acfc91907f44b46"><code>af9a407</code></a> 🔧 add restart policy to services in Docker Compose</summary>

  > - Ensures services automatically restart unless stopped
  > - Improves reliability and uptime of the application

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/79a53c45af31c01b0b767ce221ebc927b0070487"><code>79a53c4</code></a> 🔧 add logging configuration to services in Docker Compose</summary>

  > - Set logging driver to json-file with max size and file limits for better log management.

  </details>
- [`7af4ef3`](https://github.com/gamerlogue/web/commit/7af4ef3df42b70ffaac3da83906c5b6d453bcd4d) Removed unused files
- <details><summary><a href="https://github.com/gamerlogue/web/commit/33264c86dfe863dd9822e7098c0adcac826b310d"><code>33264c8</code></a> ⚡ simplify Vite imports in welcome view</summary>

  > - Replaced conditional logic with a single `@vite` import for `app.ts`.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8a88cc9d1d27992d88bc961cb75f5bdac8a0cffb"><code>8a88cc9</code></a> 🔧 configure Vite dev server with Caddy proxy for HMR fix</summary>

  > - Added `vite.caddyfile` for terminating TLS and reverse proxying Vite in development.
  > - Updated `vite.config.ts` to remove `server.https` for compatibility with Caddy's WebSocket handling.
  > - Removed `vite-plugin-restart` and related SSL configuration.
  > - Updated `compose.yaml` to mount the new Caddyfile.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/67cdb3b2f7a416e039eb1a13be08fc6618174a9a"><code>67cdb3b</code></a> ♻️ reorder and clean up ENV variables in Dockerfile</summary>

  > - Moved ENV variable block to streamline configuration.
  > - Ensured ENV variables are defined before changing file permissions.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/eabbba9a416288dc5c28c1facbeb15a21c31ebf2"><code>eabbba9</code></a> 🔧 update PHP INI scan dir and set logging directory ownership</summary>

  > - Fixed `PHP_INI_SCAN_DIR` to remove redundant separator.
  > - Added ownership adjustment for FrankenPHP log directory.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cd937cd42fcf40f305343bf712bbfd571afef199"><code>cd937cd</code></a> 🔧 update Dockerfile to adjust Caddy admin address and exposed ports</summary>

  > - Changed Caddy admin address from `:2019` to `localhost:2019`.
  > - Removed exposure of Caddy's admin port (`2019`), keeping only essential ports.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7aff647036489504cc0a1ff01e5dab75154bc6ec"><code>7aff647</code></a> 🔧 clean up Dockerfile and optimize build steps</summary>

  > - Removed unnecessary commands and improved build efficiency
  > - Adjusted permissions and ownership for better security

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a51ffcf63593cf1bc002efb98fe5c27d1e574880"><code>a51ffcf</code></a> <b>compose:</b> 🔧 update command to include Caddyfile path</summary>

  > - Added `--caddyfile=/etc/frankenphp/Caddyfile` to the Octane start command for better configuration management.

  </details>
- [`972cc1a`](https://github.com/gamerlogue/web/commit/972cc1a7ff2f5d2280b9d5c5895d8a75d2503e7e) **compose:** 🔧 update extra_hosts to use localhost IP address
- <details><summary><a href="https://github.com/gamerlogue/web/commit/95c392098e44007d96612238c4a287437d82f514"><code>95c3920</code></a> <b>compose:</b> 🔧 add security options to services</summary>

  > - Introduced `security_opt` to prevent new privileges for containers
  > - Added `cap_drop` and `cap_add` to enhance security by limiting capabilities

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9bbbd35d8629c6a48e38d650da555557bdc1cbc0"><code>9bbbd35</code></a> <b>compose:</b> 🔧 update log file configuration for rolling logs</summary>

  > - Added rolling log options for frankenphp and access logs
  > - Improved log management by limiting size and retention

  </details>
- [`89c0d8a`](https://github.com/gamerlogue/web/commit/89c0d8a1bc5568b0e0411d14f7c60ad3556fb3c4) **compose:** 🔧 update FRANKENPHP_CONFIG file path to use APP_PUBLIC_PATH
- [`d224dd9`](https://github.com/gamerlogue/web/commit/d224dd90c0231418af29df775aa0db3500a34568) **compose:** 🔧 update log directive to use `access` instead of `file`
- <details><summary><a href="https://github.com/gamerlogue/web/commit/818d0e33c7b0e8af0d802ff962998fdb30045b1e"><code>818d0e3</code></a> <b>compose:</b> 🔧 update MYSQL_ROOT_PASSWORD environment variable to support default value</summary>

  > - Allow MYSQL_ROOT_PASSWORD to default to DB_PASSWORD if not explicitly set
  > - Enhances flexibility in configuration

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7fdd8fce7d9c9abf13de4eac0b4381996fb71f29"><code>7fdd8fc</code></a> <b>compose:</b> 🔧 update MYSQL_PASSWORD and healthcheck to require DB_PASSWORD</summary>

  > - Ensure MYSQL_PASSWORD and healthcheck command require DB_PASSWORD to prevent misconfiguration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b64092397ef8f2a2811417aa176946301a4a4cf5"><code>b640923</code></a> <b>compose:</b> 🔧 update Redis configuration to set max memory limit</summary>

  > - Added command to Redis service to configure max memory and eviction policy.
  > - This change helps manage memory usage effectively and prevents potential out-of-memory errors.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/88aa8bcb7d68b387c5a1826bc124112b900e7d06"><code>88aa8bc</code></a> <b>compose:</b> 🔧 add language files to the octane configuration</summary>

  > - Included 'lang/**/*.php' to ensure language files are processed correctly.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5e632aabcf47141353e9cca52c2db03a832f1f37"><code>5e632aa</code></a> <b>octane:</b> 🔧 add configuration for Octane server state file</summary>

  > - Introduced a new configuration option for the Octane server to specify the state file location.
  > - This allows for better management of the server's master process ID and admin endpoint tracking.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7ba03061007a285fe97d887520cdbe49766898fb"><code>7ba0306</code></a> <b>log-viewer:</b> 🔧 add authentication for LogViewer access</summary>

  > - Implemented authentication logic to restrict access to LogViewer based on user email.
  > - This change enhances security by ensuring only authorized users can view logs.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6142e995c68335ca36e07f09ce267dfda9bb0fb0"><code>6142e99</code></a> <b>octane:</b> 🔧 update Octane configuration for Caddy integration</summary>

  > - Added Caddy environment variables to the Octane configuration.
  > - Enhanced the start-container-dev.sh script to handle watch directives for FrankenPHP.
  > - Improved handling of file paths to prevent crashes during watch mode.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1001961e5d2da061c0362d9a8ef117cbd5d533a1"><code>1001961</code></a> <b>dockerignore:</b> 🔧 update .dockerignore to exclude additional files</summary>

  > - Added exclusions for IDE configuration files and local project settings
  > - Improved clarity by organizing ignored files related to storage and cache

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8c201554c6d35257c8fe4d19b11c4b71e825240d"><code>8c20155</code></a> <b>composer:</b> 🔧 update dependencies in composer.json</summary>

  > - Removed outdated packages and updated to newer versions
  > - Ensures compatibility with the latest Laravel and PHPUnit releases

  </details>
- [`b22e4e5`](https://github.com/gamerlogue/web/commit/b22e4e59b7d46668068331203b74b1fff7e71ae6) 🗑️ add .gitignore file to exclude all files except itself
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c047238c7cb06197c8bddac5fbce2780d23b779e"><code>c047238</code></a> <b>tests:</b> 🔧 migrate to Pest framework</summary>

  > - Replaced PHPUnit with Pest for testing, including configuration updates (`php-test-framework.xml`, `composer.json`, `tests`).
  > - Added Pest plugins for improved functionality and parallel testing.
  > - Simplified `ExampleTest` to use Pest's syntax for clarity.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fc3f0d4227e79cb4d1a2250a8611d41e6919dc69"><code>fc3f0d4</code></a> <b>compose:</b> 🔧 update OCTANE_PORT in production configuration</summary>

  > - Changed the port variable from PORT to OCTANE_PORT to avoid conflicts with PaaS platforms and interactive shells.
  > - Ensured consistency with the container side of `ports` in compose.common.yaml and the base image's HEALTHCHECK.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c53d8cf4ae9c76895ee94b07e192e2d68695ac09"><code>c53d8cf</code></a> <b>docker:</b> 🔧 update permissions for Xdebug log file</summary>

  > - Changed permissions for the /tmp directory to 1777 to allow Xdebug to create its own log file at runtime.

  </details>
- [`8002e4f`](https://github.com/gamerlogue/web/commit/8002e4f85b15eeb8ea4e3c5b75a753b0a8285723) 🗑️ exclude storage/pail directory from project
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1f5f03e120e659f78d0a249c3e46fa9ce7d924c9"><code>1f5f03e</code></a> <b>script:</b> 🔧 enhance log output and add pail process</summary>

  > - Updated log colors to include magenta for improved visibility.
  > - Added `php artisan pail` command for streamlined local development.
  > - Adjusted process names to improve clarity in concurrent tasks.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9b9c0d6be5ff70c81f7bb1ca15de3bb733489c92"><code>9b9c0d6</code></a> <b>script:</b> 🔧 simplify command execution in development script</summary>

  > - Removed unnecessary `unbuffer` calls for improved readability and performance.
  > - Streamlined the command execution for starting the Octane server and development environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e7d616fc073e2b2714fb968f6a2186f1cef03d56"><code>e7d616f</code></a> <b>script:</b> 🔧 replace unbuffer with FORCE_COLOR for improved signal handling</summary>

  > - Removed `unbuffer` from command execution to ensure graceful shutdown on `docker stop`.
  > - Set `FORCE_COLOR=1` in Dockerfile to enable colored output without the need for `unbuffer`.
  > - Updated related commands in `compose` files to directly use `php` as PID 1 for better signal management.

  </details>
- [`90d6d04`](https://github.com/gamerlogue/web/commit/90d6d0414189eee8fd41442510573451f6255b43) **config:** 🔧 add approval mode for Laravel Boost search-docs
- [`8256cdb`](https://github.com/gamerlogue/web/commit/8256cdbd1e82ea3070cebb3b2a317d38a92b0705) **idea:** 🔧 update IDE project configuration
- [`186c39f`](https://github.com/gamerlogue/web/commit/186c39f81dfa19bf2692357d372d6c817cf8d64d) **docker:** 🔧 fix Sail service alias and MariaDB compose config
- [`eef0b4b`](https://github.com/gamerlogue/web/commit/eef0b4bd813d81804e0086bfe04478bf5d912b70) **db:** 🗑️ remove obsolete Telescope entries table migration
- [`4a9571a`](https://github.com/gamerlogue/web/commit/4a9571a81db78e55d904a95a5988e1ed393253fa) **deps:** ⬆️ update npm dependencies and lockfiles
- [`36137b1`](https://github.com/gamerlogue/web/commit/36137b1bc1298716b1b490deef406f61c2dcdee2) **ai:** 🔧 add agent guidelines and Boost MCP configuration
- [`0603f57`](https://github.com/gamerlogue/web/commit/0603f57865a2ee6f95748ce4d4ebaedd17b6eebf) 🔥 remove unused ClaudeCodeEditorTabs configuration file
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0fb2725baf7eb05df6c3f26b92e81337933cb84c"><code>0fb2725</code></a> 🔥 remove deprecated configuration files and scripts</summary>

  > - Deleted unused Caddyfile, supervisord configuration files, and related scripts to streamline the project structure.
  > - These files were no longer necessary and removing them helps reduce clutter and potential confusion for future development.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/31c9f065b991327ca84530e7f61231ea22e146e2"><code>31c9f06</code></a> 🔥 remove dead code and overlapping dependencies</summary>

  > - app/helpers.php: its only function had no callers and was force-loaded through
  >   composer's autoload.files
  > - CurrentUserFilter: OwnedLibraryEntriesExtension, auto-registered by API Platform,
  >   already scopes every query to the owner
  > - the inertiaModal route macro: unused (the inertia-modal package itself stays,
  >   resources/ts imports it)
  > - the hourly inspire command, which only wrote to the log
  > - clockwork, which overlapped with Telescope, and its route exclusions
  > - laravel/pail duplicated in require-dev, phpdocumentor/type-resolver required
  >   directly though it is transitive
  >
  > DenormalizesIris no longer defines prepareForValidation: LibraryEntryFormRequest
  > overrode it and called denormalizeIris() by hand anyway. Controller stays only
  > because soved/laravel-gdpr extends it; application controllers no longer do.

  </details>
- [`8b7f60f`](https://github.com/gamerlogue/web/commit/8b7f60ffb997c34e11c3916ab1b6869b4b63069c) 🔥 clean up unused source folders and redundant dependencies
- <details><summary><a href="https://github.com/gamerlogue/web/commit/eb8ff211da13e5607272ac38c2bc4c8123bdbaf1"><code>eb8ff21</code></a> 🐳 raise the dev memory limit to 1G</summary>

  > PHPStan exhausts the 256M default while analysing the API Platform metadata and
  > crashes its parallel workers. Development image only; production stays at 256M.

  </details>
- [`4130e82`](https://github.com/gamerlogue/web/commit/4130e82fab98669d70504216b79e123575897b78) 🐳 update Redis image to use 'redis:alpine' for consistency
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9e96fa8e7a29fbd5ae7a4fd8e22eaf1770a79767"><code>9e96fa8</code></a> 🐳 add volume mapping for local development environment</summary>

  > - This change allows the local directory to be mounted into the container, facilitating easier development and testing.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/287f73b12a3e517bc64defcbe5925a43755cc639"><code>287f73b</code></a> 🔥 drop the scaffolding example tests</summary>

  > One asserted that true is true; the other that / returns 200, which any of the
  > 51 remaining tests would catch first. tests/Unit keeps a .gitkeep: phpunit.xml
  > declares the suite, and git does not track empty directories, so a fresh clone
  > would otherwise fail with "Test directory not found".

  </details>
- [`1d7ebc0`](https://github.com/gamerlogue/web/commit/1d7ebc09729b8747dbc90f8cc424614596e97097) 🔥 remove pnpm workspace configuration file
- <details><summary><a href="https://github.com/gamerlogue/web/commit/51e40a1b5ec02dd663cec2f705a96d68de9c35cd"><code>51e40a1</code></a> 🔥 remove activate script for sail environment setup</summary>

  > - The activate.sh script has been removed as it is no longer needed for the sail environment setup.
  > - This change helps to streamline the project by eliminating unnecessary files.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e3c394662b7993f0aecf4c76427eae46bcf2e82c"><code>e3c3946</code></a> <b>idea:</b> 🔧 update GrepConsole tail history</summary>

  > Ensure IDE application logs from newer PhpStorm installations remain accessible directly within the GrepConsole plugin interface to streamline local debugging.

  </details>
- [`77b802e`](https://github.com/gamerlogue/web/commit/77b802ed2595a36395c4ccb19fcf28427c435fde) 🔧 add default interpreter configuration for Laravel Pint
- <details><summary><a href="https://github.com/gamerlogue/web/commit/8757acf9fe0d0e482cc67cd9a65a72ca0d037136"><code>8757acf</code></a> <b>deps:</b> Bump the github-actions group across 1 directory with 4 updates</summary>

  > Bumps the github-actions group with 4 updates in the / directory: [actions/checkout](https://github.com/actions/checkout), [docker/login-action](https://github.com/docker/login-action), [docker/setup-buildx-action](https://github.com/docker/setup-buildx-action) and [docker/build-push-action](https://github.com/docker/build-push-action).
  >
  >
  > Updates `actions/checkout` from 5 to 7
  > - [Release notes](https://github.com/actions/checkout/releases)
  > - [Commits](https://github.com/actions/checkout/compare/v5...v7)
  >
  > Updates `docker/login-action` from 3 to 4
  > - [Release notes](https://github.com/docker/login-action/releases)
  > - [Commits](https://github.com/docker/login-action/compare/v3...v4)
  >
  > Updates `docker/setup-buildx-action` from 3 to 4
  > - [Release notes](https://github.com/docker/setup-buildx-action/releases)
  > - [Commits](https://github.com/docker/setup-buildx-action/compare/v3...v4)
  >
  > Updates `docker/build-push-action` from 6 to 7
  > - [Release notes](https://github.com/docker/build-push-action/releases)
  > - [Commits](https://github.com/docker/build-push-action/compare/v6...v7)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: actions/checkout
  >   dependency-version: '7'
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: github-actions
  > - dependency-name: docker/build-push-action
  >   dependency-version: '7'
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: github-actions
  > - dependency-name: docker/login-action
  >   dependency-version: '4'
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: github-actions
  > - dependency-name: docker/setup-buildx-action
  >   dependency-version: '4'
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: github-actions
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e97d7e07a81fcb86cfc5fc5f5920a80355d0a5ad"><code>e97d7e0</code></a> <b>deps:</b> 🔧 update Laravel package versions for compatibility</summary>

  > - Bumped versions of several Laravel packages to ensure compatibility with the latest framework updates.
  > - Updated `laravel/fortify`, `laravel/horizon`, `laravel/octane`, and others to their respective stable versions.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fa3cf3ab874502f0ab75d5fe328edd8640cc362b"><code>fa3cf3a</code></a> <b>deps:</b> 🔧 update package versions in composer.lock</summary>

  > - Updated various package versions for compatibility and improvements
  > - Ensured alignment with the latest dependencies for better performance

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6cd40b0798acf99f0d6de1774db7f6a30a1a2165"><code>6cd40b0</code></a> 🔧 remove Composer audit step from CI workflow</summary>

  > - Simplifies the CI process by eliminating the Composer audit step, which is not critical for the current testing requirements.
  > - Already handled by Dependabot

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/14680fcfae90444ed32e5bf760f1cb05fe3b59a4"><code>14680fc</code></a> <b>deps:</b> 🔧 update dependabot configuration for multiple ecosystems</summary>

  > - Added support for bun, docker, docker-compose, and pre-commit ecosystems.
  > - Set weekly update schedule and cooldown for all dependencies.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1de4bf49267dbc5efa37f6c247faa95105219d42"><code>1de4bf4</code></a> 🔧 remove activity log migrations and unused trait from User model</summary>

  > - Cleaned up the codebase by deleting unused migration files related to activity logging.
  > - Removed the CausesActivity trait from the User model as it is no longer needed.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7259cc18c0275031d147e7f50315d541a0145bc6"><code>7259cc1</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.6.0 to 2.13.1
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.6.0...v2.13.1)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.13.1
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/596b81bd339421deaaa1ae28a85a95d7ed5d2871"><code>596b81b</code></a> <b>deps:</b> Bump mariadb in the docker-compose-images group</summary>

  > Bumps the docker-compose-images group with 1 update: mariadb.
  >
  >
  > Updates `mariadb` from 11 to 12
  >
  > ---
  > updated-dependencies:
  > - dependency-name: mariadb
  >   dependency-version: '12'
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: docker-compose-images
  > ...

  </details>
- [`e4a6c0c`](https://github.com/gamerlogue/web/commit/e4a6c0c739bc51c3abd3f055702b59aa968217cb) **compose:** 🔧 enable automatic upgrades for MariaDB
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1bbb751155fc655b40c89e298b7a2ed8961304ca"><code>1bbb751</code></a> <b>phpstan:</b> ⬆️ raise to level 6 and drop the baseline</summary>

  > The three baselined errors in User were real and are fixed rather than hidden:
  > the Attribute generics were incomplete, `explode(...)[0] ?? null` guarded an
  > offset that always exists, and email_verified_at was assigned a Carbon instance
  > where the column types as a string.
  >
  > That last one is worth knowing about: Larastan reads the $casts property but
  > not the casts() method, and types the attribute from the migration. LibraryEntry
  > uses casts(), so the style stays and mapOIDCUserinfo assigns a date string that
  > the cast parses back on read. It is the only runtime behaviour this commit
  > changes, and OidcUserMappingTest now covers it.
  >
  > Level 6 needed twelve PHPDoc annotations across form requests, models and the
  > serializer. Level 7 leaves nine errors — union narrowing on Symfony
  > interfaces, User::find() with a mixed id, serializer return types — which are
  > their own piece of work.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9bbf85388230e6fae197d0a3bcaf76a094c04797"><code>9bbf853</code></a> <b>env:</b> 🔧 document the variables the new setup needs</summary>

  > DB_ROOT_PASSWORD is required in production and must differ from DB_PASSWORD.
  > QUEUE_CONNECTION points at redis, the connection Horizon supervises. The two
  > NATIVE_AUTH_ANDROID_* keys drive the assetlinks route.
  >
  > SESSION_SECURE_COOKIE stays commented out: this file is the development
  > template and Sail serves plain HTTP, where a secure-only cookie would loop the
  > local login.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b648d57cfb434b80d573e2c00d4f4e087c326919"><code>b648d57</code></a> <b>dependencies:</b> 🔧 update composer packages and remove unused configurations</summary>

  > - Updated dependencies including `brick/math`, `guzzlehttp`, `laravel/framework`, and others in `composer.lock`.
  > - Removed unused vendor exclusions and paths from `.idea` files.

  </details>
- [`9bf30a5`](https://github.com/gamerlogue/web/commit/9bf30a5d8d4792048da82fba52dec4517ad186fd) 🔥 remove unused data source mapping file
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9b02a57247e8f9919cafd87ce48632f6986ff70b"><code>9b02a57</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update in the / directory: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.13.1 to 2.15.1
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.13.1...v2.15.1)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.13.4
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ee78df36530be983626b83558a2ee36c1527092a"><code>ee78df3</code></a> <b>deps:</b> Bump the bun-dependencies group across 1 directory with 9 updates</summary>

  > Bumps the bun-dependencies group with 9 updates in the / directory:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [@inertiajs/vue3](https://github.com/inertiajs/inertia/tree/HEAD/packages/vue3) | `3.6.1` | `3.7.0` |
  > | [vue-i18n](https://github.com/intlify/vue-i18n/tree/HEAD/packages/vue-i18n) | `11.4.8` | `11.4.10` |
  > | [@intlify/unplugin-vue-i18n](https://github.com/intlify/bundle-tools/tree/HEAD/packages/unplugin-vue-i18n) | `11.2.4` | `11.2.5` |
  > | [@types/node](https://github.com/DefinitelyTyped/DefinitelyTyped/tree/HEAD/types/node) | `26.2.0` | `26.3.0` |
  > | [eslint](https://github.com/eslint/eslint) | `10.8.1` | `10.9.1` |
  > | [fontaine](https://github.com/unjs/fontaine/tree/HEAD/packages/fontaine) | `0.8.0` | `0.8.1` |
  > | [laravel-vite-plugin](https://github.com/laravel/vite-plugin) | `3.1.3` | `3.2.0` |
  > | [sass-embedded](https://github.com/sass/embedded-host-node) | `1.100.0` | `1.103.1` |
  > | [vite](https://github.com/vitejs/vite/tree/HEAD/packages/vite) | `8.2.1` | `8.2.2` |
  >
  >
  >
  > Updates `@inertiajs/vue3` from 3.6.1 to 3.7.0
  > - [Release notes](https://github.com/inertiajs/inertia/releases)
  > - [Changelog](https://github.com/inertiajs/inertia/blob/3.x/CHANGELOG.md)
  > - [Commits](https://github.com/inertiajs/inertia/commits/v3.7.0/packages/vue3)
  >
  > Updates `vue-i18n` from 11.4.8 to 11.4.10
  > - [Release notes](https://github.com/intlify/vue-i18n/releases)
  > - [Changelog](https://github.com/intlify/vue-i18n/blob/v11.4.10/CHANGELOG.md)
  > - [Commits](https://github.com/intlify/vue-i18n/commits/v11.4.10/packages/vue-i18n)
  >
  > Updates `@intlify/unplugin-vue-i18n` from 11.2.4 to 11.2.5
  > - [Release notes](https://github.com/intlify/bundle-tools/releases)
  > - [Changelog](https://github.com/intlify/bundle-tools/blob/v11.2.5/CHANGELOG.md)
  > - [Commits](https://github.com/intlify/bundle-tools/commits/v11.2.5/packages/unplugin-vue-i18n)
  >
  > Updates `@types/node` from 26.2.0 to 26.3.0
  > - [Release notes](https://github.com/DefinitelyTyped/DefinitelyTyped/releases)
  > - [Commits](https://github.com/DefinitelyTyped/DefinitelyTyped/commits/HEAD/types/node)
  >
  > Updates `eslint` from 10.8.1 to 10.9.1
  > - [Release notes](https://github.com/eslint/eslint/releases)
  > - [Commits](https://github.com/eslint/eslint/compare/v10.8.1...v10.9.1)
  >
  > Updates `fontaine` from 0.8.0 to 0.8.1
  > - [Release notes](https://github.com/unjs/fontaine/releases)
  > - [Commits](https://github.com/unjs/fontaine/commits/fontaine@0.8.1/packages/fontaine)
  >
  > Updates `laravel-vite-plugin` from 3.1.3 to 3.2.0
  > - [Release notes](https://github.com/laravel/vite-plugin/releases)
  > - [Changelog](https://github.com/laravel/vite-plugin/blob/3.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/vite-plugin/compare/v3.1.3...v3.2.0)
  >
  > Updates `sass-embedded` from 1.100.0 to 1.103.1
  > - [Changelog](https://github.com/sass/embedded-host-node/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/sass/embedded-host-node/compare/1.100.0...1.103.1)
  >
  > Updates `vite` from 8.2.1 to 8.2.2
  > - [Release notes](https://github.com/vitejs/vite/releases)
  > - [Changelog](https://github.com/vitejs/vite/blob/main/packages/vite/CHANGELOG.md)
  > - [Commits](https://github.com/vitejs/vite/commits/v8.2.2/packages/vite)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: "@inertiajs/vue3"
  >   dependency-version: 3.7.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: vue-i18n
  >   dependency-version: 11.4.10
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@intlify/unplugin-vue-i18n"
  >   dependency-version: 11.2.5
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@types/node"
  >   dependency-version: 26.3.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: eslint
  >   dependency-version: 10.9.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: fontaine
  >   dependency-version: 0.8.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: laravel-vite-plugin
  >   dependency-version: 3.2.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: sass-embedded
  >   dependency-version: 1.103.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: vite
  >   dependency-version: 8.2.2
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/88ac79492da07bc9b35317d663e7a7e6c2f29e62"><code>88ac794</code></a> <b>deps:</b> 🔧 update dependencies in composer.json and package.json</summary>

  > - Bump versions for several packages to ensure compatibility and access to new features.
  > - Updated `emargareten/inertia-modal` to version `3.4`, `inertiajs/inertia-laravel` to `3.0`, and various other dependencies for improved functionality and security.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/4387984a9392bdb137d4dd194e79f09d674b3e36"><code>4387984</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.15.1 to 2.16.0
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.15.1...v2.16.0)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.16.0
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2ff2bc52aa75fd34b003a889c68670988b314e79"><code>2ff2bc5</code></a> <b>compose:</b> 🔧 update CADDY_HTTP_SERVER_ADDRESS for Android emulator compatibility</summary>

  > - Added support for the Android emulator to access the server through a specific IP address.
  > - Adjusted SSL_MODE to mixed to accommodate the emulator's limitations with HTTPS.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9092dc3617292eb2d8a2fb82508af2f462971584"><code>9092dc3</code></a> <b>compose:</b> 🔧 update CADDY_HTTP_SERVER_ADDRESS for native dev client compatibility</summary>

  > - Added localhost to CADDY_HTTP_SERVER_ADDRESS to support desktop app connections.
  > - Improved comments for clarity on SSL_MODE and certificate trust issues.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5521cec04a793ec78c6f266bbf8db7d8ea830d0a"><code>5521cec</code></a> 🔧 exclude inertia-devtools folder from project configuration</summary>

  > - Added exclusion for the storage/inertia-devtools folder in the project files to streamline the development environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f3d21cf6f060fbd78eb21f885cd6686384b9e3c5"><code>f3d21cf</code></a> <b>deps:</b> Bump the bun-dependencies group across 1 directory with 12 updates</summary>

  > Bumps the bun-dependencies group with 12 updates in the / directory:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [@inertiajs/vue3](https://github.com/inertiajs/inertia/tree/HEAD/packages/vue3) | `3.7.0` | `3.7.1` |
  > | [@vueuse/core](https://github.com/vueuse/vueuse/tree/HEAD/packages/core) | `14.4.0` | `15.0.0` |
  > | [vue](https://github.com/vuejs/core) | `3.5.42` | `3.5.43` |
  > | [vue-i18n](https://github.com/intlify/vue-i18n/tree/HEAD/packages/vue-i18n) | `11.4.10` | `11.4.12` |
  > | [@maicol07/eslint-config](https://github.com/maicol07/eslint-config) | `3.0.0` | `3.1.2` |
  > | [@types/node](https://github.com/DefinitelyTyped/DefinitelyTyped/tree/HEAD/types/node) | `26.4.1` | `26.6.2` |
  > | [@vitejs/plugin-vue](https://github.com/vitejs/vite-plugin-vue/tree/HEAD/packages/plugin-vue) | `6.0.8` | `6.0.9` |
  > | [eslint](https://github.com/eslint/eslint) | `10.10.0` | `10.11.0` |
  > | [fontaine](https://github.com/unjs/fontaine/tree/HEAD/packages/fontaine) | `0.8.1` | `1.0.0` |
  > | [sass-embedded](https://github.com/sass/embedded-host-node) | `1.104.0` | `1.105.0` |
  > | [type-fest](https://github.com/sindresorhus/type-fest) | `5.9.0` | `5.10.0` |
  > | [vite](https://github.com/vitejs/vite/tree/HEAD/packages/vite) | `8.2.2` | `8.3.0` |
  >
  >
  >
  > Updates `@inertiajs/vue3` from 3.7.0 to 3.7.1
  > - [Release notes](https://github.com/inertiajs/inertia/releases)
  > - [Changelog](https://github.com/inertiajs/inertia/blob/3.x/CHANGELOG.md)
  > - [Commits](https://github.com/inertiajs/inertia/commits/v3.7.1/packages/vue3)
  >
  > Updates `@vueuse/core` from 14.4.0 to 15.0.0
  > - [Release notes](https://github.com/vueuse/vueuse/releases)
  > - [Commits](https://github.com/vueuse/vueuse/commits/v15.0.0/packages/core)
  >
  > Updates `vue` from 3.5.42 to 3.5.43
  > - [Release notes](https://github.com/vuejs/core/releases)
  > - [Changelog](https://github.com/vuejs/core/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/vuejs/core/compare/v3.5.42...v3.5.43)
  >
  > Updates `vue-i18n` from 11.4.10 to 11.4.12
  > - [Release notes](https://github.com/intlify/vue-i18n/releases)
  > - [Changelog](https://github.com/intlify/vue-i18n/blob/v11.4.12/CHANGELOG.md)
  > - [Commits](https://github.com/intlify/vue-i18n/commits/v11.4.12/packages/vue-i18n)
  >
  > Updates `@maicol07/eslint-config` from 3.0.0 to 3.1.2
  > - [Commits](https://github.com/maicol07/eslint-config/commits)
  >
  > Updates `@types/node` from 26.4.1 to 26.6.2
  > - [Release notes](https://github.com/DefinitelyTyped/DefinitelyTyped/releases)
  > - [Commits](https://github.com/DefinitelyTyped/DefinitelyTyped/commits/HEAD/types/node)
  >
  > Updates `@vitejs/plugin-vue` from 6.0.8 to 6.0.9
  > - [Release notes](https://github.com/vitejs/vite-plugin-vue/releases)
  > - [Changelog](https://github.com/vitejs/vite-plugin-vue/blob/main/packages/plugin-vue/CHANGELOG.md)
  > - [Commits](https://github.com/vitejs/vite-plugin-vue/commits/plugin-vue@6.0.9/packages/plugin-vue)
  >
  > Updates `eslint` from 10.10.0 to 10.11.0
  > - [Release notes](https://github.com/eslint/eslint/releases)
  > - [Commits](https://github.com/eslint/eslint/compare/v10.10.0...v10.11.0)
  >
  > Updates `fontaine` from 0.8.1 to 1.0.0
  > - [Release notes](https://github.com/unjs/fontaine/releases)
  > - [Commits](https://github.com/unjs/fontaine/commits/fontaine@1.0.0/packages/fontaine)
  >
  > Updates `sass-embedded` from 1.104.0 to 1.105.0
  > - [Changelog](https://github.com/sass/embedded-host-node/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/sass/embedded-host-node/compare/1.104.0...1.105.0)
  >
  > Updates `type-fest` from 5.9.0 to 5.10.0
  > - [Release notes](https://github.com/sindresorhus/type-fest/releases)
  > - [Commits](https://github.com/sindresorhus/type-fest/compare/v5.9.0...v5.10.0)
  >
  > Updates `vite` from 8.2.2 to 8.3.0
  > - [Release notes](https://github.com/vitejs/vite/releases)
  > - [Changelog](https://github.com/vitejs/vite/blob/main/packages/vite/CHANGELOG.md)
  > - [Commits](https://github.com/vitejs/vite/commits/create-vite@8.3.0/packages/vite)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: "@inertiajs/vue3"
  >   dependency-version: 3.7.1
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@vueuse/core"
  >   dependency-version: 15.0.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: bun-dependencies
  > - dependency-name: vue
  >   dependency-version: 3.5.43
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: vue-i18n
  >   dependency-version: 11.4.12
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@maicol07/eslint-config"
  >   dependency-version: 3.1.2
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: "@types/node"
  >   dependency-version: 26.6.2
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: "@vitejs/plugin-vue"
  >   dependency-version: 6.0.9
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: eslint
  >   dependency-version: 10.11.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: fontaine
  >   dependency-version: 1.0.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-major
  >   dependency-group: bun-dependencies
  > - dependency-name: sass-embedded
  >   dependency-version: 1.105.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: type-fest
  >   dependency-version: 5.10.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: vite
  >   dependency-version: 8.3.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b79565bbf9e3ff04ba26514bdb8e3caf82d8d77d"><code>b79565b</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.16.0 to 2.17.0
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.16.0...v2.17.0)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.17.0
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7f6363df77b76c878e2bfaac0d2703c78fa05dce"><code>7f6363d</code></a> <b>deps:</b> Bump the composer-dependencies group across 1 directory with 15 updates</summary>

  > Bumps the composer-dependencies group with 15 updates in the / directory:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [api-platform/laravel](https://github.com/api-platform/laravel) | `4.3.18` | `5.0.0` |
  > | [emargareten/inertia-modal](https://github.com/emargareten/inertia-modal) | `3.4.0` | `3.5.0` |
  > | [inertiajs/inertia-laravel](https://github.com/inertiajs/inertia-laravel) | `3.3.3` | `3.4.0` |
  > | [laravel/framework](https://github.com/laravel/framework) | `13.30.1` | `13.33.0` |
  > | [laravel/horizon](https://github.com/laravel/horizon) | `5.48.3` | `5.50.0` |
  > | [laravel/octane](https://github.com/laravel/octane) | `2.19.1` | `2.20.0` |
  > | [laravel/telescope](https://github.com/laravel/telescope) | `5.23.0` | `5.25.0` |
  > | [maicol07/laravel-oidc-client](https://github.com/maicol07/laravel-oidc-client) | `1.1.3` | `1.1.4` |
  > | [larastan/larastan](https://github.com/larastan/larastan) | `3.11.0` | `3.12.2` |
  > | [laravel-lang/lang](https://github.com/Laravel-Lang/lang) | `15.34.8` | `15.36.0` |
  > | [laravel/boost](https://github.com/laravel/boost) | `2.7.0` | `2.9.1` |
  > | [laravel/pint](https://github.com/laravel/pint) | `1.30.5` | `1.32.1` |
  > | [laravel/pao](https://github.com/laravel/pao) | `1.1.4` | `1.1.5` |
  > | [laravel/sail](https://github.com/laravel/sail) | `1.67.0` | `1.68.0` |
  > | [pestphp/pest](https://github.com/pestphp/pest) | `5.1.3` | `5.2.1` |
  >
  >
  >
  > Updates `api-platform/laravel` from 4.3.18 to 5.0.0
  > - [Commits](https://github.com/api-platform/laravel/compare/v4.3.18...v5.0.0)
  >
  > Updates `emargareten/inertia-modal` from 3.4.0 to 3.5.0
  > - [Release notes](https://github.com/emargareten/inertia-modal/releases)
  > - [Changelog](https://github.com/emargareten/inertia-modal/blob/master/CHANGELOG.md)
  > - [Commits](https://github.com/emargareten/inertia-modal/compare/v3.4.0...v3.5.0)
  >
  > Updates `inertiajs/inertia-laravel` from 3.3.3 to 3.4.0
  > - [Release notes](https://github.com/inertiajs/inertia-laravel/releases)
  > - [Changelog](https://github.com/inertiajs/inertia-laravel/blob/3.x/CHANGELOG.md)
  > - [Commits](https://github.com/inertiajs/inertia-laravel/compare/v3.3.3...v3.4.0)
  >
  > Updates `laravel/framework` from 13.30.1 to 13.33.0
  > - [Release notes](https://github.com/laravel/framework/releases)
  > - [Changelog](https://github.com/laravel/framework/blob/13.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/framework/compare/v13.30.1...v13.33.0)
  >
  > Updates `laravel/horizon` from 5.48.3 to 5.50.0
  > - [Release notes](https://github.com/laravel/horizon/releases)
  > - [Changelog](https://github.com/laravel/horizon/blob/5.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/horizon/compare/v5.48.3...v5.50.0)
  >
  > Updates `laravel/octane` from 2.19.1 to 2.20.0
  > - [Release notes](https://github.com/laravel/octane/releases)
  > - [Changelog](https://github.com/laravel/octane/blob/2.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/octane/compare/v2.19.1...v2.20.0)
  >
  > Updates `laravel/telescope` from 5.23.0 to 5.25.0
  > - [Release notes](https://github.com/laravel/telescope/releases)
  > - [Changelog](https://github.com/laravel/telescope/blob/5.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/telescope/compare/v5.23.0...v5.25.0)
  >
  > Updates `maicol07/laravel-oidc-client` from 1.1.3 to 1.1.4
  > - [Release notes](https://github.com/maicol07/laravel-oidc-client/releases)
  > - [Commits](https://github.com/maicol07/laravel-oidc-client/compare/1.1.3...1.1.4)
  >
  > Updates `larastan/larastan` from 3.11.0 to 3.12.2
  > - [Release notes](https://github.com/larastan/larastan/releases)
  > - [Changelog](https://github.com/larastan/larastan/blob/3.x/RELEASE.md)
  > - [Commits](https://github.com/larastan/larastan/compare/v3.11.0...v3.12.2)
  >
  > Updates `laravel-lang/lang` from 15.34.8 to 15.36.0
  > - [Release notes](https://github.com/Laravel-Lang/lang/releases)
  > - [Commits](https://github.com/Laravel-Lang/lang/compare/15.34.8...15.36.0)
  >
  > Updates `laravel/boost` from 2.7.0 to 2.9.1
  > - [Release notes](https://github.com/laravel/boost/releases)
  > - [Changelog](https://github.com/laravel/boost/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/boost/compare/v2.7.0...v2.9.1)
  >
  > Updates `laravel/pint` from 1.30.5 to 1.32.1
  > - [Release notes](https://github.com/laravel/pint/releases)
  > - [Changelog](https://github.com/laravel/pint/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/pint/compare/v1.30.5...v1.32.1)
  >
  > Updates `laravel/pao` from 1.1.4 to 1.1.5
  > - [Release notes](https://github.com/laravel/pao/releases)
  > - [Commits](https://github.com/laravel/pao/compare/v1.1.4...v1.1.5)
  >
  > Updates `laravel/sail` from 1.67.0 to 1.68.0
  > - [Release notes](https://github.com/laravel/sail/releases)
  > - [Changelog](https://github.com/laravel/sail/blob/1.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/sail/compare/v1.67.0...v1.68.0)
  >
  > Updates `pestphp/pest` from 5.1.3 to 5.2.1
  > - [Release notes](https://github.com/pestphp/pest/releases)
  > - [Changelog](https://github.com/pestphp/pest/blob/5.x/RELEASE.md)
  > - [Commits](https://github.com/pestphp/pest/compare/v5.1.3...v5.2.1)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: api-platform/laravel
  >   dependency-version: 5.0.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: composer-dependencies
  > - dependency-name: emargareten/inertia-modal
  >   dependency-version: 3.5.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: inertiajs/inertia-laravel
  >   dependency-version: 3.4.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/framework
  >   dependency-version: 13.33.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/horizon
  >   dependency-version: 5.50.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/octane
  >   dependency-version: 2.20.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/telescope
  >   dependency-version: 5.25.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: maicol07/laravel-oidc-client
  >   dependency-version: 1.1.4
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: larastan/larastan
  >   dependency-version: 3.12.2
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel-lang/lang
  >   dependency-version: 15.36.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/boost
  >   dependency-version: 2.9.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/pint
  >   dependency-version: 1.32.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/pao
  >   dependency-version: 1.1.5
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/sail
  >   dependency-version: 1.68.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: pestphp/pest
  >   dependency-version: 5.2.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/67f3e354d272c8c37c1c01a5f4d4cf09ea604de3"><code>67f3e35</code></a> <b>deps:</b> Bump mariadb in the docker-compose-images group</summary>

  > Bumps the docker-compose-images group with 1 update: mariadb.
  >
  >
  > Updates `mariadb` from 12 to 13
  >
  > ---
  > updated-dependencies:
  > - dependency-name: mariadb
  >   dependency-version: '13'
  >   dependency-type: direct:production
  >   update-type: version-update:semver-major
  >   dependency-group: docker-compose-images
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/22166fab88e6fc0b4c5dedb389d89ae9599dd8c7"><code>22166fa</code></a> <b>deps:</b> Bump league&#x2F;commonmark from 2.10.0 to 2.10.3</summary>

  > Bumps [league/commonmark](https://github.com/thephpleague/commonmark) from 2.10.0 to 2.10.3.
  > - [Release notes](https://github.com/thephpleague/commonmark/releases)
  > - [Changelog](https://github.com/thephpleague/commonmark/blob/2.10/CHANGELOG.md)
  > - [Commits](https://github.com/thephpleague/commonmark/compare/2.10.0...2.10.3)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: league/commonmark
  >   dependency-version: 2.10.3
  >   dependency-type: indirect
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3a331f4e102ebc219c5fdb588c53b4d43ef2f753"><code>3a331f4</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.17.0 to 2.18.2
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.17.0...v2.18.2)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.18.2
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/750c3df1cd46ac1befb24bbb2e0375957e85b47d"><code>750c3df</code></a> <b>deps:</b> Bump the composer-dependencies group with 6 updates</summary>

  > Bumps the composer-dependencies group with 6 updates:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [api-platform/laravel](https://github.com/api-platform/laravel) | `5.0.0` | `5.0.1` |
  > | [laravel/framework](https://github.com/laravel/framework) | `13.33.0` | `13.34.0` |
  > | [phpdocumentor/type-resolver](https://github.com/phpDocumentor/TypeResolver) | `2.0.0` | `2.1.0` |
  > | [fumeapp/modeltyper](https://github.com/fumeapp/modeltyper) | `3.13.0` | `3.14.0` |
  > | [laravel-lang/lang](https://github.com/Laravel-Lang/lang) | `15.36.0` | `15.37.1` |
  > | [laravel/boost](https://github.com/laravel/boost) | `2.9.1` | `2.10.0` |
  >
  >
  > Updates `api-platform/laravel` from 5.0.0 to 5.0.1
  > - [Commits](https://github.com/api-platform/laravel/compare/v5.0.0...v5.0.1)
  >
  > Updates `laravel/framework` from 13.33.0 to 13.34.0
  > - [Release notes](https://github.com/laravel/framework/releases)
  > - [Changelog](https://github.com/laravel/framework/blob/13.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/framework/compare/v13.33.0...v13.34.0)
  >
  > Updates `phpdocumentor/type-resolver` from 2.0.0 to 2.1.0
  > - [Release notes](https://github.com/phpDocumentor/TypeResolver/releases)
  > - [Commits](https://github.com/phpDocumentor/TypeResolver/compare/2.0.0...2.1.0)
  >
  > Updates `fumeapp/modeltyper` from 3.13.0 to 3.14.0
  > - [Release notes](https://github.com/fumeapp/modeltyper/releases)
  > - [Commits](https://github.com/fumeapp/modeltyper/compare/v3.13.0...v3.14.0)
  >
  > Updates `laravel-lang/lang` from 15.36.0 to 15.37.1
  > - [Release notes](https://github.com/Laravel-Lang/lang/releases)
  > - [Commits](https://github.com/Laravel-Lang/lang/compare/15.36.0...15.37.1)
  >
  > Updates `laravel/boost` from 2.9.1 to 2.10.0
  > - [Release notes](https://github.com/laravel/boost/releases)
  > - [Changelog](https://github.com/laravel/boost/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/boost/compare/v2.9.1...v2.10.0)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: api-platform/laravel
  >   dependency-version: 5.0.1
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/framework
  >   dependency-version: 13.34.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: phpdocumentor/type-resolver
  >   dependency-version: 2.1.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: fumeapp/modeltyper
  >   dependency-version: 3.14.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel-lang/lang
  >   dependency-version: 15.37.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/boost
  >   dependency-version: 2.10.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f902ece05576c9c984124d2d3bc22ba14df3e69e"><code>f902ece</code></a> <b>deps-dev:</b> Bump the bun-dependencies group with 2 updates</summary>

  > Bumps the bun-dependencies group with 2 updates: [@types/node](https://github.com/DefinitelyTyped/DefinitelyTyped/tree/HEAD/types/node) and [vite](https://github.com/vitejs/vite/tree/HEAD/packages/vite).
  >
  >
  > Updates `@types/node` from 26.6.2 to 26.6.3
  > - [Release notes](https://github.com/DefinitelyTyped/DefinitelyTyped/releases)
  > - [Commits](https://github.com/DefinitelyTyped/DefinitelyTyped/commits/HEAD/types/node)
  >
  > Updates `vite` from 8.3.0 to 8.3.1
  > - [Release notes](https://github.com/vitejs/vite/releases)
  > - [Changelog](https://github.com/vitejs/vite/blob/main/packages/vite/CHANGELOG.md)
  > - [Commits](https://github.com/vitejs/vite/commits/v8.3.1/packages/vite)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: "@types/node"
  >   dependency-version: 26.6.3
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: vite
  >   dependency-version: 8.3.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > ...

  </details>
- [`6880238`](https://github.com/gamerlogue/web/commit/688023830d52e2c95d1bcd1819c8db4e32eb8010) **vcs:** ✨ add commit message inspection profile for better formatting checks
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cc2f4f51c09b1914e4f66d3cdeecdac706468981"><code>cc2f4f5</code></a> <b>mcpServer:</b> ✨ add auto-approve and review options</summary>

  > - Enabled auto-approval for agent edits to streamline the editing process.
  > - Added an option to show reviews in the editor for better visibility.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b3fcdb118d91cd94c79084f45a434b765bfb7229"><code>b3fcdb1</code></a> 🔧 update project configuration to include additional test directories and vendor paths</summary>

  > - Added new test source folders for Feature and Unit tests
  > - Updated include paths for various vendor packages

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/80459b8ca9ce391693a40e5d40066926707a2f3c"><code>80459b8</code></a> <b>deps:</b> Bump shivammathur&#x2F;setup-php (#36)</summary>

  > Bumps the github-actions group with 1 update: [shivammathur/setup-php](https://github.com/shivammathur/setup-php).
  >
  >
  > Updates `shivammathur/setup-php` from 2.37.2 to 2.40.0
  > - [Release notes](https://github.com/shivammathur/setup-php/releases)
  > - [Commits](https://github.com/shivammathur/setup-php/compare/f3e473d116dcccaddc5834248c87452386958240...eb7c497e18156a6bbabfef1d3a82760b9eda3962)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: shivammathur/setup-php
  >   dependency-version: 2.40.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: github-actions
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6515fd8f59a4a18a67d13605986d8161e3355ba0"><code>6515fd8</code></a> <b>deps:</b> Bump the composer-dependencies group across 1 directory with 11 updates</summary>

  > Bumps the composer-dependencies group with 11 updates in the / directory:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [api-platform/laravel](https://github.com/api-platform/laravel) | `5.0.1` | `5.0.3` |
  > | [inertiajs/inertia-laravel](https://github.com/inertiajs/inertia-laravel) | `3.4.0` | `3.5.1` |
  > | [laravel/framework](https://github.com/laravel/framework) | `13.34.0` | `13.37.0` |
  > | [laravel/horizon](https://github.com/laravel/horizon) | `5.50.0` | `5.50.1` |
  > | [laravel/octane](https://github.com/laravel/octane) | `2.20.0` | `2.21.0` |
  > | [laravel/telescope](https://github.com/laravel/telescope) | `5.25.0` | `5.26.0` |
  > | [larastan/larastan](https://github.com/larastan/larastan) | `3.12.2` | `3.13.0` |
  > | [laravel-lang/lang](https://github.com/Laravel-Lang/lang) | `15.37.1` | `15.37.4` |
  > | [laravel/boost](https://github.com/laravel/boost) | `2.10.0` | `2.10.3` |
  > | [laravel/sail](https://github.com/laravel/sail) | `1.68.0` | `1.69.0` |
  > | [pestphp/pest](https://github.com/pestphp/pest) | `5.2.1` | `5.3.2` |
  >
  >
  >
  > Updates `api-platform/laravel` from 5.0.1 to 5.0.3
  > - [Commits](https://github.com/api-platform/laravel/compare/v5.0.1...v5.0.3)
  >
  > Updates `inertiajs/inertia-laravel` from 3.4.0 to 3.5.1
  > - [Release notes](https://github.com/inertiajs/inertia-laravel/releases)
  > - [Changelog](https://github.com/inertiajs/inertia-laravel/blob/3.x/CHANGELOG.md)
  > - [Commits](https://github.com/inertiajs/inertia-laravel/compare/v3.4.0...v3.5.1)
  >
  > Updates `laravel/framework` from 13.34.0 to 13.37.0
  > - [Release notes](https://github.com/laravel/framework/releases)
  > - [Changelog](https://github.com/laravel/framework/blob/13.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/framework/compare/v13.34.0...v13.37.0)
  >
  > Updates `laravel/horizon` from 5.50.0 to 5.50.1
  > - [Release notes](https://github.com/laravel/horizon/releases)
  > - [Changelog](https://github.com/laravel/horizon/blob/5.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/horizon/compare/v5.50.0...v5.50.1)
  >
  > Updates `laravel/octane` from 2.20.0 to 2.21.0
  > - [Release notes](https://github.com/laravel/octane/releases)
  > - [Changelog](https://github.com/laravel/octane/blob/2.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/octane/compare/v2.20.0...v2.21.0)
  >
  > Updates `laravel/telescope` from 5.25.0 to 5.26.0
  > - [Release notes](https://github.com/laravel/telescope/releases)
  > - [Changelog](https://github.com/laravel/telescope/blob/5.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/telescope/compare/v5.25.0...v5.26.0)
  >
  > Updates `larastan/larastan` from 3.12.2 to 3.13.0
  > - [Release notes](https://github.com/larastan/larastan/releases)
  > - [Changelog](https://github.com/larastan/larastan/blob/3.x/RELEASE.md)
  > - [Commits](https://github.com/larastan/larastan/compare/v3.12.2...v3.13.0)
  >
  > Updates `laravel-lang/lang` from 15.37.1 to 15.37.4
  > - [Release notes](https://github.com/Laravel-Lang/lang/releases)
  > - [Commits](https://github.com/Laravel-Lang/lang/compare/15.37.1...15.37.4)
  >
  > Updates `laravel/boost` from 2.10.0 to 2.10.3
  > - [Release notes](https://github.com/laravel/boost/releases)
  > - [Changelog](https://github.com/laravel/boost/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/boost/compare/v2.10.0...v2.10.3)
  >
  > Updates `laravel/sail` from 1.68.0 to 1.69.0
  > - [Release notes](https://github.com/laravel/sail/releases)
  > - [Changelog](https://github.com/laravel/sail/blob/1.x/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/sail/compare/v1.68.0...v1.69.0)
  >
  > Updates `pestphp/pest` from 5.2.1 to 5.3.2
  > - [Release notes](https://github.com/pestphp/pest/releases)
  > - [Changelog](https://github.com/pestphp/pest/blob/5.x/RELEASE.md)
  > - [Commits](https://github.com/pestphp/pest/compare/v5.2.1...v5.3.2)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: api-platform/laravel
  >   dependency-version: 5.0.3
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: inertiajs/inertia-laravel
  >   dependency-version: 3.5.1
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/framework
  >   dependency-version: 13.37.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/horizon
  >   dependency-version: 5.50.1
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/octane
  >   dependency-version: 2.21.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/telescope
  >   dependency-version: 5.26.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: larastan/larastan
  >   dependency-version: 3.13.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel-lang/lang
  >   dependency-version: 15.37.4
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/boost
  >   dependency-version: 2.10.3
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: composer-dependencies
  > - dependency-name: laravel/sail
  >   dependency-version: 1.69.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > - dependency-name: pestphp/pest
  >   dependency-version: 5.3.2
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: composer-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2d8dfebc2f20e43da288a72e7767eb407771fb7a"><code>2d8dfeb</code></a> <b>deps:</b> Bump the bun-dependencies group across 1 directory with 11 updates</summary>

  > Bumps the bun-dependencies group with 11 updates in the / directory:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [@inertiajs/vue3](https://github.com/inertiajs/inertia/tree/HEAD/packages/vue3) | `3.7.1` | `3.9.1` |
  > | [ts-pattern](https://github.com/gvergnaud/ts-pattern) | `5.9.0` | `5.9.1` |
  > | [vue](https://github.com/vuejs/core) | `3.5.43` | `3.5.44` |
  > | [vue-i18n](https://github.com/intlify/vue-i18n/tree/HEAD/packages/vue-i18n) | `11.4.12` | `11.4.14` |
  > | [@types/node](https://github.com/DefinitelyTyped/DefinitelyTyped/tree/HEAD/types/node) | `26.6.3` | `26.6.5` |
  > | [@vitejs/plugin-vue](https://github.com/vitejs/vite-plugin-vue/tree/HEAD/packages/plugin-vue) | `6.0.9` | `6.0.10` |
  > | [eslint](https://github.com/eslint/eslint) | `10.11.0` | `10.12.0` |
  > | [fontaine](https://github.com/unjs/fontaine/tree/HEAD/packages/fontaine) | `1.0.0` | `1.0.1` |
  > | [sass-embedded](https://github.com/sass/embedded-host-node) | `1.105.0` | `1.105.1` |
  > | [stylelint](https://github.com/stylelint/stylelint) | `17.15.0` | `17.16.0` |
  > | [vite](https://github.com/vitejs/vite/tree/HEAD/packages/vite) | `8.3.1` | `8.3.4` |
  >
  >
  >
  > Updates `@inertiajs/vue3` from 3.7.1 to 3.9.1
  > - [Release notes](https://github.com/inertiajs/inertia/releases)
  > - [Changelog](https://github.com/inertiajs/inertia/blob/3.x/CHANGELOG.md)
  > - [Commits](https://github.com/inertiajs/inertia/commits/v3.9.1/packages/vue3)
  >
  > Updates `ts-pattern` from 5.9.0 to 5.9.1
  > - [Release notes](https://github.com/gvergnaud/ts-pattern/releases)
  > - [Commits](https://github.com/gvergnaud/ts-pattern/compare/v5.9.0...v5.9.1)
  >
  > Updates `vue` from 3.5.43 to 3.5.44
  > - [Release notes](https://github.com/vuejs/core/releases)
  > - [Changelog](https://github.com/vuejs/core/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/vuejs/core/compare/v3.5.43...v3.5.44)
  >
  > Updates `vue-i18n` from 11.4.12 to 11.4.14
  > - [Release notes](https://github.com/intlify/vue-i18n/releases)
  > - [Changelog](https://github.com/intlify/vue-i18n/blob/v11.4.14/CHANGELOG.md)
  > - [Commits](https://github.com/intlify/vue-i18n/commits/v11.4.14/packages/vue-i18n)
  >
  > Updates `@types/node` from 26.6.3 to 26.6.5
  > - [Release notes](https://github.com/DefinitelyTyped/DefinitelyTyped/releases)
  > - [Commits](https://github.com/DefinitelyTyped/DefinitelyTyped/commits/HEAD/types/node)
  >
  > Updates `@vitejs/plugin-vue` from 6.0.9 to 6.0.10
  > - [Release notes](https://github.com/vitejs/vite-plugin-vue/releases)
  > - [Changelog](https://github.com/vitejs/vite-plugin-vue/blob/main/packages/plugin-vue/CHANGELOG.md)
  > - [Commits](https://github.com/vitejs/vite-plugin-vue/commits/plugin-vue@6.0.10/packages/plugin-vue)
  >
  > Updates `eslint` from 10.11.0 to 10.12.0
  > - [Release notes](https://github.com/eslint/eslint/releases)
  > - [Commits](https://github.com/eslint/eslint/compare/v10.11.0...v10.12.0)
  >
  > Updates `fontaine` from 1.0.0 to 1.0.1
  > - [Release notes](https://github.com/unjs/fontaine/releases)
  > - [Commits](https://github.com/unjs/fontaine/commits/fontaine@1.0.1/packages/fontaine)
  >
  > Updates `sass-embedded` from 1.105.0 to 1.105.1
  > - [Changelog](https://github.com/sass/embedded-host-node/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/sass/embedded-host-node/compare/1.105.0...1.105.1)
  >
  > Updates `stylelint` from 17.15.0 to 17.16.0
  > - [Release notes](https://github.com/stylelint/stylelint/releases)
  > - [Changelog](https://github.com/stylelint/stylelint/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/stylelint/stylelint/compare/17.15.0...17.16.0)
  >
  > Updates `vite` from 8.3.1 to 8.3.4
  > - [Release notes](https://github.com/vitejs/vite/releases)
  > - [Changelog](https://github.com/vitejs/vite/blob/main/packages/vite/CHANGELOG.md)
  > - [Commits](https://github.com/vitejs/vite/commits/v8.3.4/packages/vite)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: "@inertiajs/vue3"
  >   dependency-version: 3.9.1
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: ts-pattern
  >   dependency-version: 5.9.1
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: vue
  >   dependency-version: 3.5.44
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: vue-i18n
  >   dependency-version: 11.4.14
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@types/node"
  >   dependency-version: 26.6.5
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@vitejs/plugin-vue"
  >   dependency-version: 6.0.10
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: eslint
  >   dependency-version: 10.12.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: fontaine
  >   dependency-version: 1.0.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: sass-embedded
  >   dependency-version: 1.105.1
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: stylelint
  >   dependency-version: 17.16.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: vite
  >   dependency-version: 8.3.4
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b791b9d307a1cd9ccf8ab740a0c14fd82b800c0f"><code>b791b9d</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.18.2 to 2.18.3
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.18.2...v2.18.3)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.18.3
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- [`5d0482f`](https://github.com/gamerlogue/web/commit/5d0482f978a5b884c4a52b763058fccca395e2ac) **deps:** 🔄 update dependencies in composer.lock
- [`4a6aece`](https://github.com/gamerlogue/web/commit/4a6aece39072a1697bd6b749b8772bd10111b88a) **lang:** 🌐 update translations for environment file and password messages in 'en' and 'it'
- <details><summary><a href="https://github.com/gamerlogue/web/commit/04371dee3defc80da3fbd8e332ba7531eac2e4c6"><code>04371de</code></a> 🔧 update project files to include new vendor paths in IDE settings</summary>

  > - Added include and exclude paths for `forxer/gravatar`, `forxer/laravel-gravatar`, and `symfony/polyfill-time` in `.idea/php.xml` and `.idea/gamerlogue_web.iml`.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ddd6b4fbb3e9d781253051b525f525f21cc8d529"><code>ddd6b4f</code></a> <b>deps:</b> Bump taiki-e&#x2F;install-action (#41)</summary>

  > Bumps the github-actions group with 1 update: [taiki-e/install-action](https://github.com/taiki-e/install-action).
  >
  >
  > Updates `taiki-e/install-action` from 2.87.27 to 2.87.29
  > - [Release notes](https://github.com/taiki-e/install-action/releases)
  > - [Changelog](https://github.com/taiki-e/install-action/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/taiki-e/install-action/compare/ab6895351a88b908e96a4697860d4ffea5e57dbe...8cca0918f8471c33515202b73f56ab27f2bed283)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: taiki-e/install-action
  >   dependency-version: 2.87.29
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: github-actions
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/aad14fc1cf5e486da5da8d0b5093607516a399fd"><code>aad14fc</code></a> <b>deps:</b> Bump the bun-dependencies group with 7 updates</summary>

  > Bumps the bun-dependencies group with 7 updates:
  >
  > | Package | From | To |
  > | --- | --- | --- |
  > | [ts-pattern](https://github.com/gvergnaud/ts-pattern) | `5.9.1` | `5.9.2` |
  > | [vue-i18n](https://github.com/intlify/vue-i18n/tree/HEAD/packages/vue-i18n) | `11.4.14` | `11.4.16` |
  > | [@intlify/unplugin-vue-i18n](https://github.com/intlify/bundle-tools/tree/HEAD/packages/unplugin-vue-i18n) | `11.2.5` | `11.2.7` |
  > | [@laravel/vite-plugin-wayfinder](https://github.com/laravel/vite-plugin-wayfinder) | `0.1.10` | `0.1.11` |
  > | [@maicol07/eslint-config](https://github.com/maicol07/eslint-config) | `3.1.2` | `3.1.3` |
  > | [eslint](https://github.com/eslint/eslint) | `10.12.0` | `10.13.0` |
  > | [sass-embedded](https://github.com/sass/embedded-host-node) | `1.105.1` | `1.105.2` |
  >
  >
  > Updates `ts-pattern` from 5.9.1 to 5.9.2
  > - [Release notes](https://github.com/gvergnaud/ts-pattern/releases)
  > - [Commits](https://github.com/gvergnaud/ts-pattern/compare/v5.9.1...v5.9.2)
  >
  > Updates `vue-i18n` from 11.4.14 to 11.4.16
  > - [Release notes](https://github.com/intlify/vue-i18n/releases)
  > - [Changelog](https://github.com/intlify/vue-i18n/blob/v11.4.16/CHANGELOG.md)
  > - [Commits](https://github.com/intlify/vue-i18n/commits/v11.4.16/packages/vue-i18n)
  >
  > Updates `@intlify/unplugin-vue-i18n` from 11.2.5 to 11.2.7
  > - [Release notes](https://github.com/intlify/bundle-tools/releases)
  > - [Changelog](https://github.com/intlify/bundle-tools/blob/v11.2.7/CHANGELOG.md)
  > - [Commits](https://github.com/intlify/bundle-tools/commits/v11.2.7/packages/unplugin-vue-i18n)
  >
  > Updates `@laravel/vite-plugin-wayfinder` from 0.1.10 to 0.1.11
  > - [Release notes](https://github.com/laravel/vite-plugin-wayfinder/releases)
  > - [Changelog](https://github.com/laravel/vite-plugin-wayfinder/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/laravel/vite-plugin-wayfinder/compare/v0.1.10...v0.1.11)
  >
  > Updates `@maicol07/eslint-config` from 3.1.2 to 3.1.3
  > - [Commits](https://github.com/maicol07/eslint-config/compare/3.1.2...3.1.3)
  >
  > Updates `eslint` from 10.12.0 to 10.13.0
  > - [Release notes](https://github.com/eslint/eslint/releases)
  > - [Commits](https://github.com/eslint/eslint/compare/v10.12.0...v10.13.0)
  >
  > Updates `sass-embedded` from 1.105.1 to 1.105.2
  > - [Changelog](https://github.com/sass/embedded-host-node/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/sass/embedded-host-node/compare/1.105.1...1.105.2)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: ts-pattern
  >   dependency-version: 5.9.2
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: vue-i18n
  >   dependency-version: 11.4.16
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@intlify/unplugin-vue-i18n"
  >   dependency-version: 11.2.7
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@laravel/vite-plugin-wayfinder"
  >   dependency-version: 0.1.11
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: "@maicol07/eslint-config"
  >   dependency-version: 3.1.3
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > - dependency-name: eslint
  >   dependency-version: 10.13.0
  >   dependency-type: direct:development
  >   update-type: version-update:semver-minor
  >   dependency-group: bun-dependencies
  > - dependency-name: sass-embedded
  >   dependency-version: 1.105.2
  >   dependency-type: direct:development
  >   update-type: version-update:semver-patch
  >   dependency-group: bun-dependencies
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/1de4a852728180e1f952658e67f307db7294b599"><code>1de4a85</code></a> <b>deps:</b> Bump https:&#x2F;&#x2F;github.com&#x2F;commit-check&#x2F;commit-check</summary>

  > Bumps the pre-commit-hooks group with 1 update: [https://github.com/commit-check/commit-check](https://github.com/commit-check/commit-check).
  >
  >
  > Updates `https://github.com/commit-check/commit-check` from v2.18.3 to 2.19.2
  > - [Release notes](https://github.com/commit-check/commit-check/releases)
  > - [Commits](https://github.com/commit-check/commit-check/compare/v2.18.3...v2.19.2)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: https://github.com/commit-check/commit-check
  >   dependency-version: 2.19.2
  >   dependency-type: direct:production
  >   dependency-group: pre-commit-hooks
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/11952733e05b14397af2dbf1b529c4099cd935b9"><code>1195273</code></a> <b>deps:</b> Bump taiki-e&#x2F;install-action (#44)</summary>

  > Bumps the github-actions group with 1 update: [taiki-e/install-action](https://github.com/taiki-e/install-action).
  >
  >
  > Updates `taiki-e/install-action` from 2.87.29 to 2.87.32
  > - [Release notes](https://github.com/taiki-e/install-action/releases)
  > - [Changelog](https://github.com/taiki-e/install-action/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/taiki-e/install-action/compare/8cca0918f8471c33515202b73f56ab27f2bed283...5488ac5a951645ce95062214902ac4b6bc1a1037)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: taiki-e/install-action
  >   dependency-version: 2.87.32
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: github-actions
  > ...

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f2c86eb38d24cc2bd1656765959c3bc743a57196"><code>f2c86eb</code></a> <b>env:</b> 🔧 update IGDB proxy rate limit to 100</summary>

  > - Increased the default rate limit for the IGDB proxy to improve performance and accommodate higher traffic.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f1c866dab5de3ddd29f8690496b6516cf690cdc4"><code>f1c866d</code></a> <b>deps:</b> Bump taiki-e&#x2F;install-action (#46)</summary>

  > Bumps the github-actions group with 1 update: [taiki-e/install-action](https://github.com/taiki-e/install-action).
  >
  >
  > Updates `taiki-e/install-action` from 2.87.32 to 2.90.0
  > - [Release notes](https://github.com/taiki-e/install-action/releases)
  > - [Changelog](https://github.com/taiki-e/install-action/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/taiki-e/install-action/compare/5488ac5a951645ce95062214902ac4b6bc1a1037...b80e2bb2635f28eb98b9fce1e2f0887e1535c6b2)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: taiki-e/install-action
  >   dependency-version: 2.90.0
  >   dependency-type: direct:production
  >   update-type: version-update:semver-minor
  >   dependency-group: github-actions
  > ...

  </details>
- [`948051d`](https://github.com/gamerlogue/web/commit/948051dcc4acdff40cf846fc40fe7e5d94f51e8b) Upgraded Composer dependencies
- [`213b8c7`](https://github.com/gamerlogue/web/commit/213b8c7444650f8f91e5d32eb9965cded30548a0) Forced PNPM package manager
- [`a9c03cb`](https://github.com/gamerlogue/web/commit/a9c03cb7e818fb8e305accfd56da74f78fcfbb0c) Updated 🙈 gitignore file
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9edb792810c25e79bc3eed941229bbd2ba33c0b2"><code>9edb792</code></a> <b>deps:</b> Added error solutions</summary>

  > Additional solutions displayed in the error page

  </details>
- [`00f35fb`](https://github.com/gamerlogue/web/commit/00f35fb22643122d8b1abcb9ba5bf1ab506b0b87) **deps:** Added ESLint
- [`4433321`](https://github.com/gamerlogue/web/commit/44333216d8d206f5b49051107551a6b7c80ae2d1) **deps:** Added Stylelint
- [`352b23b`](https://github.com/gamerlogue/web/commit/352b23b99e6611131650d69810c92932331e483c) **deps:** ➕ Added SCSS and TS support
- [`4acc1ad`](https://github.com/gamerlogue/web/commit/4acc1ad69aff11b7e55f4b5a8afc92e4d84544ed) **deps:** ⬆️ Upgraded Node dependencies
- [`f7a8bfc`](https://github.com/gamerlogue/web/commit/f7a8bfc501df4068d57f44d0df0008bf9183eae3) 🔧 Added configuration for Laravel Sail
- [`2dd3dd9`](https://github.com/gamerlogue/web/commit/2dd3dd91e96651c8185683672c0811216c03a00c) 🔧 Added PHPStorm config files
- [`59163c3`](https://github.com/gamerlogue/web/commit/59163c3ffd87b8642436db2848dbececa513e322) 🔧 Added PHPStorm config files
- [`1411fc6`](https://github.com/gamerlogue/web/commit/1411fc6b8eeaccd343e4cfc99590aa78d5642636) 🙈 Excluded public vendor folder in gitignore
- [`2691d34`](https://github.com/gamerlogue/web/commit/2691d34b3ded56fb4f4d5d30d471444a9cb996a3) Changed DB host port
- [`bcc052c`](https://github.com/gamerlogue/web/commit/bcc052c1544317d86d7f7de8a2482e425ddc94bc) Changed DB vars name
- [`f44e0f7`](https://github.com/gamerlogue/web/commit/f44e0f7b155bda77f952eae9556d2b1d0db7c876) **ide:** Remove project interpreter from PHPStorm config
- [`7a7b942`](https://github.com/gamerlogue/web/commit/7a7b94270f4c026e523906b207b7f697d6931e3f) **ide:** 🔧 Added new folders and blade directives to PHPStorm config
- [`747891a`](https://github.com/gamerlogue/web/commit/747891a76fd98989752d84a3881a9dc3a3ff535f) 🙈 Added more excluded folders to gitignore
- [`2020c3b`](https://github.com/gamerlogue/web/commit/2020c3b55d3967709793abb28f2a410e26706a60) 🙈 Added more excluded folders to gitignore
- [`b4f624e`](https://github.com/gamerlogue/web/commit/b4f624e405da79cd8942f32c97530c0706d25344) **deps:** ⬆️ Upgraded dependencies
- <details><summary><a href="https://github.com/gamerlogue/web/commit/18a64eb758a828541b994ac937193a994184e2f9"><code>18a64eb</code></a> <b>gitignore:</b> 📝 Update .gitignore with recommended templates</summary>

  > Updates the .gitignore file to include recommended templates from toptal.com.
  >
  > - Adds entries for Git, Linux, macOS, Windows, PhpStorm, and Visual Studio Code.
  > - Improves exclusion of IDE-specific files.
  > - Enhances general cleanup.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/25150cc71042e90cf4b19d4d6459ffe192b3d3fb"><code>25150cc</code></a> <b>gitignore:</b> 🙈 Update .gitignore with latest templates</summary>

  > Updates the .gitignore file to include more comprehensive templates.
  >
  > - Adds templates for Git, Linux, macOS, Windows, PhpStorm+iml, and VisualStudioCode.
  > - Includes specific exclusions for IDE-generated files and directories.
  > - Improves default ignore patterns for common development scenarios.

  </details>
- [`da438bd`](https://github.com/gamerlogue/web/commit/da438bd27956c9ade33be8384cd67d2c48c86bfa) **ide:** Added IDE files
- [`6e08e53`](https://github.com/gamerlogue/web/commit/6e08e535877bad1762dd179e0e76f004acce809b) **editorconfig:** Update line length and file patterns
- [`d11bb41`](https://github.com/gamerlogue/web/commit/d11bb41b78aca8e9d5bf7e90fe10cf1058ae448a) Update project configuration files and exclude additional vendor directories
- [`d42aad2`](https://github.com/gamerlogue/web/commit/d42aad25e318533ff6ed19509442712c9adb8faa) **composer:** Update dependencies and PHP version requirements
- [`31d899a`](https://github.com/gamerlogue/web/commit/31d899abfc396061a2e35e5e840158bb7981d901) Add Docker and Supervisor configuration for development environment
- [`19514ec`](https://github.com/gamerlogue/web/commit/19514ec2c174cb3679637b3422719e6626a72ee7) 🔧 Removed sitekit old config file
- [`c16bfba`](https://github.com/gamerlogue/web/commit/c16bfbadd9192da49984a9b236d2cd2a62c873d0) Update TypeScript configuration and add Vite configuration file
- [`cc320bf`](https://github.com/gamerlogue/web/commit/cc320bfac5ee88a03ed1dc30f613392fc209cf4b) Add Pint configuration for Laravel with custom rules
- [`96efd49`](https://github.com/gamerlogue/web/commit/96efd49b4b47f649d6e2ea57f11e22a26003ff94) Update ESLint configuration and dependencies in package.json
- [`adb7caa`](https://github.com/gamerlogue/web/commit/adb7caa638218aafdf561b7ea09c69ec318b091e) Update database configuration and aliases from mariadb to mysql
- [`007b6d0`](https://github.com/gamerlogue/web/commit/007b6d07ebc3b8044d58fa9635fb96a09bc0a138) Add configuration files for code style, CIAid settings, JavaScript library mappings, and pnpm workspace
- [`eace7b8`](https://github.com/gamerlogue/web/commit/eace7b8e07be02f948641ae44d062addd3710864) Add SVG icon file
- [`3245e89`](https://github.com/gamerlogue/web/commit/3245e89364ca002e199ec926dc3fbaf0778fd8d5) **commit-check:** 📝 Update regex for commit message validation and add imperative mood check
- [`3bae13f`](https://github.com/gamerlogue/web/commit/3bae13f70aa6bd5f8d501fd34befc953ffa0be30) 🔧 🔥 Removed old sitekit config file
- [`e09cbda`](https://github.com/gamerlogue/web/commit/e09cbda22e3d7f22f302ce9cb7c448232be4a08b) ✨ Add GitLab CI configuration for Docker image build and deployment
- [`6f08637`](https://github.com/gamerlogue/web/commit/6f0863749e26af264d86cfcb64f6c31b0fae5614) ✨ Update .env.example to include APP_SERVICE for Laravel Sail
- [`0e5592e`](https://github.com/gamerlogue/web/commit/0e5592e97b28479cb22e6831ba7be437f67f6f73) 🔥 Removed old AddViteToSailSupervisor command
- [`794c854`](https://github.com/gamerlogue/web/commit/794c854cbafa2d06f0d239a1b138a0bc3ed6d9ac) ✨ Enhance activation scripts for Laravel Sail environment
- [`b58b1ac`](https://github.com/gamerlogue/web/commit/b58b1ac5e2012a7b491eaf56b10d52cabc8ed0a4) ✨ Update supercronic command to include --quiet option in supervisord configuration
- [`122ebc4`](https://github.com/gamerlogue/web/commit/122ebc4325c954592f8766094fb0799d7dc66a20) ✨ Update supervisord configurations to use environment variables for autostart settings
- [`4ba145b`](https://github.com/gamerlogue/web/commit/4ba145bdba57942379abd4306f8968adc9270b6b) ✨ Disable Horizon in Dockerfile environment variables
- [`1b7b828`](https://github.com/gamerlogue/web/commit/1b7b828cd2356dada73743a677178efef34d39da) **deps:** ⬆️ Update dependencies in composer.lock to latest versions
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b22f0a222e246f299b0c35f7e490b48d668bee27"><code>b22f0a2</code></a> <b>config:</b> 🔧 Update php.ini values</summary>

  > Update php.ini to adjust resource limits and opcache settings.
  >
  > - Increase memory limits (post_max_size, upload_max_filesize, realpath_cache_size)
  > - Configure opcache settings, including JIT options.
  > - Improve performance and stability.

  </details>
- [`6f41e11`](https://github.com/gamerlogue/web/commit/6f41e1171f963d5bdb518958a5bb1cb236c2a8af) **ide:** 🔧 Update settings to reflect compose.yaml rename
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cd25482430e5faea2d7cecd49f40d1ccabc5f26b"><code>cd25482</code></a> ⬆️ update dependencies in composer.lock and IDE config</summary>

  > Updates a batch of dependencies including:
  > - `laravel/framework` (v12.26.3 -> v12.34.0)
  > - `laravel/octane` (v2.12.1 -> v2.13.0)
  > - `laminas/laminas-diactoros` (v3.6.0 -> v3.8.0)
  > - `brick/math` (v0.13.1 -> v0.14.0)
  > - Various Symfony and development dependencies.
  >
  > Also includes an update to `.idea/php.xml` to reflect dependency changes.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cdf95c11aa27189f45ac813fda4cc3e8b2e474bf"><code>cdf95c1</code></a> <b>ide:</b> 🔧 Enable validation for production compose file</summary>

  > This change configures the IDE to validate the `compose.prod.yaml` file.
  > Enabling this feature provides real-time syntax checking and autocompletion, helping to catch configuration errors early in the development process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b164e428732a1c155eabfdc8665b09c6b2088b3a"><code>b164e42</code></a> <b>docker:</b> 🩺 Increase healthcheck interval and timeout</summary>

  > The previous healthcheck values were too aggressive, potentially causing containers to be marked as unhealthy and restart unnecessarily during periods of high load or slow startup.
  >
  > These new, more lenient values provide a larger window for the application to respond, enhancing the overall stability of the containerized environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c598f12b3238aa67282667667325c221bf27f136"><code>c598f12</code></a> <b>deps:</b> ⬆️ update dependencies</summary>

  > This commit updates both frontend and backend dependencies to their latest versions.
  >
  > Keeping dependencies current is crucial for project health. It incorporates the latest security patches, bug fixes, and performance improvements from the upstream packages, ensuring the application remains stable, secure, and maintainable.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/592cf07e857d5afc55450b9e343d73993c0eebfe"><code>592cf07</code></a> <b>deps:</b> Replace laravel-debugbar with clockwork</summary>

  > Clockwork provides a more modern and less intrusive debugging experience compared to Laravel Debugbar. Its browser extension and dedicated app allow for inspecting application requests, including API calls, without injecting a visible bar into the application's UI.
  >
  > This switch improves the development workflow, especially for SPAs or API-heavy applications, by offering a cleaner and more powerful interface for debugging and profiling.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/4e1b1f738414931a66a4e1842f1f137fdceaaac4"><code>4e1b1f7</code></a> Merge remote-tracking branch &#x27;origin&#x2F;main&#x27;</summary>

  > # Conflicts:
  > #	.gitlab-ci.yml

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2a47fb7617221747f561864cff86c2e4e6ad83cf"><code>2a47fb7</code></a> 🔧 update pre-commit configuration and rename commit-check file</summary>

  > - Upgraded commit-check hook version to v2.6.0 for improved functionality.
  > - Renamed configuration file from `.commit-check.yml` to `commit-check.toml` for consistency with naming conventions.
  > - Adjusted hook stages to ensure proper execution during commit message checks.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/749c9931149deb371cc62face367622561e40cce"><code>749c993</code></a> <b>env:</b> 🔧 update environment configuration for caching and mail services</summary>

  > - Changed CACHE_STORE from database to redis for improved performance
  > - Updated MEMCACHED_HOST to use the new service name
  > - Adjusted REDIS_HOST to point to the redis service
  > - Modified MAIL_HOST and MAIL_PORT for compatibility with mailpit

  </details>
- [`446e40b`](https://github.com/gamerlogue/web/commit/446e40b9fb73ebd71e1fce4c2e8db4edb8121f4a) **deps:** ⬆️ update dependencies
- [`c851c12`](https://github.com/gamerlogue/web/commit/c851c123eecd59dc0e0a6c878b054ba7a5d10037) 🔧 add .idea/claudeCodeEditorTabs.xml to .gitignore
- [`59b6f32`](https://github.com/gamerlogue/web/commit/59b6f32d2c5314e29d04711209d1bc4cb809d1f8) **mcp:** 🔥 remove deprecated MCP server configuration file
- [`ae3926b`](https://github.com/gamerlogue/web/commit/ae3926b75c8bb33fe5a6595ee8eac35ddf49dd43) **lang:** 🔧 add .gitkeep file to preserve lang directory in version control
- <details><summary><a href="https://github.com/gamerlogue/web/commit/bc8dd32a447203658e9170e1f5c9a3886728a09b"><code>bc8dd32</code></a> <b>start-container:</b> 🔧 add vendor and node modules installation checks</summary>

  > - Ensure the vendor directory is created by running composer install if it doesn't exist.
  > - Ensure the node_modules directory is created by running pnpm install if it doesn't exist.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3b0f6cbeb101cef8587c99e7bd706b172cf93ca6"><code>3b0f6cb</code></a> <b>docker:</b> 🔧 update project to use Bun as package manager</summary>

  > - Added bunfig.toml for Bun configuration.
  > - Updated package.json scripts to use Bun commands.
  > - Modified Dockerfile to install Bun and adjust build process.
  > - Changed cache paths in compose.yaml and .dockerignore to reflect Bun usage.
  > - Updated activation scripts to replace pnpm with Bun commands.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7d62f500a789416738a7181d5217d33ca096db04"><code>7d62f50</code></a> Update typehint to be nullable (#5296)</summary>

  > By default, this property is null. Therefore, it should be marked as nullable

  </details>
- [`a8b5e07`](https://github.com/gamerlogue/web/commit/a8b5e075228a28344876ccedd09bc0ba850b621c) Update changelog CI permission
- [`6f1ebe2`](https://github.com/gamerlogue/web/commit/6f1ebe26a49dc76cd922f7dde481acc56ab5e6f8) Update `update-changelog.yml`
- [`51cd697`](https://github.com/gamerlogue/web/commit/51cd69753265aee56bf69fd30ddec1191db06aed) Update outdated GitHub Actions version (#6743)
- [`72ee3ca`](https://github.com/gamerlogue/web/commit/72ee3ca3b9926b24b8b947556997c057d53877c1) Add missing comma in axios
- [`6cae3cd`](https://github.com/gamerlogue/web/commit/6cae3cd668008f23c9641367b995537c12a98934) **php:** 🔧 update PHP language level to 8.5
- [`a7d2ba6`](https://github.com/gamerlogue/web/commit/a7d2ba672f9f7fa34014009a9e49e45d27e2544f) **gitattributes:** 🔧 remove CHANGELOG.md from export-ignore list
- [`f1d46d8`](https://github.com/gamerlogue/web/commit/f1d46d890ef4c3bedc64626f0323acb92c9111a9) **vite:** 🔧 remove Vite configuration file (JS)
- [`a00ac86`](https://github.com/gamerlogue/web/commit/a00ac86061fe999a2a9cf44db22d6cd8fa8459e6) Removed execution permission
- [`44117a6`](https://github.com/gamerlogue/web/commit/44117a63319bffc64ec8a4bcb1b9a8806faee39e) 🔧 add public/fonts-manifest.dev.json to .gitignore
- <details><summary><a href="https://github.com/gamerlogue/web/commit/19c1bfdd2bc12246813f0581dfc39f9102bfb6d6"><code>19c1bfd</code></a> 🔧 update development dependencies in package.json</summary>

  > - Upgraded ESLint, TypeScript, Vite, and stylelint packages to their latest versions for improved performance and compatibility.
  > - Replaced `sass` with `sass-embedded` to align with current best practices.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/41dab33be4cd5c4777709ad085d0d6dcfeb9860b"><code>41dab33</code></a> 🔧 add fontaine package to dependencies</summary>

  > - Added `fontaine` version `0.8.0` to `package.json` and `bun.lock` for enhanced font management capabilities.

  </details>
- [`a492673`](https://github.com/gamerlogue/web/commit/a492673072066addbc42d43f0698a6ee5da8ac72) 🔧 update base image in Dockerfile to use ghcr.io/maicol07/docker-php-dev
- [`d20d830`](https://github.com/gamerlogue/web/commit/d20d8301e2f95a799777fbd0212279481c32fa14) 🔧 update base image comment in Dockerfile
- <details><summary><a href="https://github.com/gamerlogue/web/commit/897c966321a5a74f2b21841de05dd3fddbbc3ddf"><code>897c966</code></a> 🔧 remove redis extension from Dockerfile</summary>

  > Redis extension is already included in the base docker-php image
  >
  > - Simplified the PHP installation by removing the redis extension.
  > - This change helps streamline the Docker image and reduce potential overhead.

  </details>
- [`a4299f8`](https://github.com/gamerlogue/web/commit/a4299f84fee78659a717c5b950d8c685d8cb2962) 🔧 consolidate EXPOSE directives in Dockerfile
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ca9288ce6b36dc769ba2e0af8413ed71914d307f"><code>ca9288c</code></a> 🔧 update Docker Compose files to manage Caddy volumes</summary>

  > - Added volume definitions for Caddy configuration and data in `compose.common.yaml`
  > - Removed redundant volume definitions from `compose.prod.yaml` and `compose.yaml`
  > - Ensures consistent volume management across different environments

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/236e7c83eebdc2037b73ae664f83909be73fc379"><code>236e7c8</code></a> 🔧 remove port mapping for HTTP in Docker Compose</summary>

  > - Eliminated the hardcoded port mapping for HTTP to allow flexibility in configuration.
  > - This change enables the use of environment variables for port management.

  </details>
- [`c709e6e`](https://github.com/gamerlogue/web/commit/c709e6e1ff2e1f5071e263c4238d9b89946eb6f5) 🔧 update hostname in Docker Compose configuration
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6fcc4c301060db0a358846f825905a12a628cab6"><code>6fcc4c3</code></a> 🔧 remove unused environment variables from Docker Compose</summary>

  > - Eliminated IGNITION_EDITOR and IGNITION_REMOTE_SITES_PATH as they are no longer needed.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e509f218148e899d5fc612b8a88dcf47bd899390"><code>e509f21</code></a> 🔧 remove tail command from start-container-dev.sh</summary>

  > - Eliminated the tail command for xdebug.log to streamline the script execution.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3d7f3feb44bbc7a48d927b724234c2f0bd2a0ccc"><code>3d7f3fe</code></a> <b>serena:</b> 🔧 add .gitignore and project.yml for configuration management</summary>

  > - Introduced a .gitignore file to exclude cache and local configuration files.
  > - Added project.yml to define project settings and language server configurations.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c6147ea4623ee9b9c6a95c2eeb66088749035b4b"><code>c6147ea</code></a> 🔧 update Docker Compose files for improved port and host configuration</summary>

  > - Added ports for HTTPS and optional database/Redis forwarding in `compose.yaml`.
  > - Removed redundant port mappings and environment variables from `compose.common.yaml`.
  > - Adjusted `extra_hosts` for better host resolution.

  </details>
- [`d64d709`](https://github.com/gamerlogue/web/commit/d64d70905a8f3afdb6b3fbca5dc0f66580b4f24d) 🔧 update extra_hosts configuration in compose.common.yaml for default server name
- [`14a77b4`](https://github.com/gamerlogue/web/commit/14a77b42d94f5ca81baeb631e71d5b3883140911) 🔧 remove USER argument from laravel service build configuration
- <details><summary><a href="https://github.com/gamerlogue/web/commit/caebe322da932bacede7aa894b7fc6a89cdf2e14"><code>caebe32</code></a> 🔧 update PHP_OPCACHE_JIT settings in Dockerfile</summary>

  > - Changed PHP_OPCACHE_JIT from '1' to 'tracing' for improved performance.
  > - Added PHP_OPCACHE_JIT_BUFFER_SIZE to optimize JIT compilation.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/ce632eefaffac1b372f02f4eeecfd438b9b03261"><code>ce632ee</code></a> 🔧 update logging directory permissions in Dockerfile</summary>

  > - Created a new logging directory for FrankenPHP.
  > - Set appropriate ownership for the logging directory to ensure proper access.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/addcf8a3e41dd9b576021cefdcf3ca86a265401d"><code>addcf8a</code></a> 🔧 update Bun cache directory in Dockerfile</summary>

  > - Changed Bun cache directory from /home/${USER}/.bun/install/cache to /root/.bun/install/cache for improved compatibility.
  > - Removed unnecessary script copying and execution steps to streamline the Docker build process.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/0d429277c46e93763469ca8d4391500a38c1bff1"><code>0d42927</code></a> 🔧 remove script copying and execution from Dockerfile</summary>

  > - Eliminated the copying and execution of deployment scripts to streamline the Docker build process.
  > - This change reduces unnecessary steps and potential errors during image creation.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c7b03b197629137f543519976b37d2829c065977"><code>c7b03b1</code></a> 🔧 update service dependencies to use health checks</summary>

  > - Added health check conditions for MySQL and Redis services in Docker Compose files.
  > - Ensures that dependent services only start when MySQL and Redis are healthy, improving reliability.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/66b69091669cbefbca1a1411a9f459f6dea21b04"><code>66b6909</code></a> 🔧 add restart policy to services in Docker Compose</summary>

  > - Ensures services automatically restart unless stopped
  > - Improves reliability and uptime of the application

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2450aca3c331635aeffd6521b3a1b4d36447e018"><code>2450aca</code></a> 🔧 add logging configuration to services in Docker Compose</summary>

  > - Set logging driver to json-file with max size and file limits for better log management.

  </details>
- [`0cfbd4a`](https://github.com/gamerlogue/web/commit/0cfbd4a22dbbb0a20dfab86d8737efb41bccd4c2) Removed unused files
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f1f3f7262ea47bf4750bc54ac908a0006206c09b"><code>f1f3f72</code></a> ⚡ simplify Vite imports in welcome view</summary>

  > - Replaced conditional logic with a single `@vite` import for `app.ts`.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2c201ba45799afcd486ab6ce99550fbf3abe847c"><code>2c201ba</code></a> 🔧 configure Vite dev server with Caddy proxy for HMR fix</summary>

  > - Added `vite.caddyfile` for terminating TLS and reverse proxying Vite in development.
  > - Updated `vite.config.ts` to remove `server.https` for compatibility with Caddy's WebSocket handling.
  > - Removed `vite-plugin-restart` and related SSL configuration.
  > - Updated `compose.yaml` to mount the new Caddyfile.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5296d2b7e9fe2b4116c6043335edaeb60b35c024"><code>5296d2b</code></a> ♻️ reorder and clean up ENV variables in Dockerfile</summary>

  > - Moved ENV variable block to streamline configuration.
  > - Ensured ENV variables are defined before changing file permissions.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/c7d6e84898657b0fe8d54fe5a52db8d052b41b09"><code>c7d6e84</code></a> 🔧 update PHP INI scan dir and set logging directory ownership</summary>

  > - Fixed `PHP_INI_SCAN_DIR` to remove redundant separator.
  > - Added ownership adjustment for FrankenPHP log directory.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/208ae9bb09835ffa1732c641ea7246679637a941"><code>208ae9b</code></a> 🔧 update Dockerfile to adjust Caddy admin address and exposed ports</summary>

  > - Changed Caddy admin address from `:2019` to `localhost:2019`.
  > - Removed exposure of Caddy's admin port (`2019`), keeping only essential ports.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/757879a2517a588e7d98437fb3a4231b5eb91574"><code>757879a</code></a> 🔧 clean up Dockerfile and optimize build steps</summary>

  > - Removed unnecessary commands and improved build efficiency
  > - Adjusted permissions and ownership for better security

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/a27d1a3f0984a55838210e3e5882b40a2c32cec5"><code>a27d1a3</code></a> <b>compose:</b> 🔧 update command to include Caddyfile path</summary>

  > - Added `--caddyfile=/etc/frankenphp/Caddyfile` to the Octane start command for better configuration management.

  </details>
- [`8551b30`](https://github.com/gamerlogue/web/commit/8551b30124ebc502c302bd67fc1f9cee94ba60d6) **compose:** 🔧 update extra_hosts to use localhost IP address
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6854b9771b94d13c632488eec915bb797f63d7b2"><code>6854b97</code></a> <b>compose:</b> 🔧 add security options to services</summary>

  > - Introduced `security_opt` to prevent new privileges for containers
  > - Added `cap_drop` and `cap_add` to enhance security by limiting capabilities

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/cb0496013b1df5c7ad6dea9be4e440e64ae9433b"><code>cb04960</code></a> <b>compose:</b> 🔧 update log file configuration for rolling logs</summary>

  > - Added rolling log options for frankenphp and access logs
  > - Improved log management by limiting size and retention

  </details>
- [`eac0844`](https://github.com/gamerlogue/web/commit/eac084486354f9e854c0bed52ed5ea877714bdfc) **compose:** 🔧 update FRANKENPHP_CONFIG file path to use APP_PUBLIC_PATH
- [`c82a944`](https://github.com/gamerlogue/web/commit/c82a9444b6837fd395085042ccf4926f307ee1a4) **compose:** 🔧 update log directive to use `access` instead of `file`
- <details><summary><a href="https://github.com/gamerlogue/web/commit/99489c39ed87ef87887760c2e4bf8bde27c720e4"><code>99489c3</code></a> <b>compose:</b> 🔧 update MYSQL_ROOT_PASSWORD environment variable to support default value</summary>

  > - Allow MYSQL_ROOT_PASSWORD to default to DB_PASSWORD if not explicitly set
  > - Enhances flexibility in configuration

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/495d2fbc7cab08e0e15279d784120807e37bd663"><code>495d2fb</code></a> <b>compose:</b> 🔧 update MYSQL_PASSWORD and healthcheck to require DB_PASSWORD</summary>

  > - Ensure MYSQL_PASSWORD and healthcheck command require DB_PASSWORD to prevent misconfiguration.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/59c35f98f1ea342b479536195a612f8f427cea5a"><code>59c35f9</code></a> <b>compose:</b> 🔧 update Redis configuration to set max memory limit</summary>

  > - Added command to Redis service to configure max memory and eviction policy.
  > - This change helps manage memory usage effectively and prevents potential out-of-memory errors.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/bd1084848a2d42ad34be14bdd89e3948be196191"><code>bd10848</code></a> <b>compose:</b> 🔧 add language files to the octane configuration</summary>

  > - Included 'lang/**/*.php' to ensure language files are processed correctly.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/905be5e75e6a8a240339f08ccafd9c85b9aa9374"><code>905be5e</code></a> <b>octane:</b> 🔧 add configuration for Octane server state file</summary>

  > - Introduced a new configuration option for the Octane server to specify the state file location.
  > - This allows for better management of the server's master process ID and admin endpoint tracking.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/963a8d25007439ac57f5ea856a265abb9a885dbc"><code>963a8d2</code></a> <b>log-viewer:</b> 🔧 add authentication for LogViewer access</summary>

  > - Implemented authentication logic to restrict access to LogViewer based on user email.
  > - This change enhances security by ensuring only authorized users can view logs.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f6ddf14803da6f2a56a6735608985d35596598d7"><code>f6ddf14</code></a> <b>octane:</b> 🔧 update Octane configuration for Caddy integration</summary>

  > - Added Caddy environment variables to the Octane configuration.
  > - Enhanced the start-container-dev.sh script to handle watch directives for FrankenPHP.
  > - Improved handling of file paths to prevent crashes during watch mode.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/6a644a823524023b3ee2466189f007fc759ce4a7"><code>6a644a8</code></a> <b>dockerignore:</b> 🔧 update .dockerignore to exclude additional files</summary>

  > - Added exclusions for IDE configuration files and local project settings
  > - Improved clarity by organizing ignored files related to storage and cache

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/b852b85b5edc858883a06091acae830ca7f1e9b5"><code>b852b85</code></a> <b>composer:</b> 🔧 update dependencies in composer.json</summary>

  > - Removed outdated packages and updated to newer versions
  > - Ensures compatibility with the latest Laravel and PHPUnit releases

  </details>
- [`ab6810a`](https://github.com/gamerlogue/web/commit/ab6810a4005936ecd40d3c53cfa1569c9147c1cd) 🗑️ add .gitignore file to exclude all files except itself
- <details><summary><a href="https://github.com/gamerlogue/web/commit/821399829a07818d5ce7356409631c0a7dd2a155"><code>8213998</code></a> <b>tests:</b> 🔧 migrate to Pest framework</summary>

  > - Replaced PHPUnit with Pest for testing, including configuration updates (`php-test-framework.xml`, `composer.json`, `tests`).
  > - Added Pest plugins for improved functionality and parallel testing.
  > - Simplified `ExampleTest` to use Pest's syntax for clarity.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fb7978e317f54be9bfa15f051bbd5877bc22e9b2"><code>fb7978e</code></a> <b>compose:</b> 🔧 update OCTANE_PORT in production configuration</summary>

  > - Changed the port variable from PORT to OCTANE_PORT to avoid conflicts with PaaS platforms and interactive shells.
  > - Ensured consistency with the container side of `ports` in compose.common.yaml and the base image's HEALTHCHECK.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/2fe5a05d12dde58cea99bd9ac6f6cab0f2d0c31a"><code>2fe5a05</code></a> <b>docker:</b> 🔧 update permissions for Xdebug log file</summary>

  > - Changed permissions for the /tmp directory to 1777 to allow Xdebug to create its own log file at runtime.

  </details>
- [`c2328ca`](https://github.com/gamerlogue/web/commit/c2328cad341c7f057400b1a7f5ae162f31b8fb3b) 🗑️ exclude storage/pail directory from project
- <details><summary><a href="https://github.com/gamerlogue/web/commit/dd02125baccdc17d6ccf496421d109f64cbc9d0c"><code>dd02125</code></a> <b>script:</b> 🔧 enhance log output and add pail process</summary>

  > - Updated log colors to include magenta for improved visibility.
  > - Added `php artisan pail` command for streamlined local development.
  > - Adjusted process names to improve clarity in concurrent tasks.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7f7ab558fddca3a38f7226f3dafcbe74d6447b18"><code>7f7ab55</code></a> <b>script:</b> 🔧 simplify command execution in development script</summary>

  > - Removed unnecessary `unbuffer` calls for improved readability and performance.
  > - Streamlined the command execution for starting the Octane server and development environment.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/15ce9c8c27178e5d23a918a12e4be3f1639c4d0b"><code>15ce9c8</code></a> <b>script:</b> 🔧 replace unbuffer with FORCE_COLOR for improved signal handling</summary>

  > - Removed `unbuffer` from command execution to ensure graceful shutdown on `docker stop`.
  > - Set `FORCE_COLOR=1` in Dockerfile to enable colored output without the need for `unbuffer`.
  > - Updated related commands in `compose` files to directly use `php` as PID 1 for better signal management.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/f12e78e9ffcf9249325cba8b539e30ad7695e969"><code>f12e78e</code></a> 🔥 remove the GitHub workflows and dependabot config</summary>

  > Leftovers of the laravel/laravel skeleton: this project runs on GitLab CI and Renovate.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3306e083418cb7596f28219a928a7e239153a3b6"><code>3306e08</code></a> 🔇 mark the sample credentials as betterleaks false positives</summary>

  > The example DB password and the docs that quote it.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/5942314e8d246968adb8e1c71e5f5f7d27d465f9"><code>5942314</code></a> <b>deps:</b> Update laravel-debugbar to version 4.0 and adjust include paths</summary>

  > - Upgraded the laravel-debugbar dependency to ensure compatibility with the latest features and improvements.
  > - Removed obsolete paths and added necessary paths for the updated debugbar and related components.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/93a5102ff6858c349fad64106709a9a1c7653f0f"><code>93a5102</code></a> <b>deps:</b> Update devDependencies and dependencies in package.json</summary>

  > - Bump versions for various packages to ensure compatibility and access to new features.
  > - Adjustments made to eslint, vite, and stylelint packages for improved development experience.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/58d69ff023da9b985d7fb3cb98121754afa9ab1a"><code>58d69ff</code></a> <b>deps:</b> 🔄 update dependencies in bun.lock</summary>

  > - Updated versions of several packages to ensure compatibility and security.
  > - Notable updates include `brace-expansion`, `fast-uri`, `js-yaml`, and `postcss`.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/45067891c62cfe42f81b7e933be9dfaee4d935aa"><code>4506789</code></a> <b>deps:</b> 🔄 update @maicol07&#x2F;eslint-config to version 3.1.3 and update globals to version 17.13.0</summary>

  > - Updated the ESLint configuration package to the latest version for improved linting rules.
  > - Updated the globals package to ensure compatibility with the latest ESLint plugins.
  > - Added new dependencies for better accessibility support in the project.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/3872578e041d96329811dbcd071dbc4b4378578f"><code>3872578</code></a> <b>deps:</b> 🔄 update typescript to version 6.0.3 and adjust version constraints</summary>

  > - Updated typescript dependency from ^7.0.2 to ~6.0.3 in bun.lock and package.json
  > - This change ensures compatibility with other dependencies and resolves potential issues with version mismatches.

  </details>
- [`cbdcdb3`](https://github.com/gamerlogue/web/commit/cbdcdb38bf856c4d8646c9e3805fa04bb44e065d) **ide:** 🔧 update IDE configuration to include GitLab repo state and enable commit message spell checking
- [`a49de1e`](https://github.com/gamerlogue/web/commit/a49de1e1ed5b0e324e480b0dd7cd3c8f3c3ec351) **deps:** Upgrade dependencies
- [`24364e3`](https://github.com/gamerlogue/web/commit/24364e3d793e1132d513cd5ad8f80b5d6e3ac862) **deps:** Update dependency websites/utils/ci-templates to v2.8.1
- [`6b10f60`](https://github.com/gamerlogue/web/commit/6b10f600f574bf9be902f43b55ec0bd7e7a222c0) **deps:** Update dependency websites/utils/ci-templates to v2.9.0
- [`8ec45e9`](https://github.com/gamerlogue/web/commit/8ec45e9db1669631df6fcc3ee73ac2ede3efc65e) **deps:** Update dependency websites/utils/ci-templates to v2.10.1
- [`375ff30`](https://github.com/gamerlogue/web/commit/375ff303e4b27fbdc8d0a9aa9340d07080695341) **deps:** Update dependency websites/utils/ci-templates to v2.10.2
- [`f0ce626`](https://github.com/gamerlogue/web/commit/f0ce626086131ebe95b4a39e1aa178c1090701bf) **deps:** Update dependency websites/utils/ci-templates to v3
- [`296113a`](https://github.com/gamerlogue/web/commit/296113ad540e560727be81a550e711b8258bca2e) **deps:** Update dependency websites/utils/ci-templates to v3.1.0
- [`9a3298c`](https://github.com/gamerlogue/web/commit/9a3298c397953ff2b283c3b0e50c0e3d239aa1f6) **deps:** Update dependency websites/utils/ci-templates to v3.2.0
- <details><summary><a href="https://github.com/gamerlogue/web/commit/d865173e52357979acd7d78094b4877adfea5966"><code>d865173</code></a> <b>deps:</b> Update dependencies in bun.lock</summary>

  > - Added optional dependencies for @laravel/multiplex
  > - Updated versions for several packages including commander and react
  > - Ensured compatibility with latest features and fixes

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/fde3032c1875031e750aee0951f0824f8b167933"><code>fde3032</code></a> <b>deps:</b> Update development dependencies</summary>

  > - Bump versions for several packages to ensure compatibility and access to the latest features and fixes.
  > - Updated `@types/node`, `eslint`, `fontaine`, `laravel-vite-plugin`, `postcss-html`, `sass-embedded`, `stylelint`, and various stylelint configurations.
  > - Adjusted `typescript` to use the latest version from the `@typescript` namespace.

  </details>
- <details><summary><a href="https://github.com/gamerlogue/web/commit/9eb2bf20d04af3816282a8f083372e7147a0bd8b"><code>9eb2bf2</code></a> <b>config:</b> 🔧 add ESLint configuration and update project settings</summary>

  > - Introduced a new ESLint configuration file for improved code quality.
  > - Updated MCP server settings, including port change and disabled tool IDs.
  > - Added commit-check schema information to jsonSchemas.xml for better validation.
  > - Included new path for Symfony polyfill-time in php.xml.

  </details>
- [`d617208`](https://github.com/gamerlogue/web/commit/d617208b3f919c8b4abea8d348622327c85ca8eb) **deps:** 🔧 reorder optional dependencies in package.json
- [`394a04f`](https://github.com/gamerlogue/web/commit/394a04ff4574736635fd08eb8ed9370c0d395571) **deps:** Update dependency websites/utils/ci-templates to v3.2.1
- <details><summary><a href="https://github.com/gamerlogue/web/commit/e4211f1e69b5a2c6523be76e2fd630aa1e43bb6a"><code>e4211f1</code></a> <b>deps:</b> Bump taiki-e&#x2F;install-action (#48)</summary>

  > Bumps the github-actions group with 1 update: [taiki-e/install-action](https://github.com/taiki-e/install-action).
  >
  >
  > Updates `taiki-e/install-action` from 2.90.0 to 2.90.3
  > - [Release notes](https://github.com/taiki-e/install-action/releases)
  > - [Changelog](https://github.com/taiki-e/install-action/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/taiki-e/install-action/compare/b80e2bb2635f28eb98b9fce1e2f0887e1535c6b2...cfdb7ed4ccc7c7dce37759eae89dc5674b469b39)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: taiki-e/install-action
  >   dependency-version: 2.90.3
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: github-actions
  > ...

  </details>
- [`9825430`](https://github.com/gamerlogue/web/commit/98254303735e27123547d1c2c699fe2c1466c7fd) **deps:** Update dependencies
- [`de7799e`](https://github.com/gamerlogue/web/commit/de7799e69f694112b4e1db80159c4e3af0c661c9) **deps:** ➕ add laravel-notification-channels/fcm
- [`22af674`](https://github.com/gamerlogue/web/commit/22af674b309fec7decc70ef00a905957708c6953) **ide:** 🔧 update PhpStorm vendor paths
- <details><summary><a href="https://github.com/gamerlogue/web/commit/7aa3d8d49369fd67aa0d034cc769864b94704962"><code>7aa3d8d</code></a> <b>deps:</b> Bump taiki-e&#x2F;install-action (#53)</summary>

  > Bumps the github-actions group with 1 update: [taiki-e/install-action](https://github.com/taiki-e/install-action).
  >
  >
  > Updates `taiki-e/install-action` from 2.90.3 to 2.90.5
  > - [Release notes](https://github.com/taiki-e/install-action/releases)
  > - [Changelog](https://github.com/taiki-e/install-action/blob/main/CHANGELOG.md)
  > - [Commits](https://github.com/taiki-e/install-action/compare/cfdb7ed4ccc7c7dce37759eae89dc5674b469b39...ab49d3c64680143e184118bed66a46419fc15519)
  >
  > ---
  > updated-dependencies:
  > - dependency-name: taiki-e/install-action
  >   dependency-version: 2.90.5
  >   dependency-type: direct:production
  >   update-type: version-update:semver-patch
  >   dependency-group: github-actions
  > ...

  </details>

### ⏪ Reverts

- [`00b064c`](https://github.com/gamerlogue/web/commit/00b064c7d52d8f43af819a5d62b1c35f01856748) Revert previous changes to Eloquent.
- [`8457238`](https://github.com/gamerlogue/web/commit/8457238ab18c04d29748bbabc188d08228cd582e) Revert back APC and Memcached drivers.
- [`23a25b9`](https://github.com/gamerlogue/web/commit/23a25b9abb3442938595d1d3b249d73d039bf5bd) Revert "Added a function for handling HTML special characters"
- [`0f3e8eb`](https://github.com/gamerlogue/web/commit/0f3e8eb62ba3f9e849e2ff7b777dd4b3af92a9c1) Reverting Symfony's Response class to previous version
- [`546c962`](https://github.com/gamerlogue/web/commit/546c96261254373b7b366ce294aeba56636611c6) Revert "Docu on how to ensure foreign() works"
- [`9484db1`](https://github.com/gamerlogue/web/commit/9484db18ced4f11034e4ca3828e0b047ee177520) Revert Blade back to 3.2.3 due to regression with layouts.
- [`70f2836`](https://github.com/gamerlogue/web/commit/70f283606068845710f62b24dee944ee82bdbf47) Revert "Make view with response status and headers"
- [`161ebda`](https://github.com/gamerlogue/web/commit/161ebdab36b267f281cbc7586898a33e81936d60) Revert "[5.1] Add new middleware"
- [`13b7991`](https://github.com/gamerlogue/web/commit/13b799196bc6957dd57b6b6d07ace32299a9f336) Revert bad changes to the exception handler
- [`b847ee7`](https://github.com/gamerlogue/web/commit/b847ee7486bfebcad33ae1181aa6788831e55670) Revert "added queue prefix to match the framework"
- [`88e55f4`](https://github.com/gamerlogue/web/commit/88e55f41d2dab4c7b1c6ad8f3ba54dc70b9fafb1) Revert "Removes padding on html/body to kill the scrollbar"
- [`ffd7ad9`](https://github.com/gamerlogue/web/commit/ffd7ad912e53bc42ec41cfb2710200c7ead2b9a8) Revert recent changes to env file.
- [`7b3e884`](https://github.com/gamerlogue/web/commit/7b3e884757580873825498cc987e70727a91b88f) Revert "[5.4] Change PUSHER enviroment variable names"
- [`095fa50`](https://github.com/gamerlogue/web/commit/095fa50f7bd54cd256a2aa58618d683ff5b377a1) Revert "Append '@' to let composer resolve PHP executable"
- [`c76716f`](https://github.com/gamerlogue/web/commit/c76716f228d809d24d1886c3e279d08fb8377ebc) Revert npm script refactor
- [`45917c7`](https://github.com/gamerlogue/web/commit/45917c747231b85a67b846125f26a6dc1e57b64b) Revert "don't need it"
- [`2b38ea1`](https://github.com/gamerlogue/web/commit/2b38ea1996f9ed396cde3004a1902a3710084bfe) Revert "Use database_path helper for sqlite database filename specified in .env"
- [`ed28d39`](https://github.com/gamerlogue/web/commit/ed28d3990efba41e1152ef9812de2027f68d806a) Revert "[5.6] Use composer platform config"
- [`603ed13`](https://github.com/gamerlogue/web/commit/603ed13aec934c8132f5270d1a445c1171ec84c9) Revert "[5.5] Use composer platform config"
- [`24e6ff9`](https://github.com/gamerlogue/web/commit/24e6ff9593054e0a061c2d1ac44936c167efc830) Revert #4744
- [`de09cbf`](https://github.com/gamerlogue/web/commit/de09cbf4a5e7561d3cd7b3cccc7889694cd79a3d) Revert "[5.7] Ignore testing folder on storage/framework"
- [`a787453`](https://github.com/gamerlogue/web/commit/a787453caaa5b706c5fd9ee80e97d1311906090a) Revert "[5.8] Modify RedirectIfAuthenticated middleware to accept multiple guards"
- [`310afdf`](https://github.com/gamerlogue/web/commit/310afdfc53cb2b4b598df26daa3484118fb623f6) Revert "Exclude StyleCI config from exported files (#5012)"
- [`8c9481a`](https://github.com/gamerlogue/web/commit/8c9481a13f9aed810c95f8697e25de1ade43521a) Revert "Bump PHPUnit"
- [`5866cb5`](https://github.com/gamerlogue/web/commit/5866cb5c8b4e01b10c31f3d6c9093650ae955a27) Revert "Set argon defaults to prevent password_hash(): Memory cost is outside of allowed memory range on PHP 7.4 (#5094)" (#5095)
- [`66dffd3`](https://github.com/gamerlogue/web/commit/66dffd3969899cc2c7e58e5dd63df9f45972b0dc) Revert "According to PHP Bug 78516 Argon2 requires at least 8KB (#5097)" (#5102)
- [`17ddc60`](https://github.com/gamerlogue/web/commit/17ddc602a89c05b4dc3452997c0e8ad54889e237) Revert routes
- [`0b40c41`](https://github.com/gamerlogue/web/commit/0b40c412e111200abf53ce5bc24d09247dcbe5e0) Revert "Apply fixes from StyleCI (#5006)"
- [`fddace3`](https://github.com/gamerlogue/web/commit/fddace3992fa4f77e0e7dc363fa6e611dd3c91ad) Revert "Apply fixes from StyleCI (#5356)" (#5357)
- [`25d4654`](https://github.com/gamerlogue/web/commit/25d465469484810c5451dc785546e3171cdfaee6) Revert "Fix PHPUnit bool server consts result in null (#5409)" (#5411)
- [`effdadb`](https://github.com/gamerlogue/web/commit/effdadb6f54df912f05da1376fccd0df1ff00040) Revert per user API rate limit
- [`2d283ba`](https://github.com/gamerlogue/web/commit/2d283ba079d608faaa079011322be0e36176c53d) Revert "Change "Login" text to "Log in" (#5536)" (#5537)
- [`c7d2fc0`](https://github.com/gamerlogue/web/commit/c7d2fc0f211da0475b4fd8eee775b8034930824a) Revert "Uses `LazilyRefreshDatabase` by default (#5696)" (#5700)
- [`da41953`](https://github.com/gamerlogue/web/commit/da41953a5cb6cd84a36b17a03fbe8114de3cb723) Revert "[9.x] Add Ignition"
- [`568c29e`](https://github.com/gamerlogue/web/commit/568c29e8fb3c7cf3e91643a5b6c4f5a5fce34a19) Reverts analysing routes folder as it causes issues with html coverage reporter (#5800)
- [`52d711b`](https://github.com/gamerlogue/web/commit/52d711bd3dbe9fa9aa6df8cefe7ae14b11813f3f) Revert "Add Redis facade as comment in app.config (#5813)" (#5814)
- [`768311d`](https://github.com/gamerlogue/web/commit/768311d05fff80e269dd670992e31240ed09f7e4) Revert "Fix .gitattributes consistency with .editorconfig (#5802)" (#5809)
- [`5f01768`](https://github.com/gamerlogue/web/commit/5f01768cb5e73ca21a2e8ef79cf7fbbab5fd7468) Revert "add ses-v2 mailer in config (#6112)" (#6115)
- [`1985a70`](https://github.com/gamerlogue/web/commit/1985a702549ea9fcc19d2fc50804c49166440cdb) Reverts #6089 (#6122)
- [`4c450b2`](https://github.com/gamerlogue/web/commit/4c450b2c2438e281cf02890916eb375e0c5bd25d) Revert "Fix incorrect collation for MySQL 8 (#6239)" (#6240)
- [`541d8c7`](https://github.com/gamerlogue/web/commit/541d8c7722870d3628c0ede2fc88fc2496fadbde) Revert "Let database handle default collation (#6241)" (#6266)
- [`7cdfdd7`](https://github.com/gamerlogue/web/commit/7cdfdd70a898933fbd2787d7817f4aeda875055e) Revert "Rename migration tables (#6295)" (#6298)
- [`a812867`](https://github.com/gamerlogue/web/commit/a8128676e960f07e1c935943c099d5752e0c4534) Revert "Fixes tests failing due database not available (#6297)" (#6299)
- [`3bce719`](https://github.com/gamerlogue/web/commit/3bce719b6ae1e69e481e0a73fd03234930be673d) Reverts `assertOk` change (#6303)
- [`cd3887d`](https://github.com/gamerlogue/web/commit/cd3887d597888ea29364e064ae43694e95eddd9b) Revert collation change (#6372)
- [`5deec73`](https://github.com/gamerlogue/web/commit/5deec737364506be57c41170390c5c17ca9ff30b) Revert "fix" (#6646)
- [`cd6e454`](https://github.com/gamerlogue/web/commit/cd6e4545d8b92010b69b7a789faa02e9a9cff05a) Revert "add index to failed jobs" (#6739)
- [`fc89640`](https://github.com/gamerlogue/web/commit/fc8964068c4fdfece98300407858a5ea2b7f161f) Revert index
- [`80d2f09`](https://github.com/gamerlogue/web/commit/80d2f09987863b1ec719adf02a2b16c83ddbc454) Revert "don't need it"
- [`80e96d2`](https://github.com/gamerlogue/web/commit/80e96d276a5c232705ed62dfd55dec50e6030c8c) Revert "Use database_path helper for sqlite database filename specified in .env"
- [`4fc45d7`](https://github.com/gamerlogue/web/commit/4fc45d75223fd5c62ac4cca069c98e0881f65634) Revert "[5.6] Use composer platform config"
- [`4464101`](https://github.com/gamerlogue/web/commit/4464101c5aee82315faf7259b399ed57a0342403) Revert "[5.5] Use composer platform config"
- [`277dd2e`](https://github.com/gamerlogue/web/commit/277dd2e0e0e0fb1ed9c1f6c960afe71e9fbbf0c1) Revert #4744
- [`25a980f`](https://github.com/gamerlogue/web/commit/25a980f35a721302c388e3743b6957212af3a071) Revert "[5.7] Ignore testing folder on storage/framework"
- [`44d2741`](https://github.com/gamerlogue/web/commit/44d274174f15317e3d28a0ea4aead883fb0f5bb2) Revert "[5.8] Modify RedirectIfAuthenticated middleware to accept multiple guards"
- [`ccea56b`](https://github.com/gamerlogue/web/commit/ccea56b6f910649d8a6ee25f61896d2b96e90496) Revert "Exclude StyleCI config from exported files (#5012)"
- [`af15fe5`](https://github.com/gamerlogue/web/commit/af15fe5ec688f59522e898dc74e0de54d84c3d96) Revert "Bump PHPUnit"
- [`31394de`](https://github.com/gamerlogue/web/commit/31394de4d736c171d40bb03d50313c60b0e4af38) Revert "Set argon defaults to prevent password_hash(): Memory cost is outside of allowed memory range on PHP 7.4 (#5094)" (#5095)
- [`56157b9`](https://github.com/gamerlogue/web/commit/56157b9cd201b5dc6fbe5f9f73014fa32e5a7838) Revert "According to PHP Bug 78516 Argon2 requires at least 8KB (#5097)" (#5102)
- [`e4683c6`](https://github.com/gamerlogue/web/commit/e4683c6ecaff9a7dc779fb0dfe39f6336832fc9d) Revert routes
- [`5df3b7b`](https://github.com/gamerlogue/web/commit/5df3b7b1fe07a22d3275180ece0b31f45682f07e) Revert "Apply fixes from StyleCI (#5006)"
- [`407b6b8`](https://github.com/gamerlogue/web/commit/407b6b8b04820a7fc0eb3143a8255abbeabb3eb9) Revert "Apply fixes from StyleCI (#5356)" (#5357)
- [`c6c41f1`](https://github.com/gamerlogue/web/commit/c6c41f11b8ea3065f035fbb6a6f570b7bfba0037) Revert "Fix PHPUnit bool server consts result in null (#5409)" (#5411)
- [`453d728`](https://github.com/gamerlogue/web/commit/453d7286f3918e067b7a06707be1f22ef59815b8) Revert per user API rate limit
- [`22626b5`](https://github.com/gamerlogue/web/commit/22626b5701cc7557d4bd45a6af5730027fc4a061) Revert "Change "Login" text to "Log in" (#5536)" (#5537)
- [`6a68092`](https://github.com/gamerlogue/web/commit/6a68092228844b1793bbcf4f0bf7c5ba2c9bd16c) Revert "Uses `LazilyRefreshDatabase` by default (#5696)" (#5700)
- [`3701593`](https://github.com/gamerlogue/web/commit/3701593e66c96315af5586a59c3533929293be9a) Revert "[9.x] Add Ignition"
- [`b86a62a`](https://github.com/gamerlogue/web/commit/b86a62a6b865d0632ade6fe334dfa1358d18d500) Reverts analysing routes folder as it causes issues with html coverage reporter (#5800)
- [`f2b8023`](https://github.com/gamerlogue/web/commit/f2b8023df3725631db1af11480b7f0f0b2576c74) Revert "Add Redis facade as comment in app.config (#5813)" (#5814)
- [`6c1f430`](https://github.com/gamerlogue/web/commit/6c1f430aa76809084668f9a97121bd2ca8bafa10) Revert "Fix .gitattributes consistency with .editorconfig (#5802)" (#5809)
- [`1bb530c`](https://github.com/gamerlogue/web/commit/1bb530c6090fdc58aace03cf8eb382574bec8b2f) Revert "add ses-v2 mailer in config (#6112)" (#6115)
- [`e121424`](https://github.com/gamerlogue/web/commit/e121424f90b3acc0358c5c94dace6524428f74a8) Reverts #6089 (#6122)
- [`96d3ecf`](https://github.com/gamerlogue/web/commit/96d3ecf5c26577530306374eb8e164fdc7425978) Revert "Fix incorrect collation for MySQL 8 (#6239)" (#6240)
- [`024c86a`](https://github.com/gamerlogue/web/commit/024c86a24bdc8b02c38d41442f3908aae09f31a7) Revert "Let database handle default collation (#6241)" (#6266)
- [`3f1426a`](https://github.com/gamerlogue/web/commit/3f1426a55a56cd7187e8b96b82ff6e97dc0a603f) Revert "Rename migration tables (#6295)" (#6298)
- [`5d93ebd`](https://github.com/gamerlogue/web/commit/5d93ebdb76383c11525714aa1fb06ab234ea8811) Revert "Fixes tests failing due database not available (#6297)" (#6299)
- [`0c8372a`](https://github.com/gamerlogue/web/commit/0c8372a2e66595c7a8b9977cc9c145b9ce1df7ac) Reverts `assertOk` change (#6303)
- [`087543a`](https://github.com/gamerlogue/web/commit/087543a48c35787fa67e4b69b79ae301824adeec) Revert collation change (#6372)
- [`902200e`](https://github.com/gamerlogue/web/commit/902200e7aac4af7efff60ed7ee958932b83ff2e4) Revert "fix" (#6646)
- [`e713de2`](https://github.com/gamerlogue/web/commit/e713de24b883712cbb7fbc12d9b3aa1460e28cb7) Revert "add index to failed jobs" (#6739)
- [`945f4e5`](https://github.com/gamerlogue/web/commit/945f4e5a9fd3695dc0ee512f497c650fb82cfbb8) Revert index

### 🔀 Pull Requests

- [`c17e357`](https://github.com/gamerlogue/web/commit/c17e357fb6e2fa7c23a04665aa3a08dc5c08ac74) Merge pull request #1 from hinathan/master
- [`e87f7dc`](https://github.com/gamerlogue/web/commit/e87f7dc2f5fcfd211312fccc0fdfddf148a0cda5) Merge pull request #5 from mikelbring/develop
- [`80173d4`](https://github.com/gamerlogue/web/commit/80173d4848785a41d1e529c57c0c832c1c38ebc5) Merge pull request #4 from pedroborges/develop
- [`65b0068`](https://github.com/gamerlogue/web/commit/65b0068d38c8e01260f351ba615d593d10a8d873) Merge pull request #10 from mikelbring/develop
- [`7803708`](https://github.com/gamerlogue/web/commit/780370826a2dba4d5fd67e44da5d17a5475c448c) Merge pull request #11 from mikelbring/develop
- [`c463952`](https://github.com/gamerlogue/web/commit/c4639524d09982a041234f3897da4fd0814a63e1) Merge pull request #12 from mikelbring/develop
- [`fe10176`](https://github.com/gamerlogue/web/commit/fe101766947fd228fd029635cdbbf71c945bf9fb) Merge pull request #13 from mikelbring/develop
- [`ab3be56`](https://github.com/gamerlogue/web/commit/ab3be568ea52e0117da9adf2496ada7929ec053c) Merge pull request #15 from toszcze/apc
- [`2b4093f`](https://github.com/gamerlogue/web/commit/2b4093f7a5af2eb28d8059d73f37ab2dce8fe257) Merge pull request #16 from michaelowens/develop
- [`e0cb6e6`](https://github.com/gamerlogue/web/commit/e0cb6e6aba0725e9e742c859ced8ef24b186c125) Merge pull request #18 from mikelbring/develop
- [`99ae26d`](https://github.com/gamerlogue/web/commit/99ae26d0e6f7d4e47e2e22080a1feb497b27c990) Merge pull request #24 from mikelbring/develop
- [`2d39ec5`](https://github.com/gamerlogue/web/commit/2d39ec5efe31427f2b7b9a12f7b869ce2b620f09) Merge pull request #29 from dongilbert/master
- [`6b77cc9`](https://github.com/gamerlogue/web/commit/6b77cc984e2766a2f815d976bdd958939d79f138) Merge pull request #32 from pedroborges/master
- [`2c68317`](https://github.com/gamerlogue/web/commit/2c68317b0de74223d1abcccbb4d14ceb5e8322d4) Merge pull request #36 from pedroborges/asset
- [`12185bd`](https://github.com/gamerlogue/web/commit/12185bd4db680f7aa768ee96213c1bdfc1795f88) Merge pull request #38 from mikelbring/develop
- [`a0c7db3`](https://github.com/gamerlogue/web/commit/a0c7db34fcbd79c0bbd491d5b1a0df297c542a87) Merge pull request #50 from mikelbring/develop
- [`1c4f305`](https://github.com/gamerlogue/web/commit/1c4f3052955f6de2a6b3fc32fdfbfc06a3b652a8) Merge pull request #52 from staydecent/master
- [`8cdf5f2`](https://github.com/gamerlogue/web/commit/8cdf5f2444e2639f2f93cd75feeb82e83014d7b5) Merge pull request #53 from staydecent/master
- [`914b60e`](https://github.com/gamerlogue/web/commit/914b60e20bb06b7f027df099ac791b5464c92cd8) Merge pull request #56 from mikelbring/develop
- [`8798d87`](https://github.com/gamerlogue/web/commit/8798d87e2fe32e7f46ee33442d3141c12bf1b2e9) Merge pull request #57 from pedroborges/develop
- [`399892d`](https://github.com/gamerlogue/web/commit/399892ddda3deee93e7d6a3ae8115d615c50213a) Merge pull request #59 from drowe/master
- [`4781832`](https://github.com/gamerlogue/web/commit/47818321878aebcc20cac76c5e9937e288f5ba02) Merge pull request #92 from wGEric/develop
- [`886a6f4`](https://github.com/gamerlogue/web/commit/886a6f4facded5f7eb1a9e6bba817d11af77eb72) Merge pull request #93 from wGEric/develop
- [`c00738a`](https://github.com/gamerlogue/web/commit/c00738a070202c7e55f4eae39aaaa15010f9bcfa) Merge pull request #101 from codler/patch-1
- [`2c2dcdc`](https://github.com/gamerlogue/web/commit/2c2dcdc5029675abfba6fd778da16cbcca0f7447) Merge pull request #99 from sparksp/aeae2c8476523f1551825afcc17323c4b88d22c5
- [`e366c62`](https://github.com/gamerlogue/web/commit/e366c62db1251ecb970acd4a6842e4ed46e0bcc1) Merge pull request #106 from ericbarnes/feature/foreign_chars
- [`92ecae3`](https://github.com/gamerlogue/web/commit/92ecae3db986a3712cbb8e0522c2c67f3ce511ab) Merge pull request #108 from ericbarnes/feature/alias
- [`6178a96`](https://github.com/gamerlogue/web/commit/6178a968eacbaf2bafc6ec836ba1d3120cc2e2db) Merge pull request #110 from ericbarnes/feature/remember_me
- [`459b216`](https://github.com/gamerlogue/web/commit/459b2165a33b228440a72f05ca7f703681cb07a2) Merge pull request #111 from ericbarnes/feature/str_limit
- [`d951222`](https://github.com/gamerlogue/web/commit/d9512221dcb8fd07a39f34c6011915b63c8716d3) Merge pull request #112 from ericbarnes/feature/unit-test
- [`e979cf1`](https://github.com/gamerlogue/web/commit/e979cf14a26002d84a086a48be55ad330422adba) Merge pull request #115 from ericbarnes/fix/str_tests
- [`494bc0b`](https://github.com/gamerlogue/web/commit/494bc0b4a72fe85b45df098c425cbabe04b0e96e) Merge pull request #120 from sparksp/fix/route_before
- [`6ed7c83`](https://github.com/gamerlogue/web/commit/6ed7c832d9c58e331cd046af473c0d1026bdb5af) Merge pull request #119 from sparksp/fix/base_path
- [`320653e`](https://github.com/gamerlogue/web/commit/320653e832ab6db021649db730a0fb2f0e994423) Merge pull request #122 from sparksp/fix/env_config
- [`128984f`](https://github.com/gamerlogue/web/commit/128984facb85061ea56e9ebc8bcb301b44b14b64) Merge pull request #132 from daylerees/develop
- [`28b42c6`](https://github.com/gamerlogue/web/commit/28b42c64feed9e73cec6907ebc6119c2bfcc7dcb) Merge pull request #133 from jjaffeux/patch-1
- [`498a83a`](https://github.com/gamerlogue/web/commit/498a83abe999cd2a77c516d9f2fa35b0b4816bd7) Merge pull request #140 from paulboco/develop
- [`968e80b`](https://github.com/gamerlogue/web/commit/968e80bcff36e3870527165ad1a31ec029c5ab98) Merge pull request #149 from jaysonic/develop
- [`8a94c97`](https://github.com/gamerlogue/web/commit/8a94c9787ab9208c5a7d24588abe159d33813eab) Merge pull request #147 from sparksp/develop/fix_inflector
- [`c11ee76`](https://github.com/gamerlogue/web/commit/c11ee76511408637d4874d8fd1f96b5bf7fd1409) Merge pull request #151 from sparksp/develop/ioc-container
- [`bdbdd05`](https://github.com/gamerlogue/web/commit/bdbdd05b6a0c7a92f8ee7c21699c51b568accb86) Merge pull request #155 from sparksp/develop/fix-uri
- [`8b803fd`](https://github.com/gamerlogue/web/commit/8b803fd356f3d2affca961804ca521b4e11fa261) Merge pull request #156 from sparksp/develop/exception
- [`beb44eb`](https://github.com/gamerlogue/web/commit/beb44eb429aa67ac53995ce4bfeb2541277b6c7b) Merge pull request #157 from sparksp/develop/exception
- [`5b9f6d1`](https://github.com/gamerlogue/web/commit/5b9f6d1bd3569f2cd792e7e008c836d858835fab) Merge pull request #161 from sparksp/develop/fix-cache
- [`570b431`](https://github.com/gamerlogue/web/commit/570b431c0509efe48e5e27cc208e21ab816fe234) Merge pull request #159 from sparksp/develop/redis
- [`1746dbd`](https://github.com/gamerlogue/web/commit/1746dbdb6c92eb935727537606611d0f0203e66e) Merge pull request #170 from codler/patch-1
- [`b0ffc01`](https://github.com/gamerlogue/web/commit/b0ffc0183a81cf14ea3807451a825d7651fbfba7) Merge pull request #171 from daniels0xff/develop
- [`8508f1b`](https://github.com/gamerlogue/web/commit/8508f1bb3a50600448a00e4f8c1ef0aafd638b6c) Merge pull request #175 from sparksp/fix/response
- [`09c60d0`](https://github.com/gamerlogue/web/commit/09c60d01dcc441572339a7d48c6015ccbc5221ee) Merge pull request #197 from codler/patch-2
- [`a2aa741`](https://github.com/gamerlogue/web/commit/a2aa74181494e7408cccae2ec19eaf1aea5d9b6d) Merge pull request #199 from syntaqx/master
- [`791dbde`](https://github.com/gamerlogue/web/commit/791dbdebe763e6b7b6d4c28dd8500c31646a69a7) Merge pull request #207 from sparksp/fix/session-flush
- [`9d7534f`](https://github.com/gamerlogue/web/commit/9d7534fa70200d8407dbeeb6dab8535d77edcabb) Merge pull request #211 from codler/patch-3
- [`b1524e8`](https://github.com/gamerlogue/web/commit/b1524e86427eb905817c8e1d1e2a1ed1d3dccf41) Merge pull request #217 from codler/patch-4
- [`59fcd67`](https://github.com/gamerlogue/web/commit/59fcd67637e9a1d5abdd51fd6dfdc5931baa644c) Merge pull request #214 from akuzemchak/develop
- [`5e82788`](https://github.com/gamerlogue/web/commit/5e82788b4d7d9f3fddd100a4945b08485fbd1501) Merge pull request #258 from sparksp/2.2b1/migrate-mkdir
- [`35e3642`](https://github.com/gamerlogue/web/commit/35e364282ae64803321dadd58a80084bdb4292fa) Merge pull request #253 from sparksp/2.2b1/session
- [`e6cec8c`](https://github.com/gamerlogue/web/commit/e6cec8c54ba973c6d466af24fade4cef682c4b5d) Merge pull request #246 from ericbarnes/develop
- [`8e5c736`](https://github.com/gamerlogue/web/commit/8e5c736392029f047b9af0ff9960b13509c6d425) Merge pull request #245 from paulboco/develop
- [`4737c6d`](https://github.com/gamerlogue/web/commit/4737c6d8a95a83cdea541d61243bf4c78ada811e) Merge pull request #244 from codler/patch-7
- [`611f8d7`](https://github.com/gamerlogue/web/commit/611f8d7e1b8cbd4da1ad4e27ec899c477a9c6d05) Merge pull request #265 from kbanman/viewfix
- [`4806bcc`](https://github.com/gamerlogue/web/commit/4806bccbb61b6f07f9dd0f10806aa72c95b50a07) Merge pull request #270 from sparksp/2.2b1/bundle-start
- [`96c43d6`](https://github.com/gamerlogue/web/commit/96c43d6d877bb1f6ec5e0b29ba1b45e683391060) Merge pull request #272 from kbanman/clicommandfix
- [`409e908`](https://github.com/gamerlogue/web/commit/409e90896422eee9590b80eae0f78128b9265ff6) Merge pull request #285 from sparksp/3.0b2/bundle-location
- [`af5e4c6`](https://github.com/gamerlogue/web/commit/af5e4c6be6ce65e33c8d94994a4fbc31ed8dd66c) Merge pull request #278 from codler/patch-8
- [`221d2f8`](https://github.com/gamerlogue/web/commit/221d2f8af5067996507c946f5c0ec1303f9bc91e) Merge pull request #260 from sparksp/2.2b1/migrate-sort
- [`6c1e357`](https://github.com/gamerlogue/web/commit/6c1e3578addde56aab72df946ae2467fbb4e05e6) Merge pull request #279 from subdesign/patch-1
- [`ac277c5`](https://github.com/gamerlogue/web/commit/ac277c58e662a923fbb9ef794ce15bd0fe1a48cf) Merge pull request #296 from cviebrock/develop
- [`95a5af3`](https://github.com/gamerlogue/web/commit/95a5af376a416dd823da0f9d645cd79fdd479757) Merge pull request #306 from sparksp/patch-1
- [`2e492a7`](https://github.com/gamerlogue/web/commit/2e492a710a5bd8a8951b45a8c00fac237a5efea6) Merge pull request #308 from sparksp/patch-3
- [`53a2053`](https://github.com/gamerlogue/web/commit/53a20533f1fc529911c3effa20bd3cef86e24702) Merge pull request #335 from daylerees/develop
- [`ed72448`](https://github.com/gamerlogue/web/commit/ed72448fb0d4ab25c983a5b6e895535ddb0c8817) Merge pull request #343 from sparksp/patch-4
- [`5919b03`](https://github.com/gamerlogue/web/commit/5919b039e62e1afb0566a344d272453e454129c2) Merge pull request #349 from Kindari/patch-1
- [`c88433f`](https://github.com/gamerlogue/web/commit/c88433f16a59e7a9b26f14a2e379d2bc49a0c913) Merge pull request #351 from ladea/develop
- [`ebcae54`](https://github.com/gamerlogue/web/commit/ebcae547fa2c4f949e992824d489ef0ddddc3e60) Merge pull request #370 from cviebrock/develop
- [`8607fcc`](https://github.com/gamerlogue/web/commit/8607fcc9330c47f33585f217116d7c67eaa1d511) Merge pull request #382 from daylerees/fetching-notice
- [`9ab1144`](https://github.com/gamerlogue/web/commit/9ab1144f78ec9e500c9c51fd155a21502168847e) Merge pull request #379 from jasonlewis/patch-6
- [`20f62b5`](https://github.com/gamerlogue/web/commit/20f62b5a1d04f08faf58c4ae41989463296da977) Merge pull request #393 from ShawnMcCool/master
- [`18f9141`](https://github.com/gamerlogue/web/commit/18f91414bbbdf069dd28af4afb6e19692d3beced) Merge pull request #396 from cviebrock/develop
- [`d862a51`](https://github.com/gamerlogue/web/commit/d862a5181a8fe4bb2da60a033ae75211eec96dea) Merge pull request #399 from kbanman/develop
- [`d8683bc`](https://github.com/gamerlogue/web/commit/d8683bcf5b60be088c58297b2f0a5b8ec8a0c129) Merge pull request #397 from maxzender/develop
- [`c18dcec`](https://github.com/gamerlogue/web/commit/c18dcecb00077966a64cdb151bc1b93ad09590ad) Merge pull request #420 from kyledecot/develop
- [`ea8d80d`](https://github.com/gamerlogue/web/commit/ea8d80d67de87d50bba4ba4f380566783a845107) Merge pull request #371 from daylerees/patch-1
- [`aadddcb`](https://github.com/gamerlogue/web/commit/aadddcb1d513f7f564f702501dd51388c4797040) Merge pull request #425 from loic-sharma/patch-1
- [`7e7f70d`](https://github.com/gamerlogue/web/commit/7e7f70dbdd0d46a6b0124638fa09fb15852e987e) Merge pull request #423 from akhodakivskiy/master
- [`6e82a4a`](https://github.com/gamerlogue/web/commit/6e82a4ac8d34c97c80d746aa1d9663a8c5aac2dc) Merge pull request #359 from akuzemchak/feature/load-route
- [`2809eb2`](https://github.com/gamerlogue/web/commit/2809eb260fdf453eb85e815a3466367981842c24) Merge pull request #435 from cviebrock/develop
- [`5cbebb9`](https://github.com/gamerlogue/web/commit/5cbebb99d3a990d2409dd9c4996ca31efc7ffec8) Merge pull request #436 from daylerees/date-filters
- [`ca77cd5`](https://github.com/gamerlogue/web/commit/ca77cd5a174fcc985ae8a364277a2135dd7bfa27) Merge pull request #438 from sparksp/patch-7
- [`37fd54b`](https://github.com/gamerlogue/web/commit/37fd54b8485cd1ee317580c2d097e4ace8e1dc52) Merge pull request #448 from danielboendergaard/patch-1
- [`afa12d3`](https://github.com/gamerlogue/web/commit/afa12d3dd3e4b8690836791bc9a1b1a0a59a69ce) Merge pull request #449 from vladrusu/master
- [`713f70a`](https://github.com/gamerlogue/web/commit/713f70a777bff57331dd34a4fca5828b70bc111d) Merge pull request #456 from Tenga/master
- [`902e8c7`](https://github.com/gamerlogue/web/commit/902e8c75003abc85cec4d17aa72141f70584f1a2) Merge pull request #479 from daylerees/docs-template
- [`21cee36`](https://github.com/gamerlogue/web/commit/21cee3667bcb622fa132c328b0929a7e6e28ec69) Merge pull request #482 from daylerees/docs-template
- [`ff484b7`](https://github.com/gamerlogue/web/commit/ff484b7203f87b38806011237d18a21347ec06cb) Merge pull request #483 from daylerees/docs-template
- [`e29270f`](https://github.com/gamerlogue/web/commit/e29270f6a7ea80bb71e72fc2e7d4feeadf6aaa07) Merge pull request #487 from jasonlewis/patch-8
- [`2af6059`](https://github.com/gamerlogue/web/commit/2af60594579988471bbe845cbc7581ab1158330f) Merge pull request #486 from daylerees/docs-template
- [`974ac61`](https://github.com/gamerlogue/web/commit/974ac6153509f217d352cc86442b6f8397a7f885) Merge pull request #490 from daylerees/markdown-extra
- [`d1adc8c`](https://github.com/gamerlogue/web/commit/d1adc8c181409837819a2e92d2dcbad5f33d2011) Merge pull request #484 from kbanman/bugfix-pivot
- [`6164607`](https://github.com/gamerlogue/web/commit/616460725f2c66c8045c10b9826f56d876b59c93) Merge pull request #496 from daylerees/anbu-jquery-fix
- [`943309e`](https://github.com/gamerlogue/web/commit/943309e00a1c9d1c08b8bed0503f74882bd16b8d) Merge pull request #498 from daylerees/anbu-jquery-fix
- [`9ee9e7b`](https://github.com/gamerlogue/web/commit/9ee9e7bb5ec47f2d634113f39f3135130685388d) Merge pull request #518 from joecwallace/eloquent-model-table-basename-fix
- [`a3e0c7c`](https://github.com/gamerlogue/web/commit/a3e0c7c0c49fa27d0edd36039b0518bf16f1cb56) Merge pull request #522 from kloy/master
- [`b370549`](https://github.com/gamerlogue/web/commit/b370549d808595e08c07ddeeccaba4380503e1ad) Merge pull request #517 from joecwallace/migrate-resolver-classify-fix
- [`2e7cca1`](https://github.com/gamerlogue/web/commit/2e7cca1d0bd90925946b70b02814c42c06080ca9) Merge pull request #512 from Mikaweb/patch-1
- [`f786b33`](https://github.com/gamerlogue/web/commit/f786b33e85f952ff23a8c7ce51abc6387423a698) Merge pull request #515 from gaker/develop
- [`78a2bce`](https://github.com/gamerlogue/web/commit/78a2bce820d17646b0f1aa32945925c9cce63a79) Merge pull request #509 from cviebrock/section-append
- [`f1435ce`](https://github.com/gamerlogue/web/commit/f1435ce1950520f9edce20bd8983187afd07d472) Merge pull request #546 from ProgerXP/patch-typos
- [`7ba97bc`](https://github.com/gamerlogue/web/commit/7ba97bc3b579af200812a77f3457e6b7ba65e005) Merge pull request #550 from davzie/develop
- [`7199ac8`](https://github.com/gamerlogue/web/commit/7199ac8e9ce80bec532fd9d80a4f8c03ea5f105e) Merge pull request #549 from ProgerXP/patch-ru
- [`eafb4bd`](https://github.com/gamerlogue/web/commit/eafb4bdfb8e6d4f44debd96c0f49d8599bad8350) Merge pull request #501 from daylerees/error-pages
- [`b9d5734`](https://github.com/gamerlogue/web/commit/b9d573467a6575f2a7e4c2e8499306362f1587a1) Merge pull request #531 from markhuot/develop
- [`45c9d15`](https://github.com/gamerlogue/web/commit/45c9d15442b760ca6a5d73ae5c248aa56ce8d77f) Merge pull request #559 from ProgerXP/patch-ioc-resolve
- [`3670423`](https://github.com/gamerlogue/web/commit/3670423da6e74c5b5078972e29b527c7f761bcd2) Merge pull request #558 from ProgerXP/patch-locks-dev
- [`cac5eba`](https://github.com/gamerlogue/web/commit/cac5ebad4a87e9261f329fc3ceea54d9c6ab3d02) Merge pull request #507 from sparksp/develop-patch-2
- [`8e05530`](https://github.com/gamerlogue/web/commit/8e05530869cce7bde7ba080e9c9c38e8df7c8fe3) Merge pull request #570 from AoSiX/urlencode_issue
- [`9057c60`](https://github.com/gamerlogue/web/commit/9057c60a5f55e816ac845e67bac51c62ed4f3f68) Merge pull request #584 from bencorlett/develop
- [`48dae0c`](https://github.com/gamerlogue/web/commit/48dae0c3d972eed29e7f5b0edbf53e8e504bb550) Merge pull request #578 from cviebrock/asset-url
- [`57c228a`](https://github.com/gamerlogue/web/commit/57c228aec6e9c6d4134b62b983afdc7e4a4aa639) Merge pull request #611 from asdfgh746/develop
- [`f53c828`](https://github.com/gamerlogue/web/commit/f53c8285a7d908a73fc86450a56680a5cb17464b) Merge pull request #564 from ProgerXP/patch-del
- [`11f08fb`](https://github.com/gamerlogue/web/commit/11f08fb737b0eaa40af8ab0b84068791796a18d3) Merge pull request #590 from Vespakoen/develop
- [`9ca8129`](https://github.com/gamerlogue/web/commit/9ca81296d8fb34a711be7524afdea7831cca6d85) Merge pull request #589 from whitman/numeric-routes
- [`e256a66`](https://github.com/gamerlogue/web/commit/e256a66b18868f8470d807e5bfefde0f913bfbbb) Merge pull request #562 from ProgerXP/patch-lang
- [`e85ca96`](https://github.com/gamerlogue/web/commit/e85ca96e383d633b489a2e49413a8a588cc9ff19) Merge pull request #614 from awellis13/feature/trim-sql-for-query
- [`6923b7c`](https://github.com/gamerlogue/web/commit/6923b7c95d66d9f081867432b139a058f553d444) Merge pull request #623 from sparksp/develop-patch-view
- [`84f2209`](https://github.com/gamerlogue/web/commit/84f2209e3ccdd0c294a1738e4e0efe98bb8c6058) Merge pull request #624 from CoolGoose/patch-1
- [`a697781`](https://github.com/gamerlogue/web/commit/a69778139057c1a8414fae27e128614f5e90bc77) Merge pull request #628 from daylerees/custom-blade
- [`d3811af`](https://github.com/gamerlogue/web/commit/d3811af333aafb55359381614100272c3aacfe26) Merge pull request #625 from daylerees/docs-style-fix
- [`16719ed`](https://github.com/gamerlogue/web/commit/16719ed45596a067306b9773fe6dd98e7676bd7b) Merge pull request #630 from dlpetrie/patch-3
- [`1f706bd`](https://github.com/gamerlogue/web/commit/1f706bd2d1ae8201c4447b81ac8b10ba4d7bd687) Merge pull request #633 from crynobone/feature/validator-replace-attr
- [`c0b9de2`](https://github.com/gamerlogue/web/commit/c0b9de27eb70b088cb6231fe5ee478dd946229c7) Merge pull request #645 from cviebrock/develop
- [`cded744`](https://github.com/gamerlogue/web/commit/cded744ac9a441bb584821b7e7a16dd98699ef56) Merge pull request #648 from cviebrock/array-helpers
- [`287f2a2`](https://github.com/gamerlogue/web/commit/287f2a299fda21d93e687bce5cf9eea13b428ac2) Merge pull request #641 from crynobone/feature/form-select-optgroup
- [`0ad9c67`](https://github.com/gamerlogue/web/commit/0ad9c67fa0f147a068c3023979d124cc5f4b45c1) Merge pull request #631 from loic-sharma/patch-2
- [`d0edf92`](https://github.com/gamerlogue/web/commit/d0edf92e31dfdaa370b161a9f281925bd7185035) Merge pull request #640 from crynobone/feature/remove-prettyprint
- [`01894ae`](https://github.com/gamerlogue/web/commit/01894ae4eed1c5b54e8ce19dddf6fed0a3f14cf6) Merge pull request #651 from dlpetrie/patch-4
- [`641f1d4`](https://github.com/gamerlogue/web/commit/641f1d4c14a50b50f12a9929306cbffd308a5e91) Merge pull request #615 from awellis13/feature/route-cleanup
- [`df79b47`](https://github.com/gamerlogue/web/commit/df79b47cc9f40c86ccee69902bc142c512fcbcd9) Merge pull request #656 from cviebrock/array-helpers
- [`492b49a`](https://github.com/gamerlogue/web/commit/492b49a04b3963a260779f35b696b774c6f6558e) Merge pull request #661 from cviebrock/develop
- [`94f49c3`](https://github.com/gamerlogue/web/commit/94f49c3627a4c999196f49d898e0a1fef78144c8) Merge pull request #663 from cviebrock/develop
- [`4cff090`](https://github.com/gamerlogue/web/commit/4cff0907a04984ca86ea591884ef13bf0751f1b0) Merge pull request #669 from awellis13/feature/where_nested-closure-fix
- [`135b6d5`](https://github.com/gamerlogue/web/commit/135b6d513262e602873e7d485e801b5269c7f352) Merge pull request #664 from franzliedke/patch-3
- [`d417eb5`](https://github.com/gamerlogue/web/commit/d417eb566402ed51639e55199b925ebf1d292663) Merge pull request #658 from jkudish/develop
- [`21d8a26`](https://github.com/gamerlogue/web/commit/21d8a266e6820036b68d6836a360123cbe24d01a) Merge pull request #673 from daylerees/patch-2
- [`a6ad5c6`](https://github.com/gamerlogue/web/commit/a6ad5c6dee03c6a7799199229f0389756c148039) Merge pull request #671 from ErikDubbelboer/docfix
- [`dbb4c16`](https://github.com/gamerlogue/web/commit/dbb4c169da06415f32fc39df6eb6468484264eca) Merge pull request #685 from loic-sharma/patch-1
- [`5adc225`](https://github.com/gamerlogue/web/commit/5adc2256d718623a6d322dc5d759f48d8e375c68) Merge pull request #688 from syntaqx/readme
- [`d29c5bf`](https://github.com/gamerlogue/web/commit/d29c5bfdabaac43ff2c7551812486e741bd065b1) Merge pull request #687 from syntaqx/git-files
- [`c80a2e4`](https://github.com/gamerlogue/web/commit/c80a2e466a23f0286930dc5aa72ebc52d4aaff7a) Merge pull request #693 from kbanman/request-fix
- [`34919af`](https://github.com/gamerlogue/web/commit/34919aff71d30c9c40f7f6d71f18aa07eca20760) Merge pull request #709 from daylerees/patch-3
- [`23f469a`](https://github.com/gamerlogue/web/commit/23f469ae536d362a4929eb1797ad83ca2a0520af) Merge pull request #716 from daylerees/feature/forelse-fix
- [`548e73a`](https://github.com/gamerlogue/web/commit/548e73ac94ea7e8ccb23545e9d40f0f460c66074) Merge pull request #715 from daylerees/feature/overide-core-tasks
- [`63b1636`](https://github.com/gamerlogue/web/commit/63b1636d138222f147c6afbf5b34718ee048b853) Merge pull request #695 from daylerees/profiler-upgrade
- [`3e92ee2`](https://github.com/gamerlogue/web/commit/3e92ee27db3d5edde4effe8e1c8bdd5b3631d42e) Merge pull request #701 from tkaw220/develop
- [`8038697`](https://github.com/gamerlogue/web/commit/80386977aaeb5d41ace3169e46fe671d3185bd72) Merge pull request #699 from falzhobel/profiler-js-finetune
- [`639d64c`](https://github.com/gamerlogue/web/commit/639d64c58403a00dc653726443b19c738f54e99e) Merge pull request #711 from benjam-es/patch-1
- [`c1de1d6`](https://github.com/gamerlogue/web/commit/c1de1d61d82d8130b40ee989aa79d1bc29cfdd90) Merge pull request #728 from AndrewBNZ/master
- [`aa687d0`](https://github.com/gamerlogue/web/commit/aa687d039d07ff3dd7454a3a00ecad29ff2f2032) Merge pull request #725 from kapv89/patch-1
- [`6758379`](https://github.com/gamerlogue/web/commit/67583790d4c4311a02b78078eaa755ea6ba29fa0) Merge pull request #723 from syntaqx/htaccess
- [`db62062`](https://github.com/gamerlogue/web/commit/db6206218ae4c4446dcacc8017c67d7d287c9c4a) Merge pull request #722 from syntaqx/readme-cleanup
- [`c2ad6a8`](https://github.com/gamerlogue/web/commit/c2ad6a812653eaf7d1a920e205caedcbeca43f51) Merge pull request #714 from daylerees/feature/error-format
- [`4bb2e5f`](https://github.com/gamerlogue/web/commit/4bb2e5f63fb749e02fbe6334ead1c2747561bb08) Merge pull request #698 from bencorlett/html-lists
- [`cf604d4`](https://github.com/gamerlogue/web/commit/cf604d4e797dadbcbb9f3b8c399810a07f22c006) Merge pull request #689 from crlosmify/html
- [`bc67c66`](https://github.com/gamerlogue/web/commit/bc67c667a9a53679863bc30cce62575aa8a6bc4c) Merge pull request #730 from sparksp/develop-default-https
- [`ba4271c`](https://github.com/gamerlogue/web/commit/ba4271c999f941e3eb203a8cd20325d7d5ba7c68) Merge pull request #752 from AndrewBNZ/master
- [`3805b69`](https://github.com/gamerlogue/web/commit/3805b69aee429e8751ff0bbc88608fbda9251be4) Merge pull request #748 from hamuz/patch-1
- [`0bdfea3`](https://github.com/gamerlogue/web/commit/0bdfea32e7130c9c4e29b9e2f1dda6e36dd3cdc8) Merge pull request #747 from kloy/master
- [`4b49ae4`](https://github.com/gamerlogue/web/commit/4b49ae422c52adc1a90223ff3b1b7b5eec168909) Merge pull request #746 from delmot/develop
- [`cfc0577`](https://github.com/gamerlogue/web/commit/cfc0577d501ab89ac4b4188badde2294c1d0dc34) Merge pull request #751 from jasonlewis/patch-9
- [`5cb8b9b`](https://github.com/gamerlogue/web/commit/5cb8b9bfe962d478f07e3717d977eb76f49744eb) Merge pull request #750 from robmeijer/develop
- [`1b71a0e`](https://github.com/gamerlogue/web/commit/1b71a0ed89e2176683601fe2a4e676c6fc47d4a3) Merge pull request #743 from kbanman/response-fix
- [`b1707f2`](https://github.com/gamerlogue/web/commit/b1707f2bc1d8c4852447d54e568cb7748b3eb811) Merge pull request #737 from ianlandsman/develop
- [`930a3e8`](https://github.com/gamerlogue/web/commit/930a3e89e02ca59290873c36383ade9a5f1083a4) Merge pull request #736 from joecwallace/cli-env-management
- [`aae8b62`](https://github.com/gamerlogue/web/commit/aae8b62d6ad1c65f6c181dd782f5eec9d6e28c85) Merge pull request #735 from lukemartin/patch-1
- [`f608157`](https://github.com/gamerlogue/web/commit/f608157ffcb69a1fb221ae68b8b0aba448769dd1) Merge pull request #732 from franzliedke/patch-4
- [`8205a21`](https://github.com/gamerlogue/web/commit/8205a2196508c7094756a1857a78c1d250abcc2a) Merge pull request #707 from cviebrock/auth-pass-field
- [`ad14938`](https://github.com/gamerlogue/web/commit/ad14938cb2ad62b0d94917092cb9cf610ad791a2) Merge pull request #760 from cviebrock/develop
- [`14868a5`](https://github.com/gamerlogue/web/commit/14868a5fd595d5622a7b0a0164d0fbba00defd10) Merge pull request #792 from asdfgh746/develop
- [`5279773`](https://github.com/gamerlogue/web/commit/527977337d1e6af025f8b42d5d2c7cf0e335cf7f) Merge pull request #823 from Vespakoen/patch-3
- [`1c0501e`](https://github.com/gamerlogue/web/commit/1c0501ef305fef2f94fa98dba5de0b92924c0304) Merge pull request #833 from tobsn/patch-4
- [`749a91f`](https://github.com/gamerlogue/web/commit/749a91f948af1eb4674566920b5dfdef15c6875b) Merge pull request #840 from noor/develop
- [`1f9f064`](https://github.com/gamerlogue/web/commit/1f9f064bf6dd72a50569bf4a73c0b7adeb6204a4) Merge pull request #831 from jasonlewis/feature/blade-break
- [`7354b5f`](https://github.com/gamerlogue/web/commit/7354b5fc7255305e1c80ef8ac57f64ffc5105d53) Merge pull request #824 from tobsn/patch-1
- [`fc96014`](https://github.com/gamerlogue/web/commit/fc96014c4f340d1fc773c93063fc994cce3b2a1c) Merge pull request #821 from daylerees/feature/clear-input
- [`6405175`](https://github.com/gamerlogue/web/commit/6405175dbdc67c7799de8ebf519a356ba3e2d25f) Merge pull request #819 from jasonlewis/patch-11
- [`81efdcf`](https://github.com/gamerlogue/web/commit/81efdcf1578724f24ab1c663b3124e02cb208112) Merge pull request #776 from JesseObrien/develop
- [`a203a12`](https://github.com/gamerlogue/web/commit/a203a12da476389ad54996c21ad77fac00801b86) Merge pull request #799 from Jelle-S/develop
- [`3fcb3aa`](https://github.com/gamerlogue/web/commit/3fcb3aac6c040f1dc68592c391df12577228907c) Merge pull request #775 from franzliedke/patch-9
- [`1b06249`](https://github.com/gamerlogue/web/commit/1b062499dd270be9db5da46ce31fac9e18b52d67) Merge pull request #774 from franzliedke/patch-8
- [`5a1c1bf`](https://github.com/gamerlogue/web/commit/5a1c1bf82ce1ac4b6284cd6631c86ac46d996602) Merge pull request #801 from dlabs88/patch-1
- [`24bbd66`](https://github.com/gamerlogue/web/commit/24bbd66273f4e89d7958e9e6bc0d9b8a2cc39954) Merge pull request #838 from SonicHedgehog/master
- [`6e28d0b`](https://github.com/gamerlogue/web/commit/6e28d0bf2caf859235599bc75b4f4ff600ef37df) Merge pull request #812 from stefanneubig/patch-2
- [`567b728`](https://github.com/gamerlogue/web/commit/567b728666d7722c4df7b4d033a7f5fdb2892e20) Merge pull request #845 from tobsn/patch-5
- [`6415f1d`](https://github.com/gamerlogue/web/commit/6415f1d2acd755cd8a42eb0ee78158c1a138d98f) Merge pull request #846 from tobsn/patch-6
- [`9296d08`](https://github.com/gamerlogue/web/commit/9296d08ec5ba71ceaa0deb1b4ae4d7aee5b11c0d) Merge pull request #825 from tobsn/patch-2
- [`0ebeb14`](https://github.com/gamerlogue/web/commit/0ebeb14b67a728d4003747ba6572b1f14b7ad922) Merge pull request #849 from franzliedke/patch-12
- [`a018608`](https://github.com/gamerlogue/web/commit/a018608569390af00c1b43050ff47400dc6fc3e9) Merge pull request #857 from noor/develop
- [`b8c4af1`](https://github.com/gamerlogue/web/commit/b8c4af1cd81bd50ef1eb1c333eef7529e22a3937) Merge pull request #852 from JeffreyWay/patch-1
- [`1f93039`](https://github.com/gamerlogue/web/commit/1f93039ba757e54e12113b396617e800f7a8246e) Merge pull request #873 from dlpetrie/master
- [`2d4fa72`](https://github.com/gamerlogue/web/commit/2d4fa7217a15bead66d87f2ec8ab9581a8c44e08) Merge pull request #867 from niallobrien/develop
- [`603e349`](https://github.com/gamerlogue/web/commit/603e349de9065dfeb5fe4f1c5260a402773950c8) Merge pull request #878 from TommyC81/develop
- [`3ba5c00`](https://github.com/gamerlogue/web/commit/3ba5c00e5f9b82b97a012e4a12df97ba6660567f) Merge pull request #881 from TommyC81/develop
- [`5c44cf9`](https://github.com/gamerlogue/web/commit/5c44cf98cdd61e9a2651bb5e6a8950e91d3eada1) Merge pull request #879 from franzliedke/patch-17
- [`dcf1966`](https://github.com/gamerlogue/web/commit/dcf1966c288bbba9021dd804163f94fbc8449ac1) Merge pull request #910 from franzliedke/patch-20
- [`a9d27ba`](https://github.com/gamerlogue/web/commit/a9d27ba79c4242ccbe786efc9fc5beab6d3d0cf2) Merge pull request #902 from JesseObrien/feature/eloquent-update-timestamp
- [`e6ff7ba`](https://github.com/gamerlogue/web/commit/e6ff7ba336cf0bdaafca520609bb0b91ce3f4d73) Merge pull request #901 from franzliedke/patch-18
- [`0556d8e`](https://github.com/gamerlogue/web/commit/0556d8e3f0576e044ea3fba75df4ed2f7778c462) Merge pull request #899 from RoumenMe/develop
- [`06154ab`](https://github.com/gamerlogue/web/commit/06154abe8d1ff012a71f1614904a84dd1ee3630c) Merge pull request #895 from TomorrowToday/develop
- [`90447e7`](https://github.com/gamerlogue/web/commit/90447e7183e7b5242be609e467fa45da9a164773) Merge pull request #892 from jasonlewis/bug/database/select
- [`12bc7f1`](https://github.com/gamerlogue/web/commit/12bc7f1ee0435a78acbd05ac19e55089c9c96f5b) Merge pull request #889 from Nirlah/develop
- [`03ad47e`](https://github.com/gamerlogue/web/commit/03ad47e2df507b260ad93ca9e6d1206f0fb31c0b) Merge pull request #880 from tomasz-tomczyk/feature/polish-translation
- [`f338db5`](https://github.com/gamerlogue/web/commit/f338db50db45cf0cc133344ce551a675295d41b4) Merge pull request #888 from TommyC81/patch-3
- [`69e1ea9`](https://github.com/gamerlogue/web/commit/69e1ea939d4ca4d904896f3ac31d906ca7fe7c31) Merge pull request #868 from lucadegasperi/bug/phpunit
- [`8198dc2`](https://github.com/gamerlogue/web/commit/8198dc23f3d886f14eced5bceae418888c21bfad) Merge pull request #874 from franzliedke/patch-16
- [`4de2010`](https://github.com/gamerlogue/web/commit/4de201002d1127b0eb46d5a6cb1452a8be98193c) Merge pull request #862 from franzliedke/patch-15
- [`990f10f`](https://github.com/gamerlogue/web/commit/990f10f6de07140872bdfcb5efe9f0b3c291f24c) Merge pull request #854 from jasonlewis/feature/pattern-filters
- [`430eeb6`](https://github.com/gamerlogue/web/commit/430eeb6da1d8d087d3a7c21bfc83f20876c8b987) Merge pull request #798 from xsbeats/feature/validation_required_with
- [`845023f`](https://github.com/gamerlogue/web/commit/845023fc80e9b0dc6c29d18bf592e2b5bd38c165) Merge pull request #847 from tobsn/patch-1
- [`0171cf8`](https://github.com/gamerlogue/web/commit/0171cf8e91ed5b312029825dda827f49faeacd17) Merge pull request #905 from franzliedke/patch-19
- [`6e9efb4`](https://github.com/gamerlogue/web/commit/6e9efb464d9e6e80c9f776d65304924ba437641e) Merge pull request #903 from Lapayo/master
- [`3e9161d`](https://github.com/gamerlogue/web/commit/3e9161d6e57f180da11991630c88c19af9495333) Merge pull request #948 from loic-sharma/patch-5
- [`a87615d`](https://github.com/gamerlogue/web/commit/a87615da45814f4d61b47f8d6b62dc9345bea1bc) Merge pull request #971 from franzliedke/patch-27
- [`a73a6fb`](https://github.com/gamerlogue/web/commit/a73a6fb6c419e2888c40bb6427bc985349c91266) Merge pull request #970 from franzliedke/patch-26
- [`c6e4a25`](https://github.com/gamerlogue/web/commit/c6e4a25ae9540a177fc8ca02c524f48c556ee00e) Merge pull request #966 from racklin/develop
- [`680407f`](https://github.com/gamerlogue/web/commit/680407f051f90732b5535673e08a7b4ca1d97438) Merge pull request #959 from franzliedke/patch-25
- [`ec41836`](https://github.com/gamerlogue/web/commit/ec41836241cc56068646255336305ba2e54ee5f1) Merge pull request #938 from Anahkiasen/develop
- [`03d2236`](https://github.com/gamerlogue/web/commit/03d22362ecd76b1508e57bbc14888e26905f47d3) Merge pull request #978 from racklin/pgsql-schema
- [`527e291`](https://github.com/gamerlogue/web/commit/527e291f1462c875df4a006fd29adf28b994bb3b) Merge pull request #976 from Jakobud/bug/docs-bundle
- [`cd9a745`](https://github.com/gamerlogue/web/commit/cd9a745cb560ab6b65f0e6ce9a342594818ddce7) Merge pull request #972 from franzliedke/patch-28
- [`c937f98`](https://github.com/gamerlogue/web/commit/c937f98b497b18029cfd1747510f9b39c86b2027) Merge pull request #932 from JeffreyWay/feature/auth_attempt_extend
- [`38234c6`](https://github.com/gamerlogue/web/commit/38234c61dd5a2777ca962130b64ade7f0933a7c8) Merge pull request #480 from cviebrock/schema-rename
- [`1db67d4`](https://github.com/gamerlogue/web/commit/1db67d47a3ffb40ea7e51fdd38a2f9209094b1c7) Merge pull request #947 from franzliedke/patch-24
- [`b194d83`](https://github.com/gamerlogue/web/commit/b194d8372dbf03a827a314e1e3099e579e2e1657) Merge pull request #987 from robmeijer/develop
- [`764e7bc`](https://github.com/gamerlogue/web/commit/764e7bc630f3469e58f00380918a66096b486aff) Merge pull request #983 from racklin/bugfix/memcached
- [`5c3ede7`](https://github.com/gamerlogue/web/commit/5c3ede74d990afcbc4b113610a8f258892b05544) Merge pull request #946 from franzliedke/patch-23
- [`5299e32`](https://github.com/gamerlogue/web/commit/5299e32aee5a27a8e8f8c4b4ee06874ff7b40175) Merge pull request #1011 from Jakobud/feature/templating-docs
- [`3b09f99`](https://github.com/gamerlogue/web/commit/3b09f99f9e48ee798f97711f06cc84f9a888ac6a) Merge pull request #989 from dprvig/develop
- [`f7e7fa6`](https://github.com/gamerlogue/web/commit/f7e7fa629939d2c8d902c807abcb86e6e9b44907) Merge pull request #995 from cviebrock/eloquent-delete-doc
- [`c27614b`](https://github.com/gamerlogue/web/commit/c27614b2173f31a2c6184c8f77277725f25d8a93) Merge pull request #996 from Jakobud/feature/pagination-docs
- [`0bc38ff`](https://github.com/gamerlogue/web/commit/0bc38ff2a89a789b425dc42cc680be712a438384) Merge pull request #1009 from apit/lang-id
- [`da35e25`](https://github.com/gamerlogue/web/commit/da35e257fd5789a242a56cbcd5d0ad5299c02931) Merge pull request #898 from franzliedke/patch-13
- [`6d193c2`](https://github.com/gamerlogue/web/commit/6d193c29e1cfaa0acb358baf2894663ff439a467) Merge pull request #1017 from Spir/develop
- [`25a69cf`](https://github.com/gamerlogue/web/commit/25a69cf9f359cde5411498fed10a17ca40872351) Merge pull request #1018 from noherczeg/feature/language/hu
- [`7b1b76b`](https://github.com/gamerlogue/web/commit/7b1b76bb02ad1b391fcd15bacfbde4414e4f6b9c) Merge pull request #1021 from benjaminreede/feature/language/nl
- [`c971052`](https://github.com/gamerlogue/web/commit/c9710525d923817b93333086f6cd0585622d6c12) Merge pull request #1020 from metaphox/develop
- [`8c5ac60`](https://github.com/gamerlogue/web/commit/8c5ac6015414bf891e8433a6ac3d32c4cdeb8803) Merge pull request #935 from tobsn/patch-7
- [`37e5605`](https://github.com/gamerlogue/web/commit/37e5605c222664530e0bb57f5b28c4cbb4217143) Merge pull request #1036 from tobsn/patch-8
- [`3d66011`](https://github.com/gamerlogue/web/commit/3d660112496f7bac5ccba78dbad0ad315a507d11) Merge pull request #1037 from tobsn/patch-9
- [`184cc09`](https://github.com/gamerlogue/web/commit/184cc090bc76b32c0c212de11fdcbaed02227e07) Merge pull request #1026 from jbruni/patch-1
- [`4b97c28`](https://github.com/gamerlogue/web/commit/4b97c28c6b759bd97b4e62362ccd4c60a51ab53d) Merge pull request #860 from stevefrost/develop
- [`483f570`](https://github.com/gamerlogue/web/commit/483f5705a9f92a7719caf22ac1c1a8225c2f74af) Merge pull request #990 from resurtm/html-indentation-fix
- [`f969776`](https://github.com/gamerlogue/web/commit/f96977631241cbc3fe1093e2c4d96a0079586e14) Merge pull request #944 from dlabsnl/master
- [`01f8323`](https://github.com/gamerlogue/web/commit/01f83234208b9116b45b292e2b8ff2e174454449) Merge pull request #945 from cviebrock/html-link
- [`a0fd22f`](https://github.com/gamerlogue/web/commit/a0fd22f6f1c4f00d1aaf7968b28d2fb7c7262acb) Merge pull request #772 from loic-sharma/patch-3
- [`dab2c79`](https://github.com/gamerlogue/web/commit/dab2c79298dfe30941cb7280051fcda758e296e5) Merge pull request #933 from franzliedke/patch-22
- [`06ac327`](https://github.com/gamerlogue/web/commit/06ac3274e5a82c87e00d064d90fc78209732d4f6) Merge pull request #917 from HiroKws/japanese-language
- [`7256dc2`](https://github.com/gamerlogue/web/commit/7256dc2a65b31f2b735aa3f99ca946d87d7a6e01) Merge pull request #1024 from Apathetic012/develop
- [`bc34498`](https://github.com/gamerlogue/web/commit/bc34498a7c5f53f026ac7358005756e2d8ac7ff6) Merge pull request #1045 from franzliedke/patch-29
- [`86b0ac0`](https://github.com/gamerlogue/web/commit/86b0ac0dff18f0875ead95cd91843b2931029acd) Merge pull request #1064 from jwpage/bug/fix_index_path
- [`f5123f9`](https://github.com/gamerlogue/web/commit/f5123f935a308d6b865a4765a7d5792ad4909ad6) Merge pull request #1052 from sergiigrebeniuk/hotfix-phpdoc
- [`ebec6ba`](https://github.com/gamerlogue/web/commit/ebec6ba8e01a9dbb20336c6578cbe610ad412aa4) Merge pull request #1077 from aebersold/master
- [`b5e81cb`](https://github.com/gamerlogue/web/commit/b5e81cb33ccda07e754cca057651da4b29915ae4) Merge pull request #1083 from spencerdeinum/master
- [`29a4ac2`](https://github.com/gamerlogue/web/commit/29a4ac270132b7c966cf915e3b021b532ac3b2f7) Merge pull request #1049 from Apathetic012/develop
- [`4d25f50`](https://github.com/gamerlogue/web/commit/4d25f50f4ba91c68ce3c10bba465af56db498fb3) Merge pull request #1016 from purwandi/develop
- [`64605f2`](https://github.com/gamerlogue/web/commit/64605f2223543e8b71be7b116e3695104c63b1fa) Merge pull request #706 from Vespakoen/patch-1
- [`722de55`](https://github.com/gamerlogue/web/commit/722de55eebf4872f617e1a250032efc138d7bfee) Merge pull request #1105 from spencerdeinum/master
- [`694f696`](https://github.com/gamerlogue/web/commit/694f696cb6ddd9355f8a9908e88638e55dbaa59b) Merge pull request #1063 from stayallive/develop
- [`4d0f955`](https://github.com/gamerlogue/web/commit/4d0f95598c82043732c2ab8a1284b62b2919643b) Merge pull request #1079 from sineld/develop
- [`a28698e`](https://github.com/gamerlogue/web/commit/a28698ed367b0ad38516bb4d238b94cbd452469a) Merge pull request #1 from crynobone/core-tests
- [`4b8ba99`](https://github.com/gamerlogue/web/commit/4b8ba99211f8c8714980f61835b3c33cca70d96c) Merge pull request #1043 from tobsn/patch-10
- [`a7c2c25`](https://github.com/gamerlogue/web/commit/a7c2c2544eda52342c77fa158554826843f587f7) Merge pull request #1053 from tobsn/patch-12
- [`fdac5e8`](https://github.com/gamerlogue/web/commit/fdac5e843f49cf7d82206fc46c7bffb47e1fc538) Merge pull request #636 from ProgerXP/patch-bexpand
- [`feb651f`](https://github.com/gamerlogue/web/commit/feb651f6307c8d76d8b9e2b8640423a9fd52db93) Merge pull request #670 from kbanman/hmvc-fix
- [`8dbe2d1`](https://github.com/gamerlogue/web/commit/8dbe2d1a9a16ab59a8163ae4d25a4c212e2632eb) Merge pull request #681 from bencorlett/develop
- [`833cf12`](https://github.com/gamerlogue/web/commit/833cf12ce3b212a061b87db4c79be3be94df107f) Merge pull request #1119 from thomiweb/master
- [`7fa54c2`](https://github.com/gamerlogue/web/commit/7fa54c2ed9a5c4859f2e87808e3adbfcb375c916) Merge pull request #1100 from franzliedke/patch-36
- [`dd01308`](https://github.com/gamerlogue/web/commit/dd013083151343074f428d565744e6dd66eb4bdd) Merge pull request #1098 from franzliedke/patch-35
- [`7298c93`](https://github.com/gamerlogue/web/commit/7298c93be106700656fe2945f282c4e2cfa31ef9) Merge pull request #1109 from JesseObrien/feature/profiler-timers
- [`f31c6dc`](https://github.com/gamerlogue/web/commit/f31c6dc3135d3669b4112d2c22e04b4929d7c822) Merge pull request #1127 from tobsn/patch-13
- [`84bf7d6`](https://github.com/gamerlogue/web/commit/84bf7d662a849097b9fe617e06333c9e5ee15f31) Merge pull request #1128 from tobsn/patch-14
- [`b86b8ff`](https://github.com/gamerlogue/web/commit/b86b8ffed12a2b5dfcdf6444e2a7e3eea9a7cbc1) Merge pull request #1113 from HiroKws/markdown-fix/doc-change
- [`c7679ba`](https://github.com/gamerlogue/web/commit/c7679bafe047627abfdb661f10287292cf335dce) Merge pull request #770 from abigwonderful/develop
- [`8f8fa09`](https://github.com/gamerlogue/web/commit/8f8fa097084866e67e3dc036befb4e11df7c5406) Merge pull request #811 from xsbeats/feature/str_limit_exact
- [`46f68ab`](https://github.com/gamerlogue/web/commit/46f68ab78c103a4cb50b2f16a3ef34406719e93a) Merge pull request #813 from anaxamaxan/patch-3
- [`5b14091`](https://github.com/gamerlogue/web/commit/5b14091e3f18eba890e53b1949ae0c530acf5d72) Merge pull request #858 from franzliedke/patch-14
- [`8e8ef86`](https://github.com/gamerlogue/web/commit/8e8ef861b65bc78a1822cd18777baab0c1b9a9d2) Merge pull request #1013 from Jakobud/bug/artisan-task-route
- [`0a908ef`](https://github.com/gamerlogue/web/commit/0a908eff8df84f4a7ebe7fe8f4fbf2ac69d32a9c) Merge pull request #1014 from jasonlewis/feature/root-bundles
- [`22962fc`](https://github.com/gamerlogue/web/commit/22962fce4a8464cfdb8a1a9e16848c02c9c30491) Merge pull request #1041 from Jakobud/feature/docs/templating
- [`017c65c`](https://github.com/gamerlogue/web/commit/017c65c0bc6235a23076acb4cf56fc6ac9bdcabd) Merge pull request #1056 from Jakobud/bug/form/buttons/defaultValues
- [`4a60981`](https://github.com/gamerlogue/web/commit/4a60981582cdfcd2a8d9776edc0412223be4267f) Merge pull request #1084 from joecwallace/pivot_fix
- [`4db0808`](https://github.com/gamerlogue/web/commit/4db08087f773ef5a7a4adce63cc02df483499e70) Merge pull request #1089 from kbanman/fix-query-lists
- [`175683f`](https://github.com/gamerlogue/web/commit/175683f9cc43194bdae1fb995d26788bae3dc080) Merge pull request #1092 from franzliedke/patch-34
- [`b3319f5`](https://github.com/gamerlogue/web/commit/b3319f5d36f1397650771d9a32b1dabd56ab9030) Merge pull request #1051 from franzliedke/patch-30
- [`5e11cb9`](https://github.com/gamerlogue/web/commit/5e11cb91ed506fbb908c4c78e05d6067f61a3d52) Merge pull request #1112 from HiroKws/fix-markdown/git-docs
- [`c974052`](https://github.com/gamerlogue/web/commit/c974052c13e5fdfdb16ff900818c102983692c4f) Merge pull request #1115 from HiroKws/delete-top-anchor/doc-session.config
- [`db48fa4`](https://github.com/gamerlogue/web/commit/db48fa4140d1e68814944d13ed98230b9b565368) Merge pull request #1121 from mcintyre94/minor/unprotect-eloquent-timestamps
- [`852b10e`](https://github.com/gamerlogue/web/commit/852b10e836dcdf6992eeab6187b3a5b76c4a7b0c) Merge pull request #1143 from franzliedke/patch-38
- [`b061b9b`](https://github.com/gamerlogue/web/commit/b061b9b21c6e7fc4c2a810de44e36f11fc873045) Merge pull request #1150 from franzliedke/patch-40
- [`c17c872`](https://github.com/gamerlogue/web/commit/c17c872b6a8961f7c6056917f085dc265ef3a64c) Merge pull request #1123 from daris/patch-1
- [`50b10fc`](https://github.com/gamerlogue/web/commit/50b10fca95e46730e15b81cdb80c5d43ce98096f) Merge pull request #1132 from cmenke/master
- [`1b475d8`](https://github.com/gamerlogue/web/commit/1b475d8f9c90c2f4345fb16d2cc390184f972ed1) Merge pull request #1142 from HendrikJan/master
- [`a121e8f`](https://github.com/gamerlogue/web/commit/a121e8f52078ed0c320c068835882517c3189ebe) Merge pull request #1196 from freezestart/master
- [`8fea602`](https://github.com/gamerlogue/web/commit/8fea6029692d2099a790896d91c181000d147460) Merge pull request #1222 from dcelasun/patch-1
- [`ec13efb`](https://github.com/gamerlogue/web/commit/ec13efb743157e9b8116bc51261fb249bd476c0e) Merge pull request #1164 from lollypopgr/grlang
- [`2b1d8e6`](https://github.com/gamerlogue/web/commit/2b1d8e6c834f447ab66a8d0a3a555277da1ad833) Merge pull request #1179 from lollypopgr/ellang
- [`96f428f`](https://github.com/gamerlogue/web/commit/96f428f83c88ea06163a729f3803a579e8de969b) Merge pull request #1186 from akuzemchak/feature/json
- [`1c12813`](https://github.com/gamerlogue/web/commit/1c1281318ce82a9c8f946c9f8e68f3482170edec) Merge pull request #1166 from RoumenMe/translation
- [`56f665b`](https://github.com/gamerlogue/web/commit/56f665bf6d46adc1ba3c0427b0c155231d8de266) Merge pull request #1193 from franzliedke/patch-43
- [`afbae10`](https://github.com/gamerlogue/web/commit/afbae103454d31928efe7645fee9107bb0bf1daa) Merge pull request #1175 from franzliedke/patch-42
- [`8004d48`](https://github.com/gamerlogue/web/commit/8004d48256bed763e3cdd9c60710399a3293c816) Merge pull request #1171 from flaviozantut/ptLang
- [`ca94296`](https://github.com/gamerlogue/web/commit/ca942963438570df67af5163365bdea67ab620af) Merge pull request #1197 from CreativityKills/bug/artisan-bundle-provider
- [`fab4fda`](https://github.com/gamerlogue/web/commit/fab4fda1f2897ea558d7b501d657f02230c23bc2) Merge pull request #1200 from bryantebeek/language/nl
- [`f004ddc`](https://github.com/gamerlogue/web/commit/f004ddcea741b09930ebedecaf1ac9c036529525) Merge pull request #1189 from kapv89/patch-5
- [`666db87`](https://github.com/gamerlogue/web/commit/666db87137b5393a6426ddbd26a72578bbef285b) Merge pull request #1169 from mcintyre94/minor/add-touch-eloquent
- [`a5bb035`](https://github.com/gamerlogue/web/commit/a5bb035e4c533d9c837ba4d05f5bc25a5a54b5dd) Merge pull request #1165 from JoostK/develop
- [`705cd6a`](https://github.com/gamerlogue/web/commit/705cd6a907ee72be362ec956406b7cb1627f8b84) Merge pull request #1203 from xsbeats/bugfix/pluralizer_uncountable
- [`38562d5`](https://github.com/gamerlogue/web/commit/38562d500770f0905ac09c7863f9e292391a1b48) Merge pull request #1160 from kapv89/patch-2
- [`b30ee48`](https://github.com/gamerlogue/web/commit/b30ee488d07ce72b22bfd40276164523c961a3ec) Merge pull request #1225 from decola977/patch-2
- [`4f7dd1c`](https://github.com/gamerlogue/web/commit/4f7dd1c8a4c73330e03541a5049ac1b2d48a270a) Merge pull request #1233 from franzliedke/patch-51
- [`99d710a`](https://github.com/gamerlogue/web/commit/99d710a8204f3d8b2f8d9ae09ebdc86ad5970d5d) Merge pull request #1242 from bstrahija/patch-1
- [`0dc124d`](https://github.com/gamerlogue/web/commit/0dc124d342a57f2e4548b733d6c17f96f69fa1d6) Merge pull request #1210 from franzliedke/patch-44
- [`dad0bbc`](https://github.com/gamerlogue/web/commit/dad0bbc688a0a0e03043a6db301893a65e8f9b38) Merge pull request #1247 from dcelasun/patch-1
- [`439f9c8`](https://github.com/gamerlogue/web/commit/439f9c805570cc2b63b08e7b09a90cd60b1f9dfa) Merge pull request #1236 from kuroi/patch-1
- [`5a1741e`](https://github.com/gamerlogue/web/commit/5a1741e9d5a790275a1ce902029ec4c9b8e3aff4) Merge pull request #1276 from rk/rk-issue-1261
- [`9acf541`](https://github.com/gamerlogue/web/commit/9acf541653beb7f4ee2226a3bfd577a0c93f3616) Merge pull request #1255 from joual/develop
- [`4b7dc2e`](https://github.com/gamerlogue/web/commit/4b7dc2e824b0d77fdc6ff3569665b1c952e775e6) Merge pull request #1226 from akuzemchak/bug/language-routes
- [`fc9b0e1`](https://github.com/gamerlogue/web/commit/fc9b0e163619355313571ea3bfc2516fd0d66028) Merge pull request #1201 from JoostK/fix-1
- [`0950081`](https://github.com/gamerlogue/web/commit/09500818e0a03f1131cc2d78a5abf2bb44916b65) Merge pull request #1204 from bryantebeek/optimisation/str-class
- [`4f8a672`](https://github.com/gamerlogue/web/commit/4f8a6724b083eb24236817fe46320c6024137ea9) Merge pull request #1305 from nmalcolm/develop
- [`8faf38e`](https://github.com/gamerlogue/web/commit/8faf38efe1208d2daa1e9fa89c5ce3515a775233) Merge pull request #1314 from vFragosop/eloquent/relationship_performance
- [`7555fda`](https://github.com/gamerlogue/web/commit/7555fda58918d847292560efde137e6fa420ec7b) Merge pull request #1307 from tillsanders/develop
- [`790a540`](https://github.com/gamerlogue/web/commit/790a540620355e119393e6de0de57fc34c3b5e81) Merge pull request #1294 from danielboendergaard/phpdoc-fix
- [`1df8fa9`](https://github.com/gamerlogue/web/commit/1df8fa91fc04b39c4a03926ebe5c834275d142fb) Merge pull request #1322 from vFragosop/eloquent/relationship_performance
- [`d55328c`](https://github.com/gamerlogue/web/commit/d55328cc5263bbd46834699172b72bd4ffaaff7b) Merge pull request #1320 from dejangeci/feature/dbexception-inner
- [`301c61f`](https://github.com/gamerlogue/web/commit/301c61fb1a49824f84c3b4e0286dad85680d024f) Merge pull request #1370 from gkunno/lang/fi
- [`aa902de`](https://github.com/gamerlogue/web/commit/aa902def30d7c885763c6ebed10e77d16dc4fde6) Merge pull request #1367 from vFragosop/language/pt/consistence
- [`73d4b0b`](https://github.com/gamerlogue/web/commit/73d4b0b2a1782268a67f7bfb51c844ef24b666f9) Merge pull request #1363 from franzliedke/patch-55
- [`1a7f2bf`](https://github.com/gamerlogue/web/commit/1a7f2bf27fbc50d000c98c12af98d633ec7320c9) Merge pull request #1352 from laravie/patch/code-standard
- [`d164cca`](https://github.com/gamerlogue/web/commit/d164cca4aad42368ee93c8d4d1809fd52c75ff81) Merge pull request #1211 from franzliedke/patch-45
- [`acbffce`](https://github.com/gamerlogue/web/commit/acbffcec508d6b656e86af21dc717ae58606ed4d) Merge pull request #1321 from dejangeci/feature/serbian-translation
- [`5e3a8de`](https://github.com/gamerlogue/web/commit/5e3a8de1ba19583260dd3ff3e0cfe9de2926e594) Merge pull request #1384 from machuga/patch-1
- [`2914471`](https://github.com/gamerlogue/web/commit/2914471de123c1de8af7fedd862123f031f32bb9) Merge pull request #1381 from vFragosop/documentation/improvements
- [`ca44c93`](https://github.com/gamerlogue/web/commit/ca44c93ca40e73c27a4c71d0e0453b9a3d0155b8) Merge pull request #1375 from christianzt19/develop
- [`0a0eb37`](https://github.com/gamerlogue/web/commit/0a0eb3779c663b152201140a9125c8120a204677) Merge pull request #1365 from sdbondi/develop
- [`205cc48`](https://github.com/gamerlogue/web/commit/205cc4869dbe314cab6e3c9fa4f1588ca6f2828a) Merge pull request #1356 from helmut/patch-1
- [`4d0bc9e`](https://github.com/gamerlogue/web/commit/4d0bc9e251d8a615c3358d9f5595eece53b81ec3) Merge pull request #1389 from Anahkiasen/feature/migrate_rebuild
- [`e842095`](https://github.com/gamerlogue/web/commit/e842095fa7d0262f13a2956d334e5c676528786e) Merge pull request #1351 from everclear/patch-1
- [`e531cd6`](https://github.com/gamerlogue/web/commit/e531cd6300ef6d393185643a850dec866a9f3e28) Merge pull request #1348 from matz3/master
- [`37cd08f`](https://github.com/gamerlogue/web/commit/37cd08faea8f3e0d970d39ad90c0c35b9ef814b5) Merge pull request #1357 from aebersold/master
- [`115f59b`](https://github.com/gamerlogue/web/commit/115f59b4ff0b078ab5e6128436b606d1fb428eb5) Merge pull request #1392 from mynameiszanders/patch-1
- [`d693a82`](https://github.com/gamerlogue/web/commit/d693a82615bf7f2859eda64653e0045bb288ddd4) Merge pull request #1408 from cartalyst/develop
- [`5059ced`](https://github.com/gamerlogue/web/commit/5059ced2e1ac11d81d898f14244eed05563a38e9) Merge pull request #1413 from machuga/develop
- [`1ddb4bb`](https://github.com/gamerlogue/web/commit/1ddb4bb6cd4b3fcf2ea9df43aa2d943d1d33a470) Merge pull request #1419 from laravie/feature/blade-testcase
- [`d20add8`](https://github.com/gamerlogue/web/commit/d20add8f75bd08fad6ea95974fd0853bca1e780b) Merge pull request #1422 from laravie/feature/form-testcase
- [`49b2d4a`](https://github.com/gamerlogue/web/commit/49b2d4ab1a9746fb6868ebfc526ca8165de35780) Merge pull request #1423 from laravie/feature/html-testcase
- [`d1efd44`](https://github.com/gamerlogue/web/commit/d1efd44c7c7209b0cc29ad8e964c1a24c829702a) Merge pull request #1467 from franzliedke/patch-60
- [`cac58db`](https://github.com/gamerlogue/web/commit/cac58db390b0418b282a89fec8aec61840ee156e) Merge pull request #1438 from dejangeci/fix/dns-speedup
- [`6ae889e`](https://github.com/gamerlogue/web/commit/6ae889e5b80b76bf657019fe1547cccda532b7cb) Merge pull request #1472 from franzliedke/patch-61
- [`f7d8241`](https://github.com/gamerlogue/web/commit/f7d82412fae3406282647951fb8b907062775595) Merge pull request #1451 from Chrty/master
- [`6140089`](https://github.com/gamerlogue/web/commit/6140089eb3fb9d096ce05ac44af6d74fdebcf511) Merge pull request #1480 from flakerimi/develop
- [`8ff052c`](https://github.com/gamerlogue/web/commit/8ff052cbdb3bed5cf7fbbb4c26a31fe6b224b0d6) Merge pull request #1180 from unikent/master
- [`ca9c3b7`](https://github.com/gamerlogue/web/commit/ca9c3b72b2deaef5aa47f7f3284ce89a53d3cdcc) Merge pull request #1481 from maxdmyers/patch-1
- [`f25d09d`](https://github.com/gamerlogue/web/commit/f25d09dd07d1241400f5a55bc7c9b8a2a68e75ac) Merge pull request #1492 from adamjacobbecker/patch-1
- [`d5d6d28`](https://github.com/gamerlogue/web/commit/d5d6d2856a5f4fbba9959406833ee7af880e3390) Merge pull request #1563 from JesseObrien/docs/profiler
- [`fd12897`](https://github.com/gamerlogue/web/commit/fd1289760f98ffea350dda88f6b0681cbf243b6e) Merge pull request #1560 from DServy/master
- [`5a89836`](https://github.com/gamerlogue/web/commit/5a89836f5d41d1a19ca33911ffeba45188c557f1) Merge pull request #1561 from danro/develop
- [`bdb5941`](https://github.com/gamerlogue/web/commit/bdb5941af26fb1d1c22e3234a15bb0ac3b8f888f) Merge pull request #1558 from deerawan/update-id-translation
- [`0993552`](https://github.com/gamerlogue/web/commit/0993552c0af21d356341184cee2a4c6a9bf12085) Merge pull request #1554 from theideapeople/patch/doc-rule-arrays
- [`ab15220`](https://github.com/gamerlogue/web/commit/ab152200e9e990ae815165d4cc2303086779321e) Merge pull request #1545 from bryanwood/master
- [`419367f`](https://github.com/gamerlogue/web/commit/419367f0a7fef7a732b0807dafe6b5b9b89ec76a) Merge pull request #1536 from xsbeats/required_with_validation_message
- [`082fc0b`](https://github.com/gamerlogue/web/commit/082fc0b39bf92031a48efa6bd296bcce6c22da25) Merge pull request #1533 from JoostK/relationship-with
- [`eb5d68f`](https://github.com/gamerlogue/web/commit/eb5d68f20104b9faa446b444c1ecc0a702db5c2c) Merge pull request #1531 from jasonlewis/eloquent/bug/find
- [`6a69979`](https://github.com/gamerlogue/web/commit/6a6997937664b2112c60e5682a755a3c1123ad97) Merge pull request #1526 from TheShiftExchange/blade_e
- [`c74118d`](https://github.com/gamerlogue/web/commit/c74118decbbc3022a2140ed7818ab0ab19c6c42a) Merge pull request #1510 from lollypopgr/develop
- [`e0dfd7c`](https://github.com/gamerlogue/web/commit/e0dfd7c5d39674aefa72b56e669fcd052d67c755) Merge pull request #1502 from olivervogel/develop
- [`8541ff5`](https://github.com/gamerlogue/web/commit/8541ff50ab99d5e0912301314767067f7591fe01) Merge pull request #1497 from bencorlett/patch-2
- [`22c2c38`](https://github.com/gamerlogue/web/commit/22c2c3843afca40e8d6d4ea3c4add2465b300e1d) Merge pull request #1485 from laravie/feature/auth-events
- [`277f1c6`](https://github.com/gamerlogue/web/commit/277f1c620b168f848348664d65940b5c84997ca1) Merge pull request #1483 from josem/develop
- [`3bbc809`](https://github.com/gamerlogue/web/commit/3bbc809c12551cfae6978acca6175ab5fe25bcdb) Merge pull request #1479 from Ore4444/patch-1
- [`b69e649`](https://github.com/gamerlogue/web/commit/b69e649a7fabd5a7de9f64d2d20406ec949727f8) Merge pull request #1539 from williamn/patch-1
- [`f8dbe4c`](https://github.com/gamerlogue/web/commit/f8dbe4cddd8c642bf26748463a8b13de79dde749) Merge pull request #1530 from tempestim/master
- [`14179c8`](https://github.com/gamerlogue/web/commit/14179c88111eeb3b2e4afaf5f262d191a936466f) Merge pull request #1520 from JorgeMurta/master
- [`731cec2`](https://github.com/gamerlogue/web/commit/731cec2475e15545e950b1efffb7580057380a76) Merge pull request #1465 from ethaizone/patch-1
- [`22107fe`](https://github.com/gamerlogue/web/commit/22107fe9447aedc451ff5342ee3f15dd79a5ac2e) Merge pull request #1461 from AustinW/master
- [`e5341ef`](https://github.com/gamerlogue/web/commit/e5341ef59e2c0a60658a564040dabdb989e238f8) Merge pull request #1458 from anaxamaxan/patch-2
- [`f0dbc07`](https://github.com/gamerlogue/web/commit/f0dbc0710153121c5e65fd04cd8161e516618c79) Merge pull request #1568 from franzliedke/patch-62
- [`19d56d5`](https://github.com/gamerlogue/web/commit/19d56d57c9837bfeb63ce3d74ca7c13b16bab0fd) Merge pull request #1450 from netputer/master
- [`e8cd58a`](https://github.com/gamerlogue/web/commit/e8cd58a9bc3c908f50ee27024846a7395c9e2436) Merge pull request #1444 from eddmann/bug/database-connector
- [`10b8732`](https://github.com/gamerlogue/web/commit/10b8732583194dd20f55d43b8a0247df5cb9109d) Merge pull request #1434 from franzliedke/patch-59
- [`f785cb2`](https://github.com/gamerlogue/web/commit/f785cb22c9da681b1a0a2baf1634ebbde8ce606a) Merge pull request #1428 from dejangeci/feature/dbtransaction-return
- [`e1d081b`](https://github.com/gamerlogue/web/commit/e1d081bd54b766320ad98c42f21dd59b9f59055f) Merge pull request #1501 from JesseObrien/master
- [`0726fb8`](https://github.com/gamerlogue/web/commit/0726fb8e847c8dea6b195b5392d80b22901baf75) Merge pull request #1415 from j20/patch-1
- [`b5e5494`](https://github.com/gamerlogue/web/commit/b5e5494144181e00da96b1e9cd81f62a88b477ac) Merge pull request #1410 from franzliedke/patch-56
- [`c463d2a`](https://github.com/gamerlogue/web/commit/c463d2a4ab09c55a1e634481cb2b0dd5b155e197) Merge pull request #1400 from sdbondi/develop
- [`829fa4e`](https://github.com/gamerlogue/web/commit/829fa4edd81975ddbb72581ebe94ce8873b205a1) Merge pull request #1399 from HiroKws/correct/document/html
- [`358e8ab`](https://github.com/gamerlogue/web/commit/358e8abde6f68776d792fa4ac15ad89967f3940a) Merge pull request #1390 from Anahkiasen/feature/url_language
- [`f156287`](https://github.com/gamerlogue/web/commit/f1562875af2f34aa85c52e15b33825c590502167) Merge pull request #1388 from tzan/improve-french
- [`6a68734`](https://github.com/gamerlogue/web/commit/6a6873440e0f20972b1d94bbd7de9956b300045f) Merge pull request #1354 from BlaineSch/develop
- [`d089046`](https://github.com/gamerlogue/web/commit/d08904616093f981fbf60ce33410ab45c94ea3a0) Merge pull request #1312 from franzliedke/patch-53
- [`f7d0b43`](https://github.com/gamerlogue/web/commit/f7d0b437c3545f8424ce8bb089b994b4c74fe432) Merge pull request #1278 from Jakobud/feature/doc/strings
- [`b8ed806`](https://github.com/gamerlogue/web/commit/b8ed80608f23e42fec61fcca0571331f7b9fc883) Merge pull request #1275 from Sadeghi85/develop
- [`6c55f9c`](https://github.com/gamerlogue/web/commit/6c55f9cf54144dc7fc1264dd861007129269d645) Merge pull request #2 from laravel/develop
- [`a5c5d70`](https://github.com/gamerlogue/web/commit/a5c5d70bd646d9232e5d80d8d87cb75df69b0323) Merge pull request #5 from laravel/develop
- [`6a14705`](https://github.com/gamerlogue/web/commit/6a14705a63a344a164cfad94a4c11fd7b6d5ab4f) Merge pull request #8 from laravel/develop
- [`1824b0b`](https://github.com/gamerlogue/web/commit/1824b0b21c910733574b9b9b59c4b75f8923a344) Merge pull request #1257 from vtalbot/develop
- [`c397c26`](https://github.com/gamerlogue/web/commit/c397c26a7b050c002e8f3b995b9360b53637f1b7) Merge pull request #1221 from arisk/patch-1
- [`cfc024f`](https://github.com/gamerlogue/web/commit/cfc024fe6609e85bbc9a51ce909fdb1266e1e32a) Merge pull request #1212 from franzliedke/patch-46
- [`13a1c5d`](https://github.com/gamerlogue/web/commit/13a1c5daac2ba33f46563dd4627edaae93280eb7) Merge pull request #1170 from kapv89/patch-4
- [`e7ae316`](https://github.com/gamerlogue/web/commit/e7ae316e44d6a0a6114d4d940292dcb600d71744) Merge pull request #1235 from ROMOPAT/patch-2
- [`05cb1ea`](https://github.com/gamerlogue/web/commit/05cb1ea5ad59aac772e17bfc5c4d917929f6258a) Merge pull request #1234 from ROMOPAT/patch-1
- [`5598238`](https://github.com/gamerlogue/web/commit/5598238fbc165e2f18ad36080c52c7bd7fdb9886) Merge pull request #1570 from HiroKws/ja/validation/new/translation
- [`dd54847`](https://github.com/gamerlogue/web/commit/dd548471bc7b63e0382fd47a667242e0d396c105) Merge pull request #1571 from vauteer/patch-1
- [`f754e1f`](https://github.com/gamerlogue/web/commit/f754e1fa55961bc379413d993d7768cb132159e0) Merge pull request #1574 from Barryvdh/patch-1
- [`ff682d6`](https://github.com/gamerlogue/web/commit/ff682d69c0645debbf6c2141fc212b2ed574a224) Merge pull request #1546 from darkimmortal/master
- [`2946274`](https://github.com/gamerlogue/web/commit/2946274a95e41fd1fca5af5e9f34b6747d0e5a26) Merge pull request #1473 from s4wny/patch-1
- [`ff7f6f6`](https://github.com/gamerlogue/web/commit/ff7f6f67db25aa5f3168da17622eed7ef827ba1c) Merge pull request #1573 from neoascetic/patch-1
- [`2e82761`](https://github.com/gamerlogue/web/commit/2e82761788fe8e4b3a24bc496a0069b2114842d0) Merge pull request #1582 from AndreasHeiberg/patch-1
- [`3b8d8bb`](https://github.com/gamerlogue/web/commit/3b8d8bbf779ad015e50510f1c5156c92dfd5c1ab) Merge pull request #1584 from bpierre/bug/doc-fixes
- [`bd11b2a`](https://github.com/gamerlogue/web/commit/bd11b2a8afe5b675dd005257fdb0d25cdb7c85e1) Merge pull request #1577 from inverse/develop
- [`d193986`](https://github.com/gamerlogue/web/commit/d19398614b92798d184c577a47b165e25b596a3c) Merge pull request #1628 from amigorich/typo-fix
- [`20a0edc`](https://github.com/gamerlogue/web/commit/20a0edcdde957e7d0f2e8b691c72a843bb2e2442) Merge pull request #1642 from alexwhitman/date-validation-messages
- [`4528981`](https://github.com/gamerlogue/web/commit/4528981e447420bc4ce26a883d11c880fc174006) Merge pull request #1687 from bencorlett/develop
- [`45f4de1`](https://github.com/gamerlogue/web/commit/45f4de147f5be276bf97755384cb965edb4803a6) Merge pull request #1721 from zackkitzmiller/patch-1
- [`3d5747c`](https://github.com/gamerlogue/web/commit/3d5747c282ab4bf7c9363e4f2174abd89ee47a5e) Merge pull request #1739 from Bering/regex-validation-message
- [`89e4c29`](https://github.com/gamerlogue/web/commit/89e4c29d63ce2d2caf8b00f20b1b976513754537) Merge pull request #1765 from driesvints/develop
- [`9a58a02`](https://github.com/gamerlogue/web/commit/9a58a02ee8e14b1b02fa160b57d0f5d903d5e5ca) Merge pull request #1800 from AndreiCanta/develop
- [`675157e`](https://github.com/gamerlogue/web/commit/675157ea24fd900c2a19b8e9b6ca628b00fa0287) Merge pull request #1738 from bencorlett/patch-1
- [`9b0fafe`](https://github.com/gamerlogue/web/commit/9b0fafe3d51db1e71347b2bfe5e2943d294553ae) Merge pull request #1716 from briankiewel/readme-typo
- [`b593b10`](https://github.com/gamerlogue/web/commit/b593b109f6ff194d6de1232c19d66dea4747e2cb) Merge pull request #1706 from billmn/develop
- [`20256d2`](https://github.com/gamerlogue/web/commit/20256d20e1993044ce5237f66daa638e750ff88f) Merge pull request #1691 from brunogaspar/patch-1
- [`66c9dd4`](https://github.com/gamerlogue/web/commit/66c9dd46e5ba7698d6ab244d88ef1f251f97abf6) Merge pull request #1665 from tkaw220/develop
- [`d8daedc`](https://github.com/gamerlogue/web/commit/d8daedcb469a3963eddb71ee5e99d6ccf5e76697) Merge pull request #1852 from andershammar/develop
- [`503ba02`](https://github.com/gamerlogue/web/commit/503ba024119103f8840f503cb8f5e8e2492a05ec) Merge pull request #1864 from bencorlett/develop
- [`048e332`](https://github.com/gamerlogue/web/commit/048e3322d52fe70429e505a2ee13a9c30223bca4) Merge pull request #1931 from vlakoff/develop
- [`5c340a6`](https://github.com/gamerlogue/web/commit/5c340a60a9bbe316f3bd69808afa24851bb82882) Merge pull request #1879 from jasonlewis/fix/use-base-path-in-start
- [`d8abb9d`](https://github.com/gamerlogue/web/commit/d8abb9d6032c2fb2d1c1310855c0c89bca2339d2) Merge pull request #1877 from briankiewel/htaccess-tabs
- [`c25c56e`](https://github.com/gamerlogue/web/commit/c25c56ecfd2c0c6dc62a56ab8e1f7626930c89e5) Merge pull request #1876 from briankiewel/robots
- [`086f296`](https://github.com/gamerlogue/web/commit/086f2966c023b8208441e6e17045ffded577c023) Merge pull request #1973 from bencorlett/patch-3
- [`71cb787`](https://github.com/gamerlogue/web/commit/71cb787346fa7baa67d90037dd3892966feabb12) Merge pull request #1999 from ipalaus/fix/session-payload
- [`ad52c50`](https://github.com/gamerlogue/web/commit/ad52c50f87ff76b25f7871c15814fc2628acd0e6) Merge pull request #2018 from laravel/welcome-page
- [`2e65a16`](https://github.com/gamerlogue/web/commit/2e65a168dcfe114af6a13e1b2d697adeeb5e644a) Merge pull request #2021 from ipalaus/fix/sendmail-config
- [`443fc9d`](https://github.com/gamerlogue/web/commit/443fc9d7b5a28c39652ae9a593155ca5b7a6be05) Merge pull request #2027 from nils-werner/executable
- [`2529904`](https://github.com/gamerlogue/web/commit/252990455e259994e717bc09bfbeb6bc007aee66) Merge pull request #1586 from Pasvaz/patch-1
- [`23d23dd`](https://github.com/gamerlogue/web/commit/23d23dd07c7e612fbd707965eed18809b871bd53) Merge pull request #1591 from eddiemonge/patch-1
- [`2e8b557`](https://github.com/gamerlogue/web/commit/2e8b5575e5a1957420e7bb1d848138315a868ba3) Merge pull request #1690 from kdocki/master
- [`1bd93c3`](https://github.com/gamerlogue/web/commit/1bd93c332711699a49d8f011c65a123b8a46b46d) Merge pull request #1781 from neoascetic/1690_fix_for_php53
- [`2d863c4`](https://github.com/gamerlogue/web/commit/2d863c45fc836ef957b1bd8ae24be4561fa11ca5) Merge pull request #1803 from alexgalletti/master
- [`9f64de9`](https://github.com/gamerlogue/web/commit/9f64de98f74f6d5a0880bc524e49d9a0828e88c5) Merge pull request #1805 from JesseObrien/patch-1
- [`7e14c8c`](https://github.com/gamerlogue/web/commit/7e14c8c4c60b5e5207b8964be8c770ccfa8b6394) Merge pull request #1822 from bruston/doc-fix-controllers
- [`7244405`](https://github.com/gamerlogue/web/commit/7244405868a8e8613424e9f5eed8eabf087e738a) Merge pull request #1806 from Gargron/patch-1
- [`dd7c317`](https://github.com/gamerlogue/web/commit/dd7c317707417fbcfc930809ac7e083681cd7ae0) Merge pull request #1793 from alexgalletti/patch-1
- [`1185550`](https://github.com/gamerlogue/web/commit/118555002f2f599bd43615fec82332e914a5b621) Merge pull request #1747 from voidman/patch-1
- [`457d0f1`](https://github.com/gamerlogue/web/commit/457d0f174a74e7ef6788114ccadc47bba5f23f40) Merge pull request #1746 from underparnv/master
- [`158b819`](https://github.com/gamerlogue/web/commit/158b81974a5de91fb482dd32539b12bdbee53110) Merge pull request #1731 from dcelasun/master
- [`3f803d4`](https://github.com/gamerlogue/web/commit/3f803d4eb35e7d289518487216c347d3d0e0abc4) Merge pull request #1719 from neoascetic/fix_custom_grammar
- [`7fe61b7`](https://github.com/gamerlogue/web/commit/7fe61b74d60f97d749976c22e6e90b796cf64a8f) Merge pull request #1711 from torm3nt/master
- [`e289bc4`](https://github.com/gamerlogue/web/commit/e289bc489377b5d4d06cbd0b821b15708cc3d1a4) Merge pull request #1700 from davedx/master
- [`e8834d7`](https://github.com/gamerlogue/web/commit/e8834d764ebc28bcca4df84983d560b6f4c05681) Merge pull request #1692 from adityamenon/master
- [`ffd5769`](https://github.com/gamerlogue/web/commit/ffd5769416e03c36d88b477d67f7dd79fc1406e1) Merge pull request #1688 from Pasvaz/patch-2
- [`37503be`](https://github.com/gamerlogue/web/commit/37503be75bbaf121db010d83272a75febe483920) Merge pull request #1685 from tzhuan/patch-1
- [`d293f9c`](https://github.com/gamerlogue/web/commit/d293f9c6a859e457c3dc3e567a6fd0da009efb50) Merge pull request #1676 from chrishow/form-label-html
- [`7888309`](https://github.com/gamerlogue/web/commit/7888309502ec5174f0ad1b3b62ce90b71eb8c9e4) Merge pull request #1663 from neoascetic/anbu_fix
- [`b914d07`](https://github.com/gamerlogue/web/commit/b914d0794886c90b27f0365f617d08c6943eda37) Merge pull request #1662 from fla/master
- [`52e9cd5`](https://github.com/gamerlogue/web/commit/52e9cd5c0975338492a9c92cd83665c96ec100a4) Merge pull request #1639 from frankwong/master
- [`ba3e481`](https://github.com/gamerlogue/web/commit/ba3e481d4a41bdc06ee9da6a657015ba7985b9ce) Merge pull request #1621 from mtthlm/master
- [`f933db7`](https://github.com/gamerlogue/web/commit/f933db7a1221034575d6f46e5577582f41598880) Merge pull request #1618 from demsey2/master
- [`778a97b`](https://github.com/gamerlogue/web/commit/778a97b3196e712131720c2c520cceb14bca82e5) Merge pull request #1827 from neoascetic/flush_file_cache
- [`e86532e`](https://github.com/gamerlogue/web/commit/e86532e0956e18a05c26d4ed4724ba7e376edcb7) Merge pull request #1829 from neoascetic/return_non_0_on_command_fail
- [`5dd3ec6`](https://github.com/gamerlogue/web/commit/5dd3ec6f1e086d3f11bbfc3a44e984dede8a914c) Merge pull request #1845 from stevenklar/master
- [`78af456`](https://github.com/gamerlogue/web/commit/78af4569ded5b10b5a5bf293ac1e15c0514e46e6) Merge pull request #1855 from rittme/patch-1
- [`4ecbef6`](https://github.com/gamerlogue/web/commit/4ecbef68a0b889dda6112049b0b7d63d420b8eab) Merge pull request #1853 from cviebrock/table-macros
- [`0008a23`](https://github.com/gamerlogue/web/commit/0008a2324f68f26661c5f33c69bbc76f9d6c5ae7) Merge pull request #1857 from doubleking/master
- [`936160f`](https://github.com/gamerlogue/web/commit/936160f90758e8b03b55294ae14fab755303d8ce) Merge pull request #1850 from rk/patch-1
- [`64953eb`](https://github.com/gamerlogue/web/commit/64953eb1968aba901b9d7abc585dab1939254718) Merge pull request #1869 from aeberhardo/docs/contributing-typo
- [`23464ca`](https://github.com/gamerlogue/web/commit/23464cac25f933a4f0a07aacfd1dc38efedebee7) Merge pull request #1868 from aeberhardo/bug/version-bump-3.2.14
- [`92f602e`](https://github.com/gamerlogue/web/commit/92f602edbfa3e6c6fb22d91e21a19aa0d9f74660) Merge pull request #1875 from effenberger/master
- [`cffded6`](https://github.com/gamerlogue/web/commit/cffded660c2c5158bc1c7ae404b6b9ab1eaee460) Merge pull request #1959 from dotramses/patch-1
- [`348fecc`](https://github.com/gamerlogue/web/commit/348feccd3e70bb51facbaba2993050ca824afc4e) Merge pull request #1989 from juukie14/master
- [`7fb445b`](https://github.com/gamerlogue/web/commit/7fb445b1077dbe9e01207d5770812f555e3e83f6) Merge pull request #1987 from netflam/patch-1
- [`6891fb7`](https://github.com/gamerlogue/web/commit/6891fb7b2119476f9541bfef4924f07ad975dafc) Merge pull request #1963 from EvgenyKovalev/master
- [`86fc0ca`](https://github.com/gamerlogue/web/commit/86fc0ca7cb77595cb59822168947b4ed3a25c0d6) Merge pull request #1976 from neoascetic/more_fluent_eloquent
- [`3965429`](https://github.com/gamerlogue/web/commit/3965429176ed70ffb9523355d83adc167ccc47b0) Merge pull request #1970 from jasonlfunk/master
- [`1fdd186`](https://github.com/gamerlogue/web/commit/1fdd186ddee99e11b8b084c592f3a9ba93cd45e1) Merge pull request #1974 from neoascetic/belongs_to_call_a_getter
- [`c878a18`](https://github.com/gamerlogue/web/commit/c878a18fdbfc60f791febc1b927f4117be57b0e4) Merge pull request #1962 from fpirsch/master
- [`9871281`](https://github.com/gamerlogue/web/commit/9871281b34962fadd880aef98e1382d0b54f98cc) Merge pull request #1880 from authman/master
- [`fe00e01`](https://github.com/gamerlogue/web/commit/fe00e012121332718f2227610f37bad21e8ad9e9) Merge pull request #1992 from neoascetic/patch-1
- [`37acc99`](https://github.com/gamerlogue/web/commit/37acc995df22ef8b18656f580e8140f8f5c61cb0) Merge pull request #1991 from juukie14/master
- [`6a1d203`](https://github.com/gamerlogue/web/commit/6a1d203baf25d4132c4120f691dd3c2ee381bade) Merge pull request #1994 from aeberhardo/bug/putenv
- [`58d6b11`](https://github.com/gamerlogue/web/commit/58d6b112a7d805db2702ae4697914776e0bb939e) Merge pull request #2009 from dr-dimitru/master
- [`c7caca4`](https://github.com/gamerlogue/web/commit/c7caca41a2d8f18b3494d264ca50509f74e0d307) Merge pull request #2022 from kirkbushell/master
- [`f742cc3`](https://github.com/gamerlogue/web/commit/f742cc32f5c29350af4c5ddd7d6bfe175f727604) Merge pull request #1 from laravel/master
- [`122f3ab`](https://github.com/gamerlogue/web/commit/122f3abd25d884e9bcad7be4ecd7aa5eaa580610) Merge pull request #2 from laravel/master
- [`584a769`](https://github.com/gamerlogue/web/commit/584a7691ad46b9d688f4a220b98ffb93e3104a40) Merge pull request #3 from laravel/master
- [`c89354f`](https://github.com/gamerlogue/web/commit/c89354f63c811eee78b23351a1883bc6c430cff9) Merge pull request #2026 from vus520/3018bcce718665e28b6fcf8b48fc3ef79f9d8c65
- [`b9fe2dd`](https://github.com/gamerlogue/web/commit/b9fe2dda266f194baa43e25491abc0d392696f41) Merge pull request #2013 from juukie14/master
- [`6d4418a`](https://github.com/gamerlogue/web/commit/6d4418afff77203005812d15d25c02b7f670f3c1) Merge pull request #2044 from jonathanmarvens/master
- [`fe74ce3`](https://github.com/gamerlogue/web/commit/fe74ce3da111b19030bac6e67fdc9655339027b4) Merge pull request #2089 from briankiewel/patch1
- [`19841d8`](https://github.com/gamerlogue/web/commit/19841d865d59c6238b81f01a7c9d40296299ee12) Merge pull request #2095 from briankiewel/patch2
- [`5c49245`](https://github.com/gamerlogue/web/commit/5c49245afe8ece6ab31e9b6e144bb853c25d8b0e) Merge pull request #2237 from mmeyer2k/patch-2
- [`91ca170`](https://github.com/gamerlogue/web/commit/91ca1707b86610fc72bb555e0a01d05d8e24b1d8) Merge pull request #2278 from fabpot/patch-1
- [`d1c0401`](https://github.com/gamerlogue/web/commit/d1c04014dd9155684c44dfdbaa03a7a0de4b4d46) Merge pull request #2332 from laheab/master
- [`1745513`](https://github.com/gamerlogue/web/commit/17455130350c2577fb95f610d897495c05ead3ed) Merge pull request #2358 from JosephSilber/ignore-windows-thumbs
- [`64dd939`](https://github.com/gamerlogue/web/commit/64dd939bba10506efb333f6d17e06f92adc2b456) Merge pull request #2366 from abishekrsrikaanth/patch-1
- [`6a35264`](https://github.com/gamerlogue/web/commit/6a352640c54e2602c295ac9d53f1efb9a36307f3) Merge pull request #2321 from ameech/patch-1
- [`b2ac319`](https://github.com/gamerlogue/web/commit/b2ac3197be39b0a2f30a8b690ec839b010a17f1b) Merge pull request #2311 from msurguy/patch-2
- [`39e265f`](https://github.com/gamerlogue/web/commit/39e265f03740ab74e988deef4923435de46fa4bf) Merge pull request #2309 from cviebrock/feature/cleanup-css
- [`65842ae`](https://github.com/gamerlogue/web/commit/65842ae55a5795fe5d6546474107326cfa3f7d6c) Merge pull request #2377 from rmobis/master
- [`1d9d577`](https://github.com/gamerlogue/web/commit/1d9d577f9b13a95dc83b63ff2768d2e8ca6007bd) Merge pull request #2192 from driesvints/dv/cleanup
- [`8084e35`](https://github.com/gamerlogue/web/commit/8084e3526aa51dd3d4cc699f51238e08b2b01cb9) Merge pull request #2204 from mmeyer2k/patch-1
- [`4535fa4`](https://github.com/gamerlogue/web/commit/4535fa404802381b4ceeb18c2a2a96bfb07d6d2e) Merge pull request #2386 from rmasters/upgrade-notes
- [`d19a79b`](https://github.com/gamerlogue/web/commit/d19a79baf27fe0a5b94a0670442b46c844f55758) Merge pull request #2400 from jamesmills/patch-1
- [`4e25666`](https://github.com/gamerlogue/web/commit/4e2566632e390a8f4423e3adfb7d4858c4206bf1) Merge pull request #2426 from philsturgeon/patch-1
- [`d8270ae`](https://github.com/gamerlogue/web/commit/d8270ae52e065456f766e551e32e0beb19a48c83) Merge pull request #2423 from mitchellvanw/develop
- [`3cd00eb`](https://github.com/gamerlogue/web/commit/3cd00eb7bd7d8a6a39464b5a655ac08aabf0bb75) Merge pull request #2436 from bryannielsen/patch-1
- [`df6e4a9`](https://github.com/gamerlogue/web/commit/df6e4a973b5ce7ee79f109d4558124e652e6cd7d) Merge pull request #2446 from seengee/develop
- [`d4c5a0f`](https://github.com/gamerlogue/web/commit/d4c5a0fd8faeb2f65eb7e1d5a57f34d92b64a9bc) Merge pull request #2440 from crynobone/patch/upgrade
- [`074d0f0`](https://github.com/gamerlogue/web/commit/074d0f08684f579b0fdd4420083e9ecb5d7117bb) Merge pull request #2453 from bretterer/patch-1
- [`b83290e`](https://github.com/gamerlogue/web/commit/b83290e5993ac1e95193ff9a806f81fc67ff2805) Merge pull request #2455 from irazasyed/patch-1
- [`b2cad30`](https://github.com/gamerlogue/web/commit/b2cad305022449d62222d8bbf2e9adf9b4e445da) Merge pull request #2470 from adamgoose/develop
- [`d763a8a`](https://github.com/gamerlogue/web/commit/d763a8a6d93d99de09f7e7f2a3fefeb29aaaac3e) Merge pull request #2471 from adamgoose/develop
- [`c1ab700`](https://github.com/gamerlogue/web/commit/c1ab700b65b028f51e8a975596445859b5008aab) Merge pull request #2480 from samchivers/patch-1
- [`adfa89b`](https://github.com/gamerlogue/web/commit/adfa89b9b24be2624ddceb88bf658ca8c174a093) Merge pull request #2560 from crynobone/feature/post-install-cmd
- [`69bb623`](https://github.com/gamerlogue/web/commit/69bb62333bb32010eaf0a3bfa86c5bfb79a772df) Merge pull request #2534 from a25ce1/patch-1
- [`ca744fc`](https://github.com/gamerlogue/web/commit/ca744fc345c3aa90b63f921ca2b784e4f83a1820) Merge pull request #2612 from liuggio/patch-1
- [`d286d94`](https://github.com/gamerlogue/web/commit/d286d9412275ac2ded7c4037f300f29e57b88d85) Merge pull request #2399 from JosephSilber/auth-ajax-401
- [`d0c5007`](https://github.com/gamerlogue/web/commit/d0c500716c69cf5a8026f8f7f0975ed35cb07995) Merge pull request #2508 from euantorano/patch-1
- [`46c7f07`](https://github.com/gamerlogue/web/commit/46c7f075ab9aacfa97323c89760d36af78faa112) Merge pull request #2389 from anlutro-pull-requests/validator-require-without-all
- [`98d160d`](https://github.com/gamerlogue/web/commit/98d160dc5bcbddc559ba57e8c12c2eb5ac77be50) Merge pull request #2655 from alexandre-butynski/patch-1
- [`945a073`](https://github.com/gamerlogue/web/commit/945a07387993a345f809fe95076aac94c8c2f1c0) Merge pull request #2710 from webdrop/master
- [`151fdab`](https://github.com/gamerlogue/web/commit/151fdab5fe8da17be29b8dc9f69ec6bb2501f4aa) Merge pull request #2706 from idhamperdameian/master
- [`5a172d9`](https://github.com/gamerlogue/web/commit/5a172d90d3d0572dba944b76675d681b0bf8eb5e) Merge pull request #2687 from EvgenyKovalev/patch-2
- [`fafb983`](https://github.com/gamerlogue/web/commit/fafb9837ddf0aeaf4123b29828e35fb1384378e6) Merge pull request #2715 from EvgenyKovalev/patch-2
- [`c7dff13`](https://github.com/gamerlogue/web/commit/c7dff1340189aaa63252d658d0511f69f0d072e8) Merge pull request #2806 from GrahamCampbell/mail
- [`3c19e7a`](https://github.com/gamerlogue/web/commit/3c19e7ad4aae45c5bb4fd451a290fa17602680f8) Merge pull request #2735 from boffey/fix-mail-config-comments
- [`7a7835f`](https://github.com/gamerlogue/web/commit/7a7835fe5fb29fa0e4c5ebb225b8e557eb473115) Merge pull request #2800 from barryvdh/patch-2
- [`cb21cb8`](https://github.com/gamerlogue/web/commit/cb21cb8aa8b9e9d4d0338e47daa2a6b18d83ea44) Merge pull request #2754 from GrahamCampbell/fixes
- [`af70922`](https://github.com/gamerlogue/web/commit/af7092275956a839e79f49158312241d3ea3b7f9) Merge pull request #2726 from lucasmichot/patch-1
- [`5b811e3`](https://github.com/gamerlogue/web/commit/5b811e308aa380dfa42234298c431930f7a6166e) Merge pull request #2884 from crynobone/feature/service-mailgun-domain
- [`9df2e23`](https://github.com/gamerlogue/web/commit/9df2e2343e719f83f441914e8c9402ae0fb4de62) Merge pull request #2885 from GrahamCampbell/badges
- [`f1fe4ef`](https://github.com/gamerlogue/web/commit/f1fe4efc50ec43ab7b49dc09cde56711218f80a6) Merge pull request #2935 from GrahamCampbell/badges
- [`a6a01b9`](https://github.com/gamerlogue/web/commit/a6a01b976c288481099a866396ae13c71e71a946) Merge pull request #2851 from juukie14/user-model-hidden
- [`e3cb29a`](https://github.com/gamerlogue/web/commit/e3cb29a3972540df97924d368d7c8687b6e3a171) Merge pull request #2929 from barryvdh/patch-3
- [`f9ce5f9`](https://github.com/gamerlogue/web/commit/f9ce5f9c5006d9527e798f616e1c176b4f78e961) Merge pull request #2854 from seeARMS/patch-1
- [`486cd4b`](https://github.com/gamerlogue/web/commit/486cd4b2571a1d83047e9b665bf7b0592b979bb9) Merge pull request #2853 from anewmanjones/patch-1
- [`8e43b13`](https://github.com/gamerlogue/web/commit/8e43b1360a5d4b7959cbcf6dd5cad7512fd539c1) Merge pull request #2948 from TheShiftExchange/patch-1
- [`5d7f9b2`](https://github.com/gamerlogue/web/commit/5d7f9b2188315cbcb1b0a37a7bc9bae4d8151f16) Merge pull request #2947 from briankiewel/patch-1
- [`f4e091f`](https://github.com/gamerlogue/web/commit/f4e091ff009e53d8f2f7c49dad10dc23ce76d590) Merge pull request #2951 from bworwa/patch-1
- [`61b67ef`](https://github.com/gamerlogue/web/commit/61b67ef869831fc77129bf146c1b3eca025978a6) Merge pull request #2967 from crynobone/patch/update-gitignore
- [`695ee01`](https://github.com/gamerlogue/web/commit/695ee0193daf54ae6d6c64bbff55380493e92380) Merge pull request #2970 from crynobone/patch/phpunit
- [`e52be1f`](https://github.com/gamerlogue/web/commit/e52be1f98dc204f4efbf21303f0d88827c07b633) Merge pull request #2974 from jpavon/patch-2
- [`55053de`](https://github.com/gamerlogue/web/commit/55053de667e06bea3e873710b683cb25419e75e9) Merge pull request #2971 from barryvdh/patch-3
- [`b363f3d`](https://github.com/gamerlogue/web/commit/b363f3d195853d40a52f3e51452557c597c86131) Merge pull request #2964 from cjaoude/master
- [`462b911`](https://github.com/gamerlogue/web/commit/462b91157b24b53c488076b0ac9f1df7565c5f18) Merge pull request #2960 from josezenem/master
- [`8b18b40`](https://github.com/gamerlogue/web/commit/8b18b40a7b5add6739538e82c3e7c7890b8c8de3) Merge pull request #2980 from driesvints/feature/dont-extend-class-aliases
- [`962ae1b`](https://github.com/gamerlogue/web/commit/962ae1b668973e0a50d334772c34c6d66b0cfa39) Merge pull request #2979 from serhatdurum/develop
- [`2fb780b`](https://github.com/gamerlogue/web/commit/2fb780b63fc88d83fb7a360b7c7f9b0f267174a8) Merge pull request #2981 from jasonlewis/fix/auth-csrf-filters
- [`464c595`](https://github.com/gamerlogue/web/commit/464c595c460ff5477842a71ddc09a787a38865d3) Merge pull request #2991 from alnutile/patch-3
- [`35d2be4`](https://github.com/gamerlogue/web/commit/35d2be474a150cc6b8d4d1cf4f9388384fe56573) Merge pull request #2985 from brnlbs/develop
- [`0f5e0f8`](https://github.com/gamerlogue/web/commit/0f5e0f8b1a5d10a68a36d0eefb62908a879bf31e) Merge pull request #2983 from ajschmaltz/patch-1
- [`bfd5323`](https://github.com/gamerlogue/web/commit/bfd5323fab8592891904608cf55d6a9bf141eefe) Merge pull request #3011 from tyloo/patch-1
- [`100f727`](https://github.com/gamerlogue/web/commit/100f727fd4347660cb7d72acd6e2513a92428701) Merge pull request #3021 from hernandev/develop
- [`fbd663c`](https://github.com/gamerlogue/web/commit/fbd663c9f16f4c77a6413f4a54b689278e2d91ea) Merge pull request #3031 from GrahamCampbell/cs
- [`986c964`](https://github.com/gamerlogue/web/commit/986c964c9839420cf9b4593a3559b157aaf9e80f) Merge pull request #3034 from crynobone/patch/tabs
- [`1edb0eb`](https://github.com/gamerlogue/web/commit/1edb0eb24ca66e1f0d8062d01510326c0234ffc8) Merge pull request #3035 from danharper/patch-1
- [`63edcad`](https://github.com/gamerlogue/web/commit/63edcad6541c22078bbcba253aa1c6ed5b32b1ee) Merge pull request #3036 from lucasmichot/short-notation-array
- [`2ac4ce6`](https://github.com/gamerlogue/web/commit/2ac4ce6fc41458f3b00e395bef8ec128f1ce8257) Merge pull request #3052 from antonioribeiro/patch-1
- [`3cb7118`](https://github.com/gamerlogue/web/commit/3cb71182a9bc3e5051c1942ed6bac3b5241a38aa) Merge pull request #3045 from robinmitra/develop
- [`6e438cf`](https://github.com/gamerlogue/web/commit/6e438cfb5ba000a4b52fd122571b84b8fc74b0ee) Merge pull request #3070 from alexsoft/patch-1
- [`c39679b`](https://github.com/gamerlogue/web/commit/c39679bb8651ac5de07f7ee2553c808d1c6d2f62) Merge pull request #3065 from johnhout/patch-1
- [`18301a1`](https://github.com/gamerlogue/web/commit/18301a1fd279c12be71002cf3453e079eeb9a9ff) Merge pull request #3062 from jlaswell/patch-1
- [`c672286`](https://github.com/gamerlogue/web/commit/c6722869a8f9196046840bef29d0e24a80be57cd) Merge pull request #3061 from antonioribeiro/patch-2
- [`31296e6`](https://github.com/gamerlogue/web/commit/31296e676b3dab53a69e93e545585534d560ce13) Merge pull request #3079 from mayoz/develop
- [`6eefa4e`](https://github.com/gamerlogue/web/commit/6eefa4e493c345d5c5358d52e3b1a63e137bf9ed) Merge pull request #3078 from anvanza/patch-1
- [`f5b4e2d`](https://github.com/gamerlogue/web/commit/f5b4e2dc93f66cb71265c6b56557a3f8cb38b45c) Merge pull request #3082 from webpatser/develop
- [`95e9346`](https://github.com/gamerlogue/web/commit/95e934698f5d3c17a197dff82cfb97da0d7ba79f) Merge pull request #3081 from alnutile/patch-5
- [`3a84475`](https://github.com/gamerlogue/web/commit/3a844756fe7df1685c6799b460f39509cdf6232f) Merge pull request #3091 from GrahamCampbell/patch-1
- [`657033a`](https://github.com/gamerlogue/web/commit/657033afa8e1559ddfc69752be7b3e51d25694c6) Merge pull request #3087 from fungku/develop
- [`c494e83`](https://github.com/gamerlogue/web/commit/c494e83193eef9551229021adcad2cb1c457b915) Merge pull request #3114 from matism/develop
- [`a59a141`](https://github.com/gamerlogue/web/commit/a59a1416cbc0d709059486b816d450756eb91db5) Merge pull request #3106 from hannesvdvreken/patch-2
- [`10452da`](https://github.com/gamerlogue/web/commit/10452da7b52e2d390e61c70d5e0d2dcaa8bea491) Merge pull request #3112 from nblackburn/patch-1
- [`0c3f1c9`](https://github.com/gamerlogue/web/commit/0c3f1c967c3f18cf09f5cd565c90239c3e0566a3) Merge pull request #3118 from miclf/patch-1
- [`c17925b`](https://github.com/gamerlogue/web/commit/c17925bce4c4003ffa89058b6bd0677646ae1059) Merge pull request #3108 from pascalschwientek/patch-1
- [`662bc27`](https://github.com/gamerlogue/web/commit/662bc27468f48b1386f9c2caa504b4f624df6aaa) Merge pull request #3153 from Codeklopper/patch-2
- [`5eb4d0a`](https://github.com/gamerlogue/web/commit/5eb4d0afd7f5047ffd6532423c9150c363d01af8) Merge pull request #3048 from lucidlogic/master
- [`4afcd8c`](https://github.com/gamerlogue/web/commit/4afcd8c278febbe6840dbf8bbb46514818abce59) Merge pull request #3136 from melvinsh/patch-1
- [`f86c94b`](https://github.com/gamerlogue/web/commit/f86c94b02ea5aa57cf1bee658ab7f83e4a43371a) Merge pull request #3151 from gregoryduckworth/patch-1
- [`6dfafcc`](https://github.com/gamerlogue/web/commit/6dfafcc402ab29cf10341a2da96e86ba01a99f94) Merge pull request #3148 from dannyvink/develop
- [`47971fb`](https://github.com/gamerlogue/web/commit/47971fbba23ea30ebf7ec23b95d6324715de3ebf) Merge pull request #3176 from slik/bugfix/artisan_optimize_crash
- [`b1dc129`](https://github.com/gamerlogue/web/commit/b1dc129af5eed8e8247a33fe3aa4aa26e5d86d66) Merge pull request #3132 from winglian/develop
- [`01adbfb`](https://github.com/gamerlogue/web/commit/01adbfbb5f01346e5adcbbf3ea0d44de90874083) Merge pull request #3187 from GrahamForks/autoload-dev
- [`a6a0aab`](https://github.com/gamerlogue/web/commit/a6a0aab6c6ba4af0bb44dd9be19d35248233b92a) Merge pull request #3188 from anhskohbo/patch-3
- [`e2b7f92`](https://github.com/gamerlogue/web/commit/e2b7f92abeb2060d775d7fb27e09650d9bc768f9) Merge pull request #3046 from driesvints/feature/phpspec-config-file
- [`c84e2fa`](https://github.com/gamerlogue/web/commit/c84e2fa0359a0c197128e8ec1f1cf0fc432dad3e) Merge pull request #3197 from coderabbi/develop
- [`3cfe2a0`](https://github.com/gamerlogue/web/commit/3cfe2a0c85c379c66fbd9d6501b81cec92757409) Merge pull request #3196 from ytake/develop
- [`223ff10`](https://github.com/gamerlogue/web/commit/223ff10d40b18fe26d7d7b268493ae60a0ddb80a) Merge pull request #3205 from GrahamForks/strict
- [`c7eecb1`](https://github.com/gamerlogue/web/commit/c7eecb1c918c1d70641b2c819e09fc912bc67f85) Merge pull request #3198 from ibrasho/switch-order-of-providers
- [`6d078c1`](https://github.com/gamerlogue/web/commit/6d078c1d58f187b25a1d90165cbc0b170cb880ef) Merge pull request #3203 from jumilla/develop
- [`ff13943`](https://github.com/gamerlogue/web/commit/ff13943dbeef2d4e254cbd6bc2090875ea72cb4b) Merge pull request #3200 from overtrue/patch-3
- [`b4b12e9`](https://github.com/gamerlogue/web/commit/b4b12e91f890b6d9ff5b8c98112e7810acbc711e) Merge pull request #3213 from ebynum/develop
- [`b6ce0e5`](https://github.com/gamerlogue/web/commit/b6ce0e513eb4154cf5eb5ddf7962dcd047419ac2) Merge pull request #3218 from hannesvdvreken/patch-1
- [`8679128`](https://github.com/gamerlogue/web/commit/86791280d654b6e2530c6ed8591dd6c773c947dd) Merge pull request #3216 from TheShiftExchange/patch-1
- [`9e6613f`](https://github.com/gamerlogue/web/commit/9e6613f3b8b448a6b2d084b07ae8b46cd2461b8c) Merge pull request #3219 from joecohens/patch-1
- [`c99d4e3`](https://github.com/gamerlogue/web/commit/c99d4e396bc0bcfeb1d9b295524e0bb96ff9fed3) Merge pull request #3228 from JoeForks/fix/event-sp
- [`fbbfa5a`](https://github.com/gamerlogue/web/commit/fbbfa5a5d6730d2fbc7d98d44e8260d4199d8ea2) Merge pull request #3227 from jaylinski/develop
- [`86b0ae0`](https://github.com/gamerlogue/web/commit/86b0ae08963d36a727120e6e10352cc108c4cf2e) Merge pull request #3221 from billmn/patch-1
- [`33e19b8`](https://github.com/gamerlogue/web/commit/33e19b852e36b9172f880967e7acb7ce0d885020) Merge pull request #3026 from paulofreitas/develop
- [`e0c22a6`](https://github.com/gamerlogue/web/commit/e0c22a6e716fb92f0acf577ca7bfd05a4f74999f) Merge pull request #3233 from GrahamForks/stability
- [`b07b9f8`](https://github.com/gamerlogue/web/commit/b07b9f8426913e02d9b70c3b07a66ead7e28c026) Merge pull request #3240 from danharper/patch-1
- [`4552d93`](https://github.com/gamerlogue/web/commit/4552d93b66c51aaa0f07b80df3e9f950498fd5bc) Merge pull request #3234 from DavidLemayian/patch-1
- [`b2c7954`](https://github.com/gamerlogue/web/commit/b2c7954e1e8de7ed6818109d098fcabe1f7ecbf4) Merge pull request #3235 from jhmilan/develop
- [`01cf5f1`](https://github.com/gamerlogue/web/commit/01cf5f183a6c381b33046c5e381e2a2a5d70c238) Merge pull request #3267 from GrahamForks/fix
- [`7a5a5c7`](https://github.com/gamerlogue/web/commit/7a5a5c7e38ac9e7b7d69880323db52363beef25b) Merge pull request #3273 from theravel/master
- [`cc09679`](https://github.com/gamerlogue/web/commit/cc09679c81fcd5f328956603a32adc6377f241ff) Merge pull request #3269 from martinbean/set-mail-defaults
- [`41b9969`](https://github.com/gamerlogue/web/commit/41b9969c45af5dd33634ce347ca9dbbc3acf3710) Merge pull request #3265 from TheShiftExchange/patch-1
- [`c9afa34`](https://github.com/gamerlogue/web/commit/c9afa3480f1c6263ac6f81c3a43128682c33238b) Merge pull request #3262 from mikedugan/master
- [`94000ae`](https://github.com/gamerlogue/web/commit/94000aec2eeda851f218176632f746a6b77bff40) Merge pull request #3260 from itised/master
- [`1c58722`](https://github.com/gamerlogue/web/commit/1c58722f023248d102ad5ee4503c3d23bb403190) Merge pull request #3258 from fwForks/master
- [`c357eb0`](https://github.com/gamerlogue/web/commit/c357eb0ccdc116332dc4fbcf08cbdb6b7c2e97da) Merge pull request #3250 from bbashy/patch-1
- [`29059a6`](https://github.com/gamerlogue/web/commit/29059a636533549458ae70790b2c7883a9ab7606) Merge pull request #3246 from Garbee/filemode-queue
- [`4e444b0`](https://github.com/gamerlogue/web/commit/4e444b0820ec3c4b466287407c5b3f466a15886f) Merge pull request #3245 from webpatser/hotfix/npm-warning
- [`1cf4fb6`](https://github.com/gamerlogue/web/commit/1cf4fb6bd620797b04ff9f2d071c00180b035e7c) Merge pull request #3243 from mikefrancis/patch-1
- [`78e24ac`](https://github.com/gamerlogue/web/commit/78e24acf2ae2637b1b4d8b65f9b6a19edb9f5fc2) Merge pull request #3278 from jpkleemans/patch-1
- [`73e1c71`](https://github.com/gamerlogue/web/commit/73e1c71e70846ff2cb960a7635e2cd4d2f80a872) Merge pull request #3279 from marcus-herrmann/develop
- [`4929781`](https://github.com/gamerlogue/web/commit/4929781b953c38e265cadeb33fa97195031797fe) Merge pull request #3282 from mathewhany/master
- [`6249969`](https://github.com/gamerlogue/web/commit/6249969271a6d8adea5df8efdd41de93c2bd15d6) Merge pull request #3283 from mathewhany/master
- [`393569b`](https://github.com/gamerlogue/web/commit/393569bfda7998a6fc2024f884f2c6c73a9f8879) Merge pull request #3294 from MarkRedeman/master
- [`ce5bcb2`](https://github.com/gamerlogue/web/commit/ce5bcb2f8f6758f8d4b1fa255d46f98a9e960b56) Merge pull request #3304 from sineld/develop
- [`7cbe38c`](https://github.com/gamerlogue/web/commit/7cbe38c0a952029d1428d30810dbfe5c16d348e2) Merge pull request #3302 from EliuFlorez/patch-13
- [`3e9422b`](https://github.com/gamerlogue/web/commit/3e9422b74f4acdd5765d1da5a2d25b8887fe4a24) Merge pull request #3315 from taiyaei/fix-spacing
- [`84028d4`](https://github.com/gamerlogue/web/commit/84028d4981799dc65bc1bf6122b75c9681875f20) Merge pull request #3320 from garygreen/ftp-adapter
- [`7bddbdc`](https://github.com/gamerlogue/web/commit/7bddbdc2a1f8d9c23205707e74455d74684e3031) Merge pull request #3318 from TheShiftExchange/patch-1
- [`7ac2f37`](https://github.com/gamerlogue/web/commit/7ac2f3782c04a354ce60d63c259c937ecb256ac7) Merge pull request #3323 from EliuFlorez/patch-15
- [`fcdb4cc`](https://github.com/gamerlogue/web/commit/fcdb4ccaa063f49339d88f173d1be689aebef7cd) Merge pull request #3329 from TheShiftExchange/patch-2
- [`609ec5a`](https://github.com/gamerlogue/web/commit/609ec5afe7b0d3d26ba602b29a12d1caba14f61b) Merge pull request #3328 from mul14/remove-unnecessary-gitignore-in-storage
- [`8eb9690`](https://github.com/gamerlogue/web/commit/8eb969098b9d8c03267403d840747440d4f060c0) Merge pull request #3334 from GrahamForks/compiled
- [`a9a59c1`](https://github.com/gamerlogue/web/commit/a9a59c1a867bbe64fe6efcc26f26212af367c3ef) Merge pull request #3338 from makque/patch-1
- [`2040080`](https://github.com/gamerlogue/web/commit/2040080fabeb9f3fa22a0df8cf5214e7f22f0b54) Merge pull request #3343 from TheShiftExchange/patch-2
- [`58ecbcd`](https://github.com/gamerlogue/web/commit/58ecbcdb1eb81b74bc23d7a92dc4a834ace0925f) Merge pull request #3346 from laravel/revert-3343-patch-2
- [`71e3391`](https://github.com/gamerlogue/web/commit/71e339146e1bffc8b63f14b2b2687e5284d7f285) Merge pull request #3351 from fideloper/patch-1
- [`0d541ec`](https://github.com/gamerlogue/web/commit/0d541ecb9a8c67b15fe9ce89edff7b78d3176842) Merge pull request #3360 from patrickbrouwers/patch-2
- [`e11d40a`](https://github.com/gamerlogue/web/commit/e11d40abd023544dfd3edc60a9621b8e312ccfee) Merge pull request #3368 from patrickbrouwers/patch-1
- [`e0ddb26`](https://github.com/gamerlogue/web/commit/e0ddb26e44308f9506dcbb551c6c683e1d7552d2) Merge pull request #3372 from mul14/patch-1
- [`f17d0e8`](https://github.com/gamerlogue/web/commit/f17d0e8a38c2c479dcde0853923a2807646a216f) Merge pull request #3384 from rafaelfs17/patch-1
- [`d68b5b8`](https://github.com/gamerlogue/web/commit/d68b5b883fd83376537b7cde9b877aa3433f502a) Merge pull request #3388 from GrahamForks/faker
- [`685e3cf`](https://github.com/gamerlogue/web/commit/685e3cf0fadb1ee2e5dd469f5616bad8fb63ea25) Merge pull request #3390 from marcanuy/develop
- [`6575cb7`](https://github.com/gamerlogue/web/commit/6575cb74f844afe9b0b1797ce8feca6970a05766) Merge pull request #3395 from spinen/feature/usePathParameter
- [`f871b7d`](https://github.com/gamerlogue/web/commit/f871b7d0f358d74d5a76db297be1bde73dcc4fcd) Merge pull request #3397 from phaza/patch-2
- [`9b6d5f4`](https://github.com/gamerlogue/web/commit/9b6d5f42379df3b6af8d29b6e11ecd99d614b11d) Merge pull request #3399 from GrahamForks/cs
- [`9293247`](https://github.com/gamerlogue/web/commit/9293247585d48e6095a998bce6656b4deb286cd3) Merge pull request #3398 from crynobone/feature/root-install
- [`86e53af`](https://github.com/gamerlogue/web/commit/86e53af851ddef58528a9c47f5d5117d2a22e75c) Merge pull request #3403 from RomainLanz/patch-1
- [`e4796a2`](https://github.com/gamerlogue/web/commit/e4796a26080194537f6efe8beb7e6a0682241949) Merge pull request #3405 from nWidart/patch-1
- [`a1a55fe`](https://github.com/gamerlogue/web/commit/a1a55fe274922382c6bcf33d9a92d9e44a5d4189) Merge pull request #3410 from pespantelis/class-notation
- [`9a80c09`](https://github.com/gamerlogue/web/commit/9a80c09a5a43f8152e7d663383d40d910978eb43) Merge pull request #3345 from douyasi/master
- [`50cf908`](https://github.com/gamerlogue/web/commit/50cf908cba46a443956f1787190f146314f6768b) Merge pull request #3348 from browner12/patch-1
- [`1ac0a0b`](https://github.com/gamerlogue/web/commit/1ac0a0bbda864ab29b8972a03a984a3ed5034df5) Merge pull request #3358 from lukeb/add-better-elixir-version
- [`11a8db8`](https://github.com/gamerlogue/web/commit/11a8db89827072a18b5b8c0b4bf98b8ae9008f43) Merge pull request #3378 from TheShiftExchange/patch-3
- [`bb6c23c`](https://github.com/gamerlogue/web/commit/bb6c23c2eb4749739a1e98e3c339f133c389aecd) Merge pull request #3392 from Fuxy22/patch-1
- [`6df868a`](https://github.com/gamerlogue/web/commit/6df868a123a8445de1aceba1349c550b1247aff0) Merge pull request #3409 from antonybudianto/patch-1
- [`fa756ff`](https://github.com/gamerlogue/web/commit/fa756ff4c206e46e30400cea2db8fff4a570e850) Merge pull request #3415 from martinssipenko/master
- [`f6e6508`](https://github.com/gamerlogue/web/commit/f6e6508b4e765eeda4bdba4a6701337b30ceb635) Merge pull request #3416 from krienow/doctype
- [`136d7fa`](https://github.com/gamerlogue/web/commit/136d7fa8ef74d0bbe3dd29c0e19c58585e84606e) Merge pull request #3418 from baspeters/feature/sqlsrv-default-charset
- [`5033b85`](https://github.com/gamerlogue/web/commit/5033b8508055567b5df4fc5964929602e3eb116a) Merge pull request #3421 from barryvdh/patch-1
- [`3b0d039`](https://github.com/gamerlogue/web/commit/3b0d03920e93c38b1cfdce1e4f7a8fba3efa1fd3) Merge pull request #3426 from Phyxsius/patch-2
- [`9089b7e`](https://github.com/gamerlogue/web/commit/9089b7e2ae4d05e217775a2cabb616c0dad4c721) Merge pull request #3434 from josezenem/master
- [`2dd8ed1`](https://github.com/gamerlogue/web/commit/2dd8ed131adcb72237e570b8ec0df2231c3add48) Merge pull request #3435 from tonglil/master
- [`99d25ec`](https://github.com/gamerlogue/web/commit/99d25ec96c4e428b6e60efc364a1188018d80077) Merge pull request #3438 from bbashy/patch-1
- [`07cb1eb`](https://github.com/gamerlogue/web/commit/07cb1eb8736d77a5b5455456d9be8ea227a709a5) Merge pull request #3440 from mikaelmattsson/patch-1
- [`48abc56`](https://github.com/gamerlogue/web/commit/48abc56ede92e21cc8536505f67871f45df93ff6) Merge pull request #3444 from antonybudianto/patch-1
- [`e3f18ea`](https://github.com/gamerlogue/web/commit/e3f18ea5f631d4c35cc5b3f53a9fcda4e7c09015) Merge pull request #3449 from browner12/patch-1
- [`5964dcf`](https://github.com/gamerlogue/web/commit/5964dcf97af29e0dac3dc8c8563c72486bd39976) Merge pull request #3456 from sileence/bcrypt_password_factory
- [`9b359ba`](https://github.com/gamerlogue/web/commit/9b359ba24cccaebbf6b54b1962f01bfc0a57a950) Merge pull request #3459 from jonathantorres/new-line
- [`0cf34a3`](https://github.com/gamerlogue/web/commit/0cf34a3bc00b08c4292d5d4dcf9c531f2356f792) Merge pull request #3465 from jumilla/patch-1
- [`9d82fc6`](https://github.com/gamerlogue/web/commit/9d82fc6007ef6aeea82939472435a6d290069d26) Merge pull request #3467 from andrewhood125/homestead-json
- [`51299e7`](https://github.com/gamerlogue/web/commit/51299e78cdbc1a04b2d8b90fb14838393a08d45b) Merge pull request #3468 from laracasts/patch-1
- [`749bb11`](https://github.com/gamerlogue/web/commit/749bb11ab9e6ff1201c27429c615790c1e820a7a) Merge pull request #3478 from krienow/remove-phpspec-yml
- [`2ddeae9`](https://github.com/gamerlogue/web/commit/2ddeae9c711a4bc7ff9d7eca04a122b9f31d92ec) Merge pull request #3480 from bmitch/JsonErrorMsg
- [`f40e72f`](https://github.com/gamerlogue/web/commit/f40e72fa2fcbe77825d72849f2be59e8e38710aa) Merge pull request #3484 from Zarthus/patch/views-use-https
- [`716e652`](https://github.com/gamerlogue/web/commit/716e65268ae088e5bd73e505acf9695c127aff66) Merge pull request #3491 from laravel/analysis-zObJlq
- [`b1b33c8`](https://github.com/gamerlogue/web/commit/b1b33c852797d7e6d415df23babf41c55dfb5f6b) Merge pull request #3511 from JosephSilber/no-unguard
- [`24575f4`](https://github.com/gamerlogue/web/commit/24575f4b89634bafb59321013eb3bc2eacfa0864) Merge pull request #3500 from pedes42/master
- [`b0a22fc`](https://github.com/gamerlogue/web/commit/b0a22fc51161630c81f20e23a9269b82a369953e) Merge pull request #3501 from crynobone/feature/use-this
- [`69c33f8`](https://github.com/gamerlogue/web/commit/69c33f8928e11b1062592f4300bd28613628f555) Merge pull request #3518 from martinssipenko/phpunit-fix
- [`7568940`](https://github.com/gamerlogue/web/commit/7568940c714c2c06d90f59187546372125cff281) Merge pull request #3536 from bbashy/patch-2
- [`892ab27`](https://github.com/gamerlogue/web/commit/892ab27f8d0f0fc7f46d3a3294d39e2347712606) Merge pull request #3537 from rkgrep/patch-2
- [`e21667f`](https://github.com/gamerlogue/web/commit/e21667f2a6878c395f324c2d4c2e3b41e6b37c17) Merge pull request #3543 from anakadote/master
- [`9ad221b`](https://github.com/gamerlogue/web/commit/9ad221b15c89b15c643dcbe0ad7aac7b420bbc4c) Merge pull request #3547 from laravel/analysis-8b2da8
- [`8611ded`](https://github.com/gamerlogue/web/commit/8611ded0cca010cefbd76abb322aefbb22ce9735) Merge pull request #3558 from GrahamForks/deps
- [`b685435`](https://github.com/gamerlogue/web/commit/b685435eccd659dd25432f5a26a6873200dd261f) Merge pull request #3578 from pulkitjalan/patch-1
- [`270f087`](https://github.com/gamerlogue/web/commit/270f0878a954379ea28045567536b077b59a9db4) Merge pull request #3548 from CupOfTea696/master
- [`8476df5`](https://github.com/gamerlogue/web/commit/8476df5c9eeb1489db64f7aa3456b38ae74d090d) Merge pull request #3551 from arcanedev-maroc/master
- [`091489d`](https://github.com/gamerlogue/web/commit/091489d17b343a105e31e8d7fac4344c16e0dbb6) Merge pull request #3564 from martinbean/patch-1
- [`1fac290`](https://github.com/gamerlogue/web/commit/1fac29099e67bf4e7d748cc398962041e6ad36c3) Merge pull request #3567 from phleobon/patch-1
- [`5cd4ba7`](https://github.com/gamerlogue/web/commit/5cd4ba7255f9999b0a1f5cb5eb45c4bc7506a5d1) Merge pull request #3573 from owen-it/master
- [`7b26399`](https://github.com/gamerlogue/web/commit/7b263997e79ce79ff9292ca9222bbab4da382315) Merge pull request #3570 from anik786/patch-2
- [`49c1a0d`](https://github.com/gamerlogue/web/commit/49c1a0dc44b23e972f995c0eb65609aa2d2a5ade) Merge pull request #3568 from rspahni/patch-1
- [`7f216a4`](https://github.com/gamerlogue/web/commit/7f216a4213123dcee98482e4f2fc754b18cf2f43) Merge pull request #3576 from pulkitjalan/patch-1
- [`90b6578`](https://github.com/gamerlogue/web/commit/90b6578e3e7dd421a1686e95b72ad456f73f38db) Merge pull request #3577 from laravel/revert-3576-patch-1
- [`5d6a3cf`](https://github.com/gamerlogue/web/commit/5d6a3cf2ce50e275d0ac1d3b0f1e82e41b3929f7) Merge pull request #3580 from jspekken/patch-1
- [`1546149`](https://github.com/gamerlogue/web/commit/1546149198d6c75fade1c1964bda0cb3abd449cf) Merge pull request #3591 from laravel/analysis-zdEQ98
- [`6d1bb6d`](https://github.com/gamerlogue/web/commit/6d1bb6d4ed9a984579a0f833e082f1a90e9b0d4e) Merge pull request #3596 from brayniverse/patch-1
- [`54d1845`](https://github.com/gamerlogue/web/commit/54d1845b70080450b7f3263de33b314f83d93640) Merge pull request #3597 from KennedyTedesco/minor-5.2
- [`ad173af`](https://github.com/gamerlogue/web/commit/ad173afa5f3def123df3ea0a3b4073edfe2cf10c) Merge pull request #3601 from vinicius73/master
- [`e6dff08`](https://github.com/gamerlogue/web/commit/e6dff08752745a58501a5c2fd83c1e075b95c440) Merge pull request #3606 from phecho/patch-1
- [`a07fcf2`](https://github.com/gamerlogue/web/commit/a07fcf280373840a6e56fa52abb7946b7aef1441) Merge pull request #3613 from n1c/patch-1
- [`c6931d2`](https://github.com/gamerlogue/web/commit/c6931d266a89efbb59236d6c2c7eca3a208a09a1) Merge pull request #3635 from JacobBennett/patch-1
- [`70355f3`](https://github.com/gamerlogue/web/commit/70355f306606acce1cae759fedbe7dde58de3fff) Merge pull request #3636 from paulvl/master
- [`eb59458`](https://github.com/gamerlogue/web/commit/eb59458d175e757a1e952f552b5eb3c6518a2ab5) Merge pull request #3637 from gaomd/fix-readme
- [`ce7c1fe`](https://github.com/gamerlogue/web/commit/ce7c1fedb39530d31475891f56b834c8eeb77ae0) Merge pull request #3641 from jspringe/fix-envexample
- [`01e3d8f`](https://github.com/gamerlogue/web/commit/01e3d8f28840909f2ac3d0cd32c4989d8e28f064) Merge pull request #3640 from martinbean/patch-1
- [`7aa988d`](https://github.com/gamerlogue/web/commit/7aa988d491435963909ba4a8f31ebfbce03df5bc) Merge pull request #3645 from david-ridgeonnet/patch-1
- [`40f9630`](https://github.com/gamerlogue/web/commit/40f9630449d32d95eaf638974f5d15993a9cfe51) Merge pull request #3658 from martinbean/patch-2
- [`b1ccb8f`](https://github.com/gamerlogue/web/commit/b1ccb8f0de707e0cf6daec0d37a927441c084ede) Merge pull request #3659 from camilorojas/patch-1
- [`770f8a7`](https://github.com/gamerlogue/web/commit/770f8a7453c26e2b6c96ee1adaaadf035e7ca1d9) Merge pull request #3660 from anthonyholmes/master
- [`e4f7ff9`](https://github.com/gamerlogue/web/commit/e4f7ff9ef1cdafbdab9e4bc8b93a74bf51eade2a) Merge pull request #3661 from AdenFraser/AppUrlEnv
- [`413c88f`](https://github.com/gamerlogue/web/commit/413c88f114b7ff637d20a694f1da5249b911f7d1) Merge pull request #3666 from krienow/patch-56c8bf
- [`dec3926`](https://github.com/gamerlogue/web/commit/dec392623ace11469b5252f93d51438f7c247c8f) Merge pull request #3668 from lucasmichot/feature/master/eof
- [`aa07b0c`](https://github.com/gamerlogue/web/commit/aa07b0c6999102bbd4eab74376d71ed0ec1a6454) Merge pull request #3670 from SammyK/password-column-fix
- [`83fd3f2`](https://github.com/gamerlogue/web/commit/83fd3f29e7fa5f65a6aa52d3d2b5821cbe3729f0) Merge pull request #3672 from themsaid/add-language-line-for-present-validation-rule
- [`7093812`](https://github.com/gamerlogue/web/commit/7093812f807d3292194e80a5f01886d2ed4729a4) Merge pull request #3674 from themsaid/language-for-distinct
- [`fc12337`](https://github.com/gamerlogue/web/commit/fc12337663642b626de0e8c2e7f728f3e6f2208e) Merge pull request #3675 from yava9221/master
- [`f748799`](https://github.com/gamerlogue/web/commit/f74879938f3c83b4e2d52483b02d391313a6bdad) Merge pull request #3678 from themsaid/add-land-line-for-in_array
- [`0da3df2`](https://github.com/gamerlogue/web/commit/0da3df2afc22a305ad171be4ffe0ac2d49ae5b4d) Merge pull request #3682 from jadjoubran/patch-1
- [`4f4d378`](https://github.com/gamerlogue/web/commit/4f4d378d6a321934a1ab03732de116ed7604350c) Merge pull request #3685 from JosephSilber/multi-auth
- [`b1b524d`](https://github.com/gamerlogue/web/commit/b1b524d78b3910956c62d633dffbe993b05c94f0) Merge pull request #3718 from JosephSilber/default-auth-driver
- [`91c6e71`](https://github.com/gamerlogue/web/commit/91c6e716773d379ecaecc97a9e7183e0970b63b1) Merge pull request #3687 from barryvdh/patch-1
- [`a925d6c`](https://github.com/gamerlogue/web/commit/a925d6c9fde9c70dd95cb8e378a633ed3752034f) Merge pull request #3692 from guilhermegonzaga/patch-1
- [`80240e9`](https://github.com/gamerlogue/web/commit/80240e9b9ed1442d400a4db5fa85368b9f72ac55) Merge pull request #3690 from kevinsimard/master
- [`34d2509`](https://github.com/gamerlogue/web/commit/34d2509e84bff9d4ca244626543354a6e795b853) Merge pull request #3702 from laravel/analysis-XZl3KP
- [`1c43882`](https://github.com/gamerlogue/web/commit/1c43882c823cbe749db7666cb80b6e40a32d955e) Merge pull request #3701 from laravel/analysis-87anp3
- [`cd0a902`](https://github.com/gamerlogue/web/commit/cd0a902061681d543e2ea349a2c8b4f51381a10b) Merge pull request #3698 from dakira/master
- [`8edf580`](https://github.com/gamerlogue/web/commit/8edf58030ecdbfc521a415cc9bd42b7b2b28cfe9) Merge pull request #3709 from MadMikeyB/patch-1
- [`3fc105d`](https://github.com/gamerlogue/web/commit/3fc105d3d409daf20fe646db79d5995f4ba893e8) Merge pull request #3699 from barryvdh/patch-1
- [`32318c3`](https://github.com/gamerlogue/web/commit/32318c385a3e851600bd3b7a2a624f74b2f46ee5) Merge pull request #3726 from laravel/patch
- [`72581c0`](https://github.com/gamerlogue/web/commit/72581c0b984f8ddec1e1c6845c28b6abb37c854f) Merge pull request #3723 from JosephSilber/authorize-middleware
- [`5450b31`](https://github.com/gamerlogue/web/commit/5450b3180f5bd75cc1117248f8fe70fd12ba57e1) Merge pull request #3725 from laravel/phpunit
- [`933e6c6`](https://github.com/gamerlogue/web/commit/933e6c61eb7aa012cb68d31d91188862f3aa801a) Merge pull request #3730 from laravel/typo
- [`9fa63f8`](https://github.com/gamerlogue/web/commit/9fa63f8ce856ec4b5c7869cd5cd597b66590ea38) Merge pull request #3733 from jcxm360/patch-1
- [`b2ca69f`](https://github.com/gamerlogue/web/commit/b2ca69f31843ece0f1bf29c7099591c2a4b16ec8) Merge pull request #3737 from laravel/tweak
- [`d359343`](https://github.com/gamerlogue/web/commit/d359343ca2fadfa0af24a5e7881f847eedf764df) Merge pull request #3760 from tillkruss/patch-1
- [`eee2a8b`](https://github.com/gamerlogue/web/commit/eee2a8b7c8de7b9ac8698270defe943e584ed2a4) Merge pull request #3763 from vinkla/npm
- [`3173f1c`](https://github.com/gamerlogue/web/commit/3173f1c072b76a554fedd4d3553819314aeec8fc) Merge pull request #3768 from tomcastleman/patch-1
- [`f8cddc0`](https://github.com/gamerlogue/web/commit/f8cddc00000d29087cae784e2685bac5545848f4) Merge pull request #3770 from tillkruss/patch-2
- [`6f4c333`](https://github.com/gamerlogue/web/commit/6f4c333678f9ab448b5126356c29792682f9c3c5) Merge pull request #3777 from Adam14Four/develop
- [`37ce8b5`](https://github.com/gamerlogue/web/commit/37ce8b50ce8af59b1d6e74d871d4e298e80ac687) Merge pull request #3778 from scrubmx/patch-3
- [`e98a270`](https://github.com/gamerlogue/web/commit/e98a2708bcfd4b9d4338c5f2887e29ea0c333d58) Merge pull request #3780 from laravel/analysis-8LZ3WJ
- [`2ed45eb`](https://github.com/gamerlogue/web/commit/2ed45ebb5cb65e112d964fdc8e216545d50cd2be) Merge pull request #3781 from laravel/bindings
- [`3ddaf3f`](https://github.com/gamerlogue/web/commit/3ddaf3f901fefd1b17c782472542c3462a9b8430) Merge pull request #3783 from JosephSilber/authenticate
- [`233c93f`](https://github.com/gamerlogue/web/commit/233c93f8105de7808a4f45c0b9ff8a1226efe2b1) Merge pull request #3787 from JosephSilber/core-authenticate
- [`f95f384`](https://github.com/gamerlogue/web/commit/f95f384ba36b2bb86384061782a1d9225ddf5087) Merge pull request #3791 from JosephSilber/authorize-namespace
- [`0d762a2`](https://github.com/gamerlogue/web/commit/0d762a22da6d90b6c5377d385c26caab41b0651e) Merge pull request #3775 from themsaid/dimensions-lang-line
- [`b6b948a`](https://github.com/gamerlogue/web/commit/b6b948aaf750f5f074cbf45289cac1621617189b) Merge pull request #3767 from sadika9/fix_password_reset_guest_middleware
- [`b402405`](https://github.com/gamerlogue/web/commit/b4024058bb87f77f73192890b656e7eb113730d4) Merge pull request #3789 from luqmanrom/master
- [`bee4dc1`](https://github.com/gamerlogue/web/commit/bee4dc163226b70c69f66ecda8e29f5981021885) Merge pull request #3799 from drawmyattention/patch-1
- [`bd358bd`](https://github.com/gamerlogue/web/commit/bd358bdc0f3d9b0d4a63fc2df1942dac8be6d644) Merge pull request #3815 from vlakoff/pdo-fetch-style
- [`51addd6`](https://github.com/gamerlogue/web/commit/51addd6c63aaa06fb63a3081dea47d66ce6397ef) Merge pull request #3817 from JosephSilber/unauthenticated-json
- [`c0898cc`](https://github.com/gamerlogue/web/commit/c0898cc71a85f9f9df3c7bd47fb56181297aed89) Merge pull request #3823 from crynobone/feature/notification
- [`47d7e2d`](https://github.com/gamerlogue/web/commit/47d7e2d490c969a91d8aaad735bf36b5dba53bfa) Merge pull request #3811 from jerguslejko/fix/supported-drivers-docs
- [`6e380aa`](https://github.com/gamerlogue/web/commit/6e380aa8f2a4c1b4bc68174a56c0b83bc279c3a3) Merge pull request #3820 from sbine/master
- [`d6ca0a6`](https://github.com/gamerlogue/web/commit/d6ca0a6dc6f0bd44787b122cbed14568f77bb2b3) Merge pull request #3819 from jrean/patch-1
- [`2051351`](https://github.com/gamerlogue/web/commit/20513516265df20e0107a5cfd04aa561d1ac7ad8) Merge pull request #3822 from halaei/expire-90
- [`ba1e9ad`](https://github.com/gamerlogue/web/commit/ba1e9ad8287a80a717a371acb5102c5d0e2d153f) Merge pull request #3824 from byCedric/master
- [`98ca59d`](https://github.com/gamerlogue/web/commit/98ca59dc8ca553ceaf654275b350a1e7157c2d03) Merge pull request #3826 from ngyikp/master
- [`db5d228`](https://github.com/gamerlogue/web/commit/db5d228f2bb3efe27d76eb7a27aa53a1cada66a8) Merge pull request #3831 from laravel/analysis-XW6KOy
- [`94c9db2`](https://github.com/gamerlogue/web/commit/94c9db25c3168ff58bd36cc18defe088ebeefc1f) Merge pull request #3717 from mauri870/5.1
- [`70f8bb6`](https://github.com/gamerlogue/web/commit/70f8bb6e08f0232c306826282b995bb5670a0efa) Merge pull request #3738 from laravel/backport
- [`e34ac8c`](https://github.com/gamerlogue/web/commit/e34ac8cb308f888b2bd8a7238ed3824cb5c8dcd5) Merge pull request #3833 from KennedyTedesco/5.3-provider
- [`9cce61b`](https://github.com/gamerlogue/web/commit/9cce61be27cc327aff4704e97057f612ccfa1bab) Merge pull request #3839 from PascaleBeier/develop
- [`5658575`](https://github.com/gamerlogue/web/commit/56585752121d8fb60106536f7d169e9d4b2b4415) Merge pull request #3840 from hikouki/master
- [`9f93004`](https://github.com/gamerlogue/web/commit/9f9300442dfedd0cfcc2d565ab0f9cdf804d91e1) Merge pull request #3842 from spyric/develop
- [`4c6abcd`](https://github.com/gamerlogue/web/commit/4c6abcd17d9a0479bd0bd0ce4018b2018a3cd889) Merge pull request #3845 from mayoz/patch-3
- [`133bd9d`](https://github.com/gamerlogue/web/commit/133bd9ddd2f0877046435d73b5466d46c628dc2b) Merge pull request #3841 from ac1982/patch-1
- [`f242112`](https://github.com/gamerlogue/web/commit/f2421123e3df8fc9de8c2df9a0d75e7257787219) Merge pull request #3850 from crynobone/default-app-key
- [`14f79f1`](https://github.com/gamerlogue/web/commit/14f79f19e34f398d3f16dd24db24af1400068502) Merge pull request #3855 from BartHuis/patch-1
- [`dfb33e2`](https://github.com/gamerlogue/web/commit/dfb33e245d4f7a8fb19783b255df398ea504cdf0) Merge pull request #3857 from laravel/analysis-qMe1Y4
- [`3b2f29e`](https://github.com/gamerlogue/web/commit/3b2f29ec26488e3fd677af1dc1e8015f7af513e0) Merge pull request #3853 from jackmcdade/develop
- [`6709c69`](https://github.com/gamerlogue/web/commit/6709c69f3c23115090e38a5919fa14943406226d) Merge pull request #3858 from laravel/analysis-XV0reP
- [`6e91cc6`](https://github.com/gamerlogue/web/commit/6e91cc6ad36d1bd045c1e3a1342d6b784a628b9e) Merge pull request #3861 from laravel/revert-3853-develop
- [`de80aad`](https://github.com/gamerlogue/web/commit/de80aad4ce4f0e26e43f976ee6f2787b4ece4bd4) Merge pull request #3854 from jhoff/phpmd_compliance
- [`1426bdd`](https://github.com/gamerlogue/web/commit/1426bdda4043cd9370ca2414634985ce96d428e7) Merge pull request #3864 from laravel/analysis-8KgoeQ
- [`1b126d0`](https://github.com/gamerlogue/web/commit/1b126d09821e469baab33ec2085ebcc850afeddd) Merge pull request #3865 from svenluijten/javascript-docblock-missing-word
- [`b69e85c`](https://github.com/gamerlogue/web/commit/b69e85c2452612295e45bae2259e71d3d2d66247) Merge pull request #3868 from tillkruss/patch-3
- [`e49c8ae`](https://github.com/gamerlogue/web/commit/e49c8aeb05ad72b48eab174ecd1f1256ac1e5088) Merge pull request #3867 from JosephSilber/remove-requests
- [`7bb7ade`](https://github.com/gamerlogue/web/commit/7bb7adef0644950d0b73f776979539b453eaccc6) Merge pull request #3870 from diogoazevedos/arrow-functions
- [`e79c0d2`](https://github.com/gamerlogue/web/commit/e79c0d222d7205b5c3091c4f7b19b763840a5c7d) Merge pull request #3871 from diogoazevedos/use-const
- [`583fd4e`](https://github.com/gamerlogue/web/commit/583fd4ed4f9ce3c33005e78e73b60f0f5e462c37) Merge pull request #3872 from donnes/patch-1
- [`40e9d60`](https://github.com/gamerlogue/web/commit/40e9d60e887633bf7fdc207af2bf79b3f7cd4fbf) Merge pull request #3877 from balping/patch-1
- [`86676aa`](https://github.com/gamerlogue/web/commit/86676aa02e190cc914ae132f4b7245f3f09eae1f) Merge pull request #3878 from tillkruss/patch-4
- [`9fb8af1`](https://github.com/gamerlogue/web/commit/9fb8af19d72274ed0d78e51350e3ae684f31e7a6) Merge pull request #3881 from BrandonSurowiec/patch-4
- [`57b57bf`](https://github.com/gamerlogue/web/commit/57b57bf1b3158737e0aa058471823b23097ef7a6) Merge pull request #3880 from BrandonSurowiec/patch-2
- [`e596cef`](https://github.com/gamerlogue/web/commit/e596cef035836c82b2a7bb208eedf96a7997898d) Merge pull request #3889 from adriaanzon/patch-1
- [`d84c499`](https://github.com/gamerlogue/web/commit/d84c4990fd8318d4504c8974a8c9fa33a23ad6ea) Merge pull request #3891 from socieboy/develop
- [`a2c075b`](https://github.com/gamerlogue/web/commit/a2c075bd3019908debf3072739491324df082c37) Merge pull request #3894 from adamwathan/53-precomputed-hash
- [`e959c22`](https://github.com/gamerlogue/web/commit/e959c228400341d4f2f8812606a0b16d740a2f2d) Merge pull request #3899 from heruputra/patch-1
- [`b6a1152`](https://github.com/gamerlogue/web/commit/b6a1152baf0b31417ef0fce630fd4e2af80eb823) Merge pull request #3856 from laravel/analysis-zGgD5r
- [`982e769`](https://github.com/gamerlogue/web/commit/982e769d2aaa9b8a4121ac933ee1360246a43a3f) Merge pull request #3874 from lancepioch/patch-1
- [`362383d`](https://github.com/gamerlogue/web/commit/362383d7c59555002806cd9b8ec7ec1368dc24db) Merge pull request #3904 from scrubmx/patch-5
- [`de81dd3`](https://github.com/gamerlogue/web/commit/de81dd38d11ad991b1577a8cdf10a112ada77c6e) Merge pull request #3906 from greabock/patch-1
- [`63e0cdc`](https://github.com/gamerlogue/web/commit/63e0cdc493a0ddc217ed7c3f70043ef7cf907fd9) Merge pull request #3909 from Rkallenkoot/patch-1
- [`1cb19ac`](https://github.com/gamerlogue/web/commit/1cb19ac9119fbe59601ede3e039df81aa2252615) Merge pull request #3910 from restored18/master
- [`d7fb66c`](https://github.com/gamerlogue/web/commit/d7fb66ca9bd22b82961b774898d74f2d2935cd2e) Merge pull request #3914 from dersvenhesse/patch-1
- [`07360db`](https://github.com/gamerlogue/web/commit/07360db40aa6b74c399d06744a8a2d95e0e818b6) Merge pull request #3913 from ngyikp/master
- [`c92c724`](https://github.com/gamerlogue/web/commit/c92c724dbfe75c154838bb5b387d80464cec8804) Merge pull request #3921 from jackmu95/add-mimetypes-translation
- [`a70dd56`](https://github.com/gamerlogue/web/commit/a70dd5622bbf0ef8725126be75657091a22db5cb) Merge pull request #3923 from fernandobandeira/patch-1
- [`a4b53b3`](https://github.com/gamerlogue/web/commit/a4b53b394c29373d7ab9b061a1c6b1bb147e3b28) Merge pull request #3922 from jasonmccreary/https-only-cookie-env
- [`7f06559`](https://github.com/gamerlogue/web/commit/7f06559971cd17f8675c2c4f9898da4a71e743dd) Merge pull request #3929 from bryceadams/patch-map-api-before-web
- [`93d92bb`](https://github.com/gamerlogue/web/commit/93d92bbb9e41f287a1c16079424c48705a44a8a2) Merge pull request #3942 from ramondj/patch-1
- [`f777e89`](https://github.com/gamerlogue/web/commit/f777e894d9c6d4d88d5067cf40e75fdee32bcd5a) Merge pull request #3951 from krienow/patch-d57d11
- [`f4606d2`](https://github.com/gamerlogue/web/commit/f4606d2bb94dc9579488df61fa3744b17e91be62) Merge pull request #3957 from WayneHarris/vue-resource
- [`421b210`](https://github.com/gamerlogue/web/commit/421b210a77ced53a4b0118b4e751e36f1bed5921) Merge pull request #3987 from barryvdh/patch-2
- [`a2df28f`](https://github.com/gamerlogue/web/commit/a2df28face78e88c8f4ac430816fca5443f7ed35) Merge pull request #3988 from arcanedev-maroc/patch-1
- [`5dc817b`](https://github.com/gamerlogue/web/commit/5dc817bf55598fda017e3b7f39957447bda94846) Merge pull request #3994 from craigpaul/master
- [`38ba328`](https://github.com/gamerlogue/web/commit/38ba3280cc74486cf68efba2738e5fe4a8db0144) Merge pull request #3996 from jehadassaf/patch-1
- [`472d6ae`](https://github.com/gamerlogue/web/commit/472d6ae508174831089b0ac0a417aaf438ee82bb) Merge pull request #4000 from zaknes/master
- [`1905c96`](https://github.com/gamerlogue/web/commit/1905c965eb241fc3409cec83ba4dfcde8ff16190) Merge pull request #4004 from diogoazevedos/schema-drop
- [`7a851c7`](https://github.com/gamerlogue/web/commit/7a851c75d95a1e7eacaf007f9b54ee7014a42890) Merge pull request #4005 from carlosmtrinidad/master
- [`5b78106`](https://github.com/gamerlogue/web/commit/5b7810680d6c1fee9fff43cf246f5278efbd6360) Merge pull request #4001 from RonMelkhior/master
- [`fdef1b6`](https://github.com/gamerlogue/web/commit/fdef1b6fbe5ae476d9437b2cbd57a283c653d9b1) Merge pull request #4007 from vinkla/patch-1
- [`3437566`](https://github.com/gamerlogue/web/commit/3437566d66898f698fe1be1a68603064eef17a61) Merge pull request #4008 from vinkla/patch-1
- [`7479a8b`](https://github.com/gamerlogue/web/commit/7479a8b920a7b14684d546a9d81e8e2819ff8fa4) Merge pull request #4019 from jirehstudios/master
- [`bc08030`](https://github.com/gamerlogue/web/commit/bc08030b301a7f84bf3ce9ce83b346dca778b717) Merge pull request #4023 from lkmadushan/formatting-web-routes
- [`61b157f`](https://github.com/gamerlogue/web/commit/61b157f8090bfd69246a9237b3b99edc99939847) Merge pull request #4067 from JosephSilber/fluent-routes
- [`b5ae7af`](https://github.com/gamerlogue/web/commit/b5ae7aff9f9953af0cae205fb749f7aa7bb9fed6) Merge pull request #4068 from yuters/patch-1
- [`673f110`](https://github.com/gamerlogue/web/commit/673f110456bb919e89703788fcfe1024c1edb0c9) Merge pull request #4069 from JosephSilber/route-groups
- [`cddb8a2`](https://github.com/gamerlogue/web/commit/cddb8a254af3ee56f75ccfbca5890f50dd945b45) Merge pull request #4036 from danieliancu/patch-1
- [`be90d3f`](https://github.com/gamerlogue/web/commit/be90d3fa1ba7d75f34cc5f45a7552fd271724b4b) Merge pull request #4045 from DojoGeekRA/patch-1
- [`038ae10`](https://github.com/gamerlogue/web/commit/038ae10ae7c25b28d8fe7ae08af237a932a6f6ab) Merge pull request #4046 from diogoazevedos/master
- [`b122f77`](https://github.com/gamerlogue/web/commit/b122f775e9c2c618d08829e7b18feb9b4baf9bbb) Merge pull request #4051 from lokielse/master
- [`fc3b4d1`](https://github.com/gamerlogue/web/commit/fc3b4d161ff9d5a276221dc50ffdddaf6753510d) Merge pull request #4052 from laravel/analysis-qomWEg
- [`6645cae`](https://github.com/gamerlogue/web/commit/6645cae8597f1d25f96ffd98793f160979e9403e) Merge pull request #4053 from mattmcdonald-uk/master
- [`cffcc49`](https://github.com/gamerlogue/web/commit/cffcc4932da6384fbbf54f19006b151af2e449c6) Merge pull request #4055 from themsaid/weakdateroles
- [`4c6e477`](https://github.com/gamerlogue/web/commit/4c6e477131f22ae1e75bb133caa9ad82f0ea413d) Merge pull request #4059 from insoutt/insoutt-patch-1
- [`d1ba0c3`](https://github.com/gamerlogue/web/commit/d1ba0c3d0d8fce35cb03c0b0593cb7e3c35c70d1) Merge pull request #4066 from damiencriado/patch-1
- [`83b76a7`](https://github.com/gamerlogue/web/commit/83b76a7f8bdd1daabcc87fa525658b6d98f53566) Merge pull request #4074 from driesvints/patch-1
- [`df1298b`](https://github.com/gamerlogue/web/commit/df1298bfccf3f1e3dc9291cefd2dbd58bdbe4f85) Merge pull request #4084 from laravel/mail
- [`b748931`](https://github.com/gamerlogue/web/commit/b748931666b24428db808e3c37b315f2af70f91f) Merge pull request #4083 from laravel/tinker
- [`7bb56ef`](https://github.com/gamerlogue/web/commit/7bb56eff6accf3616a7196afe5d92c1bd96f0cc6) Merge pull request #4093 from TheoKouzelis/fix/pusher-config
- [`1a48254`](https://github.com/gamerlogue/web/commit/1a48254e8343506fcc0e2f6f82c4596ad3f612d1) Merge pull request #4095 from laravel/revert-4093-fix/pusher-config
- [`a6d2034`](https://github.com/gamerlogue/web/commit/a6d2034c91db55a6dbebee12be14ccc658f19d98) Merge pull request #4098 from KennedyTedesco/compiled-5.4
- [`4abe343`](https://github.com/gamerlogue/web/commit/4abe343ab96b479c9353ebe71682368e8960dce2) Merge pull request #4102 from TheoKouzelis/fix/pusher-config-names
- [`182c889`](https://github.com/gamerlogue/web/commit/182c889736814128d36627f2f51f7b016fff1737) Merge pull request #4110 from laravel/fix
- [`fa7d9df`](https://github.com/gamerlogue/web/commit/fa7d9df4369485832a58302e9b3d7553234ff5ee) Merge pull request #4111 from diogoazevedos/patch-2
- [`d9f54e3`](https://github.com/gamerlogue/web/commit/d9f54e3454b4cbbc7b614970c9f5d48e440f3957) Merge pull request #4113 from laravel/yarn-fix
- [`f1430ce`](https://github.com/gamerlogue/web/commit/f1430cedce84b26c0918d7f84edba71df702e799) Merge pull request #4114 from yuters/patch-2
- [`99ec094`](https://github.com/gamerlogue/web/commit/99ec094434c7ead2d3eecede1961eac93db077e8) Merge pull request #4115 from ericdowell/ericdowell-patch-1
- [`8c6e40c`](https://github.com/gamerlogue/web/commit/8c6e40caeec7da0d0ef7c82c29785fbe76a20362) Merge pull request #4117 from fzoske/windows-fix
- [`547bb96`](https://github.com/gamerlogue/web/commit/547bb962f979f4b5c540f3aae21a039053ea08a6) Merge pull request #4121 from jpmurray/patch-1
- [`1e68597`](https://github.com/gamerlogue/web/commit/1e6859799bec1190fae12025301b199e79914054) Merge pull request #4124 from vantoozz/vantoozz-patch-1
- [`d0c5c04`](https://github.com/gamerlogue/web/commit/d0c5c041f266463174a6f8aca21e8bf75b224a5e) Merge pull request #4126 from timgws/patch-1
- [`7a44ebe`](https://github.com/gamerlogue/web/commit/7a44ebefe3f3220d873c630ce956671b497c89bc) Merge pull request #4128 from monomichael/master
- [`64bea7c`](https://github.com/gamerlogue/web/commit/64bea7ca71b6f8b6ed9fe8c2757b295468a31e04) Merge pull request #4129 from laravel/revert-4126-patch-1
- [`1306ff2`](https://github.com/gamerlogue/web/commit/1306ff25832a84ab7570c79637b9f6c161142886) Merge pull request #4130 from atefBB/patch-1
- [`1f4bf24`](https://github.com/gamerlogue/web/commit/1f4bf240a6645fa1953d077c1f752f453e3c4d5b) Merge pull request #4131 from crynobone/patch-1
- [`6574b9d`](https://github.com/gamerlogue/web/commit/6574b9dd759e5e89735f1ba3bcbfbf4aa114cec7) Merge pull request #4133 from luisdalmolin/master
- [`d2d8912`](https://github.com/gamerlogue/web/commit/d2d89124e69511887abe1d20d8cc7d7411cbbdee) Merge pull request #4135 from laravel/analysis-qJgPYE
- [`f0f1a13`](https://github.com/gamerlogue/web/commit/f0f1a13f61b9b024427b2348c7bbedf4994f58ef) Merge pull request #4136 from ahmed3mar/patch-1
- [`6dbde06`](https://github.com/gamerlogue/web/commit/6dbde06814f5c47d19dfae6d1020f0e197f0998d) Merge pull request #4138 from rickbolton/master
- [`9b02e5f`](https://github.com/gamerlogue/web/commit/9b02e5fab8a42bcf4146981d2a6b6a82f5775b68) Merge pull request #4141 from coolpraz/patch-1
- [`da9760f`](https://github.com/gamerlogue/web/commit/da9760fd090122af721c6d4673e6103facfec415) Merge pull request #4143 from kneipp/master
- [`c1643bf`](https://github.com/gamerlogue/web/commit/c1643bf0c59b6864fc55e09cce3bfafc67d29e2a) Merge pull request #4151 from laravel/fix
- [`9550569`](https://github.com/gamerlogue/web/commit/95505693a28623ae69bf3b2776ab7ea18c677e5e) Merge pull request #4157 from driesvints/patch-1
- [`9ce2f8e`](https://github.com/gamerlogue/web/commit/9ce2f8ebc9255eacb469950515606ac6cc638126) Merge pull request #4162 from eklundkristoffer/crossenv
- [`d0a6dbf`](https://github.com/gamerlogue/web/commit/d0a6dbf1a224745df3ea6a5fc57c319e086bde4a) Merge pull request #4165 from zlatevbg/use-consistent-config-paths
- [`4a7130e`](https://github.com/gamerlogue/web/commit/4a7130e31b26bd0a02f597b3dc4bc6d70647130a) Merge pull request #4167 from driesvints/fix-cross-env-bin
- [`f78d324`](https://github.com/gamerlogue/web/commit/f78d324cb279c15dd103cf4cd4dd90a9d6dde068) Merge pull request #4174 from kossa/upgrade-mix
- [`7b21471`](https://github.com/gamerlogue/web/commit/7b214719de5bf821bac0da3856c55ee4459f6d50) Merge pull request #4177 from al0mie/al0mie-patch-1
- [`e3e65bc`](https://github.com/gamerlogue/web/commit/e3e65bcc63d3bd3c73c20c1ceac1325e4786cf23) Merge pull request #4179 from bshaffer/add-socket-to-database-config
- [`94895da`](https://github.com/gamerlogue/web/commit/94895dae1d1cd2e25708717a7b20709d2e569c7c) Merge pull request #4182 from bbashy/patch-1
- [`10d31c6`](https://github.com/gamerlogue/web/commit/10d31c6db9e7e7a78f5aa58afe2e8815c4affc7a) Merge pull request #4180 from halaei/unindex-token
- [`e6ed1ba`](https://github.com/gamerlogue/web/commit/e6ed1ba352a5a5bc1c26364a1876f3b08daedf76) Merge pull request #4184 from JuanDMeGon/patch-1
- [`6c99494`](https://github.com/gamerlogue/web/commit/6c9949435ead2722bb231456c555604764e98c62) Merge pull request #4187 from lioannou/patch-1
- [`6ca414a`](https://github.com/gamerlogue/web/commit/6ca414a2c0bc0ba4228a351a8d53cf3f11a4edbe) Merge pull request #4188 from themsaid/laravelMix
- [`97d6b9c`](https://github.com/gamerlogue/web/commit/97d6b9c84b8185d2163ac109909a5a1bdde301be) Merge pull request #4189 from tabuna/patch-1
- [`fa6c017`](https://github.com/gamerlogue/web/commit/fa6c017c1f87879998e6bcb726b701f2bb933b4c) Merge pull request #4186 from tillkruss/patch-1
- [`71b2220`](https://github.com/gamerlogue/web/commit/71b222056e7feff80f342cf032bde53a5fb1463d) Merge pull request #4191 from daylerees/add-vagrant-to-ignore
- [`4bb2a5a`](https://github.com/gamerlogue/web/commit/4bb2a5af3218239c235f4bc683641c2fa0e07c88) Merge pull request #4190 from michaeldyrynda/master
- [`648a646`](https://github.com/gamerlogue/web/commit/648a646bb553280eaf861f7a83cabff711f9ff9e) Merge pull request #4193 from KristofMorva/npm-windows
- [`e3fa20f`](https://github.com/gamerlogue/web/commit/e3fa20fc807e9c098bb9aa62282374c9772ddde3) Merge pull request #4196 from DojoGeekRA/patch-1
- [`b79765f`](https://github.com/gamerlogue/web/commit/b79765f3d36bff03845fa576385fa4f32d543460) Merge pull request #4204 from mdavis1982/make-app-name-configurable
- [`14ef045`](https://github.com/gamerlogue/web/commit/14ef0452030d7a430bc49d15e3d94f0ebdf7f6b7) Merge pull request #4203 from KristofMorva/sort-gitignore
- [`3187f09`](https://github.com/gamerlogue/web/commit/3187f09e016ab02d6e861060a52b5c93acda7c34) Merge pull request #4208 from misenhower/fix-axios-defaults
- [`471bcd0`](https://github.com/gamerlogue/web/commit/471bcd09a5bfcc92634db84992d5a78e687027f9) Merge pull request #4212 from laurencei/patch-1
- [`f2c01a5`](https://github.com/gamerlogue/web/commit/f2c01a5fce1b54645e02e0a2974892b4b9054a51) Merge pull request #4229 from ebuster/patch-1
- [`65bcea3`](https://github.com/gamerlogue/web/commit/65bcea3ed32ec19e46cc0f42748e620d3d1f8e0e) Merge pull request #4232 from JuanDMeGon/patch-1
- [`7b2c583`](https://github.com/gamerlogue/web/commit/7b2c5834b462e9d5e5042925ba9d2cfc8e19bfbb) Merge pull request #4234 from tillkruss/master
- [`6951ff3`](https://github.com/gamerlogue/web/commit/6951ff37ddd4080aeee33a0628315ccde6982b2d) Merge pull request #4236 from caiquecastro/master
- [`3c6361b`](https://github.com/gamerlogue/web/commit/3c6361b6fd416bb35b006b4345e8999c3836d65f) Merge pull request #4241 from B-07/patch-2
- [`2c63bb5`](https://github.com/gamerlogue/web/commit/2c63bb5dc89b97068bc8d5653a17b0feb46c758f) Merge pull request #4240 from B-07/patch-1
- [`038cf84`](https://github.com/gamerlogue/web/commit/038cf84a934ec898228cd459bce03671fc5fe3c3) Merge pull request #4244 from B-07/patch-5
- [`8eadc9a`](https://github.com/gamerlogue/web/commit/8eadc9a58f62d37b891946fe9dbf069595b3e720) Merge pull request #4247 from laurencei/patch-1
- [`9ecb144`](https://github.com/gamerlogue/web/commit/9ecb144c0e32f54c61adef9452e2d6b66d963ed4) Merge pull request #4253 from insign/patch-1
- [`96090ea`](https://github.com/gamerlogue/web/commit/96090eaac0513a0813c2536c8c39967f23e383f6) Merge pull request #4254 from FrittenKeeZ/patch-1
- [`f6ebbbc`](https://github.com/gamerlogue/web/commit/f6ebbbc4a6cbc01ee083a9f45a94407c9584a75f) Merge pull request #4261 from mhayes14/master
- [`d069b52`](https://github.com/gamerlogue/web/commit/d069b52c19158824edeaac488cf004469556f6ea) Merge pull request #4268 from borisdamevin/patch-1
- [`e2624a6`](https://github.com/gamerlogue/web/commit/e2624a6d70c60b42dbecadf01f52f109aab6f6c8) Merge pull request #4279 from adiachenko/testsuite_names
- [`b4af9b6`](https://github.com/gamerlogue/web/commit/b4af9b69b07ae2652c69174acd011908a85a44ac) Merge pull request #4282 from m1guelpf/patch-1
- [`de8f228`](https://github.com/gamerlogue/web/commit/de8f2287b6a97673c42061b1e1adcd415b26cc1c) Merge pull request #4283 from laravel/mix-patch
- [`b13ef0f`](https://github.com/gamerlogue/web/commit/b13ef0fa3cc3a3f448351240c09e3c0eebf8a129) Merge pull request #4287 from laravel/top-secret-add-quotes-patch
- [`3e19ef9`](https://github.com/gamerlogue/web/commit/3e19ef9b1d7ffbd34cb57b77bd955c95f75f6dae) Merge pull request #4294 from ovanschie/patch-1
- [`f614da3`](https://github.com/gamerlogue/web/commit/f614da3708e16d659e32e48c60e178fa17914a58) Merge pull request #4299 from lucasmichot/feature/master/npm-packages
- [`b208fde`](https://github.com/gamerlogue/web/commit/b208fde08c512c2d735b781f841744640377d016) Merge pull request #4311 from lucasmichot/feature/master/docblock
- [`d9c34d5`](https://github.com/gamerlogue/web/commit/d9c34d550b43b74d3d49fa3920dd8af348b0c7ff) Merge pull request #4322 from kauhat/patch-1
- [`d8e31e8`](https://github.com/gamerlogue/web/commit/d8e31e8afbcc91e6dee59ed94d5f14b1bccc6e96) Merge pull request #4340 from garygreen/remove-migrations-classmap
- [`068f563`](https://github.com/gamerlogue/web/commit/068f5638780dd22d62f3872065da563d59095025) Merge pull request #4347 from balping/patch-1
- [`15beb11`](https://github.com/gamerlogue/web/commit/15beb117236ca7b62feaabcf01bb1df6d529d1c4) Merge pull request #4349 from pierreneter/patch-1
- [`3a0de29`](https://github.com/gamerlogue/web/commit/3a0de296a7bfae18a98fe5b493cf44914b1865be) Merge pull request #4351 from pierreneter/revert-4349-patch-1
- [`44f65b0`](https://github.com/gamerlogue/web/commit/44f65b02bc04833d138168ebfff457c1de13341a) Merge pull request #4350 from Te7a-Houdini/AddAuthDirective
- [`34b1aac`](https://github.com/gamerlogue/web/commit/34b1aac73df81dbe5308f0aebd3c3c2c0d3714a2) Merge pull request #4368 from keving91/patch-1
- [`6cec528`](https://github.com/gamerlogue/web/commit/6cec528fc71ff8dd248440a8995801b142b9b571) Merge pull request #4375 from decadence/patch-1
- [`ab56f32`](https://github.com/gamerlogue/web/commit/ab56f323aa6ac59df1e58ad4b516711e237c8ef5) Merge pull request #4383 from scrubmx/patch-8
- [`4f8961c`](https://github.com/gamerlogue/web/commit/4f8961cc0e8e0acef486f71f600b99a6ea4ae4a3) Merge pull request #4219 from laravel/analysis-X0W3an
- [`ede7d29`](https://github.com/gamerlogue/web/commit/ede7d2993d4fea2ca590da0bdb53788a1fed5ed0) Merge pull request #4226 from diogoazevedos/develop
- [`dfb7393`](https://github.com/gamerlogue/web/commit/dfb7393c008061f2d84350d70b1b42603a2c7349) Merge pull request #4227 from joshmanders/patch-1
- [`fc966ae`](https://github.com/gamerlogue/web/commit/fc966ae4e72fe83ba6f9a282392045e9839acd6f) Merge pull request #4278 from m1guelpf/patch-2
- [`2ab2e6a`](https://github.com/gamerlogue/web/commit/2ab2e6accdfb0b5b4dd86f13c6cb554305a2de80) Merge pull request #4275 from themsaid/updateAuthJSONError
- [`62de91d`](https://github.com/gamerlogue/web/commit/62de91dd416f1e1f0c47666a1d272c9776a6076d) Merge pull request #4302 from bretterer/fix_trusted_proxies
- [`6a5e243`](https://github.com/gamerlogue/web/commit/6a5e243e98fafb5eeb4446bb4997d625a4985874) Merge pull request #4333 from DCzajkowski/develop
- [`3ebb0f8`](https://github.com/gamerlogue/web/commit/3ebb0f8ebde87c2ff393abbd14251c2e078e113c) Merge pull request #4344 from djh101/develop
- [`efc2b5c`](https://github.com/gamerlogue/web/commit/efc2b5cb0735ad2cea42a78fd9ab4fe4617072cc) Merge pull request #4364 from tomirons/patch-1
- [`0bd5eb1`](https://github.com/gamerlogue/web/commit/0bd5eb1fe3f8eebae7bcbae1063841a1d251c3ff) Merge pull request #4373 from marcusmoore/patch-2
- [`42e3519`](https://github.com/gamerlogue/web/commit/42e3519b9ab3b0013adeb1deab1782a5df524a19) Merge pull request #4374 from ikari7789/patch-1
- [`0cf4722`](https://github.com/gamerlogue/web/commit/0cf47227f216849b80b05985c6f86db9770fe9c4) Merge pull request #4483 from nesk/custom-url-aws
- [`436f497`](https://github.com/gamerlogue/web/commit/436f497013dc878faf7a688027ddce03a0c484b6) Merge pull request #1 from ThunderBirdsX3/ThunderBirdsX3-patch-1
- [`3d6dcaf`](https://github.com/gamerlogue/web/commit/3d6dcafcb05ee1f4b90b3ececaf59fcdb40dcdce) Merge pull request #4409 from ThunderBirdsX3/master
- [`abb545b`](https://github.com/gamerlogue/web/commit/abb545bb2826e67badedb89291fce00c17489fa0) Merge pull request #4413 from adrianharabula/master
- [`9ac3c33`](https://github.com/gamerlogue/web/commit/9ac3c33b3125d5b53bffe9033f4cb77075e5f110) Merge pull request #4416 from laravel/revert-4413-master
- [`377f6da`](https://github.com/gamerlogue/web/commit/377f6da95584f69c1aa65ba1f44d4d35e4896b8f) Merge pull request #4422 from andrey-helldar/patch-4
- [`11234f9`](https://github.com/gamerlogue/web/commit/11234f9751ab2027b3232caab7c9df342cf3178e) Merge pull request #4433 from ragingdave/patch-1
- [`e2e9ee2`](https://github.com/gamerlogue/web/commit/e2e9ee2ff1762756eeca195af5d9e4b1a8bd4813) Merge pull request #4444 from calebporzio/session-lifetime-in-env
- [`0ab64b9`](https://github.com/gamerlogue/web/commit/0ab64b907862be76704b87d0b8a768c6560ee4fc) Merge pull request #4447 from talvbansal/master
- [`5097904`](https://github.com/gamerlogue/web/commit/5097904a48f2d182835ee1955a2ed27bc4bdd941) Merge pull request #4458 from gabriel-caruso/mockery
- [`c9e5087`](https://github.com/gamerlogue/web/commit/c9e5087a35779d03467d9ab81fb10c0c9c671cf1) Merge pull request #4461 from Gawdl3y/patch-2
- [`d97b97a`](https://github.com/gamerlogue/web/commit/d97b97aa8f0a52e811d1602d6afc9758bf384b75) Merge pull request #4464 from m1guelpf-forks/patch-1
- [`9f36713`](https://github.com/gamerlogue/web/commit/9f36713e5e95b4c818773a1f3db73fb282b5b1b7) Merge pull request #4467 from michaeldyrynda/master
- [`2393dae`](https://github.com/gamerlogue/web/commit/2393dae7af07d4760f42c7d31c57a2834a3adf20) Merge pull request #4470 from michaeldyrynda/chore/consistent-aws-env-vars
- [`76a2bba`](https://github.com/gamerlogue/web/commit/76a2bba43118fc34c5539d408ff3c50617a0489f) Merge pull request #4472 from nikolaynizruhin/master
- [`bdb761e`](https://github.com/gamerlogue/web/commit/bdb761e3a31733e1495bfa135cdd09e08f50550a) Merge pull request #4473 from gabriel-caruso/jquery
- [`e3e1b58`](https://github.com/gamerlogue/web/commit/e3e1b582f225917a05f2e39c38ecc040b4461dfd) Merge pull request #4475 from tecpresso/add_sponsor
- [`1f5ff9f`](https://github.com/gamerlogue/web/commit/1f5ff9fa82c229276608dad6032083d8375a9565) Merge pull request #4476 from gabriel-caruso/package-cross-env
- [`b071f76`](https://github.com/gamerlogue/web/commit/b071f7637a6c8ec731545f02fc04cf9a73054356) Merge pull request #4482 from astorm/patreon
- [`b5b0327`](https://github.com/gamerlogue/web/commit/b5b0327cce14200fc73d5d742ca06eec1f6e2d59) Merge pull request #4486 from astorm/patreon
- [`3b6a898`](https://github.com/gamerlogue/web/commit/3b6a898918183d8e61a05148103c77cabc44c2eb) Merge pull request #4485 from pranayaryal/patch-2
- [`b53748e`](https://github.com/gamerlogue/web/commit/b53748e053b5decf911c5a489de430f6834c9d19) Merge pull request #4491 from JeremyBellaiche/master
- [`fd5ceea`](https://github.com/gamerlogue/web/commit/fd5ceea4859f4f12e2faaa931f88e97d100642cb) Merge pull request #4494 from m1guelpf-forks/patch-3
- [`dab6919`](https://github.com/gamerlogue/web/commit/dab6919b41f34cea74956b4d7935462acca05d53) Merge pull request #4493 from m1guelpf-forks/patch-1
- [`4be8e4f`](https://github.com/gamerlogue/web/commit/4be8e4f3a62d01905a27b19bbe70a66ed0ab12e8) Merge pull request #4503 from lbausch/patch-1
- [`0e750a4`](https://github.com/gamerlogue/web/commit/0e750a4af160b099c216ca8fbb933d390700ee9c) Merge pull request #4504 from hasanemrebeyy/patch-1
- [`e810f81`](https://github.com/gamerlogue/web/commit/e810f81d69000ea5abd91f041e6c865daa33e0b1) Merge pull request #4518 from fideloper/trustedproxy
- [`96952bd`](https://github.com/gamerlogue/web/commit/96952bdd315a0fd44ab336455925ec2e00951059) Merge pull request #4515 from dunglas/add-set-cache-headers-middleware
- [`6b66186`](https://github.com/gamerlogue/web/commit/6b66186b14cc01df014a7214b9b2dc4e7b2a066f) Merge pull request #4516 from pavinthan/patch-2
- [`ca84cf4`](https://github.com/gamerlogue/web/commit/ca84cf4763a9c5a0b837e8310003d3b9ad188a66) Merge pull request #4517 from laurencei/patch-1
- [`f1b450c`](https://github.com/gamerlogue/web/commit/f1b450c062874bd400d4a4f14707b32408cd72de) Merge pull request #4514 from nunomaduro/master
- [`6e9d5bc`](https://github.com/gamerlogue/web/commit/6e9d5bc333ddbc5852205eea1160b8001cfbf11a) Merge pull request #4519 from themsaid/bootstrap4
- [`33dfb04`](https://github.com/gamerlogue/web/commit/33dfb0423a0f071026941e0e970454a7e3cebf3e) Merge pull request #4521 from SjorsO/patch-1
- [`e67d721`](https://github.com/gamerlogue/web/commit/e67d72101c0438712b3ed4e0f8aaed999634aad3) Merge pull request #4525 from przemdz665/bootstrap-pusher-fix
- [`bc3f205`](https://github.com/gamerlogue/web/commit/bc3f2054999e0fac6b729df9278a2a77a479d255) Merge pull request #4526 from themsaid/pusherCluster
- [`65790f5`](https://github.com/gamerlogue/web/commit/65790f587ba96e086da34b0d11b4b55cedc989a9) Merge pull request #4539 from tomhorvat/patch-1
- [`9d6a836`](https://github.com/gamerlogue/web/commit/9d6a836c9f7b90125e17babd7b19ecf46e5f7368) Merge pull request #4568 from jasonmccreary/patch-1
- [`b3138fb`](https://github.com/gamerlogue/web/commit/b3138fb6aa8a7f3663d286f44502c45f4a1e81f0) Merge pull request #4557 from nikolaynizruhin/master
- [`f49bd63`](https://github.com/gamerlogue/web/commit/f49bd6306aa1d029c0809b1797cb5d2773d084e0) Merge pull request #4563 from zendrax/add-vscode-to-gitignore
- [`d5a0e0c`](https://github.com/gamerlogue/web/commit/d5a0e0c3999382785b38905fc24ca2aac967c82e) Merge pull request #4565 from jrseliga/kirschbaum-partnership
- [`daa481f`](https://github.com/gamerlogue/web/commit/daa481fc6229b20bed019a58f7fba6f330830a04) Merge pull request #4570 from Vanlombardi/master
- [`5d93391`](https://github.com/gamerlogue/web/commit/5d93391b0caac0c8c39e842a6ac2740421769ea8) Merge pull request #4572 from nikolaynizruhin/patch-1
- [`cd5b7d4`](https://github.com/gamerlogue/web/commit/cd5b7d41003f6ab3f1c390872f5d1659ebacf763) Merge pull request #4574 from laravel/defaults-56
- [`6038a2f`](https://github.com/gamerlogue/web/commit/6038a2f5bbfc329bd44ec52da3e6e968fabb9569) Merge pull request #4577 from arikaiy/patch-1
- [`dc8ebf2`](https://github.com/gamerlogue/web/commit/dc8ebf2c36c4d64677d932443f01a5ea57b17083) Merge pull request #4579 from laurencei/revert-4574-defaults-56
- [`c1724be`](https://github.com/gamerlogue/web/commit/c1724be9123696dd835c53ef0cdb39e77ea7b946) Merge pull request #4581 from cesaramirez/collision
- [`11d0e36`](https://github.com/gamerlogue/web/commit/11d0e36fa64f274e5fda5cd50ba32cc1a125cfd3) Merge pull request #4583 from nikolaynizruhin/master
- [`70124d1`](https://github.com/gamerlogue/web/commit/70124d1c442a948a05e9ea413731b1817f9b5fdb) Merge pull request #4594 from mputkowski/patch-sftp
- [`ed93c3b`](https://github.com/gamerlogue/web/commit/ed93c3b7e6f8c1dd81f555187e20a8f882fb4891) Merge pull request #4593 from freekmurze/patch-1
- [`e00eed8`](https://github.com/gamerlogue/web/commit/e00eed802107cc73dff55658ef93b0691833c8b2) Merge pull request #4600 from laravel/sem-ver
- [`fbe7058`](https://github.com/gamerlogue/web/commit/fbe705814bdf76de973abe299d0a0076dbf10d9a) Merge pull request #4602 from vlakoff/not_regex
- [`d1ca6a5`](https://github.com/gamerlogue/web/commit/d1ca6a5c4f05fc00358fd7b4f3f8808e032aaee5) Merge pull request #4607 from shadoWalker89/patch-2
- [`ef82808`](https://github.com/gamerlogue/web/commit/ef8280821fb5797f43a55e5e60b4ca54afe767fe) Merge pull request #4665 from barryvdh/patch-3
- [`6fa1b57`](https://github.com/gamerlogue/web/commit/6fa1b57915c5f85650ea460d4134c878c0c08eb7) Merge pull request #4689 from laravel/verify-skeleton
- [`4ee4248`](https://github.com/gamerlogue/web/commit/4ee424845e2bd36a2596b2be9c42a2c5fc112b5f) Merge pull request #4692 from barryvdh/patch-4
- [`25c7b6e`](https://github.com/gamerlogue/web/commit/25c7b6ea2015da707729a0800215c5d5f9b407ef) Merge pull request #4693 from laravel/analysis-8PAgMA
- [`75d7abc`](https://github.com/gamerlogue/web/commit/75d7abc80a477aa9877756375f440e44d0f21260) Merge pull request #4698 from mpociot/add_dump_server
- [`7d1e500`](https://github.com/gamerlogue/web/commit/7d1e5009c19589cef86988710fde92a0e2a4518f) Merge pull request #4617 from rellect/npm_watch
- [`9374f42`](https://github.com/gamerlogue/web/commit/9374f4226a3919e6b404b20380e4469afe5a7a6b) Merge pull request #4620 from browner12/patch-1
- [`ec5bdd1`](https://github.com/gamerlogue/web/commit/ec5bdd1071865cca1cf054a26bf71efd2d3db361) Merge pull request #4621 from hillelcoren/master
- [`a1a4af7`](https://github.com/gamerlogue/web/commit/a1a4af7e477090a6bb3284891f82c81f38b98a98) Merge pull request #4624 from cubettech/patch-1
- [`b194608`](https://github.com/gamerlogue/web/commit/b1946086859507585a91bedc3764703aabf48fd8) Merge pull request #4627 from szepeviktor/patch-1
- [`dcf5d46`](https://github.com/gamerlogue/web/commit/dcf5d46de0275992f44ec3a35dbe309003c040e3) Merge pull request #4629 from codepotato/codepotato-ses-region-patch
- [`66b183c`](https://github.com/gamerlogue/web/commit/66b183c974051a2edcfffd8f2e936fb955be86c8) Merge pull request #4632 from astorm/patreon
- [`5b4f94d`](https://github.com/gamerlogue/web/commit/5b4f94dd04d65989f4a59bb01778c67f684a2bec) Merge pull request #4643 from DojoGeekRA/refactor/hashing-config
- [`adbd39d`](https://github.com/gamerlogue/web/commit/adbd39df18e178f52852bb79a3e68b7dce013f88) Merge pull request #4654 from Alymosul/master
- [`be18fd6`](https://github.com/gamerlogue/web/commit/be18fd64a74e288b3d5bb21f3d425a768a4539f9) Merge pull request #4656 from caouecs/patch-1
- [`fdfd05f`](https://github.com/gamerlogue/web/commit/fdfd05fbf4b79ac09b458f2c4c2a63a5b715feb4) Merge pull request #4658 from DojoGeekRA/feature/editorconfig
- [`5bfc018`](https://github.com/gamerlogue/web/commit/5bfc0181b21c9cbd0e9e4165c2790eea4d7630c5) Merge pull request #4661 from driesvints/patch-1
- [`c0c27f7`](https://github.com/gamerlogue/web/commit/c0c27f7c96dcf102c2f26d017f2dac3a4010df70) Merge pull request #4670 from amenk/patch-2
- [`5944bf4`](https://github.com/gamerlogue/web/commit/5944bf43cae86bf2d8fcd5069635cdfb03b9c4a0) Merge pull request #4687 from mll-lab/unit-tests-first
- [`e8d9710`](https://github.com/gamerlogue/web/commit/e8d97102a9a970e6c18a65d253e003ea761dd002) Merge pull request #4703 from thannaske/feature-maintenance-except-routes
- [`6c2f1b1`](https://github.com/gamerlogue/web/commit/6c2f1b1390d5d594ad5b64720cc0bd85c22fd025) Merge pull request #4700 from wuwx/patch-3
- [`a92f06f`](https://github.com/gamerlogue/web/commit/a92f06f28923dbf171ab18e3947e91d83a6f0459) Merge pull request #4716 from martin-heralecky/patch-1
- [`890e4fd`](https://github.com/gamerlogue/web/commit/890e4fd166e01276ce33936afff13135670ea22a) Merge pull request #1 from Kramerican/Kramerican-patch-1
- [`e0132e4`](https://github.com/gamerlogue/web/commit/e0132e4e18d4203c47f225221eff79a06738210e) Merge pull request #4719 from Kramerican/master
- [`429723c`](https://github.com/gamerlogue/web/commit/429723c2a58fdaeb4076d07dcb461ec941ce470d) Merge pull request #4725 from calebporzio/patch-1
- [`2fba163`](https://github.com/gamerlogue/web/commit/2fba163470f23341f17434abd42473b2bc0799f5) Merge pull request #4727 from Advaith3600/patch-1
- [`69aed31`](https://github.com/gamerlogue/web/commit/69aed31644b5b82c5e11c7ea8815ccf4d4cccd03) Merge pull request #4730 from ahinkle/ahinkle-patch-1
- [`c8180fe`](https://github.com/gamerlogue/web/commit/c8180fe0e3b6ea003f932cb8634d30d0019957b9) Merge pull request #4735 from vemcogroup/master
- [`3c649e1`](https://github.com/gamerlogue/web/commit/3c649e1f07da49c0768bc80de9d04e8bbf9c065a) Merge pull request #4736 from nunomaduro/patch-1
- [`38d89da`](https://github.com/gamerlogue/web/commit/38d89da0e7d07d7c9303674cc79e6561b591d930) Merge pull request #4741 from mattmcdonald-uk/develop
- [`eeed7fe`](https://github.com/gamerlogue/web/commit/eeed7fec415ad68183c2c4b4731774e1684cb75b) Merge pull request #4742 from voyula/master
- [`9d907c8`](https://github.com/gamerlogue/web/commit/9d907c8c902789eac8bd9ebd5e96fefcd2302e71) Merge pull request #4744 from staudenmeir/pagination
- [`eb71ace`](https://github.com/gamerlogue/web/commit/eb71acee2584cbb2cf98f792bc3acac391ddf23e) Merge pull request #4746 from PHLAK/patch-1
- [`5f51b54`](https://github.com/gamerlogue/web/commit/5f51b54f69821d91f05f0250c86a754b15575e11) Merge pull request #4748 from SjorsO/master
- [`b7b39fd`](https://github.com/gamerlogue/web/commit/b7b39fd35c3dfd045f979026733999f4f125c8b3) Merge pull request #4747 from eliurkis/patch-1
- [`6adf68f`](https://github.com/gamerlogue/web/commit/6adf68ffa297b29a1d223f6355db54ab79eabd56) Merge pull request #4752 from ubient/add-mailgun-endpoint-option
- [`38bdfe1`](https://github.com/gamerlogue/web/commit/38bdfe1963668fd2bb44b1b8ebbd2daabecc1b30) Merge pull request #4750 from kp-syginteractive/master
- [`ce6e54a`](https://github.com/gamerlogue/web/commit/ce6e54ac68b85a83b08d66aae6a40652760b0a62) Merge pull request #4573 from laravel/defaults-55
- [`22ebf2c`](https://github.com/gamerlogue/web/commit/22ebf2c00cc982cd41e9eb3ef65dcd365d43a597) Merge pull request #4580 from laurencei/revert-4573-defaults-55
- [`b63a4bf`](https://github.com/gamerlogue/web/commit/b63a4bfb4643e794975dd9684fb8cf3587df98a4) Merge pull request #4753 from laravel/next
- [`02715a3`](https://github.com/gamerlogue/web/commit/02715a319b1c996380095cde7bbf894bf5f073d5) Merge pull request #4794 from jakebathman/change-password-min-length-to-8
- [`5575cbc`](https://github.com/gamerlogue/web/commit/5575cbc03b056eeedde8237c78fc42d03650dec3) Merge pull request #4797 from connectkushal/patch-2
- [`204817b`](https://github.com/gamerlogue/web/commit/204817bd697f53bc18082e8c37a0c4d9ac0c2a57) Merge pull request #4814 from TBlindaruk/added-default-401-image
- [`79cfd9b`](https://github.com/gamerlogue/web/commit/79cfd9b8b3298e85239b154594dcad4368af0e74) Merge pull request #4878 from TBlindaruk/delete-401.svg
- [`3053aaf`](https://github.com/gamerlogue/web/commit/3053aafcd21b17411bccf71d448bdef935a5e780) Merge pull request #4756 from laurencei/master
- [`d28a359`](https://github.com/gamerlogue/web/commit/d28a3596208670700b7109587e237b832fee1107) Merge pull request #4757 from rookwood/patch-1
- [`bb39074`](https://github.com/gamerlogue/web/commit/bb390742bb9b416be13f49e44a9d42e54691b229) Merge pull request #4760 from NFarrington/persist-cache-data-directory
- [`0c8a2ea`](https://github.com/gamerlogue/web/commit/0c8a2ea5b5fdaec6aeac3e3df87c18f0124c82a2) Merge pull request #4761 from gauravmak/patch-1
- [`e05af5b`](https://github.com/gamerlogue/web/commit/e05af5b918e743cec242f0cdbb4d98ad83b96fd7) Merge pull request #4762 from olipayne/master
- [`af51821`](https://github.com/gamerlogue/web/commit/af51821355c94a29d52e78581629cf4a3bdb365e) Merge pull request #4763 from tillkruss/ansi
- [`bf8b367`](https://github.com/gamerlogue/web/commit/bf8b367efa685baf363119be32c87a0fb61288ae) Merge pull request #4767 from bertheyman/daily-logs-by-default
- [`ecd03a0`](https://github.com/gamerlogue/web/commit/ecd03a047ee6d38fb990a705e79e5204d4b3d841) Merge pull request #4775 from yajra/patch-register
- [`fc7bd1b`](https://github.com/gamerlogue/web/commit/fc7bd1b74bf74a22c5e1997c246fa5f6d2f2f588) Merge pull request #4777 from SammyK/make-app-path-stream-safe
- [`ab48823`](https://github.com/gamerlogue/web/commit/ab4882391614c53305cd8801987c92da8ea7b744) Merge pull request #4780 from zaknesler/patch-1
- [`38dd8d8`](https://github.com/gamerlogue/web/commit/38dd8d85794d29356811402a5de390c997b04f50) Merge pull request #4781 from ankurk91/patch/lang-attribute
- [`7214b9d`](https://github.com/gamerlogue/web/commit/7214b9d7cb4a17cc2013d7413ade0d2b7fe07aa3) Merge pull request #4782 from eduarguzher/patch/validation-translation
- [`0e8f6e3`](https://github.com/gamerlogue/web/commit/0e8f6e3a22d836b4cb1e08e6258c52c4db8fd03e) Merge pull request #4783 from laravel/laurencei-patch-1
- [`dc67444`](https://github.com/gamerlogue/web/commit/dc6744478dbbe32830a018ecdbd4698841e4dec7) Merge pull request #4791 from staudenmeir/pagination
- [`58f0a01`](https://github.com/gamerlogue/web/commit/58f0a017359f9d4080512135bb4f1fc17635be67) Merge pull request #4803 from driesvints/cashier-add-verify-webhook-config-values
- [`51ee714`](https://github.com/gamerlogue/web/commit/51ee7140f515162c27828c38d10a5e9ed87d065d) Merge pull request #4805 from driesvints/fix-api-redirect
- [`9f39e53`](https://github.com/gamerlogue/web/commit/9f39e5355bbf5837a5996d35683638d428e17b85) Merge pull request #4822 from borisdamevin/patch-2
- [`ef8173b`](https://github.com/gamerlogue/web/commit/ef8173b5e604e3b3b994cc85f635b191f43d2731) Merge pull request #4820 from brainmaniac/patch-1
- [`4ab37e3`](https://github.com/gamerlogue/web/commit/4ab37e3fc8b142579be48290ebd489f9e4b0b026) Merge pull request #4830 from cyberhicham/master
- [`1052ff2`](https://github.com/gamerlogue/web/commit/1052ff27fdc29070c47a3b180c28d755a48c5d31) Merge pull request #4831 from michaelmano/master
- [`6875e15`](https://github.com/gamerlogue/web/commit/6875e1590af18961509a87d2a760b2036b43c4ad) Merge pull request #4832 from daniel-banciulea/master
- [`a862577`](https://github.com/gamerlogue/web/commit/a86257711a24b05e0c026bd7dba3b88a8d107d82) Merge pull request #4833 from DojoGeekRA/feature/phpunit.xml
- [`18ee85c`](https://github.com/gamerlogue/web/commit/18ee85ce4f50be31fe6642140f6fbf769af5a6f0) Merge pull request #4834 from clemir/uuid-validation
- [`5a0438a`](https://github.com/gamerlogue/web/commit/5a0438ae65096e4c3156950c220c79779ab5702b) Merge pull request #4837 from bbashy/patch-1
- [`e33d494`](https://github.com/gamerlogue/web/commit/e33d494c9768ab80d4b663be044329ba6d7b93e0) Merge pull request #4838 from dakira/fk-support
- [`ddaf3ad`](https://github.com/gamerlogue/web/commit/ddaf3adccca7bb257bd293f7ac79b8c6f6f08e23) Merge pull request #4836 from laurencei/laurencei-patch-1
- [`bb82b6e`](https://github.com/gamerlogue/web/commit/bb82b6e993e129d3ab130cd24d14b89bc216c735) Merge pull request #4841 from narwy/patch-1
- [`ff8b293`](https://github.com/gamerlogue/web/commit/ff8b293264818e1b80529a6151e6d376b29e5266) Merge pull request #4853 from aryehraber/patch-2
- [`90fc12b`](https://github.com/gamerlogue/web/commit/90fc12b441abfd3da1e0bab88d4252797d0829d5) Merge pull request #4854 from aryehraber/patch-1
- [`1bdc86c`](https://github.com/gamerlogue/web/commit/1bdc86c27198b6f066bddd04c36418f319b8d81f) Merge pull request #4856 from localheinz/feature/composer-normalize
- [`899e9e5`](https://github.com/gamerlogue/web/commit/899e9e5079a57b6c960d59f14aa669ec8c280391) Merge pull request #4863 from staudenmeir/validation
- [`95857e3`](https://github.com/gamerlogue/web/commit/95857e3f42281cc696ad029dabe056897ed31e22) Merge pull request #4861 from unstoppablecarl/middleware-priority-comment
- [`dcdd4ec`](https://github.com/gamerlogue/web/commit/dcdd4ece6316fc1298ef7b67cacd790b294fe5c6) Merge pull request #4865 from eugenesaenko/patch-1
- [`d347c00`](https://github.com/gamerlogue/web/commit/d347c00ffae17b8723c2ab593e9e9f7adfdc4365) Merge pull request #4867 from ajthinking/patch-1
- [`1fb119a`](https://github.com/gamerlogue/web/commit/1fb119ab6a85e199667c8abbf447d6304cbc45d6) Merge pull request #4866 from driesvints/add-starts-with-rule
- [`ba71821`](https://github.com/gamerlogue/web/commit/ba71821b361ccc35c6769b21c22d0b22ea877bfc) Merge pull request #4870 from driesvints/update-changelog
- [`0662808`](https://github.com/gamerlogue/web/commit/0662808c458eec2ee3b1991a13ff82123c264eea) Merge pull request #4884 from eric-famiglietti/patch-1
- [`3b61f77`](https://github.com/gamerlogue/web/commit/3b61f7779dc8eea68344d7a7aa27f5f3793ad59d) Merge pull request #4896 from goodjack/patch-1
- [`2620fdb`](https://github.com/gamerlogue/web/commit/2620fdbc160bcf2a206e3eff3dda3bedfb163323) Merge pull request #4899 from tiagocyberduck/master
- [`67081bc`](https://github.com/gamerlogue/web/commit/67081bc81981091bf553af62e10b2150f664092b) Merge pull request #4904 from Te7a-Houdini/modify-redirect-if-auth-middleware-to-allow-multiple-guards
- [`6af3ca0`](https://github.com/gamerlogue/web/commit/6af3ca0ab08b408c43e5a454905d68250bc6a017) Merge pull request #4913 from yuloh/beanstalkd-blocking-pop-config
- [`b2ef7b2`](https://github.com/gamerlogue/web/commit/b2ef7b2fdf39850f84f6e4d20aa0f2e34662ad24) Merge pull request #4939 from driesvints/phpunit8
- [`9f66645`](https://github.com/gamerlogue/web/commit/9f66645353bbb86ec36edbac7ce05ee4eda15c94) Merge pull request #4943 from crynobone/patch-1
- [`ea1d45b`](https://github.com/gamerlogue/web/commit/ea1d45b3ad09d1d910816c53f28b7e2886416774) Merge pull request #4917 from driesvints/remove-unused-bootstrap-class
- [`43a9955`](https://github.com/gamerlogue/web/commit/43a9955d55beb0492d8fc15adae33e30b3a37b5c) Merge pull request #4921 from SjorsO/master
- [`1be270b`](https://github.com/gamerlogue/web/commit/1be270b3ca49e539d3ae40aa20d9323a6342e94c) Merge pull request #4924 from fideloper/patch-2
- [`963ddeb`](https://github.com/gamerlogue/web/commit/963ddebb66756031b525f6c2c9088db7af9d86a0) Merge pull request #4926 from kawax/str
- [`ded34b0`](https://github.com/gamerlogue/web/commit/ded34b0a3c0a9a6a6756a55f098a3d5e5d4617f0) Merge pull request #4929 from AbdelElrafa/master
- [`af980cb`](https://github.com/gamerlogue/web/commit/af980cb63fd717fe48a29348f17380cdc56701ab) Merge pull request #4930 from epalmans/master
- [`562a75e`](https://github.com/gamerlogue/web/commit/562a75e4f68d64ec2c4d5926cd801c3323af1032) Merge pull request #4931 from simoebenhida/master
- [`9d3d6ce`](https://github.com/gamerlogue/web/commit/9d3d6ce1093c0cc77c09375a4253f374af61c7d7) Merge pull request #4933 from laravel/revert-4931-master
- [`0243a67`](https://github.com/gamerlogue/web/commit/0243a679b2dfc5467c0bc0f1e170e3a4de907a02) Merge pull request #4935 from eddybrando/feat/remove-unnecessary-link-type
- [`4e2ceb5`](https://github.com/gamerlogue/web/commit/4e2ceb5a5c34947c182c36eafcb19747144f7e1e) Merge pull request #4934 from JakeConnors376W/patch-1
- [`6c8f67a`](https://github.com/gamerlogue/web/commit/6c8f67a6b990bb2143dbc40c57e984d1b818cd28) Merge pull request #4949 from laravel/revert-4904-modify-redirect-if-auth-middleware-to-allow-multiple-guards
- [`d4916f8`](https://github.com/gamerlogue/web/commit/d4916f84828ceacbca24ea012b31e32c9aa7a716) Merge pull request #4946 from ankurk91/patch/big-int
- [`ec85eb5`](https://github.com/gamerlogue/web/commit/ec85eb51b7aba14b5fef474c7c19563311a1c007) Merge pull request #4952 from andrewgorpenko/andrewgorpenko-patch-1
- [`8228c0c`](https://github.com/gamerlogue/web/commit/8228c0c6a5a53f1ed1d708947a389ba69573f3e0) Merge pull request #4951 from CupOfTea696/feature/add-arr-and-str-aliases
- [`899d28f`](https://github.com/gamerlogue/web/commit/899d28ffa59fb564227ecddb4d09903adc4f4d6b) Merge pull request #4956 from akalongman/master
- [`4c48ab8`](https://github.com/gamerlogue/web/commit/4c48ab8336dc6339374008cc366259bed2e5850e) Merge pull request #4963 from chapeupreto/patch-1
- [`aa1fe10`](https://github.com/gamerlogue/web/commit/aa1fe106825ec5d91d498b2942402a632fa40fd2) Merge pull request #4971 from Lenophie/patch-1
- [`cfeda0f`](https://github.com/gamerlogue/web/commit/cfeda0ff02d8b0178a1501bf4229ff6a08c2f550) Merge pull request #4979 from hyperhost/add-hyper-host-sponsor
- [`dc6fff1`](https://github.com/gamerlogue/web/commit/dc6fff1621091cf11cdbf0edb48ad1097d2e08cd) Merge pull request #4982 from DivineOmega/patch-1
- [`dbf66cb`](https://github.com/gamerlogue/web/commit/dbf66cb215111a16e6f04fa29ad4cbd57752952e) Merge pull request #4986 from DivineOmega/patch-1
- [`cb02438`](https://github.com/gamerlogue/web/commit/cb0243804d0e22e33803a4f399059e04b4c8dfb6) Merge pull request #4987 from DivineOmega/patch-1
- [`834561d`](https://github.com/gamerlogue/web/commit/834561d08861ec9d6f845bfe21fb42e34063e63b) Merge pull request #4989 from DrewRoberts/update-readme-laracasts
- [`378f9dd`](https://github.com/gamerlogue/web/commit/378f9dd0c1cd592d043b9eabe4b221c5ae9a99b8) Merge pull request #4990 from SjorsO/patch-1
- [`2a219df`](https://github.com/gamerlogue/web/commit/2a219dfce591b87738a51b3d06642cf4e03c4474) Merge pull request #4998 from laravel/analysis-z9QV6a
- [`7f1c137`](https://github.com/gamerlogue/web/commit/7f1c1370981bcf707be09df7fc5501f4c7880d3a) Merge pull request #5013 from laravel/revert-5012-feature/exported-files
- [`daf8fdf`](https://github.com/gamerlogue/web/commit/daf8fdfc7093564fb0c87c6f51e9c948d203298d) Merge pull request #5175 from canvural/patch-1
- [`bcbb7fe`](https://github.com/gamerlogue/web/commit/bcbb7fe72f78207ad16dc1271ed397816c6e83bd) Merge pull request #5196 from laravel/revert-5006-analysis-qxPGgA
- [`a7eabbe`](https://github.com/gamerlogue/web/commit/a7eabbe86ac9e34be2992a49865e10cfb4d15c78) Merge pull request #5201 from aimeos/master
- [`f750594`](https://github.com/gamerlogue/web/commit/f75059407bba45c2fc4e2be26d902d84c092c1f9) Merge pull request #5271 from winter-ice/master
- [`b005605`](https://github.com/gamerlogue/web/commit/b005605c1216886644004f8668d37e7e662190a8) Merge pull request #5278 from voyula/patch-1
- [`8d7f4e8`](https://github.com/gamerlogue/web/commit/8d7f4e8f2b56ec19694456a162f1083ac3ae7dcf) Merge pull request #5320 from barryvdh/patch-4
- [`308f8bf`](https://github.com/gamerlogue/web/commit/308f8bffd4f7198e1fa6f701a6abe1efcf0520fb) Merge pull request #5324 from nunomaduro/patch-1
- [`32e6a2d`](https://github.com/gamerlogue/web/commit/32e6a2d97f6801a9aee203316ab9b95220fa11b0) Merge pull request #5346 from ahinkle/patch-1
- [`357b9fe`](https://github.com/gamerlogue/web/commit/357b9fe3c4b7957a8c82ed66a2478e55fa112093) Merge pull request #5355 from laravel/bump
- [`91588dd`](https://github.com/gamerlogue/web/commit/91588dd8af4da4ed1503b30a7d021abf3eccf27f) Merge pull request #5370 from laravel/bump-7
- [`cf745b3`](https://github.com/gamerlogue/web/commit/cf745b379d8df6fdc315d88bac4cc90d275babd2) Merge pull request #5369 from laravel/bump-6
- [`ddecb8b`](https://github.com/gamerlogue/web/commit/ddecb8be437d6a11948578558eb6b89427b0a5f0) Merge pull request #5669 from laravel/8.x
- [`80b6c93`](https://github.com/gamerlogue/web/commit/80b6c935783991ffcd4c5510717ff0558afb1e3c) Merge pull request #5762 from freekmurze/master
- [`2e00d35`](https://github.com/gamerlogue/web/commit/2e00d357e7a936e1d3ec642de070b711413cef33) Merge pull request #5763 from laravel/revert-5762-master
- [`441f65b`](https://github.com/gamerlogue/web/commit/441f65b831e0149fd13b4d4a316dddfb04e780de) Merge pull request #5774 from morrislaptop/user-factory-type
- [`ad3e6e0`](https://github.com/gamerlogue/web/commit/ad3e6e0210aeb81387e6144ef353b11d80c787c6) Merge pull request #5797 from ArnaudLier/patch-1
- [`4132f7b`](https://github.com/gamerlogue/web/commit/4132f7ba8d0ba0c31f27e14c2620f6abab42864d) Merge pull request #5795 from emaia/patch-1
- [`f2072a8`](https://github.com/gamerlogue/web/commit/f2072a8f0ba7053bc003002f5a0b4304b6acc995) Merge pull request #5806 from axlon/patch-1
- [`c0096b9`](https://github.com/gamerlogue/web/commit/c0096b9a241822bb3736444df90b3ca333cb59fe) Merge pull request #5807 from u01jmg3/9.x
- [`f927277`](https://github.com/gamerlogue/web/commit/f927277368a3f475299a918d1a3990c6237cb916) Merge pull request #6765 from laravel/12.x
- [`47e182c`](https://github.com/gamerlogue/web/commit/47e182c1c540ce4b477fff0569c2a164d2470bd7) Merge pull request #6779 from aziyan99/chore/fix-missing-comma-in-package-dot-json
- [`05e8eba`](https://github.com/gamerlogue/web/commit/05e8eba4b1d51b2012244e7fbfb6e79a5d26828a) Merge pull request #6829 from laravel/chore/github-actions-hardening
- [`5019505`](https://github.com/gamerlogue/web/commit/50195055121a5ba8448213bc74cc3a350bc5e57e) Merge pull request #6830 from laravel/dependabot/github_actions/github-actions-6a98abd9ac
- [`8cef7d2`](https://github.com/gamerlogue/web/commit/8cef7d21d336dcf281bd2a36706561a9f6c8389d) Merge pull request #6831 from laravel/fix/pin-least-privilege-reusable-workflows
- [`c24eca6`](https://github.com/gamerlogue/web/commit/c24eca67a510730cd63c538381a86e06b9ce4184) Merge pull request #6832 from laravel/chore/pin-reusable-workflows-latest
- [`452c26a`](https://github.com/gamerlogue/web/commit/452c26a11ff062cd8d8364905a98a2d6407e476b) Merge pull request #9 from gamerlogue/dependabot/github_actions/github-actions-132c9c4db3
- [`6328a28`](https://github.com/gamerlogue/web/commit/6328a28f90e954cc79b0d29678937954130ae5b4) Merge pull request #12 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-c62041ce64
- [`9e1eb25`](https://github.com/gamerlogue/web/commit/9e1eb25295463953ad237a92269fdb3e210cf36f) Merge pull request #11 from gamerlogue/dependabot/docker_compose/docker-compose-images-a1b5506db0
- [`6de8a9e`](https://github.com/gamerlogue/web/commit/6de8a9eee89d94721748afa725ae5c5c3df18d38) Merge pull request #15 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-6101c9e4d7
- [`7afcd65`](https://github.com/gamerlogue/web/commit/7afcd65714d5b424c8ed9f1aba5103f77de0ce98) Merge pull request #20 from gamerlogue/dependabot/bun/bun-dependencies-e05504b0e4
- [`6eb6b52`](https://github.com/gamerlogue/web/commit/6eb6b52c854c53eeca607aa0414fe98327a00090) Merge pull request #21 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-9077b8d074
- [`f8d3c83`](https://github.com/gamerlogue/web/commit/f8d3c83564e7170a141ccb4c555bf09ab54117de) Merge pull request #29 from gamerlogue/dependabot/bun/bun-dependencies-1b2c4440e2
- [`fcd6b81`](https://github.com/gamerlogue/web/commit/fcd6b81907dbc7444241135d80d3fc44b0251829) Merge pull request #22 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-ee7afe7a9b
- [`127b016`](https://github.com/gamerlogue/web/commit/127b0168741529dd62a7a24aadc851f8ddf5aa80) Merge pull request #28 from gamerlogue/dependabot/composer/composer-dependencies-b09f1f805c
- [`caedbe2`](https://github.com/gamerlogue/web/commit/caedbe25d7b8d7a2ae1f1b4c40acda3e778932b5) Merge pull request #27 from gamerlogue/dependabot/docker_compose/docker-compose-images-05a7aa8077
- [`f94bb5f`](https://github.com/gamerlogue/web/commit/f94bb5f10d8e73e6b1da6535c0d296de3eb91cdb) Merge pull request #30 from gamerlogue/dependabot/composer/league/commonmark-2.10.3
- [`755c8b0`](https://github.com/gamerlogue/web/commit/755c8b0246a42ddb9f4af679b6057ff0d2c30a5a) Merge pull request #31 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-d1f85338cf
- [`1c033d5`](https://github.com/gamerlogue/web/commit/1c033d5ba82536f43599c15dd240465cf491a8b1) Merge pull request #32 from gamerlogue/dependabot/composer/composer-dependencies-865ae9ec70
- [`a8775ea`](https://github.com/gamerlogue/web/commit/a8775eaf96c25bde05f8b9ee24a95de29813c6b7) Merge pull request #33 from gamerlogue/dependabot/bun/bun-dependencies-83bb08f1e0
- [`31914bb`](https://github.com/gamerlogue/web/commit/31914bb5e6ebb62f9080f9a22df005ff7f26ac69) Merge pull request #38 from gamerlogue/dependabot/composer/composer-dependencies-e2fc297e84
- [`373b1c2`](https://github.com/gamerlogue/web/commit/373b1c231c7b550320151f7f9a842427b52a2534) Merge pull request #39 from gamerlogue/dependabot/bun/bun-dependencies-46a72d5b50
- [`f27634c`](https://github.com/gamerlogue/web/commit/f27634c6ce821c3b8d8c565642c03f08214c7799) Merge pull request #37 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-7fef37da5c
- [`5ae1c33`](https://github.com/gamerlogue/web/commit/5ae1c33b0b21bcbc10a45c50983abfc5c62b5deb) Merge pull request #42 from gamerlogue/dependabot/bun/bun-dependencies-c1beb756c9
- [`baa1ab3`](https://github.com/gamerlogue/web/commit/baa1ab3e322db09519a833b1dbf5305c6e406d9e) Merge pull request #40 from gamerlogue/dependabot/pre_commit/pre-commit-hooks-5a799eed95
- [`bd35127`](https://github.com/gamerlogue/web/commit/bd35127413cea4fbc030e12baf29360d6a980040) Merge pull request #4167 from driesvints/fix-cross-env-bin
- [`0557568`](https://github.com/gamerlogue/web/commit/05575687e095c9148b5efe9acb7239b5139a713f) Merge pull request #4174 from kossa/upgrade-mix
- [`fe5146f`](https://github.com/gamerlogue/web/commit/fe5146f854a6175233677f83d44519cb32079bd7) Merge pull request #4177 from al0mie/al0mie-patch-1
- [`0c4f0f0`](https://github.com/gamerlogue/web/commit/0c4f0f0a97067f892b3078e423e638d1cb860b1a) Merge pull request #4179 from bshaffer/add-socket-to-database-config
- [`1447a0e`](https://github.com/gamerlogue/web/commit/1447a0ef5089e70ee22ed60ae6218ead089da549) Merge pull request #4182 from bbashy/patch-1
- [`2312580`](https://github.com/gamerlogue/web/commit/2312580af8a20e78f96f988d420c073f899cbead) Merge pull request #4180 from halaei/unindex-token
- [`e83b2c7`](https://github.com/gamerlogue/web/commit/e83b2c795b53f14d4841e7dfff76cc0a2363de06) Merge pull request #4184 from JuanDMeGon/patch-1
- [`5052f14`](https://github.com/gamerlogue/web/commit/5052f14fc4ca284ffbe23dc019049ec97a2033a4) Merge pull request #4187 from lioannou/patch-1
- [`bc368c6`](https://github.com/gamerlogue/web/commit/bc368c627b783db369f2e8ace32a5ddb82498bea) Merge pull request #4188 from themsaid/laravelMix
- [`6432488`](https://github.com/gamerlogue/web/commit/643248834f952ec464e0197d730fcb1b698f3d28) Merge pull request #4189 from tabuna/patch-1
- [`228bc47`](https://github.com/gamerlogue/web/commit/228bc472371615055cce0976c2bee7a6ef87d3d0) Merge pull request #4186 from tillkruss/patch-1
- [`7ae5c3f`](https://github.com/gamerlogue/web/commit/7ae5c3fcf8a7b371c3e5a96c2ce37a743468d5ac) Merge pull request #4191 from daylerees/add-vagrant-to-ignore
- [`f16fbd1`](https://github.com/gamerlogue/web/commit/f16fbd1f8f403f114c06c058ed686ce07cf308dc) Merge pull request #4190 from michaeldyrynda/master
- [`f5fd03d`](https://github.com/gamerlogue/web/commit/f5fd03d705e5078b336af5012d5b6a21b277d945) Merge pull request #4193 from KristofMorva/npm-windows
- [`4882961`](https://github.com/gamerlogue/web/commit/4882961b418455e942c2dab85cdb55272c80776b) Merge pull request #4196 from DojoGeekRA/patch-1
- [`d870a0c`](https://github.com/gamerlogue/web/commit/d870a0c2ce8023906b770d5baa554e0dd27071b0) Merge pull request #4204 from mdavis1982/make-app-name-configurable
- [`f7b9a59`](https://github.com/gamerlogue/web/commit/f7b9a590f99f7248df49cf35d79b1c1f4cb8ca96) Merge pull request #4203 from KristofMorva/sort-gitignore
- [`c6e3d6e`](https://github.com/gamerlogue/web/commit/c6e3d6e5b422ad5b6ea94696ad1809a76cc85bb3) Merge pull request #4208 from misenhower/fix-axios-defaults
- [`bc91dca`](https://github.com/gamerlogue/web/commit/bc91dcab93a0784efde5fcf4fba6696c95c8e1ae) Merge pull request #4212 from laurencei/patch-1
- [`b699ffa`](https://github.com/gamerlogue/web/commit/b699ffabce93b822bc0ba76e7af0be40b1f55bb5) Merge pull request #4229 from ebuster/patch-1
- [`99da499`](https://github.com/gamerlogue/web/commit/99da499cc8d84077c59bd9fdc949758822e02c3e) Merge pull request #4232 from JuanDMeGon/patch-1
- [`49a9f5f`](https://github.com/gamerlogue/web/commit/49a9f5fd50c96ad12c77ae4d6e1747a533396623) Merge pull request #4234 from tillkruss/master
- [`859479a`](https://github.com/gamerlogue/web/commit/859479a033962c3fb986517778c4af6896e83155) Merge pull request #4236 from caiquecastro/master
- [`a521d4e`](https://github.com/gamerlogue/web/commit/a521d4e7184fa193361ed0fe58e38bda1271d99d) Merge pull request #4241 from B-07/patch-2
- [`e605f54`](https://github.com/gamerlogue/web/commit/e605f54b928940083d6c28a0bd6114f541c31a77) Merge pull request #4240 from B-07/patch-1
- [`b3725e9`](https://github.com/gamerlogue/web/commit/b3725e97b62e0e8edf81c99e951cb4f0567c2b8c) Merge pull request #4244 from B-07/patch-5
- [`2c6d764`](https://github.com/gamerlogue/web/commit/2c6d76469a46494a8f9d3c70c05310f57c38fb87) Merge pull request #4247 from laurencei/patch-1
- [`6dde426`](https://github.com/gamerlogue/web/commit/6dde42607593d43ea80fd592f963f44afca7c43e) Merge pull request #4253 from insign/patch-1
- [`6c1e426`](https://github.com/gamerlogue/web/commit/6c1e42647eda47208b94b5020564beacdcdb47e4) Merge pull request #4254 from FrittenKeeZ/patch-1
- [`0f0178a`](https://github.com/gamerlogue/web/commit/0f0178a577d3d7f41d308d2ce91b1e2ce5e27cad) Merge pull request #4261 from mhayes14/master
- [`c109a87`](https://github.com/gamerlogue/web/commit/c109a87831d86ed009da8444a1429b3fa43ef5ee) Merge pull request #4268 from borisdamevin/patch-1
- [`1a32543`](https://github.com/gamerlogue/web/commit/1a32543c09f9f0598778e189435772baee8dc689) Merge pull request #4279 from adiachenko/testsuite_names
- [`a9268c5`](https://github.com/gamerlogue/web/commit/a9268c5f58e880015452a1aa7b250970f095ad54) Merge pull request #4282 from m1guelpf/patch-1
- [`e50ca3d`](https://github.com/gamerlogue/web/commit/e50ca3dc87ce0d83aa123326151d23d18f78fea4) Merge pull request #4283 from laravel/mix-patch
- [`3acb739`](https://github.com/gamerlogue/web/commit/3acb7394502a87055f0d0447b9645cde5a9a85c0) Merge pull request #4287 from laravel/top-secret-add-quotes-patch
- [`5ae7c37`](https://github.com/gamerlogue/web/commit/5ae7c373fe9bd203277c3d50c15f1500b141d1a4) Merge pull request #4294 from ovanschie/patch-1
- [`9fec341`](https://github.com/gamerlogue/web/commit/9fec341e55bdfe44e67a48a4e85ae3b218de867f) Merge pull request #4299 from lucasmichot/feature/master/npm-packages
- [`8d370ce`](https://github.com/gamerlogue/web/commit/8d370ce7f2026165950a4e2ce622c37f8a01440f) Merge pull request #4311 from lucasmichot/feature/master/docblock
- [`098b8a4`](https://github.com/gamerlogue/web/commit/098b8a48830c0e4e6ba6540979bf2459c8a6a49e) Merge pull request #4322 from kauhat/patch-1
- [`e19952f`](https://github.com/gamerlogue/web/commit/e19952fb19c901422878b7859654cc257dcf0419) Merge pull request #4340 from garygreen/remove-migrations-classmap
- [`e4de035`](https://github.com/gamerlogue/web/commit/e4de035371efd3c7e74da547bbfab2a5fcc59c0b) Merge pull request #4347 from balping/patch-1
- [`166d25b`](https://github.com/gamerlogue/web/commit/166d25b726aa2a0c37a1991fb6cce57f517d74e3) Merge pull request #4349 from pierreneter/patch-1
- [`7a9da9c`](https://github.com/gamerlogue/web/commit/7a9da9c1649a5530dda65cd57fe2b71e455c55ff) Merge pull request #4351 from pierreneter/revert-4349-patch-1
- [`8a50ccb`](https://github.com/gamerlogue/web/commit/8a50ccb617717472f36ba9f7675fc5e73b0e12fd) Merge pull request #4350 from Te7a-Houdini/AddAuthDirective
- [`bee41ce`](https://github.com/gamerlogue/web/commit/bee41ce20ba5b7f7043533a83b6def0bb9bef09f) Merge pull request #4368 from keving91/patch-1
- [`d0ad722`](https://github.com/gamerlogue/web/commit/d0ad72226ea0a4d98eb229ec564d62ee2a7f10b9) Merge pull request #4375 from decadence/patch-1
- [`37d39a7`](https://github.com/gamerlogue/web/commit/37d39a7cf5b3941072a90b7c52fe43686b8d5b83) Merge pull request #4383 from scrubmx/patch-8
- [`15f8e2d`](https://github.com/gamerlogue/web/commit/15f8e2d45e97e3b4fbf707cadcc796b67b59a21a) Merge pull request #4219 from laravel/analysis-X0W3an
- [`cae9400`](https://github.com/gamerlogue/web/commit/cae94000ca1216f6b01cb67803a403e9469dd53d) Merge pull request #4226 from diogoazevedos/develop
- [`164acc8`](https://github.com/gamerlogue/web/commit/164acc8d7a2f11cda7f51f8e73d7702adccc2118) Merge pull request #4227 from joshmanders/patch-1
- [`640293f`](https://github.com/gamerlogue/web/commit/640293f297a9a05a3db5ce330c21c3ca1b9c4d93) Merge pull request #4278 from m1guelpf/patch-2
- [`38a8390`](https://github.com/gamerlogue/web/commit/38a8390ce7a87ab291c264c630af960c14a2d02f) Merge pull request #4275 from themsaid/updateAuthJSONError
- [`d5bf065`](https://github.com/gamerlogue/web/commit/d5bf06589f6ea032b1ad7f7338cdba19edde54ee) Merge pull request #4302 from bretterer/fix_trusted_proxies
- [`c4e1428`](https://github.com/gamerlogue/web/commit/c4e142867c84e5ed41b95884e9bd541382e48f3b) Merge pull request #4333 from DCzajkowski/develop
- [`7bcf7a5`](https://github.com/gamerlogue/web/commit/7bcf7a5450000a13a9771991cbe7713ad7e03514) Merge pull request #4344 from djh101/develop
- [`be143bf`](https://github.com/gamerlogue/web/commit/be143bf2dc13155a2afd5b040dea2e9ba85ad61c) Merge pull request #4364 from tomirons/patch-1
- [`58ed545`](https://github.com/gamerlogue/web/commit/58ed5459b1e33bd2230f2aa6377992995686e0d1) Merge pull request #4373 from marcusmoore/patch-2
- [`af2a4d4`](https://github.com/gamerlogue/web/commit/af2a4d47a3b74fb30f9a1833825fff7eef0a4615) Merge pull request #4374 from ikari7789/patch-1
- [`68772c7`](https://github.com/gamerlogue/web/commit/68772c762c3ed50f849271e418b4f17bd9311798) Merge pull request #4483 from nesk/custom-url-aws
- [`db20630`](https://github.com/gamerlogue/web/commit/db20630ebfc6b49fac401d1f7df75ae69ffafc3a) Merge pull request #1 from ThunderBirdsX3/ThunderBirdsX3-patch-1
- [`d93c8f1`](https://github.com/gamerlogue/web/commit/d93c8f177a97bc7a7cf98c992c81cfe4ace88808) Merge pull request #4409 from ThunderBirdsX3/master
- [`d1cfd41`](https://github.com/gamerlogue/web/commit/d1cfd416ca045897e43aa1448552b86aeddef793) Merge pull request #4413 from adrianharabula/master
- [`392ece3`](https://github.com/gamerlogue/web/commit/392ece3e4fdc4d58c562b0404a66ef2b90a9f9b9) Merge pull request #4416 from laravel/revert-4413-master
- [`4bbd5f9`](https://github.com/gamerlogue/web/commit/4bbd5f9be579d5e69fe784216298d9f06824d6c2) Merge pull request #4422 from andrey-helldar/patch-4
- [`691fdfe`](https://github.com/gamerlogue/web/commit/691fdfe1c2c047d79e4fa07d69ded8bf0e0ce0a8) Merge pull request #4433 from ragingdave/patch-1
- [`23f6bbe`](https://github.com/gamerlogue/web/commit/23f6bbe6997371a9222442f35aca30fa38fd2c12) Merge pull request #4444 from calebporzio/session-lifetime-in-env
- [`4a86f07`](https://github.com/gamerlogue/web/commit/4a86f0765a24be2b633e485848920f8a524be5ed) Merge pull request #4447 from talvbansal/master
- [`8f99719`](https://github.com/gamerlogue/web/commit/8f99719dfe74b798dadf679c587d68727a2d4797) Merge pull request #4458 from gabriel-caruso/mockery
- [`e6067be`](https://github.com/gamerlogue/web/commit/e6067becd1a48e5953f57431c68125c79b93d587) Merge pull request #4461 from Gawdl3y/patch-2
- [`3dcea02`](https://github.com/gamerlogue/web/commit/3dcea02db6fa216e3823b7851f0a575a3d549591) Merge pull request #4464 from m1guelpf-forks/patch-1
- [`a4aada8`](https://github.com/gamerlogue/web/commit/a4aada88b08e979957a26c9f5f6641b075a49b9a) Merge pull request #4467 from michaeldyrynda/master
- [`e441d9c`](https://github.com/gamerlogue/web/commit/e441d9cac86bffcb3d5dc079ee86fcae7cd955d5) Merge pull request #4470 from michaeldyrynda/chore/consistent-aws-env-vars
- [`a3eb00e`](https://github.com/gamerlogue/web/commit/a3eb00e23a21088257792b60079537ce577bd1ee) Merge pull request #4472 from nikolaynizruhin/master
- [`7adc396`](https://github.com/gamerlogue/web/commit/7adc396e9b4cac91beb745678663aed5cd3eaf65) Merge pull request #4473 from gabriel-caruso/jquery
- [`ba96ab0`](https://github.com/gamerlogue/web/commit/ba96ab0f6e36659368f7d95748b7cffb426b1001) Merge pull request #4475 from tecpresso/add_sponsor
- [`01b9061`](https://github.com/gamerlogue/web/commit/01b9061f69b858a8cf30dccc20f9b10c021ca997) Merge pull request #4476 from gabriel-caruso/package-cross-env
- [`7231956`](https://github.com/gamerlogue/web/commit/72319567146bd96077bfcf3842f36b749fd74103) Merge pull request #4482 from astorm/patreon
- [`df22b3b`](https://github.com/gamerlogue/web/commit/df22b3b904babfd2faa1df1bd7f4204c600de603) Merge pull request #4486 from astorm/patreon
- [`0a2daf8`](https://github.com/gamerlogue/web/commit/0a2daf8f17a70dcd5eb25228c6792869832c074b) Merge pull request #4485 from pranayaryal/patch-2
- [`0fd4fb3`](https://github.com/gamerlogue/web/commit/0fd4fb33a2fa7b940d6fea69402f118e8d5b9f21) Merge pull request #4491 from JeremyBellaiche/master
- [`19da36d`](https://github.com/gamerlogue/web/commit/19da36d08d850f078f30dde9197fecd510926986) Merge pull request #4494 from m1guelpf-forks/patch-3
- [`5939639`](https://github.com/gamerlogue/web/commit/593963979a6b6a27966aef9723b8ff08fb480b87) Merge pull request #4493 from m1guelpf-forks/patch-1
- [`18730bd`](https://github.com/gamerlogue/web/commit/18730bd0dad8d7a30aec7eb1f772e3d8a0d43216) Merge pull request #4503 from lbausch/patch-1
- [`3f0e742`](https://github.com/gamerlogue/web/commit/3f0e742421d8a922ba8a3b075189aa1bfd103ab6) Merge pull request #4504 from hasanemrebeyy/patch-1
- [`a86226a`](https://github.com/gamerlogue/web/commit/a86226a1e272e21fce45cb05754c55bc99477e43) Merge pull request #4518 from fideloper/trustedproxy
- [`0512abe`](https://github.com/gamerlogue/web/commit/0512abee6be1f311bbf34a81d6adc0039e432159) Merge pull request #4515 from dunglas/add-set-cache-headers-middleware
- [`a4402f2`](https://github.com/gamerlogue/web/commit/a4402f23afc24a495529e3915e202984964d6405) Merge pull request #4516 from pavinthan/patch-2
- [`c5a5069`](https://github.com/gamerlogue/web/commit/c5a5069ac44f6d1a54022becf42eb478e7d1bb58) Merge pull request #4517 from laurencei/patch-1
- [`f5ea753`](https://github.com/gamerlogue/web/commit/f5ea753ebe223b7c391fb057e4feb282c8c1f71c) Merge pull request #4514 from nunomaduro/master
- [`fbe47ae`](https://github.com/gamerlogue/web/commit/fbe47aec3311453c2541ebccf04a57670364a7f9) Merge pull request #4519 from themsaid/bootstrap4
- [`1f7f915`](https://github.com/gamerlogue/web/commit/1f7f915b3b6c6275c20808c40ba5b45cacf690d6) Merge pull request #4521 from SjorsO/patch-1
- [`b347461`](https://github.com/gamerlogue/web/commit/b347461f53b4dde9b17b0dffc2eecfd489e17c1e) Merge pull request #4525 from przemdz665/bootstrap-pusher-fix
- [`73cff16`](https://github.com/gamerlogue/web/commit/73cff166c79cdeaef1c6b7ec6e71a33a7ea3012d) Merge pull request #4526 from themsaid/pusherCluster
- [`54eca63`](https://github.com/gamerlogue/web/commit/54eca63612265abd61f00efe8e53a1487cd8da6c) Merge pull request #4539 from tomhorvat/patch-1
- [`179538e`](https://github.com/gamerlogue/web/commit/179538e00982e2a38ca53c8fa0fbe633d4549422) Merge pull request #4568 from jasonmccreary/patch-1
- [`7bb301b`](https://github.com/gamerlogue/web/commit/7bb301b81f6f4bcde0d634c4431e952322a682ca) Merge pull request #4557 from nikolaynizruhin/master
- [`22a2d05`](https://github.com/gamerlogue/web/commit/22a2d055f61e276e3897a6d83547c4c38a53e621) Merge pull request #4563 from zendrax/add-vscode-to-gitignore
- [`3d8ba1d`](https://github.com/gamerlogue/web/commit/3d8ba1d4d2108bce5bf5363022f3c7c70faca14e) Merge pull request #4565 from jrseliga/kirschbaum-partnership
- [`d86dd9b`](https://github.com/gamerlogue/web/commit/d86dd9b1eccbfea9c37205129c79e9fa9c376a76) Merge pull request #4570 from Vanlombardi/master
- [`ca1013d`](https://github.com/gamerlogue/web/commit/ca1013d31c44d410f4bd0ee148f590610c67ca46) Merge pull request #4572 from nikolaynizruhin/patch-1
- [`8f75f4c`](https://github.com/gamerlogue/web/commit/8f75f4c8dc504aa7408a769fd692f5216b60d52b) Merge pull request #4574 from laravel/defaults-56
- [`c09537b`](https://github.com/gamerlogue/web/commit/c09537b057bd8553b6fab790ad16b6fca0648b33) Merge pull request #4577 from arikaiy/patch-1
- [`4df852f`](https://github.com/gamerlogue/web/commit/4df852fe052f0a69870d0cc931c69deaaa5e4c74) Merge pull request #4579 from laurencei/revert-4574-defaults-56
- [`8059290`](https://github.com/gamerlogue/web/commit/8059290fa0c073221de945478b6397b85a0edfa6) Merge pull request #4581 from cesaramirez/collision
- [`bf92ec1`](https://github.com/gamerlogue/web/commit/bf92ec116e13a259a7e673cd89c38c54fc036102) Merge pull request #4583 from nikolaynizruhin/master
- [`324dda6`](https://github.com/gamerlogue/web/commit/324dda65ba08af0c039708b6c29c0fcb5eb99a1c) Merge pull request #4594 from mputkowski/patch-sftp
- [`ff2f828`](https://github.com/gamerlogue/web/commit/ff2f828c55ae9cf1cc3b0d75aa255759b63bf947) Merge pull request #4593 from freekmurze/patch-1
- [`44488ac`](https://github.com/gamerlogue/web/commit/44488acc285d3e9fd84cad2df386fb09b11b5aac) Merge pull request #4600 from laravel/sem-ver
- [`f013a48`](https://github.com/gamerlogue/web/commit/f013a48879cf35f51be23a85a938bf69756c4d6e) Merge pull request #4602 from vlakoff/not_regex
- [`c892bd3`](https://github.com/gamerlogue/web/commit/c892bd367c526a961589de7b4bdc5f983de0e81a) Merge pull request #4607 from shadoWalker89/patch-2
- [`1dfa285`](https://github.com/gamerlogue/web/commit/1dfa2851fabe2b947ad4d9db67f7e15e8af69597) Merge pull request #4665 from barryvdh/patch-3
- [`fe796d8`](https://github.com/gamerlogue/web/commit/fe796d88065e0072cea924e0cf9a211bd4d3d2d5) Merge pull request #4689 from laravel/verify-skeleton
- [`3d70f98`](https://github.com/gamerlogue/web/commit/3d70f988f673ec4a0025e143f02e6dbf054e4c02) Merge pull request #4692 from barryvdh/patch-4
- [`d4e1b93`](https://github.com/gamerlogue/web/commit/d4e1b931dc2cc77410f32b96712d5706ee475361) Merge pull request #4693 from laravel/analysis-8PAgMA
- [`1088837`](https://github.com/gamerlogue/web/commit/1088837cf31c62d5b62df5a7b2d28cc6a48751d5) Merge pull request #4698 from mpociot/add_dump_server
- [`650e627`](https://github.com/gamerlogue/web/commit/650e627eec22776a4405dab613255fd3665ce4ae) Merge pull request #4617 from rellect/npm_watch
- [`534b7ac`](https://github.com/gamerlogue/web/commit/534b7acc3f54dbeba37a78f2d4464499e8bfe818) Merge pull request #4620 from browner12/patch-1
- [`584eae0`](https://github.com/gamerlogue/web/commit/584eae0191dd93b0b533ca6e289f7063208f27c3) Merge pull request #4621 from hillelcoren/master
- [`7f936e1`](https://github.com/gamerlogue/web/commit/7f936e1c6491fc9c58ef0a2ab509d1be3e5a7ae9) Merge pull request #4624 from cubettech/patch-1
- [`3dc19a0`](https://github.com/gamerlogue/web/commit/3dc19a0d4faee5e0d800ead8c9cd0eee9871bc77) Merge pull request #4627 from szepeviktor/patch-1
- [`7e28dfa`](https://github.com/gamerlogue/web/commit/7e28dfafa2ec347c6fea5387431768468af6f731) Merge pull request #4629 from codepotato/codepotato-ses-region-patch
- [`0b89e2f`](https://github.com/gamerlogue/web/commit/0b89e2ff2016ea129adecb64b22f93ab1a81d8d5) Merge pull request #4632 from astorm/patreon
- [`479d02b`](https://github.com/gamerlogue/web/commit/479d02b0948fc3d6f244b1fe9f7ab54c09a5df05) Merge pull request #4643 from DojoGeekRA/refactor/hashing-config
- [`bc51cdd`](https://github.com/gamerlogue/web/commit/bc51cdd9f395676824fa41d98ae96e809bd564a1) Merge pull request #4654 from Alymosul/master
- [`3f92cf6`](https://github.com/gamerlogue/web/commit/3f92cf66f53b3b53467497acc0d2a00cbd7b65f0) Merge pull request #4656 from caouecs/patch-1
- [`aefda0c`](https://github.com/gamerlogue/web/commit/aefda0cfecd58e9ad782fbdb461da054d42fda8d) Merge pull request #4658 from DojoGeekRA/feature/editorconfig
- [`0869d96`](https://github.com/gamerlogue/web/commit/0869d963aa96e2a9d4ab58cb451e35e9a31b07d9) Merge pull request #4661 from driesvints/patch-1
- [`e7a74be`](https://github.com/gamerlogue/web/commit/e7a74be2822aabf3313e670539a8d77ef47fd38d) Merge pull request #4670 from amenk/patch-2
- [`d53539b`](https://github.com/gamerlogue/web/commit/d53539b47b6d2a20d0c3d3257ad801bc72547c9d) Merge pull request #4687 from mll-lab/unit-tests-first
- [`fa81e36`](https://github.com/gamerlogue/web/commit/fa81e36841ee25c3440fc430ed8d6b66c641062b) Merge pull request #4703 from thannaske/feature-maintenance-except-routes
- [`736c5ca`](https://github.com/gamerlogue/web/commit/736c5cadf41a2a4e0399bf02336162e17a2d0fe9) Merge pull request #4700 from wuwx/patch-3
- [`8512ad3`](https://github.com/gamerlogue/web/commit/8512ad31810439515d100f790363148d32e390c1) Merge pull request #4716 from martin-heralecky/patch-1
- [`7ff1f26`](https://github.com/gamerlogue/web/commit/7ff1f264e316264ca7341edecce3cf03b80d0eb3) Merge pull request #1 from Kramerican/Kramerican-patch-1
- [`3e43e6b`](https://github.com/gamerlogue/web/commit/3e43e6b1d04793c3837ad383f54aae062c085fd8) Merge pull request #4719 from Kramerican/master
- [`90b6165`](https://github.com/gamerlogue/web/commit/90b6165a2acc7d873100f358664a3df824051755) Merge pull request #4725 from calebporzio/patch-1
- [`e124fc5`](https://github.com/gamerlogue/web/commit/e124fc5f120ce109958aca01cd67a0ec476035f1) Merge pull request #4727 from Advaith3600/patch-1
- [`b2d7fac`](https://github.com/gamerlogue/web/commit/b2d7facfbbd1f01e4dfe523e4b2d7a2a9d85bbc5) Merge pull request #4730 from ahinkle/ahinkle-patch-1
- [`663f7c2`](https://github.com/gamerlogue/web/commit/663f7c2c05fab2083eb2bc559f86d4e9776a9a32) Merge pull request #4735 from vemcogroup/master
- [`c29266a`](https://github.com/gamerlogue/web/commit/c29266a0c086dfcfda453fc7c96619cf13a9920b) Merge pull request #4736 from nunomaduro/patch-1
- [`4374769`](https://github.com/gamerlogue/web/commit/43747693bdec524119a985f53ebf8b8c1f631492) Merge pull request #4741 from mattmcdonald-uk/develop
- [`6cce530`](https://github.com/gamerlogue/web/commit/6cce5303c7a1ac39f50b27838fa074f102807b3f) Merge pull request #4742 from voyula/master
- [`2d70aaa`](https://github.com/gamerlogue/web/commit/2d70aaa286d6c20ac50804e59035ee8ae61c22de) Merge pull request #4744 from staudenmeir/pagination
- [`abdefb6`](https://github.com/gamerlogue/web/commit/abdefb66028c0a7cb31dc5907b22db3fe2f51cdb) Merge pull request #4746 from PHLAK/patch-1
- [`4a27987`](https://github.com/gamerlogue/web/commit/4a27987fa69770dadcecae0adfed263470ad5376) Merge pull request #4748 from SjorsO/master
- [`8c41eae`](https://github.com/gamerlogue/web/commit/8c41eae20023fc76719c0ebfeb628008486a49d8) Merge pull request #4747 from eliurkis/patch-1
- [`ad7ce02`](https://github.com/gamerlogue/web/commit/ad7ce02254799798ddc43dfa65d5ea97db72b12e) Merge pull request #4752 from ubient/add-mailgun-endpoint-option
- [`5ad5cdc`](https://github.com/gamerlogue/web/commit/5ad5cdce8c785d09e1205ba890f81f3002dadda3) Merge pull request #4750 from kp-syginteractive/master
- [`b6d00db`](https://github.com/gamerlogue/web/commit/b6d00dba46f3adebca8dbf46fb35839cd5f18d44) Merge pull request #4573 from laravel/defaults-55
- [`3a50f43`](https://github.com/gamerlogue/web/commit/3a50f43c3be644f6168bf888af272425efb8f65c) Merge pull request #4580 from laurencei/revert-4573-defaults-55
- [`011bb6c`](https://github.com/gamerlogue/web/commit/011bb6c1d37983a614f277f6d7844060f878a42d) Merge pull request #4753 from laravel/next
- [`1cb18d1`](https://github.com/gamerlogue/web/commit/1cb18d11acfc918529c1747ee5138f35a467f065) Merge pull request #4794 from jakebathman/change-password-min-length-to-8
- [`e830a3a`](https://github.com/gamerlogue/web/commit/e830a3af0251e38e9cb64bad795f97f6f303c239) Merge pull request #4797 from connectkushal/patch-2
- [`56b8c01`](https://github.com/gamerlogue/web/commit/56b8c01080f40073f09c4c644e4e4a4554ba63a6) Merge pull request #4814 from TBlindaruk/added-default-401-image
- [`b1763fe`](https://github.com/gamerlogue/web/commit/b1763fe180ba2cff8bed72ec0f4d3e4f02466133) Merge pull request #4878 from TBlindaruk/delete-401.svg
- [`cdb0362`](https://github.com/gamerlogue/web/commit/cdb0362b4e25960955aad7c171e383042ef8dfca) Merge pull request #4756 from laurencei/master
- [`1e80b8c`](https://github.com/gamerlogue/web/commit/1e80b8ce3cacb22800883dd33273eec8e438adf5) Merge pull request #4757 from rookwood/patch-1
- [`cc1dd54`](https://github.com/gamerlogue/web/commit/cc1dd54ead190ce7373f7d1e5be6459dd20fe6c1) Merge pull request #4760 from NFarrington/persist-cache-data-directory
- [`bac6cae`](https://github.com/gamerlogue/web/commit/bac6cae21e84f5c6dd17c065c6d32100ba02d1ee) Merge pull request #4761 from gauravmak/patch-1
- [`f507c0e`](https://github.com/gamerlogue/web/commit/f507c0eda93002a5f50cb9e7b1ad688cbde6106e) Merge pull request #4762 from olipayne/master
- [`7028b17`](https://github.com/gamerlogue/web/commit/7028b17ed8bf35ee2f1269c0f9c985b411cb4469) Merge pull request #4763 from tillkruss/ansi
- [`8e87b14`](https://github.com/gamerlogue/web/commit/8e87b147bc873eca2da944b965d147e71f7dcbde) Merge pull request #4767 from bertheyman/daily-logs-by-default
- [`f0f912e`](https://github.com/gamerlogue/web/commit/f0f912ef2b519a3d965b73ebe8f13ce7f034b44e) Merge pull request #4775 from yajra/patch-register
- [`faaabe1`](https://github.com/gamerlogue/web/commit/faaabe1cefe458a9571107aaf4240095dbe6f86a) Merge pull request #4777 from SammyK/make-app-path-stream-safe
- [`4b0c1d2`](https://github.com/gamerlogue/web/commit/4b0c1d242d90efb69046c5998a0909e7cf4cec24) Merge pull request #4780 from zaknesler/patch-1
- [`5b7f3b2`](https://github.com/gamerlogue/web/commit/5b7f3b20617f2bbc38d6bda6f4aa02cff4a386f6) Merge pull request #4781 from ankurk91/patch/lang-attribute
- [`877e2d7`](https://github.com/gamerlogue/web/commit/877e2d7fdab3af487a16c8404b406e999fb99950) Merge pull request #4782 from eduarguzher/patch/validation-translation
- [`6735b84`](https://github.com/gamerlogue/web/commit/6735b84ccc4f263f54190658eb402f0637338b5d) Merge pull request #4783 from laravel/laurencei-patch-1
- [`a273cea`](https://github.com/gamerlogue/web/commit/a273cea667438858b8b3d8459021ade9e3eb18a1) Merge pull request #4791 from staudenmeir/pagination
- [`c9e612f`](https://github.com/gamerlogue/web/commit/c9e612f51026ecdeb0f5b13e9d8f4322dceefec7) Merge pull request #4803 from driesvints/cashier-add-verify-webhook-config-values
- [`b637ee3`](https://github.com/gamerlogue/web/commit/b637ee304ce783d5c5137ddc4d3de0af10735a5e) Merge pull request #4805 from driesvints/fix-api-redirect
- [`c089067`](https://github.com/gamerlogue/web/commit/c0890674934b6d767e1fb2160b097efd8ed4bd93) Merge pull request #4822 from borisdamevin/patch-2
- [`05e5419`](https://github.com/gamerlogue/web/commit/05e54193ba97719983a87e1944d436e8423cc1aa) Merge pull request #4820 from brainmaniac/patch-1
- [`39562b4`](https://github.com/gamerlogue/web/commit/39562b452a742095a03546e7241c8ee77eba5c3b) Merge pull request #4830 from cyberhicham/master
- [`4c63c84`](https://github.com/gamerlogue/web/commit/4c63c840737183f7aba4df1561f0b6f757073f0e) Merge pull request #4831 from michaelmano/master
- [`f9cf7ff`](https://github.com/gamerlogue/web/commit/f9cf7ff1c834bd918a21930288d12d04e0f15a00) Merge pull request #4832 from daniel-banciulea/master
- [`6ee6f64`](https://github.com/gamerlogue/web/commit/6ee6f6423b18386ef2d164326806baba4d185183) Merge pull request #4833 from DojoGeekRA/feature/phpunit.xml
- [`51c0f51`](https://github.com/gamerlogue/web/commit/51c0f51acb4b8039f73cf4f6d91d74811705a456) Merge pull request #4834 from clemir/uuid-validation
- [`8c4293d`](https://github.com/gamerlogue/web/commit/8c4293d22bd8e6453e273cb0294488a24197db1e) Merge pull request #4837 from bbashy/patch-1
- [`79e8ff4`](https://github.com/gamerlogue/web/commit/79e8ff4290c61a6e0f4b49732053919801581133) Merge pull request #4838 from dakira/fk-support
- [`122e99c`](https://github.com/gamerlogue/web/commit/122e99c1fbc55f82c8e2a2d38e099202fd022058) Merge pull request #4836 from laurencei/laurencei-patch-1
- [`5d7936e`](https://github.com/gamerlogue/web/commit/5d7936eeb079ed8b403da422eb24783cdb9732fc) Merge pull request #4841 from narwy/patch-1
- [`dc3e768`](https://github.com/gamerlogue/web/commit/dc3e768d4cb3c77056da6076f0e725327aa85ad1) Merge pull request #4853 from aryehraber/patch-2
- [`a2c8df5`](https://github.com/gamerlogue/web/commit/a2c8df54f72f9b032fb27e00636cb695942220bf) Merge pull request #4854 from aryehraber/patch-1
- [`6806aaa`](https://github.com/gamerlogue/web/commit/6806aaa3568382e9c8c7281a64b82a52b824e46f) Merge pull request #4856 from localheinz/feature/composer-normalize
- [`fcb7d35`](https://github.com/gamerlogue/web/commit/fcb7d357301f40b3d1c4765177bc247d48ac9e3f) Merge pull request #4863 from staudenmeir/validation
- [`3f09521`](https://github.com/gamerlogue/web/commit/3f09521d01783c1ceec23cd44600a6984733b93e) Merge pull request #4861 from unstoppablecarl/middleware-priority-comment
- [`2a483bb`](https://github.com/gamerlogue/web/commit/2a483bbf60566cab6fbd0340fb3877fc09889bc3) Merge pull request #4865 from eugenesaenko/patch-1
- [`7adea12`](https://github.com/gamerlogue/web/commit/7adea122a57932cf570c8a0693e65aed5adf0ee2) Merge pull request #4867 from ajthinking/patch-1
- [`b926f2e`](https://github.com/gamerlogue/web/commit/b926f2e1142e826eda21948481d5afd0ad4c2552) Merge pull request #4866 from driesvints/add-starts-with-rule
- [`4da373d`](https://github.com/gamerlogue/web/commit/4da373d6b2041469638a469d6b2f7a924463482c) Merge pull request #4870 from driesvints/update-changelog
- [`ddd8c2a`](https://github.com/gamerlogue/web/commit/ddd8c2a7908a91e2efbbf916e2cd3806999a5357) Merge pull request #4884 from eric-famiglietti/patch-1
- [`096c237`](https://github.com/gamerlogue/web/commit/096c23772718bbb0c6700fa5aba5f8ffd3b125fd) Merge pull request #4896 from goodjack/patch-1
- [`2949443`](https://github.com/gamerlogue/web/commit/29494438f1206fcd66fb89a046d78b5f15c39475) Merge pull request #4899 from tiagocyberduck/master
- [`2d2c089`](https://github.com/gamerlogue/web/commit/2d2c089a4a79078e7c07901eba130b1e987a08be) Merge pull request #4904 from Te7a-Houdini/modify-redirect-if-auth-middleware-to-allow-multiple-guards
- [`2b14e0e`](https://github.com/gamerlogue/web/commit/2b14e0e96bfc2c900734bc11e57d2396591d71c9) Merge pull request #4913 from yuloh/beanstalkd-blocking-pop-config
- [`7b675ab`](https://github.com/gamerlogue/web/commit/7b675abe4bcecea0ee1e74267c5037272a0c5302) Merge pull request #4939 from driesvints/phpunit8
- [`0904307`](https://github.com/gamerlogue/web/commit/0904307e6a974320818aeb5ff083e151977da25d) Merge pull request #4943 from crynobone/patch-1
- [`1f0640f`](https://github.com/gamerlogue/web/commit/1f0640f99d045ca2eeec7c87a5c6644c197f466b) Merge pull request #4917 from driesvints/remove-unused-bootstrap-class
- [`4ce439c`](https://github.com/gamerlogue/web/commit/4ce439c21b7d5a832cfe5f4dca59c34c74cac882) Merge pull request #4921 from SjorsO/master
- [`7ba612b`](https://github.com/gamerlogue/web/commit/7ba612b3ef50ae7452ed5df82cc03df4a9bd40a2) Merge pull request #4924 from fideloper/patch-2
- [`6efb843`](https://github.com/gamerlogue/web/commit/6efb843e7de5e18ed7c1b0061346cbd46d465827) Merge pull request #4926 from kawax/str
- [`ed60178`](https://github.com/gamerlogue/web/commit/ed60178bcc0fc926543b1b4b367737a8a47c8ba8) Merge pull request #4929 from AbdelElrafa/master
- [`3702622`](https://github.com/gamerlogue/web/commit/3702622461682142ff46ef342ee8741dada69e8d) Merge pull request #4930 from epalmans/master
- [`f1702e9`](https://github.com/gamerlogue/web/commit/f1702e9c7dc194e8589077aa4b401c95619f70b1) Merge pull request #4931 from simoebenhida/master
- [`049c7c9`](https://github.com/gamerlogue/web/commit/049c7c9f7540c0097c406dbb0f8df7624051c2c8) Merge pull request #4933 from laravel/revert-4931-master
- [`4318268`](https://github.com/gamerlogue/web/commit/43182688cfb807fdfa34c7a84b0c726e126248ba) Merge pull request #4935 from eddybrando/feat/remove-unnecessary-link-type
- [`864b1de`](https://github.com/gamerlogue/web/commit/864b1de19ba77b15889622756e2e992e1fcd4377) Merge pull request #4934 from JakeConnors376W/patch-1
- [`b5b2341`](https://github.com/gamerlogue/web/commit/b5b2341fd63dde5372af4b95cf7369e2d70ba0a4) Merge pull request #4949 from laravel/revert-4904-modify-redirect-if-auth-middleware-to-allow-multiple-guards
- [`b681370`](https://github.com/gamerlogue/web/commit/b681370492d2903d5016d5be0ba401c6a4078506) Merge pull request #4946 from ankurk91/patch/big-int
- [`505a891`](https://github.com/gamerlogue/web/commit/505a891db69cc5d217ca2cf588c517b64486392d) Merge pull request #4952 from andrewgorpenko/andrewgorpenko-patch-1
- [`752ca6d`](https://github.com/gamerlogue/web/commit/752ca6db17b47dfd6d6fe6548e3cd9e14ebe14c3) Merge pull request #4951 from CupOfTea696/feature/add-arr-and-str-aliases
- [`d4d4a69`](https://github.com/gamerlogue/web/commit/d4d4a69b76d1dfd87b47b7a51b4c0e2aed992793) Merge pull request #4956 from akalongman/master
- [`3b852a1`](https://github.com/gamerlogue/web/commit/3b852a1f7f292953f47df64563cc01188db336ff) Merge pull request #4963 from chapeupreto/patch-1
- [`3886012`](https://github.com/gamerlogue/web/commit/3886012c0f3ad5653d9d5138530f3fc4276eaf93) Merge pull request #4971 from Lenophie/patch-1
- [`ae44ee0`](https://github.com/gamerlogue/web/commit/ae44ee0059f6218aab26de5551b19f70329f8832) Merge pull request #4979 from hyperhost/add-hyper-host-sponsor
- [`3537492`](https://github.com/gamerlogue/web/commit/35374927bd570d578f7db4a715f2a64a2ce561c1) Merge pull request #4982 from DivineOmega/patch-1
- [`005ec13`](https://github.com/gamerlogue/web/commit/005ec1301e3600c0a5d5a8355495d4333cab138b) Merge pull request #4986 from DivineOmega/patch-1
- [`20cdf65`](https://github.com/gamerlogue/web/commit/20cdf65ae61ca7cfa45292d3dd642a252147ecc8) Merge pull request #4987 from DivineOmega/patch-1
- [`0f58190`](https://github.com/gamerlogue/web/commit/0f58190c7ba955cf7a58b47a9469bf4c6c992abb) Merge pull request #4989 from DrewRoberts/update-readme-laracasts
- [`06162ad`](https://github.com/gamerlogue/web/commit/06162adc9839ada8b2525e006bef6b80914296d6) Merge pull request #4990 from SjorsO/patch-1
- [`81fba47`](https://github.com/gamerlogue/web/commit/81fba471aff24793be8ee3ee0d303d2b31056df2) Merge pull request #4998 from laravel/analysis-z9QV6a
- [`af15618`](https://github.com/gamerlogue/web/commit/af15618b577be04fc999e3f11880d05f030d39ce) Merge pull request #5013 from laravel/revert-5012-feature/exported-files
- [`89e8391`](https://github.com/gamerlogue/web/commit/89e83915e94142ae79db7480561ae8a7a525e114) Merge pull request #5175 from canvural/patch-1
- [`25c36eb`](https://github.com/gamerlogue/web/commit/25c36eb592c57e075acc32a12703005f67c4ec10) Merge pull request #5196 from laravel/revert-5006-analysis-qxPGgA
- [`9d0862b`](https://github.com/gamerlogue/web/commit/9d0862b3340c8243ee072afc181e315ffa35e110) Merge pull request #5201 from aimeos/master
- [`f140d92`](https://github.com/gamerlogue/web/commit/f140d926d3c24e854578a9eb6a2b2f7fe763abf5) Merge pull request #5271 from winter-ice/master
- [`103fc0b`](https://github.com/gamerlogue/web/commit/103fc0b4513d9ffbc33ebb31f74f9fba81d2b100) Merge pull request #5278 from voyula/patch-1
- [`74df1e2`](https://github.com/gamerlogue/web/commit/74df1e26e639f0527429fba8185b743e6538d3ac) Merge pull request #5320 from barryvdh/patch-4
- [`17e2ce7`](https://github.com/gamerlogue/web/commit/17e2ce73edb6f8eae9879f988898de809020bbf6) Merge pull request #5324 from nunomaduro/patch-1
- [`6d9296c`](https://github.com/gamerlogue/web/commit/6d9296c71edc3def466d3cab501b7d1f9b6717d2) Merge pull request #5346 from ahinkle/patch-1
- [`074c384`](https://github.com/gamerlogue/web/commit/074c3840ff6be2c562d97ec0d68a04b0699493a1) Merge pull request #5355 from laravel/bump
- [`39a5871`](https://github.com/gamerlogue/web/commit/39a58710ba3e5aff0b3588fe748fa24e066d17b0) Merge pull request #5370 from laravel/bump-7
- [`bbd3616`](https://github.com/gamerlogue/web/commit/bbd36167158f29148095085fa81fed211ad676d2) Merge pull request #5369 from laravel/bump-6
- [`d57cc57`](https://github.com/gamerlogue/web/commit/d57cc57c6d8101cd3001cc5c2285649977e3f36c) Merge pull request #5669 from laravel/8.x
- [`9c182f8`](https://github.com/gamerlogue/web/commit/9c182f861dabdaf1ce86dd60ca147af07201b4a7) Merge pull request #5762 from freekmurze/master
- [`726e0bb`](https://github.com/gamerlogue/web/commit/726e0bb10f1444dc0387b876773eb927a4a1971e) Merge pull request #5763 from laravel/revert-5762-master
- [`4db44f8`](https://github.com/gamerlogue/web/commit/4db44f80e571c8904f2209cfe3f058e61b641d8a) Merge pull request #5774 from morrislaptop/user-factory-type
- [`f7bc33d`](https://github.com/gamerlogue/web/commit/f7bc33d584a33e3c6667be71ebf21a970728a4b5) Merge pull request #5797 from ArnaudLier/patch-1
- [`9477122`](https://github.com/gamerlogue/web/commit/94771229eaf6039a97dbdd84b09a4525732b7e97) Merge pull request #5795 from emaia/patch-1
- [`a49d1c2`](https://github.com/gamerlogue/web/commit/a49d1c2aa100f588227edc69ed6f1bbc8c57a4b9) Merge pull request #5806 from axlon/patch-1
- [`90be1e3`](https://github.com/gamerlogue/web/commit/90be1e323e11afaa2bdf86ee6eb4d5fea5c246e8) Merge pull request #5807 from u01jmg3/9.x
- [`c21f6c6`](https://github.com/gamerlogue/web/commit/c21f6c6ddcaa7781375de56c1c5706e0f9a534c5) Merge pull request #6765 from laravel/12.x
- [`5c85503`](https://github.com/gamerlogue/web/commit/5c855038d032b9969067f01e53109704dbd28b2f) Merge pull request #6779 from aziyan99/chore/fix-missing-comma-in-package-dot-json
- [`9a0ba30`](https://github.com/gamerlogue/web/commit/9a0ba307d78d8df1380f6bdadde958698f318102) Merge pull request #6829 from laravel/chore/github-actions-hardening
- [`2de748a`](https://github.com/gamerlogue/web/commit/2de748a9f6f6bc8cf0251419f9a7332b19c62ed8) Merge pull request #6830 from laravel/dependabot/github_actions/github-actions-6a98abd9ac
- [`eaefd14`](https://github.com/gamerlogue/web/commit/eaefd14f19a955b584ca052433a8dde153616539) Merge pull request #6831 from laravel/fix/pin-least-privilege-reusable-workflows
- [`cef9fa2`](https://github.com/gamerlogue/web/commit/cef9fa22ba049e532e6f03dd6dc408454f9a5324) Merge pull request #6832 from laravel/chore/pin-reusable-workflows-latest

