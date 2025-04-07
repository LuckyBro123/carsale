import { showOrHideFiltersSection } from './filter_management.js';

// ▪▪▪ тут обслуживается появление с паузой окна WHAT_IS_IT
function init() {
  var whatIsItModal = $("#what_is_it_modal");
  // ▪▪▪▪▪▪▪▪ наведение на иконку
  $(document).on("mouseenter", "#what_is_it_btn", {}, function () {
    if ($myApp.what_is_it_message_appeared) return;
    whatIsItModal.addClass("hover");
    setTimeout(() => {
      show_whatIsItModal(whatIsItModal);
    }, 400);
  });
  // уход мышки с иконки или подменю
  $(document).on("mouseleave", "#what_is_it_btn", {}, function () {
    whatIsItModal.removeClass("hover");
  });
  // показать окно по клику мыши на кнопке
  $(document).on("click", "#what_is_it_btn", {}, function () {
    show_whatIsItModal(whatIsItModal, "just show");
  });
  // а теперь статистика
  $(document).on("click", "#statistics_btn", { btn_function: "show_statistics" }, statisticsClickHandler);
  $(document).on("click", "[data-func=close_fullscreen_statistics]", { btn_function: "close_fullscreen_statistics" }, statisticsClickHandler);

//   ДЛЯ ОТЛАДКИ
//   $('#statistics_btn').click();
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪ functions ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function show_whatIsItModal(modal, forced = "") {
  if (!modal.hasClass("hover") && !forced) return;
  modal.modal('show');
  $(".modal-backdrop").addClass("modal-backdrop_opacity_075");
  $myApp.what_is_it_message_appeared = true;
  $.cookie("what_is_it_message_appeared", 1, { expires: 15000, path: '/' });
  if (isMobileViewport()) return;

  // далее анимация окна в зависимости от движения мышкой
  modal = modal.find(".modal-content");
  var maxY = 20,
    maxX = 20,
    maxZ = 2;

  modal.mousemove(function (e) {
    var $this = $(this);
    e.stopImmediatePropagation();
    var offsetY = (e.target != e.deletageTarget) ? e.offsetY + e.target.offsetTop : e.offsetY;
    var offsetX = (e.target != e.deletageTarget) ? e.offsetX + e.target.offsetLeft : e.offsetX;
    var w = modal.outerWidth(), h = modal.outerHeight();
    var transform = { y: 1 - offsetX / w * 2, x: 0 - (1 - offsetY / h * 2) };
    transform.z = 0 - (transform.x * transform.y);

    var transformCSS = {
      x: calculateValue(maxX, transform.x),
      y: calculateValue(maxY, transform.y),
      z: calculateValue(maxZ, transform.z)
    };

    $this.css({
      transform:
        'rotateY(' + transformCSS.y + 'deg) rotateX(' + transformCSS.x + 'deg) rotateZ(' + transformCSS.z + 'deg)'
    });
  });

  modal.mouseleave(function () {
    var $this = $(this);
    $this.css({
      transform :
        'rotateY(0deg) rotateX(0deg) rotateZ(0deg)',
      transition: 'all .15s ease-out'
    });
  });
}

function calculateValue(max, value) {
  return max * value;
}

function statisticsClickHandler(event) {
  event.stopImmediatePropagation();
  var thiss = $(this);
  switch (event.data.btn_function) {
    case "show_statistics":                       // -----------------------
      // если статистика открыта, закрыть и всё
      if (!$("#statistics_global_container").hasClass("show")) break;
      showOrHideStatisticsSection();
      return;
    case "close_fullscreen_statistics":               // -----------------------
      event.stopImmediatePropagation();
      $('#statistics_global_container').removeClass("h-100");
      $('#statistics_global_container').collapse("toggle");
      $("body").css("pointer-events", "auto");
      // handleBtnShowFilters();
      return;
  }

  // подготовить набор фильтров для отправки на сервер
  // вернее надо просто извлечь параметры 'ff' и 'fd' из URL страницы
  const urlParams = new URLSearchParams(window.location.search);
  const ff = urlParams.get('ff');
  const fd = urlParams.get('fd');

  // отправка данных на сервер и обработка ответа
  $.ajax({
    url     : "/get_statistics",
    type    : 'POST',
    dataType: 'json',
    headers : {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data    : {
      ff: ff,
      fd: fd,
    },
    error   : function (jqXHR, status, errorThrown) {    // ERROR -------------
      console.log('statisticsClickHandler > ОШИБКА AJAX запроса: ' + status, jqXHR);
    }
  }).done(function (responseData, b, c) {      // SUCCESS ***********************
    if (!responseData.success) {
      console.log('ERROR responseData.success = 0 / ', b, c);
      return
    }
    let statisticsContent = $(".statistics_content");
    statisticsContent.html(responseData.html)
  });
  // скрыть фильтры
  if ($("#filters_global_container").hasClass("show")) showOrHideFiltersSection();
  showOrHideStatisticsSection();
  // ▪▪▪▪▪▪▪▪▪▪▪▪▪ конец  statisticsClickHandler ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

function handleBtnShowStatistics() {
  if (!isMobileViewport()) $("#show_statistics").toggleClass("statistics_closed");
}

function showOrHideStatisticsSection() {
  handleBtnShowStatistics();
  var elem = $('#statistics_global_container');
  elem.collapse("toggle");
  if (isMobileViewport() && $("#statistics_global_container ").hasClass("show")) {
    // закрыть фильтры на мобилке
    $("body").css("pointer-events", "auto");
    elem.removeClass("h-100");
  } else if (isMobileViewport()) {
    // распахнуть фильтры на мобилке
    $("body").css("pointer-events", "none");
    elem.addClass("h-100");
  }
}

export { init }