jQuery(document).ready(function($){
	var $form_modal = $('.cd-user-modal'),
		$form_login = $form_modal.find('#cd-login'),
		$form_signup = $form_modal.find('#cd-signup'),
		$form_forgot_password = $form_modal.find('#cd-reset-password'),
		$form_modal_tab = $('.cd-switcher'),
		$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
		$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
		$forgot_password_link = $form_login.find('.cd-form-bottom-message a'),
		$back_to_login_link = $form_forgot_password.find('.cd-form-bottom-message a'),
		$main_nav = $('.main-nav');
		$login_email_check = false;;
		$login_password_check = false;
		// $signup_email_check = false;
		// $signup_password_check = false;
		// $signup_pconf_check = false;
		// $signup_username_check = false;
		$('.loading').hide();

	//open modal

	$main_nav.on('click', function(event){

		if( $(event.target).is($main_nav) ) {
			// on mobile open the submenu
			$(this).children('ul').toggleClass('is-visible');
		} else {
			// on mobile close submenu
			$main_nav.children('ul').removeClass('is-visible');
			//show modal layer
			$form_modal.addClass('is-visible');	
			//show the selected form
			( $(event.target).is('.cd-signup') ) ? signup_selected() : login_selected();
		}

	});

	//close modal
	$('.cd-user-modal').on('click', function(event){
		if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
			$form_modal.removeClass('is-visible');
		}	
	});
	//close modal when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$form_modal.removeClass('is-visible');
	    }
    });

	//switch from a tab to another
	$form_modal_tab.on('click', function(event) {
		event.preventDefault();
		( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
	});

	//hide or show password
	$('.hide-password').on('click', function(){
		var $this= $(this),
			$password_field = $this.prev('input');
		
		( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
		( 'Hide' == $this.text() ) ? $this.text('Show') : $this.text('Hide');
		//focus and move cursor to the end of input field
		$password_field.putCursorAtEnd();
	});

	//show forgot-password form 
	$forgot_password_link.on('click', function(event){
		event.preventDefault();
		forgot_password_selected();
	});

	//back to login from the forgot-password form
	$back_to_login_link.on('click', function(event){
		event.preventDefault();
		login_selected();
	});

	function login_selected(){
		$form_login.addClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.addClass('selected');
		$tab_signup.removeClass('selected');
	}

	function signup_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.addClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.removeClass('selected');
		$tab_signup.addClass('selected');
	}

	function forgot_password_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.addClass('is-selected');
	}



	$('#signin-email').bind('blur focus', function(event){
		
	    if(event.type === 'blur'){
	        var  	$this = $(this);
	        var v = $this.val();
	        v =  v.replace(/^\s+|\s+$/g, "");
	        //check email against regex
	        if (v.match(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i)) {
	            $('.loading').show();
	            $.ajax({
	            	url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/user/check_email_exist/',
	            	data: {'uemail' : v},
	            	type:"POST",
	            	dataType:"text",
	            	success: function(data) {
	            		$('.loading').hide();
		        	    if (data == "exist") {
		        	    	// alert("this email is good");
		        	    } 
		        	    else {
		        	    	$form_modal.find('#email-error-message').toggleClass('is-visible').html("Email not exists!");
		        	    }
	            	},
	            	error: function(e) {
	            		console.log(e.message);
	            	}
	            });  
	        }
	        else{
	        	$form_modal.find('#email-error-message').toggleClass('is-visible'); 
	        }
	        //replace email with trimmed version
	        $this.val(v);
	        return false;
	    }
	    //remove status styles while editing
	    if(event.type === 'focus'){
	    	$form_modal.find('#email-error-message').html("Email format error!");
	        $form_modal.find('#email-error-message').removeClass('is-visible');
	    }
	});




	$('#signup-email').bind('blur focus', function(event){
	    if(event.type === 'blur'){
	        //cache jquery objects
	        
	        var  	$this = $(this);

	        var v = $this.val();
	        // alert(v);
	        
	        //trim spaces
	        v =  v.replace(/^\s+|\s+$/g, "");

	        //check email against regex
	        if(v.match(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i)){

	        	$.ajax({
	            	url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/user/check_email_exist/',
	            	data: {'uemail' : v},
	            	type:"POST",
	            	// async: false,
	            	dataType:"text",
	            	success: function(data) {
	            		$('.loading').hide();
		        	    if (data == "exist") {
		        	    	// alert("this email is not good");
		        	    	$form_modal.find('#semail-err-message').toggleClass('is-visible').html("Account already exists!");
		        	    } else {
		        	    	// alert("this email is good");
		        	    	signup_email_check = true;
		        	    }
	            	},
	            	error: function(e) {
	            		console.log(e.message);
	            	}
	            });  

	        }
	        else{
	        	$form_modal.find('#semail-err-message').toggleClass('is-visible'); 
	        }
	        //replace email with trimmed version
	        $this.val(v);
	    }
	    //remove status styles while editing
	    if(event.type === 'focus'){
	    	$form_modal.find('#semail-err-message').html("Email format error!");
	        $form_modal.find('#semail-err-message').removeClass('is-visible');
	    }
	});
	
	$('#signup-username').bind('blur focus', function(event){
	    if(event.type === 'blur'){
	        //cache jquery objects
	        
	        var  	$this = $(this);

	        var v = $this.val();
	        
	        //trim spaces
	        v =  v.replace(/^\s+|\s+$/g, "");

	        //check email against regex
	        if(v.match(/^[0-9a-zA-Z_]{5,32}$/)){
				signup_username_check = true;
	        }
	        else{
	        	$form_modal.find('#sname-err-message').toggleClass('is-visible'); 
	        }
	        //replace email with trimmed version
	        $this.val(v);
	    }
	    //remove status styles while editing
	    if(event.type === 'focus'){
	        $form_modal.find('#sname-err-message').removeClass('is-visible');
	    }
	});

	$('#signup-password').bind('blur focus', function(event){
	    if(event.type === 'blur'){
	        //cache jquery objects
	        
	        var  	$this = $(this);

	        var v = $this.val();
	        
	        //trim spaces
	        v =  v.replace(/^\s+|\s+$/g, "");

	        //check email against regex
	        if(v.match(/^[0-9a-zA-Z_]{5,32}$/)){
	        	signup_password_check = true;
	        }
	        else{
	        	$form_modal.find('#spw-err-message').toggleClass('is-visible'); 
	        }
	        //replace email with trimmed version
	        $this.val(v);
	    }
	    //remove status styles while editing
	    if(event.type === 'focus'){
	        $form_modal.find('#spw-err-message').removeClass('is-visible');
	    }
	});


	$('#signup-repassword').bind('blur focus', function(event){
	    if(event.type === 'blur'){
	        //cache jquery objects
	        
	        var  	$this = $(this);

	        var v = $this.val();
	        
	        //trim spaces
	        v =  v.replace(/^\s+|\s+$/g, "");
	        var pw = $('#signup-password').val();

	        //check email against regex
	        if(pw === v){
	        	//do nothing
		        signup_pconf_check = true;
	        }
	        else{
	        	$form_modal.find('#spwconf-err-message').toggleClass('is-visible'); 
	        }
	        //replace email with trimmed version
	        $this.val(v);
	    }
	    //remove status styles while editing
	    if(event.type === 'focus'){
	        $form_modal.find('#spwconf-err-message').removeClass('is-visible');
	    }
	});


	//********************************************************************




	//REMOVE THIS - it's just to show error messages 
	// $form_login.find('input[type="submit"]').on('click', function(event){
	// 	event.preventDefault();
	// 	$form_login.find('input[type="email"]').toggleClass('has-error');
	// 	$form_login.find('input[type="password"]').toggleClass('has-error');
	// 	$form_login = $form_modal.find('#pw-error-message').toggleClass('is-visible');
	// 	$form_login = $form_modal.find('#email-error-message').toggleClass('is-visible');
	// });



	// $form_signup.find('input[type="submit"]').on('click', function(event){
	// 	event.preventDefault();
	// 	$form_signup.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
	// });


	//IE9 placeholder fallback
	//credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
		  	}
		}).blur(function() {
		 	var input = $(this);
		  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
		  	}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  	$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
			 		input.val('');
				}
		  	})
		});
	}

});

	
function check_pw() {
		$('.loading').show();
		var uemail = $('#signin-email').val();
		var upw = $('#signin-password').val();
		var go_or_not = false;

		$.ajax({
             
             url: 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/user/check_pw',
             async: false,
             type: "POST",
             data: {
             			'uemail': uemail,
             			'upw': upw
             		},
             success: function(data) {
             		$('.loading').hide();
		            // alert(data);
		            // alert(data);
		            // alert(data);
					if(!data) {
			        	$('.cd-user-modal').find('#pw-error-message').toggleClass('is-visible').html("Password is wrong!");

			        }
			        go_or_not = data;
             }
		});
		if(go_or_not) {
			return true;
		} else {	
			return false;
		}
	}

	
	function check_signup() {
		if (document.getElementById("accept-terms").checked) {
			if (signup_email_check && signup_password_check && signup_pconf_check && signup_username_check) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}

	



//credits http://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
jQuery.fn.putCursorAtEnd = function() {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = $(this).val().length * 2;
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
      		$(this).val($(this).val());
    	}
	});
};