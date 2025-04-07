// ▪▪▪▪▪ этот код реализует подгрузку фоток в car_row при hover
function init() {
  if (!isDesktopViewport()) return;
  $(document).on("mouseover", ".car_row", {}, carRowMouseover);
  // $(document).on("mouseout", ".car_row", {}, extCardMouseout);
  // $(document).on("mousemove", ".car_row", {}, extCardMouseout);
}

const EXT_CARD_STATUS = "ext_card_status";

function carRowMouseover(event) {
  let row = $(this), carID = row.attr("carid");
  let photos = row.find("div.photo_not_loaded");
  for (let i = 0; i < photos.length; i++) {
    photos.eq(i).removeClass("photo_not_loaded");
    let img = photos.eq(i).find("img");
    img.attr("src",img.attr("imgurl"));
  }
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

export { init }