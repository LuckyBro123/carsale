<?php
$badgeColors = ["text-bg-primary", "text-bg-danger", "text-bg-success", "text-bg-secondary", "text-bg-warning", "text-bg-info", "text-bg-dark", "text-bg-orange", "text-bg-emerald", "text-bg-pink", "text-bg-green", "text-bg-brown", "text-bg-yellow", "text-bg-lightblue", "text-bg-lightpink", "text-bg-bluegreen"]
?>
<script src="{{asset('/plugins/chart.umd.446min.js')}}" type="text/javascript"></script><!-- ▪▪▪▪▪▪▪▪▪▪ блок СРЕДНИХ величин ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
<div class="col-12 col-sm-6 col-lg-3 col-xl-3 mt-0 mb-2 stat_table_container">
	<div class="card">
		<div class="card-body p-0">
			<table class="table table_bordered ">
				<tbody>
					<tr>
						<td>{{ucfirst(__("cars_count"))}}</td>
						<td class="text-center">
							<span>{{$statistics["cars_count"]}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ucfirst(__("brands_count"))}}</td>
						<td>
							<span>{{count($statistics["brands_count"])}}</span>
						</td>
					</tr>
					<tr>
						<td>{{ucfirst(__("models_count"))}}</td>
						<td>
							<span>{{$statistics["models_count"]}}</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">{{__("AVERAGE VALUES")}}</h3>
		</div>
		<div class="card-body p-0">
			<table class="table table-striped">
				<tbody>
					@foreach($statistics["averages"] as $title => $value)
						<tr>
							<td>{{ucfirst(__($title))}}</td>
							<td>
								<span>{{__($value)}}</span>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>  <!-- ▪▪▪▪▪▪▪▪▪▪ блок НАИБОЛЕЕ ЧАСТО ВСТРЕЧАЮЩИХСЯ величин ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪ -->
<div class="col-12 col-sm-6 col-lg-3 col-xl-3 mt-0 mb-2 stat_table_container">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title text-center">{{__("MOST COMMON VALUES")}}</h3>
		</div>
		<div class="card-body p-0">
			<table class="table table-striped">
				<tbody>
					@foreach($statistics["most_common_values"] as $title => $value)
						<tr>
							<td>{{ucfirst(__($title))}}</td>
							<td>
								<span>{{__($value)}}</span>
							</td>
						</tr>
					@endforeach
					@if($statistics["body_types_count"] < 3)
						<tr>
							<td>{{ucfirst(__("body_types_count"))}}</td>
							<td>
								<span>{{$statistics["body_types_count"]}}</span>
							</td>
						</tr>
					@endif
					@if(count($statistics["engine_capacities_counts"]) < 3)
						<tr>
							<td>{{ucfirst(__("engine_capacities_counts"))}}</td>
							<td>
								<span>{{count($statistics["engine_capacities_counts"])}}</span>
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div><!-- ♦♦♦♦♦♦♦♦♦♦♦♦♦♦ график БРЕНДЫ количество КРУГ ДОЛИ ♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦ -->
@if(count($statistics["brands_count"]) > 2)
	<script>
    var htmlElem = document.getElementById('brands_chart');

    var chart = new Chart(htmlElem, {
      type   : 'pie',
      data   : {
        labels  : {!! json_encode(array_keys($statistics["brands_count"])) !!},
        datasets: [{
          // label      : '# of Brands',
          data       : {!! json_encode(array_values($statistics["brands_count"])) !!},
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
          htmlLegend: {
            containerID: 'brands_chart_legend_container',
          },
          legend: {
            display: false,
          }
          /*legend: {
            display: isDesktopViewport(),
          },*/
        }
      }
    });
	</script>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-0 mb-2 chartjs_container">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">{{__("BRANDS")}}</h3>
			</div>
			<div class="card-body p-0">
				<div id="brands_chart_legend_container"></div>
				<canvas id="brands_chart"></canvas>
			</div>
		</div>
	</div>
@endif

<!-- ♦♦♦♦♦♦♦♦♦♦♦♦♦♦ график ТИПЫ КУЗОВА количество БУБЛИК ♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦♦ -->
@if(count($statistics["body_types_count"]) > 2)
	<script>
    var htmlElem = document.getElementById('body_types_chart');

    new Chart(htmlElem, {
      type   : 'doughnut',
      data   : {
        labels  : {!! json_encode(array_keys($statistics["body_types_count"])) !!},
        datasets: [{
          // label      : '# of Brands',
          data       : {!! json_encode(array_values($statistics["body_types_count"])) !!},
          borderWidth: 1
        }]
      },
      options: {        plugins: {
          legend: {
            display: isDesktopViewport(),
          },
        }
      }
    });
	</script>
	<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-0 mb-2 chartjs_container">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">{{__("BODY TYPES")}}</h3>
			</div>
			<div class="card-body p-0">
				<canvas id="body_types_chart"></canvas>
			</div>
		</div>
	</div>
@endif
<!-- ♦♦♦♦♦♦♦♦♦♦♦♦♦♦ график ОБЪЁМЫ ДВИГАТЕЛЯ количество СТОЛБИКИ ♦♦♦♦♦♦♦♦♦♦♦♦♦ -->
@if(count($statistics["engine_capacities_counts"]) > 2)
	<script>
    var htmlElem = document.getElementById('engine_capacities_chart');

    new Chart(htmlElem, {
      type   : 'bar',
      data   : {
        labels  : {!! json_encode(array_keys($statistics["engine_capacities_counts"])) !!},
        datasets: [{
          label          : '# of engines',
          data           : {!! json_encode(array_values($statistics["engine_capacities_counts"])) !!},
          backgroundColor: [
            'rgba(255, 99, 132, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 205, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(201, 203, 207, 0.5)'
          ],
          borderWidth    : 1
        }]
      },
      options: {
        plugins: {
          legend: {
            display: false  // Это скроет легенду полностью
          }
        },
        scales : {
          y: {
            beginAtZero: true
          }
        }
      }
    });
	</script>
	<div class="col-12 col-lg-8 mt-0 mb-2 chartjs_container">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">{{__("ENGINE CAPACITIES")}}</h3>
			</div>
			<div class="card-body p-0">
				<canvas id="engine_capacities_chart"></canvas>
			</div>
		</div>
	</div>
@endif
