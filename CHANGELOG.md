# Changelog

All notable changes to `sandermuller/project-boost-php` will be documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0](https://github.com/sandermuller/project-boost-php/compare/0.10.0...1.0.0) - 2026-06-05

The first stable release. The surface is now frozen under SemVer, the package is renamed to fit the family convention, and the shipped skills are trimmed to what holds on any framework.

### Breaking

#### Renamed: `sandermuller/project-boost` → `sandermuller/project-boost-php`

The package now carries the `-php` suffix, matching its siblings (`package-boost-php`, `project-boost-laravel`, `package-boost-laravel`). The old `sandermuller/project-boost` is abandoned on Packagist pointing here; its 0.x tags stay installable.

Update your dependency — and, importantly, any reference in your `boost.php`:

```diff
- "sandermuller/project-boost": "^0.10"
+ "sandermuller/project-boost-php": "^1.0"

```
```diff
  // boost.php
- ->withAllowedVendors(['sandermuller/project-boost'])
+ ->withAllowedVendors(['sandermuller/project-boost-php'])

```
boost-core matches on the literal package name, so a stale `boost.php` reference silently stops matching — none of this package's skills would sync, and a stale `withExcludedSkills(['sandermuller/project-boost:<name>'])` entry would let a skill you'd excluded reappear. See `UPGRADING.md`.

#### Removed three skills

`ddd-layering`, `domain-modeling`, and `repository-pattern` are gone. They shipped a DDD / clean-architecture opinion by default that conflicts with the "any framework, or none" remit and misleads ActiveRecord/Eloquent-shaped apps. If you relied on a dropped skill, copy it into your own `.ai/skills/<name>/SKILL.md` (host copies shadow vendor skills), or pin the old package `sandermuller/project-boost:^0.10` whose 0.x tags still carry them.

### Changed

- The `foundation` guideline was rewritten lean and framework-agnostic — a positive "here's how to work in this application" framing instead of the defensive "it's not a package" ceremony, and less context bloat.
- The `sandermuller/boost-core` constraint widened `^0.22 || ^0.23` → `^1.0`, tracking the family's 1.0 freeze. boost-core 1.0 froze the 0.23.3 surface; both skill-source shapes and the default discovery paths are frozen-accepted, so the engine upgrade is a clean drop-in.

### The 1.0 surface

Two skills — `dependency-injection` and `legacy-coexistence` — plus the `foundation` guideline. `PUBLIC_API.md` records the frozen contract: removing or renaming a shipped skill/guideline, or changing a default discovery path, is now a MAJOR-only breaking change.

### Upgrade

See `UPGRADING.md` for the full migration: the dependency name, `boost.php` references, the dropped skills, and the boost-core constraint.

**Full Changelog**: https://github.com/SanderMuller/project-boost-php/compare/0.10.0...1.0.0

## [0.10.0](https://github.com/sandermuller/project-boost/compare/0.9.0...0.10.0) - 2026-06-04

Adds boost-core 0.23 support and lands the groundwork for a 1.0 in lockstep with the boost family. Still a pure skill bundle — no PHP, no change to what consumers receive.

### Changed

- Widened the `sandermuller/boost-core` constraint `^0.22` → `^0.22 || ^0.23` — project-boost now supports boost-core 0.23 (an additive pre-1.0 minor). Consumers on boost-core 0.22 are unaffected; those on 0.23 can now install. If you hard-pin boost-core below 0.23 elsewhere, no change is required.
- Converted the five shipped skills to boost-core's canonical `<name>/SKILL.md` source shape (was flat `<name>.md`), matching the wider boost family. Source-layout change only — boost-core emits the same per-agent skill files, so consumers receive exactly the same skills.

### Added

- **`UPGRADING.md`** — a lean upgrade guide centered on the one cross-package migration a skill bundle has: the transitive boost-core constraint consumers inherit.
- **`PUBLIC_API.md`** now declares the accurate semver-protected surface ahead of 1.0: the shipped skill set + boost-core's default discovery paths (`resources/boost/{skills,guidelines}/`) + the per-file frontmatter contract. project-boost ships no PHP, so it has no `@api`/`@internal` class surface; the doc records the family convention (a renderer/emitter implementation is `@internal`; the contract is boost-core's `@api`).

