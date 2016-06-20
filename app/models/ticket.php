<?php
class Ticket extends AppModel{
	var $name = 'Ticket';
	var $belongsTo = array('Event');
	
	var $validate = array(
		'ticket_no' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter ticket number.'
		),
		'price' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter ticket price.'
		)
	);
}
?>