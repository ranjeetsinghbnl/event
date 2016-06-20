<?php
class Event extends AppModel{
	var $name = 'Event';
	var $hasMany = array('Ticket');
	
	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter event name.'
		),
		'description' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter event description.'
		),
		'start_date' => array(
			'notEmpty'=> array(
				'rule' => 'notEmpty',
				'message' => 'Please select start date.',
			),
			'validDate'=> array(
				'rule' => 'validDate',
				'message' => 'Date should not be less than current date.',
			)
		),
		'end_date' => array(
			'validEndDate' => array(
				'rule' => 'validEndDate', 
				'message' => 'The end date must be later than start date',
			),
		),
		'organiser' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter event organiser.'
		)
	);
	
	/** 
    @function:validDate 
    @description:This function is used to check validation on date
    */  
	public function validDate($fields = null){
		if(!empty($fields['start_date'])) {
			$cur_dat = strtotime(date('Y-m-d'));
			$enter_date = strtotime($fields['start_date']);
			if($enter_date > $cur_dat || $enter_date == $cur_dat){
				return true;		
			}else{
				return 'Date should not be less than current date.';
			}
		}else{
			return 'Please select start date.';
		}
	}
	
	/** 
    @function:validEndDate 
    @description:This function is used to check validation on date
    */ 
	public function validEndDate($fields = null){ 
		if(!empty($fields['end_date'])) {
			$start_dat = strtotime($this->data['Event']['start_date']);
			$end_date = strtotime($fields['end_date']);
			if($end_date > $start_dat){
				return true;		
			}else{
				return 'End date should be greater than start date.';
			}
		}else{
			return 'Please select end date.';
		}
	}

}
?>