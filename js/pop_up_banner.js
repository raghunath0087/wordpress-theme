$(document).ready(function() {

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(";");
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    var leave_msg_for_urls = ["/services/it-outsourcing/hire-php-developer", "/service/dot-net-developer-india", "/service/asp-dot-net-developer", "/service/c-sharp-developer", "/service/sharepoint-developer", "/service/umbraco-developer", "/service/vb-dot-net-developer", "/services/it-outsourcing/hire-ajax-developers", "/services/it-outsourcing/cms-programmer", "/services/it-outsourcing/database-programmer", "/services/it-outsourcing/magento-developers", "/services/it-outsourcing/drupal-developers", "/services/software-developers", "/services/it-outsourcing/wordpress-developer", "/services/it-outsourcing/zend-developers",
        "/services/python-developers", "/services/xamarin-developers", "/services/internet-marketing", "/services/seo-service", "/services/pay-per-click", "/services/content-marketing", "/services/social-media-marketing", "/services/video-marketing", "/services/content-writers", "/services/mobile-apps-development", "/services/mobile-apps-development/hire-android-developer", "/services/mobile-apps-development/hire-ios-app-developer", "/services/mobile-apps-development/hire-windows-mobile-app-developers", "/services/mobile-apps-development/hire-mobile-game-developer", "/services/hire-dedicated-designers/hire-web-designer", "/services/front-end-developers", "/services/hire-dedicated-designers/hire-logo-designers", "/services/hire-dedicated-designers/hire-graphic-designer", "/services/hire-dedicated-designers/hire-photoshop-artist", "/services/hire-dedicated-designers/hire-indesign-expert", "/services/hire-dedicated-designers/hire-business-card-designers", "/services/hire-dedicated-designers/hire-illustrator-online", "/services/engineers-architects/hire-cad-designer", "/services/multimedia-animation", "/services/engineers-architects/hire-embedded-hardware-developer", "/services/data-entry", "/services/microsoft-office-specialists", "/services/assistant", "/services/it-support", "/services/medical-process-outsourcing/hire-dedicated-medical-image-editors", "/services/patent"
    ];

    $("body").append("<style>.img_pop_closer{position:absolute;right:0px;top:0px;background:#ccc;}.remodal-box1{display:none; text-align:center; z-index:10001; position:fixed;top:25%; right:0;left:0;bottom:0;}.remodal-box1:after{height:100%;display:inline-block; content:\"\";vertical-align:middle;}</style><div class=\"remodal-overlay overlay_2\"></div><div class=\"remodal-box1\" style=\"\"><div style=\"position:relative;display:inline-block;\"> <button aria-label=\"Close\" class=\"remodal-close img_pop_closer\"  data-remodal-action=\"close\"></button> <a style=\"display:block;\" href=\"/free-trial\"><img src=\"/wp-content/uploads/ve_assets/common/get-free-trial.jpg\" alt=\"Free Trail\" title=\"Get Free Trial\"></a></div>");

    $("body").mousemove(function(event) {
        if (getCookie("shown_pop_up_exit") == 1) {
            return false;
        }
        var show_leave_msg = leave_msg_for_urls.indexOf(document.location.pathname);

        if (show_leave_msg >= 0) {
            if (event.pageY - $(window).scrollTop() < 10) {
                setCookie("shown_pop_up_exit", 1, 1);
                $(".overlay_2").show();
                $(".remodal-box1").show();
            }
        }

    });

    $(".img_pop_closer").click(function() {
        $(".overlay_2").hide();
        $(".remodal-box1").hide();
    });


})