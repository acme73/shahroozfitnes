class Public {

    static instance_ = null;

    static instance() {
        if (Public.instance_ === null) {
            Public.instance_ = new Public();
        }
    }

    constructor() {
        this.init();
        this.onclick();
    }

    init() {
        jQuery(document).ready(function ($) {
            var current_path = window.location.pathname;
            var page_title = $("#f1_title_account_page");
            var sidebar = $("#f1_sidebar_account");
            var document_title = "حساب کاربری";
            switch (current_path) {
                case "/account/support/new_ticket":
                    page_title.text("تیکت جدید");
                    document.title = document_title + " | " + "تیکت جدید";
                    sidebar.children("li#user_support_menu").addClass("uk-open");
                    sidebar.children("li#user_support_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#user_support_menu").children("ul").children().eq(0).addClass("uk-active");
                    break;
                case "/account/support/tickets":
                    page_title.text("تیکت ها");
                    document.title = document_title + " | " + "تیکت ها";
                    sidebar.children("li#user_support_menu").addClass("uk-open");
                    sidebar.children("li#user_support_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#user_support_menu").children("ul").children().eq(1).addClass("uk-active");
                    sidebar.children("li#tickets_menu").addClass("uk-open");
                    break;
                case "/account/coach/profile":
                    page_title.text("پروفایل مربی");
                    document.title = document_title + " | " + "پروفایل مربی";
                    sidebar.children("li#coach_profile_menu").addClass("uk-open");
                    break;
                case "/account/order/athlete":
                    page_title.text("شاگردها");
                    document.title = document_title + " | " + "شاگردها";
                    sidebar.children("li#student_menu").addClass("uk-open");
                    break;
                case "/account/finance/settlement":
                    page_title.text("مالی");
                    document.title = document_title + " | " + "مالی";
                    sidebar.children("li#finance_menu").addClass("uk-open");
                    break;
                case "/account/order/coach":
                    page_title.text("مربیان");
                    document.title = document_title + " | " + "مربیان";
                    sidebar.children("li#coach_menu").addClass("uk-open");
                    break;
                case "/account/athlete/profile":
                    page_title.text("پروفایل ورزشکار");
                    document.title = document_title + " | " + "پروفایل ورزشکار";
                    sidebar.children("li#athlete_profile_menu").addClass("uk-open");
                    break;
                case "/account/finance/transactions":
                    page_title.text("پرداخت ها");
                    document.title = document_title + " | " + "پرداخت ها";
                    sidebar.children("li#transactions_athlete_menu").addClass("uk-open");
                    break;
                case "/account/coach/manage":
                    page_title.text("مربیان");
                    document.title = document_title + " | " + "مربیان";
                    sidebar.children("li#coach_manage_menu").addClass("uk-open");
                    break;
                case "/account/accounting/transactions":
                    page_title.text("تراکنش ها");
                    document.title = document_title + " | " + "تراکنش ها";
                    sidebar.children("li#accounting_menu").addClass("uk-open");
                    sidebar.children("li#accounting_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#accounting_menu").children("ul").children().eq(0).addClass("uk-active");
                    break;
                case "/account/accounting/paid":
                    page_title.text("پرداختی ها");
                    document.title = document_title + " | " + "پرداختی ها";
                    sidebar.children("li#accounting_menu").addClass("uk-open");
                    sidebar.children("li#accounting_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#accounting_menu").children("ul").children().eq(1).addClass("uk-active");
                    break;
                case "/account/accounting/configuration":
                    page_title.text("پیکربندی ها");
                    document.title = document_title + " | " + "پیکربندی ها";
                    sidebar.children("li#accounting_menu").addClass("uk-open");
                    sidebar.children("li#accounting_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#accounting_menu").children("ul").children().eq(2).addClass("uk-active");
                    break;
                case "/account/tools/exports":
                    page_title.text("خروجی گرفتن");
                    document.title = document_title + " | " + "خروجی گرفتن";
                    sidebar.children("li#tools_menu").addClass("uk-open");
                    sidebar.children("li#tools_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#tools_menu").children("ul").children().eq(0).addClass("uk-active");
                    break;
                case "/account/setting/payment":
                    page_title.text("درگاه های پرداخت");
                    document.title = document_title + " | " + "درگاه های پرداخت";
                    sidebar.children("li#setting_menu").addClass("uk-open");
                    sidebar.children("li#setting_menu").children("ul").removeAttr("hidden");
                    sidebar.children("li#setting_menu").children("ul").children().eq(0).addClass("uk-active");
                    break;
            }
        });
    }

    onclick() {
        jQuery(document).ready(function ($) {

            /*New Ticket*/
            $(document).on("click", "#f1_new_ticket_submit", function () {

                var department = $("#f1_ticket_department").val();
                var priority = $("#f1_ticket_priority").val();
                var subject = $("#f1_ticket_subject").val();
                var messages = $("#f1_ticket_messages").val();
                var self = $(this);

                $.ajax({
                    url: f1_account_public_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_public_data.nonce,
                        command: "new_ticket",
                        department: department,
                        priority: priority,
                        subject: subject,
                        messages: messages
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

            /*Replay Ticket*/
            $(document).on("click", "#f1_replay_ticket_submit", function () {

                var self = $(this);
                var replay = $("#f1_replay_ticket_message").val();
                var url = new URLSearchParams(window.location.search);
                var ticket_id = Object.fromEntries(url.entries()).ticket_id;

                $.ajax({
                    url: f1_account_public_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_public_data.nonce,
                        command: "replay_ticket",
                        replay: replay,
                        ticket_id: ticket_id
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            location.reload();
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

            /*Update Ticket*/
            $(document).on("click", "#f1_ticket_close", function () {

                var self = $(this);
                var url = new URLSearchParams(window.location.search);
                var ticket_id = Object.fromEntries(url.entries()).ticket_id;

                $.ajax({
                    url: f1_account_public_data.ajax_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'f1-account',
                        nonce: f1_account_public_data.nonce,
                        command: "update_ticket",
                        ticket_id: ticket_id
                    },
                    beforeSend() {
                        self.addClass('f1-button-spinner-show');
                        self.removeClass('f1-button-spinner-hide');
                        self.attr('disabled', true);
                    },
                    success(result) {
                        if (result.status === 'success') {
                            location.reload();
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

}

Public.instance();