<?php

namespace CodeBreaker;

class Matcher
{
    const OUTPUT_CORRECT_BUT_NOT_IN_ORDEN = '*';
    const OUTPUT_CORRECT_IN_ORDEN         = 'X';

    private $secretCode;
    private $correctButNotInOrder = 0;
    private $correctInOrder = 0;


    public function setSecretCode($code)
    {
        $this->secretCode = $code;
    }

    public function match(array $code)
    {
        foreach ($code as $key => $value) {
            $this->iterateOverCodeItem($key, $value);
        }

        return $this->renderOutput();
    }

    private function renderOutput()
    {
        return implode(null, array(
            str_repeat(self::OUTPUT_CORRECT_IN_ORDEN, $this->correctInOrder),
            str_repeat(self::OUTPUT_CORRECT_BUT_NOT_IN_ORDEN, $this->correctButNotInOrder)
        ));
    }

    private function iterateOverCodeItem($key, $value)
    {
        if ($this->isKeyValueCorrectInOrder($key, $value)) {
            $this->correctInOrder++;
        } else {
            if (in_array($value, $this->secretCode)) {
                $this->correctButNotInOrder++;
            }
        }
    }

    private function isKeyValueCorrectInOrder($key, $value)
    {
        return $this->secretCode[$key] == $value;
    }
}