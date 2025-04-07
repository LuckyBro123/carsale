// ▪▪▪▪▪ этот код ниже реализует возникновение расширенной карточки товара при наведении мышкой на car_card
function init() {
  if (!isDesktopViewport()) return;
  $(document).on("mouseover", ".car_card", {}, carCardMouseover);
  $(document).on("mouseout", ".extended_car_card:not(#layout_ext_car_card)", {}, extCardMouseout);
  $(document).on("mousemove", ".extended_car_card:not(#layout_ext_car_card)", {}, extCardMouseout);
  $(document).on("mouseover", ".ext_car_card_microphoto", {}, extendedCarCardMicrophotoMouseover);
}

const EXT_CARD_STATUS = "ext_card_status";

function carCardMouseover(event) {
  let card = $(this), carID = card.attr("carid");
  if (carID == undefined || card.attr(EXT_CARD_STATUS) == "active") return;

  if (card.attr("ext_card_id")) {   // extCard ДЛЯ ЭТОЙ МАШИНЫ УЖЕ ЕСТЬ
    let cardWidth = card.width(), cardCoords = card.offset(),
      extCard = $("#" + card.attr("ext_card_id"));
    $(".extended_car_card").not("#layout_ext_car_card").each(function (index, elem) {
      if ($(elem).attr("id") != extCard.attr("id")) $(elem).addClass("d-none");
      else $(elem).removeClass("d-none");
    });
    extCard.offset({ left: cardCoords.left - 3, top: cardCoords.top - 3 }).width(cardWidth + 6);
    extCard.find(".ext_card_photo_holder").height(extCard.find(".ext_card_photo_holder").width() / 3 * 2);
    $(".car_card[ext_card_status=active]").attr(EXT_CARD_STATUS, "");
    card.attr(EXT_CARD_STATUS, "active");
    return;
  }
  //  extCard ДЛЯ ЭТОЙ МАШИНЫ ЕЩЕ НЕТ

  let extCardId = "ext_car_card" + carID,
    cardWidth = card.width(), cardCoords = card.offset();

  let extCard = $("#" + extCardId);
  if (!extCard.length) {
    extCard = $('#layout_ext_car_card').clone();
    extCard.attr("id", extCardId)
    $('body').append(extCard);
  }

  // копирую 5 микрофоток
  var microPhotosFrom = card.find(".microphoto_set_for_ext_car_card"),
    microPhotosTo = extCard.find(".ext_car_card_microphoto_set.not_for_layout");
  microPhotosFrom.find("img").each(function () {
    $(this).attr("src",$(this).attr("imgurl"));
  });
  microPhotosTo.html(microPhotosFrom.html());

  // копирую инфу из car_card в ext_car_card
  extCard.find(".ext_car_card_photo").attr("src", card.find(".card-img-top").attr("src"));
  extCard.attr("card_id", card.attr("id"));
  let url = card.find(".card_url").attr("href");
  extCard.find(".card_url").attr("href", url);
  extCard.find("a.btn").attr("href", url);

  var dataHolder = card.find("div.data_holder");
  extCard.find("h6.car_name").text(dataHolder.attr("fullname"));
  extCard.find("h6.car_year_price span:nth-of-type(1)").text(dataHolder.attr("year"));
  extCard.find("h6.car_year_price span:nth-of-type(2)").text(dataHolder.attr("price"));

  // надо считать настройки из куков и обновить их в ext_card
  var settings = $.cookie($myApp.productName + "_ext_card_settings");
  if (settings) settings = JSON.parse(settings);
  else settings = ["mileage", "fuel_consumption", "was_in_accident"];

  extCard.find("p.car_parameters").each(function (index, elem) {
    elem = $(elem);
    var value = dataHolder.attr(elem.attr("type"));
    elem.find("span:nth-of-type(2)").text(value);

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

  extCard.find("input.input_compare").attr("carid", carID);
  extCard.find("input.input_compare").prop("checked", card.find("input.input_compare").prop("checked"));
  extCard.find("input.input_favorite").attr("carid", carID);
  extCard.find("input.input_favorite").prop("checked", card.find("input.input_favorite").prop("checked"));
  card.attr("ext_card_id", extCardId);

  // закрыть другие ext_card
  $(".extended_car_card").not("#layout_ext_car_card").each(function (index, elem) {
    if ($(elem).attr("id") != extCard.attr("id")) $(elem).addClass("d-none");
    else $(elem).removeClass("d-none");
  });
  extCard.offset({ left: cardCoords.left - 3, top: cardCoords.top - 3 }).width(cardWidth + 6);
  extCard.find(".ext_card_photo_holder").height(extCard.find(".ext_card_photo_holder").width() / 3 * 2);
  $(".car_card[ext_card_status=active]").attr(EXT_CARD_STATUS, "");
  card.attr(EXT_CARD_STATUS, "active");
}

function extCardMouseout(event) {
  event.stopImmediatePropagation();
  let thiss = $(this), cardId = thiss.attr("card_id");
  if (isMouseOverObject(event.pageX, event.pageY, thiss)) return;
  thiss.addClass("d-none");
  $("#" + cardId).attr(EXT_CARD_STATUS, "");
}

function isMouseOverObject(mouseX, mouseY, objJQ) {
  let coords = objJQ.offset(), rightX = coords.left + objJQ.width(), rightY = coords.top + objJQ.height();
  return (mouseX >= coords.left && mouseX <= rightX && mouseY >= coords.top && mouseY <= rightY);
}

function extendedCarCardMicrophotoMouseover(event) {
  let thiss = $(this), extCard = find_parent(thiss, "extended_car_card"), mainPhoto = extCard.find("img.ext_car_card_photo");
  mainPhoto.attr("src", thiss.attr("src"));
}

export { init }