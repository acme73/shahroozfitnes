<?php

use App\core\App;
use App\core\Initializer;
use App\core\Rewrite;
use App\theme\services\Ajax;
use App\theme\services\CoachPropertyMetaBox;
use App\theme\services\Hooks;

require "constant.php";
require "vendor/autoload.php";


new Initializer();
new Hooks();
new Ajax();
if ( is_admin() ) {

	/**init coach property meta box*/
	new CoachPropertyMetaBox();

}

new App();
new Rewrite();



