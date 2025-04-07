import { checkViewDeviceAndApplyFontSizeToHTMLtag } from "./modules/check_view_device.js";
checkViewDeviceAndApplyFontSizeToHTMLtag();

import * as Common from "./modules/common.js";
import * as SortmodePerpage from "./modules/sortmode_perpage.js";
import * as Search from "./modules/search.js";
import * as Favorites from "./modules/favorites.js";

$(function () {
  Common.init();
  SortmodePerpage.init();
  Search.init();
  Favorites.init();

});