### Internal (maintainer-facing, not consumer-visible)

- Dev dependencies: `sandermuller/boost-skills` 2.0.6 → 2.1.0, `sandermuller/package-boost-php` 0.18.1 → 0.19.1.
- Fixed `update-changelog.yml` to strip internal release-notes markers before prepending, so they no longer land in `CHANGELOG.md`.

### Upgrade

`composer update sandermuller/project-boost` pulls 0.10.0 and admits boost-core 0.23. See `UPGRADING.md` if your project independently pins `sandermuller/boost-core`.

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.9.0...0.10.0

## [0.9.0](https://github.com/sandermuller/project-boost/compare/0.8.0...0.9.0) - 2026-06-03

### Changed

- Bumped the `sandermuller/boost-core` constraint `^0.8` → `^0.22`. This is the one consumer-visible change: a project that hard-pins `sandermuller/boost-core` elsewhere in its `composer.json` at 0.8.x–0.21.x must widen to `^0.22` (or drop the explicit pin and let project-boost's transitive bound own it). The five shipped skills and the `foundation` guideline are unchanged.

### What boost-core 0.9 → 0.22 brings (inherited)

The jump spans several boost-core minors. For a consumer that authors a `boost.php` and syncs (no plugin contracts implemented), all of it is additive bar the one config-author signature change noted last:

- **Markerless tracked guidance (0.12)** — `CLAUDE.md` / `AGENTS.md` / `GEMINI.md` are boost-owned but kept git-tracked, so the synced output is reviewable in diffs and present on a fresh clone without a sync.
- **`.config/boost.php` support (0.17)** — config may live at `.config/boost.php`; the engine resolves `.config/` over a root `boost.php`, and having both present is a hard error.
- **Conventions system** — `withConventions([...])` slots with a schema-version handshake; vendor packages declare reusable rule shapes via `resources/boost/conventions-schema.json`.
- **`@api` / `@internal` surface declaration (0.22)** — the `boost.php` authoring API and the CLI are the stable surface; engine internals are now explicitly marked.
- **`withTags()` takes an array (0.20)** — config authors pass `->withTags([Tag::Php, …])` instead of variadic arguments. The only non-additive step, and it only bites a hand-edited `boost.php`.

### Maintainer-only changes (not consumer-visible)

None of these change what downstream consumers see in their generated agent directories.

- Migrated `boost.php` → `.config/boost.php` (the canonical location since boost-core 0.17) and switched `withTags()` to the array form.
- `CLAUDE.md` / `AGENTS.md` are now tracked rather than gitignored, following the markerless-guidance design; `.config/boost/` (the sync manifest) is gitignored.
- Pruned 11 `.ai/skills/` directories that `sandermuller/boost-skills` already provides (ai-guidelines, autoresearch, backend-quality, bug-fixing, code-review, codex-review, evaluate, implement-spec, pr-review-feedback, pre-release, write-spec). The two bespoke maintainer skills — `boost-config-shape` and `writing-file-emitter` — stay.
- Dev-deps: `sandermuller/boost-skills` ^1.6 → ^2.0 (its conventions-inlining major) and `sandermuller/package-boost-php` ^0.10 → ^0.18.
- `.gitattributes` and `.lpv` export-ignore the `.config/` directory so it stays out of the published archive.

### Upgrade

`composer update sandermuller/project-boost` widens the boost-core constraint and pulls in 0.22.x. If your project's own `composer.json` hard-pins `sandermuller/boost-core` below `^0.22`, widen it (or drop the explicit constraint and let project-boost's transitive bound own it).

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.8.0...0.9.0

## [0.8.0](https://github.com/sandermuller/project-boost/compare/0.7.0...0.8.0) - 2026-05-27

### Changed

