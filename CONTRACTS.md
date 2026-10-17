# API contracts: Profile section

The single source of truth for the client. Covers the phases implemented so far: **Phase 1**
(public profile and statistics), **Phase 2** (lists) and **Phase 3** (social: follows, blocks,
reports, activities). Later phases will be added here.

## Common conventions

- Base path `/api`. Everything requires Sanctum authentication: a bearer token (native client) or
  a session + XSRF (web). Without authentication: `401`.
- API Platform resources speak JSON:API: `Accept`/`Content-Type: application/vnd.api+json`.
  Endpoints marked **plain JSON** answer `application/json`.
- Token abilities: `profile` for `users`, follows, blocks and reports; `library` for
  `library_entries`, lists, statistics and activities. A
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
| `user_blocked` | 403 | The caller and the profile's owner are in a block, whoever blocked whom |
| `cannot_follow_self` | 422 | Following yourself |
| `cannot_block_self` | 422 | Blocking yourself |
| `invalid_import_batch` | 422 | A malformed `X-Library-Import` header (see Activities) |
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
| `GET /users/{id}` | Any user outside a block (otherwise `403 user_blocked`); the visible fields depend on ownership and visibility |
| `GET /users/{id}/followers` | Who follows that user. Visible profile required: `403 profile_private` / `user_blocked` |
| `GET /users/{id}/following` | Whom that user follows, same rules |
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
| `followers_count`, `following_count` | int | no | visible profile | |
| `is_followed_by_me` | bool | no | visible profile | the caller follows this user |
| `follows_me` | bool | no | visible profile | this user follows the caller |
| `email` | string | no | owner only | |
| `email_verified_at` | datetime? | no | owner only | |
| `picture_edit_url` | string? | no | owner only | null when the server has none configured |

"Visible profile" means the caller is the owner, or the profile is `public` and neither user
blocked the other. On a private profile
everyone else gets only `id`, `nickname`, `name`, `picture` and `visibility`. The same rules apply
when `User` is included as a relationship (e.g. `library_entries?include=user`).

A `nickname` identical to the current one is always accepted, even if it predates these rules, so a
PATCH that sends back the whole profile does not fail on a legacy nickname with spaces.

### Filters

- `filter[search]`: max 100 characters. Every word (space separated) must appear in `nickname`,
  `first_name` or `last_name`, regardless of case. `%` and `_` are literal. It covers private
  profiles too: their `name` (first + last name) is part of the public card anyway, so the search
  reveals nothing more. Users in a block with the caller are left out.

`/users/{id}/followers` and `/users/{id}/following` leave out users in a block with the caller.

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

## List and ListItem

Resource types `List` (integer id) and `ListItem` (integer id). Ability `library`.

### Endpoints

| Method and path | Access |
|---|---|
| `GET /lists` | Your lists, private ones included |
| `GET /lists?filter[user]=<uuid>` | That user's **public** lists; private profile: `403 profile_private` |
| `GET /lists/{id}` | Yours, or public on a visible profile. Someone else's private list: `404`. Private profile: `403 profile_private` |
| `POST /lists` | Creates a list of yours |
| `PATCH /lists/{id}`, `DELETE /lists/{id}` | Owner only; `404` for anyone else. Deleting also deletes its games |
| `GET /list_items?filter[list]=<id>` | The games of a list, under the list's rules (someone else's private list: empty `data`) |
| `GET /list_items` | Without `filter[list]`: the games of all your lists |
| `GET /list_items/{id}` | As the list holding it |
| `POST /list_items` | Adds a game to one of **your** lists |
| `PATCH /list_items/{id}`, `DELETE /list_items/{id}` | List owner only; `404` for anyone else |
| `POST /lists/{id}/reorder` | **Plain JSON**, owner only (otherwise `404`): see below |

### `List` attributes

| Attribute | Type | Writable | Constraints |
|---|---|---|---|
| `name` | string | yes | required on creation, max 100 |
| `description` | string? | yes | max 5000 |
| `visibility` | `public` \| `private` | yes | default `public` |
| `is_ranked` | bool | yes | default `false`; a real JSON boolean, not `"true"` |
| `items_count` | int | no | |
| `user_id` | uuid | no | always the caller on creation |
| `created_at`, `updated_at` | datetime | no | reordering touches `updated_at` |

