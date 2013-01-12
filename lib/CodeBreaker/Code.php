<?php

namespace CodeBreaker;

use CodeBreaker\Matcher;
use CodeBreaker\Exception;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Code
{
    const EVENT_CODE_SOLVED = 'code.solved';
    const EVENT_MAX_ATTEMPS = 'code.max.attemps';

    private $matcher;
    private $dispatcher;
    private $code;
    private $finished = false;

    private $maxAtteps = 3;

    private $attemps = 0;

    public function __construct(array $code, Matcher $matcher, EventDispatcher $dispatcher)
    {
        $this->code       = $code;
        $this->matcher    = $matcher;
        $this->dispatcher = $dispatcher;

        $this->matcher->setSecretCode($code);
    }

    public function matchTo(array $code)
    {
        if ($this->finished) {
            throw new Exception('Code is locked');
        }

        $this->attemps++;

        $output = $this->matcher->match($code);

        if ($code == $this->code) {
            $this->finished = true;
            $this->dispatcher->dispatch(self::EVENT_CODE_SOLVED);
            return;
        }

        if ($this->attemps >= $this->maxAtteps) {
            $this->finished = true;
            $this->dispatcher->dispatch(self::EVENT_MAX_ATTEMPS);
        }

        return $output;
    }

    public function setMaxAtteps($maxAtteps)
    {
        $this->maxAtteps = $maxAtteps;
    }
}