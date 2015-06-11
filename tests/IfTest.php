<?php
require_once __DIR__ . '/PhpStylistTestCase.php';

class IfTest extends PhpStylistTestCase
{

    /**
     * @test
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
}