Relationships: `user` (User), `items` (ListItem, in `position` order). `include=user,items`.

### `ListItem` attributes

| Attribute | Type | Writable | Constraints |
|---|---|---|---|
| `list_id` | int | on creation only | required, must be one of your lists (otherwise `422`) |
| `game_id` | int | on creation only | required, positive integer; unique within the list (`422` if already there). The game need not be in the library |
| `position` | int | yes | ≥ 0; when omitted on creation it goes last (last + 1). Not unique: ties fall back to creation order |
| `note` | string? | yes | max 2000 |
| `created_at`, `updated_at` | datetime | no | |

Relationship: `list`. `include=list`. To move a game to another list, delete and recreate it.
Relationships are not writable: use `list_id`.

### Filters and ordering

| Parameter | Resource | Semantics |
|---|---|---|
| `filter[user]` | `List` | uuid; that user's public lists instead of yours |
| `current_user=true` | `List` | always yours, even alongside `filter[user]` |
| `filter[contains_game]` | `List` | IGDB id; only the lists holding the game, among those already selected (yours, or the public ones of `filter[user]`) |
| `filter[list]` | `ListItem` | the list id |

`List` is ordered by creation; `ListItem` by `position`, then creation. Standard pagination.

### Reordering

```http
POST /api/lists/12/reorder
Content-Type: application/json

{"ids": [31, 29, 30]}
```

`ids` holds **every** id of the list's games, once each, in the desired order: the index in the
array becomes `position` (from 0). Answers `204`. Transactional: if `ids` does not match the list's
games exactly (missing, duplicated, from other lists, not integers) the answer is `422` and nothing
changes.

### Errors

`404` unknown list/game, someone else's private one, or a write to someone else's list · `403
profile_private` · `403` token without `library` · `422` validation.

### Example

```http
POST /api/list_items
Content-Type: application/vnd.api+json

{"data": {"type": "ListItem", "attributes": {"list_id": 12, "game_id": 1942, "note": "The best"}}}
```

```json
{"data": {"id": "31", "type": "ListItem", "attributes": {
  "list_id": 12, "game_id": 1942, "position": 3, "note": "The best",
  "created_at": "2026-10-17T16:00:00+02:00", "updated_at": "2026-10-17T16:00:00+02:00"},
  "relationships": {"list": {"data": {"type": "List", "id": "12"}}}}}
```

---

## Follow and Block

Resource types `Follow` and `Block` (integer ids), ability `profile`. Both are the caller's own:
the collection lists only theirs, and someone else's is a `404`.

| Method and path | Effect | Errors |
|---|---|---|
| `GET /follows` | Whom the caller follows; `filter[followable_id]=<uuid>` tells whether they follow that user | |
| `POST /follows` | Follow `followable_id` | `422 cannot_follow_self` · `403 profile_private` · `403 user_blocked` · `422` unknown or already followed user |
| `GET /follows/{id}`, `DELETE /follows/{id}` | Read, unfollow. Unfollowing is always allowed, even once the profile is private or in a block | `404` |
| `GET /blocks` | Whom the caller blocked | |
| `POST /blocks` | Block `blocked_id`; also ends the follows in both directions | `422 cannot_block_self` · `422` unknown or already blocked user |
| `GET /blocks/{id}`, `DELETE /blocks/{id}` | Read, unblock. Follows are not restored | `404` |

| Resource | Attribute | Type | Writable | Notes |
|---|---|---|---|---|
| `Follow` | `followable_id` | uuid | on creation | the followed user |
| `Follow` | `user_id` | uuid | no | the follower, always the caller |
| `Follow` | `created_at`, `updated_at` | datetime | no | |
| `Block` | `blocked_id` | uuid | on creation | the blocked user |
| `Block` | `user_id` | uuid | no | the blocker, always the caller |
| `Block` | `created_at` | datetime | no | |

