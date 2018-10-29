<?php

class ResponseObject
{

    private $WasSuccessful = false;
    private $Message = "";

    public function wasSuccessful(): bool
    {
        return $this->WasSuccessful;
    }

    public function setSuccessful($state): void
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
