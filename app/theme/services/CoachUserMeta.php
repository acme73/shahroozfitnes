<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class CoachUserMeta {

	const COACH_PROPERTY_META_KEY = '_coach_property';

	public static function get_coach_property( $user_id ) {

		$coach_property = get_user_meta( $user_id, self::COACH_PROPERTY_META_KEY );

		if ( ! $coach_property ) {
			return null;
		}

		return $coach_property[0];
	}

	public static function update_coach_property( $user_id, $user_meta ) {

		$coach_property = self::get_coach_property( $user_id );

		foreach ( $user_meta as $meta_key => $meta_value ) {
			$coach_property[ $meta_key ] = $meta_value;
		}

		update_user_meta( $user_id, self::COACH_PROPERTY_META_KEY, $coach_property );
	}

}