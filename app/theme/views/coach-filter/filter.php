<!--

filter coach

-->


<?php

/**
 * @var $coach_query
 * @var $gender
 * @var $sports_branches
 */

use App\utils\View;

?>


<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--intro-->
<?php View::render( "app.theme.views.coach-filter.intro" ); ?>

<!--wrapper-->
<?php View::render( "app.theme.views.coach-filter.wrapper", [
	"coach_query"     => $coach_query,
	"gender"          => $gender,
	"sports_branches" => $sports_branches,
] ); ?>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>


