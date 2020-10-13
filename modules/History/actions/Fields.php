<?php

class History_Fields_Action extends Vtiger_IndexAjax_View {

	function checkPermission(Vtiger_Request $request) {
		return;
	}


    public function __construct() {
		parent::__construct();
		$this->exposeMethod('getAvalibleFields');
    }
    

	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
    }

    public function hasModuleUpdates($moduleName){ 
        global $adb; 

        $resutl = $adb->pquery('SELECT mt.visible FROM vtiger_modtracker_tabs AS mt
                    INNER JOIN vtiger_tab AS t ON t.tabid = mt.tabid WHERE t.name=?', array($moduleName)); 

        if( !empty($resutl[0]['visible'])){
            return True; 
        }
        return False; 
    }


    // Accounts_detailView_fieldValue_website 
    public function getFields($moduleName){
        global $adb; 
        
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);

        $recordStructure = Vtiger_RecordStructure_Model::getInstanceForModule($moduleModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_DETAIL); 

        $blockModelList = $moduleModel->getBlocks();
        
        $fields = array(); 

        foreach($blockModelList as $blockLabel=>$blockModel){ 
            $fieldModelList = $blockModel->getFields();
            if (!empty($fieldModelList)){
                foreach($fieldModelList as $fieldName=>$fieldModel){
                    if($fieldModel->isViewable()){
                        $fields[] = $moduleName.
                    }
                }
             }
        }

    }

    
    public function getAvalibleFields(Vtiger_Request $request){
        global $adb; 
		$response = new Vtiger_Response();

        $moduleName = $request->get('currentModule'); 

        if(!$this->hasModuleUpdates($moduleName) || empty($fields = $this->getFields($moduleName))){
            $response->setResult(array('success' => false));
            return; 
        }else{ 
            $response->setResult(array(
                'success' => true,
                'fields'=>  $fields));
        }

        $response->emit(); 
    }

}
