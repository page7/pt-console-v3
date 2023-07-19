$(function(){

    var win = $(window), doc = $(document);
    if($(".autoheight").length){
        !function(){
            $(".autoheight").bind("resize", {}, function(){
                var dom = $(this),
                    y = dom.offset().top,
                    h = dom.height(),
                    wh = win.height(); //console.log(wh, h, y);
                if (y + h <= wh) {
                    var nh = wh - y;
                    dom.height(nh);
                } else {
                    dom.css("height", "auto");
                }
            }).trigger("resize");
        }();
    }

    win.scroll(function(){
        var t = Math.round(win.scrollTop()),
            hd = $(".mobile header"), bt = $(".blurtitle");
        hd.css("opacity", (t>100 ? 0 : 100-t)/100);
        if (bt.length) {
        }
    });

    window.alert = function(msg){
        var altdom = $("<div class='alert' style='display:none;'><span></span></div>");
        altdom.children('span').text(msg);
        altdom.appendTo('body').fadeIn(200).delay(3000).fadeOut(200, function(){ $(this).remove(); });
    };

    $(".pc header .city").click(function(){
        $(".citys").addClass("active");
    });

    $(document).on("click", function(e){
        var t = $(e.target);
        if (!t.is(".citys") && t.parents(".citys").length == 0 && !t.is("header .city")) {
            $(".citys").removeClass("active");
        }
    });

    $(".pc .citys dt a").click(function(){
        var a = $(this), id = a.text();
        $(".citys dd.city-code-"+id).show().siblings("dd:not(.hot)").hide();
    });

    $(".pc .citys dd a").click(function(){
        var a = $(this), id = a.data("id"), name = a.text();
        $(".citys").removeClass("active");
        $("header .city").text(name);
    });

    $(".pc .serivce li").mouseover(function(){
        $(this).addClass("act");
    })
    .mouseout(function(){
        $(this).removeClass("act");
    });

    $(".pc header .service").click(function(){
        $(".serivce ul li:eq(2)").trigger("mouseover");
    });

    $(".btn-service").click(function(){
        $(".serivce ul li:eq(2)").trigger("mouseover");
    });

});
