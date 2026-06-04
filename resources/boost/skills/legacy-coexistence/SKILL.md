---
name: legacy-coexistence
description: Add modern PHP code to a legacy 7.x codebase incrementally. Typed properties, readonly, enums — how to introduce them without forcing a big-bang upgrade.
---

# Legacy coexistence

## When to apply

- Working in a codebase with mixed PHP 7.4 and modern PHP 8+ code
- Asked "can I use enums here?" / "is readonly safe in this file?"
- Reviewing a PR that introduces modern syntax in a legacy module

## The reality

Many production PHP codebases run a PHP 7.4 baseline but allow modern
features in NEW code, planned for an eventual upgrade. The mix is
intentional, not a smell — as long as new code is forward-compatible.

## Forward-compatibility rules

For NEW code (added today, runs on 7.4 today, migrates cleanly to 8.x):

- ✅ Type hints (incl. `?Type`, `Type|null`, union types if 8.0+)
- ✅ Return types
- ✅ Strict types (`declare(strict_types=1)`)
- ✅ Constructor property promotion (PHP 8.0+) — only if you've moved off 7.4
- ✅ Match expressions (8.0+) — only post-7.4
- ❌ Typed properties — 7.4 supports them; safe to add
- ⚠️ Readonly properties (8.1+) — fine only post-7.4
- ⚠️ Enums (8.1+) — fine only post-7.4
- ❌ Named arguments (8.0+) — caller-side feature, breaks 7.x callers

## How to introduce modern features incrementally

1. **Decide a feature floor per module.** `src/Elements/` may be 8.2+;
   `src/autoload/` (legacy) stays 7.4 until rewritten.
2. **Use static analysis to enforce the boundary.** PHPStan
   `phpVersion: 70400` for legacy paths; per-path overrides for
   modern modules.
3. **Don't half-modernize.** A function with PHP 8 syntax in a 7.4
   namespace will crash at runtime. Keep the floor consistent within
   a file.

## Concrete patterns

**Adding a value object to legacy code:**

```php
// New file: src/Elements/Value/EmailAddress.php  (8.2+ floor)
namespace Elements\Value;

final readonly class EmailAddress
{
    public function __construct(public string $value) { /* ... */ }
}
```

Use it from legacy code (7.4):

```php
// Legacy: src/autoload/SomeOldClass.php  (7.4 floor)
class SomeOldClass
{
    private $email; // untyped — fine, legacy

    public function setEmail($value): void {
        $this->email = new \Elements\Value\EmailAddress($value);
    }
}
```

Legacy code can CONSUME modern classes; it just can't internally use
syntax not yet supported by the legacy floor.

## Anti-patterns

- Sprinkling modern syntax randomly in legacy files → runtime errors on
  legacy servers
- Refusing to add ANY modern code because "the rest is legacy" → no path
  to ever modernize
- Modernizing everything at once → big-bang migrations fail. Incremental
  is the only sustainable approach.

## See also

- `ddd-layering` for the modern-code boundary (typically Domain in
  modern PHP, Infrastructure can mix)
- `domain-modeling` for value objects that work in mixed-floor codebases