- Bumped the `sandermuller/boost-core` constraint to `^0.8`. Consumers with a hard pin on boost-core 0.7.x elsewhere in their `composer.json` will need to widen alongside this bump.
- README rewritten end-to-end against the family-wide README strategy. The "any framework, or none" angle leads (the direct response to `laravel/boost`'s Laravel-only scope), the five shipped skills are framed honestly as DDD- and clean-architecture-leaning opinions rather than a neutral catalog, and the routing table cross-links Laravel-app users sideways to `sandermuller/project-boost-laravel`. Side-by-side comparison with `laravel/boost` clarifies the scope, skill set, and MCP/docs delegation. Sources of skills (host `.ai/skills/`, Composer-installed catalogs, `withRemoteSkills()`) are surfaced as a stacked menu with their per-source filter semantics described accurately against the engine source.

### What boost-core 0.8 brings (inherited)

boost-core 0.8 is additive over 0.7.x — no migration required.

- **`boost where --diff=<skill>`** — unified diff between a host-shadowed skill and the vendor's upstream copy, with a "no diff" hint when the override is byte-identical (signal to remove the redundant local override).
- **`boost doctor --check-versions`** — opt-in Packagist comparison that catches stale path-repo installs silently shadowing newer published versions.
- **`.ai/commands/` argument transpilation** — `$ARGUMENTS`, `$1`/`$2`/…, `$name` placeholder rewriting per-agent across seven emit targets. Author once, transpile on sync.
- **Conventions schema discovery** — vendor packages can ship `resources/boost/conventions-schema.json` to declare reusable rule shapes; consumers pick them up via the existing allowlist.

project-boost itself does not yet consume any of these surfaces directly.

### Dev-only dependency moves (not consumer-visible)

For maintainers of this repository, two dev-dep bumps landed alongside the constraint change:

- `sandermuller/package-boost-php` ^0.9 → ^0.10. The release-flow content skills (`readme`, `release-notes`, `upgrading`) moved out of package-boost-php and into `sandermuller/boost-skills` under the `release-automation` opt-in tag.
- `sandermuller/boost-skills` ^1.1 → ^1.6 (the move target above).
- `boost.php` lost a vestigial `->withDisabledEmitters([])` no-op from the original `boost install` scaffold template. Functionally inert; cleanup only.

None of the above changes what downstream consumers of project-boost see in their generated agent directories.

### Upgrade

`composer update sandermuller/project-boost` widens the boost-core constraint and pulls in 0.8.x. If your project's own `composer.json` hard-pins `sandermuller/boost-core: ^0.7.0`, widen to `^0.8` (or drop the explicit constraint and let project-boost's transitive bound own it).

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.7.0...0.8.0

## [0.7.0](https://github.com/sandermuller/project-boost/compare/0.6.0...0.7.0) - 2026-05-25

Tracks the boost-core 0.7 family version stream. No behavior change for project-boost itself — a pure skill bundle with no PHP code. boost-core 0.7.0 is additive over 0.6.x (no migration required); project-boost does not yet consume any of its new surfaces (`withRemoteSkills`, `SkillRenderer`, `SyncEngine` injection params, `boost where`).

### Changed

- Bumped the `sandermuller/boost-core` constraint to `^0.7.0`.

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.6.0...0.7.0

## [0.6.0](https://github.com/sandermuller/project-boost/compare/0.5.0...0.6.0) - 2026-05-22

### Changed

- Bumped the `sandermuller/boost-core` constraint to `^0.6.0`.
- `post-install-cmd` / `post-update-cmd` now run `BoostAutoSync::run` instead of `::runWithSummary`. boost-core's `run()` prints the one-line sync summary (`[OK] Sync done. wrote=X, unchanged=Y.`) only when the sync actually wrote files, and stays silent on a no-op install. 0.5.0 printed that line on every `composer install` / `composer update`; 0.6.0 trims it to installs that changed something. `composer sync-ai` keeps `runWithSummary` — a user-invoked sync always reports.

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.5.0...0.6.0

## [0.5.0](https://github.com/sandermuller/project-boost/compare/0.4.0...0.5.0) - 2026-05-22

### Added

- **Framework-agnostic foundation guideline.** project-boost now ships `resources/boost/guidelines/foundation.md` alongside its five skills. On sync, boost-core merges it into each selected agent's guidelines file (`CLAUDE.md`, `AGENTS.md`, Copilot instructions, …). It replaces the package-oriented default foundation with application-oriented framing: an application sits at the top of the dependency graph, carries no internal semver, and its real contract is its edges — HTTP routes, CLI commands, queue/event payloads, and the database schema — not a published API. Classes and services behind those edges can be refactored freely.

### Changed

