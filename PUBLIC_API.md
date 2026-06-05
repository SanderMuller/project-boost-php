# Public API

The semver-protected surface of `sandermuller/project-boost-php`. Anything documented here is covered by semver; anything outside is internal and may change without notice (including in patch releases).

## Versioning

This package follows [Semantic Versioning 2.0.0](https://semver.org/spec/v2.0.0.html). As of `1.0.0` the surface below is frozen: removing or renaming a shipped skill/guideline, or changing a default discovery path, is a BREAKING change requiring a MAJOR bump. Additive changes (new skills, new guidelines) ship in MINOR releases. All changes are surfaced in `CHANGELOG.md`.

## Stable surface

`project-boost-php` ships **no PHP code** — no classes, no service provider, no CLI, no config keys of its own, no `@api`/`@internal` class surface. It is a pure skill bundle that `sandermuller/boost-core` discovers at its **default convention paths** (project-boost-php declares no `extra.boost` override in `composer.json`):

- `resources/boost/skills/` — skills root (boost-core's `DEFAULT_SKILLS_PATH`).
- `resources/boost/guidelines/` — guidelines root.

Those default paths, the on-disk layout under them, the set of shipped skills/guidelines, and the per-file frontmatter contract are the public surface. Renaming or removing a shipped skill or guideline is a BREAKING change. (boost-core also supports overriding the paths via `extra.boost.skills` / `extra.boost.guidelines`; project-boost-php relies on the defaults, so the default paths themselves are part of its contract.)

### Skills

Shipped from `resources/boost/skills/` as `<name>/SKILL.md` directories (boost-core's canonical source shape, shared with boost-skills and the family). The directory name matches the `name:` frontmatter; each `SKILL.md` carries `name` + `description` frontmatter:

- `dependency-injection`
- `legacy-coexistence`

The 1.0 surface is deliberately framework-agnostic: both shipped skills are universally-applicable PHP practices, not tied to a particular architecture. (The DDD/clean-architecture skills shipped through 0.x were dropped at 1.0 — see Removed APIs.)

### Guidelines

Shipped from `resources/boost/guidelines/` as flat `<name>.md` files:

- `foundation`

## Internal (not covered by semver)

Anything not listed above. In particular: the internal organisation of skill markdown, code-block tags, examples — these may be reworded freely.

Family convention (shared with `project-boost-laravel` / `package-boost-laravel`): a shipped `SkillRenderer` / `FileEmitter` **implementation is `@internal`** — the `@api` seam is boost-core's `SkillRenderer` / `FileEmitter` *contract* (whose signature we don't own; marking an impl `@api` would over-promise). project-boost-php ships neither, so this is informational here — recorded for one consistent rule across the family's `PUBLIC_API.md`s.

## Removed APIs

- `1.0.0` — Removed skills `ddd-layering`, `domain-modeling`, and
  `repository-pattern`. These shipped a DDD / clean-architecture opinion by
  default, which conflicts with project-boost-php's framework-agnostic remit (they
  mislead ActiveRecord/Eloquent-shaped apps). The 1.0 surface ships only
  universally-applicable skills. If you relied on the dropped skills, copy them
  into your own `.ai/skills/<name>/SKILL.md` (host copies shadow vendor skills),
  or pin the pre-rename package `sandermuller/project-boost:^0.10` (this package's
  former name before the 1.0 rename to `sandermuller/project-boost-php`; its 0.x
  tags still carry the dropped skills).

<!-- Track removed APIs here so consumers know what was removed when. Example:
- `0.5.0` — Removed skill `legacy-foo`. Replaced by `bar`.
-->
