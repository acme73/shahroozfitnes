<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class AthleteUserMeta {

	const ATHLETE_PROPERTY_META_KEY = '_athlete_property';

	public static function get_athlete_property( $user_id ) {


		$athlete_property = get_user_meta( $user_id, self::ATHLETE_PROPERTY_META_KEY );

		if ( ! $athlete_property ) {
			return null;
		}

		return $athlete_property[0];

	}

	public static function update_athlete_property( $user_id, $user_meta ) {

		$athlete_property = self::get_athlete_property( $user_id );

		foreach ( $user_meta as $meta_key => $meta_value ) {
			$athlete_property[ $meta_key ] = $meta_value;
		}

		update_user_meta( $user_id, self::ATHLETE_PROPERTY_META_KEY, $athlete_property );
	}

}