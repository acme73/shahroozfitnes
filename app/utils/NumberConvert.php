<?php

namespace App\utils;

defined( 'ABSPATH' ) || die( "No Access" );

class NumberConvert {

	private static array $en_num = [ "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" ];

	private static array $fa_num = [ "۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹" ];


	public static function convert2persian( $num, $is_price = false ) {

		if ( ! $is_price ) {
			return str_replace( self::$en_num, self::$fa_num, $num );
		}

		return str_replace( self::$en_num, self::$fa_num, number_format( $num ) );
	}


	public static function convert2english( $num, $is_price = false ) {

		if ( ! $is_price ) {
			return str_replace( self::$fa_num, self::$en_num, $num );
		}

		return str_replace( self::$fa_num, self::$en_num, number_format( $num ) );
	}

}