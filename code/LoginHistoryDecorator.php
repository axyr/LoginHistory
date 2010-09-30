<?php

class LoginHistoryDecorator extends DataObjectDecorator{
	
	function updateSummaryFields(&$fields){
		$fields['Region'] = "Region"; 
	}
	
	function Region(){
		$data = $this->owner->LocationData();
		return $data['region_name'];
	}
}