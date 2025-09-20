# AGENT ORIENTATION: Kanban Project

This document is written for an autonomous AI agent (engineering assistant) to quickly understand, navigate, and safely extend this repository.

---

## 1. High-Level Purpose

A lightweight Kanban board web app:
- Backend: PHP (Flight micro-framework + simple DI container)
- Frontend: Web Components + Reef (signals-based rendering) (single active implementation)
  (Legacy Vue implementation removed; references cleaned up)

- Persistence: MySQL (schema + triggers + sample data in `/sql`)
- Templates: Lightweight custom template system (`App\Template` + `Factory`)

The project appears mid-refactor: duplication, unused code paths, and API/JS mismatches exist.

---

## 2. Repository Structure (Essential Paths)

- `composer.json` – PHP dependencies (flightphp/core, ramsey/uuid, utility helpers)
- `web/index.php` – Front controller: boots Flight, registers routes, DI wiring, starts app
- `config/config.php.dist` – Sample configuration (must be copied to `config/config.php` in production)
- `config/services.php` – DI container service definitions (currently only DB connection)
- `src/` – PHP domain + actions
  - `Actions/` – Route handlers (each is an invokable class)
    - `Index` (home page)
    - `Board` (board page)
    - `Api/*` – REST-ish endpoints for boards, columns, cards
    - `Traits/HasConnection`, `Traits/TemplateAction`
  - `Database/Connection.php` – Thin PDO wrapper
  - `Template/Factory.php` and `Template.php` – Custom file-based template loader/renderer
  - `ActionInterface.php` – (Not widely enforced; most actions just define `__invoke`)
  - `Middleware/Board.php` – Preloads a board row (makes it available via `Flight::get('board')`)
- `templates/` – Raw HTML templates (no server-side variable interpolation beyond inclusion)
- `web/js/` – Frontend assets (Web Components + Reef only)

  - `app.js` + `util/` + `component/` – Reef + custom elements stack
- `web/css/` – Styling
- `sql/` – DB schema, triggers, sample dataset, utilities

---

## 3. Runtime Flow Overview

1. HTTP request enters `web/index.php`.
2. Autoload + config + DI container load.
3. `Factory::setBaseDir()` assigns template directory.
4. Flight routes map to action classes (Flight instantiates classes; constructor injection works if container knows the dependency).
5. API actions use:
   - Input via `Flight::request()->data`
   - DB via `$this->connection()` from `HasConnection`
   - UUID creation via `ramsey/uuid`
   - Return JSON using `Flight::jsonHalt(...)` (terminates execution)
6. Frontend fetches API endpoints to mutate/read board state.

---

## 4. Database Model (Simplified)

Tables:
- `boards(board_id (PK AUTO), board_uuid (CHAR36 UNIQUE), board_title, timestamps)`
- `columns(column_id, column_uuid, column_board FK -> boards.board_id, column_title, column_position)`
- `cards(card_id, card_uuid, card_board FK, card_column FK, card_title, card_content)`

Notes:
- Triggers (03-triggers.sql) ensure UUID fields are auto-populated if NULL (but code already sets them explicitly).
- Position ordering implemented by updating `column_position`.
- No foreign key constraints are explicitly declared in schema (potential enhancement).

---

## 5. Backend Design Conventions

- Each action is an invokable class with `__invoke(...)`.
- Actions either:
  - Render a template (via `TemplateAction` trait)
  - Return JSON (API)
- Responses use `App\Actions\Api\Response` for a consistent JSON envelope: `{ ok, error, code, ...payload }`
- `HasConnection` trait provides constructor-based injection of `App\Database\Connection`.
- Minimal validation; error handling inconsistent (some exceptions swallowed).

---

## 6. Template System

`Factory::make('name.html')` returns a `Template` instantiated with full file path.

`Template`:
- Holds an internal associative array (`$data`) but current usage does not set dynamic variables in templates.
- Templates (`board.html`, `index.html`) currently appear static and rely on client-side JS frameworks to bootstrap dynamic content.

