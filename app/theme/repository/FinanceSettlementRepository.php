<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class FinanceSettlementRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'finance_settlement';
		$this->primary_key = "id";
	}

	public function get_finance_settlement( $coach_id ) {
		$finance_settlement = $this->db->get_var( $this->db->prepare( "
        SELECT SUM(fs.amount)
        FROM {$this->table} fs
        WHERE fs.coach_id=%d
        ", $coach_id ) );

		if ( is_null( $finance_settlement ) ) {
			return 0;
		}

		return $finance_settlement;
	}

	public function new_finance_settlement( $coach_id, $coach_payment, $document_number, $amount ) {
		return $this->db->insert(
			$this->table,
			[
				"coach_id"        => $coach_id,
				"coach_payment"   => $coach_payment,
				"document_number" => $document_number,
				"amount"          => $amount,
				"date"            => current_time( 'mysql' )
			],
			[
				"%d",
				"%s",
				"%s",
				"%d",
				"%s"
			]
		);
	}

	public function get_finance_settlement_history( $coach_id, $limit ) {
		return $this->query( $this->db->prepare( "
        SELECT fs.amount,fs.coach_payment,fs.date
        FROM {$this->table} fs
        WHERE fs.coach_id=%d
        ORDER BY fs.date DESC 
        LIMIT %d
        ", $coach_id, $limit ), true );
	}

	public function get_all_finance_settlement_history( $offset, $per_page, $get_count = false ) {
		if ( $get_count ) {
			return $this->query( "
            SELECT fs.id
            FROM {$this->table} fs
            ", false );
		}

		return $this->query( $this->db->prepare( "
        SELECT *
        FROM {$this->table} fs
        ORDER BY fs.date DESC 
        LIMIT %d,%d
        ", $offset, $per_page ), true );
	}

}