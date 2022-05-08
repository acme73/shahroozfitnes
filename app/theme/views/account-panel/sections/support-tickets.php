<!--

support tickets

-->

<?php

/**
 * @var $current_user
 * @var $tickets
 * @var $users
 * @var $max_count_page
 * @var $per_page
 * @var $offset
 * @var $query_var
 */

use App\utils\PersianDate;
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

		<?php if ( ! empty( $query_var["ticket_id"] ) ): ?>

			<?php if ( ! $tickets->get_ticket( $query_var["ticket_id"] ) ): ?>
                <div class="uk-text-center uk-text-small">تیکت با این آیدی وجود ندارد</div>
			<?php else: ?>

				<?php $ticket = $tickets->get_ticket( $query_var["ticket_id"] ) ?>

                <div uk-grid>

                    <div class="uk-width-1-3">

                        <div style="position: sticky;top: 60px" class="uk-card uk-card-small uk-text-small uk-card-default uk-card-body f1-border-radius-10">

                            <!--ticket id-->
                            <div class="uk-margin-small">
                                <label class="uk-form-label">آیدی تیکت</label>
                                <input class="uk-input uk-form-small" disabled value="<?= "#" . $ticket->ticket_id ?>">
                            </div>
                            <!--/ticket id-->

                            <!--subject-->
                            <div class="uk-margin-small">
                                <label class="uk-form-label">موضوع تیکت</label>
                                <textarea class="uk-textarea uk-resize-vertical" disabled><?= $ticket->subject ?></textarea>
                            </div>
                            <!--/subject id-->

                            <!--department-->
                            <div class="uk-margin-small">
                                <label class="uk-form-label">دپارتمان</label>
                                <input class="uk-input uk-form-small" disabled value="<?php switch ( $ticket->department ) {
									case "1":
										echo "پشتيبانی فنی";
										break;
									case "2":
										echo "انتقادات و پیشنهادات";
										break;
									case "3":
										echo "شکایات";
										break;
								} ?>">
                            </div>
                            <!--/department-->

                            <!--priority-->
                            <div class="uk-margin-small">
                                <label class="uk-form-label">اهمیت</label>
                                <input class="uk-input uk-form-small" disabled value="<?php switch ( $ticket->priority ) {
									case "1":
										echo "کم";
										break;
									case "2":
										echo "متوسط";
										break;
									case "3":
										echo "زیاد";
										break;
								} ?>">
                            </div>
                            <!--/priority-->

                            <!--last update-->
                            <div class="uk-margin-small">
                                <label class="uk-form-label">آخرین بروزرسانی</label>
                                <input class="uk-input uk-form-small" disabled value="<?= PersianDate::convert( new DateTime( $ticket->last_update, wp_timezone() ), "HH:mm Y/M/d" ) ?>">
                            </div>
                            <!--/last update-->

                            <!--status-->
                            <div class="uk-margin-small">
                                <label class="uk-form-label">وضعیت تیکت</label>
                                <input class="uk-input uk-form-small" disabled value="<?php switch ( $ticket->status ) {
									case "0":
										echo "بسته است";
										break;
									case "1":
										echo "باز است";
										break;
									case "2":
										echo "پاسخ کاربر";
										break;
									case "3":
										echo "پاسخ مدیریت";
										break;
								} ?>">
                            </div>
                            <!--/status-->

							<?php if ( current_user_can( 'administrator' ) ): ?>
								<?php if ( intval( $ticket->status ) !== 0 ): ?>
                                    <!--update button-->
                                    <div class="uk-margin-small">
                                        <button id="f1_ticket_close" type="button" class="uk-button uk-width-1-1 f1-button-spinner-hide uk-button-primary uk-button-small uk-border-pill">
                                            <span>بستن تیکت</span>
                                            <i uk-spinner="ratio: 0.8"></i>
                                        </button>
                                    </div>
                                    <!--/update button-->
								<?php endif; ?>
							<?php endif; ?>

                        </div>

                    </div>

                    <div class="uk-width-expand">

                        <button class="uk-button uk-button-primary uk-button-large uk-width-1-1 " type="button" uk-toggle="target: #replay; animation: uk-animation-fade">پاسخ دادن</button>
                        <div id="replay" class="uk-card uk-card-default uk-card-small uk-card-body" hidden>

                            <label class="uk-form-label">پیام</label>
                            <textarea id="f1_replay_ticket_message" class="uk-textarea uk-resize-vertical" rows="5"></textarea>

                            <div class="uk-margin-small">
                                <button id="f1_replay_ticket_submit" class="uk-button uk-button-primary uk-button-small uk-border-pill uk-float-left f1-button-spinner-hide">
                                    <span>ارسال پیام</span>
                                    <i uk-spinner="ratio: 0.8"></i>
                                </button>
                            </div>

                        </div>

						<?php foreach ( array_reverse( unserialize( $ticket->messages ) ) as $message ): ?>
                            <div class="uk-card uk-card-default uk-card-small uk-text-small uk-margin-small-top uk-margin-small-bottom f1-border-radius-10">
                                <div class="uk-card-header">
                                    <span><?= get_user_by( 'id', $message["user"] )->display_name ?></span>
                                    <span class="uk-float-left"><?= PersianDate::convert( new DateTime( $message["date"], wp_timezone() ), "HH:mm Y/M/d" ) ?></span>
                                </div>
                                <div class="uk-card-body">
									<?= str_replace( "\n", "<br>", $message['message'] ) ?>
                                </div>
                            </div>
						<?php endforeach; ?>

                    </div>

                </div>

			<?php endif; ?>

		<?php else: ?>

            <div class="uk-card uk-padding-remove uk-card-default uk-card-body f1-border-radius-10">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-condensed uk-text-nowrap">
                        <thead>
                        <tr>
                            <th class="uk-width-medium">عنوان تیکت</th>
                            <th>اهمیت</th>
                            <th>دپارتمان</th>
                            <th>وضعیت تیکت</th>
                            <th>آخرین بروزرسانی</th>
                            <th class="uk-width-small"></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td class="uk-width-medium">عنوان تیکت</td>
                            <td>اهمیت</td>
                            <td>دپارتمان</td>
                            <td>وضعیت تیکت</td>
                            <td>آخرین بروزرسانی</td>
                            <td class="uk-width-small"></td>
                        </tr>
                        </tfoot>
                        <tbody>
						<?php if ( array_intersect( [ 'f1_coach', 'f1_athlete' ], $current_user->roles ) ): ?>
							<?php if ( count( $tickets->get_tickets( $offset, $per_page, get_current_user_id() ) ) > 0 ): ?>
								<?php $max_count_page = $tickets->get_tickets_count( get_current_user_id() ) ?>
								<?php foreach ( $tickets->get_tickets( $offset, $per_page, get_current_user_id() ) as $value ): ?>
                                    <tr>
                                        <td class="uk-text-truncate uk-text-small"><?= $value->subject ?></td>
                                        <td class="uk-text-small"><?php switch ( $value->priority ) {
												case "1":
													echo "کم";
													break;
												case "2":
													echo "متوسط";
													break;
												case "3":
													echo "زیاد";
													break;
											} ?></td>
                                        <td><span class="uk-label"><?php switch ( $value->department ) {
													case "1":
														echo "پشتيبانی فنی";
														break;
													case "2":
														echo "انتقادات و پیشنهادات";
														break;
													case "3":
														echo "شکایات";
														break;
												} ?></span></td>
                                        <td><?php switch ( $value->status ) {
												case "0":
													echo "<span class='uk-label uk-label-danger'>بسته است</span>";
													break;
												case "1":
													echo "<span class='uk-label uk-label-success'>باز است</span>";
													break;
												case "2":
													echo "<span class='uk-label uk-label-success'>پاسخ کاربر</span>";
													break;
												case "3":
													echo "<span class='uk-label uk-label-success'>پاسخ مدیریت</span>";
													break;
											} ?></td>
                                        <td class="uk-text-small"><?= PersianDate::convert( new DateTime( $value->last_update, wp_timezone() ), "HH:mm Y/M/d" ) ?></td>
                                        <td><a href="<?= add_query_arg( [ 'ticket_id' => $value->ticket_id ] ) ?>" type="button" class="uk-button uk-button-primary uk-button-small uk-border-pill">مشاهده تیکت</a></td>
                                    </tr>
								<?php endforeach; ?>
							<?php else: ?>
                                <tr>
                                    <td colspan="6" class="uk-text-small uk-text-center">موردی برای نمایش وجود ندارد!</td>
                                </tr>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( current_user_can( 'administrator' ) ): ?>
							<?php if ( count( $tickets->get_tickets( $offset, $per_page ) ) > 0 ): ?>
								<?php $max_count_page = $tickets->get_tickets_count() ?>
								<?php foreach ( $tickets->get_tickets( $offset, $per_page ) as $value ): ?>
                                    <tr>
                                        <td class="uk-text-truncate uk-text-small"><?= $value->subject ?></td>
                                        <td class="uk-text-small"><?php switch ( $value->priority ) {
												case "1":
													echo "کم";
													break;
												case "2":
													echo "متوسط";
													break;
												case "3":
													echo "زیاد";
													break;
											} ?></td>
                                        <td><span class="uk-label"><?php switch ( $value->department ) {
													case "1":
														echo "پشتيبانی فنی";
														break;
													case "2":
														echo "انتقادات و پیشنهادات";
														break;
													case "3":
														echo "شکایات";
														break;
												} ?></span></td>
                                        <td><?php switch ( $value->status ) {
												case "0":
													echo "<span class='uk-label uk-label-danger'>بسته است</span>";
													break;
												case "1":
													echo "<span class='uk-label uk-label-success'>باز است</span>";
													break;
												case "2":
													echo "<span class='uk-label uk-label-success'>پاسخ کاربر</span>";
													break;
												case "3":
													echo "<span class='uk-label uk-label-success'>پاسخ مدیریت</span>";
													break;
											} ?></td>
                                        <td class="uk-text-small"><?= PersianDate::convert( new DateTime( $value->last_update, wp_timezone() ), "HH:mm Y/M/d" ) ?></td>
                                        <td><a href="<?= add_query_arg( [ 'ticket_id' => $value->ticket_id ] ) ?>" type="button" class="uk-button uk-button-primary uk-button-small uk-border-pill">مشاهده تیکت</a></td>
                                    </tr>
								<?php endforeach; ?>
							<?php else: ?>
                                <tr>
                                    <td colspan="6" class="uk-text-small uk-text-center">موردی برای نمایش وجود ندارد!</td>
                                </tr>
							<?php endif; ?>
						<?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

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

		<?php endif; ?>

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>
