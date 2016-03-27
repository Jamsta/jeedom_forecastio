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

  public static $_widgetPossibility = array('custom' => true);

  public static function cron5($_eqLogic_id = null) {
    if ($_eqLogic_id == null) {
      $eqLogics = self::byType('forecastio', true);
    } else {
      $eqLogics = array(self::byId($_eqLogic_id));
    }
    foreach ($eqLogics as $forecastio) {
      if (null !== ($forecastio->getConfiguration('geoloc', ''))) {
        $forecastio->getInformations('5m');
      } else {
        log::add('forecastio', 'error', 'geoloc non saisie');
      }
    }
  }

  public static function cronHourly($_eqLogic_id = null) {
    if ($_eqLogic_id == null) {
      $eqLogics = self::byType('forecastio', true);
    } else {
      $eqLogics = array(self::byId($_eqLogic_id));
    }
    foreach ($eqLogics as $forecastio) {
      if (null !== ($forecastio->getConfiguration('geoloc', ''))) {
        $forecastio->getInformations('hourly');
      } else {
        log::add('forecastio', 'error', 'geoloc non saisie');
      }
    }
    if (date('G')  == 3) {
      foreach ($eqLogics as $forecastio) {
        if (null !== ($forecastio->getConfiguration('geoloc', ''))) {
          $forecastio->getInformations('daily');
        } else {
          log::add('forecastio', 'error', 'geoloc non saisie');
        }
      }
    }
  }

  public static function start() {
    foreach (self::byType('forecastio', true) as $forecastio) {
      if (null !== ($forecastio->getConfiguration('geoloc', ''))) {
        $forecastio->getInformations('daily');
        $forecastio->getInformations('hourly');
        $forecastio->getInformations('5m');
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
      //info actual
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summary');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('icon');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensity');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Intensité de Précipitation', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipIntensity');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbability');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Probabilité de Précipitation', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipProbability');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipType');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Type de Précipitation', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipType');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperature');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperature');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperature');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Apparente', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperature');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPoint');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Point de Rosée', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('dewPoint');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidity');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Humidité', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('humidity');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeed');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Vitesse du Vent', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windSpeed');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Direction du Vent', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing0');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Provenance du Vent', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing0');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCover');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Couverture Nuageuse', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('cloudCover');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressure');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Pression', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('pressure');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozone');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Ozone', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('ozone');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      //info H+1
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensityh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Intensité de Précipitation H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipIntensityh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbabilityh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Probabilité de Précipitation H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipProbabilityh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipTypeh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Type de Précipitation H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipTypeh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Apparente H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPointh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Point de Rosée H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('dewPointh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidityh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Humidité H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('humidityh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeedh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Vitesse du Vent H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windSpeedh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearingh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Direction du Vent H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearingh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing0h1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Provenance du Vent H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing0h1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCoverh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Couverture Nuageuse H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('cloudCoverh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressureh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Pression H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('pressureh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozoneh1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Ozone H+1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('ozoneh1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h1');
      $forecastioCmd->save();

      //status H+2
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensityh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Intensité de Précipitation H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipIntensityh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbabilityh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Probabilité de Précipitation H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipProbabilityh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipTypeh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Type de Précipitation H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipTypeh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Apparente H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPointh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Point de Rosée H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('dewPointh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidityh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Humidité H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('humidityh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeedh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Vitesse du Vent H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windSpeedh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearingh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Direction du Vent H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearingh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing0h2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Provenance du Vent H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing0h2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCoverh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Couverture Nuageuse H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('cloudCoverh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressureh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Pression H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('pressureh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozoneh2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Ozone H+2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('ozoneh2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h2');
      $forecastioCmd->save();

      //status H+3
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensityh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Intensité de Précipitation H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipIntensityh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbabilityh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Probabilité de Précipitation H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipProbabilityh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipTypeh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Type de Précipitation H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipTypeh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Apparente H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPointh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Point de Rosée H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('dewPointh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidityh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Humidité H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('humidityh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeedh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Vitesse du Vent H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windSpeedh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearingh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Direction du Vent H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearingh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing0h3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Provenance du Vent H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing0h3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCoverh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Couverture Nuageuse H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('cloudCoverh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressureh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Pression H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('pressureh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozoneh3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Ozone H+3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('ozoneh3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h3');
      $forecastioCmd->save();

      //status H+4
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensityh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Intensité de Précipitation H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipIntensityh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbabilityh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Probabilité de Précipitation H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipProbabilityh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipTypeh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Type de Précipitation H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipTypeh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Apparente H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPointh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Point de Rosée H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('dewPointh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidityh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Humidité H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('humidityh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeedh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Vitesse du Vent H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windSpeedh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearingh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Direction du Vent H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearingh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing0h4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Provenance du Vent H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing0h4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCoverh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Couverture Nuageuse H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('cloudCoverh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressureh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Pression H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('pressureh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozoneh4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Ozone H+4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('ozoneh4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h4');
      $forecastioCmd->save();

      //status H+5
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipIntensityh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Intensité de Précipitation H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipIntensityh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipProbabilityh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Probabilité de Précipitation H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipProbabilityh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'precipTypeh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Type de Précipitation H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('precipTypeh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Apparente H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'dewPointh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Point de Rosée H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('dewPointh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'humidityh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Humidité H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('humidityh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windSpeedh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Vitesse du Vent H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windSpeedh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearingh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Direction du Vent H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearingh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'windBearing0h5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Provenance du Vent H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('windBearing0h5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'cloudCoverh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Couverture Nuageuse H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('cloudCoverh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'pressureh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Pression H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('pressureh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'ozoneh5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Ozone H+5', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('ozoneh5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','h5');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'sunriseTime');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Lever du Soleil', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('sunriseTime');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'sunsetTime');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Coucher du Soleil', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('sunsetTime');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryweek');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition semaine', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryweek');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconweek');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone semaine', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconweek');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summaryhours');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition prochaines heures', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summaryhours');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'iconhours');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone prochaines heures', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('iconhours');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureMin');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Minimum Apparente', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureMin');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'apparentTemperatureMax');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Maximum Apparente', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('apparentTemperatureMax');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Minimum Jour', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMin_1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Maximum Jour', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMax_1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition Jour', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summary_1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_1');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone Jour', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('icon_1');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Minimum +1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMin_2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Maximum +1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMax_2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition Jour +1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summary_2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_2');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone Jour +1', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('icon_2');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Minimum +2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMin_3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Maximum +2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMax_3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition Jour +2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summary_3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_3');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone Jour +2', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('icon_3');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Minimum +3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMin_4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Maximum +3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMax_4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition Jour +3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summary_4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_4');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone Jour +3', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('icon_4');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMin_5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Minimum +4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMin_5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'temperatureMax_5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Température Maximum +4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('temperatureMax_5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('numeric');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'summary_5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Condition Jour +4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('summary_5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'icon_5');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Icone Jour +4', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('icon_5');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','daily');
      $forecastioCmd->save();

      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($forecastio->getId(),'alert');
      if (!is_object($forecastioCmd)) {
        $forecastioCmd = new forecastioCmd();
        $forecastioCmd->setName(__('Alertes', __FILE__));
        $forecastioCmd->setEqLogic_id($this->id);
        $forecastioCmd->setLogicalId('alert');
        $forecastioCmd->setType('info');
        $forecastioCmd->setSubType('string');
      }
      $forecastioCmd->setConfiguration('category','actual');
      $forecastioCmd->save();

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


  public function getInformations($frequence = 'all') {
    $geoloc = $this->getConfiguration('geoloc', '');
    $geolocCmd = geolocCmd::byId($geoloc);
    $geolocval = $geolocCmd->execCmd();
    $apikey = $this->getConfiguration('apikey', '');
    $lang = explode('_',config::byKey('language'));
    $url = 'https://api.forecast.io/forecast/' . $apikey .'/' . $geolocval . '?units=ca&lang=' . $lang[0];
    log::add('forecastio', 'debug', $url);
    $json_string = file_get_contents($url);
    $parsed_json = json_decode($json_string, true);
    //log::add('forecastio', 'debug', print_r($json_string, true));
    //log::add('forecastio', 'debug', print_r($parsed_json, true));
    //log::add('forecastio', 'debug', print_r($parsed_json['currently'], true));
    if ($frequence == 'daily' || $frequence == 'all') {
      foreach ($parsed_json['daily']['data'][0] as $key => $value) {
        if ($key == 'sunsetTime' || $key == 'sunriseTime') {
          $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
          if (is_object($forecastioCmd)) {
            $value = date('Hi',$value);
            $forecastioCmd->setConfiguration('value',$value);
            $forecastioCmd->save();
            $forecastioCmd->event($value);
          }
        }
      }
    }

    if ($frequence == 'hourly' || $frequence == 'all') {
      foreach ($parsed_json['daily']['data'][0] as $key => $value) {
        if ($key == 'apparentTemperatureMax' || $key == 'apparentTemperatureMin' || $key == 'temperatureMax' || $key == 'temperatureMin') {
          $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
          if (is_object($forecastioCmd)) {
            $forecastioCmd->setConfiguration('value',$value);
            $forecastioCmd->save();
            $forecastioCmd->event($value);
          }
        }
      }
      //daily
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
    }

    if ($frequence == '5m' || $frequence == 'all') {
      //hourly
      $i = 1;
      while ($i < 6) {
        foreach ($parsed_json['hourly']['data'][$i] as $key => $value) {
          $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key . 'h' . $i);
          if (is_object($forecastioCmd)) {
            if ($key == 'windBearing') {
              $windBearing0 = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'windBearing0h' . $i);
              $windBearing0->setConfiguration('value',$value);
              $windBearing0->save();
              $windBearing0->event($value);
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
        $i++;
      }
      foreach ($parsed_json['currently'] as $key => $value) {
        //log::add('forecastio', 'debug', $key . ' ' . $value);
        if ($key != 'time') {
          $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),$key);
          if (is_object($forecastioCmd)) {
            if ($key == 'windBearing') {
              $windBearing0 = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'windBearing0');
              $windBearing0->setConfiguration('value',$value);
              $windBearing0->save();
              $windBearing0->event($value);
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

      if (!empty($parsed_json['alert'])) {
        $title = '';
        $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'alert');
        foreach ($parsed_json['alert'] as $key => $value) {
          if ($key == 'title') {
            $title .= ', ' . $value;
          }
        }
        if (is_object($forecastioCmd)) {
          $forecastioCmd->setConfiguration('value',$title);
          $forecastioCmd->save();
          $forecastioCmd->event($title);
        }
      }
    }

    if ($frequence == 'hourly' || $frequence == 'all') {
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'summaryhours');
      if (is_object($forecastioCmd)) {
        $forecastioCmd->setConfiguration('value',$parsed_json['hourly']['summary']);
        $forecastioCmd->save();
        $forecastioCmd->event($parsed_json['hourly']['summary']);
      }
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'iconhours');
      if (is_object($forecastioCmd)) {
        $forecastioCmd->setConfiguration('value',$parsed_json['hourly']['icon']);
        $forecastioCmd->save();
        $forecastioCmd->event($parsed_json['hourly']['icon']);
      }
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'summaryweek');
      if (is_object($forecastioCmd)) {
        $forecastioCmd->setConfiguration('value',$parsed_json['daily']['summary']);
        $forecastioCmd->save();
        $forecastioCmd->event($parsed_json['daily']['summary']);
      }
      $forecastioCmd = forecastioCmd::byEqLogicIdAndLogicalId($this->getId(),'iconweek');
      if (is_object($forecastioCmd)) {
        $forecastioCmd->setConfiguration('value',$parsed_json['daily']['icon']);
        $forecastioCmd->save();
        $forecastioCmd->event($parsed_json['daily']['icon']);
      }
    }

    return ;
  }

  public function loadingData($eqlogic) {
    $return = array();
    $forecastio = forecastio::byId($eqlogic);
    $geoloc = $forecastio->getConfiguration('geoloc', '');
    $geolocCmd = geolocCmd::byId($geoloc);
    $geolocval = $geolocCmd->execCmd();
    $apikey = $forecastio->getConfiguration('apikey', '');
    $lang = explode('_',config::byKey('language'));
    $url = 'https://api.forecast.io/forecast/' . $apikey .'/' . $geolocval . '?units=ca&lang=' . $lang[0];
    log::add('forecastio', 'debug', $url);
    $json_string = file_get_contents($url);
    $parsed_json = json_decode($json_string, true);
    //log::add('forecastio', 'debug', print_r($json_string, true));
    //log::add('forecastio', 'debug', print_r($parsed_json, true));
    //log::add('forecastio', 'debug', print_r($parsed_json['currently'], true));
    $temp = '[';
    $hum = '[';
    $wind = '[';
    $press = '[';
    foreach ($parsed_json['hourly']['data'] as $value) {
      $temp .= '[' . $value['time'] . ',' . $value['temperature'] . ']';
      $hum .= '[' . $value['time'] . ',' . $value['humidity'] . ']';
      $wind .= '[' . $value['time'] . ',' . $value['windSpeed'] . ']';
      $press .= '[' . $value['time'] . ',' . $value['pressure'] . ']';
    }

    $return['temp'] = array(
      'value' => $temp,
    );
    $return['hum'] = array(
      'value' => $hum,
    );
    $return['wind'] = array(
      'value' => $wind,
    );
    $return['press'] = array(
      'value' => $press,
    );

    $day0 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';
    $day1 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';
    $day2 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';
    $day3 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';
    $day4 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';
    $day5 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';
    $day6 = '{"summary":,"icon":,"temperature":,"apparentTemperature":,"humidity":,"precipProbability":,"windSpeed":,"windBearing":,"cloudCover":,"pressure":}';

    $return['status'] = array(
      'summary' => $parsed_json['currently']['summary'],
      'icon' => $parsed_json['currently']['icon'],
      'temperature' => $parsed_json['currently']['temperature'] . '°C',
      'apparentTemperature' => $parsed_json['currently']['apparentTemperature'] . '°C',
      'humidity' => $parsed_json['currently']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['currently']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['currently']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['currently']['windBearing'] > 179 ? $parsed_json['currently']['windBearing'] -180 : $windBearing_status = $parsed_json['currently']['windBearing'] + 180,
      'cloudCover' => $parsed_json['currently']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['currently']['pressure'] . 'mb',
    );

    $return['hour'] = array(
      'summary' => $parsed_json['hourly']['data']['0']['summary'],
      'icon' => $parsed_json['hourly']['data']['0']['icon'],
      'temperature' => $parsed_json['hourly']['data']['0']['temperature'] . '°C',
      'apparentTemperature' => $parsed_json['hourly']['data']['0']['apparentTemperature'] . '°C',
      'humidity' => $parsed_json['hourly']['data']['0']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['hourly']['data']['0']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['hourly']['data']['0']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['hourly']['data']['0']['windBearing'] > 179 ? $parsed_json['hourly']['data']['0']['windBearing'] -180 : $windBearing_status = $parsed_json['hourly']['data']['0']['windBearing'] + 180,
      'cloudCover' => $parsed_json['hourly']['data']['0']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['hourly']['data']['0']['pressure'] . 'mb',
    );

    $return['day0'] = array(
      'summary' => $parsed_json['daily']['data']['0']['summary'],
      'icon' => $parsed_json['daily']['data']['0']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['0']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['0']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['0']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['0']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['0']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['0']['windBearing'] > 179 ? $parsed_json['daily']['data']['0']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['0']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['0']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['0']['pressure'] . 'mb',
    );

    $return['day1'] = array(
      'summary' => $parsed_json['daily']['data']['1']['summary'],
      'icon' => $parsed_json['daily']['data']['1']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['1']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['1']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['1']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['1']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['1']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['1']['windBearing'] > 179 ? $parsed_json['daily']['data']['1']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['1']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['1']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['1']['pressure'] . 'mb',
    );

    $return['day2'] = array(
      'summary' => $parsed_json['daily']['data']['2']['summary'],
      'icon' => $parsed_json['daily']['data']['2']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['2']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['2']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['2']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['2']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['2']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['2']['windBearing'] > 179 ? $parsed_json['daily']['data']['2']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['2']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['2']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['2']['pressure'] . 'mb',
    );

    $return['day3'] = array(
      'summary' => $parsed_json['daily']['data']['3']['summary'],
      'icon' => $parsed_json['daily']['data']['3']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['3']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['3']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['3']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['3']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['3']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['3']['windBearing'] > 179 ? $parsed_json['daily']['data']['3']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['3']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['3']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['3']['pressure'] . 'mb',
    );

    $return['day4'] = array(
      'summary' => $parsed_json['daily']['data']['4']['summary'],
      'icon' => $parsed_json['daily']['data']['4']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['4']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['4']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['4']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['4']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['4']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['4']['windBearing'] > 179 ? $parsed_json['daily']['data']['4']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['4']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['4']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['4']['pressure'] . 'mb',
    );

    $return['day5'] = array(
      'summary' => $parsed_json['daily']['data']['5']['summary'],
      'icon' => $parsed_json['daily']['data']['5']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['5']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['5']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['5']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['5']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['5']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['5']['windBearing'] > 179 ? $parsed_json['daily']['data']['5']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['5']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['5']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['5']['pressure'] . 'mb',
    );

    $return['day6'] = array(
      'summary' => $parsed_json['daily']['data']['6']['summary'],
      'icon' => $parsed_json['daily']['data']['6']['icon'],
      'temperatureMin' => $parsed_json['daily']['data']['6']['temperatureMin'] . '°C',
      'temperatureMax' => $parsed_json['daily']['data']['6']['temperatureMax'] . '°C',
      'humidity' => $parsed_json['daily']['data']['6']['humidity']*100 . '%',
      'precipProbability' => $parsed_json['daily']['data']['6']['precipProbability']*100 . '%',
      'windSpeed' => $parsed_json['daily']['data']['6']['windSpeed'] . 'km/h',
      'windBearing' => $parsed_json['daily']['data']['6']['windBearing'] > 179 ? $parsed_json['daily']['data']['6']['windBearing'] -180 : $windBearing_status = $parsed_json['daily']['data']['6']['windBearing'] + 180,
      'cloudCover' => $parsed_json['daily']['data']['6']['cloudCover']*100 . '%',
      'pressure' => $parsed_json['daily']['data']['6']['pressure'] . 'mb',
    );

    return $return;
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
    $replace = $this->preToHtml($_version);
    if (!is_array($replace)) {
      return $replace;
    }
    $version = jeedom::versionAlias($_version);
    if ($this->getDisplay('hideOn' . $version) == 1) {
      return '';
    }

    $html_forecast = '';

    if ($_version != 'mobile' || $this->getConfiguration('fullMobileDisplay', 0) == 1) {
      $forcast_template = getTemplate('core', $_version, 'forecast', 'forecastio');
      for ($i = 0; $i < 5; $i++) {
        $replace['#day#'] = date_fr(date('l', strtotime('+' . $i . ' days')));

        $j = $i + 1;
        $temperature_min = $this->getCmd(null, 'temperatureMin_' . $j);
        $replace['#low_temperature#'] = is_object($temperature_min) ? round($temperature_min->execCmd()) : '';

        $temperature_max = $this->getCmd(null, 'temperatureMax_' . $j);
        $replace['#hight_temperature#'] = is_object($temperature_max) ? round($temperature_max->execCmd()) : '';
        $replace['#tempid#'] = is_object($temperature_max) ? $temperature_max->getId() : '';

        $icone = $this->getCmd(null, 'icon_' . $j);
        $replace['#icone#'] = is_object($icone) ? $icone->getId() : '';

        $html_forecast .= template_replace($replace, $forcast_template);
      }
    }

    $replace['#forecast#'] = $html_forecast;
    $replace['#city#'] = $this->getName();

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
      $replace['#iconeid#'] = $icone->getId();
      $replace['#condition#'] = $condition->execCmd();
      $replace['#conditionid#'] = $condition->getId();
      $replace['#collectDate#'] = $condition->getCollectDate();
    } else {
      $replace['#icone#'] = '';
      $replace['#condition#'] = '';
      $replace['#collectDate#'] = '';
    }

    $icone = $this->getCmd(null, 'icon');
    $replace['#icone#'] = is_object($icone) ? $icone->execCmd() : '';

    $icone1 = $this->getCmd(null, 'icon_1');
    $replace['#icone1#'] = is_object($icone1) ? $icone1->execCmd() : '';
    $replace['#iconeid1#'] = is_object($icone1) ? $icone1->getId() : '';

    $icone2 = $this->getCmd(null, 'icon_2');
    $replace['#icone2#'] = is_object($icone2) ? $icone2->execCmd() : '';
    $replace['#iconeid2#'] = is_object($icone2) ? $icone2->getId() : '';

    $icone3 = $this->getCmd(null, 'icon_3');
    $replace['#icone3#'] = is_object($icone3) ? $icone3->execCmd() : '';
    $replace['#iconeid3#'] = is_object($icone3) ? $icone3->getId() : '';

    $icone4 = $this->getCmd(null, 'icon_4');
    $replace['#icone4#'] = is_object($icone4) ? $icone4->execCmd() : '';
    $replace['#iconeid4#'] = is_object($icone4) ? $icone4->getId() : '';

    $icone5 = $this->getCmd(null, 'icon_5');
    $replace['#icone5#'] = is_object($icone5) ? $icone5->execCmd() : '';
    $replace['#iconeid5#'] = is_object($icone5) ? $icone5->getId() : '';

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
