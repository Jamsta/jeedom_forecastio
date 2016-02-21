<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class forecastio extends eqLogic {

  public static function cron5($_eqLogic_id = null) {
		if ($_eqLogic_id == null) {
			$eqLogics = self::byType('forecastio', true);
		} else {
			$eqLogics = array(self::byId($_eqLogic_id));
		}
    foreach ($eqLogics as $forecastio) {
        if (null !== ($forecastio->getConfiguration('geoloc', ''))) {
          log::add('forecastio', 'debug', 'pull cron');
          $forecastio->getInformations();
          $mc = cache::byKey('forecastioWidgetdashboard' . $forecastio->getId());
          $mc->remove();
          $forecastio->toHtml('dashboard');
          $mc = cache::byKey('forecastioWidgetmobile' . $forecastio->getId());
          $mc->remove();
          $forecastio->toHtml('mobile');
          $forecastio->refreshWidget();
        } else {
          log::add('forecastio', 'error', 'geoloc non saisie');
        }
    }
  }

  public function preUpdate() {
    if ($this->getConfiguration('geoloc') == '') {
      throw new Exception(__('La géolocalisation ne peut etre vide',__FILE__));
    }
    if ($this->getConfiguration('apikey') == '') {
      throw new Exception(__('La clef API ne peut etre vide',__FILE__));
    }
  }

public function postUpdate() {
  foreach (eqLogic::byType('forecastio') as $forecastio) {
    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Condition', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('summary');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Icone', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('icon');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensity');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Intensité de Précipitation', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('precipIntensity');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbability');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Probabilité de Précipitation', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('precipProbability');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipType');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Type de Précipitation', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('precipType');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperature');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperature');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperature');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Apparente', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('apparentTemperature');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPoint');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Point de Rosée', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('dewPoint');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidity');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Humidité', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('humidity');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeed');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Vitesse du Vent', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('windSpeed');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Direction du Vent', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('windBearing');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCover');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Couverture Nuageuse', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('cloudCover');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressure');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Pression', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('pressure');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozone');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Ozone', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('ozone');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'sunriseTime');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Lever du Soleil', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('sunriseTime');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'sunsetTime');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Coucher du Soleil', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('sunsetTime');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureMin');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum Apparente', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('apparentTemperatureMin');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureMax');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum Apparente', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('apparentTemperatureMax');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_1');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum Jour', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMin_1');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_1');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum Jour', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMax_1');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_1');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Condition Jour', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('summary_1');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_1');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Icone Jour', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('icon_1');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_2');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum +1', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMin_2');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_2');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum +1', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMax_2');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_2');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Condition Jour +1', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('summary_2');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_2');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Icone Jour +1', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('icon_2');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_3');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum +2', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMin_3');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_3');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum +2', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMax_3');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_3');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Condition Jour +2', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('summary_3');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_3');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Icone Jour +2', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('icon_3');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_4');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum +3', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMin_4');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_4');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum +3', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMax_4');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_4');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Condition Jour +3', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('summary_4');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_4');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Icone Jour +3', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('icon_4');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_5');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum +4', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMin_5');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_5');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum +4', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMax_5');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_5');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Condition Jour +4', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('summary_5');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_5');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Icone Jour +4', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('icon_5');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('string');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'refresh');
		if (!is_object($forecastioCmd)) {
			$forecastioCmd = new forecastioCmd();
			$forecastioCmd->setName(__('Rafraichir', __FILE__));
		}
		$forecastioCmd->setEqLogic_id($this->getId());
		$forecastioCmd->setLogicalId('refresh');
		$forecastioCmd->setType('action');
		$forecastioCmd->setSubType('other');
		$forecastioCmd->save();

    forecastio::getInformations();
  }
}


