<header class="f1-navbar">

    <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">


            <!--Logo-->
            <a class="navbar-brand" href="<?= home_url() ?>">
                <img src="<?= F1_THEME_ASSET_URL . "images/partials/logo.png" ?>" alt="logo" width="60">
            </a>

            <!--icon menu mobile-->
            <svg class="bi bi-list d-block d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasmenu" id="icon-menu-mobile" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>

            <!--menu-->
            <ul class="navbar-nav ms-auto fw-bold d-none d-lg-flex">

                <li class="nav-item">
                    <a class="nav-link active" href="<?= home_url() ?>">صفحه نخست</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">مجله آموزشی</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">مربی‌ها</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                        تماس با ما
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-end" href="#">همکاری با ما</a></li>
                        <li><a class="dropdown-item text-end" href="#">سوالات پرتکرار</a></li>
                        <li><a class="dropdown-item text-end" href="#">شماره کارت</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= home_url() ?>">درباره ما</a>
                </li>


            </ul>

            <!--search input-->
            <div id="search-input" class="d-flex position-relative align-items-center w-25 ms-5 d-none d-lg-flex">
                <input type="search" class="form-control rounded-pill" placeholder="جستجو...">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </div>

            <!--instagram link-->
            <img class="ms-2 d-none d-lg-flex" src="<?= F1_THEME_ASSET_URL . "images/partials/header-instagram.svg" ?>" width="35" alt="instagram"/>

            <!--account button-->
            <button type="button" class="btn btn-primary d-none d-lg-flex">حساب کاربری</button>

        </div>
    </nav>

    <!--offcanvas-->
    <div class="offcanvas offcanvas-end f1-offcanvas" tabindex="-1" id="offcanvasmenu">

        <div class="offcanvas-header">

            <!--close offcanvas-->
            <svg class="bi bi-x btn-close me-auto" data-bs-dismiss="offcanvas" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>

        </div>

        <div class="offcanvas-body">

            <!--Logo-->
            <div class="text-center my-3">
                <a href="<?= home_url() ?>">
                    <img src="<?= F1_THEME_ASSET_URL . "images/partials/logo.png" ?>" alt="logo" width="80">
                </a>
            </div>

            <!--search input-->
            <div id="search-input" class="d-flex position-relative align-items-center">
                <input type="search" class="form-control rounded-pill" placeholder="جستجو...">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </div>

            <!--menu-->
            <ul class="list-unstyled p-0">

                <li class="f1-offcanvas-menu-item">
                    <a class="f1-offcanvas-menu-link active" href="<?= home_url() ?>">صفحه نخست</a>
                </li>

                <li class="f1-offcanvas-menu-item">
                    <a class="f1-offcanvas-menu-link" href="#">مجله آموزشی</a>
                </li>

                <li class="f1-offcanvas-menu-item">
                    <a class="f1-offcanvas-menu-link" href="#">مربی‌ها</a>
                </li>

                <li class="f1-offcanvas-menu-item">
                    <div class="f1-offcanvas-menu-link" href="#">تماس با ما</div>
                    <ul class="list-unstyled p-0">

                        <li class="f1-offcanvas-submenu-item">
                            <a class="f1-offcanvas-submenu-link" href="<?= home_url() ?>">همکاری با ما</a>
                        </li>

                        <li class="f1-offcanvas-submenu-item">
                            <a class="f1-offcanvas-submenu-link active" href="<?= home_url() ?>">سوالات پرتکرار</a>
                        </li>

                        <li class="f1-offcanvas-submenu-item">
                            <a class="f1-offcanvas-submenu-link active" href="<?= home_url() ?>">شماره کارت</a>
                        </li>

                    </ul>
                </li>

                <li class="f1-offcanvas-menu-item">
                    <a class="f1-offcanvas-menu-link" href="<?= home_url() ?>">درباره ما</a>
                </li>

            </ul>

        </div>

    </div>

</header>


