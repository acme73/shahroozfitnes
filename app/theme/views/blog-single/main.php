<!--

blog single main

-->

<!--content-->
<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>

        <div class="f1-background-white uk-padding uk-box-shadow-medium uk-box-shadow-hover-large" uk-grid>

            <div class="uk-width-1-1">

                <div class="uk-text-center">
					<?php $post_categories = get_the_category() ?>
					<?php foreach ( $post_categories as $index => $post_category ): ?>
                        <a class="uk-button-link" href="<?= esc_url( get_category_link( $post_category->term_id ) ) ?>">
                            <span class="uk-text-meta"><?= $post_category->name ?></span>
                        </a>
						<?php if ( ( count( $post_categories ) - 1 ) > $index ): ?>
                            <span>،</span>
						<?php endif; ?>
					<?php endforeach; ?>
                </div>

                <h2 class="uk-text-bold uk-margin-small-top uk-text-center"><?= get_the_title() ?></h2>

                <hr class="f1-border-3 uk-margin-small-top uk-margin-small-bottom uk-width-1-6 uk-margin-auto"/>

                <div class="uk-text-center"><?php the_post_thumbnail( 'blog-thumbnail' ); ?></div>

                <p class="uk-text-justify"><?= get_the_content() ?></p>

            </div>

        </div>

	<?php endwhile; ?>
<?php endif; ?>
<!--/content-->

<!--Comment-->
<!--<h3 class="uk-heading-line uk-text-right uk-text-bold uk-margin-medium-bottom">
    <span>نظرات کاربران</span>
</h3>-->
<!--<div class="f1-background-2f2f2f f1-border-radius-10 uk-padding-small uk-margin-small-bottom">
	<?php /*if ( comments_open() || get_comments_number() ) {
		comments_template();
	} */ ?>
</div>-->
<!--/Comment-->

