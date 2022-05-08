<!--

accounting transactions in administrator

-->

<?php

/**
 * @var $current_user
 * @var $tickets
 * @var $users
 * @var $transactions ,
 * @var $max_count_page ,
 * @var $per_page ,
 * @var $offset
 * @var $query_var
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

    <div class="uk-container uk-container-expand uk-margin-large-bottom">

        <!--Filter-->
        <form class="uk-margin-small" method="get">

            <div class="uk-flex-middle" uk-grid>

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

        <!--Content-->
        <div class="uk-card uk-padding-remove uk-card-default uk-card-body f1-border-radius-10">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-condensed uk-text-nowrap">
                    <thead>
                    <tr>
                        <th class="uk-table-shrink">آیدی تراکنش</th>
                        <th>پرداخت کننده</th>
                        <th>مربی</th>
                        <th>نوع برنامه</th>
                        <th>مبلغ پرداخت(تومان)</th>
                        <th>فاکتور</th>
                        <th>رسید</th>
                        <th>تاریخ تراکنش</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td class="uk-table-shrink">آیدی تراکنش</td>
                        <td>پرداخت کننده</td>
                        <td>مربی</td>
                        <td>نوع برنامه</td>
                        <td>مبلغ پرداخت(تومان)</td>
                        <td>فاکتور</td>
                        <td>رسید</td>
                        <td>تاریخ تراکنش</td>
                    </tr>
                    </tfoot>
                    <tbody>
					<?php if ( count( $transactions->get_transactions( $offset, $per_page ) ) > 0 ): ?>
						<?php foreach ( $transactions->get_transactions( $offset, $per_page ) as $transaction ): ?>
                            <tr>
                                <td class="uk-text-small"><span uk-icon="icon: hashtag; ratio: 0.8"></span><?= $transaction->id ?></td>
                                <td class="uk-text-small"><?= get_user_by( 'ID', $transaction->athlete_id )->display_name ?></td>
                                <td class="uk-text-small"><?= get_user_by( 'ID', $transaction->coach_id )->display_name ?></td>
                                <td class="uk-text-small"><?php switch ( $transaction->type_program ) {
										case "practice":
											echo "طراحی برنامه تمرینی";
											break;
										case "food":
											echo "طراحی برنامه غذایی";
											break;
									} ?></td>
                                <td class="uk-text-small"><?= NumberConvert::convert2persian( $transaction->price_program, true ) ?></td>
                                <td class="uk-text-small"><?= $transaction->res_number ?></td>
                                <td class="uk-text-small"><?= $transaction->ref_number ?></td>
                                <td class="uk-text-small"><?= PersianDate::convert( new DateTime( $transaction->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></td>
                            </tr>
						<?php endforeach; ?>
					<?php else: ?>
                        <tr>
                            <td colspan="8" class="uk-text-small uk-text-center">موردی برای نمایش وجود ندارد!</td>
                        </tr>
					<?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/Content-->

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

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>