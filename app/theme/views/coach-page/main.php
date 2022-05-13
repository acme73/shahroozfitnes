<?php

use App\theme\services\CoachPostMeta;

?>

<div uk-grid>

	<?php if ( have_posts() ): ?>
		<?php while ( have_posts() ): the_post(); ?>

            <div class="uk-width-1-3 uk-text-center">
                <a class="uk-text-decoration-none" href="<?php echo get_the_permalink() ?>">
                    <img style="height: 170px!important;" src="<?php echo esc_url( CoachPostMeta::get_coach_property( get_the_ID() )["coach_image"] ) ?>" class="uk-border-circle f1-border-3 f1-border-solid f1-border-primary uk-object-cover" width="170">
                    <p class="uk-text-bold f1-text-black uk-margin-small-top"><?= get_the_title() ?></p>
                </a>
            </div>

		<?php endwhile; ?>
	<?php endif; ?>

</div>