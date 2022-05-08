<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class OTP extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table = $this->table_prefix . 'mobile_numbers';
	}

	private function is_exist( $number_mobile ) {
		return $this->db->query( $this->db->prepare( "
        SELECT mob.id
        FROM {$this->table} mob
        WHERE mob.mobile_number=%s
        ", $number_mobile ) );
	}

	public function verify_OTP( $number_mobile ) {

		$result = $this->db->get_row( $this->db->prepare( "
        SELECT *
        FROM {$this->table} mob
        WHERE mob.mobile_number=%s
        ", $number_mobile ) );

		if ( intval( $result->attempts ) <= 0 ) {
			return - 1;
		}

		$this->db->update(
			$this->table,
			[ "attempts" => intval( $result->attempts ) - 1 ],
			[ "mobile_number" => $number_mobile ],
			[ "%d" ],
			[ "%s" ]
		);

		return $result;

	}

	public function set_OTP( $number_mobile ) {

		if ( $this->is_exist( $number_mobile ) ) {
			return $this->db->update(
				$this->table,
				[
					"otp"      => strval( rand( 100000, 999999 ) ),
					"attempts" => 3
				],
				[ "mobile_number" => $number_mobile ],
				[
					"%s",
					"%d"
				],
				[
					"%s"
				]
			);
		}

		return $this->db->insert(
			$this->table,
			[
				"mobile_number" => $number_mobile,
				"otp"           => strval( rand( 100000, 999999 ) )
			],
			[
				"%s",
				"%s"
			] );

	}

	public function get_OTP( $number_mobile ): ?string {
		return $this->db->get_var( $this->db->prepare( "
        SELECT mob.otp
        FROM {$this->table} mob
        WHERE mob.mobile_number=%s
        ", $number_mobile ) );
	}

}