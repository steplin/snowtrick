$(document).ready(function () {

    $(".delete").click(function () {
        let titre;
        if ($(this).attr("title") === null) {
            titre = "SnowPassion";
        } else {
            titre = $(this).attr("title");
        }
        $(".modal-title").html(titre);
        const url = $(this).data("href");
        $.ajax({
            type: "post",
            url: url,
            success: function (data) {
                $(".modal-body").html(data);
                $(".modal").modal("show");
            }
        });
    });

    function submitForm(url, dataForm) {
        $.ajax({
            type: "post",
            url: url,
            data: new FormData(dataForm),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                let result = $(data).find("#form-container");
                let error = $(data).find(".has-error");

                if (error.length) {
                    $("#form-container").html(result).addClass("has-error");
                } else {
                    window.location.reload();
                }
            }
        });
    }

    $(".add,.update").click(function () {
        let titre;
        if ($(this).attr("title") === null) {
            titre = "SnowPassion";
        } else {
            titre = $(this).attr("title");
        }
        $(".modal-title").html(titre);
        let url = $(this).data("href");
        $.ajax({
            type: "post",
            url: url,
            success: function (data) {
                $(".modal-body").html(data);
                $(".modal").modal("show");
                $("#form").submit(function (e) {
                    e.preventDefault();
                    url = $(this).attr("action");
                    submitForm(url, this);
                });
            }
        });
    });


    $(".msg-flash").delay(2000).fadeOut(1000, function () {
        $(this).remove();
    });

    $(".page-scroll,.navbar-link").bind(
        "click", function (event) {
            let anchor = $(this);
            $("html, body").stop().animate(
                {
                    scrollTop: ($(anchor.attr("href")).offset().top - 0)
                }, 1250
            );
            event.preventDefault();
        }
    );

    $(".btn-comments").click(function () {

        $(".pagination").children().removeClass("active");
        $(this).parent().addClass("active");

        let ele = document.getElementById("commentaires");
        let ancre = $(ele).offset().top - 60;
        const url = $(this).data("href");

        $.ajax({
            type: "post",
            url: url,
            success: function (data) {
                $("#commentaires").html(data);
                $("HTML, BODY").animate({scrollTop: ancre}, 1000);
            }
        });
    });
    $(".btn-more-tricks").click(function () {
        const url = $(this).data("href");
        $.ajax({
            type: "post",
            url: url,
            success: function (data) {
                $("#media-index").html(data);
            }
        });
    });

    $("#media-visible").click(function () {

        $("#media").removeClass("hidden-sm hidden-xs");
        $(this).addClass("hidden");
    });

    $(window).scroll(function () {

        if ($(this).scrollTop() > 400) {
            $("#back-bottom").fadeOut();
            $("#back-top").fadeIn();
        } else {
            $("#back-bottom").fadeIn();
            $("#back-top").fadeOut();
        }
    });
});