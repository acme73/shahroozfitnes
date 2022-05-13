<?php

namespace App\core;

use App\utils\View;
use WP_Query;

defined( 'ABSPATH' ) || die( "No Access" );

class Rewrite {

	function __construct() {
		add_action( 'parse_request', [ $this, 'parse_request' ] );
	}

	function parse_request( $query ) {


		if ( isset( $query->query_vars['pagename'] ) && $query->query_vars['pagename'] === 'f1_checkout' ) {
			$this->init_checkout_page();
		}

		if ( isset( $query->query_vars['pagename'] ) && $query->query_vars['pagename'] === 'f1_verify' ) {
			$this->init_verify_page();
		}

		if ( isset( $query->query_vars['pagename'] ) && $query->query_vars['pagename'] === 'f1_filter_coach' ) {
			$this->init_filter_coach();
		}

	}

	private function init_checkout_page() {

		//Check User Logged
		if ( ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		//Render View Checkout
		//ViewRender::view_render( 'front.template-parts.checkout' );
		exit;

	}

	private function init_verify_page() {

		//Check User Logged
		if ( ! is_user_logged_in() ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		//Render View Verify
		ViewRender::view_render( 'front.template-parts.verify' );
		exit;

	}

	private function init_filter_coach() {


		$gender          = null;
		$sports_branches = null;
		$meta_query      = [];
		$tax_query       = [];

		if ( isset( $_GET["coach_gender"] ) && ! empty( $_GET["coach_gender"] ) ) {
			$gender = $_GET["coach_gender"];
		}

		if ( isset( $_GET["coach_sport_branch"] ) && ! empty( $_GET["coach_sport_branch"] ) ) {
			$sports_branches = $_GET["coach_sport_branch"];
		}


		//meta query
		if ( ! is_null( $gender ) ) {
			$meta_query[] = [
				'key'     => '_coach_property',
				'value'   => serialize( strval( $gender ) ),
				'compare' => 'LIKE',
			];
		}

		//tax query
		if ( ! is_null( $sports_branches ) ) {
			$tax_query = [
				[
					'taxonomy' => 'sports_branches',
					'field'    => 'term_id',
					'terms'    => $sports_branches,
				]
			];
		}

		//paged
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		//query
		$coach_query = new WP_Query( [
			'post_type'  => 'coach',
			'paged'      => $paged,
			'tax_query'  => $tax_query,
			'meta_query' => $meta_query
		] );

		View::render( 'app.theme.views.coach-filter.filter', [
			"coach_query"     => $coach_query,
			"gender"          => $gender,
			"sports_branches" => $sports_branches
		] );

		exit;

	}

}