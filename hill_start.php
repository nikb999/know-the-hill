<?PHP
	require_once("./include/membersite_config.php");
	//create a variable if the user is already logged in.
	$alreadyloggedin=1;
	if(!$hill_func->CheckLogin())
	{
	    $alreadyloggedin=0;
	    //exit;
	}
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?php include('site_header.php');?>

<!-- Main document commands here -->
				           
<div id="body_sty">
		
		<?php
			// phpinfo();
			// check to see if the user is already logged on.
			//session_start();	
			
			if($alreadyloggedin==1)
				{
				//define the heading blocks if the user is logged in.
				echo '<br/>';	
				$welcomemsg = 'Welcome '.$hill_func->UserFullName();
				echo '<h2>'.$welcomemsg.'</h2>';
				}
			else
		    		{
				//define the three heading blocks if the user is not already logged in.
				echo '<br/>';	
				echo '<h2>Welcome!</h2>';
		    		}
		?>

		<h3>This is the Beta version of the Know the Hill site.</h3>
		<h4>This site is intended to help the Government Relationals professionals, the lobbying community, researchers, and others with interest in the inner workings of the US government to:</h4>
		<p><a href="hill_query_start.php">Explore</a> the links between the Federal Agencies and your congressional representatives.</p>
		<ul>
		<li>Find out which Congressional Representatives have oversight authority of which Federal Agency.</li>
		<li>Find out the Congressional Committees that have oversight over specific Federal Agencies.</li>
		</ul>
		<p><a href="hill_articles.php">Discuss</a> the issues relating to lobbying and the business of lobbying.</p>
		

		
		
<!-- section below is for right box and footer -->
</div>
	

<div id="rightbox_sty">
		<?php
			//test the system execute command
			//echo exec('pwd');
			include('right_box_text.php');
		?>
</div>
  
		  
        

<!-- Site footer is called from site-footer file -->
<?php include('site_footer.php');?>

</div>
         
