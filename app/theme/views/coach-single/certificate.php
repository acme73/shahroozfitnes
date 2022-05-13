<!--

coach certificate

-->

<?php

/**
 * @var $coach_property
 **/

?>

<section class="uk-section uk-section-small uk-background-muted">
    <div class="uk-container">
        <h4 class="uk-text-bold uk-margin-remove-bottom f1-text-black">مدارک:</h4>
        <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom uk-width-1-6"/>
        <div class="uk-child-width-1-2" uk-grid>
			<?php if ( isset( $coach_property["coach_information"] ) ): ?>
				<?php foreach ( $coach_property["coach_information"] as $information ): ?>
					<?php if ( $information["type_info"] === "certificate" ): ?>
                        <span class="f1-text-black"><?php echo $information["desc_info"] ?></span>
					<?php endif ?>
				<?php endforeach ?>
			<?php endif; ?>
        </div>
    </div>
</section>
