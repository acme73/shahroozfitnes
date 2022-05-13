<?php

use App\utils\View;

?>


<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--intro-->
<?php View::render( "app.theme.views.coach-page.intro" ); ?>

<!--wrapper-->
<?php View::render( "app.theme.views.coach-page.wrapper" ); ?>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>

