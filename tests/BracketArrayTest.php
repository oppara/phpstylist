<?php
require_once __DIR__ . '/PhpStylistTestCase.php';

class BracketArrayTest extends PhpStylistTestCase
{
    public function setUp()
    {
        parent::setUp();

        if (PHP_VERSION_ID < _PHP54) {
            $this->markTestSkipped();
        }
    }

    /**
     * @test
     * @group array
     */
    public function handleBracketArray01()
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
    public function handleBracketArray02()
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
     */
    public function handleBracketArray03()
    {
        $str = <<<'EOF'
<?php
$a=[
    ['foo' => 33, 'bar' => false]
];
EOF;

        $expected = <<<'EOF'
<?php
$a = [
    [
        'foo' => 33,
        'bar' => false,
    ],
];
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     */
    public function handleBracketArray04()
    {
        $str = <<<'EOF'
<?php
$a=[
    ['foo', ['bar']]
];
EOF;

        $expected = <<<'EOF'
<?php
$a = [
    [
        'foo',
        [
            'bar',
        ],
    ],
];
EOF;

        $this->checkStyle($str, $expected);
    }

    /**
     * @test
     */
    public function ignoreBracketArray()
    {
        $str = <<<'EOF'
<?php
$a=[
    ['foo', ['bar']]
];
EOF;

        $expected = <<<'EOF'
<?php
$a = [['foo', ['bar']]];
EOF;

        $this->ps->options['IGNORE_BRACKET_ARRAY'] = true;
        $this->checkStyle($str, $expected);
    }
}

