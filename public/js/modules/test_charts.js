function init() {
  // Load the Visualization API and the corechart package.
  google.charts.load('current', { 'packages': ['corechart'] });
  // Set a callback to run when the Google Visualization API is loaded.
  google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows($myApp.chartsdata.Chevrolet
      /*[
       ['Mushrooms', 3],
       ['Onions', 1],
       ['Olives', 1],
       ['Zucchini', 1],
       ['Pepperoni', 2]
       ]*/
  );

    // Set chart options
    var options = {
      title : 'Brands',
      width : 560,
      height: 800,
      chartArea: {
        left: '5%',
        right: '0%',
        top: '10%',
        bottom: '10%',
        width: '90%',
        height: '80%'
      },
      // Настройка легенды
      legend: {
        position: 'right',
        width: 100,
        maxLines: 3
      },
      // Настройка осей
      hAxis: {
        textPosition: 'in'
      },
      vAxis: {
        textPosition: 'in'
      }
    };
    switch (get_random_int(1, 3)) {
      case 2 :
        options.pieHole = 0.4;
        break;
      case 3 :
        options.is3D = true;
        break;
    }
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }

}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪


export { init }

