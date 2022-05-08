<?php

namespace App\core;

use App\theme\controllers\DefaultController;

defined( 'ABSPATH' ) || die( "No Access" );

class App {

	public function __construct() {

		$routing = new Routing();
		$url     = $this->parseUrl();

		if ( $routing->routes && in_array( $url[0], [ "account", "login" ] ) ) {

			$controller = new DefaultController();
			$action     = "notfound";
			$params     = [];
			$urlPath    = implode( "/", $url );

			foreach ( $routing->routes as $route ) {

				if ( preg_match( $route["route"], $urlPath ) ) {

					$path_controller = F1_THEME_PATH . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . $route['module'] . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $route['controller'] . '.php';

					if ( file_exists( $path_controller ) ) {
						$dynamicControllerName = "App" . "\\" . $route['module'] . "\\controllers\\" . $route['controller'];
						$controller            = new $dynamicControllerName;
						$action                = $route['action'];
						$urlPath               = trim( $route["route"], "/" );
						$urlPath               = explode( "\/", $urlPath );
						$url                   = array_diff( $url, $urlPath );
						break;
					}

				}

			}

			/**add path request in params*/
			if ( count( $url ) > 0 ) {

				$url = array_values( $url );

				foreach ( $url as $key => $value ) {
					$params['path'][ $key ] = $value;
				}

			} else {
				$params["path"] = [];
			}

			/**add query request in params*/
			if ( $_GET ) {

				foreach ( $_GET as $key => $value ) {
					$params['query'][ $key ] = $value;
				}

			} else {
				$params["query"] = [];
			}

			call_user_func_array( [ $controller, $action ], $params );
			exit;

		}

	}

	private function parseUrl() {

		$request = trim( $_SERVER['REQUEST_URI'], '/' );
		$request = strtok( $request, '?' );
		$request = filter_var( $request, FILTER_SANITIZE_URL );

		return explode( '/', $request );

	}

}