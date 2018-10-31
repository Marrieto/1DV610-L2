<?php

class Note {

    public $username;
    public $content;
    public $id;

    public function __construct(string $username, string $text, int $id)
    {
        $this->username = $username;
        $this->content = $text;
        $this->id = $id;
    }

}
