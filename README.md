# project-boost

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sandermuller/project-boost.svg?style=flat-square)](https://packagist.org/packages/sandermuller/project-boost)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sandermuller/project-boost/ci.yml?branch=main&label=tests&style=flat-square)](https://github.com/sandermuller/project-boost/actions/workflows/ci.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/sandermuller/project-boost.svg?style=flat-square)](https://packagist.org/packages/sandermuller/project-boost)
[![License](https://img.shields.io/packagist/l/sandermuller/project-boost.svg?style=flat-square)](LICENSE)

> AI agent skills for PHP application developers (any framework or none). Pure skill bundle — five opinionated skills covering DDD layering, dependency injection, repository pattern, domain modeling, and legacy-coexistence in PHP 7.x→8.x codebases. No PHP code, no commands of its own; depends on [`sandermuller/boost-core`](https://github.com/sandermuller/boost-core) for the sync mechanism.

## Install

```bash
composer require --dev sandermuller/project-boost
```

## Usage

```bash
composer boost:install   # interactive picker: agents + vendor allowlist
                         # auto-generates boost.php on first run
                         # project-boost is pre-checked (first-party)
vendor/bin/boost sync    # fan out skills to selected agents
```

After `boost:install`, the five shipped skills land in your selected agent directories (`.claude/skills/`, `.cursor/skills/`, etc.) and you can edit `.ai/skills/` to override any of them in your own project.

Generated agent dirs are added to `.gitignore` automatically and regenerated on every `composer install` — edit `.ai/` only. Set `BOOST_SKIP_AUTOSYNC=1` to disable the auto-regen.

## License

MIT. See [LICENSE](LICENSE).
