<?php

// 20260101010726
declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->in(__DIR__)
    ->exclude(['node_modules', 'vendor'])
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // PSR-12 基础编码规范。
        '@PSR12' => true,
        // PhpCsFixer 完整规则集。
        '@PhpCsFixer' => true,
        // 启用 PhpCsFixer risky 规则以更严格一致性。
        '@PhpCsFixer:risky' => true,
        // 使用短数组语法 []，替代 array()。
        'array_syntax' => ['syntax' => 'short'],
        // 使用短列表语法 []。
        'list_syntax' => ['syntax' => 'short'],
        // 多行数组与参数列表保留尾随逗号。
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'arguments']],
        // 强制文件包含 declare(strict_types=1)。
        'declare_strict_types' => true,
        // 命名空间内调用原生函数时使用完全限定名。
        'native_function_invocation' => [
            'scope' => 'namespaced',
            'include' => ['@all'],
            'strict' => true,
        ],
        // 移除多余 PHPDoc 标签，保留 mixed 与 inheritdoc 配置。
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
            'remove_inheritdoc' => false,
        ],
        // 垂直对齐 PHPDoc 注解列。
        'phpdoc_align' => ['align' => 'vertical'],
        // 按字母顺序排序 use 导入。
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        // 每条语句只导入一个符号。
        'single_import_per_statement' => true,
        // 规范单行注释，禁用 # 形式。
        'single_line_comment_style' => ['comment_types' => ['hash']],
    ])
    ->setFinder($finder)
;
