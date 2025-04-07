{{--
Этот код я попробовал на странице cars index, он работает, но переделывать все стили на этот механизм не захотел. Много работы, нет смысла
--}}
<script type="text/javascript">
  // Определение типа устройства и загрузка соответствующего CSS-файла
  switch (detectViewDevice()) {
    case 'PHONE':
      loadCSS("{{asset('/css/' . $phoneCSS)}}");
      break;
    case 'TABLET':
      loadCSS("{{asset('/css/' . $tabletCSS)}}");
      break;
    case 'DESKTOP':
      loadCSS("{{asset('/css/' . $desktopCSS)}}");
      break;
  }

  function loadCSS(href) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = href;
    document.head.appendChild(link);
  }
</script>