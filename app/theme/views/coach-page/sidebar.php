<!--

coach-page sidebar

-->

<form action="<?= home_url( 'filter_coach' ) ?>" method="get">

    <h4 class="uk-text-bold uk-margin-remove">مربی:</h4>
    <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom"/>

    <div class="uk-form-controls uk-margin-medium-bottom">
        <div class="uk-margin-small-bottom">
            <label><input class="uk-radio" value="man" type="radio" name="coach_gender"> آقا</label><br>
        </div>
        <div class="uk-margin-small-bottom">
            <label><input class="uk-radio" value="woman" type="radio" name="coach_gender"> خانم</label>
        </div>
    </div>

    <h4 class="uk-text-bold uk-margin-remove">تخصص:</h4>
    <hr class="f1-border-2 uk-margin-remove-top uk-margin-small-bottom"/>

    <div class="uk-form-controls uk-margin-medium-bottom">
		<?php $sports_branches = new WP_Term_Query( [ 'taxonomy' => 'sports_branches', 'hide_empty' => true ] ) ?>
		<?php foreach ( $sports_branches->terms as $branch ): ?>
            <div class="uk-margin-small-bottom">
                <label><input class="uk-checkbox" name="coach_sport_branch[]" type="checkbox" value="<?= $branch->term_id ?>"> <?= $branch->name ?></label><br>
            </div>
		<?php endforeach; ?>
    </div>

    <div class="uk-form-controls uk-margin-medium-bottom">
        <button type="submit" class="uk-button uk-button-primary uk-width-1-1">فیلتر کن</button>
    </div>

</form>

