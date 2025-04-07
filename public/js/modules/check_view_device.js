export function checkViewDeviceAndApplyFontSizeToHTMLtag() {
  let htmlTag = document.querySelector('html'); // Найди элемент
  switch (detectViewDevice()) {
    case "PHONE" :
      htmlTag.style.setProperty('font-size', '20px', 'important');
      break;
    case "TABLET" :
      htmlTag.style.setProperty('font-size', '24px', 'important');
      document.body.classList.add("tablet");
      break;
    default:
      htmlTag.style.setProperty('font-size', '16px', 'important');
      break;
  }
}