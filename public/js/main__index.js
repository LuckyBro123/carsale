var cardOrListViewMode = $("body").attr("card_or_row_view_mode");
import { checkViewDeviceAndApplyFontSizeToHTMLtag } from "./modules/check_view_device.js";
checkViewDeviceAndApplyFontSizeToHTMLtag();

import * as common from "./modules/common.js";
import * as sortmodePerpage from "./modules/sortmode_perpage.js";
import * as filters from "./modules/filter_management.js";
import * as whatIsItStatisticsButtons from "./modules/what_is_it_statistics_buttons.js";
if (cardOrListViewMode == "card") {
  var settingsForCarCardBtn = await import("./modules/settings_for_ext_car_card_btn.js");
  var productCardIcons = await import("./modules/product_card_icons_management.js");
  if (isDesktopViewport()) var ExtendedCarCard = await import("./modules/extended_car_card.js");
} else var CarRow = await import("./modules/car_row.js");
import * as search from "./modules/search.js";

$(function () {
  common.init();
  sortmodePerpage.init();
  filters.init();
  whatIsItStatisticsButtons.init();
  if (cardOrListViewMode == "card") {
    settingsForCarCardBtn.init();
    productCardIcons.init();
    if (isDesktopViewport()) ExtendedCarCard.init();
  } else CarRow.init();
  search.init();
});
