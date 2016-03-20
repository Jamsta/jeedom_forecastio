<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group">

				<button class="btn btn-default" type="button">
					EqLogic
				</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<center><strong> Actuellement </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
		<div class="col-md-4">
			<center><strong> Dans 1H </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
		<div class="col-md-4">
			<center><strong> Demain </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tabbable" id="tabs-58103">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-temp" data-toggle="tab">Température</a>
					</li>
					<li>
						<a href="#panel-humidite" data-toggle="tab">Précipitation</a>
					</li>
					<li>
						<a href="#panel-vent" data-toggle="tab">Vent</a>
					</li>
					<li>
						<a href="#panel-pression" data-toggle="tab">Pression</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel-temp">
					</div>
					<div class="tab-pane" id="panel-humidite">
					</div>
					<div class="tab-vent" id="panel-temp">
					</div>
					<div class="tab-pression" id="panel-humidite">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<center><strong> Jour +1 </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
		<div class="col-md-4">
			<center><strong> Jour +2 </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
		<div class="col-md-4">
			<center><strong> Jour +3 </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<center><strong> Jour +4 </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
		<div class="col-md-4">
			<center><strong> Jour +5 </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
		<div class="col-md-4">
			<center><strong> Jour +6 </strong></center></br>
			<div style="position : relative; left : 15px;">
		     <span class="pull-left">
		         <canvas id="icone-day-0" width="56" height="56"></canvas>
		     </span>

		     <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
		         <div id="windir-day-0" style="width: 80px; height: 80px;"></div>
						 <center><div id="windspeed-day-0">10 km/h</div></center>
		     </div>
				 <span id="temperature-day-0" style="margin-left: 5px;">  15°C (ressenti 10°C) </span><br/>
		     <span id="condition-day-0" style="margin-left: 5px;">  Clair toute la journée </span><br/>
		     <span id="humidite-day-0" style="margin-left: 5px;font-size: 0.8em;">  Humidité : 50% </span><br/>
		     <span id="pression-day-0" style="margin-left: 5px;font-size: 0.8em;">  Pression : 1000mb</span>
				 <div>
						 <i class="fa fa-sun-o"></i>
						 <span id="sun-day-0" style="font-size: 0.8em;">6:00 | 19:00</span>
				 </div>
		 </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
		</div>
	</div>
</div>

<script>

	$(function () {

$.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {
	// Create the chart
	$('#panel-temp').highcharts('StockChart', {

			title : {
					text : 'Température'
			},

			series : [{
					name : 'Température',
					data : data,
					tooltip: {
							valueDecimals: 2
					}
			}]
	});
});

});

if($('#windir-day-0').html() != undefined){
	 new Highcharts.Chart({
			 chart: {
					 renderTo: 'windir-day-0',
					 type: 'gauge',
					 backgroundColor: 'transparent',
					 plotBackgroundColor: null,
					 plotBackgroundImage: null,
					 plotBorderWidth: 0,
					 plotShadow: false,
					 spacingTop: 0,
					 spacingLeft: 0,
					 spacingRight: 0,
					 spacingBottom: 0
			 },
			 title: {
					 text: null
			 },
			 credits: {
					 enabled: false
			 },
			 pane: {
					 startAngle: 0,
					 endAngle: 360,
			 },
			 exporting : {
					 enabled: false
			 },
			 plotOptions: {
					 series: {
							 dataLabels: {
									 enabled: false
							 },
							 color: '#000000',
					 },
					 gauge: {
							 dial: {
									 radius: '90%',
									 backgroundColor: 'silver',
									 borderColor: 'silver',
									 borderWidth: 1,
									 baseWidth: 6,
									 topWidth: 1,
													 baseLength: '75%', // of radius
													 rearLength: '15%'
											 },
											 pivot: {
													 backgroundColor: 'white',
													 radius: 0,
											 }
									 }
							 },
							 pane: {background: [{backgroundColor: 'transparent'}]},
							 yAxis: {
									 min: 0,
									 max: 360,
									 tickWidth: 2,
									 tickLength: 10,
									 tickColor: '#000000',
									 tickInterval: 90,
									 lineColor: '#000000',
									 lineWidth: 4,
									 labels: {
											 formatter: function () {
													 if (this.value == 360) {
															 return '<span style="color : #000000;font-weight:bold;">N</span>';
													 } else if (this.value == 90) {
															 return '<span style="color : #000000;font-weight:bold;">E</span>';
													 } else if (this.value == 180) {
															 return '<span style="color : #000000;font-weight:bold;">S</span>';
													 } else if (this.value == 270) {
															 return '<span style="color : #000000;font-weight:bold;">W</span>';
													 }
											 }
									 },
									 title: {
											 text: null
									 }},
									 series: [{
											 name: 'Vent',
											 data: [120]
									 }]
							 });
}
</script>

<script>
  var skycons = new Skycons({'color':'white'});

  skycons.set('icone-day-0', 'clear');

  skycons.play();
</script>
