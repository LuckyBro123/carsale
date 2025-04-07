import { checkViewDeviceAndApplyFontSizeToHTMLtag } from "./modules/check_view_device.js";
checkViewDeviceAndApplyFontSizeToHTMLtag();

import * as Common from "./modules/common.js";
import * as ViewCar from "./modules/view_car.js";
import * as Search from "./modules/search.js";

$(function () {
  Common.init();
  ViewCar.init();
  Search.init();

});
