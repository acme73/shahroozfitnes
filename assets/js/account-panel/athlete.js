class Athlete {

    static instance_ = null;

    static instance() {
        if (Athlete.instance_ === null) {
            Athlete.instance_ = new Athlete();
        }
    }

    constructor() {
        this.onclick();
        this.modal();
        this.chart();
    }

    onclick() {
        jQuery(document).ready(function ($) {

            /*Athlete Profile Submit*/
            $(document).on("click", "#f1_athlete_profile_submit", function () {

                var self = $(this);
                var form_data = new FormData();
                var upload_image_1 = $("#f1_athlete_profile_image_1");
                var upload_image_2 = $("#f1_athlete_profile_image_2");
                var upload_image_3 = $("#f1_athlete_profile_image_3");
                var upload_image_4 = $("#f1_athlete_profile_image_4");

                var athlete_gender = $("#f1_athlete_profile_gender").val();
                var athlete_birth = $("#f1_athlete_profile_birth").val();
                var athlete_image_1 = upload_image_1.length ? upload_image_1.prop('files')[0] : null;
                var athlete_image_2 = upload_image_2.length ? upload_image_2.prop('files')[0] : null;
                var athlete_image_3 = upload_image_3.length ? upload_image_3.prop('files')[0] : null;
                var athlete_image_4 = upload_image_4.length ? upload_image_4.prop('files')[0] : null;

                form_data.append('nonce', f1_account_athlete_data.nonce);
                form_data.append('action', 'f1-account');
                form_data.append('command', 'athlete_profile');
                form_data.append('athlete_gender', athlete_gender);
                form_data.append('athlete_birth', athlete_birth);
                form_data.append('athlete_image_1', athlete_image_1);
                form_data.append('athlete_image_2', athlete_image_2);
                form_data.append('athlete_image_3', athlete_image_3);
                form_data.append('athlete_image_4', athlete_image_4);

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
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
                        if (result.status === 'test') {
                            console.log(result);
                        }
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

            /*Athlete Image 1  Remove*/
            $(document).on("click", "#f1_athlete_profile_image_1_remove", function () {

                var self = $(this);
                var parent = $("#f1_athlete_profile_image_1_container");

                var upload_image = $("<div>", {class: "uk-margin-small uk-width-1-1", "uk-form-custom": "target:true"}).append(
                    $("<label>", {class: "uk-form-label", text: "آپلود تصویر اول"}),
                    $("<input>", {id: "f1_athlete_profile_image_1", type: "file"}),
                    $("<input>", {class: "uk-input", placeholder: "یک تصویر انتخاب کنید...", type: "text", disabled: "disabled"})
                );

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "athlete_image_1_remove"
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            parent.children().remove();
                            parent.append(upload_image);
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

            /*Athlete Image 2  Remove*/
            $(document).on("click", "#f1_athlete_profile_image_2_remove", function () {

                var self = $(this);
                var parent = $("#f1_athlete_profile_image_2_container");

                var upload_image = $("<div>", {class: "uk-margin-small uk-width-1-1", "uk-form-custom": "target:true"}).append(
                    $("<label>", {class: "uk-form-label", text: "آپلود تصویر دوم"}),
                    $("<input>", {id: "f1_athlete_profile_image_2", type: "file"}),
                    $("<input>", {class: "uk-input", placeholder: "یک تصویر انتخاب کنید...", type: "text", disabled: "disabled"})
                );

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "athlete_image_2_remove"
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            parent.children().remove();
                            parent.append(upload_image);
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

            /*Athlete Image 3  Remove*/
            $(document).on("click", "#f1_athlete_profile_image_3_remove", function () {

                var self = $(this);
                var parent = $("#f1_athlete_profile_image_3_container");

                var upload_image = $("<div>", {class: "uk-margin-small uk-width-1-1", "uk-form-custom": "target:true"}).append(
                    $("<label>", {class: "uk-form-label", text: "آپلود تصویر سوم"}),
                    $("<input>", {id: "f1_athlete_profile_image_2", type: "file"}),
                    $("<input>", {class: "uk-input", placeholder: "یک تصویر انتخاب کنید...", type: "text", disabled: "disabled"})
                );

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "athlete_image_3_remove"
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            parent.children().remove();
                            parent.append(upload_image);
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

            /*Athlete Image 4  Remove*/
            $(document).on("click", "#f1_athlete_profile_image_4_remove", function () {

                var self = $(this);
                var parent = $("#f1_athlete_profile_image_4_container");

                var upload_image = $("<div>", {class: "uk-margin-small uk-width-1-1", "uk-form-custom": "target:true"}).append(
                    $("<label>", {class: "uk-form-label", text: "آپلود تصویر چهارم"}),
                    $("<input>", {id: "f1_athlete_profile_image_2", type: "file"}),
                    $("<input>", {class: "uk-input", placeholder: "یک تصویر انتخاب کنید...", type: "text", disabled: "disabled"})
                );

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "athlete_image_4_remove"
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            parent.children().remove();
                            parent.append(upload_image);
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

            /*Athlete Body Submit*/
            $(document).on("click", "#f1_athlete_body_submit", function () {

                var athlete_height = $("#f1_athlete_body_height").val();
                var athlete_weight = $("#f1_athlete_body_weight").val();
                var self = $(this);

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "athlete_body",
                        athlete_height: athlete_height,
                        athlete_weight: athlete_weight
                    },
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

            /*Send Coach Chat*/
            $(document).on("click", "button[id^=\"f1_send_message_coach_chat_\"]", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                var message = $("#f1_message_coach_chat_" + order_id);
                var container = $("#f1_container_coach_chat_" + order_id);
                var self = $(this);

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "send_coach_chat",
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
                                $("<button>", {id: "f1_load_more_coach_chat_" + order_id, class: "uk-button uk-button-secondary uk-border-pill uk-button-small uk-align-center f1-button-spinner-hide"}).append(
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

            /*Load More Coach Chat*/
            $(document).on("click", "button[id^=\"f1_load_more_coach_chat_\"]", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                var container = $("#f1_container_coach_chat_" + order_id);
                var offset = $(this).data("offset") === undefined ? 2 : $(this).data("offset");
                var self = $(this);

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "load_more_coach_chat",
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
                                    $("<button>", {"data-offset": ++offset, id: "f1_load_more_coach_chat_" + order_id, class: "uk-button uk-button-secondary uk-border-pill uk-button-small uk-align-center f1-button-spinner-hide"}).append(
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

            /*Submit Rate Coach*/
            $(document).on("click", "button[id^=\"f1_submit_rate_coach_\"]", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                var rate = $("input[name=" + "f1_rate_coach_" + order_id + "]:checked").val();
                var self = $(this);

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "submit_rate_coach",
                        order_id: order_id,
                        rate: rate
                    },
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

        });
    }

    modal() {
        jQuery(document).ready(function ($) {

            /*Show Coach Chat For Athlete*/
            UIkit.util.on("div[id^=\"chat_coach_modal_\"]", "shown", function () {

                var order_id = parseInt(this.id.match(/\d+$/));
                var container = $("#f1_container_coach_chat_" + order_id);

                $.ajax({
                    url: f1_account_athlete_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_athlete_data.nonce,
                        command: "show_coach_chat",
                        order_id: order_id
                    },
                    success(result) {
                        if (result.status === 'success') {

                            container.children().remove();
                            container.append(
                                $("<button>", {id: "f1_load_more_coach_chat_" + order_id, class: "uk-button uk-button-secondary uk-border-pill uk-button-small uk-align-center f1-button-spinner-hide"}).append(
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

    chart() {

        //show chart for athlete
        jQuery(document).ready(function ($) {

            var athlete_wight = $("#f1_chart_weight");
            var athlete_height = $("#f1_chart_height");
            $.ajax({
                url: f1_account_athlete_data.ajax_url,
                dataType: 'json',
                type: 'POST',
                data: {
                    action: 'f1-account',
                    nonce: f1_account_athlete_data.nonce,
                    command: "show_chart_athlete_user"
                },
                beforeSend() {
                    $("#f1_chart_weight_container").append($("<i>", {style: "position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);", "uk-spinner": "ratio: 5"}));
                    $("#f1_chart_height_container").append($("<i>", {style: "position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);", "uk-spinner": "ratio: 5"}));
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
                    if (result.status === 'failed') {
                        UIkit.notification("<span class='fas fa-exclamation-triangle f1-ml-7'></span>" + result.message,
                            {pos: 'bottom-left', status: 'warning', timeout: 2000});
                    }
                },
                complete() {
                    $("#f1_chart_weight_container").children("i").fadeOut(3000, function () {
                        $(this).remove();
                    });
                    $("#f1_chart_height_container").children("i").fadeOut(3000, function () {
                        $(this).remove();
                    });
                }
            });

        });

    }

}

Athlete.instance();