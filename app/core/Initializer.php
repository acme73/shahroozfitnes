<?php

namespace App\core;

use App\theme\repository\UsersRepository;
use App\theme\services\PaymentsOption;
use App\theme\services\SettingOptions;

defined( 'ABSPATH' ) || die( "No Access" );

class Initializer {


	public function __construct() {

		add_action( 'after_switch_theme', [ $this, 'activate_theme' ] );
		add_action( 'switch_theme', [ $this, 'deactivate_theme' ] );

		add_action( 'init', [ $this, 'initialize_setting' ] );
		add_action( 'init', [ $this, 'initialize_payment' ] );


		add_action( 'admin_menu', [ $this, 'linked_admin' ] );


		add_action( 'init', [ $this, 'rewrite_rules' ] );


		add_action( 'init', [ $this, 'coach_post_type_init' ] );
		add_action( 'init', [ $this, 'sports_branches_taxonomy_init' ], 0 );


		add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_asset_front' ] );
		add_action( 'admin_head', [ $this, 'register_asset_admin' ] );

	}


	public function activate_theme() {

		/**add user roles in WordPress**/
		$this->user_roles();

		//add rewrite rule
		$this->rewrite_rules();

		/**add coach in postType WordPress**/
		$this->coach_post_type_init();

		flush_rewrite_rules();

	}

	public function deactivate_theme() {
		flush_rewrite_rules( false );
	}

	public function setup_theme() {

		//support theme
		$this->theme_support();

		//hide admin bar
		add_filter( "show_admin_bar", "__return_false" );

	}

	public function theme_support() {

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		add_image_size( "blog-thumbnail", 417, 235 );

	}


	public function rewrite_rules() {
		add_rewrite_rule(
			'^checkout$',
			'index.php?pagename=f1_checkout',
			'top'
		);

		add_rewrite_rule(
			'^verify$',
			'index.php?pagename=f1_verify',
			'top'
		);

		add_rewrite_rule(
			'^filter_coach$',
			'index.php?pagename=f1_filter_coach',
			'top'
		);
	}


	public function initialize_setting() {

		//init percent site
		if ( is_null( SettingOptions::get_settings()['percent_site'] ) ) {
			SettingOptions::update_setting( "percent_site", 10 );
		}

	}

	public function initialize_payment() {

		//init irankish
		if ( empty( PaymentsOption::get_payments()['irankish'] ) ) {
			PaymentsOption::update_payment( 'irankish', [
				'name_payment' => '?????????? ?????????? ??????',
				'icon_payment' => F1_THEME_ASSET_URL . "images/payment/irankish_logo.png",
				'active'       => 1,
				'api'          => ''
			] );
		}

	}

	public function linked_admin() {
		add_menu_page(
			'?????? ????????????',
			'?????? ????????????',
			'read',
			home_url( "account/coach/manage" ),
			'',
			'dashicons-universal-access' );
	}


	public function user_roles() {

		/**create coach role**/
		add_role(
			'f1_coach',
			"????????",
			[

			]
		);

		/**create athlete role**/
		add_role(
			'f1_athlete',
			"??????????????",
			[

			]
		);

	}


