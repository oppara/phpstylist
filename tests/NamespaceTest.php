<?php
require_once __DIR__ . '/PhpStylistTestCase.php';

class NamespaceTest extends PhpStylistTestCase
{

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
}



