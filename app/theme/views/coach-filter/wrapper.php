<!--

coach-page wrapper

-->

<?php

/**
 * @var $coach_query
 * @var $gender
 * @var $sports_branches
 */

use App\utils\View;

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <div uk-grid>
            <div class="uk-width-1-1 uk-width-1-5@m">
				<?php View::render( "app.theme.views.coach-filter.sidebar", [
					"gender"          => $gender,
					"sports_branches" => $sports_branches
				] ); ?>
            </div>
            <div class="uk-width-expand">
				<?php View::render( "app.theme.views.coach-filter.main", [
					"coach_query" => $coach_query
				] ); ?>
            </div>
        </div>
    </div>
</section>