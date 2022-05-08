<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;
use WP_User_Query;

defined( 'ABSPATH' ) || die( "No Access" );

class UsersRepository extends BaseRepository {

	public function __construct() {
		parent::__construct();
		$this->table       = $this->table_prefix . 'users';
		$this->primary_key = "ID";
	}

	public function get_all_user_by_role( $role ): array {

		$users = [];

		$query = $this->query( "
         SELECT users.ID,users.user_login,users.display_name
         FROM {$this->table} users
         ", true );

		foreach ( $query as $user ) {
			switch ( $role ) {
				case "coach":
					if ( array_intersect( [ 'f1_coach' ], get_user_by( "ID", $user->ID )->roles ) ) {
						$users[] = [
							"id"     => $user->ID,
							"name"   => $user->display_name,
							"mobile" => $user->user_login
						];
					}
					break;
				case "athlete":
					if ( array_intersect( [ 'f1_athlete' ], get_user_by( "ID", $user->ID )->roles ) ) {
						$users[] = [
							"id"     => $user->ID,
							"name"   => $user->display_name,
							"mobile" => $user->user_login
						];
					}
					break;
				case "any":
					if ( array_intersect( [ 'f1_coach', 'f1_athlete' ], get_user_by( "ID", $user->ID )->roles ) ) {
						$users[] = [
							"id"     => $user->ID,
							"name"   => $user->display_name,
							"mobile" => $user->user_login
						];
					}
					break;
			}
		}

		return $users;

	}

	public function get_all_coach_for_manage( $offset = null, $per_page = null, $coach_status = null, $get_count = false ) {

		$coaches = [];

		$query = new WP_User_Query( [
			'role'         => 'f1_coach',
			'meta_key'     => is_null( $coach_status ) ? null : '_coach_property',
			'meta_value'   => is_null( $coach_status ) ? null : serialize( 'coach_status' ) . serialize( strval( $coach_status ) ),
			'meta_compare' => is_null( $coach_status ) ? null : 'LIKE',
			'number'       => $per_page,
			'offset'       => $offset
		] );

		if ( $get_count ) {
			return $query->get_total();
		}

		if ( $query->get_results() ) {
			foreach ( $query->get_results() as $user ) {
				$coaches[] = (object) [ 'ID' => strval( $user->ID ) ];
			}
		}

		return $coaches;

	}

}