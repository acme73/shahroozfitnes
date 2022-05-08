<!--

support new ticket

-->

<?php

/**
 * @var $current_user
 * @var $tickets
 * @var $users
 */

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

        <div class="uk-card uk-card-small uk-card-default uk-card-body f1-border-radius-10">

            <div class="uk-child-width-1-3 uk-grid">
                <div>
                    <div class="uk-margin">
                        <label class="uk-form-label">بخش و دپارتمان</label>
                        <select id="f1_ticket_department" class="uk-select uk-border-pill f1-border-2">
                            <option selected>انتخاب بخش مورد نظر</option>
                            <option value="1">پشتيبانی فنی</option>
                            <option value="2">انتقادات و پیشنهادات</option>
                            <option value="3">شکایات</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="uk-margin">
                        <label class="uk-form-label">اهمیت</label>
                        <select id="f1_ticket_priority" class="uk-select uk-border-pill f1-border-2">
                            <option value="1">کم</option>
                            <option value="2" selected>متوسط</option>
                            <option value="3">زیاد</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">موضوع</label>
                <input id="f1_ticket_subject" class="uk-input uk-border-pill f1-border-2" type="text">
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">پیام</label>
                <textarea id="f1_ticket_messages" class="uk-textarea uk-resize-vertical f1-border-2" rows="3"></textarea>
            </div>

            <div class="uk-margin uk-margin-large-bottom">
                <button id="f1_new_ticket_submit" type="button" class="uk-button uk-button-primary uk-button-small uk-border-pill uk-float-left f1-button-spinner-hide">
                    <span>ارسال تیکت</span>
                    <i uk-spinner="ratio: 0.8"></i>
                </button>
            </div>

        </div>

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>

