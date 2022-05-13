<!--

blog wrapper

-->


<?php

use App\utils\View;

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <div uk-grid>
            <div class="uk-width-1-1 uk-width-1-5@m ">
		        <?php View::render( "app.theme.views.blog-page.sidebar" ); ?>
            </div>
            <div class="uk-width-expand uk-flex-first">
				<?php View::render( "app.theme.views.blog-page.main" ); ?>
            </div>
        </div>
    </div>
</section>
