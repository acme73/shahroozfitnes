<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class Hooks {

	public function __construct() {

		add_action( "f1_send_otp_code", [ $this, "send_otp_code" ], 10, 2 );

	}

	public function send_otp_code( $to, $otp ) {

		FarazSms::sendPattern( "wp3axjpkc63vyvr", $to, [ "otp" => $otp ] );

	}

}

