<?php

namespace Symfony\Component\Messenger\Bridge\Doctrine\Tests\Fixtures;

class DummyMessage
{
    public function __construct(
        private string $message,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
