<!--

manage coach in administrator

-->

<?php

/**
 * @var $current_user
 * @var $tickets
 * @var $users
 * @var $max_count_page ,
 * @var $per_page ,
 * @var $offset ,
 * @var $coach_status ,
 * @var $coach_balance ,
 * @var $finance_settlement ,
 * @var $query_var ,
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

        <!--Filter-->
        <form class="uk-margin-small" method="get">

            <div class="uk-flex-middle" uk-grid>

                <div class="uk-width-1-4@m">
                    <select name="coach_status" class="uk-select uk-form-small uk-border-pill f1-border-2">
                        <option value="all" selected>مشاهده همه</option>
                        <option value="1" <?php isset( $query_var['coach_status'] ) ? selected( $query_var['coach_status'], "1" ) : null ?>>فعال</option>
                        <option value="2" <?php isset( $query_var['coach_status'] ) ? selected( $query_var['coach_status'], "2" ) : null ?>>بازبینی مدیریت</option>
                        <option value="3" <?php isset( $query_var['coach_status'] ) ? selected( $query_var['coach_status'], "3" ) : null ?>>ویرایش کاربر</option>
                        <option value="0" <?php isset( $query_var['coach_status'] ) ? selected( $query_var['coach_status'], "0" ) : null ?>>غیرفعال</option>
                    </select>
                </div>

                <div class="uk-width-1-4@m">
                    <select name="per_page" class="uk-select uk-form-small uk-border-pill f1-border-2">
                        <option value="10" selected <?php isset( $query_var['per_page'] ) ? selected( $query_var['per_page'], "10" ) : null ?>>10</option>
                        <option value="20" <?php isset( $query_var['per_page'] ) ? selected( $query_var['per_page'], "20" ) : null ?>>20</option>
                        <option value="30" <?php isset( $query_var['per_page'] ) ? selected( $query_var['per_page'], "30" ) : null ?>>30</option>
                        <option value="40" <?php isset( $query_var['per_page'] ) ? selected( $query_var['per_page'], "40" ) : null ?>>40</option>
                        <option value="50" <?php isset( $query_var['per_page'] ) ? selected( $query_var['per_page'], "50" ) : null ?>>50</option>
                    </select>
                </div>

                <div class="uk-width-expand@m">
                    <button type="submit" class="uk-button uk-button-primary uk-border-pill uk-button-small uk-float-left">فیلتر کن</button>
                </div>

            </div>

        </form>
        <!--/Filter-->

        <!--Coach List-->
        <div class="uk-card uk-padding-remove uk-card-default uk-card-body f1-border-radius-10">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-condensed uk-text-nowrap uk-table-middle">
                    <thead>
                    <tr>
                        <th class="uk-table-shrink">آیدی مربی</th>
                        <th class="uk-width-small">نام مربی</th>
                        <th class="uk-width-small">وضعیت مربی</th>
                        <th class="uk-width-small">نمایش در سایت</th>
                        <th class="uk-width-small">موجودی(تومان)</th>
                        <th class="uk-table-expand"></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td class="uk-table-shrink">آیدی مربی</td>
                        <td class="uk-width-small">نام مربی</td>
                        <td class="uk-width-small">وضعیت مربی</td>
                        <td class="uk-width-small">نمایش در سایت</td>
                        <td class="uk-width-small">موجودی(تومان)</td>
                        <td class="uk-table-expand"></td>
                    </tr>
                    </tfoot>
                    <tbody>
					<?php foreach ( $users->get_all_coach_for_manage( $offset, $per_page, $coach_status ) as $value ): ?>
                        <tr>
                            <td class="uk-text-small"><span uk-icon="icon: hashtag; ratio: 0.8"></span><?= $value->ID ?></td>
                            <td class="uk-text-small"><?= get_user_by( 'ID', $value->ID )->display_name ?></td>
                            <td class="uk-text-small"><?php switch ( CoachUserMeta::get_coach_property( $value->ID )['coach_status'] ) {
									case "1":
										echo "<span class='uk-label uk-label-success'>فعال</span>";
										break;
									case "2":
										echo "<span class='uk-label uk-label-danger'>بازبینی مدیریت</span>";
										break;
									case "3":
										echo "<span class='uk-label uk-label-danger'>ویرایش کاربر</span>";
										break;
									default :
										echo "<span class='uk-label uk-label-danger'>غیرفعال</span>";
								} ?></td>
                            <td class="uk-text-small">
								<?php
								$coach_post_type = 'no_publish';
								if ( isset( CoachUserMeta::get_coach_property( $value->ID )['post_id'] ) ) {
									$coach_post_type = get_post( CoachUserMeta::get_coach_property( $value->ID )['post_id'] )->post_status;
								}
								switch ( $coach_post_type ) {
									case "publish":
										echo "<span class='uk-label uk-label-success'>بله</span>";
										break;
									default:
										echo "<span class='uk-label uk-label-danger'>خیر</span>";
										break;
								} ?>
                            </td>
                            <td class="uk-text-small">
								<?php
								$balance                  = $coach_balance->get_balance( $value->ID );
								$coach_finance_settlement = $finance_settlement->get_finance_settlement( $value->ID );
								$balance                  = intval( $balance ) - intval( $coach_finance_settlement );
								echo NumberConvert::convert2persian( $balance, true )
								?>
                            </td>
                            <td class="uk-float-left">
								<?php if ( isset( CoachUserMeta::get_coach_property( $value->ID )['post_id'] ) && CoachUserMeta::get_coach_property( $value->ID )['coach_status'] === "1" ): ?>
                                    <button class="uk-icon-button" uk-toggle="target: <?= "#finance_settlement_modal_" . $value->ID ?>" uk-tooltip="تصفیه حساب" uk-icon="icon: credit-card; ratio: 1.1" uk-toggle></button>
								<?php endif; ?>
								<?php if ( isset( CoachUserMeta::get_coach_property( $value->ID )['post_id'] ) ): ?>
                                    <button class="uk-icon-button" uk-toggle="target: <?= "#post_status_modal_" . $value->ID ?>" uk-tooltip="نمایش در سایت" uk-icon="icon: world; ratio: 1.1" uk-toggle></button>
								<?php endif; ?>
								<?php if ( in_array( CoachUserMeta::get_coach_property( $value->ID )['coach_status'], [ "1", "2", "3" ] ) ): ?>
                                    <button class="uk-icon-button" uk-toggle="target: <?= "#coach_status_modal_" . $value->ID ?>" uk-tooltip="تغییر وضعیت" uk-icon="icon: bolt; ratio: 1.1"></button>
								<?php endif; ?>
                                <button class="uk-icon-button" uk-toggle="target: <?= "#coach_property_modal_" . $value->ID ?>" uk-tooltip="اطلاعات <?= get_user_by( 'ID', $value->ID )->display_name ?>" uk-icon="icon: info; ratio: 1.1" uk-toggle></button>
                            </td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/Coach List-->

        <!--Modal-->
		<?php foreach ( $users->get_all_coach_for_manage( $offset, $per_page, $coach_status ) as $value ): ?>

            <div id="<?= "coach_property_modal_" . $value->ID ?>" uk-modal>
                <div class="uk-modal-dialog">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    <div class="uk-modal-header">
                        <h5 class="uk-heading-bullet"> <?= "اطلاعات " . get_user_by( 'ID', $value->ID )->display_name ?></h5>
                    </div>
                    <div class="uk-modal-body" uk-overflow-auto>

                        <!--Coach Image-->
                        <div class="uk-margin uk-text-center" uk-lightbox>
							<?php if ( empty( CoachUserMeta::get_coach_property( $value->ID )['coach_image'] ) ): ?>
                                <div style="width: 300px" class="f1-image-upload uk-padding-small">
                                    <span uk-icon="icon: warning; ratio: 1.3"></span>
                                    <span>بدون تصویر</span>
                                </div>
							<?php else: ?>
                                <a href="<?= CoachUserMeta::get_coach_property( $value->ID )['coach_image'] ?>">
                                    <img class="f1-image-upload" width="300" src="<?= CoachUserMeta::get_coach_property( $value->ID )['coach_image'] ?>" alt="coach_image">
                                </a>
							<?php endif; ?>
                        </div>
                        <hr>
                        <!--/Coach Image-->

                        <!--Coach Bio-->
                        <div class="uk-grid uk-grid-medium uk-grid-column-small uk-child-width-1-2@m ">
                            <div>
                                <!--Coach Name-->
                                <label class="uk-form-label uk-text-meta">نام و نام خانوادگی</label>
                                <input class="uk-input uk-form-small" type="text" value="<?= get_user_by( 'ID', $value->ID )->display_name ?>" disabled>
                                <!--/Coach Name-->
                            </div>
                            <div>
                                <!--Coach Mobile-->
                                <label class="uk-form-label uk-text-meta">شماره موبایل</label>
                                <input class="uk-input uk-form-small" type="text" value="<?= get_user_by( 'ID', $value->ID )->user_login ?>" disabled>
                                <!--/Coach Mobile-->
                            </div>
                            <div>
                                <!--Coach Email-->
                                <label class="uk-form-label uk-text-meta">ایمیل</label>
                                <input class="uk-input uk-form-small" type="text" value="<?= get_user_by( 'ID', $value->ID )->user_email ?>" disabled>
                                <!--/Coach Email-->
                            </div>
                            <div>
                                <!--Coach Gender-->
                                <label class="uk-form-label uk-text-meta">جنسیت</label>
                                <input class="uk-input uk-form-small" type="text" value="<?php
								if ( isset( CoachUserMeta::get_coach_property( $value->ID )['coach_gender'] ) ) {
									switch ( CoachUserMeta::get_coach_property( $value->ID )['coach_gender'] ) {
										case "man" :
											echo "مرد";
											break;
										case "woman" :
											echo "زن";
											break;
									}
								}
								?>" disabled>
                                <!--/Coach Gender-->
                            </div>
                            <div>
                                <!--Coach Birth-->
                                <label class="uk-form-label uk-text-meta">سال تولد</label>
                                <input class="uk-input uk-form-small" type="text" value="<?php
								if ( isset( CoachUserMeta::get_coach_property( $value->ID )['coach_birth'] ) ) {
									echo CoachUserMeta::get_coach_property( $value->ID )['coach_birth'];
								}
								?>" disabled>
                                <!--/Coach Birth-->
                            </div>
                            <div>
                                <!--Coach Height-->
                                <label class="uk-form-label uk-text-meta">قد مربی</label>
                                <input class="uk-input uk-form-small" type="text" value="<?php
								if ( isset( CoachUserMeta::get_coach_property( $value->ID )['coach_height'] ) ) {
									echo CoachUserMeta::get_coach_property( $value->ID )['coach_height'];
								}
								?>" disabled>
                                <!--/Coach Height-->
                            </div>
                            <div>
                                <!--Coach Weight-->
                                <label class="uk-form-label uk-text-meta">وزن مربی</label>
                                <input class="uk-input uk-form-small" type="text" value="<?php
								if ( isset( CoachUserMeta::get_coach_property( $value->ID )['coach_weight'] ) ) {
									echo CoachUserMeta::get_coach_property( $value->ID )['coach_weight'];
								}
								?>" disabled>
                                <!--/Coach Weight-->
                            </div>
                            <div>
                                <!--Coach Payment-->
                                <label class="uk-form-label uk-text-meta">شماره شبا</label>
                                <input class="uk-input uk-form-small" type="text" value="<?php
								if ( isset( CoachUserMeta::get_coach_property( $value->ID )['coach_payment'] ) ) {
									echo CoachUserMeta::get_coach_property( $value->ID )['coach_payment'];
								}
								?>" disabled>
                                <!--/Coach Payment-->
                            </div>
                            <div>
                                <!--Coach Explanation-->
                                <label class="uk-form-label uk-text-meta">معرفی کوتاه</label>
                                <textarea id="f1_coach_profile_explanation" class="uk-textarea uk-resize-vertical f1-border-2" rows="3" disabled><?php
									if ( isset( CoachUserMeta::get_coach_property( $value->ID )['coach_explanation'] ) ) {
										echo CoachUserMeta::get_coach_property( $value->ID )['coach_explanation'];
									}
									?></textarea>
                                <!--/Coach Explanation-->
                            </div>
                        </div>
                        <hr>
                        <!--/Coach Bio-->

                        <!--Coach Branch-->
						<?php if ( ! empty( CoachUserMeta::get_coach_property( $value->ID )['coach_branch'] ) ): ?>
                            <div class="uk-margin">
                                <label class="uk-form-label uk-text-meta">مهارت های مربی</label>
                                <br/>
								<?php $sports_branches = new WP_Term_Query( [ 'taxonomy' => 'sports_branches', 'hide_empty' => false ] ); ?>
								<?php foreach ( CoachUserMeta::get_coach_property( $value->ID )['coach_branch'] as $item ): ?>
									<?php foreach ( $sports_branches->terms as $branch ): ?>
										<?php if ( intval( $branch->term_id ) === intval( $item ) ): ?>
                                            <span class="uk-label"><?= $branch->name ?></span>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endforeach; ?>
                            </div>
                            <hr>
						<?php endif; ?>
                        <!--/Coach Branch-->

                        <!--Coach Information-->
						<?php if ( ! empty( CoachUserMeta::get_coach_property( $value->ID )['coach_information'] ) ): ?>
                            <label class="uk-form-label uk-text-meta">اطلاعات اضافی</label>
							<?php foreach ( CoachUserMeta::get_coach_property( $value->ID )['coach_information'] as $info ): ?>
                                <div class="uk-margin-small" uk-grid>
                                    <div class="uk-width-1-3">
                                        <input class="uk-input uk-form-small" value="<?php switch ( $info['type_info'] ) {
											case "certificate":
												echo "مدارک ها";
												break;
										} ?>" disabled>
                                    </div>
                                    <div class="uk-width-expand">
                                        <input class="uk-input uk-form-small" value="<?= $info['desc_info'] ?>" disabled>
                                    </div>
                                </div>
							<?php endforeach; ?>
                            <hr>
						<?php else: ?>
                            <div class="uk-margin">
                                <input class="uk-input uk-form-danger" type="reset" value="بدون اطلاعات اضافی">
                            </div>
						<?php endif; ?>
                        <!--/Coach Information-->

                        <!--Coach Prices-->
						<?php if ( ! empty( CoachUserMeta::get_coach_property( $value->ID )['coach_program_prices'] ) ): ?>
                            <label class="uk-form-label uk-text-meta">قیمت برنامه</label>
							<?php foreach ( CoachUserMeta::get_coach_property( $value->ID )['coach_program_prices'] as $program ): ?>
                                <div class="uk-margin-small" uk-grid>
                                    <div class="uk-width-1-3">
                                        <input class="uk-input uk-form-small" value="<?php switch ( $program['type_service'] ) {
											case "practice_food":
												echo "طراحی تمرین و تغذیه";
												break;
											case "professional_consultation":
												echo "مشاوره تخصصی";
												break;
										} ?>" disabled>
                                    </div>
                                    <div class="uk-width-expand">
                                        <input class="uk-input uk-form-small" value="<?= $program['program_price'] ?>" disabled>
                                    </div>
                                </div>
							<?php endforeach; ?>
						<?php else: ?>
                            <div class="uk-margin">
                                <input class="uk-input uk-form-danger" type="reset" value="بدون ارائه قیمت">
                            </div>
						<?php endif; ?>
                        <!--/Coach Prices-->

                    </div>
                </div>
            </div>

			<?php if ( in_array( CoachUserMeta::get_coach_property( $value->ID )['coach_status'], [ "1", "2", "3" ] ) ): ?>
                <div id="<?= "coach_status_modal_" . $value->ID ?>" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-default" type="button" uk-close></button>

                        <div class="uk-modal-header">
                            <h5 class="uk-heading-bullet"><?= "تغییر وضعیت: " . get_user_by( 'ID', $value->ID )->display_name ?></h5>
                        </div>

                        <div class="uk-modal-body">

                            <div class="uk-margin">
                                <div class="uk-form-label uk-margin-small">انتخاب وضعیت کاربر</div>
                                <select id="<?= 'f1_coach_status_' . $value->ID ?>" class="uk-select uk-border-pill f1-border-2">
                                    <option>یک حالت را انتخاب کنید</option>
                                    <option value="1">فعال</option>
                                    <option value="3">ویرایش کاربر</option>
                                </select>
                            </div>

                            <div class="uk-margin uk-hidden">
                                <label class="uk-form-label">توضیحات</label>
                                <textarea id="<?= 'f1_coach_alert_' . $value->ID ?>" class="uk-textarea uk-resize-vertical f1-border-2"></textarea>
                            </div>

                        </div>

                        <div class="uk-modal-footer">
                            <div class="uk-margin uk-float-left">
                                <button id="<?= 'f1_coach_status_submit_' . $value->ID ?>" class="uk-button uk-button-small uk-button-primary uk-border-pill f1-button-spinner-hide">
                                    <span>بروزرسانی</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
			<?php endif; ?>

			<?php if ( isset( CoachUserMeta::get_coach_property( $value->ID )['post_id'] ) ): ?>
                <div id="<?= "post_status_modal_" . $value->ID ?>" uk-modal>
                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h5 class="uk-heading-bullet"><?= "نمایش در سایت: " . get_user_by( 'ID', $value->ID )->display_name ?></h5>
                        </div>

                        <div class="uk-modal-body">

                            <div class="uk-margin">
                                <label class="uk-form-label">نمایش در سایت</label>
                                <select id="<?= 'f1_post_status_' . $value->ID ?>" class="uk-select">
                                    <option>یک حالت را انتخاب کنید</option>
                                    <option value="1">بله</option>
                                    <option value="0">خیر</option>
                                </select>
                            </div>

                        </div>

                        <div class="uk-modal-footer">
                            <div class="uk-margin uk-float-left">
                                <button id="<?= 'f1_post_status_submit_' . $value->ID ?>" class="uk-button uk-button-small uk-button-primary uk-border-pill f1-button-spinner-hide">
                                    <span>بروزرسانی</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
			<?php endif; ?>

			<?php if ( isset( CoachUserMeta::get_coach_property( $value->ID )['post_id'] ) && CoachUserMeta::get_coach_property( $value->ID )['coach_status'] === "1" ): ?>
                <div id="<?= "finance_settlement_modal_" . $value->ID ?>" uk-modal>

                    <div class="uk-modal-dialog">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <div class="uk-modal-header">
                            <h5 class="uk-heading-bullet"><?= "تصفیه حساب: " . get_user_by( 'ID', $value->ID )->display_name ?></h5>
                        </div>

                        <div class="uk-modal-body">

                            <div class="uk-grid uk-child-width-1-2@s uk-margin-medium uk-flex-middle">

                                <div>
                                    <span>مبلغ قابل پرداخت:</span>
                                </div>

                                <div>
									<?php
									$balance                  = $coach_balance->get_balance( $value->ID );
									$coach_finance_settlement = $finance_settlement->get_finance_settlement( $value->ID );
									$balance                  = intval( $balance ) - intval( $coach_finance_settlement );
									?>
                                    <span class="uk-text-bold uk-text-large uk-text-success"><?= NumberConvert::convert2persian( $balance, true ); ?></span>
                                    <span class="uk-text-small">تومان</span>
                                    <input id="<?= "f1_finance_settlement_amount_" . $value->ID ?>" type="hidden" value="<?= $balance ?>">
                                </div>

                            </div>

                            <div class="uk-grid uk-child-width-1-2@s uk-margin-medium uk-flex-middle">

                                <div>
                                    <span>شماره شبا:</span>
                                </div>

                                <div>
                                    <span><?= CoachUserMeta::get_coach_property( $value->ID )['coach_payment'] ?></span>
                                </div>

                            </div>

                            <div class="uk-grid uk-child-width-1-2@s uk-margin-medium uk-flex-middle">

                                <div>
                                    <span>شماره سند:</span>
                                </div>

                                <div>
                                    <input id="<?= "f1_finance_settlement_dn_" . $value->ID ?>" class="uk-input uk-text-left uk-form-small" type="text">
                                </div>

                            </div>

                        </div>

                        <div class="uk-modal-footer">
                            <div class="uk-margin uk-float-left">
                                <button id="<?= 'f1_finance_settlement_submit_' . $value->ID ?>" class="uk-button uk-button-small uk-button-primary uk-border-pill f1-button-spinner-hide">
                                    <span>پرداخت</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
			<?php endif; ?>

		<?php endforeach; ?>
        <!--Modal-->

        <!--Paging-->
		<?php if ( ceil( $max_count_page / $per_page ) > 1 ): ?>
            <ul class="uk-pagination uk-flex-center uk-margin-large-bottom" uk-margin>
				<?php if ( isset( $query_var['page'] ) && intval( $query_var['page'] ) !== 1 ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $query_var['page'] - 1 ] ) ?>"><span uk-pagination-previous></span></a></li>
				<?php endif; ?>
				<?php for ( $i = 1; $i <= ( ceil( $max_count_page / $per_page ) ); $i ++ ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $i ] ) ?>"><?= $i ?></a></li>
				<?php endfor; ?>
				<?php if ( isset( $query_var['page'] ) && intval( $query_var['page'] ) !== intval( ceil( $max_count_page / $per_page ) ) ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $query_var['page'] + 1 ] ) ?>"><span uk-pagination-next></span></a></li>
				<?php endif; ?>
            </ul>
		<?php endif; ?>
        <!--/Paging-->

    </div>

</div>
<!-- endregion -->

<?php get_footer(); ?>