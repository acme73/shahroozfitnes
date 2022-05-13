<?php

namespace App\theme\services;

use App\theme\repository\CoachBalanceRepository;
use App\theme\repository\FinanceSettlementRepository;
use App\theme\repository\OrderRepository;
use App\theme\repository\OTP;
use App\theme\repository\TicketRepository;
use WP_Query;

defined( 'ABSPATH' ) || die( "No Access" );

class Ajax {

	private OTP $otp;
	private TicketRepository $ticket;
	private $athlete_body;
	private $chats;
	private OrderRepository $orders;
	private $coach_rate;

	public function __construct() {

		$this->otp    = new OTP();
		$this->ticket = new TicketRepository();
		//$this->athlete_body = new AthleteBody();
		//$this->chats = new ChatRepository();
		$this->orders = new OrderRepository();
		//$this->coach_rate = new CoachRateRepository();

		add_action( 'wp_ajax_nopriv_f1-login', [ $this, 'ajax_login' ] );

		add_action( 'wp_ajax_nopriv_f1-account', [ $this, 'ajax_account' ] );
		add_action( 'wp_ajax_f1-account', [ $this, 'ajax_account' ] );

		add_action('wp_ajax_nopriv_f1-shopping', [$this, 'ajax_shopping']);
		add_action('wp_ajax_f1-shopping', [$this, 'ajax_shopping']);

	}

	private function response( $status, $message = null, $data = null ) {
		wp_send_json( [ 'status' => $status, 'message' => $message, 'data' => $data ] );
	}

	private function captcha( $token, $action ): bool {
		$url_verify = "https://www.google.com/recaptcha/api/siteverify";
		$secret_key = "6LdXKrkcAAAAABandGKWYDjd66J8Mz2ceCsPJFzI";
		$response   = file_get_contents( $url_verify . "?secret=" . $secret_key . "&response=" . $token );
		$response   = json_decode( $response );

		if (
			! $response->success
			|| $response->score < 0.5
			|| $response->hostname !== $_SERVER['SERVER_NAME']
			|| $response->action !== $action
		) {
			return false;
		}

		return true;
	}

	private function object_data( $val1, $val2, $new_obj ): array {
		$result = [];
		$i      = 0;

		foreach ( $val1 as $value1 ) {
			foreach ( $val2 as $index2 => $value2 ) {
				if ( $index2 === $i ) {
					array_push( $result, [ $new_obj['name1'] => $value1, $new_obj['name2'] => $value2 ] );
					$i += 1;
					break;
				}
			}
		}

		return $result;
	}

