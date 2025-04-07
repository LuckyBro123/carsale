import { checkViewDeviceAndApplyFontSizeToHTMLtag } from "./modules/check_view_device.js";
checkViewDeviceAndApplyFontSizeToHTMLtag();

import * as Common from "./modules/common.js";
import * as Search from "./modules/search.js";
import * as Test from "./modules/test_get_progress_of_operation.js";

$(function () {
  Common.init();
  Search.init();
  Test.init();
});
