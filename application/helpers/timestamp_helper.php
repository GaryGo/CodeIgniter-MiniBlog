<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function timeFormat($enddate, $startdate) {
	$year=floor((strtotime($enddate)-strtotime($startdate))/946080000);
	$month=floor((strtotime($enddate)-strtotime($startdate))/2592000);
	$day=floor((strtotime($enddate)-strtotime($startdate))/86400);
	$hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
	$minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
	$second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);

	$time_pass = array(
			'year' => $year,
			'month' => $month,
			'day' => $day,
			'hour' => $hour,
			'minute' => $minute,
			'second' => $second
		);
	return $time_pass;
}


function longEnoughToVisitAgain($enddate, $startdate) {
	if (floor((strtotime($enddate)-strtotime($startdate))) > 1800) {
		return TRUE;
	} else {
		return FALSE;
	}
}








?>