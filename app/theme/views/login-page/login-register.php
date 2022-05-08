<!--

login & register page

-->

<?php get_header() ?>

<section class="uk-flex uk-flex-center uk-flex-middle uk-cover-container uk-height-viewport uk-overflow-hidden" uk-height-viewport>

    <div class="uk-section uk-text-center">

        <div class="uk-width-medium uk-background-muted uk-padding uk-margin f1-border-rounded-15 ">

            <div class="uk-grid uk-grid-small uk-child-width-1-1 " id="f1_login_container" uk-grid>

                <div>
                    <img src="<?= F1_THEME_ASSET_URL . "images/partials/logo.png" ?>" width="150"/>
                </div>

                <div>
                    <div class="uk-inline">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="receiver"></span>
                        <input id="f1_user_phone_number" type="tel" maxlength="10" class="uk-input uk-border-pill f1-ltr uk-form-width-large f1-border-2" placeholder="9121234567">
                    </div>
                </div>

                <div>
                    <button id="f1_login_or_register" type="button" class="uk-button uk-button-primary f1-button-spinner-hide uk-border-pill">
                        <span>ورود/ثبت نام</span>
                        <i uk-spinner="ratio: 0.8"></i>
                    </button>
                </div>

            </div>

        </div>

        <div>
            <a href="<?= home_url() ?>" type="button" class="uk-button uk-button-link uk-text-primary uk-text-bold">بازگشت به سایت</a>
        </div>

    </div>

</section>

<?php get_footer() ?>