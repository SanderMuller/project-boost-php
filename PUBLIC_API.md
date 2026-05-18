# Public API

The semver-protected surface of `sandermuller/project-boost`. Anything documented here is covered by semver; anything outside is internal and may change without notice (including in patch releases).

## Versioning

This package follows [Semantic Versioning 2.0.0](https://semver.org/spec/v2.0.0.html). Pre-`1.0.0` releases may break API in MINOR bumps; we surface those in `CHANGELOG.md`.

## Stable surface

`project-boost` ships no PHP code. It is a skill bundle consumed by `sandermuller/boost-core` via the `extra.boost` keys in `composer.json`:

- `extra.boost.skills` — path to the skills root (currently `resources/boost/skills`).
- `extra.boost.guidelines` — path to the guidelines root (currently `resources/boost/guidelines`).

These two keys plus the on-disk layout under those paths are the public surface. Skill file names, skill IDs, and the SKILL.md frontmatter contract are covered by semver.

### Skills

Skills shipped from `resources/boost/skills/`. Each top-level directory is one skill; renaming or removing a skill is a BREAKING change.

<!-- Enumerate skill IDs once they stabilise. -->

### Guidelines

Guidelines shipped from `resources/boost/guidelines/`.

<!-- Enumerate guideline files once they stabilise. -->

## Internal (not covered by semver)

Anything not listed above. In particular: the internal organisation of skill markdown, code-block tags, examples — these may be reworded freely.

## Removed APIs

<!-- Track removed APIs here so consumers know what was removed when. Example:
- `0.5.0` — Removed skill `legacy-foo`. Replaced by `bar`.
-->
