<?php

require_once "model/TimeModel.php";

class DateTimeView
{
    private $timeModel;

    public function __construct()
    {
        $this->timeModel = new TimeModel();
    }

    public function show(): string
    {

        // $timeString = calculateDateAndTime();

        return '<p>' . $this->timeModel->calculateDateAndTime( ) . '</p>';
    }
}
