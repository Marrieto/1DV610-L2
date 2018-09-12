<?php

require_once("model/TimeModel.php");

class DateTimeView {


	public function show() {

		$timeString = calculateDate();

		return '<p>' . $timeString . '</p>';
	}
}