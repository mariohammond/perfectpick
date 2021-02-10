<?php
session_start();
$_SESSION['ref'] = $_SERVER['PHP_SELF'];
$_SESSION['query'] = $_SERVER['QUERY_STRING'];

if (isset($_COOKIE['connect_id']) || isset($_COOKIE['email'])) : ?>
<script>
$(document).ready(function(e) {
	$(".modalContainer").hide();
	$("#modal_trigger").hide();
	$(".sign-out").show();
	$("#register").show();
});
	
$(window).resize(function() {
	$(".modalContainer").hide();
	$("#modal_trigger").hide();
	$(".sign-out").show();
	$("#register").show();
});
</script>
<?php endif; ?>

<div class="HeaderContainer right">
    <ul class="header-content">
        <li class="menu-button left">
            <a data-category="pp-header" data-action="menu-button" data-label="open"><img class="menu" src="images/menu.png"/></a>
            <a data-category="pp-header" data-action="menu-button" data-label="open"><img class="menu-rollover" src="images/menu-rollover.png" style="display:none;"/></a>
        </li>
        <li class="banner-image left">
             <a href="http://play.perfectpickem.com" data-category="pp-header" data-action="button" data-label="home"><img class="header-logo-full" src="images/banner.png"/></a>
        </li>
        <li class="sign-in-button right">
            <a id="modal_trigger" href="#sign-in" data-category="pp-header" data-action="button" data-label="sign-in"><h1>Sign In</h1></a>
            <a class="sign-out" href="/logout" data-category="pp-header" data-action="button" data-label="sign-out" style="display:none;"><h1>Sign Out</h1></a>
        </li>
        <li class="social-buttons right">
        	<a class="facebook-follow" href="https://www.facebook.com/perfectpickem" target="_blank" data-category="pp-social" data-action="follow" data-label="facebook" title="Follow Us On Facebook"><span class="fa fa-facebook"></span></a>
            <a class="twitter-follow" href="http://www.twitter.com/perfectpickem" target="_blank" data-category="pp-social" data-action="follow" data-label="twitter" title="Follow Us On Twitter"><span class="fa fa-twitter"></span></a>
            <a class="google-follow" href="http://www.google.com/+Perfectpickem1/posts" target="_blank" data-category="pp-social" data-action="follow" data-label="google" title="Follow Us On Google+"><span class="fa fa-google-plus"></span></a>
        </li>
    </ul>
</div>

