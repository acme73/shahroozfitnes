<?php

namespace App\theme\services;

use App\utils\View;
use WP_Query;

defined( 'ABSPATH' ) || die( "No Access" );

class CoachPropertyMetaBox {

	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'register_coach_property_meta_box' ] );
		add_action( 'post_edit_form_tag', [ $this, 'add_enctype_in_form_tag' ] );
		add_action( 'save_post', [ $this, 'save_coach_property_meta_box' ] );
	}

	public function add_enctype_in_form_tag() {

		global $post;

		if ( ! $post ) {
			return;
		}

		$post_type = get_post_type( $post->ID );

		if ( 'coach' != $post_type ) {
			return;
		}

		echo 'enctype="multipart/form-data" encoding="multipart/form-data"';

	}

	public function register_coach_property_meta_box() {
		add_meta_box(
			'coach_property_meta_box',
			'مشخصات مربی',
			[ $this, 'callback_coach_property_meta_box' ],
			'coach',
			'normal',
			'high'
		);
	}

	public function callback_coach_property_meta_box( $post ) {

		View::render( 'app.theme.views.admin.metaboxes.coach-property', [
			'coach_property' => CoachPostMeta::get_coach_property( $post->ID ),
			'coach_id'       => CoachPostMeta::get_coach_id( $post->ID )
		] );

	}

	private function object_data( $val1, $val2, $new_obj ): array {

		$result = [];
		$i      = 0;

		foreach ( $val1 as $value1 ) {
			foreach ( $val2 as $index2 => $value2 ) {
				if ( $index2 === $i ) {
					$result[] = [ $new_obj['name1'] => $value1, $new_obj['name2'] => $value2 ];
					$i        += 1;
					break;
				}
			}
		}

		return $result;

	}

	public function save_coach_property_meta_box( $post_id ): bool {

		global $post;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		if ( empty( $post->ID ) || get_post_type( $post->ID ) != 'coach' ) {
			return false;
		}

		if ( ! current_user_can( 'edit_page', $post->ID ) ) {
			return false;
		}

		if ( 'trash' == get_post_status( $post_id ) ) {
			return false;
		}

		if ( ! is_admin() ) {
			return false;
		}

		$query = new WP_Query( [
			'post_type'    => 'coach',
			'meta_key'     => '_coach_id',
			'meta_value'   => $_POST['coach_id'],
			'meta_compare' => '='
		] );

		if ( $query->have_posts() ) {
			if ( intval( $post_id ) !== intval( $query->post->ID ) ) {
				goto ex;
			}
		}

		//Coach Information
		$coach_information = [];
		if ( isset( $_POST['type_info'] ) && isset( $_POST['desc_info'] ) ) {
			$coach_information = $this->object_data( $_POST['type_info'], $_POST['desc_info'], [ "name1" => "type_info", "name2" => "desc_info" ] );
		}

		//Coach Program Price
		$coach_program_prices = [];
		if ( isset( $_POST['type_service'] ) && isset( $_POST['program_price'] ) ) {
			$coach_program_prices = $this->object_data( $_POST['type_service'], $_POST['program_price'], [ "name1" => "type_service", "name2" => "program_price" ] );
		}

		if ( ! isset( $_POST['is_image'] ) && ! empty( $_POST['coach_id'] ) ) {

			$image_tmp_name = $_FILES['coach_image']['tmp_name'];
			$image_size     = $_FILES['coach_image']['size'];
			$image_error    = $_FILES['coach_image']['error'];
			$image_type     = $_FILES['coach_image']['type'];
			$image_format   = explode( "/", $image_type );
			$image_format   = strtolower( end( $image_format ) );

			if ( $image_error !== 0 ) {
				goto jmp;
			}

			if ( ! in_array( $image_format, [ 'jpg', 'png', 'jpeg' ] ) ) {
				goto jmp;
			}

			if ( $image_size > 1061806 ) {
				goto jmp;
			}

			$image_new_name         = uniqid( "", true ) . "." . ( $image_format === 'jpeg' ? 'jpg' : $image_format );
			$image_destination_path = F1_THEME_UPLOADS_PATH . 'coach' . DIRECTORY_SEPARATOR . $image_new_name;
			$image_destination_url  = F1_THEME_UPLOADS_URL . "coach/" . $image_new_name;

			move_uploaded_file( $image_tmp_name, $image_destination_path );

			CoachUserMeta::update_coach_property( $_POST['coach_id'], [ 'coach_image' => $image_destination_url ] );
			CoachPostMeta::update_coach_property( $post_id, [ 'coach_image' => $image_destination_url ] );

		}

		jmp:

		CoachPostMeta::update_coach_property( $post_id, [
			"coach_gender"         => $_POST['coach_gender'],
			"coach_height"         => $_POST['coach_height'],
			"coach_weight"         => $_POST['coach_weight'],
			"coach_birth"          => $_POST['coach_birth'],
			"coach_explanation"    => $_POST['coach_explanation'],
			"coach_information"    => $coach_information,
			"coach_program_prices" => $coach_program_prices,
		] );

		CoachPostMeta::update_coach_id( $post_id, $_POST['coach_id'] );

		CoachUserMeta::update_coach_property( $_POST['coach_id'], [
			"coach_gender"         => $_POST['coach_gender'],
			"coach_birth"          => $_POST['coach_birth'],
			"coach_height"         => $_POST['coach_height'],
			"coach_weight"         => $_POST['coach_weight'],
			"coach_explanation"    => $_POST['coach_explanation'],
			"coach_branch"         => $_POST['tax_input']['sports_branches'],
			"coach_information"    => $coach_information,
			"coach_program_prices" => $coach_program_prices,
			'coach_status'         => '1',
			'post_id'              => $post_id
		] );

		ex:

		return true;

	}

}