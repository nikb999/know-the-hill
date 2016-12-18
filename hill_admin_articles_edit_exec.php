<?PHP 
	require_once("./include/membersite_config.php");
	//create a variable if the user is already logged in.
	$alreadyloggedin=1;
	if(!$hill_func->CheckLogin())
	{
	    $alreadyloggedin=0;
            $username_for_comment_box=null;
            header('Location:hill_login.php');
	    //exit;
	}
	else
	{
	    $username_for_comment_box=$hill_func->UserFullName();
		if(strtoupper($hill_func->UserType())!="ADMIN")
		{header('Location:hill_login.php');}
	}
	
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?PHP  include('site_header.php');?>

<div id="body_sty">


<?PHP 
	//session_start();
	include "./include/hillarticleconfig.php";

	//retrieve the main article 
	if(isset($_POST['artidtoupdate']) && strlen(trim($_POST['artidtoupdate']))>0 )
	{
		$updatearticle="UPDATE article 	
				SET 	name 		= '".trim($hill_func->fix_intext($_POST['nametoupdate'])) ."',
					title		= '".trim($hill_func->fix_intext($_POST['titletoupdate'])) ."',
					comments 	= '".trim($hill_func->fix_intext($_POST['commentstoupdate'])) ."',
					art_summary 	= '".trim($hill_func->fix_intext($_POST['summarytoupdate'])) ."',
					date_posted 	= '".date("Y-m-d",time()) ."',
					categoryID 	= ".$hill_func->fix_intext($_POST['categoryIDtoupdate']) .",
					artchild 	= ".$hill_func->fix_intext($_POST['artchildtoupdate']) ."
				WHERE 	artid 		= ".$_POST['artidtoupdate']." ";
				
		echo $updatearticle;
		echo '<p>Current date '.date("Y-m-d",time()).'</p>';
		if(!$updateresult = mysql_query($updatearticle))
		{
		echo '<p>Error in updating: <br/> '.mysql_error().'</p>';
		}
		else
		{
		echo '<p>Update Successfull: <br/> '.mysql_error().'</p>';
		//unset the session variables
		unset($_POST['artidtoupdate']);
		unset($_POST['nametoupdate']);
		unset($_POST['commentstoupdate']);
		unset($_POST['summarytoupdate']);
		unset($_POST['categoryIDtoupdate']);
		unset($_POST['artchildtoupdate']);
		}
	}
	else {echo '<p>Problem - Article ID not correct.  Received: '.$_POST['artidtoupdate'].' Please check.</p>';}


?>

<form name="redirect_to_admin" action="hill_admin.php" method="get">
	<input type="submit" value="Return back to Admin Page" />
</form> 


<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
