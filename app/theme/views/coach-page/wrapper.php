<!--

coach-page wrapper

-->


<?php

use App\utils\View;

?>

<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
				<?php View::render( "app.theme.views.coach-page.sidebar" ); ?>
            </div>
            <div class="col-lg-9">
				<?php View::render( "app.theme.views.coach-page.main" ); ?>
            </div>
        </div>
    </div>
</section>