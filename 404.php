<!--

404 page

-->

<?php

use App\utils\View;

?>


<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--content-->
<section class="uk-section uk-flex uk-flex-center uk-flex-middle">
	<div class="uk-grid uk-grid-small uk-text-center" uk-grid>

		<div class="uk-width-1-1">
			<h1 class="uk-heading-2xlarge">404</h1>
		</div>

		<div class="uk-width-1-1">
			<p class="uk-text-small">صفحه مورد نظر پیدا نشد :(</p>
		</div>

	</div>
</section>

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>