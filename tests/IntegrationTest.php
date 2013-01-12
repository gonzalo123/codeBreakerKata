<?php

use CodeBreaker\Randomizer;
use CodeBreaker\Code;
use CodeBreaker\Matcher;
use Symfony\Component\EventDispatcher\EventDispatcher;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testWholeApplication()
    {
        $isFinished = $maxAttempsLimit = false;

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(Code::EVENT_MAX_ATTEMPS, function () use (&$maxAttempsLimit) {
            $maxAttempsLimit = true;
        });
        $dispatcher->addListener(Code::EVENT_CODE_SOLVED, function () use (&$isFinished) {
            $isFinished = true;
        });

        $secretCode = Randomizer::generate();
        $code = new Code($secretCode, new Matcher(), $dispatcher);

        $codeToMatch = Randomizer::generate();

        $code->matchTo($codeToMatch);

        if ($secretCode == $codeToMatch) {
            $this->assertTrue($isFinished);
        }
    }
}