<!--

blog main

-->

<!--content-->
<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>

        <a class="uk-text-decoration-none" href="<?php echo get_the_permalink() ?>">
            <div class="uk-grid-collapse uk-margin f1-background-white uk-box-shadow-medium uk-box-shadow-hover-large uk-flex-middle" uk-grid>

                <div class="uk-width-1-1 uk-width-1-3@m uk-text-center ">
					<?php the_post_thumbnail( 'blog-thumbnail' ); ?>
                </div>

                <div class="uk-width-expand uk-text-center uk-padding-small f1-text-black">
                    <h5 class="uk-text-bold uk-margin-remove-bottom uk-margin-small-top"><?= get_the_title() ?></h5>
                    <hr class="f1-border-2 uk-margin-small-top uk-margin-small-bottom uk-width-1-6 uk-margin-auto"/>
                    <p><?php echo substr( get_the_content(), 0, 200 ) . "[...]" ?></p>
                </div>

            </div>
        </a>

	<?php endwhile; ?>
<?php endif; ?>
<!--/content-->

<!--Paging-->
<div class="uk-text-center uk-margin-large f1-paging">
	<?php echo paginate_links( [
		'prev_text' => 'صفحه قبلی',
		'next_text' => 'صفحه بعدی'
	] ); ?>
</div>
<!--/Paging-->

