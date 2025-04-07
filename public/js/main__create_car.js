import { checkViewDeviceAndApplyFontSizeToHTMLtag } from "./modules/check_view_device.js";
checkViewDeviceAndApplyFontSizeToHTMLtag();

import * as Common from "./modules/common.js";
import * as CreateCar from "./modules/create_car.js";
import * as Search from "./modules/search.js";

$(function () {
  Common.init();
  CreateCar.init();
  Search.init();

});

