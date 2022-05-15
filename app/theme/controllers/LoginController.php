<?php

namespace App\theme\controllers;


use App\utils\View;

defined( 'ABSPATH' ) || die( "No Access" );

class LoginController {

	public function __construct() {

		//register assets login page
		add_action( "wp_head", [ $this, "register_assets" ] );

	}

	public function index() {

		//check user logged
		if ( is_user_logged_in() ) {

			if ( current_user_can( "administrator" ) ) {
				wp_safe_redirect( home_url( 'account/coach/manage' ) );
			}

			if ( current_user_can( "f1_coach" ) ) {
				wp_safe_redirect( home_url( 'account/order/athlete' ) );
			}

			if ( current_user_can( "f1_athlete" ) ) {
				wp_safe_redirect( home_url( 'account/order/coach' ) );
			}

			exit;
		}

		View::render( "app.theme.views.login-page.login-register" );

	}

	public function register_assets() {
		wp_enqueue_script( 'f1-recaptcha-google', "https://www.google.com/recaptcha/api.js?render=6Lcw380cAAAAAMZQueju19ZVuqGLgtUHxSiw-ujO", null, null, true );
		wp_enqueue_script( 'f1-login', F1_THEME_ASSET_URL . 'js/login.js', [ 'jquery' ], F1_THEME_VERSION, true );
		wp_localize_script( 'f1-login', 'f1_login_data', [
			"ajax_url" => admin_url( "admin-ajax.php" ),
			"nonce"    => wp_create_nonce( "f1_login_ajax_nonce" )
		] );
	}

}