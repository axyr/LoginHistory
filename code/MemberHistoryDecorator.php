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
		
		$tf = new TableListField(
					'LoginHistory',
					'LoginHistory',
					array('Date' => 'Date', 'Time' => 'Time', 'Ip' => 'Ip', 'City' => 'City', 'Country' => 'Country')
			);
		$fields->addFieldToTab('Root.LoginHistory', $tf);
		
	}
	
}