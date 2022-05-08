<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class CoachBalanceRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'coach_balance';
		$this->primary_key = "id";
	}

	public function get_balance( $coach_id ) {

		$balance = $this->db->get_var( $this->db->prepare( "
        SELECT SUM(cb.amount)
        FROM {$this->table} cb
        WHERE cb.coach_id=%d
        ", $coach_id ) );

		if ( is_null( $balance ) ) {
			return 0;
		}

		return $balance;

	}

	public function recharge_balance( $coach_id, $amount, $res_number ) {
		return $this->db->insert(
			$this->table,
			[
				"coach_id"   => $coach_id,
				"amount"     => $amount,
				"res_number" => $res_number,
				"date"       => current_time( 'mysql' )
			],
			[
				"%d",
				"%d",
				"%s",
				"%s"
			]
		);
	}

	public function get_transactions( $coach_id, $limit ) {
		return $this->query( $this->db->prepare( "
        SELECT cb.amount,cb.res_number,cb.date
        FROM {$this->table} cb
        WHERE cb.coach_id=%d
        ORDER BY cb.date DESC 
        LIMIT %d
        ", $coach_id, $limit ), true );
	}

}