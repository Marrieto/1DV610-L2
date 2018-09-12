<?php

	function calculateDate() {

		$currentTime 		= getdate();
		$weekDay			= $currentTime["weekday"];
		$mday 				= $currentTime["mday"];
		$month				= $currentTime["month"];
		$year				= $currentTime["year"];

		return $weekDay . ", the " . $mday . "th of " . $month . " " . $year . ", The time is ";
	}
