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
	//Code to EXECUTE the updating of categories
	//session_start();
	include "./include/hillarticleconfig.php";

	//retrieve the main article 
	if(isset($_POST['catidtoupdate']) && strlen(trim($_POST['catidtoupdate']))>0 )
	{
		$updatecategory="UPDATE categories 	
				SET 	category	= '".trim($_POST['categorytoupdate']) ."' ,
						cat_order	= '".trim($_POST['catordertoupdate']) ."'
				WHERE 	catid 		= ".$_POST['catidtoupdate']." ";
				
		echo $updatecategory;
		echo '<p>Current date '.date("Y-m-d",time()).'</p>';
		if(!$updatecatresult = mysql_query($updatecategory))
		{
		echo '<p>Error in updating: <br/> '.mysql_error().'</p>';
		}
		else
		{
		echo '<p>Update Successfull: <br/> '.$updatecategory.'</p>';
		//unset the $_POST items
		unset($_POST['catidtoupdate']);
		unset($_POST['categorytoupdate']);
		unset($_POST['catordertoupdate']);
		//get the admin user back to the admin page
		header('location: hill_admin.php');
		}
	}
	else {echo '<p>Problem - Category ID not correct.  Received: '.$_POST['catidtoupdate'].' Please check.</p>';}

?>





<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
