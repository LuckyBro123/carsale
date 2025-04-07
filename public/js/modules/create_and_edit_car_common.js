export function changeIsInvalidHandler() {
  $(this).removeClass("is-invalid");
}

export function showLoaderCSS() {
  $("#loader_black_rect_fullscreen").removeClass("d-none");
}

export function hideLoaderCSS() {
  $("#loader_black_rect_fullscreen").addClass("d-none");
}

export function showErrorModal(message) {
  $("#error_modal .error_modal_text").text(message);
  $('#error_modal').modal('show');
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// в content_test.blade.php лежит присвоение $myApp.dictDefaultMessage, чтобы получить перевод этой фразы
export function initDropzone() {
  // Dropzone.discover();
  $myApp.myDropzone = new Dropzone("#dropzone_placement", {
      // paramName         : "file", // The name that will be used to transfer the file
      url               : "/photo-upload",
      addRemoveLinks    : true,
      filesizeBase      : 1024,
      maxFilesize       : 15, // MB
      maxFiles          : 50,
      parallelUploads   : 4,
      acceptedFiles     : `image/*`,
      previewsContainer : "#dropzone_placement",
      thumbnailMethod   : "contain",
      thumbnailWidth    : 180,
      thumbnailHeight   : 180,
      dictCancelUpload  : "",
      dictRemoveFile    : `<svg width="1rem" height="1rem"><use xlink:href="#i_close_mini"></use></svg>`,
      dictDefaultMessage: $myApp.dictDefaultMessage,
      // resizeMethod  : "contain",
      init          : function () {
        // добавляю огромную иконку с надписью в dropzone
        $(".dz-default.dz-message").prepend($(".drag_drop_big_icon"));
        // если в dropzone уже есть фотки, то делаю невидимой предыдущую большую иконку
        if ($("#dropzone_placement").find(".dz-preview:not(.d-none)").length) $("#dropzone_placement").addClass("dz-started");
        // добавляю возможность перетягивать миниатюры внури dropzone
        $('.dropzone').sortable({
          animation: 250,
          draggable: ".dz-preview",
        });
      },
      accept        : function (file, done) {
        // console.log("accept -> " + file.name);
        done();
      },
      success       : function (file) {
        /*
         if (file.previewElement) {
         return file.previewElement.classList.add("dz-success");
         }*/
        $(".error_holder").addClass("d-none");
        var thumbnailsAmount = $(".dz-preview:not(.d-none)").length;
        $(".photos_amount").text(thumbnailsAmount);
      },
      error         : errorUploadPhoto,
      sending       : function (file, xhr) {
        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
      },
      reset         : function () {
      },
      renameFile    : function (file) {
        console.log("renameFile -> ", file.name);
      },
      renameFilename: function (file) {
        return $("input[name=id_for_link_form_and_uploaded_photos]").val() + "_-_-_" + file;
      },
      removedfile   : deletePhotoFromDropzoneAndServer,
    }
  );
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
export function deletePhotoFromDropzoneAndServer(file) {
  // event.stopPropagation(); // остановка всех текущих JS событий
  event.preventDefault();  // остановка дефолтного события для текущего элемента - отправка формы по submit

  var filename = file.name,
    id_for_link_form_and_uploaded_photos = $("input[name=id_for_link_form_and_uploaded_photos]").val(),
    thumbnail = $(file.previewElement);
  var dataToSend = {
    filename                            : filename,
    id_for_link_form_and_uploaded_photos: id_for_link_form_and_uploaded_photos
  }

  $.ajax({
    url     : '/delete-uploaded-photo',
    type    : 'POST',
    headers : { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    data    : dataToSend,
    dataType: 'json',
    success : function (response, status, jqXHR) {
      removeOneThumbnailFromDropzone(thumbnail);
    },
    error   : function (jqXHR, status, errorThrown) { // функция ошибки ответа сервера
      console.log('deletePhotoFromDropzoneAndServer  ОШИБКА : ' + status, jqXHR);
    }
  });
}

export function deleteAllPhotosFromDropzone(event) {
  var thumbnails = $(".dz-preview");
  for (let i = 0; i < thumbnails.length; i++) {
    let
      thumbnail = thumbnails.eq(i),
      filename = thumbnail.attr("file_name"),
      status = thumbnail.attr("file_status");

    // if (status != "old") continue;
    thumbnail.attr("file_status", "del")
    thumbnail.animate({ width: '0px', height: "0px" }, 150, function () {
      $(this).addClass("d-none");
    });
  }
  // надо включить dropzone и 0 фоток написать
  $("#dropzone_placement").removeClass("dz-started");
  $(".photos_amount").text(0);
}

// вызывается, если сервер вернул ошибку при загрузке фотки
export function errorUploadPhoto(file, message) {
  var thumbnail = find_parent($("span[data-dz-name]").filter(function (index) {
    return $(this).text() == file.name;
  }).eq(0), "dz-preview");
  removeOneThumbnailFromDropzone(thumbnail);
  console.log("error -> ", file.name, message);
}

// изменение списка моделей машин после выбора брэнда
export function changeCarModelDatalist(event) {
  if (typeof event == "string") {
    var brand = event;
  } else {
    event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега
    var brand = $(this).val();
  }
  var carModelListHolder = $("#car_model_list"), modelsList = $myApp.carModels[brand];
  carModelListHolder.html("");
  $("#car_model").val("");
  for (let i = 0; i < modelsList.length; i++) {
    carModelListHolder.append($("<option value='" + modelsList[i] + "'></option>"));
  }
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
export function removeOneThumbnailFromDropzone(thumbnail) {
  thumbnail.animate({ width: '0px', height: "0px" }, 200, function () {
    $(this).remove();
    // если не осталось ни одной миниатюры, то надо включить dropzone
    var thumbnailsAmount = $(".dz-preview:not(.d-none)").length;
    if (!thumbnailsAmount) $("#dropzone_placement").removeClass("dz-started");
    $(".photos_amount").text(thumbnailsAmount);
  });
}

// очистка введенных данных в форме
export function clearData(event) {
  var newBrandValue = $("#car_brand option").eq(0).val();
  $("#car_brand").val(newBrandValue);
  // $("#car_brand").val("");
  $("#car_model").val("");
  changeCarModelDatalist(newBrandValue);
  $("#car_gearbox").val($("#car_gearbox option").eq(0).val());
  $("#car_engine_type").val($("#car_engine_type option").eq(0).val());
  $("#car_engine_capacity").val("");
  $("#car_engine_power").val("");
  $("#car_fuel_consumption").val("");
  $("#car_body_type").val($("#car_body_type option").eq(0).val());
  $("#car_number_doors").val("");
  $("#car_number_places").val("");
  $(".x_color_selection input").prop("checked", false);
  $("#car_clearance").val("");
  $("#car_wheelbase").val("");
  $("#car_length").val("");
  $("#car_width").val("");
  $("#car_height").val("");
  $("#car_production_year").val("");
  $("#car_mileage").val("");
  $("#was_in_accident_no").prop("checked", true);
  $("#was_in_accident_yes").prop("checked", false);
  $("#car_price").val("");
  $("#car_description").val("");
}
