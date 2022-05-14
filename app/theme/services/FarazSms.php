<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class FarazSms {

	static $param = [
		"username" => 'meysam-arabi',
		"password" => 'xuxHu6-vegtes-gavked',
		"from"     => '+983000505',
		"url"      => 'https://ippanel.com/patterns/pattern?'
	];

	public static function sendPattern( $pattern_code, $to, $input_data = null ) {
		$url =
			self::$param['url']
			. 'username=' . self::$param['username']
			. '&password=' . urlencode( self::$param['password'] )
			. '&from=' . self::$param['from']
			. '&to=' . json_encode( $to )
			. "&input_data=" . urlencode( json_encode( $input_data ) )
			. '&pattern_code=' . $pattern_code;

		$handler = curl_init( $url );
		curl_setopt( $handler, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt( $handler, CURLOPT_POSTFIELDS, $input_data );
		curl_setopt( $handler, CURLOPT_RETURNTRANSFER, true );

		return curl_exec( $handler );

	}

}