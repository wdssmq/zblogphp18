<?php
// 20260101003610
declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->in(__DIR__)
    ->exclude(['node_modules', 'vendor']);

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP73Migration' => true,
        '@PHP73Migration:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax' => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'arguments']],
        'declare_strict_types' => true,
        'native_function_invocation' => [
            'scope' => 'namespaced',
            'include' => ['@all'],
            'strict' => true,
        ],
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => false,
        ],
        'phpdoc_align' => ['align' => 'vertical'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'single_import_per_statement' => true,
        'single_line_comment_style' => ['comment_types' => ['hash']],
    ])
    ->setFinder($finder)
;
