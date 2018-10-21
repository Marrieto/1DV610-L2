<?php

require_once "model/TimeModel.php";

class DateTimeView
{

    public function show(): string
    {

        $timeString = calculateDate();

        return '<p>' . $timeString . '</p>';
    }
}
