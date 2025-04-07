import { changeIsInvalidHandler, showLoaderCSS, hideLoaderCSS, showErrorModal, initDropzone, deletePhotoFromDropzoneAndServer, deleteAllPhotosFromDropzone, errorUploadPhoto, changeCarModelDatalist, removeOneThumbnailFromDropzone, clearData } from './create_and_edit_car_common.js';

function init() {
  // Dropzone инициализируется в content_test.blade.php, поскольку там надо указывать фразы с переводом на языки
  initDropzone();
  $(document).on("submit", "#create_form", send_dataClickHandler);
  $(document).on("click", ".btn_clear_data", clearData);
  $(document).on("click", ".btn_clear_photos", deleteAllPhotosFromDropzone);
  $(document).on("change", "#car_brand", changeCarModelDatalist);
  // $(document).on("click", ".dz-remove", deletePhotoFromDropzoneAndServer);
  $(document).on("change", ".is-invalid", changeIsInvalidHandler);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function send_dataClickHandler(event) {
  // event.stopPropagation(); // остановка всех текущих JS событий
  event.preventDefault();  // остановка дефолтного события для текущего элемента - отправка формы по submit

  var photoFilenames = $("span[data-dz-name]");
  if (!photoFilenames.length) { /* нету фоток, вывести ошибку и прекратить выполнение*/
    showErrorModal($("#error_modal .error_message_no_photos").text());
    return;
  }

  showLoaderCSS();
  var filenamesArray = new Set;
  for (let i = 0; i < photoFilenames.length; i++) filenamesArray.add(photoFilenames.eq(i).text());
  $("input[name=photo_filenames]").val(JSON.stringify(Array.from(filenamesArray.values())));

  // создадим объект данных формы
  var data = new FormData(document.forms.create_form);
  /*
   // заполняем FormData объект данных файлами в подходящем для отправки формате
   var files = $("#input__upload_photos")[0].files;
   $.each(files, function (key, value) {
   data.append(key, value);
   });
   */

  // AJAX запрос
  $.ajax({
    url        : '/create',
    type       : 'POST',
    headers    : {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data       : data,
    cache      : false, // dataType: 'json',
    processData: false, // отключаем обработку передаваемых данных, пусть передаются как есть
    contentType: false, // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
    // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
    success: function (response, status, jqXHR) {
      window.location.href = response.location;
    },
    // ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
    error: function (jqXHR, status, errorThrown) {
      hideLoaderCSS();
      console.log('send_dataClickHandler  ОШИБКА:', jqXHR);
      switch (jqXHR.status) {
        case 550 : // сервер не получил фотки (странно). Юзеру надо загрузить фотки в dropzone
          showErrorModal(jqXHR.responseJSON.message);
          break;
        case 551 : // проблема с фотками. Юзеру надо заново загрузить фотки в dropzone
          showErrorModal(jqXHR.responseJSON.message);
          $(".dz-preview").each(function (index, elem) {
            $(elem).remove();
          });
          $("#dropzone_placement").removeClass("dz-started");
          break;
        case 422 : // Введённые данные не прошли валидацию
          console.log("INPUT DATA HAS NOT BEEN VALIDATED");
          Object.keys(jqXHR.responseJSON.errors).forEach(function (key) {
            if (key == "message") return;
            if (!Array.isArray(jqXHR.responseJSON.errors[key])) return;
            console.log(" -> ", jqXHR.responseJSON.errors[key][0]);
            if (key == "car_color") $("#select_color_title").addClass("is-invalid");
            else $("[name=" + key + "]").addClass("is-invalid");
            showErrorModal(jqXHR.responseJSON.message);
          });
          break;
        default:
          showErrorModal(jqXHR.responseJSON.message);
          break;
      }
    }
  });
}

export { init }