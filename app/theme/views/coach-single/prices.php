<!--

coach prices

-->

<?php

/**
 * @var $coach_property
 * @var $coach_rate
 **/

use App\theme\services\CoachPostMeta;

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <div uk-grid>
            <div class="uk-width-expand">
                <h4 class="uk-text-bold uk-margin-remove-bottom f1-text-black">معرفی:</h4>
                <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom uk-width-1-6"/>
                <p class="f1-text-black uk-text-justify uk-margin-remove"><?= $coach_property["coach_explanation"] ?></p>
            </div>
            <div class="uk-width-1-1 uk-width-1-3@m uk-text-center uk-flex-first uk-flex-last@m">
                <div style="margin-top: -125px;">
                    <img style="height: 170px!important;" src="<?php echo esc_url( $coach_property["coach_image"] ) ?>" class="uk-border-circle f1-border-3 f1-border-solid f1-border-primary uk-object-cover" width="170">
                    <p class="uk-text-bold f1-text-black uk-margin-small-bottom uk-margin-small-top"><?= get_the_title() ?></p>
					<?php $total_rate = intval( CoachPostMeta::get_coach_rate( get_the_ID() ) ) ?>
                    <div class="uk-flex uk-flex-row-reverse uk-flex-center uk-margin-small-bottom">
						<?php for ( $i = 0; $i < 5; $i ++ ): ?>
							<?php if ( $i < $total_rate ): ?>
                                <img src="<?= F1_THEME_ASSET_URL . "images/coach-single/coachs-star-gold.svg" ?>" width="20">
							<?php else: ?>
                                <img src="<?= F1_THEME_ASSET_URL . "images/coach-single/coachs-star-gray.svg" ?>" width="20">
							<?php endif ?>
						<?php endfor; ?>
                    </div>
					<?php if ( isset( $coach_property["coach_program_prices"] ) && count( $coach_property["coach_program_prices"] ) > 0 ): ?>
						<?php foreach ( $coach_property["coach_program_prices"] as $program_prices ): ?>
							<?php switch ( $program_prices["type_service"] ) :
								case "practice_food" : ?>
                                    <button class="uk-button uk-button-primary uk-button-small uk-border-pill f1-button-spinner-hide uk-margin-small-bottom" id="<?= "f1_order_" . $program_prices["type_service"] . "%" . get_the_ID() ?>">
                                        <span>برنامه تمرین و تغذیه</span>
                                        <i uk-spinner="ratio: 0.8"></i>
                                    </button><br>
									<?php break; ?>
								<?php case "professional_consultation" : ?>
                                    <button class="uk-button uk-button-primary uk-button-small uk-border-pill f1-button-spinner-hide uk-margin-small-bottom" id="<?= "f1_order_" . $program_prices["type_service"] . "%" . get_the_ID() ?>">
                                        <span>مشاوره تخصصی</span>
                                        <i uk-spinner="ratio: 0.8"></i>
                                    </button><br>
									<?php break; ?>
								<?php endswitch; ?>
						<?php endforeach; ?>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>