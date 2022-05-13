<!--

coach info

-->
<?php

/**
 * @var $coach_property
 */

use App\utils\NumberConvert;

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <h4 class="uk-text-bold uk-margin-remove-bottom f1-text-black">اطلاعات فردی:</h4>
        <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom uk-width-1-6"/>
        <div class="uk-child-width-1-2" uk-grid>
            <div>
                <span class="uk-text-bold f1-text-black">نام و نام خانوادگی :</span>
                <span class="f1-text-black"><?= get_the_title() ?></span>
            </div>
            <div>
                <span class="uk-text-bold f1-text-black">تولد :</span>
                <span class="f1-text-black"><?php echo NumberConvert::convert2persian( $coach_property["coach_birth"] ) ?></span>
            </div>
            <div>
                <span class="uk-text-bold f1-text-black">تولد :</span>
                <span class="f1-text-black"><?php echo NumberConvert::convert2persian( $coach_property["coach_height"] ) . " سانتی متر" ?></span>
            </div>
            <div>
                <span class="uk-text-bold f1-text-black">وزن :</span>
                <span class="f1-text-black"><?php echo NumberConvert::convert2persian( $coach_property["coach_weight"] ) . " کیلوگرم" ?></span>
            </div>
        </div>
    </div>
</section>
