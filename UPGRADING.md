# Upgrading

project-boost ships no PHP API — it's a skill bundle. The shipped skills and the
`foundation` guideline are additive; for *what* changed each release, see
[`CHANGELOG.md`](CHANGELOG.md). This file covers the one thing that is *more than*
a find/replace: the transitive **`sandermuller/boost-core` constraint** project-boost
carries. If your own `composer.json` also pins `sandermuller/boost-core`, your pin
must stay compatible with project-boost's as it advances — or drop the explicit pin
and let project-boost's transitive bound own it.

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
