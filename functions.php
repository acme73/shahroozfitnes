<?php

use App\core\App;
use App\core\Initializer;
use App\theme\services\Ajax;
use App\theme\services\CoachPropertyMetaBox;

require "constant.php";
require "vendor/autoload.php";

new Initializer();
new Ajax();
if ( is_admin() ) {

	/**init coach property meta box*/
	new CoachPropertyMetaBox();

}

new App();



