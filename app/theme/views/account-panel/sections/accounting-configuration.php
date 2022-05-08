<!--

accounting configuration in administrator

-->

<?php

/**
 * @var $current_user
 * @var $tickets
 * @var $users
 */


use App\theme\services\SettingOptions;
use App\utils\View;

?>

<?php get_header(); ?>

<!--header-->
<?php View::render( "app.theme.views.account-panel.partials.header", [
	"current_user" => $current_user,
	"tickets"      => $tickets,
	"users"        => $users,
] ); ?>


<!--sidebar-->
<?php View::render( "app.theme.views.account-panel.partials.sidebar", [
	"current_user" => $current_user,
	"tickets"      => $tickets,
	"users"        => $users,
] ); ?>

<!-- regionCONTENT -->
<div class="f1-account-content" uk-height-viewport="expand: true">

    <div class="uk-container uk-container-expand uk-margin-large-bottom">

        <!--Setting Finance-->
        <div class="uk-card uk-card-small uk-card-default f1-border-radius-10">

            <div class="uk-card-header">
                <h6 class="uk-heading-bullet">تنظیمات مالی</h6>
            </div>

            <div class="uk-card-body">
                <div class="uk-margin-small">
                    <label class="uk-form-label">درصد سایت</label>
                    <input id="f1_percent_site" class="uk-input uk-border-pill f1-border-2" type="number" value="<?= SettingOptions::get_settings()['percent_site'] ?>">
                </div>
            </div>

            <div class="uk-card-footer">
                <div class="uk-margin uk-float-left">
                    <button id="f1_setting_finance_submit" class="uk-button uk-button-small uk-button-primary uk-border-pill f1-button-spinner-hide">
                        <span>بروزرسانی</span>
                        <i uk-spinner="ratio: 0.8"></i>
                    </button>
                </div>
            </div>

        </div>
        <!--/Setting Finance-->

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>