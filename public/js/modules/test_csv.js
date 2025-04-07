function init() {
  // click on buttons  Export or Import
  $(document).on("click", ".btn_export_data", { func: "export" }, btnHandler_Export);
  $(document).on("click", ".btn_import_data", { func: "import" }, btnHandler_Import);

  // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

  // клик по кнопке Export
  function btnHandler_Export(event) {
    event.preventDefault();  // disable other event handlers

    $.ajax({
      url     : "/table_export",
      type    : "POST",
      headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data    : { data_set: "" },
      dataType: 'json',
      // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
      success: function (responseData, b, c) {                   // SUCCESS
        clog(responseData.reply);
      },
      // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
      error: function (jqXHR, status, errorThrown) {            // ERROR
        console.log('btnHandler_Export > ОШИБКА AJAX запроса: ' + status, jqXHR);
      }
    });
  }

  // клик по кнопке Import
  function btnHandler_Import(event) {
    event.preventDefault();  // disable other event handlers

    var filename = $('input[name=csv_filename]:checked').attr("filename");

    $.ajax({
      url     : "/table_import",
      type    : "POST",
      headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data    : { filename: filename },
      dataType: 'json'
    }).done(function (responseData, b, c) {                   // SUCCESS
      clog(responseData.reply);

    }).fail(function (jqXHR, status, errorThrown) {            // ERROR
        console.log('btnHandler_Import > ОШИБКА AJAX запроса: ' + status, jqXHR);
      }
    );
return

    $.ajax({
      url     : "/table_import",
      type    : "POST",
      headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data    : { filename: filename },
      dataType: 'json',
      // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
      success: function (responseData, b, c) {                   // SUCCESS
        clog(responseData.reply);
      },
      // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
      error: function (jqXHR, status, errorThrown) {            // ERROR
        console.log('btnHandler_Import > ОШИБКА AJAX запроса: ' + status, jqXHR);
      }
    });
  }

}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

export { init }

