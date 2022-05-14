<!--

account sidebar

-->

<?php
/**
 * @var $current_user
 * @var $tickets
 * @var $users
 */
?>

<header class="uk-position-fixed f1-account-header f1-background-white">

    <div class="uk-container uk-container-expand">

        <nav class="uk-navbar" uk-navbar>

            <div class="uk-navbar-right">

                <!--Logo Mobile-->
                <div class="uk-navbar-item uk-hidden@m">
                    <a href="<?= home_url() ?>"><img src="<?php echo F1_THEME_ASSET_URL . 'images/partials/logo.png' ?>" width="50"></a>
                </div>
                <!--/Logo Mobile-->

                <!--Title Page-->
                <div class="uk-navbar-item uk-visible@m">
                    <h5 id="f1_title_account_page" class="f1-text-black uk-text-bold"></h5>
                </div>
                <!--/Title Page-->

            </div>

            <div class="uk-navbar-left">

                <ul class="uk-navbar-nav">
                    <li class="uk-hidden@m"><a class="uk-navbar-toggle" uk-toggle uk-navbar-toggle-icon href="#offcanvas-nav" uk-tooltip></a></li>
                </ul>

            </div>

        </nav>

    </div>

</header>

<!-- regionOFFCANVAS -->
<div id="offcanvas-nav" data-uk-offcanvas="flip: true; overlay: true">

    <div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide f1-background-white">

        <button class="uk-offcanvas-close uk-close f1-text-black" type="button" uk-close></button>

        <ul class="uk-nav uk-nav-default">

            <!--Coach Manage-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/coach/manage' ) ?>"><span class="uk-margin-small-right f1-text-black" uk-icon="icon: users"></span>مربیان</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Coach Manage-->

            <!--Order Coach-->
			<?php if ( current_user_can( 'f1_athlete' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/order/coach' ) ?>"><span class="uk-margin-small-right f1-text-black" uk-icon="icon: users"></span>مربیان</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Order Coach-->

            <!--Accounting-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li class="uk-parent"><a class="f1-text-black" href="#"><span data-uk-icon="icon: credit-card" class="uk-margin-small-right f1-text-black"></span>حسابداری</a>
                    <ul class="uk-nav-sub">
                        <li><a class="f1-text-black" href="<?= home_url( 'account/accounting/transactions' ) ?>">تراکنش ها</a></li>
                        <li><a class="f1-text-black" href="<?= home_url( 'account/accounting/paid' ) ?>">پرداختی ها</a></li>
                    </ul>
                </li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Accounting-->

            <!--Student-->
			<?php if ( current_user_can( 'f1_coach' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/order/athlete' ) ?>"><span data-uk-icon=" icon: users" class="uk-margin-small-right f1-text-black"></span>شاگردها</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Student-->

            <!--Finance-->
			<?php if ( current_user_can( 'f1_coach' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/finance/settlement' ) ?>"><span data-uk-icon="icon:  credit-card" class="uk-margin-small-right f1-text-black"></span>مالی</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Finance-->

            <!--Coach Profile-->
			<?php if ( current_user_can( 'f1_coach' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/profile/coach' ) ?>"><span data-uk-icon="icon: user" class="uk-margin-small-right f1-text-black"></span>پروفایل مربی</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Coach Profile-->

            <!--Athlete Profile-->
			<?php if ( current_user_can( 'f1_athlete' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/profile/athlete' ) ?>"><span data-uk-icon="icon: user" class="uk-margin-small-right f1-text-black"></span>پروفایل ورزشکار</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Athlete Profile-->

            <!--Transactions-->
			<?php if ( current_user_can( 'f1_athlete' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/finance/transactions' ) ?>"><span data-uk-icon="icon:  credit-card" class="uk-margin-small-right f1-text-black"></span>پرداخت ها</a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Transactions-->

            <!--user Support-->
			<?php if ( array_intersect( [ 'f1_coach', 'f1_athlete' ], $current_user->roles ) ): ?>
                <li class="uk-parent"><a class="f1-text-black" href="#"><span data-uk-icon="icon: lifesaver" class="uk-margin-small-right f1-text-black"></span>پشتیبانی کاربران</a>
                    <ul class="uk-nav-sub">
                        <li><a class="f1-text-black" href="<?= home_url( 'account/support/new_ticket' ) ?>">تیکت جدید</a></li>
                        <li><a class="f1-text-black" href="<?= home_url( 'account/support/tickets' ) ?>">تیکت ها</a></li>
                    </ul>
                </li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/userSupport-->

            <!--Tickets-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li><a class="f1-text-black" href="<?= home_url( 'account/support/tickets' ) ?>"><span uk-icon="icon: comments" class="uk-margin-small-right f1-text-black"></span>تیکت ها<span class="uk-badge"><?= $tickets->unclosed_ticket() ?></span></a></li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Tickets-->

            <!--Tools-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li class="uk-parent"><a class="f1-text-black" href="#"><span data-uk-icon="icon: settings" class="uk-margin-small-right f1-text-black"></span>ابزارها</a>
                    <ul class="uk-nav-sub">
                        <li><a class="f1-text-black" href="<?= home_url( 'account/tools/exports' ) ?>">خروجی گرفتن</a></li>
                    </ul>
                </li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Tools-->

            <!--Setting-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li class="uk-parent"><a class="f1-text-black" href="#"><span data-uk-icon="icon: cog" class="uk-margin-small-right f1-text-black"></span>تنظیمات</a>
                    <ul class="uk-nav-sub">
                        <li><a class="f1-text-black" href="<?= home_url( 'account/setting/payment' ) ?>">درگاه های پرداخت</a></li>
                    </ul>
                </li>
                <li class="uk-nav-divider"></li>
			<?php endif; ?>
            <!--/Setting-->

            <!--Footer-->
            <li><a class="f1-text-black" href="<?php echo home_url() ?>"><span class="uk-margin-small-right uk-icon" data-uk-icon="icon: home"></span>صفحه اصلی</a></li>
            <li><a class="f1-text-black" href="<?php echo wp_logout_url( home_url() ) ?>"><span class="uk-margin-small-right uk-icon" data-uk-icon="icon: sign-out"></span>خروج</a></li>
            <!--/Footer-->

        </ul>

    </div>

</div>
<!-- endregion -->
