<!--

contact us

-->

<?php /* Template Name: تماس با ما */

use App\utils\View;

?>


<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--intro-->
<?php View::render( "app.theme.views.contact-us.intro" ); ?>

<!--info-->
<?php View::render( "app.theme.views.contact-us.info" ); ?>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>