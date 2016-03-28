<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

?>

<script src="plugins/forecastio/desktop/js/skycons.js"></script>

<link rel="stylesheet" type="text/css" href="plugins/forecastio/desktop/weather-icons/css/weather-icons.min.css" />

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group">

				<?php
				$first = 0;
				$eqLogics = forecastio::byType('forecastio', true);
				foreach ($eqLogics as $forecastio) {
					if ($first == 0 ) {
						echo '<button class="btn btn-success" id="' . $forecastio->getId() . '" type="button">' . $forecastio->getName() . '</button>';
						$selected = $forecastio->getId();
						$first = 1;
					} else {
						echo '<button class="btn btn-default" id="' . $forecastio->getId() . '" type="button">' . $forecastio->getName() . '</button>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<center><strong> Actuellement </strong></center></br>
			<div style="position : relative; left : 15px;">
				<span class="pull-left">
					<canvas id="icone-status" width="56" height="56"></canvas>
				</span>

				<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
					<div id="wind-status" style="width: 80px; height: 80px;"></div>
					<center><i class="wi wi-strong-wind"></i><div class="weather-status" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
				</div>
				<i class="jeedom-thermo-moyen"></i><span class="weather-status" data-l1key="temperature" style="margin-left: 5px;">   </span><span class="weather-status" data-l1key="apparentTemperature" style="margin-left: 5px;font-size: 0.8em;"> </span><br/>
				<span class="weather-status" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
			</br>
			<i class="wi wi-humidity"></i><span class="weather-status" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-status" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-status" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
			<i class="wi wi-barometer"></i><span class="weather-status" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-status" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

		</div>

	</div>
	<div class="col-md-4">
		<center><strong> Dans 1H </strong></center></br>
		<div style="position : relative; left : 15px;">
			<span class="pull-left">
				<canvas id="icone-hour" width="56" height="56"></canvas>
			</span>

			<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
				<div id="wind-hour" style="width: 80px; height: 80px;"></div>
				<center><i class="wi wi-strong-wind"></i><div class="weather-hour" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
			</div>
			<i class="jeedom-thermo-moyen"></i><span class="weather-hour" data-l1key="temperature" style="margin-left: 5px;">   </span><span class="weather-hour" data-l1key="apparentTemperature" style="margin-left: 5px;font-size: 0.8em;"> </span><br/>
			<span class="weather-hour" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
		</br>
		<i class="wi wi-humidity"></i><span class="weather-hour" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-hour" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-hour" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
		<i class="wi wi-barometer"></i><span class="weather-hour" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-hour" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

	</div>
</div>
<div class="col-md-4">
	<center><strong> Aujourd'hui </strong></center></br>
	<div style="position : relative; left : 15px;">
		<span class="pull-left">
			<canvas id="icone-day0" width="56" height="56"></canvas>
		</span>

		<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
			<div id="wind-day0" style="width: 80px; height: 80px;"></div>
			<center><i class="wi wi-strong-wind"></i><div class="weather-day0" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
		</div>
		<i class="jeedom-thermo-moyen"></i><span class="weather-day0" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day0" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
		<span class="weather-day0" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
	</br>
	<i class="wi wi-humidity"></i><span class="weather-day0" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day0" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day0" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
	<i class="wi wi-barometer"></i><span class="weather-day0" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day0" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

	<div>
		<i class="wi wi-sunrise"></i><span class="weather-day0" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day0" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
	</div>
</div>
</div>
</div>
</br>
<div class="row">
	<div class="col-md-12">
		<div id="previsions">

		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<center><strong> Jour +1 </strong></center></br>
		<div style="position : relative; left : 15px;">
			<span class="pull-left">
				<canvas id="icone-day1" width="56" height="56"></canvas>
			</span>

			<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
				<div id="wind-day1" style="width: 80px; height: 80px;"></div>
				<center><i class="wi wi-strong-wind"></i><div class="weather-day1" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
			</div>
			<i class="jeedom-thermo-moyen"></i><span class="weather-day1" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day1" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
			<span class="weather-day1" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
		</br>
		<i class="wi wi-humidity"></i><span class="weather-day1" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day1" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day1" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
		<i class="wi wi-barometer"></i><span class="weather-day1" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day1" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

		<div>
			<i class="wi wi-sunrise"></i><span class="weather-day1" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day1" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
		</div>
	</div>
</div>
<div class="col-md-4">
	<center><strong> Jour +2 </strong></center></br>
	<div style="position : relative; left : 15px;">
		<span class="pull-left">
			<canvas id="icone-day2" width="56" height="56"></canvas>
		</span>

		<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
			<div id="wind-day2" style="width: 80px; height: 80px;"></div>
			<center><i class="wi wi-strong-wind"></i><div class="weather-day2" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
		</div>
		<i class="jeedom-thermo-moyen"></i><span class="weather-day2" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day2" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
		<span class="weather-day2" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
	</br>
	<i class="wi wi-humidity"></i><span class="weather-day2" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day2" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day2" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
	<i class="wi wi-barometer"></i><span class="weather-day2" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day2" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

	<div>
		<i class="wi wi-sunrise"></i><span class="weather-day2" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day2" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
	</div>
</div>
</div>
<div class="col-md-4">
	<center><strong> Jour +3 </strong></center></br>
	<div style="position : relative; left : 15px;">
		<span class="pull-left">
			<canvas id="icone-day3" width="56" height="56"></canvas>
		</span>

		<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
			<div id="wind-day3" style="width: 80px; height: 80px;"></div>
			<center><i class="wi wi-strong-wind"></i><div class="weather-day3" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
		</div>
		<i class="jeedom-thermo-moyen"></i><span class="weather-day3" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day3" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
		<span class="weather-day3" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
	</br>
	<i class="wi wi-humidity"></i><span class="weather-day3" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day3" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day3" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
	<i class="wi wi-barometer"></i><span class="weather-day3" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day3" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

	<div>
		<i class="wi wi-sunrise"></i><span class="weather-day3" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day3" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
	</div>
</div>
</div>
</div>
</br>
<div class="row">
	<div class="col-md-4">
		<center><strong> Jour +4 </strong></center></br>
		<div style="position : relative; left : 15px;">
			<span class="pull-left">
				<canvas id="icone-day4" width="56" height="56"></canvas>
			</span>

			<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
				<div id="wind-day4" style="width: 80px; height: 80px;"></div>
				<center><i class="wi wi-strong-wind"></i><div class="weather-day4" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
			</div>
			<i class="jeedom-thermo-moyen"></i><span class="weather-day4" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day4" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
			<span class="weather-day4" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
		</br>
		<i class="wi wi-humidity"></i><span class="weather-day4" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day4" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day4" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
		<i class="wi wi-barometer"></i><span class="weather-day4" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day4" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

		<div>
			<i class="wi wi-sunrise"></i><span class="weather-day4" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day4" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
		</div>
	</div>
</div>
<div class="col-md-4">
	<center><strong> Jour +5 </strong></center></br>
	<div style="position : relative; left : 15px;">
		<span class="pull-left">
			<canvas id="icone-day5" width="56" height="56"></canvas>
		</span>

		<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
			<div id="wind-day5" style="width: 80px; height: 80px;"></div>
			<center><i class="wi wi-strong-wind"></i><div class="weather-day5" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
		</div>
		<i class="jeedom-thermo-moyen"></i><span class="weather-day5" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day5" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
		<span class="weather-day5" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
	</br>
	<i class="wi wi-humidity"></i><span class="weather-day5" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day5" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day5" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
	<i class="wi wi-barometer"></i><span class="weather-day5" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day5" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

	<div>
		<i class="wi wi-sunrise"></i><span class="weather-day5" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day5" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
	</div>
</div>
</div>
<div class="col-md-4">
	<center><strong> Jour +6 </strong></center></br>
	<div style="position : relative; left : 15px;">
		<span class="pull-left">
			<canvas id="icone-day6" width="56" height="56"></canvas>
		</span>

		<div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
			<div id="wind-day6" style="width: 80px; height: 80px;"></div>
			<center><i class="wi wi-strong-wind"></i><div class="weather-day6" data-l1key="windSpeed" style="margin-left: 5px;font-size: 0.8em;"></div></center>
		</div>
		<i class="jeedom-thermo-moyen"></i><span class="weather-day6" data-l1key="temperatureMin" style="margin-left: 5px;">   </span> / <span class="weather-day6" data-l1key="temperatureMax" style="margin-left: 5px;"> </span><br/>
		<span class="weather-day6" data-l1key="summary" style="margin-left: 5px;">   </span><br/>
	</br>
	<i class="wi wi-humidity"></i><span class="weather-day6" data-l1key="humidity" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-cloud"></i><span class="weather-day6" data-l1key="cloudCover" style="margin-left: 5px;font-size: 0.8em;">  </span><i class="wi wi-umbrella"></i><span class="weather-day6" data-l1key="precipProbability" style="margin-left: 5px;font-size: 0.8em;">  </span><br/>
	<i class="wi wi-barometer"></i><span class="weather-day6" data-l1key="pressure" style="margin-left: 5px;font-size: 0.8em;">  </span> <i class="fa fa-flask"></i> <span class="weather-day6" data-l1key="ozone" style="margin-left: 5px;font-size: 0.8em;">   </span>

	<div>
		<i class="wi wi-sunrise"></i><span class="weather-day6" data-l1key="sunriseTime" style="font-size: 0.8em;"></span><i class="wi wi-sunset"></i><span class="weather-day6" data-l1key="sunsetTime" style="font-size: 0.8em;"></span>
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

	loadingData(
		<?php
		echo $selected;
		?>);

	});

	function loadingData(eqLogic){

		$.ajax({// fonction permettant de faire de l'ajax
		type: "POST", // methode de transmission des données au fichier php
		url: "plugins/forecastio/core/ajax/forecastio.ajax.php", // url du fichier php
		data: {
			action: "loadingData",
			value: eqLogic,
		},
		dataType: 'json',
		error: function (request, status, error) {
			handleAjaxError(request, status, error);
		},
		success: function (data) { // si l'appel a bien fonctionné
		if (data.state != 'ok') {
			$('#div_alert').showAlert({message: data.result, level: 'danger'});
			return;
		}
		$('.weather-status').value('');
		for (var i in data.result.status) {
			$('.weather-status[data-l1key=' + i + ']').value(data.result.status[i]);
		}
		$('.weather-hour').value('');
		for (var i in data.result.hour) {
			$('.weather-hour[data-l1key=' + i + ']').value(data.result.hour[i]);
		}
		$('.weather-day0').value('');
		for (var i in data.result.day0) {
			$('.weather-day0[data-l1key=' + i + ']').value(data.result.day0[i]);
		}
		$('.weather-day1').value('');
		for (var i in data.result.day1) {
			$('.weather-day1[data-l1key=' + i + ']').value(data.result.day1[i]);
		}
		$('.weather-day2').value('');
		for (var i in data.result.day2) {
			$('.weather-day2[data-l1key=' + i + ']').value(data.result.day2[i]);
		}
		$('.weather-day3').value('');
		for (var i in data.result.day3) {
			$('.weather-day3[data-l1key=' + i + ']').value(data.result.day3[i]);
		}
		$('.weather-day4').value('');
		for (var i in data.result.day4) {
			$('.weather-day4[data-l1key=' + i + ']').value(data.result.day4[i]);
		}
		$('.weather-day5').value('');
		for (var i in data.result.day5) {
			$('.weather-day5[data-l1key=' + i + ']').value(data.result.day5[i]);
		}
		$('.weather-day6').value('');
		for (var i in data.result.day6) {
			$('.weather-day6[data-l1key=' + i + ']').value(data.result.day6[i]);
		}

		var skycons = new Skycons({'color':'black'});
		skycons.set('icone-status', data.result.status.icon);
		skycons.set('icone-hour', data.result.hour.icon);
		skycons.set('icone-day0', data.result.day0.icon);
		skycons.set('icone-day1', data.result.day1.icon);
		skycons.set('icone-day2', data.result.day2.icon);
		skycons.set('icone-day3', data.result.day3.icon);
		skycons.set('icone-day4', data.result.day4.icon);
		skycons.set('icone-day5', data.result.day5.icon);
		skycons.set('icone-day6', data.result.day6.icon);
		skycons.play();

		roseTrace('wind-status',data.result.status.windBearing);
		roseTrace('wind-hour',data.result.hour.windBearing);
		roseTrace('wind-day0',data.result.day0.windBearing);
		roseTrace('wind-day1',data.result.day1.windBearing);
		roseTrace('wind-day2',data.result.day2.windBearing);
		roseTrace('wind-day3',data.result.day3.windBearing);
		roseTrace('wind-day4',data.result.day4.windBearing);
		roseTrace('wind-day5',data.result.day5.windBearing);
		roseTrace('wind-day6',data.result.day6.windBearing);

		//console.log(data.result.temp.value);

		var options = {
			title : {	text : 'Prévisions'	},
			chart: { renderTo: 'previsions' },
			xAxis: [{ // Bottom X axis
            type: 'datetime',
            tickInterval: 2 * 36e5, // two hours
            minorTickInterval: 36e5, // one hour
            tickLength: 0,
            gridLineWidth: 1,
            gridLineColor: (Highcharts.theme && Highcharts.theme.background2) || '#F0F0F0',
            startOnTick: false,
            endOnTick: false,
            minPadding: 0,
            maxPadding: 0,
            offset: 30,
            showLastLabel: true,
            labels: {
                format: '{value:%H}'
            }
        }, { // Top X axis
            linkedTo: 0,
            type: 'datetime',
            tickInterval: 24 * 3600 * 1000,
            labels: {
                format: '{value:<span style="font-size: 12px; font-weight: bold">%a</span> %b %e}',
                align: 'left',
                x: 3,
                y: -5
            },
            opposite: true,
            tickLength: 20,
            gridLineWidth: 1
        }],

				yAxis: [{ // temperature axis
	            title: {
	                text: null
	            },
	            labels: {
	                format: '{value}°',
	                style: {
	                    fontSize: '10px'
	                },
	                x: -3
	            },
	            plotLines: [{ // zero plane
	                value: 0,
	                color: '#BBBBBB',
	                width: 1,
	                zIndex: 2
	            }],
	            // Custom positioner to provide even temperature ticks from top down
	            tickPositioner: function () {
	                var max = Math.ceil(this.max) + 1,
	                    pos = max - 12, // start
	                    ret;

	                if (pos < this.min) {
	                    ret = [];
	                    while (pos <= max) {
	                        ret.push(pos += 1);
	                    }
	                } // else return undefined and go auto

	                return ret;

	            },
	            maxPadding: 0.3,
	            tickInterval: 1,
	            gridLineColor: (Highcharts.theme && Highcharts.theme.background2) || '#F0F0F0'

	        }, { // precipitation axis
	            title: {
	                text: null
	            },
	            labels: {
	                enabled: false
	            },
	            gridLineWidth: 0,
	            tickLength: 0

	        }, { // Air pressure
	            allowDecimals: false,
	            title: { // Title on top of axis
	                text: 'hPa',
	                offset: 0,
	                align: 'high',
	                rotation: 0,
	                style: {
	                    fontSize: '10px',
	                    color: Highcharts.getOptions().colors[2]
	                },
	                textAlign: 'left',
	                x: 3
	            },
	            labels: {
	                style: {
	                    fontSize: '8px',
	                    color: Highcharts.getOptions().colors[2]
	                },
	                y: 2,
	                x: 3
	            },
	            gridLineWidth: 0,
	            opposite: true,
	            showLastLabel: false
	        }],

	        legend: {
	            enabled: false
	        },

			series: [
				],
		};
		var valTemp = {
			name: 'Température',
			dashStyle: 'spline',
			tooltip: {
				valueSuffix: ' °C'
			},
			color: '#FF3333',
			negativeColor: '#48AFE8',
			data: []
		};
		var valRain = {
			name: 'Précipitations',
			type: 'column',
      color: '#68CFE8',
			yAxis: 1,
			tooltip: {
				valueSuffix: ' mn'
			},
			data: []
		};
		var valPress = {
			name: 'Pression',
			dashStyle: 'shortdot',
      yAxis: 2,
			tooltip: {
				valueSuffix: ' hPa'
			},
			data: []
		};

		for (var i in data.result.previsions.time) {
			//console.log(data.result.previsions.temperature[i]);
			valTemp.data.push(data.result.previsions.time[i], parseFloat(data.result.previsions.temperature[i],2));
			valRain.data.push(data.result.previsions.time[i], parseFloat(data.result.previsions.precipIntensity[i],2));
			valPress.data.push(data.result.previsions.time[i], parseInt(data.result.previsions.pressure[i]));
		};

		options.series.push(valTemp);
		options.series.push(valRain);
		options.series.push(valPress);

		var chart = new Highcharts.Chart(options);

	}
});
}

function roseTrace(id,value){
	new Highcharts.Chart({
		chart: {
			renderTo: id,
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
				data: [value]
			}]
		});

	}



	</script>
