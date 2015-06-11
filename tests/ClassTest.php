<?php
require_once __DIR__ . '/PhpStylistTestCase.php';

class ClassTest extends PhpStylistTestCase
{

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

