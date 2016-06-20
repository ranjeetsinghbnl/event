function isValidTicketPrice(t_price) {
	var new_val = $.trim(t_price);
	if( isNaN( parseFloat( new_val ) ) ){
		return false;
	}else{
		return parseFloat(new_val).toFixed(2);
	}
}

function isValidTicketNo(t_no) {
	var new_val = $.trim(t_no);
	if(new_val == '') {
		return false;	
	}else{
		return true;
	}
}

function isDefine(val) {
	if(typeof val != 'undefined') {
		return true	;
	}else{
		return false;	
	}	
}

function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}