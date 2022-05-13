<!--

coach filter sidebar

-->

<?php

/**
 * @var $gender
 * @var $sports_branches
 */

?>

<form action="<?= home_url( 'filter_coach' ) ?>" method="get">

    <h4 class="uk-text-bold uk-margin-remove">مربی:</h4>
    <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom"/>

    <div class="uk-form-controls uk-margin-medium-bottom">
        <div class="uk-margin-small-bottom">
            <label><input class="uk-radio" value="man" <?php checked( $gender, "man" ) ?> type="radio" name="coach_gender"> آقا</label><br>
        </div>
        <div class="uk-margin-small-bottom">
            <label><input class="uk-radio" value="woman" <?php checked( $gender, "woman" ) ?> type="radio" name="coach_gender"> خانم</label>
        </div>
    </div>

    <h4 class="uk-text-bold uk-margin-remove">تخصص:</h4>
    <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom"/>

    <div class="uk-form-controls uk-margin-medium-bottom">
		<?php $branches = new WP_Term_Query( [ 'taxonomy' => 'sports_branches', 'hide_empty' => true ] ); ?>
		<?php foreach ( $branches->terms as $branch ): ?>
            <div class="uk-margin-small-bottom">
                <label>
                    <input class="uk-checkbox" type="checkbox" name="coach_sport_branch[]" value="<?= $branch->term_id ?>"
						<?php if ( isset( $sports_branches ) ): ?>
							<?php foreach ( $sports_branches as $sports_branch ): ?>
								<?php checked( $sports_branch, intval( $branch->term_id ) ) ?>
							<?php endforeach; ?>
						<?php endif ?>
                    > <?= $branch->name ?>
                </label>
                <br>
            </div>
		<?php endforeach; ?>
    </div>

    <div class="uk-form-controls uk-margin-medium-bottom">
        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">فیلتر کن</button>
    </div>

</form>

