<?php

class TimeModel
{

    public function calculateDateAndTime()
    {
    
        date_default_timezone_set("Europe/Stockholm");
        $currentTime = getdate();
        $weekDay = $currentTime["weekday"];
        $mday = $currentTime["mday"];
        $month = $currentTime["month"];
        $year = $currentTime["year"];
        $hours = $currentTime["hours"];
        $minutes = $currentTime["minutes"];
    
    
        return $weekDay . ", the " . $this->ordinal($mday) . " of " . $month . " " . $year . ", The time is " . $hours . ":" . ($minutes < 10 ? "0" . $minutes : $minutes) . ".";
    }
    
    // Copied from: https://stackoverflow.com/questions/3109978/display-numbers-with-ordinal-suffix-in-php 21/09/18
    private function ordinal($number): string
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }

}


