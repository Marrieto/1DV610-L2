<?php

class StatusMessage
{

    private $messageState = false;
    private $messageString = "";

    public function getMessageState(): bool
    {
        return $this->messageState;
    }

    public function setMessageState($state): void
    {
        $this->messageState = $state;
    }

    public function getMessageString(): string
    {
        return $this->messageString;
    }

    public function setMessageString($input): void
    {
        $this->messageString = $input;
    }

}
