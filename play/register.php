<?php
	include_once 'util/profile.inc.php';
	
	// Redirect to login page if not signed in
	if (!isset($_COOKIE['email']) && !isset($_COOKIE['connect_id'])) {
		header('Location: ./');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Profile | Perfect Pick'em</title>
    <link rel="shortcut icon" href="images/favicon.ico"/>
    <meta name="viewport" content="width=device-width", initial-scale=1"">     
    <link href='http://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Lean Modal Popup Box: Start -->
    <script type="text/javascript" src="js/lean-modal.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="css/lean-modal.css" />
    <!-- Lean Modal Popup Box: End -->
    
    <script type="text/javaScript" src="js/sha512.js"></script>
    <script type="text/javaScript" src="js/forms.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/desktop.css" type="text/css">
    <link rel="stylesheet" href="css/tablet.css" type="text/css">
    <link rel="stylesheet" href="css/mobile.css" type="text/css">
    
    <script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-58067202-1', 'auto');
	ga('require', 'displayfeatures');
	ga('send', 'pageview');
	</script>
</head>
<body>
	<div class="CreateAccountWrapper">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div class="AccountContainer Main">
        	<div class="cover-container"></div>
            <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" name="profile_form">		
                <table>
                	<caption>Create Profile</caption>
                    <tr>
                        <td><label for="firstname">First Name:</label></td>
                    	<td>
                            <input type="text" name="firstname" id="firstname" placeholder="Required" 
                            onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="lastname">Last Name:</label></td>
                        <td>
                            <input type="text" name="lastname" id="lastname" placeholder="Required" 
                            onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="photo">Profile Photo:</label></td>
                        <td><input type="file" name="photo"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <a data-category="pp-create-profile" data-action="button" data-label="submit"><input type="button" id="register" value="SUBMIT" onClick="checkFields(form, firstname, lastname)" /></a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php include 'footer.php'; ?>
	</div>
    <span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
</html>
