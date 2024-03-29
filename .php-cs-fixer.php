<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER'                                        => true,
        'align_multiline_comment'                     => ['comment_type' => 'all_multiline'],
        'array_indentation'                           => true,
        'array_syntax'                                => ['syntax' => 'short'],
        'binary_operator_spaces'                      => ['default' => 'align_single_space_minimal', 'operators' => [], ],
        'cast_spaces'                                 => ['space' => 'none'],
        'combine_consecutive_issets'                  => true,
        'concat_space'                                => ['spacing' => 'one'],
        'explicit_indirect_variable'                  => true,
        'function_typehint_space'                     => true,
        'include'                                     => true,
        'linebreak_after_opening_tag'                 => true,
        'list_syntax'                                 => ['syntax' => 'short'],
        'magic_constant_casing'                       => true,
        'magic_method_casing'                         => true,
        'multiline_comment_opening_closing'           => true,
        'multiline_whitespace_before_semicolons'      => true,
        'native_function_casing'                      => true,
        'native_function_type_declaration_casing'     => true,
        'no_alias_language_construct_call'            => true,
        'no_alternative_syntax'                       => true,
        'no_empty_statement'                          => true,
        'no_extra_blank_lines'                        => true,
        'no_mixed_echo_print'                         => ['use' => 'print'],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast'                          => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_spaces_around_offset'                     => true,
        'no_superfluous_elseif'                       => true,
        'no_unneeded_control_parentheses'             => true,
        'no_unneeded_curly_braces'                    => true,
        'no_unset_cast'                               => true,
        'no_unused_imports'                           => true,
        'no_useless_concat_operator'                  => true,
        'no_useless_else'                             => true,
        'no_useless_return'                           => true,
        'no_whitespace_before_comma_in_array'         => true,
        'normalize_index_brace'                       => true,
        'object_operator_without_whitespace'          => true,
        'semicolon_after_instruction'                 => true,
        'single_line_comment_style'                   => true,
        'space_after_semicolon'                       => true,
        'standardize_not_equals'                      => true,
        'ternary_to_null_coalescing'                  => true,
        'trailing_comma_in_multiline'                 => true,
        'trim_array_spaces'                           => true,
        'unary_operator_spaces'                       => true,
        'whitespace_after_comma_in_array'             => true,
    ])
    ->setFinder($finder)
    ->setIndent("    ")
    ->setLineEnding("\n");
