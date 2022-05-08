<?php

namespace App\theme\controllers;

use App\theme\repository\CoachBalanceRepository;
use App\theme\repository\FinanceSettlementRepository;
use App\theme\repository\OrderRepository;
use App\theme\repository\TicketRepository;
use App\theme\repository\TransactionRepository;
use App\theme\repository\UsersRepository;
use App\theme\services\AthleteUserMeta;
use App\theme\services\CoachUserMeta;
use App\utils\PersianDate;
use App\utils\View;
use DateTime;

defined( 'ABSPATH' ) || die( "No Access" );

class AccountController {

	private $current_user;
	private $tickets;
	private $users;

	public function __construct() {

		/**Check User Logged*/
		if ( ! is_user_logged_in() ) {
			wp_safe_redirect( home_url( 'login' ) );
			exit;
		}

		$this->current_user = wp_get_current_user();
		$this->tickets      = new TicketRepository();
		$this->users        = new UsersRepository();

		//register assets login page
		add_action( "wp_head", [ $this, "register_assets" ] );

	}

	public function register_assets() {

		wp_enqueue_script( 'f1-account-public', F1_THEME_ASSET_URL . 'js/account-panel/public.js', [ 'jquery' ], F1_THEME_VERSION, true );
		wp_localize_script( 'f1-account-public', 'f1_account_public_data', [
			"ajax_url" => admin_url( "admin-ajax.php" ),
			"nonce"    => wp_create_nonce( "f1_account_public_ajax_nonce" )
		] );

		if ( current_user_can( "f1_coach" ) ) {
			wp_enqueue_script( 'f1-chart', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js", null, null, true );
			wp_enqueue_script( 'f1-account-coach', F1_THEME_ASSET_URL . 'js/account-panel/coach.js', [
				"f1-chart",
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
				"jquery-ui-autocomplete"
			], F1_THEME_VERSION, true );
			wp_localize_script( 'f1-account-coach', 'f1_account_coach_data', [
				"ajax_url" => admin_url( "admin-ajax.php" ),
				"nonce"    => wp_create_nonce( "f1_account_coach_ajax_nonce" )
			] );
		}
		if ( current_user_can( "f1_athlete" ) ) {
			wp_enqueue_script( 'f1-chart', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js", null, null, true );
			wp_enqueue_script( 'f1-account-athlete', F1_THEME_ASSET_URL . 'js/account-panel/athlete.js', [
				"f1-chart",
				'jquery',
				'jquery-ui-core',
				'jquery-ui-sortable',
				"jquery-ui-autocomplete"
			], F1_THEME_VERSION, true );
			wp_localize_script( 'f1-account-athlete', 'f1_account_athlete_data', [
				"ajax_url" => admin_url( "admin-ajax.php" ),
				"nonce"    => wp_create_nonce( "f1_account_athlete_ajax_nonce" )
			] );
		}
		if ( current_user_can( "administrator" ) ) {
			wp_enqueue_script( 'f1-account-admin', F1_THEME_ASSET_URL . 'js/account-panel/admin.js', [ 'jquery' ], F1_THEME_VERSION, true );
			wp_localize_script( 'f1-account-admin', 'f1_account_admin_data', [
				"ajax_url" => admin_url( "admin-ajax.php" ),
				"nonce"    => wp_create_nonce( "f1_account_admin_ajax_nonce" )
			] );
		}

	}

	/**support*/
	public function support_tickets() {

		/**check permision role user -> only administrator athlete coach */
		if ( ! array_intersect( [ 'f1_coach', 'f1_athlete', 'administrator' ], $this->current_user->roles ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$max_count_page = 0;
		$per_page       = 15;
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		//check authorize user
		if ( ! empty( func_get_args()[1]["ticket_id"] ) ) {
			if ( ! current_user_can( 'administrator' ) ) {
				if (
					$this->tickets->get_ticket( func_get_args()[1]["ticket_id"] ) === null ||
					get_current_user_id() !== intval( $this->tickets->get_ticket( func_get_args()[1]["ticket_id"] )->user_id )
				) {
					wp_safe_redirect( home_url() );
					exit;
				}
			}
		}

		View::render( "app.theme.views.account-panel.sections.support-tickets", [
			"max_count_page" => $max_count_page,
			"per_page"       => $per_page,
			"offset"         => $offset,
			"current_user"   => $this->current_user,
			"tickets"        => $this->tickets,
			"users"          => $this->users,
			"query_var"      => func_get_args()[1]
		] );

	}

	public function support_new_ticket() {

		/* check capability user -> only coach & athlete */
		$current_user = wp_get_current_user();
		if ( ! array_intersect( [ 'f1_coach', 'f1_athlete' ], $current_user->roles ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		View::render( "app.theme.views.account-panel.sections.support-new-ticket", [
			"current_user" => $this->current_user,
			"tickets"      => $this->tickets,
			"users"        => $this->users
		] );

	}


	/**tools*/
	public function tools_exports() {

		/* check capability user -> only administrator */
		if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		if ( isset( $_POST["f1_download_csv_users"] ) ) {

			$role  = $_POST["f1_role_user"];
			$users = new UsersRepository();

			if ( ! in_array( $_POST["f1_role_user"], [ "any", "coach", "athlete" ] ) ) {
				$role = "any";
			}

			$file_name = $role . "_users_" . PersianDate::convert( new DateTime(), "Y_M_d" ) . ".csv";

			header( 'Content-Type: text/csv; charset=utf-8' );
			header( "Content-Disposition: attachment; filename= $file_name" );

			$output = fopen( "php://output", "w" );

			fputcsv( $output, [ "ID", "Name", "Mobile" ] );

			foreach ( $users->get_all_user_by_role( $role ) as $user ) {
				fputcsv( $output, [ $user["id"], $user["name"], $user["mobile"] ] );
			}

			fclose( $output );

			exit;

		}

		View::render( "app.theme.views.account-panel.sections.tools-exports", [
			"current_user" => $this->current_user,
			"tickets"      => $this->tickets,
			"users"        => $this->users,
		] );

	}

	/**setting*/
	public function setting_payment() {
		View::render( "app.theme.views.client.account.setting-payment" );
	}

	/**finance*/
	public function finance_settlement() {

		/* check capability user -> only coach */
		if ( ! current_user_can( 'f1_coach' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$coach_balance      = new CoachBalanceRepository();
		$finance_settlement = new FinanceSettlementRepository();

		$balance                  = $coach_balance->get_balance( get_current_user_id() );
		$coach_finance_settlement = $finance_settlement->get_finance_settlement( get_current_user_id() );

		$balance = intval( $balance ) - intval( $coach_finance_settlement );

		$transactions               = $coach_balance->get_transactions( get_current_user_id(), 15 );
		$finance_settlement_history = $finance_settlement->get_finance_settlement_history( get_current_user_id(), 15 );

		View::render( "app.theme.views.account-panel.sections.finance-settlement", [
			"finance_settlement"         => $finance_settlement,
			"balance"                    => $balance,
			"finance_settlement_history" => $finance_settlement_history,
			"transactions"               => $transactions,
			"current_user"               => $this->current_user,
			"tickets"                    => $this->tickets,
			"users"                      => $this->users,
		] );

	}

	public function finance_transactions() {

		/* check capability user -> only athlete */
		if ( ! current_user_can( 'f1_athlete' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$transactions = new TransactionRepository();

		$max_count_page = $transactions->get_transactions_count( get_current_user_id() );
		$per_page       = empty( func_get_args()[1]['per_page'] ) ? 10 : func_get_args()[1]['per_page'];
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		View::render( "app.theme.views.account-panel.sections.finance-transactions", [
			"transactions"   => $transactions,
			"max_count_page" => $max_count_page,
			"per_page"       => $per_page,
			"offset"         => $offset,
			"current_user"   => $this->current_user,
			"tickets"        => $this->tickets,
			"users"          => $this->users,
			"query_var"      => func_get_args()[1]
		] );

	}

	/**accounting*/
	public function accounting_transactions() {

		/* check capability user -> only administrator */
		if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$transactions = new TransactionRepository();

		$max_count_page = $transactions->get_transactions_count();
		$per_page       = empty( func_get_args()[1]['per_page'] ) ? 10 : func_get_args()[1]['per_page'];
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		View::render( "app.theme.views.account-panel.sections.accounting-transactions", [
			"transactions"   => $transactions,
			"max_count_page" => $max_count_page,
			"per_page"       => $per_page,
			"offset"         => $offset,
			"current_user"   => $this->current_user,
			"tickets"        => $this->tickets,
			"users"          => $this->users,
			"query_var"      => func_get_args()[1]
		] );

	}

	public function accounting_paid() {

		/* check capability user -> only administrator */
		if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$all_finance_settlement = new FinanceSettlementRepository();

		$max_count_page = $all_finance_settlement->get_all_finance_settlement_history( null, null, true );
		$per_page       = empty( func_get_args()[1]['per_page'] ) ? 10 : func_get_args()[1]['per_page'];
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		View::render( "app.theme.views.account-panel.sections.accounting-paid", [
			"all_finance_settlement" => $all_finance_settlement,
			"max_count_page"         => $max_count_page,
			"per_page"               => $per_page,
			"offset"                 => $offset,
			"current_user"           => $this->current_user,
			"tickets"                => $this->tickets,
			"users"                  => $this->users,
			"query_var"              => func_get_args()[1]
		] );

	}

	public function accounting_configuration() {

		/* check capability user -> only administrator */
		if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		View::render( "app.theme.views.account-panel.sections.accounting-configuration", [
			"current_user" => $this->current_user,
			"tickets"      => $this->tickets,
			"users"        => $this->users,
		] );

	}

	/**order*/
	public function order_coach() {

		/* check capability user -> only athlete */
		if ( ! current_user_can( 'f1_athlete' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$transaction_status = null;

		/*if ( isset( $_SESSION['transaction_status'] ) ) {

			if ( $_SESSION['transaction_status'] === 1 ) {
				$transaction_status = 1;
			}

			if ( $_SESSION['transaction_status'] === 0 ) {
				$transaction_status = 0;
			}

			unset( $_SESSION['transaction_status'] );
		}*/

		$order          = new OrderRepository();
		$max_count_page = $order->get_count_orders_for_athlete( get_current_user_id() );
		$per_page       = 15;
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		View::render( "app.theme.views.account-panel.sections.order-coach", [
			"transaction_status" => $transaction_status,
			"current_user"       => $this->current_user,
			"tickets"            => $this->tickets,
			"users"              => $this->users,
			"order"              => $order,
			"max_count_page"     => $max_count_page,
			"per_page"           => $per_page,
			"offset"             => $offset
		] );

	}

	public function order_athlete() {

		/* check capability user -> only coach */
		if ( ! current_user_can( 'f1_coach' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$order          = new OrderRepository();
		$max_count_page = $order->get_count_orders_for_coach( get_current_user_id() );
		$per_page       = 15;
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		View::render( "app.theme.views.account-panel.sections.order-athlete", [
			"order"          => $order,
			"current_user"   => $this->current_user,
			"tickets"        => $this->tickets,
			"users"          => $this->users,
			"max_count_page" => $max_count_page,
			"per_page"       => $per_page,
			"offset"         => $offset,
			"query_var"      => func_get_args()[1]
		] );

	}

	/**coach*/
	public function coach_profile() {

		/* check capability user -> only coach */
		if ( ! current_user_can( 'f1_coach' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$coach_property = CoachUserMeta::get_coach_property( get_current_user_id() );

		View::render( "app.theme.views.account-panel.sections.coach-profile", [
			"current_user"   => $this->current_user,
			"tickets"        => $this->tickets,
			"users"          => $this->users,
			"coach_property" => $coach_property
		] );
	}

	public function coach_manage() {

		/* check capability user -> only administrator */
		if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$max_count_page = $this->users->get_all_coach_for_manage( null, null, null, true );
		$per_page       = empty( func_get_args()[1]['per_page'] ) ? 10 : func_get_args()[1]['per_page'];
		$coach_status   = ! isset( func_get_args()[1]['coach_status'] ) || func_get_args()[1]['coach_status'] === "all" ? null : func_get_args()[1]['coach_status'];
		$offset         = ! empty( func_get_args()[1]["page"] ) ? ( ( intval( func_get_args()[1]["page"] ) - 1 ) * $per_page ) : 0;

		$coach_balance      = new CoachBalanceRepository();
		$finance_settlement = new FinanceSettlementRepository();

		View::render( "app.theme.views.account-panel.sections.coach-manage", [
			"current_user"       => $this->current_user,
			"tickets"            => $this->tickets,
			"users"              => $this->users,
			"max_count_page"     => $max_count_page,
			"per_page"           => $per_page,
			"offset"             => $offset,
			"coach_status"       => $coach_status,
			"coach_balance"      => $coach_balance,
			"finance_settlement" => $finance_settlement,
			"query_var"          => func_get_args()[1]
		] );

	}

	/**athlete*/
	public function athlete_profile() {

		/* check capability user -> only athlete */
		if ( ! current_user_can( 'f1_athlete' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}

		$athlete_property = AthleteUserMeta::get_athlete_property( get_current_user_id() );

		View::render( "app.theme.views.account-panel.sections.athlete-profile", [
			"current_user"     => $this->current_user,
			"tickets"          => $this->tickets,
			"users"            => $this->users,
			"athlete_property" => $athlete_property
		] );

	}


}