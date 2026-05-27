# Changelog

All notable changes to `sandermuller/project-boost` will be documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
