<?php

declare(strict_types=1);

use SanderMuller\BoostCore\Skills\FrontmatterParser;

/**
 * Validates that every shipped guideline in resources/boost/guidelines/
 * parses, has a non-empty body, and opens with a Markdown `#` heading.
 *
 * Guidelines carry no frontmatter — boost-core derives the guideline name
 * from the filename. Catches the regression class of: an empty file, a file
 * that opens with stray frontmatter, or a missing leading heading.
 */
function shippedGuidelines(): array
{
    $dir = __DIR__ . '/../../resources/boost/guidelines';
    $entries = scandir($dir);
    if ($entries === false) {
        return [];
    }

    $guidelines = [];
    foreach ($entries as $entry) {
        if (str_ends_with($entry, '.md')) {
            $guidelines[] = $entry;
        }
    }

    return $guidelines;
}

it('ships at least one guideline', function (): void {
    expect(shippedGuidelines())->not->toBeEmpty();
});

it('every shipped guideline has a non-empty body opening with a heading', function (): void {
    $parser = new FrontmatterParser();
    $dir = __DIR__ . '/../../resources/boost/guidelines';

    foreach (shippedGuidelines() as $filename) {
        $contents = (string) file_get_contents($dir . '/' . $filename);
        $parsed = $parser->parse($contents);

        expect($parsed->body)
            ->toBeString()
            ->not->toBe('');

        expect(str_starts_with(ltrim($parsed->body), '# '))->toBeTrue();
    }
});
