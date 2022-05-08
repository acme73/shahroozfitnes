<?php /* Template Name: صفحه اصلی اول */

use App\utils\View;

?>

<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--intro-->
<?php View::render( "app.theme.views.home-page.intro" ); ?>

<!--steps-->
<?php View::render( "app.theme.views.home-page.steps" ); ?>

<!--coach list-->
<?php View::render( "app.theme.views.home-page.coach-list" ); ?>

<!--calculate-bmi-->
<?php View::render( "app.theme.views.home-page.calculate-bmi" ); ?>

<!--comment list-->
<?php View::render( "app.theme.views.home-page.comment-list" ); ?>

<!--contact us-->
<?php View::render( "app.theme.views.home-page.about-us" ); ?>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>

