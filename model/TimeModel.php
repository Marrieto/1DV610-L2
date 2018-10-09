<?php

function calculateDate()
{

    date_default_timezone_set("Europe/Stockholm");
    $currentTime = getdate();
    $weekDay = $currentTime["weekday"];
    $mday = $currentTime["mday"];
    $month = $currentTime["month"];
    $year = $currentTime["year"];

    return $weekDay . ", the " . ordinal($mday) . " of " . $month . " " . $year . ", The time is ";
}

/*     Copied from:
https://stackoverflow.com/questions/3109978/display-numbers-with-ordinal-suffix-in-php
21/09/18
 */
function ordinal($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}
