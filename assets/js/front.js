class Front {

    static instance_ = null;

    static instance() {
        if (Front.instance_ === null) {
            Front.instance_ = new Front();
        }
    }

    constructor() {
        this.init();
        this.onclick();
    }

    counterup(target, start, end) {
        start += 1;
        setTimeout(function () {

            if (start <= end) {
                Front.prototype.counterup(target, start, end);
                target.text("+" + start);
            }

        }, 1);
    }

    init() {
        jQuery(document).ready(function ($) {

            //header
            var current_menu = window.location.pathname;
            switch (current_menu) {
                case "/" :
                    $("#f1_nav_home").addClass("uk-active uk-text-bold");
                    break;
                case "/coach/":
                    $("#f1_nav_coach").addClass("uk-active uk-text-bold");
                    break;
                case  '/blog/' :
                    $("#f1_nav_blog").addClass("uk-active uk-text-bold");
                    break;
                case  '/contact-us/' :
                    $("#f1_nav_contact_us").addClass("uk-active uk-text-bold");
                    break;
                case  '/about-us/' :
                    $("#f1_nav_about_us").addClass("uk-active uk-text-bold");
                    break;
            }

            //counter
            var counters = $(".f1-counter");
            $.each(counters, function (index, item) {
                var end = $(item).data("count");
                Front.prototype.counterup($(item), 0, end)
            });
            /*counters.forEach(function () {
                var end = this.data("count");
                Front.prototype.counterup(this, 0, end)
            });*/

        });
    }

    onclick() {
        jQuery(document).ready(function ($) {

            /*Order Program*/
            $(document).on("click", "button[id^=\"f1_order_\"]", function () {

                var post_id = parseInt(this.id.match(/\d+$/));
                var type_service = this.id.replace("f1_order_", "").trim();
                type_service = type_service.match(/[a-z_]+/)[0];
                var self = $(this);

                $.ajax({
                    url: f1_front_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-shopping',
                        nonce: f1_front_data.nonce,
                        command: "order_program",
                        post_id: post_id,
                        type_service: type_service
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {

                        if (result.status === "redirect") {
                            window.location.replace(result.data);
                        }

                        if (result.status === "failed") {
                            UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + result.message,
                                {pos: 'bottom-left', status: 'warning', timeout: 10000});
                        }

                        if (result.status === "reload") {
                            window.location.reload();
                        }

                        if (result.status === 'success') {
                            var form = $("<form>", {action: result.data, method: "post"}).append(
                                $("<input>", {name: "post_id", value: post_id}),
                                $("<input>", {name: "type_service", value: type_service})
                            );
                            $('body').append(form);
                            form.submit();
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

            /*Calculate BMI*/
            $(document).on("click", "#f1_calculate_bmi", function () {

                var regExp = new RegExp('^\\d+(\\.\\d+)?$');
                var height = $("#f1_bmi_height").val();
                var weight = $("#f1_bmi_weight").val();
                var formula = (weight / Math.pow(height / 100, 2)).toFixed(1);

                if (!regExp.test(height.toString()) || !regExp.test(weight.toString())) {
                    UIkit.notification("<span class='uk-margin-small-left' uk-icon='warning'></span>" + "مقادیر را به عدد وارد کنید!",
                        {pos: 'bottom-left', status: 'warning', timeout: 2000});
                } else {
                    UIkit.notification("<span></span>" + "شاخص توده بدنی شما برابر است با: " + "<span style='font-size: 20px'>" + formula + "</span>",
                        {pos: 'top-center', status: 'success', timeout: 10000});
                }

            });

        });
    }

}

Front.instance();