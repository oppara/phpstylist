<?php
class PhpStylistTest extends PHPUnit_Framework_TestCase
{
    const INDENT_SIZE = 4;

    protected $valid_options = array(
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
        foreach ($this->valid_options as $opt) {
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

    /**
     * @test
     * @group array
     */
    public function handleArray()
    {
        $str = <<<'EOF'
<?php
$a = array('foo' => 'bar', 'barbar' => 'baz');
EOF;

        $expected = <<<'EOF'
<?php
$a = array(
    'foo' => 'bar',
    'barbar' => 'baz',
);
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     * @group deep_array
     */
    public function handleDeepArray()
    {
        $str = <<<'EOF'
<?php
$a = array('foo' =>'bar','barbar'=>array('baz'=>array('1', '2')));
EOF;

        $expected = <<<'EOF'
<?php
$a = array(
    'foo' => 'bar',
    'barbar' => array(
        'baz' => array(
            '1',
            '2',
        ),
    ),
);
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     * @group array
     */
    public function handleBracketArray()
    {
        if (PHP_VERSION_ID < _PHP54) {
            $this->markTestSkipped();
        }

        $str = <<<'EOF'
<?php
$a = ['foo' => 'bar', 'barbar' => 'baz'];
EOF;

        $expected = <<<'EOF'
<?php
$a = [
    'foo' => 'bar',
    'barbar' => 'baz',
];
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     * @group deep_array
     */
    public function handleDeepBracketArray()
    {
        if (PHP_VERSION_ID < _PHP54) {
            $this->markTestSkipped();
        }

        $str = <<<'EOF'
<?php
$a=['foo' =>'bar','barbar'=>['baz'=>['1','2']]];
EOF;

        $expected = <<<'EOF'
<?php
$a = [
    'foo' => 'bar',
    'barbar' => [
        'baz' => [
            '1',
            '2',
        ],
    ],
];
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     * @group namespace
     */
    public function handleNamespace()
    {
        $str = <<<'EOF'
<?php
namespace \Foo\Bar\Baz\Hogehoge;
use \Foo\Bar\Baz;
EOF;

        $expected = <<<'EOF'
<?php
namespace \Foo\Bar\Baz\Hogehoge;
use \Foo\Bar\Baz;
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     */
    public function handleIf()
    {
        $str = <<<'EOF'
<?php
if($foo===''){}elseif($bar===''){}else{}
EOF;

        $expected = <<<'EOF'
<?php
if ($foo === '') {
} elseif ($bar === '') {
} else {
}
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     */
    public function handleClass()
    {
        $str = <<<'EOF'
<?php
class Foo extends Bar{public function baz($foo,$bar){}}
EOF;

        $expected = <<<'EOF'
<?php
class Foo extends Bar
{

    public function baz($foo, $bar)
    {
    }
}
EOF;

        $this->checkStyle($str, $expected);
    }
}
