# Public API

The semver-protected surface of `sandermuller/project-boost`. Anything documented here is covered by semver; anything outside is internal and may change without notice (including in patch releases).

## Versioning

This package follows [Semantic Versioning 2.0.0](https://semver.org/spec/v2.0.0.html). Pre-`1.0.0` releases may break API in MINOR bumps; we surface those in `CHANGELOG.md`.

## Stable surface

`project-boost` ships **no PHP code** — no classes, no service provider, no CLI, no config keys of its own, no `@api`/`@internal` class surface. It is a pure skill bundle that `sandermuller/boost-core` discovers at its **default convention paths** (project-boost declares no `extra.boost` override in `composer.json`):

- `resources/boost/skills/` — skills root (boost-core's `DEFAULT_SKILLS_PATH`).
- `resources/boost/guidelines/` — guidelines root.

Those default paths, the on-disk layout under them, the set of shipped skills/guidelines, and the per-file frontmatter contract are the public surface. Renaming or removing a shipped skill or guideline is a BREAKING change. (boost-core also supports overriding the paths via `extra.boost.skills` / `extra.boost.guidelines`; project-boost relies on the defaults, so the default paths themselves are part of its contract.)

### Skills

Shipped from `resources/boost/skills/` as `<name>/SKILL.md` directories (boost-core's canonical source shape, shared with boost-skills and the family). The directory name matches the `name:` frontmatter; each `SKILL.md` carries `name` + `description` frontmatter:

- `ddd-layering`
- `dependency-injection`
- `domain-modeling`
- `legacy-coexistence`
- `repository-pattern`

### Guidelines

Shipped from `resources/boost/guidelines/` as flat `<name>.md` files:

- `foundation`

## Internal (not covered by semver)

Anything not listed above. In particular: the internal organisation of skill markdown, code-block tags, examples — these may be reworded freely.

Family convention (shared with `project-boost-laravel` / `package-boost-laravel`): a shipped `SkillRenderer` / `FileEmitter` **implementation is `@internal`** — the `@api` seam is boost-core's `SkillRenderer` / `FileEmitter` *contract* (whose signature we don't own; marking an impl `@api` would over-promise). project-boost ships neither, so this is informational here — recorded for one consistent rule across the family's `PUBLIC_API.md`s.

## Removed APIs

<!-- Track removed APIs here so consumers know what was removed when. Example:
- `0.5.0` — Removed skill `legacy-foo`. Replaced by `bar`.
-->
