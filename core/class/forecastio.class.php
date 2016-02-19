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
      $forecastioCmd->setName(__('windBearing', __FILE__));
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

    forecastio::getInformations();
  }
}


public function getInformations() {
  $geoloc = $this->getConfiguration('geoloc', '');
  $apikey = $this->getConfiguration('apikey', '');
  $url = 'https://api.forecast.io/forecast/' . $apikey .'/' . $geoloc . '?units=ca';
  $json_string = file_get_contents($url);
  $parsed_json = json_decode($json_string, true);
  log::add('forecastio', 'debug', print_r($parsed_json));
  log::add('forecastio', 'debug', print_r($parsed_json['currently']));
  foreach ($parsed_json['currently'] as $key => $value) {
    if ($key != 'time' && $key != 'icon') {
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),$key);
      $forecastioCmd->setConfiguration('value',$value);
      $forecastioCmd->save();
      $forecastioCmd->event($value);
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
  $mc = cache::byKey('forecastioWidget' . $_version . $this->getId());
  if ($mc->getValue() != '') {
    return $mc->getValue();
  }
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
      $vcolor = 'cmdColor';
      if ($_version == 'mobile') {
          $vcolor = 'mcmdColor';
      }
      $parameters = $this->getDisplay('parameters');
      $cmdColor = ($this->getPrimaryCategory() == '') ? '' : jeedom::getConfiguration('eqLogic:category:' . $this->getPrimaryCategory() . ':' . $vcolor);
      if (is_array($parameters) && isset($parameters['background_cmd_color'])) {
          $cmdColor = $parameters['background_cmd_color'];
      }

      if (($_version == 'dview' || $_version == 'mview') && $this->getDisplay('doNotShowNameOnView') == 1) {
          $replace['#name#'] = '';
          $replace['#object_name#'] = (is_object($object)) ? $object->getName() : '';
      }
      if (($_version == 'mobile' || $_version == 'dashboard') && $this->getDisplay('doNotShowNameOnDashboard') == 1) {
          $replace['#name#'] = '<br/>';
          $replace['#object_name#'] = (is_object($object)) ? $object->getName() : '';
      }

      if (is_array($parameters)) {
          foreach ($parameters as $key => $value) {
              $replace['#' . $key . '#'] = $value;
          }
      }

  $id=array();
  $value=array();
  foreach($this->getCmd() as $cmd){
    $type_cmd=$cmd->getConfiguration('data');
    $id[$type_cmd]=$cmd->getId();
    $value[$type_cmd]=$cmd->getConfiguration('value');
  }

  $cmdlogic = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'azimuth360');
  $datec = $cmdlogic->getCollectDate();

  $replace = array(
    '#name#' => $this->getName(),
    '#azimuth360#' => round($value['azimuth360'],1),
    '#azimuth360_id#' => $id['azimuth360'],
    '#altitude#' => round($value['altitude'],1),
    '#sunrise#' => substr_replace($value['sunrise'],':',-2,0),
    '#sunset#' => substr_replace($value['sunset'],':',-2,0),
    '#id#' => $this->getId(),
    '#collectDate#' => $datec,
    '#background_color#' => $this->getBackgroundColor(jeedom::versionAlias($_version)),
    '#eqLink#' => ($this->hasRight('w')) ? $this->getLinkToConfiguration() : '#',
  );
  if (array_key_exists('daystatus', $value) && $value['daystatus']=="1") {
    $replace['#heliosun#'] = "color : rgba(255,255,255,1)";
    $replace['#heliomoon#'] = "color : rgba(255,255,255,0.3)";
  } else {
    $replace['#heliosun#'] = "color : rgba(255,255,255,0.3)";
    $replace['#heliomoon#'] = "color : rgba(255,255,255,1)";
  }

  $parameters = $this->getDisplay('parameters');
  if (is_array($parameters)) {
    foreach ($parameters as $key => $value) {
      $replace['#' . $key . '#'] = $value;
    }
  }
  $html = template_replace($replace, getTemplate('core', $_version, 'forecastio', 'forecastio'));
  cache::set('forecastioWidget' . $_version . $this->getId(), $html, 0);
  return $html;
}

}

class forecastioCmd extends cmd {

  public function execute($_options = null) {
  }

}

?>
