class Login {

    static instance_ = null;

    static site_key = "6Lcw380cAAAAAMZQueju19ZVuqGLgtUHxSiw-ujO";

    static instance() {
        if (Login.instance_ === null) {
            Login.instance_ = new Login();
        }
    }

    constructor() {
        this.onclick();
    }

    resend_otp_in_register(time, display) {
        jQuery(document).ready(function ($) {

            var m = Math.floor(time / 60);
            var s = time % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;

            $(display).text(m + ':' + s + ' : تا ارسال مجدد رمز یکبار مصرف');
            time -= 1;

            if (time >= 0) {
                setTimeout(function () {
                    Login.prototype.resend_otp_in_register(time, display);
                }, 1000);
                return;
            }

            $(display).parents("div.uk-width-1-1").remove();
            $("#f1_login_container").children().eq(7).after(
                $("<div>", {class: "uk-width-1-1"}).append(
                    $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_request_otp_in_register"}).append(
                        $("<span>", {text: "درخواست رمز یکبار مصرف"}),
                        $("<i>", {"uk-spinner": "ratio: 0.8"})
                    )
                )
            )
        });
    }

    resend_otp_in_change_password(time, display) {
        jQuery(document).ready(function ($) {

            var m = Math.floor(time / 60);
            var s = time % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;

            $(display).text(m + ':' + s + ' : تا ارسال مجدد رمز یکبار مصرف');
            time -= 1;

            if (time >= 0) {
                setTimeout(function () {
                    Login.prototype.resend_otp_in_change_password(time, display);
                }, 1000);
                return;
            }

            $(display).parents("div.uk-width-1-1").remove();
            $("#f1_login_container").children().eq(3).after(
                $("<div>", {class: "uk-width-1-1"}).append(
                    $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_request_otp_in_change_password"}).append(
                        $("<span>", {text: "درخواست رمز یکبار مصرف"}),
                        $("<i>", {"uk-spinner": "ratio: 0.8"})
                    )
                )
            )
        });
    }

    onclick() {
        jQuery(document).ready(function ($) {

            /*Login OR Register*/
            $(document).on("click", "#f1_login_or_register", function () {

                var self = $(this);
                var user_phone_number = $("#f1_user_phone_number").val();
                var container = $("#f1_login_container");
                self.addClass('f1-button-spinner-show');
                self.removeClass('f1-button-spinner-hide');
                self.attr('disabled', true);

                grecaptcha.ready(function () {
                    grecaptcha.execute(Login.site_key, {action: "login_or_register"}).then(function (token) {

                        $.ajax({
                            url: f1_login_data.ajax_url,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                action: 'f1-login',
                                nonce: f1_login_data.nonce,
                                command: "login_or_register",
                                token: token,
                                user_phone_number: user_phone_number
                            },
                            success(result) {
                                if (result.status === 'register') {
                                    container.children().remove();
                                    container.append(
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "user"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_name", type: "text", placeholder: "نام"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "user"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_family", type: "text", placeholder: "نام خانوادگی"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "receiver"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2 f1-ltr", id: "f1_user_phone_number", maxlength: 10, value: user_phone_number, type: "tel", placeholder: "9121234567"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "mail"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2 f1-ltr", id: "f1_user_email", type: "email", placeholder: "ایمیل"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<select>", {class: "uk-select uk-border-pill f1-border-2", id: "f1_user_role"}).append(
                                                $("<option>", {value: "role", text: "نقش کاربری"}),
                                                $("<option>", {value: "coach", text: "مربی"}),
                                                $("<option>", {value: "athlete", text: "ورزشکار"})
                                            )
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "lock"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_password", type: "text", placeholder: "رمز عبور"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "phone"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_otp_code", maxlength: 6, placeholder: "رمز یکبار مصرف"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_register"}).append(
                                                $("<span>", {text: "ثبت نام"}),
                                                $("<i>", {"uk-spinner": "ratio: 0.8"})
                                            )
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_request_otp_in_register"}).append(
                                                $("<span>", {text: "درخواست رمز یکبار مصرف"}),
                                                $("<i>", {"uk-spinner": "ratio: 0.8"})
                                            )
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {id: "f1_mistake_phone_number", class: "uk-button uk-button-link uk-width-1-1", type: "button", text: "شماره خود را اشتباه وارد کردم"})
                                        )
                                    );
                                }
                                if (result.status === 'login') {
                                    container.children().remove();
                                    container.append(
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "receiver"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_phone_number", maxlength: 10, value: user_phone_number, type: "tel", placeholder: "9121234567"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "lock"}),
                                            $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_password", type: "password", placeholder: "رمز عبور"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_login"}).append(
                                                $("<span>", {text: "ورود"}),
                                                $("<i>", {"uk-spinner": "ratio: 0.8"})
                                            )
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {class: "uk-button uk-button-link uk-width-1-1", type: "button", text: "رمز خود را فراموش کردم", id: "f1_forget_password"})
                                        )
                                    );
                                }
                                if (result.status === 'failed') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                                }
                            },
                            error() {
                                UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مشکل در ارتباط با پایگاه داده",
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            },
                            complete() {
                                self.removeClass('f1-button-spinner-show');
                                self.addClass('f1-button-spinner-hide');
                                self.attr('disabled', false);
                            }
                        });

                    });
                });

            });

            /*Mistake Phone Number*/
            $(document).on("click", "#f1_mistake_phone_number", function () {
                location.reload();
            });

            /*Forget My Password*/
            $(document).on("click", "#f1_forget_password", function () {
                var container = $("#f1_login_container");
                var user_phone_number = $("#f1_user_phone_number").val();
                container.children().remove();
                container.append(
                    $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                        $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "receiver"}),
                        $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_phone_number", maxlength: 10, value: user_phone_number, type: "tel", placeholder: "9121234567"})
                    ),
                    $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                        $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "lock"}),
                        $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_user_new_password", type: "text", placeholder: "رمز عبور جدید"})
                    ),
                    $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                        $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "phone"}),
                        $("<input>", {class: "uk-input uk-border-pill f1-border-2", id: "f1_otp_code", maxlength: 6, placeholder: "رمز یکبار مصرف"})
                    ),
                    $("<div>", {class: "uk-width-1-1"}).append(
                        $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_change_password"}).append(
                            $("<span>", {text: "تغییر رمز عبور"}),
                            $("<i>", {"uk-spinner": "ratio: 0.8"})
                        )
                    ),
                    $("<div>", {class: "uk-width-1-1"}).append(
                        $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_request_otp_in_change_password"}).append(
                            $("<span>", {text: "درخواست رمز یکبار مصرف"}),
                            $("<i>", {"uk-spinner": "ratio: 0.8"})
                        )
                    ),
                );
            });

            /*Request OTP In Register*/
            $(document).on("click", "#f1_request_otp_in_register", function () {
                var self = $(this);
                var user_phone_number = $("#f1_user_phone_number").val();
                self.addClass('f1-button-spinner-show');
                self.removeClass('f1-button-spinner-hide');
                self.attr('disabled', true);

                grecaptcha.ready(function () {
                    grecaptcha.execute(Login.site_key, {action: "request_otp_in_register"}).then(function (token) {

                        $.ajax({
                            url: f1_login_data.ajax_url,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                action: 'f1-login',
                                nonce: f1_login_data.nonce,
                                command: "request_otp_in_register",
                                token: token,
                                user_phone_number: user_phone_number
                            },
                            success(result) {
                                if (result.status === 'success') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'success', timeout: 2000});
                                    self.parents("div.uk-width-1-1").remove();
                                    $("#f1_login_container").children().eq(7).after(
                                        $("<div>", {class: "uk-width-1-1 uk-text-center"}).append(
                                            $("<span>", {class: "uk-text-meta", id: "f1_timer"})
                                        )
                                    );
                                    Login.prototype.resend_otp_in_register(120, "#f1_timer");
                                }
                                if (result.status === 'failed') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                                }
                            },
                            error() {
                                UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مشکل در ارتباط با پایگاه داده",
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            },
                            complete() {
                                self.removeClass('f1-button-spinner-show');
                                self.addClass('f1-button-spinner-hide');
                                self.attr('disabled', false);
                            }
                        });

                    });
                });
            });

            /*Request OTP In Change Password*/
            $(document).on("click", "#f1_request_otp_in_change_password", function () {
                var self = $(this);
                var user_phone_number = $("#f1_user_phone_number").val();
                self.addClass('f1-button-spinner-show');
                self.removeClass('f1-button-spinner-hide');
                self.attr('disabled', true);

                grecaptcha.ready(function () {
                    grecaptcha.execute(Login.site_key, {action: "request_otp_in_change_password"}).then(function (token) {

                        $.ajax({
                            url: f1_login_data.ajax_url,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                action: 'f1-login',
                                nonce: f1_login_data.nonce,
                                command: "request_otp_in_change_password",
                                token: token,
                                user_phone_number: user_phone_number
                            },
                            success(result) {
                                if (result.status === 'success') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'success', timeout: 2000});
                                    self.parents("div.uk-width-1-1").remove();
                                    $("#f1_login_container").children().eq(3).after(
                                        $("<div>", {class: "uk-width-1-1 uk-text-center"}).append(
                                            $("<span>", {class: "uk-text-meta", id: "f1_timer"})
                                        )
                                    );
                                    Login.prototype.resend_otp_in_change_password(120, "#f1_timer");
                                }
                                if (result.status === 'failed') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                                }
                            },
                            error() {
                                UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مشکل در ارتباط با پایگاه داده",
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            },
                            complete() {
                                self.removeClass('f1-button-spinner-show');
                                self.addClass('f1-button-spinner-hide');
                                self.attr('disabled', false);
                            }
                        });

                    });
                });
            });

            /*Register*/
            $(document).on("click", "#f1_register", function () {

                var self = $(this);
                var user_name = $("#f1_user_name").val();
                var user_family = $("#f1_user_family").val();
                var user_phone_number = $("#f1_user_phone_number").val();
                var user_email = $("#f1_user_email").val();
                var user_role = $("#f1_user_role").val();
                var user_password = $("#f1_user_password").val();
                var otp_code = $("#f1_otp_code").val();
                self.addClass('f1-button-spinner-show');
                self.removeClass('f1-button-spinner-hide');
                self.attr('disabled', true);

                grecaptcha.ready(function () {
                    grecaptcha.execute(Login.site_key, {action: "register"}).then(function (token) {

                        $.ajax({
                            url: f1_login_data.ajax_url,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                action: 'f1-login',
                                nonce: f1_login_data.nonce,
                                command: "register",
                                token: token,
                                user_name: user_name,
                                user_family: user_family,
                                user_phone_number: user_phone_number,
                                user_email: user_email,
                                user_role: user_role,
                                user_password: user_password,
                                otp_code: otp_code
                            },
                            success(result) {
                                if (result.status === 'success') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'success', timeout: 2000});
                                    setTimeout(function () {
                                        window.location.replace(result.data);
                                    }, 1500);
                                }
                                if (result.status === 'failed') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                                }
                            },
                            error() {
                                UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مشکل در ارتباط با پایگاه داده",
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            },
                            complete() {
                                self.removeClass('f1-button-spinner-show');
                                self.addClass('f1-button-spinner-hide');
                                self.attr('disabled', false);
                            }
                        });

                    });
                });

            });

            /*Login*/
            $(document).on("click", "#f1_login", function () {

                var self = $(this);
                var user_phone_number = $("#f1_user_phone_number").val();
                var user_password = $("#f1_user_password").val();
                self.addClass('f1-button-spinner-show');
                self.removeClass('f1-button-spinner-hide');
                self.attr('disabled', true);

                grecaptcha.ready(function () {
                    grecaptcha.execute(Login.site_key, {action: "login"}).then(function (token) {

                        $.ajax({
                            url: f1_login_data.ajax_url,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                action: 'f1-login',
                                nonce: f1_login_data.nonce,
                                command: "login",
                                token: token,
                                user_phone_number: user_phone_number,
                                user_password: user_password
                            },
                            success(result) {
                                if (result.status === 'success') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'success', timeout: 2000});
                                    setTimeout(function () {
                                        window.location.replace(result.data);
                                    }, 1500);
                                }
                                if (result.status === 'failed') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                                }
                            },
                            error() {
                                UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مشکل در ارتباط با پایگاه داده",
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            },
                            complete() {
                                self.removeClass('f1-button-spinner-show');
                                self.addClass('f1-button-spinner-hide');
                                self.attr('disabled', false);
                            }
                        });

                    });
                });

            });

            /*Change Password*/
            $(document).on("click", "#f1_change_password", function () {

                var self = $(this);
                var container = $("#f1_login_container");
                var user_phone_number = $("#f1_user_phone_number").val();
                var user_new_password = $("#f1_user_new_password").val();
                var otp_code = $("#f1_otp_code").val();
                self.addClass('f1-button-spinner-show');
                self.removeClass('f1-button-spinner-hide');
                self.attr('disabled', true);

                grecaptcha.ready(function () {
                    grecaptcha.execute(Login.site_key, {action: "change_password"}).then(function (token) {

                        $.ajax({
                            url: f1_login_data.ajax_url,
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                action: 'f1-login',
                                nonce: f1_login_data.nonce,
                                command: "change_password",
                                token: token,
                                user_phone_number: user_phone_number,
                                user_new_password: user_new_password,
                                otp_code: otp_code
                            },
                            success(result) {
                                if (result.status === 'success') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'success', timeout: 2000});
                                    container.children().remove();
                                    container.append(
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "receiver"}),
                                            $("<input>", {class: "uk-input uk-form-small", id: "f1_user_phone_number", maxlength: 10, value: user_phone_number, type: "tel", placeholder: "9121234567"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1 uk-inline"}).append(
                                            $("<span>", {class: "uk-form-icon uk-form-icon-flip", 'uk-icon': "lock"}),
                                            $("<input>", {class: "uk-input uk-form-small", id: "f1_user_password", type: "password", placeholder: "رمز عبور"})
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {class: "uk-button uk-button-primary uk-button-small f1-button-spinner-hide uk-width-1-1 uk-border-pill", type: "button", id: "f1_login"}).append(
                                                $("<span>", {text: "ورود"}),
                                                $("<i>", {"uk-spinner": "ratio: 0.8"})
                                            )
                                        ),
                                        $("<div>", {class: "uk-width-1-1"}).append(
                                            $("<button>", {class: "uk-button uk-button-link uk-width-1-1", type: "button", text: "رمز خود را فراموش کردم", id: "f1_forget_password"})
                                        )
                                    );
                                }
                                if (result.status === 'failed') {
                                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                                }
                            },
                            error() {
                                UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مشکل در ارتباط با پایگاه داده",
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            },
                            complete() {
                                self.removeClass('f1-button-spinner-show');
                                self.addClass('f1-button-spinner-hide');
                                self.attr('disabled', false);
                            }
                        });

                    });
                });

            });

        });
    }

}

Login.instance();