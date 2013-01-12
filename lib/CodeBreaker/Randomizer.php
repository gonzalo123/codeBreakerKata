<?php

namespace CodeBreaker;

class Randomizer
{
    static function generate()
    {
        $availableValues = ['R', 'A', 'M', 'V', 'N', 'I'];
        $out = [];
        foreach (array_rand($availableValues, 4) as $key) {
            $out[] = $availableValues[$key];
        }

        return $out;
    }
}