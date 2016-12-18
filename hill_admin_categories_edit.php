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
	if(isset($_POST['cat_id_to_edit']) && strlen(trim($_POST['cat_id_to_edit']))>0)
	{
		$_SESSION['cat_id_to_edit']=$_POST['cat_id_to_edit'];
		$editcat="SELECT * FROM categories WHERE catid = ".$_POST['cat_id_to_edit']."";
		if(!$editcatresult = mysql_query($editcat))
		{
		echo mysql_error();
		}
		else
		{
			$numcat=mysql_num_rows($editcatresult);
			?>
			<!-- code to show the existing article info -->
			<p>Selected Category</p>
			<p>Please make the needed changes and submit the form</p>
			<?PHP 
			while($rowcat_edit=mysql_fetch_assoc($editcatresult))
			{
			?>
			<!--Write the form to show the existing data.  
			When done user taken to EXEC code where the database is updated or record deleted -->
			<form name="input" action="hill_admin_categories_edit_exec.php" method="post">
				<p>Category ID: <input type="text" name="catidtoupdate" value="<?PHP echo $rowcat_edit['catid'];?>" readonly="readonly" /></p>
				<p>Category: <input type="text" name="categorytoupdate" value="<?PHP echo $rowcat_edit['category'];?>" /></p>
				<p>Category Order: <input type="text" name="catordertoupdate" value="<?PHP echo $rowcat_edit['cat_order'];?>" /></p>
				<input type="submit" value="Submit" />
			</form> 
			<?PHP 
			}
		}
	}
	else {echo '<p>Problem - Category ID not correct.  Received: '.$_POST['cat_id_to_edit'].'. Please check.</p>';}

?>


<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
