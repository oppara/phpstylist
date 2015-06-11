<?php
abstract class PhpStylistTestCase extends PHPUnit_Framework_TestCase
{
    const INDENT_SIZE = 4;

    protected $default_options = array(
        'line_before_comment_multi',
        'keep_redundant_lines',
        'space_after_comma',
        'space_around_assignment',
        'align_var_assignment',
        'space_around_comparison',
        'space_around_arithmetic',
        'space_around_logical',
        'space_around_colon_question',
        'line_before_function',
        'line_before_curly_function',
        'space_after_if',
        'add_missing_braces',
        'space_inside_for',
        'indent_case',
        'else_along_curly',
        'line_after_break',
        'space_around_double_arrow',
        'space_around_concat',
        'vertical_array',
        'align_array_assignment',
    );

    /**
     * @var phpStylist
     */
    protected $ps;

    protected function setUp()
    {
        $this->ps = new phpStylist();
        $this->ps->indent_size = self::INDENT_SIZE;
        foreach ($this->default_options as $opt) {
            $this->ps->options[strtoupper($opt)] = true;
        }
    }

    protected function checkStyle($src, $expected, $show = false)
    {
        $actual = $this->ps->formatCode($src);
        if ($show) {
            echo "\n";
            echo $actual;
            echo "\n";
        }
        $this->assertEquals(trim($expected), trim($actual));
    }

}
