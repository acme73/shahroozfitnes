<!--

contact us

-->

<?php /* Template Name: درباره ما */

use App\utils\View;

?>


<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--intro-->
<?php View::render( "app.theme.views.about-us.intro" ); ?>

<!--info-->
<?php View::render( "app.theme.views.about-us.info" ); ?>

<!--main-->
<?php View::render( "app.theme.views.about-us.main" ); ?>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>
