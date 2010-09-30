<?php

class LoginHistory extends DataObject{
	
	static $db = array(
		'Ip' => 'Varchar(15)',
		'LocationData' => 'Text'
	);
	
	static $has_one = array(
		'Member' => 'Member'
	);
	
	static $default_sort = 'Created DESC';
	
	static $summary_fields = array(
		'Date' 		=> 'Date',
		'Time' 		=> 'Time',
		'Ip' 		=> 'Ip',
		'City' 		=> 'City',
		'Country' 	=> 'Country'
	);
	
	function __construct($record = null, $isSingleton = false) {
		parent::__construct($record, $isSingleton);
	}
	
	function onBeforeWrite(){
		parent::onBeforeWrite();
		if($this->LocationData){
			$this->LocationData = serialize($this->LocationData);
		}	
	}
	
	function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldsFromTab("Root.Main", array('LocationData'));
		
		/*if($data = $this->LocationData()){
			foreach($data as $k => $v){
				$data_fields[] = new TextField('LocationData["'.$k.'"]', $k, $v);	
			}
			$set = new FieldSet(
				$data_fields		
			);
			$fields->addFieldsToTab("Root.Main", $set);
			
		}*/
		
		return $fields;	
	}
	
	function LocationData(){
		if($this->LocationData){
			return unserialize($this->LocationData);
		}
	}
	
	function City(){
		$data = $this->LocationData();
		return $data['city'];
	}
	
	function Country(){
		$data = $this->LocationData();
		return $data['country_name'];
	}
	
	function Date(){
		return $this->dbObject('Created')->Date();
	}
	
	function Time(){
		return $this->dbObject('Created')->Time();
	}
}