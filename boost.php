<?php

declare(strict_types=1);

use SanderMuller\BoostCore\Config\BoostConfig;
use SanderMuller\BoostCore\Enums\Agent;
use SanderMuller\BoostCore\Enums\Tag;

/**
 * boost-core configuration — which AI agents `composer boost:sync` writes to,
 * which dependency vendors' shipped skills are synced, and which skill tags
 * are active.
 *
 * `withAllowedVendors()` is an explicit allowlist: a dependency's skills sync
 * ONLY if its package name is listed here. `withTags()` filters
 * `sandermuller/boost-skills` — universal skills always sync; each tag adds
 * its capability-specific set (e.g. `Tag::Php` adds backend-quality /
 * pre-release, `Tag::Github` adds pr-review-feedback). Re-run
 * `composer boost:install` to change agents/vendors/tags interactively, or
 * hand-edit this file; then run `composer boost:sync`.
 *
 * Docs: https://github.com/sandermuller/boost-core
 */
return BoostConfig::configure()
    ->withAgents([
        Agent::CLAUDE_CODE,
        Agent::COPILOT,
        Agent::CODEX,
    ])
    // `sandermuller/package-boost-php` provides maintainer-facing Composer
    // package-author skills (readme, release-notes, lean-dist, …). It ships a
    // package-author `foundation` guideline that collides with project-boost's
    // app-author `foundation` — for this repo (which IS a Composer package),
    // the package-author framing wins, so project-boost is intentionally NOT
    // self-listed here. Downstream consumers still get project-boost's
    // foundation via their own allowlist.
    // `stolt/lean-package-validator` ships three gitattributes-helper
    // skills (validating-/creating-/updating-gitattributes-file) under
    // boost-core's default `resources/boost/skills/` path — auto-discovered
    // without an `extra.boost.skills` declaration. Do not remove.
    ->withAllowedVendors([
        'sandermuller/boost-skills',
        'sandermuller/package-boost-php',
        'stolt/lean-package-validator',
    ])
    ->withTags(Tag::Php, Tag::Github, 'release-automation');
