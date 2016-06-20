<?php
class EventsController extends AppController {
	
	var $name = 'Events';
	var $components = array('RequestHandler');
	
	
	/*
	* Function: add_event
	* Details: Function to adding events and their associated tickets.
	* params: 
	* Return: 
	*/
	function add_event()
	{
		if($this->RequestHandler->isAjax()) {
			$return_arr = array('valid' => false,'err_msg' => array());
			if(!empty($this->data)) {
				$eventTickets = json_decode($this->data['Event']['ticket_info'],true);
				if(!empty($eventTickets)) {
					if($this->Event->save($this->data)) {
						$event_id = $this->Event->getLastInsertID();
						$this->Event->id = $event_id;
						$this->Event->saveField('order',$event_id);
						$this->LoadModel('Ticket');
						foreach($eventTickets as $t_key => $ticket) {
							if(isset($ticket['row-'.$t_key])) {
								$data_node = $ticket['row-'.$t_key];
								$tcktSavedArr = array(
									'Ticket' => array(
										'event_id' => $event_id,
										'ticket_no' => $data_node['ticket_no'],
										'price' => $data_node['price'],
										'order' => $t_key
									)
								);
								$this->Ticket->create();
								$this->Ticket->save($tcktSavedArr );	
							}
						}
						$return_arr['valid'] = true;
						$this->Session->setFlash(__('Event has been saved successfully.',true),'flash/success');		
					}else{
						foreach($this->Event->validationErrors as $key => $val) {
							$return_arr['err_msg'][] = array('node' => $key ,'msg' => $val);	
						}
					}
				}else{
					$return_arr['err_msg'] = array('node' => 'form_erros' ,'msg' => 'Please add ticket(s) for the event.');
				}
				echo json_encode($return_arr);die;
			}
		}
		$this->set('pageTitle','Add Event');
	}
}	
?>