<?php if(isset($_GET['login']) || isset($_GET['register'])) : ?>
<div class="loginMessage">
	<?php if(isset($_GET['login']) && $_GET['login'] == 'false') : ?>
        <label class="errorMessage">Invalid email/password combination.</label><br/>
    <?php endif; ?>
    
    <?php if(isset($_GET['login']) && $_GET['login'] == 'locked') : ?>
        <label class="errorMessage">Too many invalid attempts. Account is locked for 15 minutes.</label><br/>
    <?php endif; ?>
    
    <?php if(isset($_GET['register']) && $_GET['register'] == 'duplicate') : ?>
        <label class="errorMessage">An account with this email address already exists.</label><br/>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="modalContainer">
	<div id="sign-in" class="popupContainer" style="display:none;">
		<header class="popupHeader">
			<span class="header_title">Sign In / Register</span>
			<span class="modal_close"><i class="fa fa-times"></i></span>
		</header>
		
		<section class="popupBody">
			<!-- Social Login -->
			<div class="social_login">
				<div>
					<a href="http://play.perfectpickem.com/connect/facebook" class="social_box fb" data-category="pp-header" data-action="social-connect" data-label="facebook">
						<span class="icon"><i class="fa fa-facebook"></i></span>
						<span class="icon_title">Connect with Facebook</span>
					</a>
                    <a href="http://play.perfectpickem.com/connect/twitter" class="social_box twitter" data-category="pp-header" data-action="social-connect" data-label="twitter">
						<span class="icon"><i class="fa fa-twitter"></i></span>
						<span class="icon_title">Connect with Twitter</span>
					</a>
                    <a href="http://play.perfectpickem.com/connect/google" class="social_box google" data-category="pp-header" data-action="social-connect" data-label="google">
						<span class="icon"><i class="fa fa-google-plus"></i></span>
						<span class="icon_title">Connect with Google</span>
					</a>
				</div>

				<div class="centeredText">
					<span>Or use your Email address</span>
				</div>

				<div class="action_btns">
					<div class="one_half"><a href="#" id="login_form" class="btn" data-category="pp-header" data-action="email-connect" data-label="sign-in">Sign In</a></div>
					<div class="one_half last"><a href="#" id="register_form" class="btn" data-category="pp-header" data-action="email-connect" data-label="register">Register</a></div>
				</div>
			</div>

			<!-- Username & Password Login form -->
			<div class="user_login">
				<form action="util/process-login.php" method="post">
					<label for="email">Email</label>
					<input type="text" name="email" />
					<br/>

					<label for="password">Password</label>
					<input type="password" name="password" id="password" />
					<br/>

					<!--<div class="checkbox">
						<input id="remember" type="checkbox" />
						<label for="remember">Remember me on this computer</label>
					</div>-->

					<div class="action_btns">
						<div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
						<div class="one_half last">
                        	<input type="button" id="signin" class="btn btn_red" value="Sign In" onClick="createHash(this.form, this.form.password);" />
                        	<!--<a href="#" class="btn btn_red">Login</a>-->
                        </div>
					</div>
				</form>

				<a href="#" class="forgot_password" data-category="pp-header" data-action="email-connect" data-label="lost-password">Forgot password?</a>
			</div>

			<!-- Register Form -->
			<div class="user_register">
				<form method="post">
					<label for="email">Email Address</label>
					<input type="email" name="email" id="email" />
					<br/>

					<label for="password">Password</label>
					<input type="password" name="password" id="password" />
					<br/>
                    
                    <label for="confirmpwd">Confirm Password</label>
					<input type="password" name="confirmpwd" id="confirmpwd" />
					<br/>

					<div class="action_btns">
						<div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
						<div class="one_half last">
                        	<input type="button" id="register" class="btn btn_red" value="Register" onClick="checkRegistration(form, email, password, confirmpwd)" />
                      	</div>
					</div>
				</form>
			</div>
            
            <!-- Lost Password form -->
			<div class="lost_password">
				<form method="post">
                	<label>Enter your email address to reset your password. A temporary password will be emailed to you.</label><br/>
                    
					<label for="email">Email</label>
					<input type="email" name="email" id="email" />
					<br/>

					<div class="action_btns">
                    	<div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
						<div class="one_half last">
                        	<input type="button" id="register" class="btn btn_red" value="Reset" onClick="resetPassword(form, email)" />
                        </div>
					</div>
				</form>
			</div>
		</section>
	</div>
    <div id="register" class="popupContainer" style="display:none;">
		<header class="popupHeader">
			<span class="header_title">Register</span>
			<span class="modal_close"><i class="fa fa-times"></i></span>
		</header>
		
		<section class="popupBody">
        	<div class="user_register">
				<form>
					<label>First Name</label>
					<input type="text" />
					<br />
                    
                    <label>Last Name</label>
					<input type="text" />
					<br />

					<label>Email Address</label>
					<input type="email" />
					<br />

					<label>Password</label>
					<input type="password" />
					<br />

					<div class="action_btns">
						<div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
						<div class="one_half last"><a href="#" class="btn btn_red" data-category="pp-header" data-action="email-connect" data-label="register">Register</a></div>
					</div>
				</form>
			</div>
       	</section>
    </div>
</div>

<script type="text/javascript">
$("#modal_trigger").leanModal({top : 60, overlay : 0.6, closeButton: ".modal_close" });
$("#modal_trigger_menu").leanModal({top : 60, overlay : 0.6, closeButton: ".modal_close" });

$(function(){ 
	// Calling Login Form
	$("#modal_trigger").click(function(){
		$(".lost_password").hide();
		return false;
	});
		
	// Calling Login Form
	$("#login_form").click(function(){
		$(".social_login").hide();
		$(".user_login").show();
		$(".lost_password").hide();
		return false;
	});

	// Calling Register Form
	$("#register_form").click(function(){
		$(".social_login").hide();
		$(".user_register").show();
		$(".header_title").text('Register');
		$(".lost_password").hide();
		return false;
	});

	// Going back to Social Forms
	$(".back_btn").click(function(){
		$(".user_login").hide();
		$(".user_register").hide();
		$(".social_login").show();
		$(".header_title").text('Sign In / Register');
		$(".lost_password").hide();
		return false;
	});
	
	// Calling Lost Password Form
	$(".forgot_password").click(function(){
		$(".user_login").hide();
		$(".lost_password").show();
		$(".header_title").text('Reset Password');
		return false;
	});

})
</script>
