<!--

accounting paid in administrator

-->

<?php

/**
 * @var $all_finance_settlement
 * @var $current_user
 * @var $tickets
 * @var $users
 * @var $max_count_page
 * @var $per_page
 * @var $offset
 * @var $query_var
 */

use App\utils\NumberConvert;
use app\utils\PersianDate;
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
                        <th class="uk-table-shrink">آیدی مربی</th>
                        <th>نام مربی</th>
                        <th>شماره شبا</th>
                        <th>مبلغ پرداخت(تومان)</th>
                        <th>شماره سند</th>
                        <th>تاریخ پرداخت</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td class="uk-table-shrink">آیدی مربی</td>
                        <td>نام مربی</td>
                        <td>شماره شبا</td>
                        <td>مبلغ پرداخت(تومان)</td>
                        <td>شماره سند</td>
                        <td>تاریخ پرداخت</td>
                    </tr>
                    </tfoot>
                    <tbody>
					<?php if ( count( $all_finance_settlement->get_all_finance_settlement_history( $offset, $per_page ) ) > 0 ): ?>
						<?php foreach ( $all_finance_settlement->get_all_finance_settlement_history( $offset, $per_page ) as $value ): ?>
                            <tr>
                                <td class="uk-text-small"><span uk-icon="icon: hashtag; ratio: 0.8"></span><?= $value->coach_id ?></td>
                                <td class="uk-text-small"><?= get_user_by( 'ID', $value->coach_id )->display_name ?></td>
                                <td class="uk-text-small"><?= $value->coach_payment ?></td>
                                <td class="uk-text-small"><?= NumberConvert::convert2persian( $value->amount, true ) ?></td>
                                <td class="uk-text-small"><?= $value->document_number ?></td>
                                <td class="uk-text-small"><?= PersianDate::convert( new DateTime( $value->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></td>
                            </tr>
						<?php endforeach; ?>
					<?php else: ?>
                        <tr>
                            <td colspan="6" class="uk-text-small uk-text-center">موردی برای نمایش وجود ندارد!</td>
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

<?php get_footer() ?>