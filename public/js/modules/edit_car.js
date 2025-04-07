import { changeIsInvalidHandler, showLoaderCSS, hideLoaderCSS, showErrorModal, initDropzone, deletePhotoFromDropzoneAndServer, deleteAllPhotosFromDropzone, errorUploadPhoto, changeCarModelDatalist, removeOneThumbnailFromDropzone, clearData } from './create_and_edit_car_common.js';

function init() {
  // Dropzone инициализируется в content_test.blade.php, поскольку там надо указывать фразы с переводом на языки
  initDropzone();
  // click on the Send and Clear Data buttons
  $(document).on("submit", "#edit_form", send_dataClickHandler);
  $(document).on("click", ".btn_clear_data", clearData);
  $(document).on("click", ".btn_clear_photos", deleteAllPhotosFromDropzone);
  $(document).on("change", "#car_brand", changeCarModelDatalist);
  // $(document).on("click", ".dz-remove", deletePhotoFromDropzoneAndServer);
  $(document).on("click", ".btn-remove-old-photo", deleteOldPhotoFromDropzone);
  $(document).on("change", ".is-invalid", changeIsInvalidHandler);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function send_dataClickHandler(event) {
  // event.stopPropagation(); // остановка всех текущих JS событий
  event.preventDefault();  // остановка дефолтного события для текущего элемента - отправка формы по submit
  var thumbnails = $(".dz-preview:not(.d-none)");
  if (!thumbnails.length) { /* нету фоток, вывести ошибку и прекратить выполнение*/
    showErrorModal($("#error_modal .error_message_no_photos").text());
    return;
  }

  showLoaderCSS();
  var thumbnailsWithDeleted = $(".dz-preview");
  var photosArray = new Set;
  for (let i = 0; i < thumbnailsWithDeleted.length; i++) {
    let file = {};
    file["filename"] = thumbnailsWithDeleted.eq(i).attr("file_name");
    var status = thumbnailsWithDeleted.eq(i).attr("file_status");
    switch (thumbnailsWithDeleted.eq(i).attr("file_status")) {
      case "old" :
        file.status = "old";
        file["filename"] = thumbnailsWithDeleted.eq(i).attr("file_name");
        break;
      case "del" :
        file.status = "del";
        file["filename"] = thumbnailsWithDeleted.eq(i).attr("file_name");
        break;
      default  :
        file.status = "new";
        file["filename"] = thumbnailsWithDeleted.eq(i).find("span[data-dz-name]").text();
        break;
    }
    photosArray.add(file);
  }
  // таким образом на сервер передаются список файлов и их статус
  $("input[name=photo_filenames]").val(JSON.stringify(Array.from(photosArray.values())));

  // создадим объект данных формы
  var data = new FormData(document.forms.edit_form),
    url = new URL(window.location.href).pathname;

  // AJAX запрос
  $.ajax({
    url        : url,
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
        case 552 : // возможность сохранения отключена, чтобы избежать вредительства от посетителей
          showErrorModal(jqXHR.responseJSON.message);
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

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function deleteOldPhotoFromDropzone(event) {
  var
    thumbnail = find_parent($(this), "dz-preview"),
    filename = thumbnail.attr("file_name"),
    status = thumbnail.attr("file_status");

  if (status != "old") return;
  thumbnail.attr("file_status", "del")
  thumbnail.animate({ width: '0px', height: "0px" }, 200, function () {
    $(this).addClass("d-none");
    // если не осталось ни одной миниатюры, то надо включить dropzone
    var thumbnailsAmount = $(".dz-preview:not(.d-none)").length;
    if (!thumbnailsAmount) $("#dropzone_placement").removeClass("dz-started");
    $(".photos_amount").text(thumbnailsAmount);
  });
}

export { init }