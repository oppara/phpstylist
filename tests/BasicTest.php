<?php
require_once __DIR__ . '/PhpStylistTestCase.php';

class BasicTest extends PhpStylistTestCase
{

    /**
     * @test
     * @group if
     */
    public function handleIf01()
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
     * @group class
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



