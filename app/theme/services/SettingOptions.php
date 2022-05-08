<?php

namespace App\theme\services;

defined( 'ABSPATH' ) || die( "No Access" );

class SettingOptions {

	const SETTINGS_OPTION_NAME = '_settings_option';

	public static function get_settings() {
		return get_option( self::SETTINGS_OPTION_NAME );
	}

	public static function update_setting( $setting, $data ) {

		$settings = empty( self::get_settings() ) ? [] : self::get_settings();

		$settings[ $setting ] = $data;

		update_option( self::SETTINGS_OPTION_NAME, $settings );

	}

}