---

## 7. Frontend Stacks (Two Coexisting Approaches)

### A. Reef + Custom Elements
- Entry: `templates/index.html` loads:
  - `component/board-header.js`
  - `component/column-list.js`
  - etc.
- A global `Board` instance (from `util/board.js`) orchestrates adding columns/cards.
- Relies on `reef.es.min.js` (in `/js/vendor/`—not fully shown here) for signals.





- Column and card creation, movement, modal editing.

### Mismatch / Inconsistencies
- Endpoints differ between utilities:
  - `board.js` fetch delete card via `/api/card/${card.id}` but server defines `DELETE /api/board/@board/card/@card`
  - `util/api.js` still uses nested REST resource style (`/board/{board}/column/{column}/card`) not implemented server-side (server uses flat `/api/board/{board}/card`).
- Two separate philosophies; consolidation recommended.

---

## 8. API Endpoint Map (Current)

Board:
- `POST /api/board` – create board
- `GET /api/board/@board` – get full board structure (board + columns + cards)
  (No update/delete)

Column:
- `POST /api/board/@board/column`
- `DELETE /api/board/@board/column/@column`
- `PUT /api/board/@board/column/order` (expects `{ order: [uuid1, uuid2,...] }`)

Card:
- `POST /api/board/@board/card`
- `PUT /api/board/@board/card/@card`
- `DELETE /api/board/@board/card/@card`
- (No single GET)

Response envelope: Standardized via `Response` object.

---

## 9. Dependency Injection

- Flight container adapter: `Flight::registerContainerHandler([$container, 'get']);`
- When resolving a route to `ClassName::__invoke`, Flight attempts to instantiate via container.
- Only explicitly bound service: `App\Database\Connection`.
- If adding new dependencies (e.g., Logger), register in `config/services.php`.

---

## 10. Known / Potential Issues (Useful for Agent Task Queue)

1. Frontend now standardized on Web Components + Reef (verify no stale references).
2. Missing `config/config.php` (only `.dist`). Consider boot-time check.
3. Hard-coded board UUID in `web/js/app.js`.
4. Inconsistent API paths between `util/api.js` and server routes.
5. Security:
   - No CSRF protection.
   - No auth / board access control.
   - Some raw SQL string interpolation (e.g., ordered columns assembly in `Column\Order`).
6. Error handling:
   - Exceptions often swallowed (e.g., middleware).
   - Mixed usage of `Flight::json` vs `Flight::jsonHalt`.
7. `Response` sets `$error` to a string but also labeled `error` – could rename to `error_message`.
8. Position update query builds an `IN (...)` list from unvalidated UUID array—risk if malformed data injected.
9. No migrations script wrapper; raw `.sql` files only.
10. `ActionInterface` unused; either remove or enforce.

---

## 11. Suggested Refactor / Improvement Roadmap

Priority tiers:

High:
- Frontend unified on Web Components + Reef; continue removing legacy assumptions.
- Normalize API contract; update JS clients accordingly.
- Add input validation + sanitation.
- Introduce consistent exception handling (central error middleware).
- Parameterize `IN` list update logic (rewrite using prepared statements with dynamic placeholders).

Medium:
- Add PSR-4 namespaced tests + PHPUnit config.
- Implement board ownership + auth (JWT or session).
- Introduce logging (Monolog).
- Add a migration tool (e.g., Phinx) instead of raw SQL.

Low:
- Replace custom template system with a more robust engine (e.g., Plates or Twig) OR lean fully into SPA.
- Enforce `ActionInterface`.
- Provide OpenAPI spec for API.
- Add rate limiting middleware.

---

## 12. Adding a New API Feature (Example Checklist)

To add `PATCH /api/board/@board` (rename board):

