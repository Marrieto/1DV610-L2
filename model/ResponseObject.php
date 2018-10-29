<?php

class ResponseObject
{

    private $WasSuccessful = false;
    private $Message = "";

    public function getWasSuccessful(): bool
    {
        return $this->WasSuccessful;
    }

    public function setWasSuccessful($state): void
    {
        $this->WasSuccessful = $state;
    }

    public function getMessage(): string
    {
        return $this->Message;
    }

    public function setMessage($input): void
    {
        $this->Message = $input;
    }

}
