<?php

$account_url = "account/coach/manage";

if ( current_user_can( "f1_coach" ) ) {
	$account_url = "account/order/athlete";
}

if ( current_user_can( "f1_athlete" ) ) {
	$account_url = "account/order/coach";
}

?>

<header>

    <!--navbar-->
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar f1-py-5" uk-navbar="offset:-20;">

            <div class="uk-navbar-right ">

                <!--Logo-->
                <a class="uk-navbar-item uk-logo" href="<?= home_url() ?>">
                    <img src="<?= F1_THEME_ASSET_URL . "images/partials/logo.png" ?>" alt="logo" width="60">
                </a>

                <!--Menu-->
                <ul class="uk-navbar-nav uk-visible@m">
                    <li id="f1_nav_home"><a href="<?= home_url() ?>">صفحه نخست</a></li>
                    <li id="f1_nav_blog"><a href="<?= home_url( 'blog' ) ?>">مجله آموزشی</a></li>
                    <li id="f1_nav_coach"><a href="<?= home_url( 'coach' ) ?>">مربی‌ها</a></li>
                    <li id="f1_nav_contact_us"><a href="<?= home_url( 'contact-us' ) ?>">تماس با ما</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="#">همکاری با ما</a></li>
                                <li><a href="#">سوالات پرتکرار</a></li>
                                <li><a href="#">شماره کارت</a></li>
                            </ul>
                        </div>
                    </li>
                    <li id="f1_nav_about_us"><a href="<?= home_url( 'about-us' ) ?>">درباره ما</a></li>
                </ul>

            </div>

            <div class="uk-navbar-left">

                <!--search input-->
                <form action="<?php echo home_url() ?>" method="get">
                    <div class="uk-inline uk-margin-medium-left uk-visible@m">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>
                        <input name="s" autocomplete="off" placeholder="جستجو..." class="uk-input uk-form-small f1-border-2 uk-border-pill" type="text">
                    </div>
                </form>

                <!--instagram link-->
                <a href="https://www.instagram.com/shahroozfitness">
                    <img class="uk-margin-small-left uk-visible@m" src="<?= F1_THEME_ASSET_URL . "images/partials/header-instagram.svg" ?>" width="30" alt="instagram"/>
                </a>

                <!--account button-->
				<?php if ( is_user_logged_in() ): ?>

                    <a href="<?= home_url( $account_url ) ?>" class="uk-button uk-button-primary uk-button-small uk-visible@m">
						<?php echo "سلام" . " " . get_user_meta( get_current_user_id(), 'first_name', true ) . " عزیز" ?>
                    </a>

				<?php else: ?>

                    <a href="<?= home_url( 'login' ) ?>" class="uk-button uk-button-primary uk-button-small uk-visible@m">
                        حساب کاربری
                    </a>

				<?php endif; ?>

                <!--menu berger-->
                <a class="uk-navbar-toggle uk-hidden@m" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-mobile-menu"></a>

            </div>

        </nav>
    </div>

    <!--offcanvas-->
    <div id="offcanvas-mobile-menu" uk-offcanvas="overlay: true;">
        <div class="uk-offcanvas-bar uk-padding-small f1-background-white">

            <button class="uk-offcanvas-close f1-text-black" type="button" uk-close></button>

            <nav class="uk-navbar f1-py-5">
                <div class="uk-navbar-center ">

                    <!--Logo-->
                    <a class="uk-navbar-item uk-logo f1-ma-10 uk-width-1-1" href="<?= home_url() ?>">
                        <img src="<?= F1_THEME_ASSET_URL . "images/partials/logo.png" ?>" alt="logo" width="80">
                    </a>

                    <!--Menu-->
                    <ul class="uk-nav-default" uk-nav>
                        <li class="uk-active f1-py-5 f1-pr-8"><a class="f1-text-black" href="<?= home_url() ?>">صفحه نخست</a></li>
                        <li class="f1-py-5 f1-pr-8"><a class="f1-text-black" href="<?= home_url( 'blog' ) ?>">مجله آموزشی</a></li>
                        <li class="f1-py-5 f1-pr-8"><a class="f1-text-black" href="<?= home_url( 'coach' ) ?>">مربی‌ها</a></li>
                        <li class="uk-parent f1-py-5 f1-pr-8">
                            <a class="f1-text-black" href="#">تماس با ما</a>
                            <ul class="uk-nav-sub">
                                <li><a class="f1-text-black" href="#">همکاری با ما</a></li>
                                <li><a class="f1-text-black" href="#">سوالات پرتکرار</a></li>
                                <li><a class="f1-text-black" href="#">شماره کارت</a></li>
                            </ul>
                        </li>
                        <li class="f1-py-5 f1-pr-8"><a class="f1-text-black" href="<?= home_url( 'about-us' ) ?>">درباره ما</a></li>
                    </ul>

                    <!--account button-->
					<?php if ( is_user_logged_in() ): ?>

                        <a href="<?= home_url( $account_url ) ?>" class="uk-button f1-background-primary uk-button-small uk-margin-small uk-width-1-1">
							<?php echo "سلام" . " " . get_user_meta( get_current_user_id(), 'first_name', true ) . " عزیز" ?>
                        </a>

					<?php else: ?>

                        <a href="<?= home_url( 'login' ) ?>" class="uk-button f1-background-primary uk-button-small uk-margin-small uk-width-1-1">
                            حساب کاربری
                        </a>

					<?php endif; ?>

                </div>
            </nav>

        </div>
    </div>

</header>