	public function ajax_login() {

		//check nonce
		check_ajax_referer( "f1_login_ajax_nonce", "nonce" );

		//login or register
		if ( $_POST["command"] === 'login_or_register' ) {

			/*if (!($this->captcha($_POST['token'], $_POST["command"])))
				$this->response("failed", "خطا در تایید کپچا");*/

			if ( empty( $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل نباید خالی باشد" );
			}

			if ( ! preg_match( '/^9\d{9}$/', $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل وارد شده اشتباه است" );
			}

			if ( ! username_exists( "98" . $_POST['user_phone_number'] ) ) {
				$this->response( "register" );
			}

			$this->response( "login" );
		}

		//request OTP in register
		if ( $_POST["command"] === 'request_otp_in_register' ) {

			/*if ( ! ( $this->captcha( $_POST['token'], $_POST["command"] ) ) ) {
				$this->response( "failed", "خطا در تایید کپچا" );
			}*/

			if ( empty( $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل نباید خالی باشد" );
			}

			if ( ! preg_match( '/^9\d{9}$/', $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل وارد شده اشتباه است" );
			}

			if ( username_exists( "98" . $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شما قبلا در سایت ثبت نام کرده اید" );
			}

			$this->otp->set_OTP( "98" . $_POST['user_phone_number'] );

			//SMS Here...

			$this->response( "success", "رمز یکبار مصرف با موفقیت ارسال شد" );

		}

		//request OTP in change password
		if ( $_POST["command"] === 'request_otp_in_change_password' ) {

			/*if ( ! ( $this->captcha( $_POST['token'], $_POST["command"] ) ) ) {
				$this->response( "failed", "خطا در تایید کپچا" );
			}*/

			if ( empty( $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل نباید خالی باشد" );
			}

			if ( ! preg_match( '/^9\d{9}$/', $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل وارد شده اشتباه است" );
			}

			if ( ! username_exists( "98" . $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "کاربری با این مشخصات در سایت وجود ندارد" );
			}

			$this->otp->set_OTP( "98" . $_POST['user_phone_number'] );

			//SMS Here...

			$this->response( "success", "رمز یکبار مصرف با موفقیت ارسال شد" );

		}

		//register
		if ( $_POST["command"] === 'register' ) {

			/*if ( ! ( $this->captcha( $_POST['token'], $_POST["command"] ) ) ) {
				$this->response( "failed", "خطا در تایید کپچا" );
			}*/

			if ( empty( $_POST['user_name'] ) ) {
				$this->response( "failed", "نام خود را وارد کنید" );
			}

			if ( preg_match( '/^[^\x{600}-\x{6FF}]+$/u', str_replace( "\\\\", "", $_POST['user_name'] ) ) ) {
				$this->response( "failed", "نام خود را به فارسی وارد کنید" );
			}

			if ( empty( $_POST['user_family'] ) ) {
				$this->response( "failed", "نام خانوادگی خود را وارد کنید" );
			}

			if ( preg_match( '/^[^\x{600}-\x{6FF}]+$/u', str_replace( "\\\\", "", $_POST['user_family'] ) ) ) {
				$this->response( "failed", "نام خانوادگی خود را به فارسی وارد کنید" );
			}

			if ( empty( $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل خود را وارد کنید" );
			}

			if ( ! preg_match( '/^9\d{9}$/', $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل وارد شده اشتباه است" );
			}

			if ( username_exists( "98" . $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شما قبلا در سایت ثبت نام کرده اید" );
			}

			if ( ! sanitize_email( $_POST['user_email'] ) ) {
				$this->response( "failed", "ایمیل خود را صحیح وارد کنید" );
			}

			if ( ! in_array( $_POST['user_role'], [ "coach", "athlete" ] ) ) {
				$this->response( "failed", "نقش کاربری خود را انتخاب کنید" );
			}

			if ( empty( $_POST['user_password'] ) ) {
				$this->response( "failed", "رمز عبور خود را وارد کنید" );
			}

			if ( empty( $_POST['otp_code'] ) ) {
				$this->response( "failed", "رمز یکبار مصرف را وارد کنید" );
			}

			$verify_otp   = $this->otp->verify_OTP( "98" . $_POST['user_phone_number'] );
			$phone_number = "98" . $_POST['user_phone_number'];
			$otp_code     = sanitize_text_field( $_POST['otp_code'] );

			if ( $verify_otp === - 1 ) {
				$this->response( "failed", "خطا در تایید رمز یکبار مصرف! لطفا درخواست رمز کنید" );
			}

			if ( $verify_otp->mobile_number !== $phone_number || $verify_otp->otp !== $otp_code ) {
				$this->response( "failed", "رمز یکبار مصرف صحیح نیست" );
			}

			$user = array(
				'user_login'           => "98" . $_POST['user_phone_number'],
				'first_name'           => sanitize_text_field( $_POST['user_name'] ),
				'last_name'            => sanitize_text_field( $_POST['user_family'] ),
				'role'                 => 'f1_' . $_POST['user_role'],
				'user_email'           => $_POST['user_email'],
				'user_pass'            => sanitize_text_field( $_POST['user_password'] ),
				'show_admin_bar_front' => "false"
			);

			$user_id = wp_insert_user( $user );

			if ( is_wp_error( $user_id ) ) {
				$this->response( 'failed', "خطای ناشناخته! لطفا به مدیر سایت اطلاع دهید" );
			}

			wp_clear_auth_cookie();
			wp_set_current_user( $user_id );
			wp_set_auth_cookie( $user_id );

			$redirect = "";

			if ( current_user_can( "f1_coach" ) ) {
				CoachUserMeta::update_coach_property( $user_id, [ 'coach_status' => '0' ] );
				$redirect = home_url( "account/order/athlete" );
			}

			if ( current_user_can( "f1_athlete" ) ) {
				$redirect = home_url( "account/order/coach" );
			}

			$this->otp->set_OTP( "98" . $_POST['user_phone_number'] );

			$this->response( "success", "ثبت نام شما با موفقیت انجام شد", $redirect );

		}

		//login
		if ( $_POST["command"] === 'login' ) {

			/*if ( ! ( $this->captcha( $_POST['token'], $_POST["command"] ) ) ) {
				$this->response( "failed", "خطا در تایید کپچا" );
			}*/

			if ( empty( $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل خود را وارد کنید" );
			}

			if ( ! preg_match( '/^9\d{9}$/', $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل وارد شده اشتباه است" );
			}

			if ( ! username_exists( "98" . $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شما ابتدا باید در سایت ثبت نام کنید" );
			}

			if ( empty( $_POST['user_password'] ) ) {
				$this->response( "failed", "رمز عبور خود را وارد کنید" );
			}

			$user          = get_user_by( 'login', "98" . $_POST['user_phone_number'] );
			$user_password = sanitize_text_field( $_POST['user_password'] );

			if ( ! wp_check_password( $user_password, $user->user_pass, $user->ID ) ) {
				$this->response( 'failed', "رمز عبور اشتباه است" );
			}

			if ( is_wp_error( $user ) ) {
				$this->response( 'failed', "خطای ناشناخته! لطفا به مدیر سایت اطلاع دهید" );
			}

			wp_clear_auth_cookie();
			wp_set_current_user( $user->ID );
			wp_set_auth_cookie( $user->ID );

			$redirect = "";

			if ( current_user_can( "f1_coach" ) ) {
				$redirect = home_url( "account/order/athlete" );
			}

			if ( current_user_can( "f1_athlete" ) ) {
				$redirect = home_url( "account/order/coach" );
			}

			$this->response( "success", "شما با موفقیت وارد شدید", $redirect );

		}

		//change password
		if ( $_POST["command"] === 'change_password' ) {

			/*if ( ! ( $this->captcha( $_POST['token'], $_POST["command"] ) ) ) {
				$this->response( "failed", "خطا در تایید کپچا" );
			}*/

			if ( empty( $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل خود را وارد کنید" );
			}

			if ( ! preg_match( '/^9\d{9}$/', $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "شماره موبایل وارد شده اشتباه است" );
			}

			if ( ! username_exists( "98" . $_POST['user_phone_number'] ) ) {
				$this->response( "failed", "کاربری با این مشخصات در سایت وجود ندارد" );
			}

			if ( empty( $_POST['user_new_password'] ) ) {
				$this->response( "failed", "رمز عبور جدید خود را وارد کنید" );
			}

			if ( empty( $_POST['otp_code'] ) ) {
				$this->response( "failed", "رمز یکبار مصرف را وارد کنید" );
			}

			$verify_otp   = $this->otp->verify_OTP( "98" . $_POST['user_phone_number'] );
			$phone_number = "98" . $_POST['user_phone_number'];
			$otp_code     = sanitize_text_field( $_POST['otp_code'] );

			if ( $verify_otp === - 1 ) {
				$this->response( "failed", "خطا در تایید رمز یکبار مصرف! لطفا درخواست رمز کنید" );
			}

			if ( $verify_otp->mobile_number !== $phone_number || $verify_otp->otp !== $otp_code ) {
				$this->response( "failed", "رمز یکبار مصرف صحیح نیست" );
			}

			$user = array(
				'ID'        => get_user_by( 'login', $phone_number )->ID,
				'user_pass' => sanitize_text_field( $_POST['user_new_password'] )
			);

			$user_id = wp_update_user( $user );

			if ( is_wp_error( $user_id ) ) {
				$this->response( 'failed', "خطای ناشناخته! لطفا به مدیر سایت اطلاع دهید" );
			}

			$this->otp->set_OTP( "98" . $_POST['user_phone_number'] );

			$this->response( "success", "رمز عبور با موفقیت تغییر کرد" );

		}

	}

	public function ajax_account() {

		//send new ticket
		if ( $_POST["command"] === 'new_ticket' ) {

			check_ajax_referer( "f1_account_public_ajax_nonce", "nonce" );

			if ( ! array_intersect( [ 'f1_coach', 'f1_athlete' ], wp_get_current_user()->roles ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! in_array( $_POST['department'], [ "1", "2", "3" ] ) ) {
				$this->response( "failed", "لطفا بخش و دپارتمان تیکت را مشخص کنید" );
			}

			if ( ! in_array( $_POST['priority'], [ "1", "2", "3" ] ) ) {
				$this->response( "failed", "لطفااهمیت تیکت را مشخص کنید" );
			}

			if ( empty( $_POST['subject'] ) ) {
				$this->response( "failed", "قسمت موضوع تیکت نباید خالی باشد" );
			}

			if ( empty( $_POST['messages'] ) ) {
				$this->response( "failed", "قسمت پیام تیکت نباید خالی باشد" );
			}

			$new_ticket = $this->ticket->new_ticket(
				get_current_user_id(),
				sanitize_text_field( $_POST["subject"] ),
				intval( $_POST["department"] ),
				intval( $_POST["priority"] ),
				serialize( [ [ "user" => get_current_user_id(), "message" => sanitize_textarea_field( $_POST["messages"] ), "date" => current_time( 'mysql' ) ] ] ),
				1
			);

			if ( ! $new_ticket ) {
				$this->response( "failed", "مشکلی در ارسال تیکت وجود دارد، لطفا در زمان دیگری امتحان کنید" );
			}

			$this->response( "success", "تیکت با موفقیت ارسال شد", home_url( "account/support/tickets" ) );
		}

		//send replay ticket
		if ( $_POST["command"] === 'replay_ticket' ) {

			check_ajax_referer( "f1_account_public_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				if ( intval( get_current_user_id() ) !== intval( $this->ticket->get_ticket( $_POST["ticket_id"] )->user_id ) ) {
					$this->response( "failed", "دسترسی غیر مجاز" );
				}
			}

			if ( empty( $_POST['replay'] ) ) {
				$this->response( "failed", "قسمت پیام نباید خالی باشد" );
			}

			$replay_message = $this->ticket->replay_ticket(
				$_POST['ticket_id'],
				sanitize_textarea_field( $_POST['replay'] )
			);

			if ( ! $replay_message ) {
				$this->response( "failed", "ارسال پیام انجام نشد. لطفا بعدا امتحان کنید" );
			}

			$this->response( "success" );

		}

		//update ticket
		if ( $_POST["command"] === 'update_ticket' ) {

			check_ajax_referer( "f1_account_public_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$change_status = $this->ticket->update_ticket( $_POST['ticket_id'] );

			if ( ! $change_status ) {
				$this->response( "failed", "بروزرسانی تیکت با خطا رو به رو شد" );
			}

			$this->response( "success" );

		}


		//submit coach profile
		if ( $_POST["command"] === 'coach_profile' ) {

			check_ajax_referer( "f1_account_coach_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_coach' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( CoachUserMeta::get_coach_property( get_current_user_id() )['coach_status'] === "2" ) {
				$this->response( "failed", "در حال بازبینی مدیریت است" );
			}

			if ( ! in_array( $_POST['coach_gender'], [ "man", "woman" ] ) ) {
				$this->response( "failed", "جنسیت خود را انتخاب کنید" );
			}

			if ( ! preg_match( '/^[0-9]+$/', $_POST['coach_birth'] ) ) {
				$this->response( "failed", "سال تولد خود را به عدد وارد کنید" );
			}

			if ( ! preg_match( '/^[0-9]+$/', $_POST['coach_height'] ) ) {
				$this->response( "failed", "قد خود را به عدد وارد کنید" );
			}

			if ( ! preg_match( '/^[0-9]+$/', $_POST['coach_weight'] ) ) {
				$this->response( "failed", "وزن خود را به عدد وارد کنید" );
			}

			if ( empty( $_POST['coach_explanation'] ) ) {
				$this->response( "failed", "قسمت معرفی کوتاه نباید خالی باشد" );
			}

			if ( ! preg_match( '/^IR[0-9]{24}$/', $_POST['coach_payment'] ) ) {
				$this->response( "failed", "شماره شبا خود را مانند نمونه وارد کنید" );
			}

			if ( empty( $_POST['coach_branch'] ) || $_POST['coach_branch'] === 'undefined' ) {
				$this->response( "failed", "حداقل یک مهارت باید انتخاب کنید" );
			}

			$coach_branch = explode( ",", $_POST['coach_branch'] );

			$coach_information = [];
			$coach_program     = [];

			if ( ! empty( $_POST['coach_type_information'] ) ) {

				$coach_type_information = explode( ",", $_POST['coach_type_information'] );
				$coach_desc_information = explode( ",", $_POST['coach_desc_information'] );

				foreach ( $coach_type_information as $type_info ) {
					if ( ! in_array( $type_info, [ "certificate" ] ) ) {
						$this->response( "reload" );
						break;
					}
				}

				foreach ( $coach_desc_information as $desc_info ) {
					if ( empty( $desc_info ) ) {
						$this->response( "failed", "توضیحات فیلدها نباید خالی باشد" );
						break;
					}
					if ( ! sanitize_text_field( $desc_info ) ) {
						$this->response( "failed", "عبارات غیر مجاز در توضیحات وجود دارد" );
						break;
					}
				}

				$coach_information = $this->object_data( $coach_type_information, $coach_desc_information, [ "name1" => "type_info", "name2" => "desc_info" ] );

			}

			if ( ! empty( $_POST['coach_type_program'] ) ) {

				$coach_type_program  = explode( ",", $_POST['coach_type_program'] );
				$coach_price_program = explode( ",", $_POST['coach_price_program'] );

				foreach ( $coach_type_program as $type_program ) {
					if ( ! in_array( $type_program, [ "practice_food", "professional_consultation" ] ) ) {
						$this->response( "reload" );
						break;
					}
				}

				foreach ( $coach_price_program as $price_program ) {
					if ( ! preg_match( '/^[0-9]+$/', $price_program ) ) {
						$this->response( "failed", "قیمت را به تومان با عدد وارد کنید" );
						break;
					}
				}

				$coach_program = $this->object_data( $coach_type_program, $coach_price_program, [ "name1" => "type_service", "name2" => "program_price" ] );

			}

			if ( intval( $_POST["is_image"] ) === 0 ) {

				$image_tmp_name = $_FILES['coach_image']['tmp_name'];
				$image_size     = $_FILES['coach_image']['size'];
				$image_error    = $_FILES['coach_image']['error'];
				$image_type     = $_FILES['coach_image']['type'];
				$image_format   = explode( "/", $image_type );
				$image_format   = strtolower( end( $image_format ) );

				if ( $image_error !== 0 ) {
					$this->response( "failed", "در آپلود تصویر خطایی وجود دارد" );
				}

				if ( ! in_array( $image_format, [ 'jpg', 'png', 'jpeg' ] ) ) {
					$this->response( "failed", "فرمت تصویر باید jpg یا png باشد" );
				}

				if ( $image_size > 1061806 ) {
					$this->response( "failed", "سایز تصویر نباید بیشتر از 1 مگابایت باشد" );
				}

				$image_new_name         = uniqid( "", true ) . "." . ( $image_format === 'jpeg' ? 'jpg' : $image_format );
				$image_destination_path = F1_THEME_UPLOADS_PATH . 'coach' . DIRECTORY_SEPARATOR . $image_new_name;
				$image_destination_url  = F1_THEME_UPLOADS_URL . "coach/" . $image_new_name;

				move_uploaded_file( $image_tmp_name, $image_destination_path );

				CoachUserMeta::update_coach_property( get_current_user_id(), [ "coach_image" => $image_destination_url ] );

			}

			CoachUserMeta::update_coach_property( get_current_user_id(), [
				"coach_gender"         => $_POST['coach_gender'],
				"coach_birth"          => $_POST['coach_birth'],
				"coach_height"         => $_POST['coach_height'],
				"coach_weight"         => $_POST['coach_weight'],
				"coach_explanation"    => sanitize_textarea_field( $_POST['coach_explanation'] ),
				"coach_payment"        => $_POST['coach_payment'],
				"coach_branch"         => $coach_branch,
				"coach_status"         => "2",
				"coach_information"    => $coach_information,
				"coach_program_prices" => $coach_program,
			] );

			$this->response( "success", "اطلاعات با موفقیت بروزرسانی شد" );

		}

		//show chart athlete for coach
		if ( $_POST["command"] === 'show_chart_athlete_for_coach' ) {

			check_ajax_referer( "f1_account_coach_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_coach' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id   = $data->coach_id;
			$athlete_id = $data->athlete_id;

			if ( intval( $coach_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			$chart_data = $this->athlete_body->parse_athlete_body_for_chart( $athlete_id );
			$this->response( "success", null, $chart_data );

		}

		//show athlete chat for coach
		if ( $_POST["command"] === 'show_athlete_chat' ) {

			check_ajax_referer( "f1_account_coach_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_coach' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id", "type_program" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id     = $data->coach_id;
			$athlete_id   = $data->athlete_id;
			$type_program = $data->type_program;
			$per_page     = 50;
			$offset       = 0;

			if ( intval( $coach_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			ob_start();

			foreach ( $this->chats->get_chat_history( get_current_user_id(), $athlete_id, $type_program, $offset, $per_page ) as $chat ) {

				if ( intval( $chat->user_id ) === intval( get_current_user_id() ) ):?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-right f1-chat-box" uk-grid>
                        <div class="uk-width-auto right">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-primary uk-border-rounded uk-margin-small">
                                <p class="f1-color-white uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove uk-flex-first date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

				if ( intval( $chat->user_id ) === intval( $athlete_id ) ): ?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-left f1-chat-box" uk-grid>
                        <div class="uk-width-auto left">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-border-rounded uk-margin-small">
                                <p class="uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

			}

			$this->response( "success", null, ob_get_clean() );

		}

		//send athlete chat
		if ( $_POST["command"] === 'send_athlete_chat' ) {

			check_ajax_referer( "f1_account_coach_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_coach' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id", "type_program", "active" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id     = $data->coach_id;
			$athlete_id   = $data->athlete_id;
			$type_program = $data->type_program;
			$active       = $data->active;
			$per_page     = 50;
			$offset       = 0;

			if ( intval( $coach_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			if ( ! $active ) {
				$this->response( "failed", "در حالت غیر فعال بودن سفارش نمی توانید پیام ارسال کنید" );
			}

			$new_message_chat = $this->chats->insert_chat_message(
				get_current_user_id(),
				$athlete_id,
				$type_program,
				get_current_user_id(),
				sanitize_textarea_field( $_POST["message"] )
			);

			if ( empty( $new_message_chat ) ) {
				$this->response( "failed", "خطا در ارسال پیام" );
			}

			ob_start();

			foreach ( $this->chats->get_chat_history( get_current_user_id(), $athlete_id, $type_program, $offset, $per_page ) as $chat ) {

				if ( intval( $chat->user_id ) === intval( get_current_user_id() ) ):?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-right f1-chat-box" uk-grid>
                        <div class="uk-width-auto right">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-primary uk-border-rounded uk-margin-small">
                                <p class="f1-color-white uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove uk-flex-first date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

				if ( intval( $chat->user_id ) === intval( $athlete_id ) ): ?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-left f1-chat-box" uk-grid>
                        <div class="uk-width-auto left">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-border-rounded uk-margin-small">
                                <p class="uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

			}

			$this->response( "success", null, ob_get_clean() );
		}

		//load more athlete chat
		if ( $_POST["command"] === 'load_more_athlete_chat' ) {

			check_ajax_referer( "f1_account_coach_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_coach' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id", "type_program" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id     = $data->coach_id;
			$athlete_id   = $data->athlete_id;
			$type_program = $data->type_program;
			$per_page     = 50;
			$offset       = ! empty( $_POST["offset"] ) ? ( ( intval( $_POST["offset"] ) - 1 ) * $per_page ) : $per_page;

			if ( intval( $coach_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			ob_start();

			foreach ( $this->chats->get_chat_history( get_current_user_id(), $athlete_id, $type_program, $offset, $per_page ) as $chat ) {

				if ( intval( $chat->user_id ) === intval( get_current_user_id() ) ):?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-right f1-chat-box" uk-grid>
                        <div class="uk-width-auto right">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-primary uk-border-rounded uk-margin-small">
                                <p class="f1-color-white uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove uk-flex-first date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

				if ( intval( $chat->user_id ) === intval( $athlete_id ) ): ?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-left f1-chat-box" uk-grid>
                        <div class="uk-width-auto left">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-border-rounded uk-margin-small">
                                <p class="uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

			}

			$this->response( "success", null, ob_get_clean() );

		}

		//deactivate order
		if ( $_POST["command"] === 'deactivate_order' ) {

			check_ajax_referer( "f1_account_coach_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_coach' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id" ] );

			$coach_id = $data->coach_id;

			if ( intval( $coach_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			$close_order = $this->orders->deactivate_order( $_POST['order_id'] );

			if ( ! $close_order ) {
				$this->response( "failed", "خطا در بروزرسانی اطلاعات" );
			}

			$this->orders->activate_rate( $_POST["order_id"] );

			$this->response( "success", "سفارش با موفقیت بسته شد" );

		}


		//submit athlete profile
		if ( $_POST["command"] === 'athlete_profile' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_athlete' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! in_array( $_POST['athlete_gender'], [ "man", "woman" ] ) ) {
				$this->response( "failed", "جنسیت خود را انتخاب کنید" );
			}

			if ( ! preg_match( '/^[0-9]+$/', $_POST['athlete_birth'] ) ) {
				$this->response( "failed", "سال تولد خود را به عدد وارد کنید" );
			}

			AthleteUserMeta::update_athlete_property( get_current_user_id(), [
				"athlete_gender" => $_POST['athlete_gender'],
				"athlete_birth"  => $_POST['athlete_birth']
			] );

			$this->response( "success", "اطلاعات با موفقیت بروزرسانی شد" );
		}

		//show chart for athlete user
		if ( $_POST["command"] === 'show_chart_athlete_user' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( current_user_can( 'f1_athlete' ) ) {
				$data = $this->athlete_body->parse_athlete_body_for_chart( get_current_user_id() );
				$this->response( "success", null, $data );
			}

			exit;
		}

		//submit athlete body
		if ( $_POST["command"] === 'athlete_body' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_athlete' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! preg_match( '/^[^.][0-9]*[.]?[0-9]+$/', $_POST['athlete_height'] ) ) {
				$this->response( "failed", "قد خود را به عدد وارد کنید" );
			}

			if ( ! preg_match( '/^[^.][0-9]*[.]?[0-9]+$/', $_POST['athlete_weight'] ) ) {
				$this->response( "failed", "وزن خود را به عدد وارد کنید" );
			}

			$now         = new DateTime( "now", wp_timezone() );
			$last_update = new DateTime( $this->athlete_body->get_athlete_body( get_current_user_id(), true )->last_update, wp_timezone() );

			if ( $last_update->diff( $now )->days < 31 ) {
				$this->response( "failed", "برای ثبت اطلاعات جدید " . ( 31 - ( $last_update->diff( $now )->days ) ) . " روز باقی مانده است" );
			}

			$new_athlete_body = $this->athlete_body->new_athlete_body(
				get_current_user_id(),
				$_POST['athlete_height'],
				$_POST['athlete_weight']
			);

			if ( ! $new_athlete_body ) {
				$this->response( "failed", "خطا در ثبت اطلاعات" );
			}

			$this->response( "success", "اطلاعات با موفقیت بروزرسانی شد" );

		}

		//show coach chat for athlete
		if ( $_POST["command"] === 'show_coach_chat' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_athlete' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id", "type_program" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id     = $data->coach_id;
			$athlete_id   = $data->athlete_id;
			$type_program = $data->type_program;
			$per_page     = 50;
			$offset       = 0;

			if ( intval( $athlete_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			ob_start();

			foreach ( $this->chats->get_chat_history( intval( $coach_id ), get_current_user_id(), $type_program, $offset, $per_page ) as $chat ) {

				if ( intval( $chat->user_id ) === intval( get_current_user_id() ) ):?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-right f1-chat-box" uk-grid>
                        <div class="uk-width-auto right">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-primary uk-border-rounded uk-margin-small">
                                <p class="f1-color-white uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove uk-flex-first date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

				if ( intval( $chat->user_id ) === intval( $coach_id ) ): ?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-left f1-chat-box" uk-grid>
                        <div class="uk-width-auto left">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-border-rounded uk-margin-small">
                                <p class="uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

			}

			$this->response( "success", null, ob_get_clean() );

		}

		//send coach chat
		if ( $_POST["command"] === 'send_coach_chat' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_athlete' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id", "type_program", "active" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id     = $data->coach_id;
			$athlete_id   = $data->athlete_id;
			$type_program = $data->type_program;
			$active       = $data->active;
			$per_page     = 50;
			$offset       = 0;

			if ( intval( $athlete_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			if ( ! $active ) {
				$this->response( "failed", "برای ارسال پیام باید هزینه مشاوره را پرداخت کنید" );
			}

			$new_message_chat = $this->chats->insert_chat_message(
				$coach_id,
				get_current_user_id(),
				$type_program,
				get_current_user_id(),
				sanitize_textarea_field( $_POST["message"] )
			);

			if ( empty( $new_message_chat ) ) {
				$this->response( "failed", "خطا در ارسال پیام" );
			}

			ob_start();

			foreach ( $this->chats->get_chat_history( intval( $coach_id ), get_current_user_id(), $type_program, $offset, $per_page ) as $chat ) {

				if ( intval( $chat->user_id ) === intval( get_current_user_id() ) ):?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-right f1-chat-box" uk-grid>
                        <div class="uk-width-auto right">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-primary uk-border-rounded uk-margin-small">
                                <p class="f1-color-white uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove uk-flex-first date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

				if ( intval( $chat->user_id ) === intval( $coach_id ) ): ?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-left f1-chat-box" uk-grid>
                        <div class="uk-width-auto left">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-border-rounded uk-margin-small">
                                <p class="uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

			}


			$this->response( "success", null, ob_get_clean() );

		}

		//load more coach chat
		if ( $_POST["command"] === 'load_more_coach_chat' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_athlete' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "coach_id", "athlete_id", "type_program" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$coach_id     = $data->coach_id;
			$athlete_id   = $data->athlete_id;
			$type_program = $data->type_program;
			$per_page     = 50;
			$offset       = ! empty( $_POST["offset"] ) ? ( ( intval( $_POST["offset"] ) - 1 ) * $per_page ) : $per_page;

			if ( intval( $athlete_id ) !== intval( get_current_user_id() ) ) {
				$this->response( "reload" );
			}

			ob_start();

			foreach ( $this->chats->get_chat_history( intval( $coach_id ), get_current_user_id(), $type_program, $offset, $per_page ) as $chat ) {

				if ( intval( $chat->user_id ) === intval( get_current_user_id() ) ):?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-right f1-chat-box" uk-grid>
                        <div class="uk-width-auto right">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-primary uk-border-rounded uk-margin-small">
                                <p class="f1-color-white uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove uk-flex-first date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

				if ( intval( $chat->user_id ) === intval( $coach_id ) ): ?>

                    <div class="uk-grid uk-grid-small uk-flex-bottom uk-flex-left f1-chat-box" uk-grid>
                        <div class="uk-width-auto left">
                            <div class="uk-card uk-card-body uk-padding-small uk-card-default uk-border-rounded uk-margin-small">
                                <p class="uk-text-right uk-text-small"><?= str_replace( "\n", "<br>", $chat->message ) ?></p>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-margin-remove date">
                            <span style="font-size: 12px" class="uk-text-meta"><?= PersianDate::convert( new DateTime( $chat->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                        </div>
                    </div>

				<?php endif;

			}

			$this->response( "success", null, ob_get_clean() );

		}

		//submit rate coach
		if ( $_POST["command"] === 'submit_rate_coach' ) {

			check_ajax_referer( "f1_account_athlete_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'f1_athlete' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! in_array( $_POST["rate"], [ "1", "2", "3", "4", "5" ] ) ) {
				$this->response( "failed", "لطفا یک امتیاز انتخاب کنید" );
			}

			$data = $this->orders->find( $_POST['order_id'], [ "athlete_id", "coach_id", "can_rate" ] );

			if ( empty( $data ) ) {
				$this->response( "reload" );
			}

			$athlete_id = $data->athlete_id;
			$coach_id   = $data->coach_id;
			$can_rate   = $data->can_rate;

			if ( intval( $athlete_id ) !== intval( get_current_user_id() ) || ! $can_rate ) {
				$this->response( "reload" );
			}

			$this->coach_rate->insert_rate( get_current_user_id(), $coach_id, $_POST["rate"] );

			$this->orders->deactivate_rate( $_POST['order_id'] );

			$sum_rate = $this->coach_rate->sum_rate( $coach_id );

			CoachPostMeta::update_coach_rate( CoachUserMeta::get_coach_property( $coach_id )["post_id"], $sum_rate );

			$this->response( "success", "امتیاز با موفقیت ثبت شد" );

		}


		//submit coach status
		if ( $_POST["command"] === 'change_coach_status' ) {

			check_ajax_referer( "f1_account_admin_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! in_array( $_POST['coach_status'], [ "1", "3" ] ) ) {
				$this->response( "failed", "لطفا یک وضعیت را انتخاب کنید" );
			}

			if ( empty( $_POST['coach_alert'] ) && $_POST['coach_status'] === "3" ) {
				$this->response( "failed", "متن توضیحات نباید خالی باشد" );
			}

			if ( $_POST['coach_status'] === "3" ) {
				CoachUserMeta::update_coach_property( $_POST['coach_id'], [ "coach_status" => "3" ] );
				CoachUserMeta::update_coach_property( $_POST['coach_id'], [ "coach_alert" => sanitize_textarea_field( $_POST['coach_alert'] ) ] );
				$this->response( "success", "مربی با موفقیت بروزرسانی شد" );
			}

			if ( $_POST['coach_status'] === "1" ) {

				$query = new WP_Query( [
					'post_type'    => 'coach',
					'meta_key'     => '_coach_id',
					'meta_value'   => $_POST['coach_id'],
					'meta_compare' => '='
				] );

				//create coach
				if ( ! $query->have_posts() ) {

					$post_id = wp_insert_post( [
						'post_type'   => "coach",
						'post_title'  => get_user_by( 'ID', $_POST['coach_id'] )->display_name,
						'post_status' => 'publish',
						'tax_input'   => [
							'sports_branches' => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_branch']
						],
					] );

					if ( is_wp_error( $post_id ) ) {
						$this->response( "failed", "مشکلی در ذخیره مربی وجود دارد" );
					}

					CoachPostMeta::update_coach_property( $post_id, [
						"coach_gender"         => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_gender'],
						"coach_birth"          => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_birth'],
						"coach_height"         => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_height'],
						"coach_weight"         => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_weight'],
						"coach_image"          => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_image'],
						"coach_explanation"    => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_explanation'],
						"coach_information"    => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_information'],
						"coach_program_prices" => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_program_prices']
					] );
					CoachPostMeta::update_coach_id( $post_id, $_POST['coach_id'] );
					CoachUserMeta::update_coach_property( $_POST['coach_id'], [
						'coach_status' => '1',
						'post_id'      => $post_id
					] );
					$this->response( "success", "مربی با موفقیت فعال شد" );
				}

				//create update
				if ( $query->have_posts() ) {

					$post_id = wp_update_post( [
						'ID'          => $query->post->ID,
						'post_status' => 'publish',
						'tax_input'   => [
							'sports_branches' => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_branch']
						],
					] );

					if ( is_wp_error( $post_id ) ) {
						$this->response( "failed", "مشکلی در بروزرسانی مربی وجود دارد" );
					}

					CoachPostMeta::update_coach_property( $post_id, [
						"coach_gender"         => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_gender'],
						"coach_birth"          => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_birth'],
						"coach_height"         => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_height'],
						"coach_weight"         => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_weight'],
						"coach_image"          => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_image'],
						"coach_explanation"    => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_explanation'],
						"coach_id"             => $_POST['coach_id'],
						"coach_information"    => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_information'],
						"coach_program_prices" => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_program_prices']
					] );
					CoachPostMeta::update_coach_id( $post_id, $_POST['coach_id'] );
					CoachUserMeta::update_coach_property( $_POST['coach_id'], [
						'coach_status' => '1',
						'post_id'      => $post_id
					] );
					$this->response( "success", "مربی با موفقیت بروزرسانی شد" );
				}

			}

		}

		//submit post status
		if ( $_POST["command"] === 'change_post_status' ) {

			check_ajax_referer( "f1_account_admin_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! in_array( $_POST['post_status'], [ "0", "1" ] ) ) {
				$this->response( "failed", "لطفا یک حالت را انتخاب کنید" );
			}

			$post_id = wp_update_post( [
				'ID'          => CoachUserMeta::get_coach_property( $_POST['coach_id'] )['post_id'],
				'post_status' => $_POST['post_status'] === '1' ? 'publish' : 'pending'
			] );

			if ( is_wp_error( $post_id ) ) {
				$this->response( "failed", "مشکلی در بروزرسانی مربی وجود دارد" );
			}

			$this->response( "success", "مربی با موفقیت بروزرسانی شد" );
		}

		//submit coach finance settlement
		if ( $_POST["command"] === 'coach_finance_settlement' ) {

			check_ajax_referer( "f1_account_admin_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( empty( $_POST['document_number'] ) ) {
				$this->response( "failed", "یک شماره سند وارد کنید" );
			}

			$coach_balance      = new CoachBalanceRepository();
			$finance_settlement = new FinanceSettlementRepository();

			$current_balance          = $coach_balance->get_balance( $_POST['coach_id'] );
			$coach_finance_settlement = $finance_settlement->get_finance_settlement( $_POST['coach_id'] );
			$current_balance          = intval( $current_balance ) - intval( $coach_finance_settlement );

			if ( ( intval( $_POST['amount'] ) > intval( $current_balance ) ) || intval( $_POST['amount'] ) === 0 || ! preg_match( '/^[0-9]+$/', strval( $_POST['amount'] ) ) ) {
				$this->response( "failed", "مقدار پرداخت معتبر نیست" );
			}

			$pay = $finance_settlement->new_finance_settlement(
				intval( $_POST['coach_id'] ),
				CoachUserMeta::get_coach_property( $_POST['coach_id'] )['coach_payment'],
				sanitize_text_field( $_POST['document_number'] ),
				intval( $_POST['amount'] )
			);

			if ( ! $pay ) {
				$this->response( "failed", "خطا در ثبت اطلاعات" );
			}

			$this->response( "success", "پرداخت با موفقیت ثبت شد" );
		}

		//submit setting pay payment
		if ( $_POST["command"] === 'setting_payment' ) {

			check_ajax_referer( "f1_account_admin_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! in_array( $_POST['payment_status'], [ "0", "1" ] ) ) {
				$this->response( "failed", "لطفا یک وضعیت را انتخاب کنید" );
			}

			if ( empty( $_POST['api_pay'] ) ) {
				$this->response( "failed", "کد API را وارد کنید" );
			}


			if ( $_POST['payment'] === 'pay' ) {
				PaymentsOption::update_payment( 'pay', [
					'name_payment' => 'درگاه پرداخت پی',
					'icon_payment' => F1_THEME_ASSET_URL . "img/icons/pay.svg",
					'active'       => $_POST['payment_status'],
					'api'          => $_POST['api_pay']
				] );
				$this->response( "success", "درگاه پی با موفقیت بروزرسانی شد" );
			}


			$this->response( "reload" );

		}

		//submit setting finance
		if ( $_POST["command"] === 'setting_finance' ) {

			check_ajax_referer( "f1_account_admin_ajax_nonce", "nonce" );

			if ( ! current_user_can( 'administrator' ) ) {
				$this->response( "failed", "دسترسی غیر مجاز" );
			}

			if ( ! preg_match( '/^[0-9]+$/', $_POST['percent_site'] ) ) {
				$this->response( "failed", "درصد سایت را به عدد وارد کنید" );
			}

			if ( $_POST['percent_site'] < 0 || $_POST['percent_site'] > 100 ) {
				$this->response( "failed", "درصد سایت را صحیح وارد کنید" );
			}

			SettingOptions::update_setting( 'percent_site', $_POST['percent_site'] );

			$this->response( "success", "تنظیمات با موفقیت بروزرسانی شد" );

		}

	}

	public function ajax_shopping()
	{

		//check nonce
		check_ajax_referer("f1_front_ajax_nonce", "nonce");

		//send order
		if ($_POST["command"] === 'order_program') {

			if (!is_user_logged_in())
				$this->response('redirect', null, home_url('login'));

			if (!current_user_can('f1_athlete'))
				$this->response('failed', "برای سفارش باید حتما به عنوان ورزشکار ثبت نام کنید");

			$query = new WP_Query([
				'page_id' => $_POST['post_id'],
				'post_type' => 'coach',
				'meta_key' => '_coach_property',
				'meta_value' => serialize(strval($_POST['type_service'])),
				'meta_compare' => 'LIKE'
			]);

			if (!$query->have_posts())
				$this->response('reload');

			$coach_id = CoachPostMeta::get_coach_property($_POST['post_id'])['coach_id'];
			$order = $this->orders->check_activate_order(get_current_user_id(), $coach_id, $_POST['type_service']);

			if ($order)
				$this->response('failed', "در حال حاضر این سفارش در پنل کاربری برای شما فعال است");

			$this->response('success', null, home_url("checkout"));

		}

	}

}