<?php

use CodeBreaker\Matcher;

class MatcherTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provider */
    public function testNewAttemp($secretCode, $codeToMatch, $output)
    {
        $code = new Matcher();
        $code->setSecretCode($secretCode);
        $this->assertEquals($output, $code->match($codeToMatch));
    }

    public static function provider()
    {
        return array(
            array('secretCode' => ['R', 'A', 'N', 'I'], 'codeToMatch' => ['Y', 'N', 'Y', 'I'], 'output' => 'X*'),
            array('secretCode' => ['R', 'A', 'N', 'I'], 'codeToMatch' => ['R', 'M', 'V', 'I'], 'output' => 'XX'),
            array('secretCode' => ['N', 'R', 'R', 'I'], 'codeToMatch' => ['R', 'R', 'V', 'N'], 'output' => 'X**'),
            array('secretCode' => ['N', 'N', 'N', 'N'], 'codeToMatch' => ['R', 'R', 'R', 'R'], 'output' => ''),
            array('secretCode' => ['R', 'A', 'N', 'I'], 'codeToMatch' => ['R', 'A', 'N', 'I'], 'output' => 'XXXX'),
            array('secretCode' => ['R', 'A', 'N', 'I'], 'codeToMatch' => ['I', 'N', 'A', 'R'], 'output' => '****'),
        );
    }
}