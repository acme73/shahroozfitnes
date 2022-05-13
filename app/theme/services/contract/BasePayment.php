<?php

namespace App\theme\services\contract;

use App\theme\services\PaymentsOption;

defined( 'ABSPATH' ) || die( "No Access" );

abstract class BasePayment {

	protected $options;

	public function __construct() {
		$this->options = PaymentsOption::get_payments();
	}

	abstract public function send_Request( $data );

	abstract public function verify_Request( $data );

}