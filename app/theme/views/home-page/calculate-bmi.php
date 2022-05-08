<!--

homepage calculate bmi rtl

-->

<section class="bg-white pt-5">
    <div class="container">

        <div class="row">
            <h2 class="fw-bold">محاسبه شاخص توده بدنی (BMI)</h2>
            <p class="mt-3">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
        </div>

        <div class="row align-items-end">
            <div class="col-lg-5 order-1 order-lg-0 mt-3 mt-lg-0">
                <div class="mb-4 text-center">
                    <p class="fw-bold">برای محاسبه شاخص توده بدنی (BMI) خود، فرم زیر را پر کنید:</p>
                </div>
                <div class="row align-items-center mb-4">
                    <div class="col-1 fw-bold">قد:</div>
                    <div class="col-11">
                        <input type="text" placeholder="به سانتیمتر (مثلا‌:180)" id="bmi_height" class="form-control rounded-pill border border-3 border-primary">
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-1 fw-bold">وزن:</div>
                    <div class="col-11">
                        <input type="text" placeholder="به کیلوگرم (مثلا‌:82.5)" id="bmi_height" class="form-control rounded-pill border border-3 border-primary">
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary rounded-pill px-5 mt-4 mb-5">محاسبه BMI</button>
                </div>
            </div>
            <div class="col-lg-7 order-0 text-center">
                <img class="img-fluid" src="<?= F1_THEME_ASSET_URL . "images/home-page/firstpage-bmi-02.svg" ?>" width="450"/>
            </div>
        </div>

    </div>
</section>


