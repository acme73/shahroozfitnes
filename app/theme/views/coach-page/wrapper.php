<!--

coach-page wrapper

-->

<?php

use App\utils\View;

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <div uk-grid>
            <div class="uk-width-1-5">
				<?php View::render( "app.theme.views.coach-page.sidebar" ); ?>
            </div>
            <div class="uk-width-expand">
				<?php View::render( "app.theme.views.coach-page.main" ); ?>
            </div>
        </div>
    </div>
</section>