Relationships: `Follow.followable` (User), `Block.blocked` (User, public card only), `Block.user` (the caller).
`include=followable` / `include=blocked`. Relationships are not writable: use the id attributes.

A follow survives the followed profile turning private: it just shows nothing until it is public
again. A block in either direction makes each user invisible to the other: profile (`403
user_blocked`), library, lists, statistics, followers/following, activities, search and feed. Who
blocked whom is never exposed to anyone else.

```http
POST /api/follows
Content-Type: application/vnd.api+json

{"data": {"type": "Follow", "attributes": {"followable_id": "0199…"}}}
```

```json
{"data": {"id": "12", "type": "Follow", "attributes": {"followable_id": "0199…",
  "user_id": "0198…", "created_at": "2026-10-17T16:00:00+02:00",
  "updated_at": "2026-10-17T16:00:00+02:00"},
  "relationships": {"followable": {"data": {"type": "User", "id": "0199…"}}}}}
```

To unfollow from a profile page: `GET /follows?filter[followable_id]=0199…`, then `DELETE` the
returned id.

---

## Report

Resource type `Report`, ability `profile`. At most 10 per minute.

| Method and path | Access |
|---|---|
| `POST /reports` | Anyone, including about a user they are in a block with |
| `GET /reports/{id}` | The author only (`404` for anyone else) |

| Attribute | Type | Writable | Constraints |
|---|---|---|---|
| `reportable_type` | `user` \| `library_entry` \| `list` | yes | required (`comment` arrives with comments) |
| `reportable_id` | string | yes | required; the id **as a string**, UUID for users. Must exist |
| `reason` | `spam` \| `harassment` \| `hate_speech` \| `spoiler` \| `inappropriate` \| `impersonation` \| `other` | yes | required |
| `note` | string? | yes | max 1000 |
| `user_id` | uuid | no | the author, always the caller |
| `created_at`, `updated_at` | datetime | no | |

One report per author and subject: a second one is `422`. Errors: `422` validation, `429` too many.

```http
POST /api/reports
Content-Type: application/vnd.api+json

{"data": {"type": "Report", "attributes": {"reportable_type": "list", "reportable_id": "12",
  "reason": "spam", "note": "Advertising"}}}
```

```json
{"data": {"id": "3", "type": "Report", "attributes": {"user_id": "0199…", "reportable_type": "list",
  "reportable_id": "12", "reason": "spam", "note": "Advertising",
  "created_at": "2026-10-17T16:00:00+02:00", "updated_at": "2026-10-17T16:00:00+02:00"}}}
```

---

## Activity

Resource type `Activity`, integer id, read-only. Ability `library`. Recorded by the server, for
private profiles too; filtered when read.

| Method and path | Content |
|---|---|
| `GET /activities` | The caller's own |
| `GET /activities?filter[user]=<uuid>` | That user's. `403 profile_private` / `403 user_blocked` |
| `GET /activities?filter[feed]=true` | Those of the users the caller follows, leaving out private profiles and users in a block with the caller |
| `GET /activities/{id}` | One activity |

Always newest first. `sort=-created_at` may be sent explicitly; any other sort is ignored, as on
every resource. Standard
pagination. Activities about someone else's private list are never shown, nor is "A followed B"
when B is in a block with the caller.

### Attributes

| Attribute | Type | Content |
|---|---|---|
| `verb` | string | see below |
| `subject_type` | `library_entry` \| `list` \| `user` | the kind of subject |
| `payload` | object | what the activity renders from, by verb (below) |
| `created_at` | datetime | when it happened first |
| `updated_at` | datetime | when it was last folded (see grouping) |

Relationships: `user` (who did it), `subject` (polymorphic: `LibraryEntry`, `List` or `User`).
`include=user,subject`.