Checklist:
1. Create `src/Actions/Api/Board/Update.php` with `HasConnection`.
2. Validate UUID via `Flight::get('board')` (already loaded by middleware).
3. Accept JSON: `{ title: "New Title" }`
4. Update `boards` table using `Connection::update()`.
5. Return JSON using `Response` with updated board payload.
6. Add route in `web/index.php`.
7. Update frontend calls where API changes occur (Reef components).
8. Add basic test (if test harness introduced later).

---

## 13. Safe Editing Guidelines

When modifying:
- Always keep `composer.json` autoload namespace consistent: All `App\` classes in `src/`.
- Avoid introducing blocking code in actions; Fast fail with JSON responses.
- Use `Uuid::isValid()` before trusting incoming IDs.
- Prefer `selectOne` for unique fetches; handle `false/null` explicitly.
- When building dynamic SQL lists, generate placeholder tokens (`:p0`, `:p1`, ...) instead of concatenating raw values.

---

## 14. Potential Automation Tasks for the Agent

You (agent) can propose or execute (after user approval):
- Generate OpenAPI spec from existing routes.
- Write a unifying `frontend/README`.
- Add a script to reconcile mismatched API endpoints in JS.
- Build a simple test harness: one integration test hitting `GET /api/board/:uuid`.
- Add linter (PHP-CS-Fixer) config.
- Write a migration runner script (PHP CLI) to apply `/sql` sequentially.
- Create a `Makefile` or `justfile` for: `install`, `serve`, `migrate`, `seed`.

---

## 15. Quick Reference: Common Classes

- `App\Database\Connection` – Methods: `select`, `selectOne`, `insert`, `update`, `delete`, `query`
- `App\Actions\Traits\HasConnection` – Provides `$this->connection()`
- `App\Actions\Traits\TemplateAction` – Derives template name from class name
- `App\Actions\Api\Response` – Build consistent JSON envelopes

---

## 16. Environment Bootstrap Requirements

Required to run locally:
1. Copy `config/config.php.dist` → `config/config.php`
2. Create MySQL database matching DSN
3. Apply SQL scripts in order:
   - `01-uuid-polyfill.sql`
   - `02-schema.sql`
   - `03-triggers.sql`
   - (Optionally) `11-sample-dataset.sql`
4. Run PHP built-in server via composer script:
   - `composer install`
   - `composer run serve`
5. Visit: `http://localhost:8001/board/{sample-board-uuid}`

---

## 17. Data Flow Example (Card Creation)

Frontend (Reef-based components):
- User types card title -> triggers `addCard(columnId)`
- Calls `createCard(boardId, columnId, { title, content })`
- Sends `POST /api/board/{board}/card` with JSON `{ column: <uuid>, title: "...", content: "" }`
Backend:
1. Middleware loads board row.
2. Validates column exists for that board.
3. Inserts new card.
4. Returns `{ ok: true, card: { id: <uuid> } }`
Frontend:
- Pushes new card into reactive array for that column.

---

## 18. Known UUID Patterns

Using `ramsey/uuid` v4.9 but calling `Uuid::uuid7()` (new monotonic style). Ensure DB `CHAR(36)` columns can store them (they can). If optimizing later, consider `BINARY(16)` with conversion helpers.

---

## 19. Risks & Edge Cases

- If middleware fails to find board, API handlers may proceed with null board context—should enforce 404.
- Column ordering update relies on `FIELD()` ordering; if a UUID missing, positions may desync.
- No transaction boundaries: complex multi-step mutations could become inconsistent.
- Lack of escaping in the IN clause update—malformed payload may cause SQL error.

---

## 20. Suggested Immediate Fix Set (If Acting Autonomously)

1. Normalize API path usage in `util/api.js` to match server (remove nested card routes).
2. Add guard in middleware: if board not found -> `Flight::jsonHalt` 404 envelope.
3. Refactor `Column\Order` to parameterize UUID sequence.
4. Provide `config/config.php` existence check at boot; copy dist file automatically if missing (optional).
5. Remove one frontend layer (choose strategy).

---

## 21. Contributing Pattern (Proposed)

