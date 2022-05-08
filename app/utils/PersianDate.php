<?php

namespace App\utils;

use IntlDateFormatter;

defined( 'ABSPATH' ) || die( "No Access" );

class PersianDate {

	public static function convert( $date, $pattern ) {

		$formatter = new IntlDateFormatter(
			"fa_IR@calender=persian",
			IntlDateFormatter::FULL,
			IntlDateFormatter::FULL,
			"Asia/Tehran",
			IntlDateFormatter::TRADITIONAL,
			$pattern );

		return $formatter->format( $date );

	}

}