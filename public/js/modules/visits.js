function init() {
  // надо во всех строках вставить местное время визитов, тоесть переконвертить UTC в местное
  $('.timestamp').each(function () {
    const utcTime = $(this).data('time');
    const date = new Date(utcTime);

    // Форматируем в нужный вид
    // Получаем компоненты времени в местном часовом поясе
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const seconds = date.getSeconds().toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // +1 потому что месяцы с 0
    const year = date.getFullYear();

    // Собираем в нужном формате
    const formattedTime = `${hours}:${minutes}:${seconds} _ ${day}-${month}-${year}`;

    $(this).text(formattedTime);
  });
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
export { init }

