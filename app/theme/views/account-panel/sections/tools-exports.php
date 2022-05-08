<!--

tools exports in administrator

-->

<?php

/**
 * @var $current_user
 * @var $tickets
 * @var $users
 **/

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

        <div class="uk-card uk-card-small uk-card-default f1-border-radius-10">
            <div class="uk-card-header">
                <h6 class="uk-heading-bullet">خروجی گرفتن کاربران</h6>
            </div>
            <div class="uk-card-body">
                <form method="post">
                    <div class="uk-margin-small">
                        <label class="uk-form-label">سمت کاربر</label>
                        <select name="f1_role_user" class="uk-select uk-border-pill f1-border-2">
                            <option value="any">همهء کاربران</option>
                            <option value="coach">مربیان</option>
                            <option value="athlete">ورزشکاران</option>
                        </select>
                    </div>
                    <div class="uk-margin-small">
                        <button name="f1_download_csv_users" type="submit" class="uk-button uk-float-left uk-button-primary uk-border-pill">
                            <span uk-icon="download"></span>
                            <span>دانلود فایل</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
<!-- endregion -->

<?php get_footer(); ?>