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

		$params = [
			'api'          => $this->pay_option['api'],
			'amount'       => $data['amount'],
			'redirect'     => urlencode( home_url() . '/verify?payment=irankish' ),
			'mobile'       => $data['mobile'],
			'factorNumber' => $data['factorNumber'],
			'description'  => $data['description']
		];

		return true;

	}

	public function verify_Request( $data ) {

	}
}