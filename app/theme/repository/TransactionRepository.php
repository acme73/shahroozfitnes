<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class TransactionRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'transactions';
		$this->primary_key = "id";
	}

	public function new_transaction( $athlete_id, $coach_id, $type_program, $price_program, $res_number ) {
		return $this->db->insert(
			$this->table,
			[
				"athlete_id"    => $athlete_id,
				"coach_id"      => $coach_id,
				"type_program"  => $type_program,
				"price_program" => $price_program,
				"res_number"    => $res_number,
				"date"          => current_time( 'mysql' )
			],
			[
				"%d",
				"%d",
				"%s",
				"%d",
				"%s",
				"%s"
			] );
	}

	public function verify_transaction( $res_number, $ref_number ) {

		$transaction = $this->db->get_row( $this->db->prepare( "
        SELECT *
        FROM {$this->table} t
        WHERE t.res_number=%s
        ", $res_number ) );

		if ( ! is_null( $transaction->ref_number ) ) {
			return false;
		}

		$this->db->update(
			$this->table,
			[
				'ref_number' => $ref_number
			],
			[
				'res_number' => $res_number
			],
			[
				"%s"
			],
			[
				"%s"
			]
		);

		return $transaction;
	}

	public function get_transactions_count( $athlete_id = null ) {

		if ( is_null( $athlete_id ) ) {
			return $this->db->query( "
            SELECT t.id
            FROM {$this->table} t
            " );
		}

		return $this->db->query( $this->db->prepare( "
            SELECT t.id
            FROM {$this->table} t
            WHERE t.athlete_id=%d
            ", $athlete_id ) );

	}

	public function get_transactions( $offset, $per_page, $athlete_id = null ) {

		if ( is_null( $athlete_id ) ) {
			return $this->query( $this->db->prepare( "
            SELECT *
            FROM {$this->table} t
            WHERE t.ref_number IS NOT NULL
            ORDER BY t.date DESC 
            LIMIT %d,%d
            ", [ $offset, $per_page ] ), true );
		}

		return $this->query( $this->db->prepare( "
        SELECT t.coach_id,t.type_program,t.price_program,t.res_number,t.date
        FROM {$this->table} t
        WHERE t.athlete_id=%d AND t.ref_number IS NOT NULL
        ORDER BY t.date DESC
        LIMIT %d,%d
        ", [ $athlete_id, $offset, $per_page ] ), true );

	}

}