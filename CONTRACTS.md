# API contracts: Profile section

The single source of truth for the client. Covers the phases implemented so far: **Phase 1**
(public profile and statistics). Later phases will be added here.

## Common conventions

- Base path `/api`. Everything requires Sanctum authentication: a bearer token (native client) or
  a session + XSRF (web). Without authentication: `401`.
- API Platform resources speak JSON:API: `Accept`/`Content-Type: application/vnd.api+json`.
  Endpoints marked **plain JSON** answer `application/json`.
- Token abilities: `profile` for `users`; `library` for `library_entries` and statistics. A
  token without the required ability gets `403`.
- Collections: `page=N` (from 1), a fixed 30 items, `page[size]` ignored, `meta.totalItems` always
  present.
- Timestamps carry time and offset (`2026-01-01T00:00:00+01:00`); plain dates (`start_date`,
  `end_date`) stay `YYYY-MM-DD`.
- IGDB ids (games, platforms) are positive integers, not checked against IGDB.
- Attributes whose value is `null` are omitted from responses (existing behaviour): treat a missing
  attribute as `null`. An attribute hidden by visibility rules is missing the same way.

### Errors

A JSON:API document `{"errors": [{...}]}`. Every error has `status` (a string) and `code`.

| `code` | Status | Meaning |
|---|---|---|
| `profile_private` | 403 | The profile is private and the caller is not its owner |
| *HTTP status* (`"401"`, `"403"`, `"404"`…) | same as the code | Generic errors: the `code` is the status, as today |
| `<id>/data.attributes.<field>` | 422 | Attribute validation (unchanged): one error per field, the field is the suffix after `/` |

The client must tell cases apart by `code`, never by `title` or `detail`, which are free text.
Specific codes are also sent in the `X-Error-Code` header.

---

## User

Resource type `User`, UUID id.

### Endpoints

| Method and path | Access |
|---|---|
| `GET /users` | Without `filter[search]`: holds only the current user (unchanged) |
| `GET /users?filter[search]=<text>` | Searches every user, private ones included (with the reduced profile) |
| `GET /users/{id}` | Any user; the visible fields depend on ownership and visibility |
| `PATCH /users/{id}` | Owner only; `404` for anyone else |

### Attributes

| Attribute | Type | Writable | Visible to | Constraints |
|---|---|---|---|---|
| `nickname` | string? | yes | everyone | 3–30 characters among letters (accented ones too), digits, `_`, `.`, `-`; unique regardless of case |
| `name` | string | yes | everyone | `first_name` + `last_name` |
| `picture` | string? | yes | everyone | URL, max 2048. Comes from the identity provider |
| `visibility` | `public` \| `private` | yes | everyone | default `public` |
| `first_name`, `last_name` | string? | yes | visible profile | max 255 |
| `bio` | string? | yes | visible profile | max 500 |
| `banner_game_id` | int? | yes | visible profile | positive integer; null together with `banner_image_id`, or set together |
| `banner_image_id` | string? | yes | visible profile | IGDB `image_id`, max 255 |
| `platforms_ids` | int[] | yes | visible profile | IGDB platforms the user **owns**; positive integers, no duplicates. Not to be confused with `LibraryEntry.platforms_ids`, the platforms of that entry |
| `created_at`, `updated_at` | datetime | no | visible profile | |
| `email` | string | no | owner only | |
| `email_verified_at` | datetime? | no | owner only | |
| `picture_edit_url` | string? | no | owner only | null when the server has none configured |

"Visible profile" means the caller is the owner or the profile is `public`. On a private profile
everyone else gets only `id`, `nickname`, `name`, `picture` and `visibility`. The same rules apply
when `User` is included as a relationship (e.g. `library_entries?include=user`).

A `nickname` identical to the current one is always accepted, even if it predates these rules, so a
PATCH that sends back the whole profile does not fail on a legacy nickname with spaces.

### Filters

- `filter[search]`: max 100 characters. Every word (space separated) must appear in `nickname`,
  `first_name` or `last_name`, regardless of case. `%` and `_` are literal. It covers private
  profiles too: their `name` (first + last name) is part of the public card anyway, so the search
  reveals nothing more.

### Errors

`404` unknown user, or PATCH on another user · `403` token without `profile` · `422` validation.

### Example

```http
PATCH /api/users/0199…
Content-Type: application/vnd.api+json

{"data": {"type": "User", "id": "0199…", "attributes": {
  "bio": "I play everything", "banner_game_id": 1942, "banner_image_id": "sc6xyz",
  "visibility": "private"}}}
```

```json
{"data": {"id": "0199…", "type": "User", "attributes": {
  "nickname": "maicol", "name": "Maicol B", "visibility": "private",
  "bio": "I play everything", "banner_game_id": 1942, "banner_image_id": "sc6xyz",
  "platforms_ids": [],
  "email": "me@example.com", "email_verified_at": "2026-01-01T00:00:00+01:00",
  "picture_edit_url": "https://account.example.com/profile",
  "created_at": "2026-01-01T00:00:00+01:00", "updated_at": "2026-10-17T15:00:00+02:00"}}}
```

