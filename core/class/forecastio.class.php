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

  public static function cron5() {
    foreach (eqLogic::byType('forecastio', true) as $forecastio) {
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
      $forecastioCmd->setName(__('Force du Vent', __FILE__));
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

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Minimum', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMin');
      $forecastioCmd->setType('info');
      $forecastioCmd->setSubType('numeric');
      $forecastioCmd->save();
    }

    $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax');
    if (!is_object($forecastioCmd)) {
      $forecastioCmd = new forecastioCmd();
      $forecastioCmd->setName(__('Température Maximum', __FILE__));
      $forecastioCmd->setEqLogic_id($this->id);
      $forecastioCmd->setLogicalId('temperatureMax');
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

    forecastio::getInformations();
  }
}


public function getInformations() {
  $geoloc = $this->getConfiguration('geoloc', '');
  $geolocCmd = geolocCmd::byId($geoloc);
  $geolocval = $geolocCmd->execCmd(null, 0);
  $apikey = $this->getConfiguration('apikey', '');
  $url = 'https://api.forecast.io/forecast/' . $apikey .'/' . $geolocval . '?units=ca';
  log::add('forecastio', 'debug', $url);
  $json_string = file_get_contents($url);
  $parsed_json = json_decode($json_string, true);
  //log::add('forecastio', 'debug', print_r($json_string, true));
  //log::add('forecastio', 'debug', print_r($parsed_json, true));
  //log::add('forecastio', 'debug', print_r($parsed_json['currently'], true));
  foreach ($parsed_json['daily']['data'][0] as $key => $value) {
    //log::add('forecastio', 'debug', $key . ' ' . $value);
    if ($key != 'time') {
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
      if (is_object($forecastioCmd)) {
        $forecastioCmd->setConfiguration('value',$value);
        $forecastioCmd->save();
        $forecastioCmd->event($value);
      }
    }
  }
  foreach ($parsed_json['currently'] as $key => $value) {
    //log::add('forecastio', 'debug', $key . ' ' . $value);
    if ($key != 'time') {
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
      if (is_object($forecastioCmd)) {
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
  $mc = cache::byKey('weatherWidget' . $_version . $this->getId());
  if ($mc->getValue() != '') {
    return preg_replace("/" . preg_quote(self::UIDDELIMITER) . "(.*?)" . preg_quote(self::UIDDELIMITER) . "/", self::UIDDELIMITER . mt_rand() . self::UIDDELIMITER, $mc->getValue());
  }
  $html_forecast = '';

  if ($_version != 'mobile' || $this->getConfiguration('fullMobileDisplay', 0) == 1) {
    $forcast_template = getTemplate('core', $_version, 'forecast', 'weather');
    for ($i = 0; $i < 5; $i++) {
      $replace = array();
      $replace['#day#'] = date_fr(date('l', strtotime('+' . $i . ' days')));

      if ($i == 0) {
        $temperature_min = $this->getCmd(null, 'temperature_min');
      } else {
        $temperature_min = $this->getCmd(null, 'temperature_' . $i . '_min');
      }
      $replace['#low_temperature#'] = is_object($temperature_min) ? $temperature_min->execCmd() : '';

      if ($i == 0) {
        $temperature_max = $this->getCmd(null, 'temperature_max');
      } else {
        $temperature_max = $this->getCmd(null, 'temperature_' . $i . '_max');
      }
      $replace['#hight_temperature#'] = is_object($temperature_max) ? $temperature_max->execCmd() : '';
      $replace['#tempid#'] = is_object($temperature_max) ? $temperature_max->getId() : '';

      if ($i == 0) {
        $condition = $this->getCmd(null, 'condition');
      } else {
        $condition = $this->getCmd(null, 'condition_' . $i);
      }
      $replace['#icone#'] = is_object($condition) ? self::getIconFromCondition($condition->execCmd()) : '';
      $replace['#conditionid#'] = is_object($condition) ? $condition->getId() : '';

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
    '#uid#' => 'weather' . $this->getId() . self::UIDDELIMITER . mt_rand() . self::UIDDELIMITER,
  );
  $temperature = $this->getCmd(null, 'temperature');
  $replace['#temperature#'] = is_object($temperature) ? $temperature->execCmd() : '';
  $replace['#tempid#'] = is_object($temperature) ? $temperature->getId() : '';

  $humidity = $this->getCmd(null, 'humidity');
  $replace['#humidity#'] = is_object($humidity) ? $humidity->execCmd() : '';

  $pressure = $this->getCmd(null, 'pressure');
  $replace['#pressure#'] = is_object($pressure) ? $pressure->execCmd() : '';
  $replace['#pressureid#'] = is_object($pressure) ? $pressure->getId() : '';

  $wind_speed = $this->getCmd(null, 'windSpeed');
  $replace['#windspeed#'] = is_object($wind_speed) ? $wind_speed->execCmd() : '';
  $replace['#windid#'] = is_object($wind_speed) ? $wind_speed->getId() : '';


  $replace['#sunrise#'] = '';
  $replace['#sunset#'] = '';

  $wind_direction = $this->getCmd(null, 'wind_direction');
  $replace['#wind_direction#'] = is_object($wind_direction) ? $wind_direction->execCmd() : 0;

  $replace['#refresh_id#'] = '';

  $condition = $this->getCmd(null, 'summary');
  $sunset_time = '';
  $sunrise_time = '';
  if (is_object($condition)) {
    $replace['#icone#'] = self::getIconFromCondition($condition->execCmd(), $sunrise_time, $sunset_time);
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

  if ($this->getConfiguration('modeImage', 0) == 1) {
    $replace['#visibilityIcon#'] = "none";
    $replace['#visibilityImage#'] = "block";
  } else {
    $replace['#visibilityIcon#'] = "block";
    $replace['#visibilityImage#'] = "none";
  }

  $html = template_replace($replace, getTemplate('core', $_version, 'current', 'weather'));
  cache::set('weatherWidget' . $_version . $this->getId(), $html, 0);
  return $html;
}

}

class forecastioCmd extends cmd {

  public function execute($_options = null) {
  }

}

?>
