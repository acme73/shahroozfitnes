<!--

order athlete

-->

<?php

/**
 * @var $order
 * @var $current_user
 * @var $tickets
 * @var $users
 * @var $max_count_page
 * @var $per_page
 * @var $offset
 * @var $query_var
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

        <!--Orders-->
		<?php if ( count( $order->get_orders_for_coach( get_current_user_id(), $offset, $per_page ) ) > 0 ): ?>

			<?php foreach ( $order->get_orders_for_coach( get_current_user_id(), $offset, $per_page ) as $value ): ?>
                <div style="<?php switch ( $value->active ) {
					case "0":
						echo "border-right: 5px solid #f0506e";
						break;
					case "1":
						echo "border-right: 5px solid #32d296";
						break;
				} ?>" class="uk-card uk-card-small uk-card-default uk-card-body uk-margin-small f1-border-radius-10">

                    <div class="uk-flex-middle" uk-grid>

                        <!--Athlete Image-->
                        <div class="uk-width-auto">
                            <img width="35" height="35" src="<?php echo get_avatar_url( $value->athlete_id ) ?>" alt="avatar" class="uk-border-circle">
                        </div>
                        <!--/Athlete Image-->

                        <!--Order Details-->
                        <div class="uk-width-auto">
                            <div class="uk-grid uk-child-width-auto">

                                <div>
                                    <p class="uk-heading-bullet uk-text-small"><?= get_user_by( "ID", $value->athlete_id )->display_name ?></p>
                                </div>

                                <div>
                                    <p class="uk-heading-bullet uk-text-small"><?php switch ( $value->type_program ) {
											case "practice":
												echo "طراحی برنامه تمرینی";
												break;
											case "food":
												echo "طراحی برنامه غذایی";
												break;
										} ?></p>
                                </div>

                            </div>
                        </div>
                        <!--/Order Details-->

                        <!--Options-->
                        <div class="uk-width-expand">

                            <span class="f1-cursor-pointer uk-float-left uk-icon-button" uk-icon="icon:  more-vertical; ratio: 1.1"></span>
                            <div class="f1-background-e9491e f1-border-radius-10" id="<?= "f1_options_order_coach_" . $value->id ?>" uk-dropdown="mode: click">
                                <ul class="uk-nav uk-dropdown-nav">

                                    <li>
                                        <button class="uk-button f1-color-white f1-background-e9491e uk-button-small" uk-toggle="target: <?= "#chart_athlete_modal_" . $value->id ?>" uk-toggle><span class="uk-margin-small-left" uk-icon="icon: info; ratio: 1.1"></span>مشاهده نمودارها</button>
                                    </li>

                                    <li class="uk-nav-divider"></li>

                                    <li>
                                        <button class="uk-button f1-color-white f1-background-e9491e uk-button-small" uk-toggle="target: <?= "#chat_athlete_modal_" . $value->id ?>" uk-toggle><span class="uk-margin-small-left" uk-icon="icon: comment; ratio: 1.1"></span>مشاوره و گفتگو</button>
                                    </li>

									<?php if ( $value->active ): ?>

                                        <li class="uk-nav-divider"></li>

                                        <li>
                                            <button id="<?= "f1_deactivate_order_" . $value->id ?>" class="uk-button f1-color-white f1-background-e9491e uk-button-small"><span class="uk-margin-small-left" uk-icon="icon: lock; ratio: 1.1"></span>بستن سفارش</button>
                                        </li>

									<?php endif; ?>

                                </ul>
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
				<?php if ( isset( $query_var['page'] ) && intval( $query_var['page'] ) !== 1 ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $query_var['page'] - 1 ] ) ?>"><span uk-pagination-previous></span></a></li>
				<?php endif; ?>
				<?php for (
					$i = 1;
					$i <= ( ceil( $max_count_page / $per_page ) );
					$i ++
				): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $i ] ) ?>"><?= $i ?></a></li>
				<?php endfor; ?>
				<?php if ( intval( $query_var['page'] ) !== intval( ceil( $max_count_page / $per_page ) ) ): ?>
                    <li><a href="<?= add_query_arg( [ 'page' => $query_var['page'] + 1 ] ) ?>"><span uk-pagination-next></span></a></li>
				<?php endif; ?>
            </ul>
		<?php endif; ?>
        <!--/Paging-->

        <!--Modal-->
		<?php foreach ( $order->get_orders_for_coach( get_current_user_id(), $offset, $per_page ) as $value ): ?>

            <!--Chart Athlete-->
            <div id="<?= "chart_athlete_modal_" . $value->id ?>" class="uk-modal-container" uk-modal>
                <div class="uk-modal-dialog f1-background-f5f5f5">

                    <button class="uk-modal-close-outside" type="button" uk-close></button>

                    <div class="uk-modal-body f1-scroller" uk-overflow-auto>

                        <div class="uk-card uk-card-small uk-card-default uk-margin-small f1-border-radius-10">

                            <div class="uk-card-body">
                                <h5 class="uk-heading-bullet"> <?= "نمودار وزن " . get_user_by( 'ID', $value->athlete_id )->display_name ?></h5>
                            </div>

                            <div id="<?= "f1_athlete_chart_weight_container_" . $value->id ?>" class="uk-card-body" style="position: relative;height: 300px;margin: 0 auto;">
                                <canvas id="<?= "f1_athlete_chart_weight_" . $value->id ?>"></canvas>
                            </div>

                        </div>

                        <div class="uk-card uk-card-small uk-card-default uk-margin-small f1-border-radius-10">

                            <div class="uk-card-body">
                                <h5 class="uk-heading-bullet"> <?= "نمودار قد " . get_user_by( 'ID', $value->athlete_id )->display_name ?></h5>
                            </div>

                            <div id="<?= "f1_athlete_chart_height_container_" . $value->id ?>" class="uk-card-body" style="position: relative;height: 300px;margin: 0 auto;">
                                <canvas id="<?= "f1_athlete_chart_height_" . $value->id ?>"></canvas>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!--/Chart Athlete-->

            <!--Chat Modal-->
            <div id="<?= "chat_athlete_modal_" . $value->id ?>" uk-modal="bgClose: false; escClose: false; modal: false; keyboard: false">
                <div class="uk-modal-dialog f1-background-f5f5f5">

                    <button class="uk-modal-close-default" type="button" uk-close></button>

                    <div class="uk-modal-header">
                        <h5 class="uk-heading-bullet"> <?= "مشاوره با " . get_user_by( 'ID', $value->athlete_id )->display_name ?></h5>
                    </div>

                    <div class="uk-modal-body f1-scroller" id="<?= "f1_container_athlete_chat_" . $value->id ?>" uk-overflow-auto></div>

                    <div class="uk-modal-footer uk-padding-remove">

                        <div class="uk-grid uk-grid-small uk-flex-bottom" uk-grid>

                            <div class="uk-width-expand">
                                <div class="uk-padding-small uk-padding-remove-horizontal">
                                    <textarea style="border : 0;resize : none" class="uk-textarea uk-padding-remove uk-margin-small-right f1-scroller" id="<?= "f1_message_athlete_chat_" . $value->id ?>" rows="2" placeholder="نوشتن پیام..."></textarea>
                                </div>
                            </div>

                            <div class="uk-width-auto">
                                <button id="<?= "f1_send_message_athlete_chat_" . $value->id ?>" class="uk-button uk-button-primary uk-border-pill uk-button-small uk-margin-small-left uk-margin-small-bottom f1-button-spinner-hide">
                                    <span>ارسال</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!--/Chat Modal-->

		<?php endforeach; ?>
        <!--/Modal-->

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>