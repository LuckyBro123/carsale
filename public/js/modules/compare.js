function init() {
  $(window).on("scroll", { type: "vertical" }, scrollHandler);
  $(".cd-products-wrapper").on("scroll", { type: "horizontal" }, scrollHandler);
  scrollHandler({ data: { type: "vertical" } });
  scrollHandler({ data: { type: "horizontal" } });

  /*
   window.addEventListener('scroll', function () {
   const scrollPosition = window.scrollY;
   console.log(scrollPosition);
   });
   */

  /*
   $(".cd-products-wrapper").scroll(function() {
   var scrollLeft = $(this).scrollLeft();
   console.log("Горизонтальный скролл: " + scrollLeft);
   });
   */

}

function scrollHandler(event) {
  if (!$('#top-info_title').hasClass("top-info_top_fixed_1")) scrollHandler.top_info_offsetTop = $('#top-info_title').offset().top;
  var top_infos = $('.top-info'),
    top_info_height = top_infos.eq(0).outerHeight(true),
    top_info_offsetTop = top_infos.eq(0).offset().top;

  switch (event.data.type) {
    case "vertical" :
      clog("$(window).scrollTop() - ", $(window).scrollTop());
      clog("scrollHandler.top_info_offsetTop - ", scrollHandler.top_info_offsetTop);
      clog("top_info_height - ", top_info_height);
      if ($(window).scrollTop() > scrollHandler.top_info_offsetTop) { // top-info ушел вверх за край экрана
        if (scrollHandler.isHeadingFixed) {
          scrollHandler({ data: { type: "horizontal" } });
        } else {
          top_infos.each(function (index, elem) {
            if (index == 0) $(elem).addClass("top-info_top_fixed_1");
            else $(elem).addClass("top-info_top_fixed_2");
          });
          $(".cd-products-comparison-table").css("margin-top", top_info_height + "px");
          scrollHandler.isHeadingFixed = true;
          scrollHandler({ data: { type: "horizontal" } });
        }
      } else {    // top-info полностью видимый , надо отключить фиксацию
        if (scrollHandler.isHeadingFixed) {
          top_infos.removeClass("top-info_top_fixed_1 top-info_top_fixed_2");
          $(".cd-products-comparison-table").css("margin-top", "");
          scrollHandler.isHeadingFixed = false;
        } else {
        }
      }
      break;
    case "horizontal" :
      if (scrollHandler.isHeadingFixed) {
        var top_info_width = top_infos.eq(1).outerWidth(true);
        // console.clear();
        top_infos.each(function (index, elem) {
          if (index == 0) return;
          var offset = top_infos.eq(0).outerWidth(true) + top_info_width * (index - 1) - $(".cd-products-wrapper").scrollLeft();
          offset = offset.toFixed(2) + "px";
          $(elem).css("left", offset);
          find_parent($(elem)).find(".near_topinfo").css("left", offset);
        });
        var aaa = 1;
      } else {
      }
      break;
  }
}


export { init }
