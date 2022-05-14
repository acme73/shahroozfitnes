<!--

coach gallery

-->

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <h4 class="uk-text-bold uk-margin-remove-bottom f1-text-black">تصاویر:</h4>
        <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom uk-width-1-6"/>
        <div class="uk-child-width-1-3" uk-grid>
			<?php for ( $x = 0; $x < 6; $x ++ ): ?>
                <img src="<?= F1_THEME_ASSET_URL . "images/partials/placeholder.svg" ?>" width="80">
			<?php endfor; ?>
        </div>
    </div>
</section>
