/* global mod */

var supporttouch = "ontouchend" in document;
!supporttouch && (window.location.href = '/home/Index/');

var platform = navigator.platform;
var ua = navigator.userAgent;
var ios = /iPhone|iPad|iPod/.test(platform) && ua.indexOf("AppleWebKit") > -1;
var andriod = ua.indexOf("Android") > -1;

function footerPosition() {
    $("footer").removeClass("fixed-bottom");
    if (window.pageYOffset > window.innerHeight) {
        $(".mod_backtop").show();
    } else {
        $(".mod_backtop").hide();
    }
}

//轮询
function banner_focus() {
    $('#focus').width($(window).width());
    $('#focus').height(326 * ($(window).width() / 640));
    $('#focus').find('img').width($(window).width());
    $('#focus').find('img').height(326 * ($(window).width() / 640));
    var autoPlay = $('#focus').find('img').length > 1 ? true : false;
    TouchSlide({
        slideCell: "#focus",
        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell: ".bd ul",
        effect: "leftLoop",
        autoPlay: autoPlay, //自动播放
        autoPage: true //自动分页
    });
}
//推荐
function hotthreads() {
    setInterval(function() {
        var index = $('#hotthreads > ul').children('li.a').index();
        index = index < 0 ? 0 : index;
        var length = $('#hotthreads > ul').children('li').length;
        var next = (index + 1) < length ? (index + 1) : 0;
        $('#hotthreads > ul').children('li').each(function(i) {
            $(this).removeClass("a");
        });
        $('#hotthreads > ul').children('li').eq(next).addClass("a");
        $('#hotthreads > ul').css({transform: 'translateY(' + (0 - next * 18) + 'px)'});
    }, 3500);
}
//文章列表
window.curpage = 1;
function threadlist() {
    var loadRecommend = function() {
        var pageURL = '/app/Index/digests/?pageSize=2&classid=' + classid + '&page=' + window.curpage;
        $.getJSON(pageURL, function(data) {
            if (data == null || data == "undefined" || data.length == 0) {
                $('#more_tips').remove();
                window.scrolled = new Date().getTime();
            } else {
                var html = '';
                for (var index in data) {
                    var item = data[index];
                    if (typeof(item.picurl) != 'undefined') {
                        html += '<div class="digest_item cl"><div class="bigpic"><a href="' + item.url + '" ><img src="' + item.picurl + '" width="108.8" height="72.88" /><span>' + item.title + '</span></a></div><dl class="cl"><dd class="summary">'
                                + item.summary + '</dd><dd class="info"><a class="author iconfont icon-author" href="member/?uid='
                                + item.authorid + '" >' + item.author + '</a><i class="views iconfont icon-views">'
                                + item.views + '</i></dd></dl></div>';
                    } else if (typeof(item.imgattach) != 'undefined' && item.imgattach.length == 3) {
                        html += '<div class="digest_item cl"><a class="title" href="' + item.url + '" >' + item.title + '</a><div class="pics">';
                        for (var i in item.imgattach) {
                            html += '<a href="' + item.url + '" class="pic" ><img src="'
                                    + item.imgattach[i] + '" alt="' + item.title + '" width="108.8" height="72.88" /></a>';
                        }
                        html += '</div><p class="summary">' + item.summary
                                + '</p><p class="info"><a class="author iconfont icon-author" href="member/?uid='
                                + item.authorid + '" >' + item.author + '</a><i class="views iconfont icon-views">'
                                + item.views + '</i></p></div>';
                    } else if (typeof(item.imgattach) != 'undefined') {
                        html += '<div class="digest_item img cl"><dl class="cl"><dt class="m"><a class="title" href="' + item.url + '" >'
                                + item.title + '</a></dt><dd class="summary">'
                                + item.summary + '</dd><dd class="info"><a class="author iconfont icon-author" href="member/?uid='
                                + item.authorid + '">' + item.author + '</a><i class="views iconfont icon-views">'
                                + item.views + '</i></dd></dl><div class="pic"><a href="' + item.url + '" title="'
                                + item.title + '"><img src="' + item.imgattach[0] + '" width="108.8" height="72.88" alt="'
                                + item.title + '" /></a></div></div>';
                    } else {
                        html += '<div class="digest_item cl">' + '<dl class="cl"><dt class="m"><a class="title" href="'
                                + item.url + '">' + item.title + '</a></dt><dd class="summary">'
                                + item.summary + '</dd><dd class="info"><a class="author iconfont icon-author" href="member/?uid='
                                + item.authorid + '">' + item.author + '</a><i class="views iconfont icon-views">'
                                + item.views + '</i></dd></dl></div>';
                    }
                }
                $('#more_tips').remove();
                $('#digests').append(html);
                window.scrolling = null;
            }
        });
    };
    window.scrolltimer = null;
    $(window).bind("scroll", function() {
        if (window.scrolltimer == null && window.scrolled == null) {
            window.scrolltimer = setTimeout(function() {
                var scrollTop = $(document).scrollTop(), docHeight = $(document).height(), winHeight = $(window).height();
                if ((scrollTop + winHeight + 100) >= docHeight && window.scrolling == null) {
                    window.scrolling = new Date().getTime();
                    var loading = '<p id="more_tips"><img src="' + siteurl + '/static/images/loading.gif" alt="" width="16" height="16" class="vm" /> 加载中...</p>';
                    $('#digests').append(loading);
                    window.curpage++;
                    loadRecommend();
                }
                window.scrolltimer = null;
            }, 320);
        }
    });
    loadRecommend();

}

(function($) {
    $(document).ready(function() {
        //导航更多
        $('#nav_down_id').click(function() {
            $('.site_nav').toggleClass('open')
        });
        //置顶
        footerPosition();
        window.onscroll = footerPosition;
        $(window).resize(footerPosition);
        //定位
        getLocation();
        banner_focus();
        hotthreads();
        if (basescript === "news" && mod === "list") {
            threadlist();
        }

    });
})(jQuery);


