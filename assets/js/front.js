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

        });
    }

}

Front.instance();