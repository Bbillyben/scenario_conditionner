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

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';
require_once __DIR__  . '/../../../../core/php/utils.inc.php';

class scenario_conditionner extends eqLogic {


    
    /*     * ***********************Methode static*************************** */
  
  public static function getStatusById($eqId){
  	log::add(__CLASS__, 'debug', 'call showroom, id :'.$eqId);
     if($eqId=='' or $eqId==0)return false;
      $eqL=eqLogic::byId($eqId);

      if(!is_object($eqL)){
        log::add('scenario_conditionner', 'error', '####### Get EqlL error '.$eqId.' not found######');
        return false;
      }
    	$ctCMD = $eqL->getCmd(null, 'status');
      if (!is_object($ctCMD)) {
        log::add('scenario_conditionner', 'error', '####### Get Status CMD error '.$eqId.' not found######');
        return false;
      }
      return array($ctCMD->execCmd(), $ctCMD->getValueDate(), jeedom::toHumanReadable($eqL->getConfiguration('expression', '')));
  
  }
  public static function getScenarList($eqId){
     log::add(__CLASS__, 'debug', 'call showroom, id :'.$eqId);
     if($eqId=='' or $eqId==0)return array();
      $eqL=eqLogic::byId($eqId);

      if(!is_object($eqL)){
      log::add('scenario_conditionner', 'error', '####### Show room error '.$eqId.' not found######');
      return false;
      }
      $listScen=array();
      $allCmds = $eqL->getCmd('info');

      foreach($allCmds as $cmdCol){
         if($cmdCol->getConfiguration('cmdType') != "conditioner")continue;
         
         if($cmdCol->getConfiguration('act_type')=='scenario'){
            $eqId = $cmdCol->getConfiguration('scenarCond');
            if($eqId==''){
               log::add(__CLASS__,"warning", 'Scenario not found in '.$eqL->getHumanName());
               continue;
            }
            $scen=scenario::byString($eqId);
         }else{  
            $eqId = str_replace(array('#', 'eqLogic'),array('',''),$cmdCol->getConfiguration('equipCond'));
            $scen=eqLogic::byId($eqId);
         }
         if($scen == false || !is_object($scen)){
            log::add(__CLASS__,"warning", 'Item not found in '.$eqL->getHumanName());
            continue;
         }
         $listScen[]=array('scenar'=>$scen->getHumanName(),
                  'act_entry'=>self::getActionTranslation($cmdCol->getConfiguration('entry-act')),
                  'act_exit'=>self::getActionTranslation($cmdCol->getConfiguration('exit-act')));
      }
      return $listScen;
  }
  Private static function getActionTranslation($act){
     switch($act){
        case 'activate':
            return __('Activer', __FILE__);
         break;
         case 'deactivate':
            return __('D??sactiver', __FILE__);
            break;
         case 'activate_launch':
            return __('Activer et lancer', __FILE__);
            break;
         case 'show':
               return __('Visible', __FILE__);
               break;
         case 'hide':
            return __('Masquer', __FILE__);
            break;
        case 'none':
         return __('Ne rien faire', __FILE__);
         break;
     }
     return false;
  }

  public static function getTagsCmd($cmd, $status){
      if($cmd->getConfiguration('cmdType') != "conditioner")return false;
      $action = ($status == 1? 'tag-entry':'tag-exit');
      $tags = $cmd->getConfiguration($action);
      return arg2array($tags);
  }
  // ========== Gestion de la mise ?? jour des donn??es des conditions
  public static function trigger($_option) {
		log::add(__CLASS__, 'debug', '????????????????????????????????????????????????????????????????????????  Trigger sur id :'.$_option['id']);

		$eqLogic = self::byId($_option['id']);
		if (is_object($eqLogic) && $eqLogic->getIsEnable() == 1) {
			$eqLogic->checkCondition();
		}
      log::add(__CLASS__,'debug', "?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????? END Trigger ");
		
	}


    /*     * *********************M??thodes d'instance************************* */
    
 // Fonction ex??cut??e automatiquement avant la cr??ation de l'??quipement 
    public function preInsert() {
        
    }

 // Fonction ex??cut??e automatiquement apr??s la cr??ation de l'??quipement 
    public function postInsert() {
        
    }

 // Fonction ex??cut??e automatiquement avant la mise ?? jour de l'??quipement 
    public function preUpdate() {
        
    }

 // Fonction ex??cut??e automatiquement apr??s la mise ?? jour de l'??quipement 
    public function postUpdate() {
        
    }

 // Fonction ex??cut??e automatiquement avant la sauvegarde (cr??ation ou mise ?? jour) de l'??quipement 
    public function preSave() {
      //rendre non affich?? les cmd scenario
      $allCmds = $this->getCmd('info');
     
      foreach($allCmds as $cmdCol){
        if($cmdCol->getConfiguration('cmdType') != "conditioner")continue;
        	$cmdCol->setIsVisible(0);
          	$cmdCol->save(true);
      }
        
    }

