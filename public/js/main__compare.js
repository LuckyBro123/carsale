import { checkViewDeviceAndApplyFontSizeToHTMLtag } from "./modules/check_view_device.js";
checkViewDeviceAndApplyFontSizeToHTMLtag();

import * as Common from "./modules/common.js";
import * as Search from "./modules/search.js";
import * as Compare from "./modules/compare.js";

$(function () {
  Common.init();
  Search.init();
  Compare.init();
});
