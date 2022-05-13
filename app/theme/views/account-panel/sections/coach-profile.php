<!--

coach profile

-->

<?php

/**
 * @var $coach_property
 * @var $current_user
 * @var $tickets
 * @var $users
 */

use App\theme\services\CoachUserMeta;
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

            <div class="uk-width-auto@m">
                <div style="position: sticky;top: 60px" class="uk-card uk-card-small uk-text-small uk-card-default uk-card-body f1-border-radius-10">
                    <div class="uk-margin-small">
                        <label class="uk-form-label">وضعیت حساب کاربری</label>
						<?php switch ( CoachUserMeta::get_coach_property( get_current_user_id() )['coach_status'] ) {
							case "1":
								echo '<input class="uk-input uk-form-small uk-form-success" type="reset" value="فعال">';
								break;
							case "2":
								echo '<input class="uk-input uk-form-small uk-form-danger" type="reset" value="بازبینی مدیریت">';
								break;
							case "3":
								echo '<input class="uk-input uk-form-small uk-form-danger" type="reset" value="ویرایش کاربر">';
								break;
							default :
								echo '<input class="uk-input uk-form-small uk-form-danger" type="reset" value="غیرفعال">';
						} ?>
                    </div>
                    <hr>
                    <div class="uk-margin-small">
                        <button id="f1_coach_profile_submit" class="uk-button uk-form-small f1-button-spinner-hide uk-width-1-1 uk-button-primary uk-border-pill">
                            <span>بروزرسانی اطلاعات</span>
                            <i uk-spinner="ratio: 0.8"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="uk-width-expand@m">

                <!--Coach Alert-->
				<?php if ( CoachUserMeta::get_coach_property( get_current_user_id() )['coach_status'] === "3" ): ?>
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p><?php echo str_replace( "\n", "<br>", CoachUserMeta::get_coach_property( get_current_user_id() )['coach_alert'] ) ?></p>
                    </div>
				<?php endif; ?>
                <!--/Coach Alert-->

                <!--User Account-->
                <div class="uk-card uk-card-small uk-card-default f1-border-radius-10">

                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">مشخصات کاربری</h6>
                    </div>

                    <div class="uk-card-body">

                        <div uk-grid>

                            <!--Display Name-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">نام و نام خانوادگی</label>
                                <input class="uk-input uk-border-pill f1-border-2" value="<?= wp_get_current_user()->display_name ?>" disabled>
                            </div>
                            <!--/Display Name-->

                            <!--Phone Number-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">شماره موبایل</label>
                                <input class="uk-input uk-border-pill f1-border-2" value="<?= NumberConvert::convert2persian( wp_get_current_user()->user_login ) ?>" disabled>
                            </div>
                            <!--/Phone Number-->

                            <!--Email-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">ایمیل</label>
                                <input class="uk-input uk-border-pill f1-border-2" value="<?= wp_get_current_user()->user_email ?>" disabled>
                            </div>
                            <!--/Email-->
                        </div>

                    </div>

                </div>
                <!--/User Account-->

                <!--Coach Details-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">

                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">مشخصات مربی</h6>
                    </div>

                    <div class="uk-card-body">

                        <div uk-grid>

                            <!--Coach Gender-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">جنسیت مربی</label>
                                <select id="f1_coach_profile_gender" class="uk-select uk-border-pill f1-border-2">
                                    <option value="man" <?php isset( $coach_property['coach_gender'] ) ? selected( $coach_property['coach_gender'], "man" ) : null; ?> >مرد</option>
                                    <option value="woman" <?php isset( $coach_property['coach_gender'] ) ? selected( $coach_property['coach_gender'], "woman" ) : null; ?>>زن</option>
                                </select>
                            </div>
                            <!--/Coach Gender-->

                            <!--Coach BirthDay-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">تولد (سال تولد)</label>
                                <input id="f1_coach_profile_birth" class="uk-input uk-border-pill f1-border-2" type="number" value="<?= $coach_property['coach_birth'] ?? '' ?>">
                            </div>
                            <!--/Coach BirthDay-->

                            <!--Coach Height-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">قد مربی (سانتی متر)</label>
                                <input id="f1_coach_profile_height" class="uk-input uk-border-pill f1-border-2" type="number" value="<?= $coach_property['coach_height'] ?? '' ?>">
                            </div>
                            <!--/Coach Height-->

                            <!--Coach Weight-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">وزن مربی (کیلوگرم)</label>
                                <input id="f1_coach_profile_weight" class="uk-input uk-border-pill f1-border-2" type="number" value="<?= $coach_property['coach_weight'] ?? '' ?>">
                            </div>
                            <!--/Coach Weight-->

                            <!--Coach explanation-->
                            <div class="uk-width-1-3@l">
                                <label class="uk-form-label">معرفی کوتاه</label>
                                <textarea id="f1_coach_profile_explanation" class="uk-textarea uk-resize-vertical f1-border-2" rows="3"><?= $coach_property['coach_explanation'] ?? '' ?></textarea>
                            </div>
                            <!--Coach explanation-->

                        </div>

                    </div>

                </div>
                <!--/Coach Details-->

                <!--Coach Finance-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">

                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">مشخصات مالی</h6>
                    </div>

                    <div class="uk-card-body">

                        <div uk-grid>

                            <!--Coach Gender-->
                            <div class="uk-width-1-1">
                                <label class="uk-form-label">شماره شبا</label>
                                <input id="f1_coach_profile_payment" placeholder="IR123456789012345678901234" class="uk-input uk-border-pill f1-border-2 f1-ltr" type="text" value="<?= $coach_property['coach_payment'] ?? '' ?>">
                            </div>
                            <!--/Coach Gender-->

                        </div>

                    </div>

                </div>
                <!--/Coach Finance-->

                <!--Coach Image-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">

                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">تصویر مربی</h6>
                    </div>

                    <div id="f1_coach_profile_image_container" class="uk-card-body">

						<?php if ( empty( $coach_property['coach_image'] ) ): ?>

                            <div class="uk-alert-danger uk-text-small uk-margin-small" uk-alert>
                                <p><span class="uk-margin-small-left" uk-icon="warning"></span>تصویری که انتخاب میکنید به عنوان تصویر شاخص توسط کاربران قابل رویت است.</p>
                            </div>
                            <div class="uk-alert-danger uk-text-small uk-margin-small" uk-alert>
                                <p><span class="uk-margin-small-left" uk-icon="warning"></span>سایز تصویر عرض 1200 و ارتفاع 800 و یا متناسب با این ابعاد است.</p>
                            </div>
                            <div class="uk-alert-danger uk-text-small uk-margin-small" uk-alert>
                                <p><span class="uk-margin-small-left" uk-icon="warning"></span>فرمت های قابل قبول: jpg,png</p>
                            </div>
                            <div class="uk-alert-danger uk-text-small uk-margin-small" uk-alert>
                                <p><span class="uk-margin-small-left" uk-icon="warning"></span>سایز تصویر شما نباید از 1 مگابایت بیشتر باشد.</p>
                            </div>

                            <div class="uk-margin-small uk-width-1-1" uk-form-custom="target:true">
                                <label class="uk-form-label">آپلود تصویر</label>
                                <input id="f1_coach_profile_image" type="file">
                                <input class="uk-input" type="text" placeholder="یک تصویر انتخاب کنید..." disabled>
                            </div>

						<?php else: ?>

                            <div class="uk-margin-small uk-width-1-1 uk-text-center" uk-lightbox>
                                <a href="<?= $coach_property['coach_image'] ?>">
                                    <img width="400" class="f1-image-upload" src="<?= $coach_property['coach_image'] ?>" alt="coach_image">
                                </a>
                            </div>

                            <div class="uk-margin-small uk-width-1-1 uk-text-center">
                                <button id="f1_coach_profile_image_remove" class="uk-button-primary uk-button uk-border-pill f1-button-spinner-hide">
                                    <span uk-icon="trash"></span>
                                    <span>حذف تصویر</span>
                                    <i uk-spinner="ratio: 1"></i>
                                </button>
                            </div>

						<?php endif; ?>

                    </div>
                </div>
                <!--/Coach Image-->

                <!--Coach Branch-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">
                    <div class="uk-card-header">
                        <h6 class="uk-heading-bullet">مهارت های مربی</h6>
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-margin-small">
                            <span uk-tooltip="برای انتخاب چند گزینه دکمه <kbd>Ctrl</kbd> روی کیبرد را نگه دارید" class="uk-margin-small-right uk-margin-small-bottom" uk-icon="icon: question; ratio: 0.9"></span>
                            <select id="f1_coach_profile_branch" class="uk-select uk-text-small" multiple>
								<?php $sports_branches = new WP_Term_Query( [ 'taxonomy' => 'sports_branches', 'hide_empty' => false ] ); ?>
								<?php foreach ( $sports_branches->terms as $branch ): ?>
                                    <option value="<?= $branch->term_id ?>"
										<?php if ( isset( $coach_property['coach_branch'] ) ):
											foreach ( $coach_property['coach_branch'] as $value ):
												selected( $value, $branch->term_id );
											endforeach;
										endif; ?>><?= $branch->name ?>
                                    </option>
								<?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--/Coach Branch-->

                <!--Coach Information-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">
                    <div class="uk-card-header uk-flex-middle">
                        <h6 class="uk-heading-bullet uk-margin-remove uk-float-right">اطلاعات مربی</h6>
                        <button id="f1_coach_information_new_record" uk-tooltip="اضافه کردن فیلد جدید" class="uk-float-left" uk-icon="plus-circle"></button>
                    </div>
                    <div class="uk-card-body">
                        <div id="f1_coach_information_container">
							<?php if ( isset( $coach_property['coach_information'] ) ): ?>
								<?php foreach ( $coach_property['coach_information'] as $value ): ?>
                                    <div class="uk-flex uk-flex-middle uk-margin-small-bottom f1-border-1 f1-border-solid f1-border-c3c4c7 uk-padding-small f1-background-f5f5f5" id="container">
                                        <div class="uk-width-1-4 uk-margin-small-left">
                                            <select class="uk-select uk-border-pill f1-border-2">
                                                <option value="certificate" <?php selected( $value['type_info'], "certificate" ); ?>>مدارک ها</option>
                                            </select>
                                        </div>
                                        <div class="uk-width-expand uk-margin-small-left">
                                            <input class="uk-input uk-border-pill f1-border-2" type="text" placeholder="توضیحات" value="<?= $value['desc_info'] ?>">
                                        </div>
                                        <div class="uk-width-auto">
                                            <span class="f1-cursor-pointer" id="f1_coach_information_remove_filed" uk-icon="trash"></span>
                                            <span class="f1-cursor-move" id="f1_coach_information_move_filed" uk-icon="move"></span>
                                        </div>
                                    </div>
								<?php endforeach; ?>
							<?php endif; ?>
                        </div>
                        <div class="uk-text-center">
                            <button id="f1_coach_information_new_record" class="uk-button uk-button-secondary uk-border-pill">
                                <span uk-icon="plus-circle"></span>
                                اضافه کردن فیلد جدید
                            </button>
                        </div>
                    </div>
                </div>
                <!--/Coach Information-->

                <!--Coach Prices-->
                <div class="uk-card uk-card-small uk-card-default uk-margin-small-top f1-border-radius-10">
                    <div class="uk-card-header uk-flex-middle">
                        <h6 class="uk-heading-bullet uk-margin-remove uk-float-right">قیمت های مربی</h6>
                        <button id="f1_coach_prices_new_record" uk-tooltip="اضافه کردن فیلد جدید" class="uk-float-left" uk-icon="plus-circle"></button>
                    </div>
                    <div class="uk-card-body">
                        <div id="f1_coach_prices_container">
							<?php if ( isset( $coach_property['coach_program_prices'] ) ): ?>
								<?php foreach ( $coach_property['coach_program_prices'] as $value ): ?>
                                    <div class="uk-flex uk-flex-middle uk-margin-small-bottom f1-border-1 f1-border-solid f1-border-c3c4c7 uk-padding-small f1-background-f5f5f5" id="container">
                                        <div class="uk-width-1-4 uk-margin-small-left">
                                            <select class="uk-select uk-border-pill f1-border-2">
                                                <option value="practice_food" <?php selected( $value['type_service'], "practice_food" ); ?>>طراحی تمرین و تغذیه</option>
                                                <option value="professional_consultation" <?php selected( $value['type_service'], "professional_consultation" ); ?>>مشاوره تخصصی</option>
                                            </select>
                                        </div>
                                        <div class="uk-width-expand uk-margin-small-left">
                                            <input class="uk-input uk-border-pill f1-border-2" type="number" placeholder="قیمت دریافت برنامه به تومان" value="<?= $value['program_price'] ?>">
                                        </div>
                                        <div class="uk-width-auto">
                                            <span class="f1-cursor-pointer" id="f1_coach_prices_remove_filed" uk-icon="trash"></span>
                                            <span class="f1-cursor-move" id="f1_coach_prices_move_filed" uk-icon="move"></span>
                                        </div>
                                    </div>
								<?php endforeach; ?>
							<?php endif; ?>
                        </div>
                        <div class="uk-text-center">
                            <button id="f1_coach_prices_new_record" class="uk-button uk-button-secondary uk-border-pill">
                                <span uk-icon="plus-circle"></span>
                                اضافه کردن فیلد جدید
                            </button>
                        </div>
                    </div>
                </div>
                <!--/Coach Prices-->

            </div>

        </div>

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>
