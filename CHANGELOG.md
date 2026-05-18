# Changelog

All notable changes to `sandermuller/project-boost` will be documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/sandermuller/project-boost/compare/0.3.0...HEAD)

### Added

- Initial scaffolding. Depends on `sandermuller/boost-core` (path repository).
- 5 PHP-application-author skills: `ddd-layering`, `dependency-injection`, `repository-pattern`, `domain-modeling`, `legacy-coexistence`.
- Pure skill bundle — no PHP code, no commands. Discovered by boost-core via `extra.boost.{skills,guidelines}` declarations.

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
