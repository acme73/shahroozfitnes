<?php
/**
 * @var $coach_property
 * @var $coach_id
 */
?>

<div class="f1-panel">

    <div class="f1-panel-tab">
        <ul>
            <li>مشخصات فردی</li>
            <li>آپلود تصویر</li>
            <li>اطلاعات</li>
            <li>قیمت ها</li>
            <li>پیکربندی</li>
        </ul>
    </div>

    <div class="f1-panel-content">

        <!--region person-->
        <div>

            <div class="row">
                <label for="coach_gender">جنسیت</label>
                <select style="width: 120px;" id="coach_gender" name="coach_gender">
                    <option value="man" <?php is_null( $coach_property ) ? null : selected( $coach_property['coach_gender'], 'man' ) ?> >مرد</option>
                    <option value="woman" <?php is_null( $coach_property ) ? null : selected( $coach_property['coach_gender'], 'woman' ) ?>>زن</option>
                </select>
            </div>

            <div class="row">
                <label for="coach_birth">سال تولد (شمسی)</label>
                <input style="width: 120px;direction: ltr;" type="number" id="coach_birth" name="coach_birth" placeholder="1368 :مثال" value="<?= ! is_null( $coach_property ) ? $coach_property['coach_birth'] : '' ?>">
            </div>

            <div class="row">
                <label for="coach_height">قد (سانتی متر)</label>
                <input style="width: 120px;direction: ltr;" type="number" id="coach_height" name="coach_height" placeholder="180 :مثال" value="<?= ! is_null( $coach_property ) ? $coach_property['coach_height'] : '' ?>">
            </div>

            <div class="row">
                <label for="coach_weight">وزن (کیلوگرم)</label>
                <input style="width: 120px;direction: ltr;" type="number" id="coach_weight" name="coach_weight" placeholder="85 :مثال" value="<?= ! is_null( $coach_property ) ? $coach_property['coach_weight'] : '' ?>">
            </div>

            <div class="row">
                <label for="coach_explanation">معرفی کوتاه</label>
                <textarea id="coach_explanation" name="coach_explanation"><?= $coach_property['coach_explanation'] ?? '' ?></textarea>
            </div>

        </div>
        <!--endregion-->

        <!--region Upload image-->
        <div id=" f1_coach_profile_image_container">

			<?php if ( ! is_null( $coach_property ) && isset( $coach_property['coach_image'] ) ): ?>
                <div class="row">
                    <img class="f1-image-upload" width="200" src="<?= esc_url( $coach_property['coach_image'] ) ?>" alt="coach_image">
                    <input type="hidden" name="is_image">
                </div>
                <div class="row">
                    <button id="f1_coach_profile_image_remove" class="button button-cancel button-large">حذف تصویر</button>
                </div>
			<?php else: ?>
                <div class="row">
                    <label for="coach_image">تصویر مربی</label>
                    <input id="coach_image" name="coach_image" type="file">
                </div>
			<?php endif; ?>

        </div>
        <!--endregion-->

        <!--region Information-->
        <div>

            <div id="f1_coach_information_container">

				<?php if ( $coach_property !== null && isset( $coach_property["coach_information"] ) ): ?>

					<?php foreach ( $coach_property["coach_information"] as $information ): ?>
                        <div class="f1-coach-row-container">

                            <div>
                                <select name="type_info[]">
                                    <option value="certificate" <?php selected( $information['type_info'], 'certificate' ) ?>>مدارک ها</option>
                                </select>
                            </div>

                            <div>
                                <input type="text" name="desc_info[]" placeholder="توضیحات را اینجا وارد کنید..." value="<?php echo $information["desc_info"] ?>">
                            </div>

                            <div>
                                <span class="dashicons dashicons-trash f1-cursor-pointer" id="f1_coach_information_remove_record"></span>
                                <span class="dashicons dashicons-move f1-cursor-move" id="f1_coach_information_move_record"></span>
                            </div>

                        </div>
					<?php endforeach; ?>

				<?php endif; ?>

            </div>

            <div class="f1-coach-new-record" id="f1_coach_information_new_record"><span class="dashicons dashicons-insert"></span><span>اضافه کردن مورد جدید</span></div>

        </div>
        <!--endregion-->

        <!--region Program prices-->
        <div>

            <div id="f1_coach_program_prices_container">

				<?php if ( $coach_property !== null && isset( $coach_property["coach_program_prices"] ) ): ?>
					<?php foreach ( $coach_property["coach_program_prices"] as $program_price ): ?>
                        <div class="f1-coach-row-container">

                            <div>
                                <select name="type_service[]">
                                    <option value="practice_food" <?php selected( $program_price['type_service'], 'practice_food' ) ?>>طراحی تمرین و تغذیه</option>
                                    <option value="professional_consultation" <?php selected( $program_price['type_service'], 'professional_consultation' ) ?>>مشاوره تخصصی</option>
                                </select>
                            </div>

                            <div>
                                <input type="text" name="program_price[]" placeholder="قیمت به تومان" value="<?php echo $program_price["program_price"] ?>">
                            </div>

                            <div>
                                <span class="dashicons dashicons-trash f1-cursor-pointer" id="f1_coach_program_prices_remove_record"></span>
                                <span class="dashicons dashicons-move f1-cursor-move" id="f1_coach_program_prices_move_record"></span>
                            </div>

                        </div>
					<?php endforeach; ?>
				<?php endif; ?>

            </div>

            <div class="f1-coach-new-record" id="f1_coach_program_prices_new_record"><span class="dashicons dashicons-insert"></span><span>اضافه کردن مورد جدید</span></div>

        </div>
        <!--endregion-->

        <!--region Configuration-->
        <div>
            <div class="row">
                <label for="coach_id">شناسه کاربری مربی</label>
                <input type="text" id="coach_id" name="coach_id" placeholder="یک حرف از نام مربی را وارد کنید..." value="<?= $coach_id ?>">
            </div>
        </div>
        <!--endregion-->

    </div>

</div>