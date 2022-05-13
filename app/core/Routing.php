<?php

namespace App\core;

defined( 'ABSPATH' ) || die( "No Access" );

class Routing {

	public array $routes = [
		[
			'route'      => '/login/',
			'module'     => 'theme',
			'controller' => 'LoginController',
			'action'     => 'index'
		],
		[
			'route'      => '/checkout/',
			'module'     => 'theme',
			'controller' => 'DefaultController',
			'action'     => 'checkout'
		],
		[
			'route'      => "/account\/support\/tickets/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'support_tickets'
		],
		[
			'route'      => "/account\/support\/new_ticket/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'support_new_ticket'
		],
		[
			'route'      => "/account\/tools\/exports/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'tools_exports'
		],
		[
			'route'      => "/account\/setting\/payment/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'setting_payment'
		],
		[
			'route'      => "/account\/finance\/settlement/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'finance_settlement'
		],
		[
			'route'      => "/account\/finance\/transactions/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'finance_transactions'
		],
		[
			'route'      => "/account\/accounting\/transactions/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'accounting_transactions'
		],
		[
			'route'      => "/account\/accounting\/paid/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'accounting_paid'
		],
		[
			'route'      => "/account\/accounting\/configuration/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'accounting_configuration'
		],
		[
			'route'      => "/account\/order\/coach/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'order_coach'
		],
		[
			'route'      => "/account\/order\/athlete/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'order_athlete'
		],
		[
			'route'      => "/account\/coach\/profile/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'coach_profile'
		],
		[
			'route'      => "/account\/coach\/manage/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'coach_manage'
		],
		[
			'route'      => "/account\/athlete\/profile/",
			'module'     => 'theme',
			'controller' => 'AccountController',
			'action'     => 'athlete_profile'
		]
	];

	public function __construct() {
		return $this->routes;
	}

}