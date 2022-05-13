<?php

namespace App\theme\controllers;

use App\theme\repository\TransactionRepository;
use App\theme\services\CoachPostMeta;
use App\utils\View;
use WP_Query;

defined( 'ABSPATH' ) || die( "No Access" );

class DefaultController {

	public function checkout() {

		if ( isset( $_POST['order_payment_submit'] ) ) {

			if ( ! wp_verify_nonce( $_POST['_wpnonce'] ) ) {
				wp_safe_redirect( home_url() );
				exit;
			}

			$query = new WP_Query( [
				'page_id'      => $_POST['post_id'],
				'post_type'    => 'coach',
				'meta_key'     => '_coach_property',
				'meta_value'   => serialize( strval( $_POST['type_service'] ) ),
				'meta_compare' => 'LIKE'
			] );

			if ( ! $query->have_posts() || ! current_user_can( 'f1_athlete' ) ) {
				wp_safe_redirect( home_url() );
				exit;
			}

			$amount       = 0;
			$factorNumber = uniqid();

			foreach ( CoachPostMeta::get_coach_property( $_POST['post_id'] )["coach_program_prices"] as $program_prices ) {
				if ( $program_prices['type_service'] === $_POST['type_service'] ) {
					$amount = $program_prices['program_price'];
				}
			}

			if ( $_POST['type_payment'] === 'pay' ) {

				$data    = [
					'amount'       => intval( $amount ) * 10,
					'mobile'       => wp_get_current_user()->user_login,
					'description'  => "درخواست برنامه از " . get_post( $_POST['post_id'] )->post_title,
					'factorNumber' => $factorNumber
				];
				$payment = new Pay();
				$payment = $payment->send_Request( $data );

				if ( $payment === - 1 ) {
					print_r( 'Error' );
					exit;
				}

				if ( ! $payment['status'] ) {
					print_r( 'Error: ' . $payment['errorCode'] );
				}

				if ( $payment['status'] ) {

					$new_transaction = new TransactionRepository();
					$new_transaction = $new_transaction->new_transaction(
						intval( get_current_user_id() ),
						intval( CoachPostMeta::get_coach_id( $_POST['post_id'] ) ),
						$_POST['type_service'],
						intval( $amount ),
						$factorNumber
					);

					if ( $new_transaction ) {
						header( 'Location: ' . $payment['url'] );
					}

				}

				exit;
			}

			wp_safe_redirect( home_url() );

			exit;

		}

		$query = new WP_Query( [
			'page_id'      => $_POST['post_id'],
			'post_type'    => 'coach',
			'meta_key'     => '_coach_property',
			'meta_value'   => serialize( strval( $_POST['type_service'] ) ),
			'meta_compare' => 'LIKE'
		] );

		if ( ! $query->have_posts() || ! current_user_can( 'f1_athlete' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		View::render( "app.theme.views.checkout-page.checkout", [ "query" => $query ] );

	}

	public function notfound() {
		var_dump( "notFound" );
	}

}