// ▪▪▪ тут обслуживается появление с паузой окна WHAT_IS_IT
function init() {
  if (!isDesktopViewport()) return;
  // показать окно по клику мыши на кнопке настроек
  $(document).on("click", "#settings_for_car_card_btn", {}, settingsBtnClicked);
  // клик по настройке
  $(document).on("click", ".ext_car_card_setting_checkbox", {}, settingCheckboxClicked);
  $(document).on("click", "button[data-func=all_on_settings_for_ext_car_card]", { action: "all" }, changeSettings);
  $(document).on("click", "button[data-func=all_off_settings_for_ext_car_card]", { action: "nothing" }, changeSettings);
  $(document).on("click", "button[data-func=reset_to_default_settings_for_ext_car_card]", { action: "default" }, changeSettings);
  // применить настройки
  $(document).on("click", "button[data-func=apply_new_settings_for_ext_car_card]", {}, applyNewSettingsForExtCarCard);

  // для отладки
  // $('#settings_for_car_card_btn').click();

}

// ▪▪▪▪▪▪▪ functions ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function changeSettings(event) {
  event.stopImmediatePropagation();
  var checkboxes = $("input.ext_car_card_setting_checkbox");

  switch (event.data.action) {
    case "all" :
      var default_settings = ["mileage", "gearbox", "engine_capacity", "engine_power", "fuel_consumption", "wheelbase", "number_doors", "was_in_accident"];
      change(default_settings);
      break;
    case "nothing" :
      var default_settings = [];
      change(default_settings);
      break;
    case "default" :
      var default_settings = ["mileage", "fuel_consumption", "was_in_accident"];
      change(default_settings);
      break;
  }

  function change(settingsArray) {
    var checkboxes = $("input.ext_car_card_setting_checkbox");
    checkboxes.each(function (index, elem) {
      var infoItem = $("#layout_ext_car_card .car_parameters[type=" + elem.name + "]");
      if (settingsArray.includes(elem.name)) {  // ВКЛЮЧИТЬ
        elem.checked = true;
        infoItem.attr('style', '');
      } else {  // ВЫКЛЮЧИТЬ
        elem.checked = false;
        infoItem.attr('style', 'height: 0px');
      }
    });
  }
}


function settingsBtnClicked(event) {
  var btn = $(event.currentTarget);
  clog(event)
  if (btn.hasClass("active")) {       // надо ЗАКРЫТЬ настройки
    btn.removeClass("active");
  } else {                            // надо ОТКРЫТЬ настройки
    btn.addClass("active");
    var extCard = $('#layout_ext_car_card'),
      extCardWidth = $('.car_card:not(.extended_car_card)').eq(0).width() + 6;
    extCard.css("width", extCardWidth);
    extCard.find(".ext_card_photo_holder").height(extCardWidth / 3 * 2);

    // надо считать настройки из куков и обновить их в макете ext_card
    var settings = $.cookie($myApp.productName + "_ext_card_settings");
    if (settings) settings = JSON.parse(settings);
    else settings = ["mileage", "fuel_consumption", "was_in_accident"];

    $("input.ext_car_card_setting_checkbox").each(function (index, elem) {
      elem = $(elem);
      var checked = settings.includes(elem.attr("name"));
      elem.prop("checked", checked);
    });
    // а теперь обновить макет ext_card
    extCard.find("p.car_parameters").each(function (index, elem) {
      elem = $(elem);
      var checked = settings.includes(elem.attr("type"));
      switch (checked) {
        case true :
          elem.attr("style", "");
          break;
        case false :
          elem.css("height", "0px");
          break;
      }
    });
  }
  var elem = $('#settings_for_ext_car_card_global_container');
  elem.collapse("toggle");

}

function settingCheckboxClicked(event) {
  event.stopImmediatePropagation();
  var checkboxName = event.currentTarget.name;
  // а теперь надо анимированно убрать или показать переключенную строку в extCarCard
  var infoItem = $("#layout_ext_car_card .car_parameters[type=" + checkboxName + "]");
  if (event.currentTarget.checked) { // ВКЛЮЧИТЬ элемент
    // Получаем естественную высоту элемента
    var naturalHeight = infoItem.css('height', 'auto').height();
    // Возвращаем высоту в 0
    infoItem.height(0);
    // Анимируем высоту до естественной
    infoItem.animate({
      height: naturalHeight
    }, 200, function () {
      // После завершения анимации убираем inline стили
      $(this).attr('style', '');
    });
  } else infoItem.animate({ height: '0px' }, 200, function () { // ВЫКЛЮЧИТЬ элемент
  });
}

function applyNewSettingsForExtCarCard(event) {
  event.stopImmediatePropagation();
  var new_settings = [],
    checkboxes = $("input.ext_car_card_setting_checkbox");

  checkboxes.each(function (index, elem) {
    if (elem.checked) new_settings.push(elem.name);
  });
  $.cookie($myApp.productName + "_ext_card_settings", JSON.stringify(new_settings), { expires: 1000000, path: '/' });

  // теперь надо всем имеющимся ext_card вкл\откл car_parameters
  var extCards = $(".extended_car_card:not(#layout_ext_car_card)");
  checkboxes = new Map($('#checkboxes_ext_car_card_settings input[type="checkbox"]').map(function () {
    return [[this.name, this.checked]];
  }).get());
  extCards.each(function (index, elem) {
    var extCard = $(elem);
    extCard.find("p.car_parameters").each(function (index, elem) {
      elem = $(elem);
      var checked = checkboxes.get(elem.attr("type"));
      switch (checked) {
        case true :
          elem.attr("style", "");
          break;
        case false :
          elem.css("height", "0px");
          break;
      }
    });
  });
}

export { init }