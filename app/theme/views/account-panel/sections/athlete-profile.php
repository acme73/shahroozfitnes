<!--

athlete profile

-->

<?php

/**
 * @var $athlete_property
 * @var $current_user
 * @var $tickets
 * @var $users
 */

use App\utils\NumberConvert;
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

    <div class="uk-container uk-container-expand">

        <div uk-grid>

            <div class="uk-width-1-4@m">
                <div style="position: sticky;top: 60px" class="uk-card uk-card-small uk-text-small uk-card-default uk-card-body f1-border-radius-10">
                    <div class="uk-margin-small">
                        <button id="f1_athlete_profile_submit" class="uk-button uk-form-small f1-button-spinner-hide uk-width-1-1 uk-button-primary uk-border-pill">
                            <span>بروزرسانی اطلاعات</span>
                            <i uk-spinner="ratio: 0.8"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="uk-width-expand@m">

                <!--Athlete Body-->
                <div class="uk-card uk-card-small uk-card-default uk-card-body f1-border-radius-10">

                    <ul uk-tab>
                        <li><a href="#">نمودار وزن</a></li>
                        <li><a href="#">نمودار قد</a></li>
                        <li><a href="#">ثبت اطلاعات جدید</a></li>
                    </ul>

                    <ul class="uk-switcher uk-margin">

                        <li id="f1_chart_weight_container" style="position: relative;height: 300px;margin: 0 auto;">
                            <canvas id="f1_chart_weight"></canvas>
                        </li>

                        <li id="f1_chart_height_container" style="position: relative;height: 300px;margin: 0 auto;">
                            <canvas id="f1_chart_height"></canvas>
                        </li>

                        <li>

                            <div class="uk-alert-success uk-margin-small" uk-alert>
                                <p class="uk-text-small">ورزشکار عزیز شما باید هر 30 روز یک بار نسبت به ثبت اطلاعات خود اقدام کنید</p>
                            </div>

                            <div class="uk-alert-success uk-margin-small" uk-alert>
                                <p class="uk-text-small">با وارد کردن اطلاعات خود به صورت منظم میتوانید مراحل پیشرفتان را به وسیله نمودار ها مورد بررسی قرار دهید</p>
                            </div>

                            <div uk-grid>

                                <div class="uk-width-1-3@m">
                                    <label class="uk-form-label">قد</label>
                                    <input type="number" id="f1_athlete_body_height" class="uk-input" step="0.01" placeholder="قد خود را به سانتی متر وارد کنید">
                                </div>

                                <div class="uk-width-1-3@m">
                                    <label class="uk-form-label">وزن</label>
                                    <input type="number" id="f1_athlete_body_weight" class="uk-input" step="0.01" placeholder="وزن خود را به کیلوگرم وارد کنید">
                                </div>

                            </div>

                            <div class="uk-margin">
                                <button id="f1_athlete_body_submit" type="button" class="uk-button uk-border-pill uk-button-small f1-button-spinner-hide uk-button-primary uk-float-left">
                                    <span>ثبت اطلاعات</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>

                        </li>

                    </ul>

                </div>
                <!--/Athlete Body-->

                <!--User Account-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">

                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">مشخصات کاربری</h6>
                    </div>

                    <div class="uk-card-body">

                        <div uk-grid>

                            <!--Display Name-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">نام و نام خانوادگی</label>
                                <input class="uk-input" value="<?= wp_get_current_user()->display_name ?>" disabled>
                            </div>
                            <!--/Display Name-->

                            <!--Phone Number-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">شماره موبایل</label>
                                <input class="uk-input" value="<?= NumberConvert::convert2persian( wp_get_current_user()->user_login ) ?>" disabled>
                            </div>
                            <!--/Phone Number-->

                            <!--Email-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">ایمیل</label>
                                <input class="uk-input" value="<?= wp_get_current_user()->user_email ?>" disabled>
                            </div>
                            <!--/Email-->

                        </div>
                    </div>
                </div>
                <!--/User Account-->

                <!--Athlete Details-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">

                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">مشخصات ورزشکار</h6>
                    </div>

                    <div class="uk-card-body">

                        <div uk-grid>

                            <!--Athlete Gender-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">جنسیت ورزشکار</label>
                                <select id="f1_athlete_profile_gender" class="uk-select">
                                    <option value="man" <?php isset( $athlete_property['athlete_gender'] ) ? selected( $athlete_property['athlete_gender'], "man" ) : null ?> >مرد</option>
                                    <option value="woman" <?php isset( $athlete_property['athlete_gender'] ) ? selected( $athlete_property['athlete_gender'], "woman" ) : null ?>>زن</option>
                                </select>
                            </div>
                            <!--/Athlete Gender-->

                            <!--Athlete BirthDay-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">تولد (سال تولد)</label>
                                <input id="f1_athlete_profile_birth" class="uk-input" type="number" value="<?= $athlete_property['athlete_birth'] ?? '' ?>">
                            </div>
                            <!--/Athlete BirthDay-->

                        </div>

                    </div>

                </div>
                <!--/Athlete Details-->

            </div>

        </div>

    </div>

</div>
<!-- endregion -->

<?php get_footer(); ?>
