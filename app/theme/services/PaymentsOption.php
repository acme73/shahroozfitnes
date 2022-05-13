<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class PaymentsOption {

	const PAYMENTS_OPTION_NAME = '_payments_option';

	public static function get_payments() {
		return get_option( self::PAYMENTS_OPTION_NAME );
	}

	public static function update_payment( $payment, $data ) {

		$payments = empty( self::get_payments() ) ? [] : self::get_payments();

		$payments[ $payment ] = $data;

		update_option( self::PAYMENTS_OPTION_NAME, $payments );

	}

}