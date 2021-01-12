(function ($) {
    "use strict";
    $(document).ready(function () {
        $("ul.job_listings.load_jobs li.job_listing").slice(0, 4).show();
        $("#loadMore").on("click", function (e) {
            e.preventDefault();
            $("ul.job_listings.load_jobs li.job_listing:hidden").slice(0, 4).slideDown();
            if ($("ul.job_listings.load_jobs li.job_listing:hidden").length == 0) {
//                $("#loadMore").text("No Content").addClass("noContent");
                $("#loadMore").fadeOut("slow");
            }
        });
//        $('.form_add_classified .article-content').removeClass('loading');
        if ($("#buddyforms_form_hero_add-classified").length) {
//            $('.container-wrap.main-color:not(.kleo-page-header)').addClass('form_add_classified');
            $('.elem-buddyforms_form_title').parent().before('<div class="col-xs-12 col-md-6 col- form_add_classified_box1 row"></div>');
            $('.elem-actual_by').parent().after('<div class="col-xs-12 col-md-6 col- form_add_classified_box2 row"></div>');
            $('.elem-buddyforms_form_title').parent().appendTo('.form_add_classified_box1');
            $('.bf_form_content').parent().appendTo('.form_add_classified_box1');
            $('.elem-actual_with').parent().appendTo('.form_add_classified_box1');
            $('.elem-actual_by').parent().appendTo('.form_add_classified_box1');

            $('#85d2c546fa').parent().parent().parent().appendTo('.form_add_classified_box2');
            $('#e2d268620a').parent().parent().parent().appendTo('.form_add_classified_box2');
            $('.elem-email').parent().appendTo('.form_add_classified_box2');
            $('.elem-phone').parent().appendTo('.form_add_classified_box2');

            $('#featured_image .dz-default.dz-message span').text('Przeciągnij żeby dodać plik');
            $('#upload .dz-default.dz-message span').text('Przeciągnij żeby dodać zdjęcie');
        }
        if ($("#buddyforms_form_add-job").length) {
//            $('.container-wrap.main-color:not(.kleo-page-header)').addClass('form_add_classified');
            $('.elem-buddyforms_form_title').parent().before('<div class="col-xs-12 col-"></div><div class="col-xs-12 col-md-6 col- form_add_classified_box1 row"></div><div class="col-xs-12 col-md-6 col- form_add_classified_box2 row"></div><div class="col-xs-12 col-md-6 col- form_add_classified_box3 row"></div><div class="col-xs-12 col-md-6 col- form_add_classified_box4 row"></div>');

            $('.elem-buddyforms_form_title').parent().appendTo('.form_add_classified_box1');
            $('.bf_form_content').parent().appendTo('.form_add_classified_box1');

            $('.elem-_job_location').parent().appendTo('.form_add_classified_box2');
            $('#_job_location').attr('placeholder', 'np."Warszawa"');
            $('#_job_salary').attr('placeholder', 'na przykład 10');
            $('#8d123bba13').parent().parent().parent().appendTo('.form_add_classified_box2');
            $('#a6f95f2e84').parent().parent().parent().appendTo('.form_add_classified_box2');
            $('#a9e6b0fc0c').parent().parent().parent().appendTo('.form_add_classified_box2');


            $('.elem-email').parent().appendTo('.form_add_classified_box3');
            $('.elem-phone').parent().appendTo('.form_add_classified_box3');
            $('.elem-_company_name').parent().appendTo('.form_add_classified_box3');
            $('.elem-_company_website').parent().appendTo('.form_add_classified_box3');

            $('.elem-_company_tagline').parent().appendTo('.form_add_classified_box4');
            $('.elem-featured_image').parent().prev().appendTo('.form_add_classified_box4');
            $('.elem-featured_image').parent().appendTo('.form_add_classified_box4');

            $('#featured_image .dz-default.dz-message span').text('Przeciągnij żeby dodać plik');
        }
        $('.dynamic_select').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
        $('#phone').on('keyup keypress', function (e) {
            var len = $(this).val().length;
            if (len >= 16) {
                $('#phone_count').text(16 - len);
                return false;
            } else {
                $('#phone_count').text(16 - len);
            }
        });
        var current_domain_url = $('.current_domain_url').val();
        var current_domain_user = $('.current_domain_url').attr("data-cur_user");

        $('.classifieds .kleo-banner-slider .kleo-banner-next').trigger('click');
        $('.bf-input #actual_by').prop('type', 'date');
        if ($('.the_buddyforms_form').children().last().is('[clss]')) {
            $('.the_buddyforms_form').children().last().remove();
        }

        $('#post_infoTab .geodir_contact, #geodir_contactTab .geodir_contact').append('<span class="mask_phone">зателефонувати</span>');
        $('.mask_phone').click(function () {
            $(this).remove();
        });
        $('.mask_email').click(function () {
            $(this).remove();
        });
        $('#slidebox').animate({'right': '0px'}, 500);
//        $(window).scroll(function () {
//            if ($(window).scrollTop() > 200)
//                $('#slidebox').animate({'right': '0px'}, 500);
//            else
//                $('#slidebox').stop(true).animate({'right': '-230px'}, 500);
//        });
        $('#slidebox .close').bind('click', function () {
            $(this).parent().remove();
        });

        var quotes = $(".reklama_menu .nav>li>a");
        var quoteIndex = -1;

        function showNextQuote() {
            ++quoteIndex;
            quotes.eq(quoteIndex % quotes.length)
                    .fadeIn(2000)
                    .delay(2000)
                    .fadeOut(2000, showNextQuote);
        }
        showNextQuote();
        $('body').on('click', '.widget_nav_menu a', function (e) {
            if (/#/.test(this.href)) {
                //if ($(this).is('[href*="#"]')) {
                e.preventDefault();
                $(this).find('.caret').click();
            }
        });
        $('.max_flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails",
            start: function (slider) {
                $('.max_flexslider').removeClass('loading');
            }
        });
        $('.bf-submit').on('click', function () {
            if ($("#bf_post_type").val() == 'classifieds') {
                var post_id = $("#post_id").val();
                var upload = $("#field_upload").val();
                $.ajax({
                    type: 'POST',
                    url: current_domain_url + '/wp-content/themes/NASZAPolsha/action/bf_submit.php',
                    data: {
                        post_id: post_id,
                        upload: upload,
                    },
                    cache: false,
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (xhr, str) {
                        console.log('Возникла ошибка: ' + xhr.responseCode);
                    }
                });
            }
        });
        $('.job_application_button').click(function (e) {
            e.preventDefault();
            $('.job_application_details').toggle();
        });
        $('.easysend_banner_home img').click(function () {
            var local = 'home';
            var src = $(this).attr('src');
            var name = src.split('/').pop().split('.').shift();
            var url = window.location.href;
            var href = $(this).parent().attr('href');
            easysend_clicks_send(local, name, url, href);
        });
        $('.easysend_banner_post img').click(function () {
            var local = 'post';
            var src = $(this).attr('src');
            var name = src.split('/').pop().split('.').shift();
            var url = window.location.href;
            var href = $(this).parent().attr('href');
            easysend_clicks_send(local, name, url, href);
        });
        $('.easysend_banner_sidebar').click(function () {
            var local = 'sidebar';
            var src = $(this).attr('src');
            var name = src.split('/').pop().split('.').shift();
            var url = window.location.href;
            var href = $(this).parent().attr('href');
            easysend_clicks_send(local, name, url, href);
        });
        $('.easysend_btn').click(function () {
            var local = 'btn';
            var name = 'easysend_btn';
            var url = window.location.href;
            var href = $(this).attr('href');
            easysend_clicks_send(local, name, url, href);
            console.log(local + ' ' + name + ' ' + url + ' ' + href);
        });
        function easysend_clicks_send(local, name, url, href) {
            $.ajax({
                type: 'POST',
                url: current_domain_url + '/wp-content/themes/NASZAPolsha/action/easysend_clicks.php',
                data: {
                    current_domain_user: current_domain_user,
                    url: url,
                    name: name,
                    local: local,
                    href: href,
                },
                cache: false,
                success: function (data) {
                    console.log(data);
                },
                error: function (xhr, str) {
                    console.log('Возникла ошибка: ' + xhr.responseCode);
                }
            });
        }
    });
    $(window).load(function () {
        $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 210,
            itemMargin: 5,
            asNavFor: '#slider',
            start: function (slider) {
                $('.flexslider').removeClass('loading');
            }
        });

        $('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            start: function (slider) {
                $('.flexslider').removeClass('loading');
            }
        });
    });
    $(document).ready(function () {
        fixFlexsliderHeight();
    });

    $(window).load(function () {
        fixFlexsliderHeight();
    });

    $(window).resize(function () {
        fixFlexsliderHeight();
    });
    function fixFlexsliderHeight() {
        $('.max_flexslider').each(function () {
            var sliderHeight = 0;
            $(this).find('.slides > img').each(function () {
                slideHeight = $(this).height();
                if (sliderHeight < slideHeight) {
                    sliderHeight = slideHeight;
                }
            });
            $(this).find('ul.slides').css({'height': sliderHeight});
        });
    }
})(jQuery);