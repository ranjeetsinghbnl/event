<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h3><?php echo __('Add Event'); ?></h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8 col-xs-12 col-sm-12 col-lg-8">
		<?php 
			echo $this->Form->create('Event',array(
				'inputDefaults' => array(
					'div' => array('class' => 'form-group')
				),
				'id' => 'event_form'
			));
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('ticket_info',array('id' => 'ticket_info'));
			echo $this->Form->input('name',array('id' => 'name','class' => 'form-control','placeholder' => 'Enter Event Name'));
			echo $this->Form->input('description',array('id' => 'description','class' => 'form-control','placeholder' => 'Enter Event Description'));
			echo $this->Form->input('start_date',array('id' => 'start_date','type' => 'text','class' => 'form-control','div' => array('class' => 'col-md-5 col-xs-5 col-sm-12 col-lg-5 form-group'),'placeholder' => 'Choose Event Start Date'));
			echo $this->Form->input('end_date',array('id' => 'end_date','type' => 'text','class' => 'form-control','div' => array('class' => 'col-md-5 col-xs-5 col-sm-12 col-lg-5 form-group'),'placeholder' => 'Choose Event End Date'));
			?>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
				<button type="button" class="btn btn-primary" id="add_ticket"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Ticket</button>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 ticket_listing_wrap">
				<table class="table table-bordered table-striped" id="ticket_table">
					<caption><div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">Event Ticket(s)</div></caption>
					<thead>
						<tr>
							<th align="center" width="10%">ID</th>
							<th align="center" width="25%" >Ticket No</th>
							<th align="center" width="25%">Price</th>
							<th align="center" width="40%">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr id="ticket_input_row" class="hide">
							<td><input type="text" class="form-control" id="ticket_id" name="ticket_id" readonly="" /></td>
							<td><input type="text" class="form-control" id="ticket_no" name="ticket_no" readonly="" /></td>
							<td><input type="number" class="form-control" id="price" name="price" /></td>
							<td>
								<button type="button" class="btn btn-primary" id="save_ticket">Save</button>
								&nbsp;&nbsp;&nbsp;
								<button type="button" class="btn btn-primary" id="cancel_ticket">Cancel</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
				<h4>Total Tickets:&nbsp;<b><span class="total_tickets">0</span></b></h4>
			</div>
			<?php
			echo $this->Form->input('organiser',array('id' => 'organiser','class' => 'form-control','placeholder' => 'Enter Event Organiser'));
			?>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
				&nbsp;
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 hide" id="form_erros">
				
			</div>
			<?php
			$options = array(
				'class' => 'btn btn-success',
				'label' => 'Save Event',
				'name' => 'Save Event',	
				'id' => 'add_event',
				'type' => 'button',
				'div' => array('class' => 'col-md-3 col-xs-5 col-sm-12 col-lg-3')
			);
			echo $this->Form->end($options);
		?>
	</div>
