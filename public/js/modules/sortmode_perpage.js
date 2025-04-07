function init() {
  init_sortMode_perPage_URL();
  // ▪▪▪▪▪▪▪▪ EVENTS
  $(document).on("change", "#sort_mode", {}, sortModeClickHandler);
  $(document).on("change", "#elems_per_page", {}, elemsPerPageClickHandler);

  // Enter-key pressed in the page_number input
  $('.page_number').keypress(function (event) {
    if (event.which === 13) {
      event.data = { eventType: "input enter pressed", pageNumber: $(this).val() };
      pageNumberHandler(event);
    }
  });
  // click on btn_page_number_submit
  $(document).on("click", ".btn_page_number_submit", { eventType: "btn mouse click" }, pageNumberHandler);
  // <select> was changed
  $(document).on("change", "select[id=page_numbers]", { eventType: "select was changed" }, pageNumberHandler);

}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪ functions ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

/*
 инициализирует механизм для сортировки и perpage
 */
function init_sortMode_perPage_URL() {
  $myApp.sortModes[$myApp.productName] = $("#sort_mode").val();
  if ($myApp.sortModes[$myApp.productName] == "random") {
    var cookie = $.cookie($myApp.productName + '_sort_mode');
    if (cookie) {
      $myApp.sortModes[$myApp.productName] = cookie;
      $("#sort_mode").val(cookie)
    }
  }
  // addParamInURL("sort", $myApp.sortMode);

  $myApp.perPages[$myApp.productName] = +$("#elems_per_page").val();
  if ($myApp.perPages[$myApp.productName] == "random") {
    var cookie = $.cookie($myApp.productName + '_per_page');
    if (cookie) {
      $myApp.perPages[$myApp.productName] = cookie;
      $("#elems_per_page").val(cookie)
    }
  }
  // addParamInURL("perpage", $myApp.perPage);
}

function sortModeClickHandler(event) {
  $myApp.sortModes[$myApp.productName] = $(this).val();
  $.cookie($myApp.productName + '_sort_mode', $myApp.sortModes[$myApp.productName], { expires: 15, path: '/' });
  var currentURL = new URL(window.location);
  // currentURL.searchParams.set("sort", $myApp.sortMode);
  // currentURL.searchParams.set("perpage", $myApp.perPage);
  window.location.href = currentURL.href;
}

function elemsPerPageClickHandler(event) {
  $myApp.perPages[$myApp.productName] = $(this).val();
  $.cookie($myApp.productName + '_per_page', $myApp.perPages[$myApp.productName], { expires: 15, path: '/' });
  var currentURL = new URL(window.location);
  if (window.location.href.indexOf('page=') !== -1) {
    currentURL.searchParams.set("page", 1);
  }
  // currentURL.searchParams.set("sort", $myApp.sortMode);
  // currentURL.searchParams.set("perpage", $myApp.perPage);
  window.location.href = currentURL.href;
}

function pageNumberHandler(event) {
  switch (event.data.eventType) {
    case "input enter pressed" :
      var pageNumber = event.data.pageNumber;
      var maxPageNumber = $("input.page_number").attr("max");
      break;
    case "btn mouse click" :
      pageNumber = find_parent($(this)).find("input.page_number").val()
      // pageNumber = $("input.page_number").val()
      maxPageNumber = $("input.page_number").attr("max");
      break;
    case "select was changed" :
      pageNumber = $(this).val();
      maxPageNumber = $(this).find("option").length;
      break;
  }
  pageNumber = limitNumber(+pageNumber, 1, +maxPageNumber);
  var currentURL = new URL(window.location);
  currentURL.searchParams.set("page", pageNumber);
  window.location.href = currentURL.href;
}

export { init }