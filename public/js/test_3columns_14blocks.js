$(function () {
  init();

});

function init() {
  $('.r1').sortable({
    animation: 250,
    group: 'shared',
    draggable: ".block",
  });
  $('.r2').sortable({
    animation: 250,
    group: 'shared',
    draggable: ".block",
  });
  $('.r3').sortable({
    animation: 250,
    group: 'shared',
    draggable: ".block",
  });

  // $(document).on("click", ".btn_clear_data", send_dataClickHandler);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function changeIsInvalidHandler() {
  $(this).removeClass("is-invalid");
}

function send_dataClickHandler(event) {
  // event.stopPropagation(); // остановка всех текущих JS событий
  event.preventDefault();  // остановка дефолтного события для текущего элемента - отправка формы по submit

}

