(function ($) {
    $.fn.VideoList = function (viewPanelId,width, height) {
        var a = $(this);
        var b = $(this).children();
        b.eq(0).addClass("today");
        var image = b.eq(0).children("a").attr("image");
        if (image == null || image == undefined || image.match('id=0') == 'id=0') image = '';
        embedVideo(viewPanelId, ResolveUrl("~" + b.eq(0).children("a").attr("val")), width, height, false, image);
        var view = $("#" + viewPanelId);
        b.each(function () {
            b.children("a").bind("click", function (event) {

                b.removeClass("today");
                $(this).parent().addClass("today");
                var url = $(this).attr("val");
                image = $(this).attr("image");
                if (image == null || image == undefined || image.match('id=0') != '') image = '';
                if (url != undefined || url != '') {
                    if (url.match("http://") == '') {
                        url = "~" + url;
                    }
                    embedVideo(viewPanelId, ResolveUrl(url), width, height, true, image);
                }
            });
        });
    };
    $.fn.VideoView = function (url, width, height, autostart) {
        var a = $(this);
        if (a.attr("id") != undefined) {
            embedVideo(a.attr("id"), url, width, height, autostart, a.attr('image'));
        }
    };
    function embedVideo(viewPanelId, url, width, height, autostart, image) {
        /*  var scale = width / height;
          height = height > 200 ? height : 200;
          width = height * scale;*/

        if (jwplayer(viewPanelId) != null) {
            jwplayer(viewPanelId).setup({
                'file': url,
                'flashplayer': '/Scripts/jwplayer/player.swf',//'<%= Page.ResolveUrl("~/Scripts/jwplayer/player.swf") %>'

                'autostart': autostart,
                'repeat': 'none',
                'icons': 'true',
                'volume': 60,
                'image': image,
                'height': height,
                'width': width,
                'mute': false,
                //'controlbar': 'none',
                'controlbar': 'bottom',
                //'stretching': 'exactfit',
                'stretching': 'fill',
                "controlbar.position": "bottom",
                /*'skin': '/Scripts/jwplayer/skin/stormtrooper/stormtrooper.xml',*/
                'skin': '/Scripts/jwplayer/skin/polishedmetal/polishedmetal.xml',
                events: {
                    onComplete: function () {
                    }
                }
            });
        }
    }
})(jQuery);


function PlayVideo(Url, ID) {
    jwplayer('avView').remove();
    jwplayer("avView").setup({
        autostart: true,
        flashplayer: '/Scripts/jwplayer/player.swf',
        file: Url,
        image: ''
    });
    $('.active_video').removeClass().addClass('link-video');
    $(ID).parent().removeClass().addClass('active_video');
}