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

<aside class="f1-account-sidebar uk-visible@m">

    <!--Logo-->
    <div class="f1-account-sidebar-logo uk-flex uk-flex-middle uk-flex-center">
        <a class="uk-logo" href="<?= home_url() ?>">
            <img src="<?php echo F1_THEME_ASSET_URL . 'images/partials/logo.png' ?>" alt="logo" width="60">
        </a>
        <span class="uk-text-small">شهروز فیتنس</span>
    </div>
    <!--/Logo-->

    <!--User Info-->
    <div class="f1-account-sidebar-box-user">

        <!--Avatar-->
        <img id="profile" src="<?php echo get_avatar_url( get_current_user_id() ) ?>" alt="avatar" class="uk-border-circle">
        <!--/Avatar-->

        <!--Display Name-->
        <h4 class="uk-text-center uk-margin-remove-vertical f1-text-light"><?= $current_user->display_name ?></h4>
        <!--/Display Name-->

        <!--Display Login-->
        <div class="uk-text-center">
            <p class="uk-text-small uk-text-muted uk-margin-remove-bottom"><?= $current_user->user_login ?></p>
        </div>
        <!--/Display Login-->

    </div>
    <!--/User Info-->

    <!--Menu-->
    <div class="f1-account-sidebar-menu-wrap">

        <ul class="uk-nav uk-nav-default uk-nav-parent-icon" id="f1_sidebar_account" uk-nav>

            <!--Coach Manage-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li id="coach_manage_menu"><a href="<?= home_url( 'account/coach/manage' ) ?>"><span uk-icon="icon: users" class="uk-margin-small-right"></span>مربیان</a></li>
			<?php endif; ?>
            <!--/Coach Manage-->

            <!--Order Coach-->
			<?php if ( current_user_can( 'f1_athlete' ) ): ?>
                <li id="coach_menu"><a href="<?= home_url( 'account/order/coach' ) ?>"><span uk-icon="icon: users" class="uk-margin-small-right"></span>مربیان</a></li>
			<?php endif; ?>
            <!--/Order Coach-->

            <!--Accounting-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li class="uk-parent" id="accounting_menu"><a href="#"><span data-uk-icon="icon: credit-card" class="uk-margin-small-right"></span>حسابداری</a>
                    <ul class="uk-nav-sub">
                        <li><a href="<?= home_url( 'account/accounting/transactions' ) ?>">تراکنش ها</a></li>
                        <li><a href="<?= home_url( 'account/accounting/paid' ) ?>">پرداختی ها</a></li>
                        <li><a href="<?= home_url( 'account/accounting/configuration' ) ?>">پیکربندی ها</a></li>
                    </ul>
                </li>
			<?php endif; ?>
            <!--/Accounting-->

            <!--Student-->
			<?php if ( current_user_can( 'f1_coach' ) ): ?>
                <li id="student_menu"><a href="<?= home_url( 'account/order/athlete' ) ?>"><span data-uk-icon=" icon: users" class="uk-margin-small-right"></span>شاگردها</a></li>
			<?php endif; ?>
            <!--/Student-->

            <!--Finance-->
			<?php if ( current_user_can( 'f1_coach' ) ): ?>
                <li id="finance_menu"><a href="<?= home_url( 'account/finance/settlement' ) ?>"><span data-uk-icon="icon:  credit-card" class="uk-margin-small-right"></span>مالی</a></li>
			<?php endif; ?>
            <!--/Finance-->

            <!--Coach Profile-->
			<?php if ( current_user_can( 'f1_coach' ) ): ?>
                <li id="coach_profile_menu"><a href="<?= home_url( 'account/coach/profile' ) ?>"><span data-uk-icon="icon: user" class="uk-margin-small-right"></span>پروفایل مربی</a></li>
			<?php endif; ?>
            <!--/Coach Profile-->

            <!--Athlete Profile-->
			<?php if ( current_user_can( 'f1_athlete' ) ): ?>
                <li id="athlete_profile_menu"><a href="<?= home_url( 'account/athlete/profile' ) ?>"><span data-uk-icon="icon: user" class="uk-margin-small-right"></span>پروفایل ورزشکار</a></li>
			<?php endif; ?>
            <!--/Athlete Profile-->

            <!--Transactions-->
			<?php if ( current_user_can( 'f1_athlete' ) ): ?>
                <li id="transactions_athlete_menu"><a href="<?= home_url( 'account/finance/transactions' ) ?>"><span data-uk-icon="icon:  credit-card" class="uk-margin-small-right"></span>پرداخت ها</a></li>
			<?php endif; ?>
            <!--/Transactions-->

            <!--user Support-->
			<?php if ( array_intersect( [ 'f1_coach', 'f1_athlete' ], $current_user->roles ) ): ?>
                <li class="uk-parent" id="user_support_menu"><a href="#"><span data-uk-icon="icon: lifesaver" class="uk-margin-small-right"></span>پشتیبانی کاربران</a>
                    <ul class="uk-nav-sub">
                        <li><a href="<?= home_url( 'account/support/new_ticket' ) ?>">تیکت جدید</a></li>
                        <li><a href="<?= home_url( 'account/support/tickets' ) ?>">تیکت ها</a></li>
                    </ul>
                </li>
			<?php endif; ?>
            <!--/userSupport-->

            <!--Tickets-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li id="tickets_menu"><a href="<?= home_url( 'account/support/tickets' ) ?>"><span uk-icon="icon: comments" class="uk-margin-small-right"></span>تیکت ها<span class="uk-badge"><?= $tickets->unclosed_ticket() ?></span></a></li>
			<?php endif; ?>
            <!--/Tickets-->

            <!--Tools-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li class="uk-parent" id="tools_menu"><a href="#"><span data-uk-icon="icon: settings" class="uk-margin-small-right"></span>ابزارها</a>
                    <ul class="uk-nav-sub">
                        <li><a href="<?= home_url( 'account/tools/exports' ) ?>">خروجی گرفتن</a></li>
                    </ul>
                </li>
			<?php endif; ?>
            <!--/Tools-->

            <!--Setting-->
			<?php if ( current_user_can( 'administrator' ) ): ?>
                <li class="uk-parent" id="setting_menu"><a href="#"><span data-uk-icon="icon: cog" class="uk-margin-small-right"></span>تنظیمات</a>
                    <ul class="uk-nav-sub">
                        <li><a href="<?= home_url( 'account/setting/payment' ) ?>">درگاه های پرداخت</a></li>
                    </ul>
                </li>
			<?php endif; ?>
            <!--/Setting-->

        </ul>

    </div>
    <!--/Menu-->

    <!--Footer Sidebar-->
    <div class="f1-account-footer-sidebar uk-background-primary">
        <ul class="uk-subnav uk-flex uk-flex-center uk-child-width-1-5 uk-text-default" uk-grid>
            <li>
                <a href="<?php echo home_url() ?>" class="uk-text-default" uk-icon="icon: home" title="صفحه اصلی" uk-tooltip></a>
            </li>
            <li>
                <a href="<?php echo wp_logout_url( home_url() ) ?>" class="uk-text-default" uk-icon="icon: sign-out" title="خروج" uk-tooltip></a>
            </li>
        </ul>
    </div>
    <!--/Footer Sidebar-->

</aside>