public function getInformations() {
  $geoloc = $this->getConfiguration('geoloc', '');
  $geolocCmd = geolocCmd::byId($geoloc);
  $geolocval = $geolocCmd->execCmd(null, 0);
  $apikey = $this->getConfiguration('apikey', '');
  $url = 'https://api.forecast.io/forecast/' . $apikey .'/' . $geolocval . '?units=ca&lang=fr';
  log::add('forecastio', 'debug', $url);
  $json_string = file_get_contents($url);
  $parsed_json = json_decode($json_string, true);
  //log::add('forecastio', 'debug', print_r($json_string, true));
  //log::add('forecastio', 'debug', print_r($parsed_json, true));
  //log::add('forecastio', 'debug', print_r($parsed_json['currently'], true));
  foreach ($parsed_json['daily']['data'][0] as $key => $value) {
    if ($key == 'apparentTemperatureMax' || $key == 'apparentTemperatureMin' || $key == 'temperatureMax' || $key == 'temperatureMin' || $key == 'sunsetTime' || $key == 'sunriseTime') {
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
      //log::add('forecastio', 'debug', $key . ' ' . $value);
      if (is_object($forecastioCmd)) {
        if ($key == 'sunriseTime' || $key == 'sunsetTime') {
          $value = date('Hi',$value);
        }
        $forecastioCmd->setConfiguration('value',$value);
        $forecastioCmd->save();
        $forecastioCmd->event($value);
      }
    }
  }
  $i = 0;
  while ($i < 5) {
    $j = $i +1;
    foreach ($parsed_json['daily']['data'][$i] as $key => $value) {
      if ($key == 'temperatureMax' || $key == 'temperatureMin' || $key == 'summary' || $key == 'icon') {
        $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key . '_' . $j);
        if (is_object($forecastioCmd)) {
          $forecastioCmd->setConfiguration('value',$value);
          $forecastioCmd->save();
          $forecastioCmd->event($value);
        }
      }
    }
    $i++;
  }

  foreach ($parsed_json['currently'] as $key => $value) {
    //log::add('forecastio', 'debug', $key . ' ' . $value);
    if ($key != 'time') {
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
      if (is_object($forecastioCmd)) {
        if ($key == 'windBearing') {
          if ($value > 179) {
            $value = $value -180;
          } else {
            $value = $value + 180;
          }
        }
        if ($key == 'humidity') {
          $value = $value * 100;
        }
        $forecastioCmd->setConfiguration('value',$value);
        $forecastioCmd->save();
        $forecastioCmd->event($value);
      }
    }
  }

  return ;
}

public function getGeoloc($_infos = '') {
  $return = array();
  foreach (eqLogic::byType('geoloc') as $geoloc) {
    foreach (geolocCmd::byEqLogicId($geoloc->getId()) as $geoinfo) {
      if ($geoinfo->getConfiguration('mode') == 'fixe' || $geoinfo->getConfiguration('mode') == 'dynamic') {
        $return[$geoinfo->getId()] = array(
          'value' => $geoinfo->getName(),
        );
      }
    }
  }
  return $return;
}

