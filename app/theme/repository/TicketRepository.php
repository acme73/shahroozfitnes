<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class TicketRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'ticket';
		$this->primary_key = "ticket_id";
	}

	public function new_ticket( $user_id, $subject, $department, $priority, $messages, $status ) {
		return $this->db->insert(
			$this->table,
			[
				"user_id"     => $user_id,
				"subject"     => $subject,
				"department"  => $department,
				"priority"    => $priority,
				"messages"    => $messages,
				"status"      => $status,
				"last_update" => current_time( 'mysql' )
			],
			[
				"%d",
				"%s",
				"%d",
				"%d",
				"%s",
				"%d",
				"%s"
			] );
	}

	public function get_tickets( $offset, $per_page, $user_id = null ) {

		if ( is_null( $user_id ) ) {
			return $this->query( $this->db->prepare( "
            SELECT *
            FROM {$this->table} ticket
            ORDER BY ticket.last_update DESC
            LIMIT %d,%d
            ", [ $offset, $per_page ] ), true );
		}

		return $this->query( $this->db->prepare( "
        SELECT *
        FROM {$this->table} ticket
        WHERE ticket.user_id=%d
        ORDER BY ticket.last_update DESC
        LIMIT %d,%d
         ", [ $user_id, $offset, $per_page ] ), true );

	}

	public function get_tickets_count( $user_id = null ) {
		if ( is_null( $user_id ) ) {
			return $this->db->query( "
            SELECT ticket.ticket_id
            FROM {$this->table} ticket
            " );
		}

		return $this->db->query( $this->db->prepare( "
         SELECT ticket.ticket_id
         FROM {$this->table} ticket
         WHERE ticket.user_id=%d
         ", $user_id ) );
	}

	public function get_ticket( $ticket_id ) {
		return $this->db->get_row( $this->db->prepare( "
        SELECT *
        FROM {$this->table} ticket
        WHERE ticket.ticket_id= %d
        ", $ticket_id ) );
	}

	public function replay_ticket( $ticket_id, $replay_message ) {

		$messages = $this->db->get_row( $this->db->prepare( "
        SELECT ticket.messages
        FROM {$this->table} ticket
        WHERE ticket.ticket_id= %d
        ", $ticket_id ) );

		if ( is_null( $messages ) ) {
			return false;
		}

		$messages = unserialize( $messages->messages );

		$messages[] = [ "user" => get_current_user_id(), "message" => $replay_message, "date" => current_time( 'mysql' ) ];

		return $this->db->update(
			$this->table,
			[
				"messages"    => serialize( $messages ),
				"last_update" => current_time( 'mysql' ),
				"status"      => current_user_can( 'administrator' ) ? 3 : 2
			],
			[ "ticket_id" => $ticket_id ],
			[ "%s", "%s", "%d" ],
			[ "%d" ]
		);

	}

	public function update_ticket( $ticket_id ) {
		return $this->db->update(
			$this->table,
			[
				"status" => 0
			],
			[ "ticket_id" => $ticket_id ],
			[ "%d" ],
			[ "%d" ]
		);
	}

	public function unclosed_ticket() {
		return $this->query( $this->db->prepare( "
        SELECT ticket.ticket_id
        FROM {$this->table} ticket
        WHERE ticket.status != %d
        ", 0 ), false );
	}

}