| `verb` | `subject_type` | `payload` |
|---|---|---|
| `library_added` | `library_entry` | `game_id`, `status` |
| `status_changed` | `library_entry` | `game_id`, `old`, `new` (statuses) |
| `completed` | `library_entry` | `game_id`, `completion_status` (may be missing) |
| `rated` | `library_entry` | `game_id`, `rating` |
| `reviewed` | `library_entry` | `game_id`, `review_spoiler` |
| `list_created` | `list` | `name` |
| `list_item_added` | `list` | `name`, `game_ids` (every game added during the grouping window) |
| `followed` | `user` (the followed one) | `nickname` |
| `library_imported` | `user` (the importer) | `batch`, `count` |

### Grouping

The same user repeating the same verb on the same subject within **30 minutes** of the activity's
`created_at` updates that activity instead of creating a new one: the payload becomes the latest,
except `old`, which keeps the first value (so PLAYING → PAUSED → ABANDONED reads `old: PLAYING, new:
ABANDONED`).

### Deletion

Deleting an entry or a list deletes its activities. Unfollowing (also through a block) deletes the
`followed` activity.

### Library imports

When a connected service syncs many entries, send the header

```
X-Library-Import: <batch id>
```

on **every** `library_entries` write (POST/PATCH/DELETE) of that sync, with the same id for the
whole sync: 1–64 characters among letters, digits, `_` and `-` (otherwise `422
invalid_import_batch`), e.g. a UUID generated when the sync starts. Those writes record no
activity of their own. Each entry they **create** counts into one `library_imported` activity per
batch, `payload: {"batch": "<id>", "count": N}`. Updates within the batch count nothing. A new
sync must use a new id.

### Example

```http
GET /api/activities?filter[feed]=true&include=user,subject
```

```json
{"links": {"self": "/api/activities?filter%5Bfeed%5D=true&include=user%2Csubject"},
 "meta": {"totalItems": 1, "itemsPerPage": 30, "currentPage": 1},
 "data": [{"id": "41", "type": "Activity", "attributes": {
   "verb": "status_changed", "subject_type": "library_entry",
   "payload": {"old": "PLAYING", "game_id": 1942, "new": "COMPLETED"},
   "created_at": "2026-10-17T16:00:00+02:00", "updated_at": "2026-10-17T16:12:00+02:00"},
   "relationships": {"user": {"data": {"type": "User", "id": "0199…"}},
     "subject": {"data": {"type": "LibraryEntry", "id": "77"}}}}],
 "included": ["…"]}
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
| Someone else's private list | `404` (its existence is not revealed); `403 profile_private` stays for private profiles |
| Reorder format | Plain JSON `{"ids": [...]}` with every id, `204` |
| Activity grouping window | 30 minutes from the activity's creation; `old` keeps the first value |
| Library imports | Header `X-Library-Import: <batch id>` on every write of a sync; one `library_imported` per batch counting the created entries |
| Type names | `reportable_type` and `subject_type` use `user`, `library_entry`, `list` (and `comment` from Phase 4) |
| Report reasons | `spam`, `harassment`, `hate_speech`, `spoiler`, `inappropriate`, `impersonation`, `other`; one report per author and subject |
| Follow and block | JSON:API resources `Follow` and `Block`; a duplicate is `422` |
| Self follow/block | `422` with `cannot_follow_self` / `cannot_block_self` |

## Not implemented or deferred

- Blocks on likes and comments: Phase 4.
- Removing a game from a list does not shrink the `game_ids` of an earlier `list_item_added`.
- `likes_count`, `liked_by_me`, `comments_count` on lists: Phase 4.

## Differences from the existing contract

- `GET /users/{id}` for another user: `404` before, now `200` under the visibility rules.
- The owner gets `email` (never exposed before) and `email_verified_at`.
- On a private profile, others no longer see `first_name`, `last_name`, `created_at`, `updated_at`.
- The OIDC login no longer overwrites `nickname` on every sign-in.
- `User` gains `followers_count`, `following_count`, `is_followed_by_me`, `follows_me` (additions).

Everything else (pagination, `current_user=true`, `library_entries` filters and sorts, date format,
generic errors) is unchanged.

Note: `page[offset]` is currently accepted by API Platform as a page number (`page[offset]=2` ≡
`page=2`), not rejected. It stays that way.
