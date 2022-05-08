<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class CoachPostMeta {

	const COACH_PROPERTY_META_KEY = '_coach_property';
	const COACH_ID_META_KEY = '_coach_id';
	const COACH_RATE_META_KEY = '_coach_rate';

	public static function get_coach_property( $post_id ) {

		$coach_property = get_post_meta( $post_id, self::COACH_PROPERTY_META_KEY );

		if ( ! $coach_property ) {
			return null;
		}

		return $coach_property[0];

	}

	public static function update_coach_property( $post_id, $post_meta ) {

		$coach_property = self::get_coach_property( $post_id );

		foreach ( $post_meta as $meta_key => $meta_value ) {
			$coach_property[ $meta_key ] = $meta_value;
		}

		update_post_meta( $post_id, self::COACH_PROPERTY_META_KEY, $coach_property );

	}

	public static function update_coach_id( $post_id, $coach_id ) {
		update_post_meta( $post_id, self::COACH_ID_META_KEY, $coach_id );
	}

	public static function get_coach_id( $post_id ) {

		if ( ! $post_id ) {
			return null;
		}

		return get_post_meta( $post_id, self::COACH_ID_META_KEY, true );

	}

	public static function update_coach_rate( $post_id, $coach_rate ) {
		update_post_meta( $post_id, self::COACH_RATE_META_KEY, $coach_rate );
	}

	public static function get_coach_rate( $post_id ) {
		if ( ! $post_id ) {
			return null;
		}

		return get_post_meta( $post_id, self::COACH_RATE_META_KEY, true );
	}

}