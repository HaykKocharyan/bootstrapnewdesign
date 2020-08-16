function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  
  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
function PaymentFormAjax(data) {
	$.ajax({
		url: "PaymentHandler.php",
		type: "POST",
		data: data,
	 	success: function(result){
	 		$('input.border-danger, select.border-danger').each(function() {
			  $(this).tooltip('dispose');
			});
	 		$('input.border-danger, select.border-danger').removeClass('border-danger');
    		var code = result.slice(0, 3);
    		if (code == 'SCS')	//SCS = success
    		{
    			$('#carouselExampleIndicators .carousel-item:last').after('<div class="carousel-item">\n'+result.slice(3)+'\n</div>');
    			$('#carouselExampleIndicators').carousel('next');
    		}
    		else if (code == 'ERR')
    		{
    			var errors = JSON.parse(result.slice(3));
    			var inputs = Object.keys(errors);
    			errors = Object.values(errors);
    			for(var i = 0; i < errors.length; i++){
    				var errorsToListItems = '';
    				for(var j = 0; j < errors[i].length; j++){
    					errorsToListItems += '<li style="font-size:12px;text-wrap:no-wrap;">'+errors[i][j]+'</li>';
    				}
    				errors[i] = errorsToListItems;
    			}
    			for(var i = 0; i < inputs.length; i++){
    				$('[name="'+inputs[i]+'"]').addClass('border-danger');
    				$('[name="'+inputs[i]+'"]').attr('title', '<ul style="padding-left:16px;margin-bottom:0;">'+errors[i]+'</ul>');
    				$('[name="'+inputs[i]+'"]').tooltip();
    				$('[name="'+inputs[i]+'"]').tooltip('show');
    			}
    		}
		}
	});
}




$(document).ready(function(){
	$("#paymentform_cardinfo").click(function() {
    	PaymentFormAjax("next=addressinfo&"+GetCardInfo());
	});
});


function GetCardInfo(){
	var cardNumber 	= 	$('input[name="cardnumber"]').val();
	var cardOwner 	= 	$('input[name="cardowner"]').val();
	var valDate 	= 	$('input[name="valdate"]').val();
	var cvv 		= 	$('input[name="cvv"]').val();
	return "cardnumber="+escapeHtml(cardNumber)+"&cardowner="+escapeHtml(cardOwner)+"&valdate="+escapeHtml(valDate)+"&cvv="+escapeHtml(cvv);
}
function GetAddressInfo(){
	var Fname 	= 	$('input[name="fname"]').val();
	var Lname 	= 	$('input[name="lname"]').val();
	var Email 	= 	$('input[name="email"]').val();
	var Phone 	= 	$('input[name="phone"]').val();
	var Country = 	$('select[name="country"] option:selected').val();
	var City 	= 	$('input[name="city"]').val();
	var Postal 	=	$('input[name="postalcode"]').val();
	var Address = 	$('input[name="address"]').val();
	return "fname="+escapeHtml(Fname)+"&lname="+escapeHtml(Lname)+"&email="+escapeHtml(Email)+
			"&phone="+escapeHtml(Phone)+"&country="+escapeHtml(Country)+"&city="+escapeHtml(City)+
			"&postalcode="+escapeHtml(Postal)+"&address="+escapeHtml(Address);
}