	public function coach_post_type_init() {

		$labels = array(
			'name'                  => _x( '???????? ????', 'Post type general name', 'textdomain' ),
			'singular_name'         => _x( '????????', 'Post type singular name', 'textdomain' ),
			'menu_name'             => _x( '???????? ????', 'Admin Menu text', 'textdomain' ),
			'name_admin_bar'        => _x( '????????', 'Add New on Toolbar', 'textdomain' ),
			'add_new'               => __( '?????????? ???????? ????????', 'textdomain' ),
			'add_new_item'          => __( '?????????? ???????? ????????', 'textdomain' ),
			'new_item'              => __( '???????? ????????', 'textdomain' ),
			'edit_item'             => __( '???????????? ????????', 'textdomain' ),
			'view_item'             => __( '???????????? ????????', 'textdomain' ),
			'all_items'             => __( '???????? ???????? ????', 'textdomain' ),
			'search_items'          => __( '???????????? ???????? ????', 'textdomain' ),
			'parent_item_colon'     => __( '???????? ????????', 'textdomain' ),
			'not_found'             => __( '???????? ???? ?????? ?????????? ???????? ??????!', 'textdomain' ),
			'not_found_in_trash'    => __( '???????? ???? ?????? ?????????? ???? ???????? ?????????????? ???????? ??????!', 'textdomain' ),
			'featured_image'        => _x( '?????????? ???????? ????????', 'textdomain' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the ???Set featured image??? phrase for this post type. Added in 4.3', 'textdomain' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the ???Remove featured image??? phrase for this post type. Added in 4.3', 'textdomain' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the ???Use as featured image??? phrase for this post type. Added in 4.3', 'textdomain' ),
			'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default ???Post Archives???. Added in 4.4', 'textdomain' ),
			'insert_into_item'      => _x( 'Insert into book', 'Overrides the ???Insert into post???/???Insert into page??? phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the ???Uploaded to this post???/???Uploaded to this page??? phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
			'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default ???Filter posts list???/???Filter pages list???. Added in 4.4', 'textdomain' ),
			'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default ???Posts list navigation???/???Pages list navigation???. Added in 4.4', 'textdomain' ),
			'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default ???Posts list???/???Pages list???. Added in 4.4', 'textdomain' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'coach' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-businessman'
		);

		register_post_type( 'coach', $args );
	}

	public function sports_branches_taxonomy_init() {

		$labels = array(
			'name'              => _x( '???????? ?????? ??????????', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( '???????? ??????????', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( '???????????? ???????? ?????? ??????????', 'textdomain' ),
			'all_items'         => __( '???????? ???????? ?????? ??????????', 'textdomain' ),
			'parent_item'       => __( '?????? ???????? ??????????', 'textdomain' ),
			'parent_item_colon' => __( '?????? ???????? ??????????:', 'textdomain' ),
			'edit_item'         => __( '???????????? ???????? ??????????', 'textdomain' ),
			'update_item'       => __( '?????????????????? ???????? ??????????', 'textdomain' ),
			'add_new_item'      => __( '???????????? ???????? ?????????? ????????', 'textdomain' ),
			'new_item_name'     => __( '?????? ???????? ?????????? ????????', 'textdomain' ),
			'menu_name'         => __( '???????? ?????? ??????????', 'textdomain' )
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'sports_branches' )
		);

		register_taxonomy( 'sports_branches', array( 'coach' ), $args );

	}


	public function register_asset_front() {

		//add css in Front
		wp_enqueue_style( "f1-main", F1_THEME_ASSET_URL . 'css/main.css', [], F1_THEME_VERSION, 'all' );
		wp_enqueue_script( 'f1-uikit', F1_THEME_ASSET_URL . 'js/uikit.min.js', [], F1_THEME_VERSION, true );
		wp_enqueue_script( 'f1-uikit-icons', F1_THEME_ASSET_URL . 'js/uikit-icons.min.js', [], F1_THEME_VERSION, true );
		wp_enqueue_script( 'f1-front', F1_THEME_ASSET_URL . 'js/front.js', [ 'jquery' ], F1_THEME_VERSION, true );
		wp_localize_script( 'f1-front', 'f1_front_data', [
			"ajax_url" => admin_url( "admin-ajax.php" ),
			"nonce"    => wp_create_nonce( "f1_front_ajax_nonce" )
		] );

	}

	public function register_asset_admin() {

		$users = new UsersRepository();

		wp_enqueue_script( 'f1-coach', F1_THEME_ASSET_URL . 'admin/js/coach-post-type.js', [ 'jquery' ], F1_THEME_VERSION, true );
		wp_localize_script( 'f1-coach', 'f1_coach_data', [
			"users_autocomplete" => $users->get_all_user_by_role( "coach" )
		] );
		wp_enqueue_style( "f1-admin", F1_THEME_ASSET_URL . 'admin/css/coach-post-type.css', [], F1_THEME_VERSION, 'all' );

	}

}