 // Fonction ex??cut??e automatiquement apr??s la sauvegarde (cr??ation ou mise ?? jour) de l'??quipement 
    public function postSave() {
      
       // commande info du status
        $ctCMD = $this->getCmd(null, 'status');
      if (!is_object($ctCMD)) {
         $ctCMD = new scenario_conditionnerCmd();
         $ctCMD->setLogicalId('status');
         $ctCMD->setIsVisible(1);
         $ctCMD->setName(__('Status', __FILE__));
      }

      $ctCMD->setType('info');
      $ctCMD->setSubType('binary');
      $ctCMD->setEqLogic_id($this->getId());
      $ctCMD->save();
      
      
      $ctCMDAct = $this->getCmd(null, 'force_check');
      if (!is_object($ctCMDAct)) {
         $ctCMDAct = new scenario_conditionnerCmd();
         $ctCMDAct->setLogicalId('force_check');
         $ctCMDAct->setIsVisible(1);
         $ctCMDAct->setName(__('Force V??rification', __FILE__));
      }
      $ctCMDAct->setType('action');
      $ctCMDAct->setSubType('other');      
      $ctCMDAct->setEqLogic_id($this->getId());
      $ctCMDAct->save();
      
      
      
      // creation des commandes par d??faut
      $ctCMDAct = $this->getCmd(null, 'force_entry');
      if (!is_object($ctCMDAct)) {
         $ctCMDAct = new scenario_conditionnerCmd();
         $ctCMDAct->setLogicalId('force_entry');
         $ctCMDAct->setIsVisible(1);
         $ctCMDAct->setName(__('Force Entr??e', __FILE__));
      }
      $ctCMDAct->setType('action');
      $ctCMDAct->setSubType('other');      
      $ctCMDAct->setEqLogic_id($this->getId());
      $ctCMDAct->save();
      
      $ctCMDAct = $this->getCmd(null, 'force_exit');
      if (!is_object($ctCMDAct)) {
         $ctCMDAct = new scenario_conditionnerCmd();
         $ctCMDAct->setLogicalId('force_exit');
         $ctCMDAct->setIsVisible(1);
         $ctCMDAct->setName(__('Force Sortie', __FILE__));
      }
      $ctCMDAct->setType('action');
      $ctCMDAct->setSubType('other');      
      $ctCMDAct->setEqLogic_id($this->getId());
      $ctCMDAct->save();

      
      
      // mmise ?? jhour du status 
      $expression = $this->getConfiguration('expression', '');
      if ($expression=='') {
			log::add(__CLASS__, 'warning', 'Aucun test d??fini sur :'.$this->getName());
			return;
		}else{
        
      	$testCond =jeedom::evaluateExpression($expression);
        	$ctCMD = $this->getCmd(null, 'status');
        	$ctCMD->event($testCond);
      }
      
      // mise ?? jour des listener
      $this->setListener();
        
    }

 // Fonction ex??cut??e automatiquement avant la suppression de l'??quipement 
    public function preRemove() {
        $this->removeListener();
    }

 // Fonction ex??cut??e automatiquement apr??s la suppression de l'??quipement 
    public function postRemove() {
        
    }

    /*
     * Non obligatoire : permet de modifier l'affichage du widget (??galement utilisable par les commandes)
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire : permet de d??clencher une action apr??s modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire : permet de d??clencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    /*     * **********************Getteur Setteur*************************** */
  
