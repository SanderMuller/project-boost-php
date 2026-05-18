# project-boost

> AI agent skills for PHP application developers (any framework or none). Pure skill bundle — five opinionated skills covering DDD layering, dependency injection, repository pattern, domain modeling, and legacy-coexistence in PHP 7.x→8.x codebases. No PHP code, no commands of its own; depends on [`sandermuller/boost-core`](https://github.com/sandermuller/boost-core) for the sync mechanism.

## Install

```bash
composer require --dev "sandermuller/project-boost:^1.0@dev"
```

Set `minimum-stability` to `dev` in your `composer.json` (or use the `@dev` suffix on the constraint as above) — `boost-core` only ships `dev-main` on Packagist for now, no tagged releases yet.

## Usage

```bash
composer boost:init      # generate boost.php starter (from boost-core)
composer boost:install   # interactive picker: agents + vendor allowlist
                         # project-boost is pre-checked (first-party)
composer boost:sync      # fan out skills to selected agents
```

After `boost:install`, the five shipped skills land in your selected agent directories (`.claude/skills/`, `.cursor/skills/`, etc.) and you can edit `.ai/skills/` to override any of them in your own project.

## License

MIT. See [LICENSE](LICENSE).