- Bumped the `sandermuller/boost-core` constraint to `^0.5.0`.
- `post-install-cmd` / `post-update-cmd` now run `BoostAutoSync::runWithSummary`. The one-line sync summary (`[OK] Sync done. wrote=X, unchanged=Y.`) is now shown on `composer install` / `composer update`, matching what `composer sync-ai` already prints.

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.4.0...0.5.0

## [0.4.0](https://github.com/sandermuller/project-boost/compare/0.3.1...0.4.0) - 2026-05-20

Tracks the boost-core 0.4 family version stream. No behavior change for project-boost itself — a pure skill bundle with no PHP code.

### Changed

- Bumped the `sandermuller/boost-core` constraint to `^0.4.0`.

### What boost-core 0.4.0 brings (inherited)

boost-core 0.4.0 vendor-namespaces user-scope skill paths to prevent cross-package collisions:

- Path shape: `~/.{agent}/skills/<basename>/` → `~/.{agent}/skills/<vendor>__<package>/`.
- A one-time auto-migration runs on first sync after upgrade — it renames a legacy directory only when an ownership check confirms the contents trace back to that package's own source tree.

Pre-0.2 collision states (two packages that wrote to the same basename directory) are left for manual cleanup — see boost-core's UPGRADING.md.

No upgrade steps for project-boost consumers. `composer update` picks up boost-core 0.4.0; the path migration is automatic.

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.3.1...0.4.0

## [0.3.1](https://github.com/sandermuller/project-boost/compare/0.3.0...0.3.1) - 2026-05-18

### Changed

- `composer sync-ai` now runs `SanderMuller\BoostCore\Scripts\BoostAutoSync::runWithSummary` instead of shelling out to `vendor/bin/boost sync` directly. The callable streams the binary's one-line summary (`[OK] Sync done. wrote=X, unchanged=Y.`) through Composer's IO — visible output for manual runs, silent on the auto `post-install-cmd` / `post-update-cmd` path.
- Bumped `sandermuller/boost-core` constraint floor to `^0.3.2` — `runWithSummary` was added in that release.

No upgrade steps. `composer require --dev sandermuller/project-boost:^0.3.1` (or any `^0.3` consumer already pinned at 0.3.0) gets the new behavior on next `composer update`.

**Full Changelog**: https://github.com/SanderMuller/project-boost/compare/0.3.0...0.3.1

## [0.3.0](https://github.com/sandermuller/project-boost/compare/...0.3.0) - 2026-05-18

First tagged release. Aligns project-boost with the boost-core 0.3 family-wide version stream.

### Highlights

- Ships as a stable Composer dependency: install with `composer require --dev sandermuller/project-boost` (no more `@dev` constraint hack, no more `minimum-stability: dev`).
- Powered by [`sandermuller/boost-core`](https://github.com/sandermuller/boost-core) `^0.3` — a Composer plugin that auto-fans-out skills to every agent dir on `composer install`. No testbench, no Laravel runtime required.
- Five shipped skills under `resources/boost/skills/` for PHP application developers: DDD layering, dependency injection, repository pattern, domain modeling, legacy 7.x→8.x coexistence.

### Install

```bash
composer require --dev sandermuller/project-boost









```
Then run `composer boost:install` to pick which agents (Claude, Cursor, Copilot, …) you want skills fanned out to.

### Notes for early adopters

If you were tracking `dev-main` against the previous `^1.0@dev` constraint:

- Bump your constraint to `sandermuller/project-boost: ^0.3`.
- Drop the `minimum-stability: dev` opt-in if you were only using it for project-boost / boost-core.

### What changed under the hood

- Adopted the canonical sandermuller php-package layout (split CI workflows, lean-package-validator, pint, dependabot, gitattributes managed block).
- Switched from `sandermuller/package-boost` + `orchestra/testbench` to `sandermuller/boost-core` for skill sync. `vendor/bin/boost sync` replaces `vendor/bin/testbench package-boost:sync`.
- Wired `SanderMuller\BoostCore\Scripts\BoostAutoSync::run` into `post-install-cmd` / `post-update-cmd` — cross-platform (Windows-safe), uses Composer's `Event::isDevMode()`, honors `config.bin-dir`, surfaces sync errors through Composer's IO.
- README install/usage examples updated to reflect the boost-core 0.3 single-command flow (`composer boost:install` auto-generates `boost.php` — the old two-step `boost:init && boost:install` is gone).
