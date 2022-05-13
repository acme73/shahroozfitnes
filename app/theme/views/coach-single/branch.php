<!--

coach branch

-->

<?php

/**
 * @var $coach_property
 */

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <h4 class="uk-text-bold uk-margin-remove-bottom f1-text-black">رشته:</h4>
        <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom uk-width-1-6"/>
        <div class="uk-child-width-1-2" uk-grid>
			<?php $sports_branches = get_the_terms( get_the_ID(), "sports_branches" ); ?>
			<?php if ( $sports_branches ): ?>
				<?php foreach ( $sports_branches as $sport_branch ): ?>
                    <p class="f1-text-black"><?php echo $sport_branch->name ?></p>
				<?php endforeach ?>
			<?php endif; ?>
        </div>
    </div>
</section>
