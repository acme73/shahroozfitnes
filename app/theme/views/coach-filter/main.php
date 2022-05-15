<!--

coach filter main

-->

<?php

/**
 * @var $coach_query
 */

use App\theme\services\CoachPostMeta;

?>

<div uk-grid>

	<?php if ( $coach_query->have_posts() ): ?>
		<?php while ( $coach_query->have_posts() ): $coach_query->the_post(); ?>

            <div class="uk-width-1-2 uk-width-1-3@m uk-text-center">
                <a class="uk-text-decoration-none" href="<?php echo get_the_permalink() ?>">
                    <img style="height: 170px!important;" src="<?php echo esc_url( CoachPostMeta::get_coach_property( get_the_ID() )["coach_image"] ) ?>" class="uk-border-circle f1-border-3 f1-border-solid f1-border-primary uk-object-cover" width="170">
                    <p class="uk-text-bold f1-text-black uk-margin-small-top"><?= get_the_title() ?></p>
                </a>
            </div>

		<?php endwhile; ?>
	<?php else: ?>
        <div class="uk-width-1-1 uk-text-center">
            <p>جستجو شما نتیجه ای نداشت!</p>
        </div>
	<?php endif; ?>

</div>