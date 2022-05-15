<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined( 'ABSPATH' ) || die( "No Access" );

class ChatRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'chats';
		$this->primary_key = "id";
	}

	public function get_chat_history( $coach_id, $athlete_id, $type_program, $offset, $per_page ): array {

		$chats = [];

		$query = $this->query( $this->db->prepare( "
        SELECT chat.message,chat.date
        FROM {$this->table} chat
        WHERE chat.coach_id=%d AND chat.athlete_id=%d AND chat.type_program=%s
        ORDER BY chat.date DESC 
        LIMIT %d,%d
        ", $coach_id, $athlete_id, $type_program, $offset, $per_page ), true );

		foreach ( $query as $chat ) {
			$user_id = unserialize( $chat->message )["user_id"];
			$message = unserialize( $chat->message )["message"];
			$chats[] = (object) [ "user_id" => $user_id, "message" => $message, "date" => $chat->date ];
		}

		return array_reverse( $chats );

	}

	public function insert_chat_message( $coach_id, $athlete_id, $type_program, $user_id, $message ) {

		return $this->db->insert(
			$this->table,
			[
				"coach_id"     => $coach_id,
				"athlete_id"   => $athlete_id,
				"type_program" => $type_program,
				"message"      => serialize(
					[
						"user_id" => $user_id,
						"message" => $message
					]
				),
				"date"         => current_time( "mysql" )
			],
			[
				"%d",
				"%d",
				"%s",
				"%s",
				"%s"
			]
		);

	}

}