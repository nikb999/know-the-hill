<?PHP 
	require_once("./include/membersite_config.php");
	//create a variable if the user is already logged in.
	$alreadyloggedin=1;
	if(!$hill_func->CheckLogin())
	{
	    $alreadyloggedin=0;
            $username_for_comment_box=null;
            header('Location:login.php');
	    //exit;
	}
	else
	{
	    $username_for_comment_box=$hill_func->UserFullName();
		if(strtoupper($hill_func->UserType())!="ADMIN")
		{header('Location:login.php');}
	}
	
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?PHP  include('site_header.php');?>

<div id="body_sty">


<?PHP 
	//Code to EXECUTE the updating of categories
	//session_start();
	//retrieve the main article 
	if(isset($_POST['useridtoupdate']) && strlen(trim($_POST['useridtoupdate']))>0 )
	{
		mysql_connect($xhost, $xusername, $xpassword) or die("Line 35 Cannot Connect to DB");
		mysql_select_db($xdb_name) or die("Line 36 Cannot select DB");
				
		$updateuser=	"UPDATE $xtbl_name 	
				SET 	name		= '".$hill_func->fix_intext($_POST['nametoupdate']) ."',
					email		= '".$hill_func->fix_intext($_POST['emailtoupdate']) ."',
					phone_number	= '".$hill_func->fix_intext($_POST['phonetoupdate']) ."',
					username	= '".$hill_func->fix_intext($_POST['usernametoupdate']) ."',
					usertype	= '".$hill_func->fix_intext($_POST['usertypetoupdate']) ."',
					lastupdate	= '".date("Y-m-d",time())."'
				WHERE 	id_user 	= ".$_POST['useridtoupdate']." ";
				
		echo $updateuser;
		echo '<p>Current date '.date("Y-m-d",time()).'</p>';
		if(!$updateuserresult = mysql_query($updateuser))
		{
		echo '<p>Error in updating: <br/> '.mysql_error().'</p>';
		}
		else
		{
		echo '<p>Update Successfull: <br/> '.$updateuser.'</p>';
		//unset the $_POST items
		unset($_POST['useridtoupdate']);
		//get the admin user back to the admin page
		header('location: hill_admin.php');
		}
	}
	else {echo '<p>Problem - User ID not correct.  Received: '.$_POST['useridtoupdate'].' Please check.</p>';}

?>





<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