The same user seen by someone else:

```json
{"data": {"id": "0199…", "type": "User", "attributes": {
  "nickname": "maicol", "name": "Maicol B", "visibility": "private"}}}
```

---

## LibraryEntry (changes)

Existing endpoints, attributes, filters and sorts are unchanged. Additions:

### Attributes

| Attribute | Type | Writable | Notes |
|---|---|---|---|
| `review_spoiler` | bool | yes | default `false` |
| `review_updated_at` | datetime? | no (ignored if sent) | changes only when the `review` text changes; `null` ↔ `""` is not an edit |

### Filters and sort

| Parameter | Values | Semantics |
|---|---|---|
| `filter[user]` | UUID | That user's library. A private profile that is not yours: `403 profile_private`. Invalid UUID: `422` |
| `current_user=true` | | The caller's library, even alongside `filter[user]` (unchanged) |
| `filter[has_review]` | `true` \| `false` | `true` = `review` neither null nor empty. Other values: `422` |
| `sort` | adds `review_updated_at` | e.g. `sort=-review_updated_at` |

Another user's entries are read-only: PATCH/DELETE stay `404`. `GET /library_entries/{id}` stays
limited to your own entries.

### Example

```http
GET /api/library_entries?filter[user]=0199…&filter[has_review]=true&sort=-review_updated_at&include=user
```

```json
{"errors": [{"status": "403", "code": "profile_private", "title": "An error occurred",
  "detail": "This profile is private."}]}
```

(the answer when profile `0199…` is private)

---

## Statistics: `GET /users/{id}/stats`

**Plain JSON**, not JSON:API: a computed summary, not a resource. Ability `library`. A private
profile that is not yours: `403 profile_private`.

`?year=YYYY` (1900–9999, otherwise `422`) limits it to that year's entries. An entry belongs to the
year of its `end_date`, else of its `start_date`, else of the moment it was added.

| Field | Type | Content |
|---|---|---|
| `status_counts` | `{STATUS: int}` | every `status` key, zeros included |
| `completion_status_counts` | `{COMPLETION_STATUS: int}` | every `completion_status` key, zeros included |
| `owned_count` | int | entries with `owned = true` |
| `total_played_time` | int | sum of `played_time`, in the same unit |
| `average_rating` | float? | mean of the existing ratings, 2 decimals; null without ratings |
| `rating_histogram` | int[11] | bucket `N` counts ratings in `[10N, 10N+10)`; 100 goes into bucket 10 |
| `platforms` | `[{platform_id, entries_count, played_time}]` | per IGDB platform, sorted by id; a platform repeated within an entry counts once |
| `completed_by_year` | `{"YYYY": int}` | `COMPLETED` entries by year of `end_date` |
| `started_by_year` | `{"YYYY": int}` | entries by year of `start_date` |
| `reviews_count` | int | entries with a non-empty review |

The result is cached per user and year. Any write to an entry invalidates it immediately; bulk
changes made outside the model show up within a day.

```json
{"status_counts": {"PLAYING": 1, "COMPLETED": 2, "PAUSED": 0, "ABANDONED": 0, "BACKLOG": 1},
 "completion_status_counts": {"MAIN_STORY": 1, "FULL_100": 1, "…": 0},
 "owned_count": 2, "total_played_time": 90, "average_rating": 79.17,
 "rating_histogram": [0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1],
 "platforms": [{"platform_id": 6, "entries_count": 2, "played_time": 80}],
 "completed_by_year": {"2024": 1, "2026": 1}, "started_by_year": {"2025": 1},
 "reviews_count": 2}
```

---

## Choices left to the server

| Topic | Choice |
|---|---|
| Nickname rules | 3–30 characters among Unicode letters, digits, `_`, `.`, `-`; unique regardless of case (unique index on `LOWER(nickname)`) |
| Nickname from the identity provider | Set only when the user has none and it is not taken; it no longer overwrites the one the user chose |
| `picture_edit_url` | There is a single OIDC provider: the URL is `OIDC_PICTURE_EDIT_URL`, null when not configured |
| Statistics format | Plain JSON, keys described above |
| Played time unit | `played_time` has no unit defined server-side: statistics sum the value as is (`total_played_time`) |
| Rating scale | 0–100, as the existing validation says; histogram in tens |

## Not implemented or deferred

- Blocks and their effects on profiles and search: Phase 3.
- Lists, followers/following and activities under the `profile_private` rule: they come with
  their phases.

## Differences from the existing contract

- `GET /users/{id}` for another user: `404` before, now `200` under the visibility rules.
- The owner gets `email` (never exposed before) and `email_verified_at`.
- On a private profile, others no longer see `first_name`, `last_name`, `created_at`, `updated_at`.
- The OIDC login no longer overwrites `nickname` on every sign-in.

Everything else (pagination, `current_user=true`, `library_entries` filters and sorts, date format,
generic errors) is unchanged.

Note: `page[offset]` is currently accepted by API Platform as a page number (`page[offset]=2` ≡
`page=2`), not rejected. It stays that way.