</div>
<style type="text/css">
.ticket_listing_wrap{
	height:350px;
	min-height:350px;
	overflow:hidden;
	overflow-y:scroll;
	border:1px solid #d3d3d3
}
#form_erros{
	border:1px solid #990000;
	background-color:#FFB3B3;
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	color:#FF0000;
}
</style>
<script type="text/javascript">
	/*
	Script for handling events and their tickets.
	*/
	var ticket_code = '004S'; // Ticket prefix number
	var ticket_input = $('#ticket_input_row');
	var event_tickets = {};
	event_tickets['Ticket'] = [];
	//console.log(event_tickets.Ticket);
	$(document).ready(function(){
		
		// on submit form
		$('#event_form').submit(function(ev){
			//ev.preventDefault();
			if(event_tickets.Ticket.length <= 0) {
				alert('Please add ticket(s) to the event.');
				return false;
			}
			$('#ticket_info').val(JSON.stringify(event_tickets.Ticket));
			//$(this).submit();
			//return false;
		});
		
		$('#add_event').click(function(){
			var cObj = $(this);
			if(event_tickets.Ticket.length <= 0) {
				alert('Please add ticket(s) to the event.');
				return false;
			}
			$('#ticket_info').val(JSON.stringify(event_tickets.Ticket));
			$('.error-message').remove();
			$('#form_erros').html('');
			$.ajax({
					type: "POST",
					dataType: "json",
					url: "<?php echo $this->Html->url(array('action' => 'add_event'));?>",
					data: $('#event_form').serializeArray(),
					success: function(result){
						if(result.valid == true) {
							window.location.reload(true);
						}else{
							if(result.err_msg) {
								var errMsgArr = result.err_msg;
								// setting form errors.
								$(errMsgArr).each(function(key,val){
									var err_temp = '<div class="error-message">'+val.msg+'</div>';
									if(val.node == 'form_erros') {
										$('#'+val.node).removeClass('hide');	
									}
									$('#'+val.node).after(err_temp);
								});
							}
						}
					},
					error: function(a,b,c) {
						$('input').prop('disabled','');
						cObj.val('Save Event');
					},
					beforeSend: function() {
						$('input').prop('disabled','disabled');
						cObj.val('Saving...');
					},
					complete: function() {
						$('input').prop('disabled','');
						cObj.val('Save Event');
					}
			});
		});
		var today_date = '<?php echo date('Y-m-d')?>';
		// Datepicker code
		$.datepicker.setDefaults({
			dateFormat:"yy-mm-dd",
			minDate: today_date,
		});
		$( "#start_date" ).datepicker({
			onClose: function( selectedDate ) {
				$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end_date" ).datepicker({
			onClose: function( selectedDate ) {
				$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
			}	
		});
		// End of datepicker
		
		// Add ticket handler.
		$('#add_ticket').click(function(){
			if(ticket_input.prop('class') == 'hide'){
				ticket_input.prop('class','');
				setTicketId();
				setTicketNo();
			}else{
				ticket_input.prop('class','hide');
				reset_ticket_input();
			}
		});
		
		// save ticket for event(handler)
		$('#save_ticket').click(function(){
			insert_ticket();
		});
		// cancel adding ticket and reset inputs
		$('#cancel_ticket').click(function(){
			ticket_input.prop('class','hide');
			reset_ticket_input();
		});
		// delete ticket and remove correspondinf node from ticker array.
		$(document).on('click','.del_ticket',function(){
			///del_ticket($(this));
			//alert()
			var cnf = confirm('Are your sure you want to delete?');
			if(cnf == true) {
				var close_tr = $(this).closest('tr');
				del_ticket(close_tr.prop('id'));
				close_tr.fadeOut(function(){
					$(this).remove();
				});
			}
		});
		// cancel editing ticket and reset input values to original values
		$(document).on('click','.cancel_edit_ticket',function(){
			var close_tr = $(this).closest('tr');
			close_tr.find('.form-control').each(function(){
				var val_input = $(this).prev('span').prop('value');
				//console.log($(this).prev('span'));
				$(this).prop('value',val_input);
			});
			close_tr.find('.text').toggleClass('hide');
			close_tr.find('.form-control').toggleClass('hide');
			close_tr.find('button').toggleClass('hide');
		});
		// toggle inline-edit for ticket.
		$(document).on('click','.edit_ticket',function(){
			var close_tr = $(this).closest('tr');
			close_tr.find('.text').each(function(){
				var val_input = $(this).prop('value');
				$(this).next('input').prop('value',val_input);
			});
			close_tr.find('.text').toggleClass('hide');
			close_tr.find('.form-control').toggleClass('hide');
			close_tr.find('button').toggleClass('hide');
		});
		// update ticket and reset inputs
		$(document).on('click','.update_ticket',function(){
			var close_tr = $(this).closest('tr');
			var error = false;
			$('.error').remove();
			// validating all inputs
			close_tr.find('.form-control').each(function(){
				var val_input = $(this).val();
				var name = $(this).prop('name');
				
				if(isDefine(val_input)) {
					// validate ticket no.
					if(name == 'ticket_no') {
						if(!isValidTicketNo(val_input)) {
							var error_html = '<span class="error"><p class="text-danger">Please enter a valid No.</p></span>';
							$(this).after(error_html);
							error = true;
						}
					}// validate ticket price
					else if(name == 'price') {
						if(!isValidTicketPrice(val_input)) {
							var error_html = '<span class="error"><p class="text-danger">Please enter a valid Price. For ex(12.25)</p></span>';
							$(this).after(error_html);
							error = true;
						}else{
							//val_input = roundToTwo(val_input);
						}
					}
				}else{
					error = true;
				}
			});
				
			if(error == false) {
				close_tr.find('.text').each(function(){
					var val_input = $(this).next('input').prop('value');
					var name = $(this).next('input').prop('name');
					if(name == 'price') {
						val_input = roundToTwo(val_input);
					}
					$(this).prop('value',val_input);
					$(this).text(val_input);
				});
				close_tr.find('.text').toggleClass('hide');
				close_tr.find('.form-control').toggleClass('hide');
				close_tr.find('button').toggleClass('hide');
			}	
		});
	});
	
	/*
	Name:insert_ticket
	Desc: function for inserting ticket
	*/
	function insert_ticket(){
		var temp_arr = {};
		var tr_template = '';
		var error = false;
		$('.error').remove();
		ticket_input.find('input').each(function(){
			var name = $(this).prop('name');
			var type = $(this).prop('type');
			var val = $(this).val();
			// Used function are define in common.js file
			if(isDefine(val)) {
				// validate ticket no.
				if(name == 'ticket_no') {
					if(!isValidTicketNo(val)) {
						var error_html = '<span class="error"><p class="text-danger">Please enter a valid No.</p></span>';
						$(this).after(error_html);
						error = true;
					}
				}// validate ticket price
				else if(name == 'price') {
					if(!isValidTicketPrice(val)) {
						var error_html = '<span class="error"><p class="text-danger">Please enter a valid Price. For ex(12.25)</p></span>';
						$(this).after(error_html);
						error = true;
					}else{
						val = roundToTwo(val);
					}
				}
			}else{
				error = true;
			}
			temp_arr[name] = val;
			var readonly = '';
			if(name == 'ticket_id' || name == 'ticket_no') {
				readonly = 'readonly=""';
			}
			tr_template += '<td>'+
								'<span class="text" value="'+val+'">'+val+'</span>'+
								'<input type="'+type+'" name="'+name+'" class="form-control hide" '+readonly+' value="'+val+'" />'+
							'</td>';
		});
		// if their is not any error add ticket
		if(error == false) { 
			tr_template += '<td>'+
								'<button type="button" class="btn btn-primary edit_ticket">Edit</button>'+
								'<button type="button" class="btn btn-primary update_ticket hide">Update</button>'+
								'&nbsp;&nbsp;&nbsp;'+
								'<button type="button" class="btn btn-primary del_ticket">Delete</button>'+
								'<button type="button" class="btn btn-primary cancel_edit_ticket hide">Cancel</button>'+
							'</td>';
			var tct_len = getTotalTicket(); // get total ticker length
			var row_id = "row-"+tct_len;
			var push_arr = {[row_id]:temp_arr};
			event_tickets.Ticket.push(push_arr);
			tr_template = '<tr id="'+row_id+'">'+tr_template+'</tr>'; 
			$('#ticket_table').find('tbody').append(tr_template);
			$('.total_tickets').text(getTotalTicket());
			setTimeout(function(){
					$('#cancel_ticket').click();
				}
				,10
			);
		}
		//console.log(event_tickets);
	}
	/*
	Name:del_ticket
	Desc: function for delete ticket node from ticket array
	*/
	function del_ticket(del_node){
		//event_tickets.Ticket[del_node] = null;
		//delete event_tickets.Ticket[del_node]; 
		event_tickets.Ticket.splice(del_node,1);
		console.log(event_tickets.Ticket);
		console.log('len='+getTotalTicket());
		console.log('del_node='+del_node);
		$('.total_tickets').text(getTotalTicket());
	}
	/*
	Name:getTotalTicket
	Desc: function for couting ticket node from ticket array
	*/
	function getTotalTicket(){
		return event_tickets.Ticket.length;
	}
	/*
	Name:setTicketId
	Desc: function for setting ticket id
	*/
	function setTicketId(){
		var tck_len = $('#ticket_table').find('tbody tr').length;
		$('#ticket_id').val(tck_len);
	}
	/*
	Name:setTicketNo
	Desc: function for setting ticket number. This will be auto generated depend upon starting code.
	*/
	function setTicketNo(){
		var tck_len = $('#ticket_table').find('tbody tr').length;
		$('#ticket_no').val(ticket_code+tck_len);
	}
	/*
	Name:reset_ticket_input
	Desc: function for reseting ticket input fields
	*/
	function reset_ticket_input(){
		ticket_input.find('input').val('');
	}
</script>