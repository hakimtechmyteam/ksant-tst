<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/migrations',
    ])
    ->notName('*.html.php');
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'yoda_style' => true,
    ])
    ->setFinder($finder)
;
