# Project Boost Guidelines

These guidelines replace Laravel Boost's default foundation for
repositories that are **applications** — built to run, not to be
installed as a Composer dependency. They apply whatever framework the
app uses, or none.

## Foundational Context

This codebase is an **application**, not a Composer package. It sits at
the top of the dependency graph: it consumes packages, nothing consumes
it.

- It has an entry point and runs — an HTTP front controller, a CLI, a
  worker, or several. `composer.json` here pins the app's own
  dependencies; it is not published to Packagist.
- The artefact is running behaviour, not an API surface. Correctness is
  judged by what the app does, not by a contract other code links
  against.
- There is no internal semver to honour. Renaming a class, moving a
  file, or changing a method signature breaks nothing outside this
  repo — refactor freely.
- `composer.json`'s `require.php` is the source of truth for the
  supported PHP version. Check it before using version-specific syntax.

## Source Layout

Layout varies by framework. Read what is actually there before
assuming.

- Application code lives under `src/` or `app/`, PSR-4 autoloaded per
  `composer.json`.
- `tests/` — the Pest or PHPUnit suite.
- `config/`, `.env` / `.env.example` — configuration and environment.
- `public/` — the web entry point, when the app serves HTTP.
- `routes/`, `database/`, `resources/` — present on framework apps;
  absent on others.

Check sibling files before inventing structure. Match the directory
conventions the app already uses; do not introduce new top-level
directories without a clear reason.

## Tests and the Running App

An application can be exercised two ways — the test suite and the app
itself. Use both.

- Write tests alongside any behavioural change. Run the configured
  runner (`vendor/bin/pest` or `vendor/bin/phpunit`) before claiming a
  change is done.
- For changes that touch a request, a command, or a screen, also
  confirm the behaviour in the running app. Tests and a manual check
  cover different gaps.
- Do not create throwaway "verification scripts" when a test can pin
  the same behaviour down permanently.

## The Contract Is the App's Edges

An application has no published public API, but it is not free of
contracts. Its real boundaries are:

- **HTTP routes** — URL shapes and request/response payloads consumed
  by clients or a frontend.
- **CLI commands** — names, arguments, and options that people or
  schedulers invoke.
- **Queue / event payloads** — message shapes read by workers, possibly
  across deploys.
- **Database schema** — migrations are forward-only in production; a
  shipped migration cannot be edited, only superseded.

Internal classes, services, and helpers behind these edges carry no
such guarantee — restructure them whenever it improves the code.

## Conventions

- Match existing code style, naming, and structural patterns — check
  sibling files before writing new ones.
- Use descriptive names (`resolvePublishDestination`, not `resolve()`).
- Reuse existing helpers and framework features before adding new ones.
- Adding a dependency is cheap for an app, but every `require` is still
  code to maintain, update, and audit. Reach for the standard library
  and existing dependencies first.

## Documentation Files

Only create or edit documentation (README, CHANGELOG, docs/) when
explicitly requested or when a behaviour change requires it.

## Replies

Be concise. Focus on what changed and why. Skip restating what the
diff already shows.
