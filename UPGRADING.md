# Upgrading

project-boost-php ships no PHP API — it's a skill bundle. The shipped skills and the
`foundation` guideline are additive; for *what* changed each release, see
[`CHANGELOG.md`](CHANGELOG.md). This file covers the things that are *more than*
a find/replace: the package rename at 1.0, and the transitive
**`sandermuller/boost-core` constraint** the package carries. If your own
`composer.json` also pins `sandermuller/boost-core`, your pin must stay compatible
with this package's as it advances — or drop the explicit pin and let the
transitive bound own it.

> The package was named `sandermuller/project-boost` through 0.x. It was renamed to
> `sandermuller/project-boost-php` at 1.0 (see below); pre-1.0 entries here use the
> former name.

## From 0.10 to 1.0

**The package was renamed** `sandermuller/project-boost` →
`sandermuller/project-boost-php`, aligning with the family naming convention
(`package-boost-php`, `project-boost-laravel`, …). Update your dependency:

```diff
- "sandermuller/project-boost": "^0.10"
+ "sandermuller/project-boost-php": "^1.0"
```

The old `sandermuller/project-boost` is marked abandoned on Packagist with
`sandermuller/project-boost-php` as its replacement; its 0.x tags stay installable
but receive no further releases.

**Update every reference to the old name, not just `composer.json`.** If your
`boost.php` allowlists or excludes this package, those identifiers must change too
— boost-core matches on the literal package name, so a stale reference silently
stops matching after the upgrade:

```diff
  // boost.php
- ->withAllowedVendors(['sandermuller/project-boost'])
+ ->withAllowedVendors(['sandermuller/project-boost-php'])

- ->withExcludedSkills(['sandermuller/project-boost:legacy-coexistence'])
+ ->withExcludedSkills(['sandermuller/project-boost-php:legacy-coexistence'])
```

A missed allowlist entry means **none** of this package's skills sync; a missed
excluded-skill ID means a skill you had excluded **reappears**.

**Three skills were removed** (BREAKING): `ddd-layering`, `domain-modeling`, and
`repository-pattern`. They shipped a DDD / clean-architecture opinion that
conflicts with the package's framework-agnostic remit. The 1.0 surface ships only
`dependency-injection` and `legacy-coexistence`, plus the `foundation` guideline.
If you relied on a dropped skill, copy it into your own `.ai/skills/<name>/SKILL.md`
(host copies shadow vendor skills), or pin the old package
`sandermuller/project-boost:^0.10` whose 0.x tags still carry them.

**The `sandermuller/boost-core` constraint** moved `^0.22 || ^0.23` → `^1.0`,
tracking the family's 1.0 freeze. If your project hard-pins boost-core at 0.x,
widen it:

```diff
- "sandermuller/boost-core": "^0.23"
+ "sandermuller/boost-core": "^1.0"
```

Or drop your explicit `sandermuller/boost-core` line and inherit the transitive
constraint. boost-core 1.0 froze the 0.23.3 surface under SemVer — both
skill-source shapes (flat `<name>.md` and `<name>/SKILL.md`) and the default
discovery paths are frozen-accepted, so the engine upgrade itself is a clean
drop-in.

## From 0.8 to 0.9

- `sandermuller/boost-core` moved `^0.8` → `^0.22`. If your project hard-pins
  boost-core at 0.8.x–0.21.x, widen it:
  ```diff
  - "sandermuller/boost-core": "^0.8"
  + "sandermuller/boost-core": "^0.22"
  ```
  Or remove your explicit `sandermuller/boost-core` line entirely and inherit
  project-boost's transitive constraint.
- Optional (not required): boost-core 0.17+ accepts a `.config/boost.php` config
  location. project-boost moved its own config there; you may mirror that or keep
  `boost.php` at the repo root — boost-core resolves either, just not both at once.
- If `boost sync` reports `skipped-symlink=N`, you have orphaned symlinks in your
  agent dirs from a pre-copy-era boost-core. They are gitignored and regenerable:
  `find .claude .agents .cursor -type l -delete && vendor/bin/boost sync` clears them.
