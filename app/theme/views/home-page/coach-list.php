<!--

homepage coach list rtl

-->

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container uk-text-center">

        <h4 class="uk-text-bold uk-margin-medium-bottom">مربی‌های متخصص و با‌تجربه ما</h4>

        <div class="uk-child-width-1-2 uk-child-width-1-3@m" uk-grid>
			<?php for ( $x = 0; $x < 9; $x ++ ) : ?>
                <div>
                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/profile-coach.png" ?>" class="uk-border-circle f1-border-primary f1-border-solid f1-border-3" width="170">
                    <p class="uk-text-bold uk-text-secondary">شهروز رحیمی</p>
                </div>
			<?php endfor; ?>
        </div>

        <a href="<?= home_url() . "/coach" ?>" class="uk-button uk-button-primary uk-border-pill uk-margin-medium-top">مشاهده همه مربی ها</a>

    </div>
</section>