  // ============== handler de la condition 
  public function  checkCondition(){
    	$expression = $this->getConfiguration('expression', '');
    	$ctCMD = $this->getCmd(null, 'status');
    	if (!is_Object($ctCMD)){
         	log::add(__CLASS__, 'error', 'Pas de commande Status d??fini sur '.$this->getName());
          return;
        }
    	$status = $ctCMD->execCmd();
    	log::add(__CLASS__, 'debug', 'Verif Condition sur '.$this->getHumanName().' sur expression : '.$expression);
    	if ($expression=='') {
			log::add(__CLASS__, 'warning', 'Aucun test d??fini sur :'.$this->getName());
			return;
		} 
    	$testCond =jeedom::evaluateExpression($expression);
    	log::add(__CLASS__, 'debug', 'Expression ??valu??e ?? '.($testCond==1?1:0));
    	if($testCond == $status){
          	log::add(__CLASS__, 'debug', 'Condition identique ?? status en cours :'.$testCond.'/'.$status);
          return;
        }
    	$this->manageScenar($testCond);
    	
    
  }
  public function manageScenar($status){
   		$action = ($status == 1? 'entry-act':'exit-act');
    	log::add(__CLASS__, 'debug', 'Gestion item sur action:'.$action);
    	$allCmd=$this->getCmd('info');
        foreach($allCmd as $cmd){
            if($cmd->getConfiguration('cmdType') != "conditioner")continue;

            if($cmd->getConfiguration('act_type')=='scenario'){
               $eqId =$cmd->getConfiguration('scenarCond');
               $scen=scenario::byString( $eqId);
            }else{  
               $eqId = str_replace(array('#', 'eqLogic'),array('',''),$cmd->getConfiguration('equipCond'));
               $scen=eqLogic::byId($eqId);
            }
            if(!is_object($scen)){
               log::add(__CLASS__, 'error', 'Item non trouv??, id : '. $eqId.', sur objet : '.$this->getHumanName());
                 return false;
                 
            }

            $scenarAct = $cmd->getConfiguration($action);
            log::add(__CLASS__, 'debug', 'action : '.$scenarAct.' sur item : '.$scen->getHumanName());
			$this->action_scenar($scen, $scenarAct, $status, $cmd);
        }
    
    	$ctCMD = $this->getCmd(null, 'status');
      $ctCMD->event($status);
  }    
  private function action_scenar($scenar, $action, $status,$cmd){
   	if($action=='none')return;
    switch ($action) {
        case 'activate':
        	log::add(__CLASS__, 'debug', 'Activation item : '.$scenar->getHumanName());
           if($cmd->getConfiguration('act_type')=='scenario'){
            $scenar->setIsActive(1);
           }else{
            $scenar->setIsEnable(1);
           }
            
        	   $scenar->save();
            break;
         case 'activate_launch':
            $scenar->setIsActive(1);
        	   $scenar->save();
            $tags = self::getTagsCmd($cmd, $status);
            $scenar->setTags($tags);
            log::add(__CLASS__, 'debug', 'Lance scenario avec tags : '.json_encode($tags));
            $scenar->launch();
            break;
        case 'deactivate':
            log::add(__CLASS__, 'debug', 'D??sactivation item : '.$scenar->getHumanName());
            if($cmd->getConfiguration('act_type')=='scenario'){
               $scenar->setIsActive(0);
              }else{
               $scenar->setIsEnable(0);
              }
        	   $scenar->save();
            break;
         case 'show':
            log::add(__CLASS__, 'debug', 'Visible equipement : '.$scenar->getHumanName());
            $scenar->setIsVisible(1);
            $scenar->save();
            break;
         case 'hide':
            log::add(__CLASS__, 'debug', 'Masquer equipement : '.$scenar->getHumanName());
            $scenar->setIsVisible(0);
            $scenar->save();
            break;
         
    }
    
    
  }
/*================================== GESTION DES LISTENER ============================*/
  private function getListener() {
		return listener::byClassAndFunction(__CLASS__, 'trigger', array('id' => $this->getId()));
	}

	private function removeListener() {
      log::add(__CLASS__, 'debug', ' Suppression des Ecouteurs de '.$this->getHumanName());
		$listener = $this->getListener();
		if (is_object($listener)) {
			$listener->remove();
		}
	}

	private function setListener() {
		log::add(__CLASS__, 'debug', ' Enregistrement des Ecouteurs');

		$expression = $this->getConfiguration('expression', '');
      
      	log::add(__CLASS__, 'debug', 'Expression : '.$expression);

		if ($this->getIsEnable() == 0 || $expression==='') {
			$this->removeListener();
			return;
		}

		$pregResult = preg_match_all("/#([0-9]*)#/", $expression, $matches);
      
		if ($pregResult===false) {
			log::add(__CLASS__, 'error', __('Erreur regExp Expression', __FILE__) . ': '.  $expression);
			$this->removeListener();
			return;
		}

		if ($pregResult<1) {
			log::add(__CLASS__, 'debug', 'Pas de Commandes trouv??s dans les listeners');
			$this->removeListener();
			return;
		}

		$listener = $this->getListener();
		if (!is_object($listener)) {
          	
			$listener = new listener();
			$listener->setClass(__CLASS__);
			$listener->setFunction('trigger');
			$listener->setOption(array('id' => $this->getId()));
		}
		$listener->emptyEvent();

		$eventAdded = false;
		foreach ($matches[1] as $cmd_id) {
			if (!is_numeric($cmd_id)) continue;
          
			$cmd = cmd::byId($cmd_id);
          log::add(__CLASS__, 'debug', 'Ajout listener pour la commande :'.$cmd->getHumanName());
			if (!is_object($cmd)) continue;
			$listener->addEvent($cmd->getId());
			$eventAdded = true;
		}
		if ($eventAdded) {
			$listener->save();
		} else {
			$listener->remove();
		}
	}

  
  
}

class scenario_conditionnerCmd extends cmd {


  // Ex??cution d'une commande  
     public function execute($_options = array()) {
       
      log::add('scenario_conditionner','debug', "???????????????????????????????????????????????????????????????????????? execute CMD : ".$this->getId()." | ".$this->getHumanName().", logical id : ".$this->getLogicalId() ."  options : ".json_encode($_options));
      log::add('scenario_conditionner','debug', '??????????????? Eq logic '.$this->getEqLogic()->getHumanName());
      
      switch($this->getLogicalId()){
         case 'force_check':
          	$this->getEqLogic()->checkCondition();
          break;
         case 'force_entry':
          	$this->getEqLogic()->manageScenar(1);
         	break;
         case 'force_exit';
         	$this->getEqLogic()->manageScenar(0);
           break;           
         default:
         log::add('scenario_conditionner','debug', '??????????????? Default call');

      } 
      log::add('scenario_conditionner','debug', "?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????? END execute CMD ".$this->getHumanName());
		return true;
	
     }

    /*     * **********************Getteur Setteur*************************** */
}