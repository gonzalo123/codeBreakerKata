<?php

use CodeBreaker\Randomizer;

class RandomizerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateRandomArray()
    {
        $availableElements = ['R', 'A', 'M', 'V', 'N', 'I'];
        $code = Randomizer::generate();
        foreach ($code as $codeItem) {
            $this->assertTrue(in_array($codeItem, $availableElements));
        }
    }
}