  $(document).ready(function() {		
  $('#buttonsend').click( function() {
	
		var name    = $('#name').val();
		var subject = $('#subject').val();
		var email   = $('#email').val();
		var message = $('#message').val();
		
		$('.loading').fadeIn('fast');
		
		if (name != "" && subject != "" && email != "" && message != "")
			{

				$.ajax(
					{
						url: './sendemail.php',
						type: 'POST',
						data: "name=" + name + "&subject=" + subject + "&email=" + email + "&message=" + message,
						success: function(result) 
						{
							$('.loading').fadeOut('fast');
							if(result == "email_error") {
								$('#email').css({"border":"1px solid #FF8C8C"}).next('.require').text(' !');
							} else {
								$('#name, #subject, #email, #message').val("");
								$('<div class="success">Your message has been sent successfully. Thank you! </div>').insertBefore('#maincontactform');
								$('.success').fadeOut(5000, function(){ $(this).remove(); });
							}
						}
					}
				);
				return false;
				
			} 
		else 
			{
				$('.loading').fadeOut('fast');
				if( name == "") $('#name').css({"background":"#FFFCFC","border":"1px solid #FFD1D1"}).next('.require').text(' !');
				if(subject == "") $('#subject').css({"background":"#FFFCFC","border":"1px solid #FFD1D1"}).next('.require').text(' !');
				if(email == "" ) $('#email').css({"background":"#FFFCFC","border":"1px solid #FFD1D1"}).next('.require').text(' !');
				if(message == "") $('#message').css({"background":"#FFFCFC","border":"1px solid #FFD1D1"}).next('.require').text(' !');
				return false;
			}
	});
	
		$('#name, #subject, #email,#message').focus(function(){
			$(this).css({"background":"#ffffff","border":"1px solid #dcdcdc"}).next('.require').text(' *');
		});
      	
		});