public function toHtml($_version = 'dashboard') {
  if ($this->getIsEnable() != 1) {
    return '';
  }
  if (!$this->hasRight('r')) {
    return '';
  }
  $_version = jeedom::versionAlias($_version);
  if ($this->getDisplay('hideOn' . $_version) == 1) {
    return '';
  }
  $mc = cache::byKey('forecastioWidget' . $_version . $this->getId());
  if ($mc->getValue() != '') {
    return preg_replace("/" . preg_quote(self::UIDDELIMITER) . "(.*?)" . preg_quote(self::UIDDELIMITER) . "/", self::UIDDELIMITER . mt_rand() . self::UIDDELIMITER, $mc->getValue());
  }
  $html_forecast = '';

  if ($_version != 'mobile' || $this->getConfiguration('fullMobileDisplay', 0) == 1) {
    $forcast_template = getTemplate('core', $_version, 'forecast', 'forecastio');
    for ($i = 0; $i < 5; $i++) {
      $replace = array();
      $replace['#day#'] = date_fr(date('l', strtotime('+' . $i . ' days')));

      $j = $i + 1;
      $temperature_min = $this->getCmd(null, 'temperatureMin_' . $j);
      $replace['#low_temperature#'] = is_object($temperature_min) ? round($temperature_min->execCmd()) : '';

      $temperature_max = $this->getCmd(null, 'temperatureMax_' . $j);
      $replace['#hight_temperature#'] = is_object($temperature_max) ? round($temperature_max->execCmd()) : '';
      $replace['#tempid#'] = is_object($temperature_max) ? $temperature_max->getId() : '';

      $icone = $this->getCmd(null, 'icon_' . $j);
      $replace['#icone#'] = is_object($icone) ? $icone->execCmd() : '';

      $html_forecast .= template_replace($replace, $forcast_template);
    }
  }
  $replace = array(
    '#id#' => $this->getId(),
    '#city#' => $this->getName(),
    '#collectDate#' => '',
    '#background_color#' => $this->getBackgroundColor($_version),
    '#eqLink#' => ($this->hasRight('w')) ? $this->getLinkToConfiguration() : '#',
    '#forecast#' => $html_forecast,
    '#uid#' => 'forecastio' . $this->getId() . self::UIDDELIMITER . mt_rand() . self::UIDDELIMITER,
  );
  $temperature = $this->getCmd(null, 'temperature');
  $replace['#temperature#'] = is_object($temperature) ? round($temperature->execCmd()) : '';
  $replace['#tempid#'] = is_object($temperature) ? $temperature->getId() : '';

  $humidity = $this->getCmd(null, 'humidity');
  $replace['#humidity#'] = is_object($humidity) ? $humidity->execCmd() : '';

  $pressure = $this->getCmd(null, 'pressure');
  $replace['#pressure#'] = is_object($pressure) ? $pressure->execCmd() : '';
  $replace['#pressureid#'] = is_object($pressure) ? $pressure->getId() : '';

  $wind_speed = $this->getCmd(null, 'windSpeed');
  $replace['#windspeed#'] = is_object($wind_speed) ? $wind_speed->execCmd() : '';
  $replace['#windid#'] = is_object($wind_speed) ? $wind_speed->getId() : '';

  $sunrise = $this->getCmd(null, 'sunriseTime');
  $replace['#sunrise#'] = is_object($sunrise) ? substr_replace($sunrise->execCmd(),':',-2,0) : '';
  $replace['#sunriseid#'] = is_object($sunrise) ? $sunrise->getId() : '';

  $sunset = $this->getCmd(null, 'sunsetTime');
  $replace['#sunset#'] = is_object($sunset) ? substr_replace($sunset->execCmd(),':',-2,0) : '';
  $replace['#sunsetid#'] = is_object($sunset) ? $sunset->getId() : '';

  $wind_direction = $this->getCmd(null, 'windBearing');
  $replace['#wind_direction#'] = is_object($wind_direction) ? $wind_direction->execCmd() : 0;

  $refresh = $this->getCmd(null, 'refresh');
  $replace['#refresh_id#'] = is_object($refresh) ? $refresh->getId() : '';

  $condition = $this->getCmd(null, 'summary');
  $icone = $this->getCmd(null, 'icon');
  if (is_object($condition)) {
    $replace['#icone#'] = $icone->execCmd();
    $replace['#condition#'] = $condition->execCmd();
    $replace['#conditionid#'] = $condition->getId();
    $replace['#collectDate#'] = $condition->getCollectDate();
  } else {
    $replace['#icone#'] = '';
    $replace['#condition#'] = '';
    $replace['#collectDate#'] = '';
  }

  $parameters = $this->getDisplay('parameters');
  if (is_array($parameters)) {
    foreach ($parameters as $key => $value) {
      $replace['#' . $key . '#'] = $value;
    }
  }

  $html = template_replace($replace, getTemplate('core', $_version, 'current', 'forecastio'));
  cache::set('forecastioWidget' . $_version . $this->getId(), $html, 0);
  return $html;
}

}

class forecastioCmd extends cmd {

  public function execute($_options = null) {
    if ($this->getLogicalId() == 'refresh') {
			weather::cron30($this->getEqLogic_id());
		} else {
      return $this->getConfiguration('value');
    }
  }

}

?>
