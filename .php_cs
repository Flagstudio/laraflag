<?php

$rules = [
    'psr0' => false,
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag' => true,
    'phpdoc_no_alias_tag' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_order' => true,
    'phpdoc_separation' => true,
    'phpdoc_trim' => true,
    'no_empty_phpdoc' => true,
    'no_empty_comment' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'line_ending' => true,
];

$excludes = [
    'bootstrap',
    'vendor',
    'storage',
    'node_modules',
];

return PhpCsFixer\Config::create()
    ->setLineEnding(PHP_EOL)
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->name('*.php')
            ->exclude($excludes)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
            ->notName('_ide_helper.php')
            ->notName('*.blade.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
    );