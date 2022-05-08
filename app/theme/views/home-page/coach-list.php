<!--

homepage coach list rtl

-->

<section class="bg-light py-5">
    <div class="container text-center">
        <h4 class="fw-bold mb-3">مربی‌های متخصص و با‌تجربه ما</h4>
        <div class="row justify-content-center">
			<?php for ( $x = 0; $x < 9; $x ++ ) : ?>
                <div class="col-6 col-lg-4 gy-4 text-center">
                    <img src="<?= F1_THEME_ASSET_URL . "images/home-page/profile-coach.png" ?>" class="img-fluid rounded-circle border border-primary border-3" width="170">
                    <p class="fw-bold mb-0 mt-2">شهروز رحیمی</p>
                </div>
			<?php endfor; ?>
        </div>
        <button class="btn btn-primary rounded-pill mt-5">مشاهده همه مربی ها</button>
    </div>
</section>