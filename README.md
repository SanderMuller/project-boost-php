# project-boost

> AI agent skills for PHP application developers (any framework or none).

Pure skill bundle — no code, no commands. Depends on [`sandermuller/boost-core`](https://github.com/sandermuller/boost-core) for the sync mechanism.

## What ships

**5 skills targeting PHP application authors:**

- `ddd-layering` — Domain/Application/Infrastructure/Presentation responsibilities
- `dependency-injection` — Constructor injection, container vs `new`
- `repository-pattern` — Doctrine-flavored and ORM-agnostic shapes
- `domain-modeling` — Entities vs value objects vs aggregates
- `legacy-coexistence` — Mixing modern PHP 8.x code into a 7.x baseline

Each is intentionally brief (~100-300 lines) — "show the shape, iterate
post-launch" per the architecture plan.

## Status

**Under construction.** boost-core is not yet on Packagist. This package currently resolves it via a path repository.

## Installation

Coming soon:

```bash
composer require --dev sandermuller/project-boost
composer boost:init
composer boost:install   # picker pre-checks first-party packages
composer boost:sync
```

## License

MIT. See [LICENSE](LICENSE).
