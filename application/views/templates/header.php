<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>

	

	<!-- editor -->
	<link rel="stylesheet" href="<?php echo base_url();?>static/css/reset.css"> 
	<link rel="stylesheet" href="<?php echo base_url();?>static/css/style.css"> 
	<link rel="stylesheet" href="<?php echo base_url();?>static/css/user-page.css"> 
	<!-- editor end -->
	
	<script src="<?php echo base_url();?>static/js/jquery1.9.1.min.js"></script>
	<script src="<?php echo base_url();?>static/js/modernizr.js"></script> <!-- Modernizr -->
	<title>Da Pao</title>

	<!-- 样式文件 -->
	<link rel="stylesheet" href="<?php echo base_url();?>static/editor/themes/default/_css/umeditor.css">
	<!-- 引用jquery -->
	<script type="text/javascript" src="<?php echo base_url();?>static/editor/third-party/jquery.min.js"></script>
	<!-- 配置文件 -->
	<script type="text/javascript" src="<?php echo base_url();?>static/editor/umeditor.config.js"></script>
	<!-- 编辑器源码文件 -->
	<script type="text/javascript" src="<?php echo base_url();?>static/editor/_examples/editor_api.js"></script>
	<!-- 语言包文件 -->
	<script type="text/javascript" src=".<?php echo base_url();?>static/editor/lang/zh-cn/zh-cn.js"></script>
	<!-- 实例化编辑器代码 -->
	<style type="text/css">
        h1{
            font-family: "微软雅黑";
            font-weight: normal;
        }
        .btn {
            display: inline-block;
            *display: inline;
            padding: 4px 12px;
            margin-bottom: 0;
            *margin-left: .3em;
            font-size: 14px;
            line-height: 20px;
            color: #333333;
            text-align: center;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
            vertical-align: middle;
            cursor: pointer;
            background-color: #f5f5f5;
            *background-color: #e6e6e6;
            background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
            background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
            background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
            background-repeat: repeat-x;
            border: 1px solid #cccccc;
            *border: 0;
            border-color: #e6e6e6 #e6e6e6 #bfbfbf;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            border-bottom-color: #b3b3b3;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            *zoom: 1;
            -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
            -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn:hover,
        .btn:focus,
        .btn:active,
        .btn.active,
        .btn.disabled,
        .btn[disabled] {
            color: #333333;
            background-color: #e6e6e6;
            *background-color: #d9d9d9;
        }

        .btn:active,
        .btn.active {
            background-color: #cccccc \9;
        }

        .btn:first-child {
            *margin-left: 0;
        }

        .btn:hover,
        .btn:focus {
            color: #333333;
            text-decoration: none;
            background-position: 0 -15px;
            -webkit-transition: background-position 0.1s linear;
            -moz-transition: background-position 0.1s linear;
            -o-transition: background-position 0.1s linear;
            transition: background-position 0.1s linear;
        }

        .btn:focus {
            outline: thin dotted #333;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        .btn.active,
        .btn:active {
            background-image: none;
            outline: 0;
            -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
            -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn.disabled,
        .btn[disabled] {
            cursor: default;
            background-image: none;
            opacity: 0.65;
            filter: alpha(opacity=65);
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }
    </style>
</head>
<body>
	
    <!--Luara js文件-->
    
	<header role="banner">   <!-- <img src="<?php echo base_url();?>static/img/cd-logo.svg" alt="Logo"> -->
		<div id="cd-logo">
			<?php if ($this->session->userdata('login')) { 
				echo anchor('login_home', img(base_url() . 'static/img/cd-logo.svg?>'));
			} else {
				echo anchor('home', img(base_url() . 'static/img/cd-logo.svg?>'));
			}
			?>

		</div>

		<?php 
		if ($this->session->userdata('login')) { ?>
		<!-- after logged in -->
		<nav class="auth-nav">
			<ul>
				<!-- inser more links here -->
				<li><div class="show-uname"><?php echo $this->session->userdata('uname'); ?></div></li>
				<li><div class="cd-signup" style="font-weight: bold;"><?php echo anchor('user/logout', 'Logout'); ?></div></li>
			</ul>
		</nav>
		
		<!-- not yet logged in -->
		<?php } else { ?>
		<nav class="main-nav">
			<ul>
				<!-- inser more links here -->
				<li><a class="cd-signin" href="#">Sign in</a></li>
				<li><a class="cd-signup" href="#">Sign up</a></li>
			</ul>
		</nav>
		<?php } ?>


	</header>

	<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#">Sign in</a></li>
				<li><a href="#">New account</a></li>
			</ul>

			<div id="cd-login"> <!-- log in form -->
				<?php echo form_open('user/login', array('method' => 'post', 'class' => 'cd-form', 'id' => 'the-login-form', 'onsubmit' => 'return check_pw();')); ?>
					<p class="fieldset">
						<label class="image-replace cd-email" for="signin-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail" name="uemail">
						<span class="cd-error-message" id="email-error-message">Email format error!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" id="signin-password" type="password"  placeholder="Password" name="upw">
						<a href="#0" class="hide-password">Hide</a>
						<span class="cd-error-message" id="pw-error-message">Password error!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="remember-me" checked>
						<label for="remember-me">Remember me</label>
						<span class="loading" style="margin-left:20px; position:relative; top: 3px"><img src="<?php echo base_url();?>static/img/loading.gif" alt="Ajax Indicator" /></span>
					</p>

					<p class="fieldset">
						<input class="full-width" type="submit" value="Sign In" id="login-submit-bn">
					</p>
				</form>
				
				<p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-login -->

			<div id="cd-signup"> <!-- sign up form -->
				<?php echo form_open('user/reg', array('method' => 'post', 'class' => 'cd-form', 'onsubmit' => 'return check_signup();')); ?>
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-username">Username</label>
						<input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username" name="uname">
						<span class="cd-error-message" id="sname-err-message">User must between 5 to 32 letters!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail" name="uemail">
						<span class="cd-error-message" id="semail-err-message">Email format error!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password" name="upw">
						<a href="#0" class="hide-password">Hide</a>
						<span class="cd-error-message" id="spw-err-message">Password must between 5 to 32 letters!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-repassword">Re-enter Password</label>
						<input class="full-width has-padding has-border" id="signup-repassword" type="text"  placeholder="Re-enter Password" name="upwconf">
						<a href="#0" class="hide-password">Hide</a>
						<span class="cd-error-message" id="spwconf-err-message">Password doesn't match!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="accept-terms">
						<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
						<span class="loading" style="margin-left:20px; position:relative; top: 3px"><img src="<?php echo base_url();?>static/img/loading.gif" alt="Ajax Indicator" /></span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Create account" id="sinup-submit">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Reset password">
					</p>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div> <!-- cd-user-modal -->

	<div class="main-content">
