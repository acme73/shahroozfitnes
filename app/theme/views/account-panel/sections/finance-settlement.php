<!--

finance settlement

-->

<?php

/**
 * @var $finance_settlement
 * @var $balance
 * @var $finance_settlement_history
 * @var $transactions
 * @var $current_user
 * @var $tickets
 * @var $users
 */

use App\utils\NumberConvert;
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

    <div class="uk-container uk-container-expand uk-margin-large-bottom">

        <div uk-grid>

            <div class="uk-width-1-3@m">
                <div style="background-image: url(<?php echo F1_THEME_ASSET_URL . "images/coach-panel/sack-dollar.svg" ?>); background-repeat: no-repeat; background-position: -25px 20px;" class="uk-card uk-card-small uk-card-default uk-card-body f1-border-radius-10">

                    <p class="uk-text-light">مبلغ قابل تصفیه</p>
                    <span class="uk-text-bold uk-text-large"><?= NumberConvert::convert2persian( $balance, true ) ?></span>
                    <span class="uk-margin-small-right uk-text-light">تومان</span>

                </div>
            </div>

        </div>

        <div class="uk-card uk-card-small uk-margin-small uk-card-default uk-card-body f1-border-radius-10">

            <ul uk-tab>
                <li><a href="#">تراکنش ها</a></li>
                <li><a href="#">تسویه حساب</a></li>
            </ul>

            <ul class="uk-switcher uk-margin">
                <li>
                    <div class="uk-overflow-auto">
                        <table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-condensed uk-text-nowrap">
                            <thead>
                            <tr>
                                <th class="uk-width-medium">مبلغ (تومان)</th>
                                <th class="uk-width-medium">شماره فاکتور</th>
                                <th class="uk-width-medium">تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php if ( ! empty( $transactions ) ): ?>
								<?php foreach ( $transactions as $transaction ): ?>
                                    <tr>
                                        <td class="uk-text-small"><?= NumberConvert::convert2persian( $transaction->amount, true ) ?></td>
                                        <td class="uk-text-small"><?= $transaction->res_number ?></td>
                                        <td class="uk-text-small"><?= PersianDate::convert( new DateTime( $transaction->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li>
                    <div class="uk-overflow-auto">
                        <table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-condensed uk-text-nowrap">
                            <thead>
                            <tr>
                                <th class="uk-width-medium">مبلغ (تومان)</th>
                                <th class="uk-width-medium">شماره شبا</th>
                                <th class="uk-width-medium">تاریخ تسویه</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php if ( ! empty( $finance_settlement_history ) ): ?>
								<?php foreach ( $finance_settlement_history as $item ): ?>
                                    <tr>
                                        <td class="uk-text-small"><?= NumberConvert::convert2persian( $item->amount, true ) ?></td>
                                        <td class="uk-text-small"><?= $item->coach_payment ?></td>
                                        <td class="uk-text-small"><?= PersianDate::convert( new DateTime( $item->date, wp_timezone() ), "HH:mm Y/M/d" ) ?></td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>

        </div>

    </div>

</div>
<!-- endregion -->


<?php get_footer(); ?>
