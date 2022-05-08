class Coach {

    static instance_ = null;

    static instance() {
        if (Coach.instance_ === null) {
            Coach.instance_ = new Coach();
        }
    }

    constructor() {
        this.onclick();
        this.sortable();
        this.modal();
    }

    onclick() {
        jQuery(document).ready(function ($) {

            /*New Record Coach Information*/
            $(document).on("click", "#f1_coach_information_new_record", function () {
                var container = $("<div>", {class: "uk-flex uk-flex-middle uk-margin-small-bottom f1-border-1 f1-border-solid f1-border-c3c4c7 uk-padding-small f1-background-f5f5f5", id: "container"});
                var type_information_container = $("<div>", {class: "uk-width-1-4 uk-margin-small-left"});
                var type_information = $("<select>", {class: "uk-select uk-border-pill f1-border-2"})
                    .append(
                        $("<option>", {value: "certificate", text: "مدارک ها"})
                    );
                type_information_container.append(type_information);
                var description_information = $("<div>", {class: "uk-width-expand uk-margin-small-left"})
                    .append(
                        $("<input>", {class: "uk-input uk-border-pill f1-border-2", type: "text", placeholder: "توضیحات"})
                    );
                var options = $("<div>", {class: "uk-width-auto"})
                    .append(
                        $("<span>", {class: "f1-cursor-pointer", "uk-icon": "trash", id: "f1_coach_information_remove_filed"}),
                        $("<span>", {class: "f1-cursor-move", "uk-icon": "move", id: "f1_coach_information_move_filed"})
                    );
                container.append(type_information_container, description_information, options);
                $("#f1_coach_information_container").append(container);
            });

            /*Remove Record Coach Information*/
            $(document).on("click", "#f1_coach_information_remove_filed", function () {
                $(this).parents("div#container").fadeOut(500, function () {
                    $(this).remove();
                });
            });

            /*New Record Coach Prices*/
            $(document).on("click", "#f1_coach_prices_new_record", function () {
                var container = $("<div>", {class: "uk-flex uk-flex-middle uk-margin-small-bottom f1-border-1 f1-border-solid f1-border-c3c4c7 uk-padding-small f1-background-f5f5f5", id: "container"});
                var type_prices_container = $("<div>", {class: "uk-width-1-4 uk-margin-small-left"});
                var type_prices = $("<select>", {class: "uk-select uk-border-pill f1-border-2"})
                    .append(
                        $("<option>", {value: "practice_food", text: "طراحی تمرین و تغذیه"}),
                        $("<option>", {value: "professional_consultation", text: "مشاوره تخصصی"}),
                    );
                type_prices_container.append(type_prices);
                var price = $("<div>", {class: "uk-width-expand uk-margin-small-left"})
                    .append(
                        $("<input>", {class: "uk-input uk-border-pill f1-border-2", type: "number", placeholder: "قیمت دریافت برنامه به تومان"})
                    );
                var options = $("<div>", {class: "uk-width-auto"})
                    .append(
                        $("<span>", {class: "f1-cursor-pointer", "uk-icon": "trash", id: "f1_coach_prices_remove_filed"}),
                        $("<span>", {class: "f1-cursor-move", "uk-icon": "move", id: "f1_coach_prices_move_filed"})
                    );
                container.append(type_prices_container, price, options);
                $("#f1_coach_prices_container").append(container);
            });

            /*Remove Record Coach Prices*/
            $(document).on("click", "#f1_coach_prices_remove_filed", function () {
                $(this).parents("div#container").fadeOut(500, function () {
                    $(this).remove();
                });
            });

            /*Coach Profile Submit*/
            $(document).on("click", "#f1_coach_profile_submit", function () {

                var self = $(this);
                var form_data = new FormData();
                var upload_image = $("#f1_coach_profile_image");
                var is_image = $("#f1_coach_profile_image_remove");
                is_image = is_image.length ? 1 : 0;

                var coach_gender = $("#f1_coach_profile_gender").val();
                var coach_birth = $("#f1_coach_profile_birth").val();
                var coach_height = $("#f1_coach_profile_height").val();
                var coach_weight = $("#f1_coach_profile_weight").val();
                var coach_payment = $("#f1_coach_profile_payment").val();
                var coach_image = upload_image.length ? upload_image.prop('files')[0] : null;
                var coach_branch = $("#f1_coach_profile_branch").val();
                var coach_explanation = $("#f1_coach_profile_explanation").val();

                var coach_type_information = [];
                var coach_desc_information = [];
                var coach_type_program = [];
                var coach_price_program = [];

                $.each($("#f1_coach_information_container").children(), function () {
                    var type_info = $(this).children().eq(0).children("select").val();
                    var desc_info = $(this).children().eq(1).children("input").val();
                    coach_type_information.push(type_info);
                    coach_desc_information.push(desc_info);
                });
                $.each($("#f1_coach_prices_container").children(), function () {
                    var type_program = $(this).children().eq(0).children("select").val();
                    var price_program = $(this).children().eq(1).children("input").val();
                    coach_type_program.push(type_program);
                    coach_price_program.push(price_program);
                });

                form_data.append('nonce', f1_account_coach_data.nonce);
                form_data.append('action', 'f1-account');
                form_data.append('command', 'coach_profile');
                form_data.append('coach_gender', coach_gender);
                form_data.append('coach_birth', coach_birth);
                form_data.append('coach_height', coach_height);
                form_data.append('coach_weight', coach_weight);
                form_data.append('coach_payment', coach_payment);
                form_data.append('coach_image', coach_image);
                form_data.append('coach_explanation', coach_explanation);
                form_data.append('is_image', is_image);
                form_data.append('coach_branch', coach_branch);
                form_data.append('coach_type_information', coach_type_information);
                form_data.append('coach_desc_information', coach_desc_information);
                form_data.append('coach_type_program', coach_type_program);
                form_data.append('coach_price_program', coach_price_program);

                $.ajax({
                    url: f1_account_coach_data.ajax_url,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: form_data,
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            UIkit.notification("<span class='fas fa-check-square f1-ml-7'></span>" + result.message,
                                {pos: 'bottom-left', status: 'success', timeout: 2000});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1500);
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
                        }
                        if (result.status === 'failed') {
                            UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                                {pos: 'bottom-left', status: 'warning', timeout: 2000});
                        }
                    },
                    error() {
                        UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + "مشکل در ارتباط با پایگاه داده",
                            {pos: 'bottom-left', status: 'warning', timeout: 2000});
                    },
                    complete() {
                        self.removeClass('f1-button-spinner-show');
                        self.addClass('f1-button-spinner-hide');
                        self.attr('disabled', false);
                    }
                });

            });

            /*Coach Profile Image Remove*/
            $(document).on("click", "#f1_coach_profile_image_remove", function () {

                var parent = $("#f1_coach_profile_image_container");

                var alert1 = $("<div>", {class: "uk-alert-danger uk-text-small uk-margin-small", "uk-alert": ""}).append(
                    $("<p>").append(
                        $("<span>", {class: "uk-margin-small-left", "uk-icon": "warning"}),
                        "تصویری که انتخاب میکنید به عنوان تصویر شاخص توسط کاربران قابل رویت است."
                    )
                );

                var alert2 = $("<div>", {class: "uk-alert-danger uk-text-small uk-margin-small", "uk-alert": ""}).append(
                    $("<p>").append(
                        $("<span>", {class: "uk-margin-small-left", "uk-icon": "warning"}),
                        "سایز تصویر عرض 1200 و ارتفاع 800 و یا متناسب با این ابعاد است."
                    )
                );

                var alert3 = $("<div>", {class: "uk-alert-danger uk-text-small uk-margin-small", "uk-alert": ""}).append(
                    $("<p>").append(
                        $("<span>", {class: "uk-margin-small-left", "uk-icon": "warning"}),
                        "فرمت های قابل قبول: jpg,png"
                    )
                );

                var alert4 = $("<div>", {class: "uk-alert-danger uk-text-small uk-margin-small", "uk-alert": ""}).append(
                    $("<p>").append(
                        $("<span>", {class: "uk-margin-small-left", "uk-icon": "warning"}),
                        "سایز تصویر شما نباید از 1 مگابایت بیشتر باشد."
                    )
                );

                var upload_image = $("<div>", {class: "uk-margin-small uk-width-1-1", "uk-form-custom": "target:true"}).append(
                    $("<label>", {class: "uk-form-label", text: "آپلود تصویر"}),
                    $("<input>", {id: "f1_coach_profile_image", type: "file"}),
                    $("<input>", {class: "uk-input", placeholder: "یک تصویر انتخاب کنید...", type: "text", disabled: "disabled"})
                );

                parent.children().remove();
                parent.append(alert1, alert2, alert3, alert4, upload_image);
            });

            /*Send Athlete Chat*/
            $(document).on("click", "button[id^=\"f1_send_message_athlete_chat_\"]", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                var message = $("#f1_message_athlete_chat_" + order_id);
                var container = $("#f1_container_athlete_chat_" + order_id);
                var self = $(this);

                $.ajax({
                    url: f1_account_coach_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_coach_data.nonce,
                        command: "send_athlete_chat",
                        order_id: order_id,
                        message: message.val()
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            container.children().remove();
                            container.append(
                                $("<button>", {id: "f1_load_more_athlete_chat_" + order_id, class: "uk-button uk-button-secondary uk-border-pill uk-button-small uk-align-center f1-button-spinner-hide"}).append(
                                    $("<span>", {text: "نمایش بیشتر.."}),
                                    $("<i>", {"uk-spinner": "ratio: 0.8"})
                                ),
                                result.data
                            );
                            container.animate({scrollTop: container.get(0).scrollHeight}, 1000);
                            message.val("");
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
                        }
                        if (result.status === 'failed') {
                            UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                                {pos: 'bottom-left', status: 'warning', timeout: 2000});
                        }
                    },
                    error() {
                        UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + "مشکل در ارتباط با پایگاه داده",
                            {pos: 'bottom-left', status: 'warning', timeout: 2000});
                    },
                    complete() {
                        self.removeClass('f1-button-spinner-show');
                        self.addClass('f1-button-spinner-hide');
                        self.attr('disabled', false);
                    }
                });

            });

            /*Load More Athlete Chat*/
            $(document).on("click", "button[id^=\"f1_load_more_athlete_chat_\"]", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                var container = $("#f1_container_athlete_chat_" + order_id);
                var offset = $(this).data("offset") === undefined ? 2 : $(this).data("offset");
                var self = $(this);

                $.ajax({
                    url: f1_account_coach_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_coach_data.nonce,
                        command: "load_more_athlete_chat",
                        order_id: order_id,
                        offset: offset
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            self.remove();
                            if (result.data !== "") {
                                var current_scroll = (container.scroll().get(0).scrollHeight) - (container.scroll().get(0).clientHeight);
                                container.prepend(
                                    $("<button>", {"data-offset": ++offset, id: "f1_load_more_athlete_chat_" + order_id, class: "uk-button uk-button-secondary uk-border-pill uk-button-small uk-align-center f1-button-spinner-hide"}).append(
                                        $("<span>", {text: "نمایش بیشتر.."}),
                                        $("<i>", {"uk-spinner": "ratio: 0.8"})
                                    ),
                                    result.data
                                );
                                container.scrollTop(current_scroll);
                            }
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
                        }
                        if (result.status === 'failed') {
                            UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                                {pos: 'bottom-left', status: 'warning', timeout: 2000});
                        }
                    },
                    error() {
                        UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + "مشکل در ارتباط با پایگاه داده",
                            {pos: 'bottom-left', status: 'warning', timeout: 2000});
                    },
                    complete() {
                        self.removeClass('f1-button-spinner-show');
                        self.addClass('f1-button-spinner-hide');
                        self.attr('disabled', false);
                    }
                });

            });

            /*Close Order*/
            $(document).on("click", "button[id^=\"f1_deactivate_order_\"]", function () {

                if (confirm('آیا میخواهید این سفارش را ببندید؟')) {

                    var order_id = parseInt(this.id.match(/\d+$/));

                    $.ajax({
                        url: f1_account_coach_data.ajax_url,
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            action: 'f1-account',
                            nonce: f1_account_coach_data.nonce,
                            command: "deactivate_order",
                            order_id: order_id
                        },
                        success(result) {
                            if (result.status === 'success') {
                                UIkit.notification("<span class='fas fa-check-square f1-ml-7'></span>" + result.message,
                                    {pos: 'bottom-left', status: 'success', timeout: 2000});
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1500);
                            }
                            if (result.status === 'reload') {
                                window.location.reload();
                            }
                            if (result.status === 'failed') {
                                UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                                    {pos: 'bottom-left', status: 'warning', timeout: 2000});
                            }
                        },
                        error() {
                            UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + "مشکل در ارتباط با پایگاه داده",
                                {pos: 'bottom-left', status: 'warning', timeout: 2000});
                        },
                    });

                }

            });

        });
    }

    sortable() {
        jQuery(document).ready(function ($) {
            $("#f1_coach_information_container").sortable({handle: "#f1_coach_information_move_filed"}).disableSelection();
            $("#f1_coach_prices_container").sortable({handle: "#f1_coach_prices_move_filed"}).disableSelection();
        });
    }

    modal() {

        jQuery(document).ready(function ($) {

            /*Show Chart Athlete For Coach*/
            UIkit.util.on("div[id^=\"chart_athlete_modal_\"]", "beforeshow", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                UIkit.dropdown($("#f1_options_order_coach_" + order_id)).hide();
                var athlete_wight = $("#f1_athlete_chart_weight_" + order_id);
                var athlete_height = $("#f1_athlete_chart_height_" + order_id);

                $.ajax({
                    url: f1_account_coach_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_coach_data.nonce,
                        command: "show_chart_athlete_for_coach",
                        order_id: order_id
                    },
                    beforeSend() {
                        $("#f1_athlete_chart_weight_container_" + order_id).append($("<i>", {style: "position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);", "uk-spinner": "ratio: 5"}));
                        $("#f1_athlete_chart_height_container_" + order_id).append($("<i>", {style: "position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);", "uk-spinner": "ratio: 5"}));
                    },
                    success(result) {
                        if (result.status === 'success') {

                            var datasets_weight = [];
                            var datasets_height = [];
                            var color = ["#2196f3", "#009688", "#4caf50", "#ff9800", "#ff5722", "#00bcd4"];
                            var color_select = 0;

                            $.each(result.data, function (year, param) {

                                var data_weight = [];
                                var data_height = [];
                                $.each(param.weight, function (month, data) {
                                    data_weight.push(data)
                                });
                                $.each(param.height, function (month, data) {
                                    data_height.push(data)
                                });

                                datasets_weight.push({
                                    data: data_weight,
                                    label: year,
                                    borderColor: color[color_select],
                                    fill: false
                                });
                                datasets_height.push({
                                    data: data_height,
                                    label: year,
                                    borderColor: color[color_select],
                                    fill: false
                                });

                                color_select += 1;

                            });

                            new Chart(athlete_wight, {
                                type: 'line',
                                data: {
                                    labels: [
                                        "فروردین",
                                        "اردیبهشت",
                                        "خرداد",
                                        "تیر",
                                        "مرداد",
                                        "شهریور",
                                        "مهر",
                                        "آبان",
                                        "آذر",
                                        "دی",
                                        "بهمن",
                                        "اسفند",
                                    ],
                                    datasets: datasets_weight
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    responsiveAnimationDuration: 500,
                                    animation: {
                                        duration: 2000
                                    },
                                    title: {
                                        display: false,
                                    }
                                }
                            });
                            new Chart(athlete_height, {
                                type: 'line',
                                data: {
                                    labels: [
                                        "فروردین",
                                        "اردیبهشت",
                                        "خرداد",
                                        "تیر",
                                        "مرداد",
                                        "شهریور",
                                        "مهر",
                                        "آبان",
                                        "آذر",
                                        "دی",
                                        "بهمن",
                                        "اسفند",
                                    ],
                                    datasets: datasets_height
                                },
                                options: {
                                    maintainAspectRatio: false,
                                    responsiveAnimationDuration: 500,
                                    animation: {
                                        duration: 2000
                                    },
                                    title: {
                                        display: false,
                                    }
                                }
                            });

                        }
                        if (result.status === 'reload') {
                            window.location.reload();
                        }
                        if (result.status === 'failed') {
                            UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                                {pos: 'bottom-left', status: 'warning', timeout: 2000});
                        }
                    },
                    error() {
                        UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + "مشکل در ارتباط با پایگاه داده",
                            {pos: 'bottom-left', status: 'warning', timeout: 2000});
                    },
                    complete() {
                        $("#f1_athlete_chart_weight_container_" + order_id).children("i").fadeOut(3000, function () {
                            $(this).remove();
                        });
                        $("#f1_athlete_chart_height_container_" + order_id).children("i").fadeOut(3000, function () {
                            $(this).remove();
                        });
                    }
                });

            });

            /*Show Athlete Chat For Coach*/
            UIkit.util.on("div[id^=\"chat_athlete_modal_\"]", "shown", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                UIkit.dropdown($("#f1_options_order_coach_" + order_id)).hide();
                var container = $("#f1_container_athlete_chat_" + order_id);

                $.ajax({
                    url: f1_account_coach_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_coach_data.nonce,
                        command: "show_athlete_chat",
                        order_id: order_id
                    },
                    success(result) {
                        if (result.status === 'success') {

                            container.children().remove();
                            container.append(
                                $("<button>", {id: "f1_load_more_athlete_chat_" + order_id, class: "uk-button uk-button-secondary uk-border-pill uk-button-small uk-align-center f1-button-spinner-hide"}).append(
                                    $("<span>", {text: "نمایش بیشتر.."}),
                                    $("<i>", {"uk-spinner": "ratio: 0.8"})
                                ),
                                result.data
                            );
                            container.animate({scrollTop: container.get(0).scrollHeight}, 1000);

                        }
                        if (result.status === 'reload') {
                            window.location.reload();
                        }
                        if (result.status === 'failed') {
                            UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                                {pos: 'bottom-left', status: 'warning', timeout: 2000});
                        }
                    },
                    error() {
                        UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + "مشکل در ارتباط با پایگاه داده",
                            {pos: 'bottom-left', status: 'warning', timeout: 2000});
                    }
                });

            });


        });

    }

}

Coach.instance();