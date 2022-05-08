<!--

coach order

-->

<?php

/**
 * @var $order
 * @var $transaction_status
 * @var $max_count_page
 * @var $per_page
 * @var $offset
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

        <!--Transaction Status-->
		<?php if ( ! is_null( $transaction_status ) ): ?>

			<?php if ( $transaction_status ): ?>
                <div class="uk-alert-success uk-margin-small" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>پرداخت شما با موفقیت انجام شد</p>
                </div>
			<?php endif; ?>

			<?php if ( ! $transaction_status ): ?>
                <div class="uk-alert-danger uk-margin-small" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>پرداخت شما با خطا مواجعه شد</p>
                </div>
			<?php endif; ?>

		<?php endif; ?>
        <!--/Transaction Status-->

        <!--Orders-->
		<?php if ( count( $order->get_orders_for_athlete( get_current_user_id(), $offset, $per_page ) ) > 0 ): ?>

			<?php foreach ( $order->get_orders_for_athlete( get_current_user_id(), $offset, $per_page ) as $value ): ?>
                <div class="uk-card uk-card-small uk-card-default uk-card-body uk-margin-small f1-border-radius-10">

                    <div uk-grid>

                        <!--Coach Image-->
                        <div class="uk-width-1-4@m">
                            <img class="f1-border-radius-10" src="<?= CoachPostMeta::get_coach_property( CoachUserMeta::get_coach_property( $value->coach_id )["post_id"] )["coach_image"] ?>" alt="coach_image">
                        </div>
                        <!--/Coach Image-->

                        <!--Coach Information-->
                        <div class="uk-width-expand">

                            <div uk-grid>

                                <div class="uk-width-auto">
                                    <p class="uk-heading-bullet uk-text-small">نام مربی:</p>
                                </div>

                                <div class="uk-width-expand">
                                    <p class="uk-text-small uk-float-left"><?= get_user_by( 'ID', $value->coach_id )->display_name ?></p>
                                </div>

                            </div>

                            <div uk-grid>

                                <div class="uk-width-auto">
                                    <p class="uk-heading-bullet uk-text-small">نوع برنامه:</p>
                                </div>

                                <div class="uk-width-expand">
                                    <p class="uk-text-small uk-float-left"><?php switch ( $value->type_program ) {
											case "practice":
												echo "طراحی برنامه تمرینی";
												break;
											case "food":
												echo "طراحی برنامه غذایی";
												break;
										} ?></p>
                                </div>

                            </div>

                            <div uk-grid>

                                <div class="uk-width-auto">
                                    <p class="uk-heading-bullet uk-text-small">وضعیت:</p>
                                </div>

                                <div class="uk-width-expand">
                                    <p class="uk-text-small uk-float-left"><?php switch ( $value->active ) {
											case "0":
												echo "<span class='uk-label uk-label-danger'>غیرفعال</span>";
												break;
											case "1":
												echo "<span class='uk-label uk-label-success'>فعال</span>";
												break;
										} ?></p>
                                </div>

                            </div>

                        </div>
                        <!--/Coach Information-->

                        <!--Options-->
                        <div class="uk-width-expand@s">

                            <div class="uk-grid uk-child-width-auto@s uk-child-width-1-1@s uk-flex-left">

                                <div>

                                    <div>
                                        <button class="uk-button uk-button-primary uk-border-pill uk-margin-small uk-width-1-1" uk-toggle="target: <?= "#chat_coach_modal_" . $value->id ?>" uk-toggle><span class="uk-margin-small-left" uk-icon="icon: comment; ratio: 1.1"></span>گفتگو و مشاوره</button>
                                    </div>

									<?php if ( $value->can_rate ): ?>
                                        <div>
                                            <button class="uk-button uk-button-primary uk-border-pill uk-margin-small uk-width-1-1" uk-toggle="target: <?= "#rate_coach_modal_" . $value->id ?>" uk-toggle><span class="uk-margin-small-left" uk-icon="icon: star; ratio: 1.1"></span>امتیاز دادن</button>
                                        </div>
									<?php endif; ?>

                                </div>

                            </div>

                        </div>
                        <!--/Options-->

                    </div>

                </div>
			<?php endforeach; ?>

		<?php else: ?>

            <div class="uk-flex uk-flex-middle uk-flex-center">
                <p class="uk-text-meta">سفارشی موجود نیست!!</p>
            </div>

		<?php endif; ?>
        <!--/Orders-->

        <!--Paging-->
		<?php if ( ceil( $max_count_page / $per_page ) > 1 ): ?>
            <ul class="uk-pagination uk-flex-center uk-margin-large-bottom" uk-margin>
				<?php if ( isset( $_GET['page'] ) && intval( $_GET['page'] ) !== 1 ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $_GET['page'] - 1 ] ) ?>"><span uk-pagination-previous></span></a></li>
				<?php endif; ?>
				<?php for (
					$i = 1;
					$i <= ( ceil( $max_count_page / $per_page ) );
					$i ++
				): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $i ] ) ?>"><?= $i ?></a></li>
				<?php endfor; ?>
				<?php if ( intval( $_GET['page'] ) !== intval( ceil( $max_count_page / $per_page ) ) ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $_GET['page'] + 1 ] ) ?>"><span uk-pagination-next></span></a></li>
				<?php endif; ?>
            </ul>
		<?php endif; ?>
        <!--/Paging-->

        <!--Modal-->
		<?php foreach ( $order->get_orders_for_athlete( get_current_user_id(), $offset, $per_page ) as $value ): ?>

            <!--Chat Modal-->
            <div id="<?= "chat_coach_modal_" . $value->id ?>" uk-modal="bgClose: false; escClose: false; modal: false; keyboard: false">
                <div class="uk-modal-dialog f1-background-f5f5f5">

                    <button class="uk-modal-close-default" type="button" uk-close></button>

                    <div class="uk-modal-header">
                        <h5 class="uk-heading-bullet"> <?= "مشاوره با " . get_user_by( 'ID', $value->coach_id )->display_name ?></h5>
                    </div>

                    <div class="uk-modal-body f1-scroller" id="<?= "f1_container_coach_chat_" . $value->id ?>" uk-overflow-auto></div>

                    <div class="uk-modal-footer uk-padding-remove">

                        <div class="uk-grid uk-grid-small uk-flex-bottom" uk-grid>

                            <div class="uk-width-expand">
                                <div class="uk-padding-small uk-padding-remove-horizontal">

                                    <textarea style="border : 0;resize : none" class="uk-textarea uk-padding-remove uk-margin-small-right f1-scroller" id="<?= "f1_message_coach_chat_" . $value->id ?>" rows="2" placeholder="نوشتن پیام..."></textarea>

                                </div>
                            </div>

                            <div class="uk-width-auto">
                                <button id="<?= "f1_send_message_coach_chat_" . $value->id ?>" class="uk-button uk-button-primary uk-border-pill uk-button-small uk-margin-small-left uk-margin-small-bottom f1-button-spinner-hide">
                                    <span>ارسال</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!--/Chat Modal-->

            <!--Rate Coach-->
			<?php if ( $value->can_rate ): ?>
                <div id="<?= "rate_coach_modal_" . $value->id ?>" uk-modal>
                    <div class="uk-modal-dialog">

                        <button class="uk-modal-close-default" type="button" uk-close></button>

                        <div class="uk-modal-header">
                            <h5 class="uk-heading-bullet"> <?= "امتیاز دادن به " . get_user_by( 'ID', $value->coach_id )->display_name ?></h5>
                        </div>

                        <div class="uk-modal-body">

                            <div>
                                <p class="uk-text-small">امتیاز خود را از 1 تا 5 ستاره وارد کنید:</p>
                            </div>

                            <div uk-grid>

                                <div class="uk-width-auto">
                                    <div class="uk-margin-small">
                                        <input class="uk-radio" type="radio" value="1" name="<?= "f1_rate_coach_" . $value->id ?>">
                                    </div>
                                    <div class="uk-margin-small">
                                        <input class="uk-radio" type="radio" value="2" name="<?= "f1_rate_coach_" . $value->id ?>">
                                    </div>
                                    <div class="uk-margin-small">
                                        <input class="uk-radio" type="radio" value="3" name="<?= "f1_rate_coach_" . $value->id ?>">
                                    </div>
                                    <div class="uk-margin-small">
                                        <input class="uk-radio" type="radio" value="4" name="<?= "f1_rate_coach_" . $value->id ?>">
                                    </div>
                                    <div class="uk-margin-small">
                                        <input class="uk-radio" type="radio" value="5" name="<?= "f1_rate_coach_" . $value->id ?>">
                                    </div>
                                </div>

                                <div class="uk-width-1-2">
                                    <div class="uk-margin-small">
                                        <span uk-icon="star"></span>
                                    </div>
                                    <div class="uk-margin-small">
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                    </div>
                                    <div class="uk-margin-small">
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                    </div>
                                    <div class="uk-margin-small">
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                    </div>
                                    <div class="uk-margin-small">
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                        <span uk-icon="star"></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="uk-modal-footer">

                            <button id="<?= "f1_submit_rate_coach_" . $value->id ?>" class="uk-button uk-button-primary uk-border-pill uk-button-small uk-float-left f1-button-spinner-hide">
                                <span>ثبت امتیاز</span>
                                <i uk-spinner="ratio: 0.8"></i>
                            </button>

                        </div>

                    </div>
                </div>
			<?php endif; ?>
            <!--/Rate Coach-->

		<?php endforeach; ?>
        <!--/Modal-->

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>
