function getBaseURL() {
    return "[urlroot]";
}

//function getBaseURL() {
//    var url = location.href;
//    var baseURL = url.substring(0, url.indexOf('/', 14));
//    if (baseURL.indexOf('http://localhost') != -1 || baseURL.indexOf('http://cuong') != -1) {
//        // Base Url for localhost
//        var url = location.href; // window.location.href;
//        var pathname = location.pathname; // window.location.pathname;
//        var index1 = url.indexOf(pathname);
//        var index2 = url.indexOf("/", index1 + 1);
//        var baseLocalUrl = url.substr(0, index2);
//        return baseLocalUrl + "/";
//    } else {
//        // Root Url for domain name
//        return baseURL + "/";
//    }
//}
function ResolveUrl(input) {
    return input.replace("~/", getBaseURL());
}
function share_google() {
    var u = location.href;
    var t = document.title;
    window.open("https://www.google.com/bookmarks/mark?op=edit&amp;bkmk=" + encodeURIComponent(u));
}
function share_facebook() {
    var u = location.href;
    var t = document.title;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', ',width=980,height=600');
    return false;
}

function share_twitter() {
    var uvnn = location.href;
    var tvnn = document.title;
    window.open("http://twitter.com/home?status=" + encodeURIComponent(uvnn));
}

function share_yahoo() {
    this.href = "ymsgr:im?msg=" + document.title + ' ' + location.href;
}

function fbs_click() {
    u = location.href;
    t = document.title;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', ',width=980,height=600');
    return false;
}
function yhs_click() {
    document.getElementById('yahoo_share').href = "ymsgr:im?msg=" + document.title + ' ' + location.href;
}

$(window).load(function () {
    $(".menuCatBlock a.menuitem.selected").next().remove();
    $(".menuCatBlock a.menuitem.selected").prev().remove();

});
$(document).ready(function () {
    $("a.menuitem,a.aiaItem").unbind("click");
});
$(function () {

    $(".toTop").live("click", function (event) {
        event.preventDefault();
        var t = $(window).scrollTop();
        $('html,body').stop().animate({ scrollTop: 0 }, t);
    });
    $(window).scroll(function () {
        var op = $(window).scrollTop() / $(window).height();
        op = op > 1 ? 1 : op;
        $(".toTop").stop().animate({ 'opacity': op }, 10);
    });

    $(".othermenu").each(function () {
        var li = $(this).children("ul").children("li");
        li.eq(li.length - 1).addClass("last-child");
    });

    $("#slider.nivoSlider .nivo-caption p").live("click", function () {
        var c = $("#slider.nivoSlider a.nivo-imageLink");
        var a = $("#slider.nivoSlider .nivo-controlNav .nivo-control.active");
        if (c.eq(a.attr("rel")).attr("href") != undefined) {
            window.location = c.eq(a.attr("rel")).attr("href");
        }
    });
    $("#slider2.nivoSlider .nivo-caption p").live("click", function () {
        var c = $("#slider2.nivoSlider a.nivo-imageLink");
        var a = $("#slider2.nivoSlider .nivo-controlNav .nivo-control.active");
        if (c.eq(a.attr("rel")).attr("href") != undefined) {
            window.location = c.eq(a.attr("rel")).attr("href");
        }
    });
    $("#ctl00_cphMain_Contact2_capComment_CaptchaTextBox").live("focusin focusout", function (event) {
        if (event.type == "focusin") {
            if ($(this).val() == "Nhập mã xác nhận") {
                $(this).val("");
            }
            if (event.type == "focusout") {
                if ($(this).val() == "" || "Nhập mã xác nhận".match($(this).val())) {
                    $(this).val("Nhập mã xác nhận");
                }
            }
        }
    }).val("Nhập mã xác nhận");
});

(function ($) {
    $.fn.LimitChar = function (leng, objectAlert, textAlert) {
        $(this).live("keyup", function () {
            var content = $(this).val();
            $(this).val(content.substring(0, leng));
            $(this).next().children("." + objectAlert).html(textAlert + " " + leng - content.length);
        });
    };
})(jQuery);
/**PECORA**/
function StringFormat(text) {

    if (arguments.length <= 1) {
        return text;
    }
    var tokenCount = arguments.length - 2;
    for (var token = 0; token <= tokenCount; token++) {
        text = text.replace(new RegExp("\\{" + token + "\\}", "gi"), arguments[token + 1]);
    }
    return text;
}

String.prototype.Format = function (args) {
    return StringFormat(this, args);
};

var _chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
String.prototype.ToBase64 = function () {
    var input = this;
    var a, b, c = '';
    var d, e, f, g = '';
    var i = 0;
    var result = '';
    do {
        a = input.charCodeAt(i++);
        b = input.charCodeAt(i++);
        c = input.charCodeAt(i++);

        d = a >> 2;
        e = ((a & 3) << 4) | (b >> 4);
        f = ((b & 15) << 2) | (c >> 6);
        g = c & 63;
        if (isNaN(b)) {
            f = g = 64;
        } else if (isNaN(c)) {
            g = 64;
        }
        result += _chars.charAt(d) + _chars.charAt(e) + _chars.charAt(f) + _chars.charAt(g);
    } while (i < input.length);
    return result;
};
String.prototype.FromBase64 = function () {
    var input = this;
    var result = "";
    var a, b, c = "";
    var d, e, f, g = "";
    var i = 0;
    var h = /[^A-Za-z0-9\+\/\=]/g;
    if (h.exec(input)) {
        alert("There were invalid base64 characters in the input text.\n" +
                "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                "Expect errors in decoding.");
    }
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    do {
        d = _chars.indexOf(input.charAt(i++));
        e = _chars.indexOf(input.charAt(i++));
        f = _chars.indexOf(input.charAt(i++));
        g = _chars.indexOf(input.charAt(i++));

        a = (d << 2) | (e >> 4);
        b = ((e & 15) << 4) | (f >> 2);
        c = ((f & 3) << 6) | g;

        result += String.fromCharCode(a);

        if (f != 64) {
            result = result + String.fromCharCode(b);
        }
        if (g != 64) {
            result = result + String.fromCharCode(c);
        }
    } while (i < input.length);

    return unescape(result);
};
String.prototype.ToUrl = function () {
    var str = this.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
    str = str.replace(/-+-/g, "-");
    str = str.replace(/^\-+|\-+$/g, "");
    return str;
};