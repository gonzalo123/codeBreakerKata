<?php

use CodeBreaker\Code;
use CodeBreaker\Exception;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CodeTest extends \PHPUnit_Framework_TestCase
{
    /** @return CodeBreaker\Code */
    public function testEndGameWithCorrectCode()
    {
        $isFinished = false;

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(Code::EVENT_CODE_SOLVED, function () use (&$isFinished) {
            $isFinished = true;
        });

        $code = new Code(['R', 'A', 'N', 'I'], $this->getMockMatcherWithOutput('XXXX'), $dispatcher);

        $this->assertFalse($isFinished, 'start');
        $code->matchTo(['R', 'A', 'N', 'I']);
        $this->assertTrue($isFinished, 'end');

        return $code;
    }

    public function testMaxAttempsReached()
    {
        $maxAttempsLimit = false;

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(Code::EVENT_MAX_ATTEMPS, function () use (&$maxAttempsLimit) {
            $maxAttempsLimit = true;
        });

        $code = new Code(['R', 'A', 'N', 'I'], $this->getMockMatcherWithOutput(''), $dispatcher);
        $code->setMaxAtteps(3);
        $this->assertFalse($maxAttempsLimit, 'attempt1');
        $code->matchTo(['A', 'R', 'N', 'I']);
        $this->assertFalse($maxAttempsLimit, 'attempt2');
        $code->matchTo(['A', 'R', 'N', 'I']);
        $this->assertFalse($maxAttempsLimit, 'attempt3');

        $code->matchTo(['A', 'R', 'N', 'I']);
        $this->assertTrue($maxAttempsLimit, 'max attempt reached');

        return $code;
    }

    /**
     * @expectedException Exception
     */
    public function testCannotContinueAfterCorrectCode()
    {
        $code = $this->testEndGameWithCorrectCode();
        $code->matchTo(['R', 'A', 'N', 'I']);
    }

    /**
     * @expectedException Exception
     */
    public function testCannotContinueAfterMaxAttempsReached()
    {
        $code = $this->testMaxAttempsReached();
        $code->matchTo(['R', 'A', 'N', 'I']);
    }

    /**
     * @param $output
     * @return CodeBreaker\Matcher
     */
    private function getMockMatcherWithOutput($output)
    {
        $matcher = $this->getMockBuilder('CodeBreaker\Matcher')->getMock();
        $matcher->expects($this->any())->method('match')->will($this->returnValue($output));
        return $matcher;
    }
}