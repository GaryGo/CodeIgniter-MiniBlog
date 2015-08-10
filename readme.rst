In main.js and add-post.php, there is hard code of path in $.ajax. Care about it.

Controllers: 

Article: 	index ---- post edit page (has view)
			add ------ add a post, redirect to user_index page using $.ajax in success function.

Home:	root of the website (not login)

Login_home:		index --- user_index (login)

Signup_alert:    let people know to check email for activation.

User:			reg: registration, redirect to signup-alert
				Index:  home
				User-index:  Login-home
				login:			Login-home
				check-email-exist
				check_pw
				activate:  redirect to login_home



hard code: in edit_post.php(72)