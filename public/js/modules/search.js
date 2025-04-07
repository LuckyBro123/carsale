function init() {
  // load results for dynamic search
  // $(document).on("change", "#search, #search_mobile", { dynamic: true }, searchHandler);
  // $(document).on("keyup", "#search, #search_mobile", { dynamic: true }, searchHandler);
  $(document).on("input", "#search, #search_mobile", { dynamic: true }, searchHandler);
  $(document).on("focus", "#search, #search_mobile", { focus: true }, searchFocusHandler);
  $(document).on("blur", "#search, #search_mobile", { focus: false }, searchFocusHandler);
  // Enter-key pressed in the search input
  $(document).on("submit ", "#search_form, #search_mobile", { dynamic: false }, searchHandler);
  // click on search-btn
  $(document).on("click", "#btn_search_submit, #btn_search_mobile_submit", { dynamic: false }, searchHandler);
}

function searchHandler(event) {
  if (typeof (searchHandler.savedSearchPhrase) == "undefined") searchHandler.savedSearchPhrase = "";
  if (isMobileViewport()) {
    var divTitle = ".dynamic_search_results_mobile",
      inputID = "#search_mobile";
  } else {
    var divTitle = ".dynamic_search_results",
      inputID = "#search";
  }
  var dynamicSearchResults = $(divTitle);
  var searchStr = $(inputID).val();
  searchStr.trim();
  if (dynamicSearchResults.hasClass("d-none")) searchHandler.savedSearchPhrase = "";  // это надо, когда в строка ввода уже имеет поисковую строку, не имеет фокус и получает фокус. И надо заставить её отправить поисковый запрос на сервак
  if (searchStr.length < 2) {
    searchHandler.savedSearchPhrase = searchStr;
    dynamicSearchResults.addClass("d-none");
    return;
  }

  var words = searchStr.split(" ");
  words = words.filter(function (item, index) {
    return item.length >= 2;
  });
  if (words.length == 0) return;
  searchStr = words.slice(0, 2).join(" ");

  var requestType, requestUrl;
  if (event.data.dynamic) {
    event.preventDefault();  // disable other event handlers
    if (searchStr == searchHandler.savedSearchPhrase) return;
    searchHandler.savedSearchPhrase = searchStr;
    requestType = "POST";
    requestUrl = "/search";
  } else {
    requestType = "GET";
    requestUrl = "/search";
    return
  }

  $.ajax({
    url     : requestUrl,
    type    : requestType,
    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    data    : { search_str: searchStr },
    dataType: 'json'
  }).done(function (responseData, b, c) {                   // SUCCESS
    if (!responseData.success) {
      dynamicSearchResults.addClass("d-none");
      return;
    }
    dynamicSearchResults.removeClass("d-none");
    dynamicSearchResults.html(responseData.html)
    var handle = function (event) {
      // Проверяем, что клик не был по #search, #search_mobile или их дочерним элементам
      if ($(event.target).closest("#search").length === 0 && $(event.target).closest("#search_mobile").length === 0) {
        dynamicSearchResults.addClass("d-none");
        $(document).off("click", "*", handle);
      }
    };

    $(document).on("click", "*", handle);
  }).fail(function (jqXHR, status, errorThrown) {            // ERROR
    console.log('DYNAMIC_SEARCH > ОШИБКА AJAX запроса: ' + status, jqXHR);
  });
}

function searchFocusHandler(event) {
  if (event.data.focus) {
    $(".black_rect_fullscreen").removeClass("d-none");
    /* теперь надо инициировать событие input, ато вдруг в строке поиска уже есть ранее введенный текст - тогда надо чтобы отправился запрос на его поиск */
    if (isMobileViewport()) {
      $('#search_mobile').trigger({
        type   : 'input',
        dynamic: true
      });
    } else {
      $('#search').trigger({
        type   : 'input',
        dynamic: true
      });
    }
  } else {
    $(".black_rect_fullscreen").addClass("d-none");
  }

}

export { init }