Branch workflow suggestion:
- Feature branches: `feature/<short-description>`
- Commit message style: `feat(api): add board rename endpoint`
- Run (future) test + static analysis before PR merge.

---

## 22. Glossary

- Action: An invokable class mapped to a route.
- Middleware: Pre-route hook that enriches context (loads board).
- Template: Static HTML file rendered server-side (currently without dynamic PHP variable injection).
- Reef: Lightweight reactive component system used for custom elements.
- Flight: Micro-framework handling routing & request lifecycle.

---

## 23. Quick TODO Markers Already Present

Look for commented-out lines in `web/index.php` and some `Api` actions—indicates planned endpoints (e.g., Board Update, Card Index) not yet implemented.

---

## 24. Exit Criteria for "Stabilized MVP"

You can consider the backend stabilized when:
- All active front-end consumers use a single, consistent API contract.
- Error responses are standardized (same shape, meaningful codes).
- Board not found → 404 JSON with code.
- Column/card operations validated strictly (foreign entity existence).
- At least one integration test passes (board load).
- Column reorder sanitized.

---

## 25. Contact / Human Handoff Notes

If you (agent) need higher-level direction:
- Frontend paradigm established: Web Components + Reef.
- Clarify whether multi-user ownership and auth are in scope.
- Confirm if automated tests (PHPUnit / Playwright) should be introduced next.
- Determine whether to formalize an API versioning strategy early.
- Ask whether DB migrations tooling should precede auth features.

---

## 26. Continuous Integration (Current State)

Implemented GitHub Actions workflows:
- `.github/workflows/php-lint.yml`
  - Matrix: PHP 8.2 & 8.4
  - Composer validate, install, autoload optimize
  - Parallel `php -l` syntax checks
  - Basic autoload smoke test
- `.github/workflows/js-css-lint.yml`
  - Matrix: Node 18.x & 20.x
  - Ephemeral ESLint (flat config) + Stylelint configs (generated if absent)
  - Node syntax verification (`node --check`)
  - Zero-warnings policy for ESLint
  - Stylelint standard config for CSS

Observations:
- No caching for Node dependencies beyond built‑in setup-node caching of npm (acceptable for now).
- No artifacts uploaded (OK for lint-only).
- CI does not yet:
  - Run application-level tests
  - Perform static analysis (PHPStan/Psalm)
  - Enforce code style (PHP-CS-Fixer / Prettier)
  - Build or package assets
  - Security scan (Composer audit suppressed; could add `symfony/security-checker` or `roave/security-advisories`)

Suggested Near-Term CI Enhancements:
1. Add PHPStan level 6+ (fail on baseline drift).
2. Add Psalm (optional if PHPStan sufficient).
3. Add PHP-CS-Fixer dry-run step (or Laravel Pint) before style adoption.
4. Add dependency vulnerability scan (e.g., `composer audit || true` with summary).
5. Introduce a test matrix once tests exist: job `tests` depending on `lint`.
6. Add `fail-fast: true` only after pipeline stabilizes.
7. Generate an SBOM (CycloneDX) if supply chain visibility is desired.

---

## 27. Licensing

Project is licensed under MIT (`LICENSE.md`):
- Permissive reuse allowed
- Ensure future contributions do not introduce incompatible licensed code
- When adding third-party assets/scripts manually (non-composer), record origin + license in a new `THIRD_PARTY.md`

Actionable:
- Add a short license badge/reference in a future `README.md`
- Include license header docblocks only if policy requires (currently omitted for brevity)

---

## 28. Next Automation Candidates

Automation targets now that CI linting exists:
- Script: `bin/migrate` (apply SQL in order; idempotency guard)
- OpenAPI draft generation (manual first, later automated validation)
- Add `make` or `justfile` with targets: `install`, `serve`, `lint`, `phpstan`, `migrate`, `seed`
- Generate dependency graph (e.g., `composer show --tree > docs/deps.txt`)
- Add Renovate or Dependabot for dependency update PRs
- Add commit message linting (Conventional Commits) using a lightweight action

---

End of AGENT.md
