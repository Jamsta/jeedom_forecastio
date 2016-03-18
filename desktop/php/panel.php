<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
       <span class="statusCmd" style="position : absolute;left : 5px; width : 30px;z-index: 1030;"></span>
       <i class='fa fa-refresh pull-right cursor refresh' style="margin-top: 3px;margin-right: 3px;"></i>
       <span class="cmd cmd-widget" data-cmd_id="#refresh_id#" style="display:none;"></span>
       <center class="widget-name"><strong><a href="#eqLink#" style="font-size : 1.1em;"> #city# </a></strong></center>
       <div style="position : relative; left : 15px;" class="tooltips" title="#collectDate#">
          <span class="pull-left">
              <canvas id="forecastioS" width="56" height="56"></canvas>
          </span>
          <div class="pull-right" style="margin-right: 20px;margin-top: 0px;">
              <div id="windDirection" style="width: 80px; height: 80px;" class="cmd noRefresh" data-type="info" data-subtype="numeric" data-cmd_id="#windid#"></div>
              <div class="cmd noRefresh" data-type="info" data-subtype="string" data-cmd_id="#sunid#">
                  <center style="position: relative;left:-2px;"><i class="fa fa-sun-o"></i></center>
                  <span style="font-size: 0.8em;position: relative;left:10px;">#sunrise# | #sunset#</span>
              </div>
          </div>
          <span style="margin-left: 5px;"class="cmd noRefresh" data-type="info" data-subtype="string" data-cmd_id="#conditionid#">  #condition# </span><br/>
          <span style="margin-left: 5px;font-size: 0.8em;" class="cmd noRefresh" data-type="info" data-subtype="string" data-cmd_id="#tempid#">  #temperature# °C / #humidity# % </span><br/>
          <span style="margin-left: 5px;font-size: 0.8em;" class="cmd noRefresh" data-type="info" data-subtype="string" data-cmd_id="#pressureid#">  #windspeed# km/h | #pressure# mb</span>
      </div><br/>

      <script src="plugins/forecastio/desktop/js/skycons.js"></script>

      <script>
        var skycons = new Skycons({'color':'white'});

        skycons.set('forecastioS', '#icone#');
        skycons.set('forecastio1', '#icone1#');
        skycons.set('forecastio2', '#icone2#');
        skycons.set('forecastio3', '#icone3#');
        skycons.set('forecastio4', '#icone4#');
        skycons.set('forecastio5', '#icone5#');

        skycons.play();
      </script>
      <script>


       if($('#windDirection').html() != undefined){
          new Highcharts.Chart({
              chart: {
                  renderTo: 'windDirection',
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
                      color: '#FFFFFF',
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
                          tickColor: '#FFFFFF',
                          tickInterval: 90,
                          lineColor: '#FFFFFF',
                          lineWidth: 4,
                          labels: {
                              formatter: function () {
                                  if (this.value == 360) {
                                      return '<span style="color : #FFFFFF;font-weight:bold;">N</span>';
                                  } else if (this.value == 90) {
                                      return '<span style="color : #FFFFFF;font-weight:bold;">E</span>';
                                  } else if (this.value == 180) {
                                      return '<span style="color : #FFFFFF;font-weight:bold;">S</span>';
                                  } else if (this.value == 270) {
                                      return '<span style="color : #FFFFFF;font-weight:bold;">W</span>';
                                  }
                              }
                          },
                          title: {
                              text: null
                          }},
                          series: [{
                              name: 'Vent',
                              data: [#wind_direction#]
                          }]
                      });
      }
      </script>


		</div>
		<div class="col-md-4">
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tabbable" id="tabs-58103">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-320857" data-toggle="tab">Section 1</a>
					</li>
					<li>
						<a href="#panel-379392" data-toggle="tab">Section 2</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel-320857">
						<p>
							I'm in Section 1.
						</p>
					</div>
					<div class="tab-pane" id="panel-379392">
						<p>
							Howdy, I'm in Section 2.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h2>
				J+2
			</h2>
			<p>
				J+2 text
			</p>

			 <span class="label label-default">Pluie</span>
			<div class="progress">
				<div class="progress-bar progress-success">
				</div>
			</div>
			<ul class="nav nav-pills">
				<li class="active">
					 <a href="#"> <span class="badge pull-right">42</span> Home</a>
				</li>
				<li>
					 <a href="#"> <span class="badge pull-right">16</span> More</a>
				</li>
			</ul>
		</div>
		<div class="col-md-4">
			<h2>
				J+3
			</h2>
			<p>
				text 3<br />
			</p>

		</div>
		<div class="col-md-4">
			<h2>
				J+4
			</h2>
			<p>
				text 4
			</p>
		</div>
	</div>
</div>
