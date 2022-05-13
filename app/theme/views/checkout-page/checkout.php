<!--

checkout page

-->

<?php

/**
 * @var $query
 */

use App\theme\services\CoachPostMeta;
use App\theme\services\PaymentsOption;
use App\utils\NumberConvert;
use App\utils\View;

?>

<?php get_header() ?>

<!--navbar-->
<?php View::render( "app.theme.views.partials.navbar" ); ?>

<!--regionContent-->
<?php if ( $query->have_posts() ): ?>
	<?php while ( $query->have_posts() ): $query->the_post(); ?>

        <section class="uk-section uk-section-small uk-background-muted">

            <div class="uk-container">
                <div class="uk-flex-center" uk-grid>
                    <div class="uk-width-1-1 uk-width-1-2@m">
                        <form method="post">

                            <input name="post_id" type="hidden" value="<?= $_POST['post_id'] ?>">
                            <input name="type_service" type="hidden" value="<?= $_POST['type_service'] ?>">

                            <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-text-center uk-flex-middle f1-text-black" uk-grid>
                                <div class="uk-text-bold uk-text-center">سفارش شما:</div>
                                <div><?= "درخواست برنامه از " . get_the_title() ?></div>
                            </div>

                            <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-text-center uk-flex-middle f1-text-black" uk-grid>
                                <div class="uk-text-bold uk-text-center">نوع برنامه:</div>
                                <div><?php switch ( $_POST['type_service'] ):
										case "practice_food": ?>
											<?= "طراحی تمرین و تغذیه" ?>
											<?php break ?>
										<?php case "professional_consultation": ?>
											<?= "مشاوره تخصصی" ?>
											<?php break ?>
										<?php endswitch; ?>
                                </div>
                            </div>

                            <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-text-center uk-flex-middle f1-text-black" uk-grid>
                                <div class="uk-text-bold uk-text-center">مبلغ قابل پرداخت:</div>
                                <div><?php foreach ( CoachPostMeta::get_coach_property( get_the_ID() )["coach_program_prices"] as $program_prices ): ?>
										<?php if ( $program_prices["type_service"] === $_POST['type_service'] ): ?>
											<?= NumberConvert::convert2persian( $program_prices["program_price"], true ) . " تومان" ?>
										<?php endif; ?>
									<?php endforeach; ?></div>
                            </div>

                            <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small uk-text-center uk-flex-middle f1-text-black" uk-grid>
                                <div class="uk-text-bold uk-text-center">انتخاب درگاه پرداخت:</div>
                                <div>
                                    <select name="type_payment" class="uk-select uk-border-pill f1-border-2 f1-border-primary">
										<?php foreach ( PaymentsOption::get_payments() as $payment => $option ): ?>
                                            <option value="<?= $payment ?>"><?= $option['name_payment'] ?></option>
										<?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="uk-margin-medium-top uk-text-center">
                                <button type="submit" name="order_payment_submit" class="uk-button uk-button-primary uk-border-pill">ثبت سفارش و پرداخت</button>
								<?= wp_nonce_field() ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </section>

	<?php endwhile; ?>
<?php endif; ?>
<!--endregion-->

<!--footer-->
<?php View::render( "app.theme.views.partials.footer" ); ?>

<?php get_footer() ?>


