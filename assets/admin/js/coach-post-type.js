class Coach {

    static instance_ = null;

    static instance() {
        if (Coach.instance_ === null) {
            Coach.instance_ = new Coach();
        }
    }

    constructor() {
        this.coach_metabox();
        this.coach_id();
        this.init();
        this.remove_coach_image();
    }

    init() {

        //Coach Information
        this.sortable_container({
            name: "coach_information"
        });
        this.new_record(
            {
                name: "coach_information"
            },
            {
                label: "نوع اطلاعات",
                name: "type_info[]",
                options: [
                    {value: "certificate", text: "مدارک"},
                ]
            },
            {
                label: "توضیحات",
                name: "desc_info[]",
                placeholder: "توضیحات را اینجا وارد کنید..."
            }
        );
        this.remove_record({
            name: "coach_information"
        });

        //Coach Program Prices
        this.sortable_container({
            name: "coach_program_prices"
        });
        this.new_record(
            {
                name: "coach_program_prices"
            },
            {
                label: "نوع خدمات",
                name: "type_service[]",
                options: [
                    {value: "practice_food", text: "طراحی تمرین و تغذیه"},
                    {value: "professional_consultation", text: "مشاوره تخصصی"}
                ]
            },
            {
                label: "قیمت دریافت برنامه",
                name: "program_price[]",
                placeholder: "قیمت به تومان"
            }
        );
        this.remove_record({
            name: "coach_program_prices"
        });

    }

    coach_metabox() {
        jQuery(document).ready(function ($) {

            $(".f1-panel").parent('.inside').css({margin: 0, padding: 0});
            $(".f1-panel-tab li:last-child").css({border: 'none'});

            var current_tab;

            $(".f1-panel-tab li").on("click", function () {

                if (current_tab !== undefined)
                    current_tab.removeClass('active');

                var content = $(".f1-panel-content");
                content.children().hide();

                content.children().eq($(this).index()).show();
                $(this).addClass('active');

                current_tab = $(this);

            });

            $(".f1-panel-tab li:first-child").click();

        });
    }

    coach_id() {

        jQuery(document).ready(function ($) {

            var users = [];

            $.each(f1_coach_data.users_autocomplete, function (index, user) {
                users.push({label: user.name, value: user.id});
            });

            $("#coach_id").autocomplete({
                minLength: 1,
                source: users
                ,
                select: function (event, ui) {
                    $("#coach_id").val(ui.item.value);
                    return false;
                }

            });
        });

    }

    sortable_container(data) {

        jQuery(document).ready(function ($) {
            $("#f1_" + data.name + "_container").sortable({handle: "#f1_" + data.name + "_move_record"}).disableSelection();
        });

    }

    new_record(data, type, field) {
        jQuery(document).ready(function ($) {

            $(document).on("click", "#f1_" + data.name + "_new_record", function () {

                var container = $("<div>", {class: "f1-coach-row-container"});

                var data_type = $("<div>").append(
                    $("<select>", {name: type.name})
                );

                $.each(type.options, function (index, option) {
                    data_type.children("select").append($("<option>", {value: option.value, text: option.text}));
                });

                var data_desc = $("<div>").append(
                    $("<input>", {type: "text", name: field.name, placeholder: field.placeholder})
                );

                var options = $("<div>").append(
                    $("<span>", {class: "dashicons dashicons-trash f1-cursor-pointer", id: "f1_" + data.name + "_remove_record"}),
                    $("<span>", {class: "dashicons dashicons-move f1-cursor-move", id: "f1_" + data.name + "_move_record"})
                );

                container.append(data_type, data_desc, options);
                $("#f1_" + data.name + "_container").append(container);

            });

        });
    }

    remove_record(data) {
        jQuery(document).ready(function ($) {

            $(document).on("click", "#f1_" + data.name + "_remove_record", function () {
                $(this).parents("div.f1-coach-row-container").fadeOut(500, function () {
                    $(this).remove();
                });
            });

        });
    }

    remove_coach_image() {
        jQuery(document).ready(function ($) {

            $(document).on("click", "#f1_coach_profile_image_remove", function () {

                var parent = $("#f1_coach_profile_image_container");
                var upload_image = $("<div>", {class: "row"}).append(
                    $("<label>", {for: "coach_image", text: "تصویر مربی"}),
                    $("<input>", {id: "coach_image", name: "coach_image", type: "file"})
                );

                parent.children().remove();
                parent.append(upload_image);

            });

        });
    }

}

Coach.instance();