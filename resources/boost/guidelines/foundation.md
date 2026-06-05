# Project Boost Guidelines

Curated guidelines for building **PHP applications** — on any framework, or
none. Follow them to work the way the codebase already works.

## Foundational Context

This codebase is a PHP application: code that runs — an HTTP front controller, a
CLI, a worker, or several — rather than a library other projects install. Work
with the grain of what is already here.

- Read `composer.json` first. `require.php` is the supported PHP version — check
  it before reaching for version-specific syntax. The `require` block names the
  framework (if any) and the libraries in play; treat their conventions as the
  house style.
- Match the framework the app already uses — Laravel, Symfony, or plain PHP.
  Don't import patterns from a stack this app didn't choose.

## Conventions

- Follow existing code conventions. Before creating or editing a file, read
  sibling files for structure, naming, and approach.
- Use descriptive names (`isEligibleForRefund`, not `check()`).
- Reuse existing helpers, services, and components before writing new ones.

## Tests

- Write tests alongside any behavioural change; run the configured runner
  (`vendor/bin/pest` or `vendor/bin/phpunit`) before calling a change done.
- Don't write throwaway verification scripts when a test pins the same behaviour
  down permanently.

## Structure & Dependencies

- Stick to the existing directory structure. Don't add top-level folders without
  a clear reason.
- Don't add or change dependencies without approval — every `require` is code to
  maintain, update, and audit. Reach for the standard library and what's already
  installed first.

## Documentation

- Only create or edit documentation (README, CHANGELOG, docs/) when explicitly
  requested or when a behavioural change requires it.

## Replies

- Be concise. Focus on what changed and why; skip restating what the diff shows.
