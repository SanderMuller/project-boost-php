<?php

declare(strict_types=1);

use SanderMuller\BoostCore\Skills\FrontmatterParser;

/**
 * Validates that every shipped skill in resources/boost/skills/ parses with
 * valid frontmatter, has a non-empty `name` matching the skill directory, and
 * a non-empty `description` so AI agents can route to it.
 *
 * Each skill is a `<name>/SKILL.md` directory (boost-core's canonical source
 * shape, shared with boost-skills and the wider family).
 *
 * Catches the regression class of: someone adds a skill with a typo'd
 * frontmatter key, mismatched name, or empty description.
 */
function shippedSkills(): array
{
    $dir = __DIR__ . '/../../resources/boost/skills';
    $entries = scandir($dir);
    if ($entries === false) {
        return [];
    }

    $skills = [];
    foreach ($entries as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        if (is_file($dir . '/' . $entry . '/SKILL.md')) {
            $skills[] = $entry;
        }
    }

    return $skills;
}

it('ships at least one skill', function (): void {
    expect(shippedSkills())->not->toBeEmpty();
});

it('every shipped skill has parseable frontmatter with required fields', function (): void {
    $parser = new FrontmatterParser();
    $dir = __DIR__ . '/../../resources/boost/skills';

    foreach (shippedSkills() as $name) {
        $contents = (string) file_get_contents($dir . '/' . $name . '/SKILL.md');
        $parsed = $parser->parse($contents);

        expect($parsed->frontmatter)
            ->toHaveKey('name')
            ->toHaveKey('description');

        expect($parsed->frontmatter['name'] ?? null)->toBe($name);

        expect($parsed->frontmatter['description'] ?? null)
            ->toBeString()
            ->not->toBe('');

        expect($parsed->body)->not->toBe('');
    }
});
