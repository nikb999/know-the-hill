<?PHP
require_once("./include/membersite_config.php");
//set the timezone
date_default_timezone_set("America/New_York");
//create a variable if the user is already logged in.
$alreadyloggedin=1;
if(!$hill_func->CheckLogin())
{
    $alreadyloggedin=0;
    //exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
   
	<!-- SITE HEADER -->
    <div id="hd_sty">
        <head>       
            <meta charset="utf-8" />       
            <title>Know the HILL</title>    
            <link rel="stylesheet" type="text/css" href="./style/hillcss.css" />
            <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
      </head>    
    </div>

	<img src="images/knowthehill_hires.gif" alt="Know the Hill" width="400" height="50" />
	
<div id="blk1_sty">	
	<?php
		// block for the navigation bar
		// check to see if the user is already logged on.
		// if user is not logged on then set the svalid = 0.
		//session_start();	
					
		if($alreadyloggedin==1)
			{
			//define the heading blocks if the user is logged in.
			echo '<ul>';
			echo '<li> <a href="hill_start.php">Home</a> </li>';	
			echo '<li> <a href="hill_aboutus.php">About us</a> </li>';
			echo '<li> <a href="hill_articles.php">Debate Issues</a> </li>';
			echo '<li> <a href="hill_query_start.php">HillQuery</a> </li>';
			//echo '<li> <a href="test.php">TEST</a> </li>';
			echo '</ul>';
			}
		else
	    	{
			//define the three heading blocks if the user is not already logged in.
			echo '<ul>';
			echo '<li> <a href="hill_start.php">Home</a> </li>';
			echo '<li> </li>';	
			echo '<li> <a href="hill_login.php">Login</a> </li>';	
			echo '<li> <a href="hill_register.php">Register</a> </li>';
			//echo '<li> <a href="confirmreg.php">Confirm Registration</a> </li>';
			echo '<li> <a href="hill_aboutus.php">About us</a> </li>';
			echo '<li> <a href="hill_articles.php">Debate Issues</a> </li>';
			echo '<li> <a href="hill_query_start.php">HillQuery</a> </li>';
			//echo '<li> <a href="test.php">TEST</a> </li>';
			echo '</ul>';
	    	}	
	    	
	    if(!$hill_func->CheckLogin()) 
		{
			echo "";
			//echo '<hr><p>No User not logged in '.$alreadyloggedin.'</p>';
		}
		else
		{
			echo '<hr>';
			echo '<ul>';
			echo '<li>User: '.$hill_func->UserFullName().'</li>';
			echo '<li> <a href="hill_logout.php">Logout</a> </li>';
			echo '<li> <a href="hill_change-pwd.php">Change Password</a> </li>';
			if (strtoupper($hill_func->UserType())=="ADMIN")
				{
				echo '<li> <a href="test.php">TEST</a> </li>';
				echo '<li> <a href="hill_admin.php">AdminPage</a> </li>';
				}
			elseif (strtoupper($hill_func->UserType())=="BASIC")
				{
				echo '<li> <a href="hill_membership_upgrade.php">Upgrade Membership</a> </li>';
				}			
			elseif (strtoupper($hill_func->UserType())=="PREMIER")
				{
				echo '<li> <a href="hill_membership_unsubscribe.php">Unsubscribe</a> </li>';
				}			
			echo '</ul>';
		}

	?>

</div>
    
    <body>       

		<!-- Script for the Facebook Like button - start -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<!-- Script for the Facebook Like button - end -->

 
	<!-- Rest of the main document goes here -->
 
 
