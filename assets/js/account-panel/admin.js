class Admin {

    static instance_ = null;

    static instance() {
        if (Admin.instance_ === null) {
            Admin.instance_ = new Admin();
        }
    }

    constructor() {
        this.onclick();
        this.onchange();
    }

    onclick() {
        jQuery(document).ready(function ($) {

            /*Coach Status*/
            $(document).on("click", "button[id^=\"f1_coach_status_submit_\"]", function () {

                var coach_id = parseInt(this.id.match(/\d+$/));
                var coach_status = $("#f1_coach_status_" + coach_id).val();
                var coach_alert = $("#f1_coach_alert_" + coach_id).val();
                var self = $(this);

                $.ajax({
                    url: f1_account_admin_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_admin_data.nonce,
                        command: "change_coach_status",
                        coach_id: coach_id,
                        coach_status: coach_status,
                        coach_alert: coach_alert
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                {pos: 'bottom-left', status: 'success', timeout: 2000});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1500);
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
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

            /*Post Status*/
            $(document).on("click", "button[id^=\"f1_post_status_submit_\"]", function () {

                var coach_id = parseInt(this.id.match(/\d+$/));
                var post_status = $("#f1_post_status_" + coach_id).val();
                var self = $(this);

                $.ajax({
                    url: f1_account_admin_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_admin_data.nonce,
                        command: "change_post_status",
                        coach_id: coach_id,
                        post_status: post_status
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                {pos: 'bottom-left', status: 'success', timeout: 2000});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1500);
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
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

            /*Coach Finance Settlement*/
            $(document).on("click", "button[id^=\"f1_finance_settlement_submit_\"]", function () {

                var coach_id = parseInt(this.id.match(/\d+$/));
                var amount = $("#f1_finance_settlement_amount_" + coach_id).val();
                var document_number = $("#f1_finance_settlement_dn_" + coach_id).val();
                var self = $(this);

                $.ajax({
                    url: f1_account_admin_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_admin_data.nonce,
                        command: "coach_finance_settlement",
                        coach_id: coach_id,
                        amount: amount,
                        document_number: document_number
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
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

            /*Pay Payment Setting Submit*/
            $(document).on("click", "button[id^=\"f1_setting_payment_submit_\"]", function () {

                var payment = this.id.replace("f1_setting_payment_submit_", "").trim();
                var payment_status = $("#f1_payment_status_" + payment).val();
                var self = $(this);

                var api_pay = $("#f1_payment_api_pay").val();

                $.ajax({
                    url: f1_account_admin_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_admin_data.nonce,
                        command: "setting_payment",
                        payment: payment,
                        payment_status: payment_status,
                        api_pay: api_pay
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                {pos: 'bottom-left', status: 'success', timeout: 2000});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1500);
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
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

            /*Finance Setting Submit*/
            $(document).on("click", "#f1_setting_finance_submit", function () {

                var percent_site = $("#f1_percent_site").val();
                var self = $(this);

                $.ajax({
                    url: f1_account_admin_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_admin_data.nonce,
                        command: "setting_finance",
                        percent_site: percent_site
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            UIkit.notification("<span class='uk-margin-small-left' uk-icon='check'></span>" + result.message,
                                {pos: 'bottom-left', status: 'success', timeout: 2000});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1500);
                        }
                        if (result.status === 'reload') {
                            window.location.reload();
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
    }

    onchange() {
        jQuery(document).ready(function ($) {

            //coach status type
            $(document).on("change", "select[id^=\"f1_coach_status_\"]", function () {

                switch ($(this).val()) {
                    case "1":
                        $(this).parent().nextAll().slice(0).addClass("uk-hidden");
                        break;
                    case "3":
                        $(this).parent().nextAll().slice(0).removeClass("uk-hidden");
                        break;
                }

            });

        });
    }

}

Admin.instance();