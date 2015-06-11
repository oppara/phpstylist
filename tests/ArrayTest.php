<?php
require_once __DIR__ . '/PhpStylistTestCase.php';

class ArrayTest extends PhpStylistTestCase
{

    /**
     * @test
     * @group array
     */
    public function handleArray01()
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
    public function handleArray02()
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
     */
    public function handleArray03()
    {
        $str = <<<'EOF'
<?php
$a = array(array('foo' => 'bar'));
EOF;

        $expected = <<<'EOF'
<?php
$a = array(
    array(
        'foo' => 'bar',
    ),
);
EOF;

        $this->checkStyle($str, $expected);
    }
}



