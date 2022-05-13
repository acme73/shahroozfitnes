<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class CoachRateRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'coach_rate';
		$this->primary_key = "id";
	}

	public function is_exist( $athlete_id, $coach_id ) {

		return $this->db->query( $this->db->prepare( "
        SELECT rate.id
        FROM {$this->table} rate
        WHERE rate.athlete_id=%d AND rate.coach_id=%d
        ", [ $athlete_id, $coach_id ] ) );

	}

	public function insert_rate( $athlete_id, $coach_id, $rate ) {

		if ( $this->is_exist( $athlete_id, $coach_id ) ) {
			return $this->db->update(
				$this->table,
				[
					"rate" => $rate
				],
				[
					"athlete_id" => $athlete_id,
					"coach_id"   => $coach_id
				],
				[
					"%d"
				],
				[
					"%d",
					"%d"
				]
			);
		}

		return $this->db->insert(
			$this->table,
			[
				"athlete_id" => $athlete_id,
				"coach_id"   => $coach_id,
				"rate"       => $rate
			],
			[
				"%d",
				"%d",
				"%d"
			]
		);

	}

	public function sum_rate( $coach_id ) {

		$sum_rate = $this->db->get_var( $this->db->prepare( "
        SELECT SUM(rate.rate)
        FROM {$this->table} rate
        WHERE rate.coach_id=%d
        ", $coach_id ) );

		$count = $this->db->query( $this->db->prepare( "
        SELECT rate.id
        FROM {$this->table} rate
        WHERE rate.coach_id=%d
        ", $coach_id ) );

		if ( empty( $sum_rate ) || empty( $count ) ) {
			return 0;
		}

		$result = intval( $sum_rate ) / intval( $count );

		return number_format( $result, 1 );

	}

	public function count_user_rating( $coach_id ) {

		return $this->db->query( $this->db->prepare( "
        SELECT rate.id
        FROM {$this->table} rate
        WHERE rate.coach_id=%d
        ", $coach_id ) );

	}

}