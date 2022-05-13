<?php

namespace app\theme\services;

use App\theme\services\contract\BasePayment;

defined( 'ABSPATH' ) || die( "No Access" );

class IranKish extends BasePayment {

	private string $get_way_name;
	private $pay_option;

	public function __construct() {
		$this->get_way_name = 'irankish';
		parent::__construct();
		$this->pay_option = $this->options[ $this->get_way_name ];
	}

	public function send_Request( $data ) {


	}

	public function verify_Request( $data ) {
		// TODO: Implement verify_Request() method.
	}
}