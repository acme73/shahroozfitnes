<!--

homepage comment list rtl

-->

<section class="uk-section uk-section-small uk-background-muted">
    <div class="container">
        <div uk-grid>

            <div class="uk-width-1-1">
                <h4 class="uk-text-bold uk-text-center">نظرات برخی از همراهان ما</h4>
            </div>

            <div class="uk-width-1-1">
                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider="center: true">

                    <ul class="uk-slider-items uk-grid">
						<?php for ( $x = 0; $x < 10; $x ++ ): ?>
                            <li>
                                <div class="uk-card uk-card-default uk-padding-small uk-border-rounded " style="width: 295px">
                                    <div class="uk-card-header uk-padding-remove f1-remove-border">
                                        <div class="uk-flex-middle" uk-grid>
                                            <div class="uk-width-expand">
                                                <div class="uk-flex uk-flex-middle">
                                                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-number-icon-star.svg" ?>" width="20">
                                                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-number-icon-star.svg" ?>" width="20">
                                                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-number-icon-star.svg" ?>" width="20">
                                                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-number-icon-star.svg" ?>" width="20">
                                                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-number-icon-star.svg" ?>" width="20">
                                                </div>
                                            </div>
                                            <div class="uk-width-auto">
                                                <img src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-testimonial.png" ?>" width="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-card-body uk-padding-remove">
                                        <p class="uk-text-justify f1-text-black">
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
                                        </p>
                                    </div>
                                    <div class="uk-card-footer uk-padding-remove f1-remove-border">
                                        <span class="uk-text-bold f1-text-black">شهروز رحیمی</span>
                                    </div>
                                </div>
                            </li>
						<?php endfor; ?>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</section>