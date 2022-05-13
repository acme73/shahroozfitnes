<?php

use App\theme\services\CoachPostMeta;
use App\utils\View;

?>

<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>


		<?php
		//property
		$coach_property = CoachPostMeta::get_coach_property( get_the_ID() );
		$coach_rate     = CoachPostMeta::get_coach_rate( get_the_ID() );
		?>

        <!--intro-->
		<?php View::render( "app.theme.views.coach-single.intro" ); ?>

        <!--price-->
		<?php View::render( "app.theme.views.coach-single.prices", [
			"coach_property" => $coach_property,
			"coach_rate"     => $coach_rate
		] ); ?>

        <!--info-->
		<?php View::render( "app.theme.views.coach-single.info", [
			"coach_property" => $coach_property
		] ); ?>

        <!--branch-->
		<?php View::render( "app.theme.views.coach-single.branch", [
			"coach_property" => $coach_property
		] ); ?>

        <!--certificate-->
		<?php View::render( "app.theme.views.coach-single.certificate", [
			"coach_property" => $coach_property
		] ); ?>

        <!--gallery-->
		<?php View::render( "app.theme.views.coach-single.gallery" ); ?>

        <!--video-->
		<?php View::render( "app.theme.views.coach-single.video" ); ?>

	<?php endwhile; ?>
<?php endif; ?>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>
