<?php

include_once 'data/CRMEntity.php';
include_once 'vtlib/Vtiger/Menu.php';
include_once 'vtlib/Vtiger/Link.php';
include_once 'include/utils/utils.php';
include_once 'vtlib/Vtiger/Module.php';
include_once 'include/events/include.inc';


class History {

    protected $tabId = 0; 
    protected $headerScriptLinkType = 'HEADERSCRIPT';
    protected $incominglinkLabel = 'History';


    public function __construct(){
        $this->log = & LoggerManager::getLogger('INSTALL');
    }

    
    function vtlib_handler($moduleName, $eventType) {

		if($eventType == 'module.postinstall') {
            $this->log->debug('Post install starting'); 
            $this->registerHeaderScripts();        
            $this->log->debug('Post install ending'); 
        } else if($eventType == 'module.disabled') {
        // TODO Handle actions when this module is disabled.
        } else if($eventType == 'module.enabled') {
        // TODO Handle actions when this module is enabled.
        } else if($eventType == 'module.preuninstall') {
        // TODO Handle actions when this module is about to be deleted.
        } else if($eventType == 'module.preupdate') {
        // TODO Handle actions before this module is updated.
        } else if($eventType == 'module.postupdate') {
        // TODO Handle actions after this module is updated.
        }
    }


    public function registerHeaderScripts(){
        global $adb;
        $this->log->debug('Starting registerHeaderScripts'); 

        $handlerInfo = array(
            'path' => 'modules/History/History.php',
            'class' => 'History', 
            'method' => 'checkLinkPermission' );
            
        Vtiger_Link::addLink($this->tabId, $this->headerScriptLinkType, $this->incominglinkLabel, 
                            'modules/History/resources/History.js', '', '', $handlerInfo);
                            
        $this->log->debug('Ending registerHeaderScripts');
    }


    public function checkLinkPermission(){ 
        $module = new Vtiger_Module();
        $moduleInstance = $module->getInstance('History');
        
        if($moduleInstance) {
            return true;
        }else {
            return false;
        }
    }
}