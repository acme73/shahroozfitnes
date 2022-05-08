<?php

namespace App\theme\repository\contract;

defined( 'ABSPATH' ) || die( "No Access" );

class BaseRepository {

	protected string $table;
	protected $db;
	protected string $table_prefix;
	protected string $primary_key;

	protected function __construct() {
		global $wpdb;
		$this->db           = $wpdb;
		$this->table_prefix = $this->db->prefix;
	}

	private function checkColumns( $columns ): string {
		return is_array( $columns ) && count( $columns ) > 0 ? implode( ',', $columns ) : '*';
	}

	public function find( $id, $columns = null ) {

		//Check Is Columns??
		$columns_property = $this->checkColumns( $columns );

		return $this->db->get_row( $this->db->prepare(
			"SELECT {$columns_property}
                  FROM {$this->table}
                  WHERE {$this->primary_key}= %d", $id ) );

	}

	public function delete_by_id( $id ) {
		return $this->db->delete( $this->table, [ $this->primary_key => $id ], "%d" );
	}

	public function query( $query, $is_select = false ) {

		return $is_select ? $this->db->get_results( $query ) : $this->db->query( $query );

	}

}