<?php

class MemberHistoryDecorator extends DataObjectDecorator{
	
	function extraStatics() {
		return array(
			'has_many' => array(
				'LoginHistories' => 'LoginHistory'
			)
		);
	}
	
	function memberLoggedIn(){
		$loc 		= new MM_Geoip();
		$history 	= new LoginHistory();
		
		$history->Ip			= $loc->getIp();
		$history->LocationData	= $loc->getAllLocationData();
		$history->MemberID		= $this->owner->ID;
		$history->write();
	}
	
	function updateCMSFields(FieldSet &$fields) {
		$fields->removeFieldsFromTab("Root", array('LoginHistories'));
		$sng = singleton('LoginHistory');
		$tf = new TableListField(
			$sng->ClassName,
			$sng->ClassName,
			$sng->summaryFields(),
			$sng->ClassName.'.MemberID='.$this->owner->ID
		);
		$tf->setShowPagination(true);
		$fields->addFieldToTab('Root.LoginHistory', $tf);
	}
	
}