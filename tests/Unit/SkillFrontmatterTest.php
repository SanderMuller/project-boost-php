<?php

declare(strict_types=1);

use SanderMuller\BoostCore\Skills\FrontmatterParser;

/**
 * Validates that every shipped skill in resources/boost/skills/ parses with
 * valid frontmatter, has a non-empty `name` matching the filename, and a
 * non-empty `description` so AI agents can route to it.
 *
 * Catches the regression class of: someone adds a skill with a typo'd
 * frontmatter key, mismatched name, or empty description.
 */
function shippedSkills(): array
{
    $dir = __DIR__.'/../../resources/boost/skills';
    $entries = scandir($dir);
    if ($entries === false) {
        return [];
    }

    $skills = [];
    foreach ($entries as $entry) {
        if (str_ends_with($entry, '.md')) {
            $skills[] = $entry;
        }
    }

    return $skills;
}

it('ships at least one skill', function (): void {
    expect(shippedSkills())->not->toBeEmpty();
});

it('every shipped skill has parseable frontmatter with required fields', function (): void {
    $parser = new FrontmatterParser;
    $dir = __DIR__.'/../../resources/boost/skills';

    foreach (shippedSkills() as $filename) {
        $contents = (string) file_get_contents($dir.'/'.$filename);
        $parsed = $parser->parse($contents);
        $expectedName = substr($filename, 0, -3); // strip .md

        expect($parsed->frontmatter)
            ->toHaveKey('name')
            ->toHaveKey('description');

        expect($parsed->frontmatter['name'] ?? null)->toBe($expectedName);

        expect($parsed->frontmatter['description'] ?? null)
            ->toBeString()
            ->not->toBe('');

        expect($parsed->body)->not->toBe('');
    }
});
