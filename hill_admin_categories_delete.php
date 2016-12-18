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
	//ASK TO CONFIRM DELETION
	$category_to_delete=null;
		
	if (isset($_POST['cat_id_to_edit']) && strlen(trim($_POST['cat_id_to_edit']))>0 )
	{
		$article_to_delete=$_POST['cat_id_to_edit'];
	
		//echo $article_to_delete;
			
		if ( !isset($_POST['deleteyesno']) )
		{
			$go_ahead_with_deletion="NO";
			?>
			<!--if confirmation is not there then show the confirmation form.-->
			<h3>Please confirm deletion for Article #</h3>
			<form action="hill_admin_categories_delete.php" method="post">
	
				<input type="text" readonly="readonly" name="cat_id_to_edit" value="<?PHP echo $_POST['cat_id_to_edit']?>"   /> <br/>
				<input type="radio" name="deleteyesno" value="NO" /> Do Not Delete <br/>
				<input type="radio" name="deleteyesno" value="YES" /> Please Go Ahead with Detele<br/>
				<input type="submit" value="Confirm"/>
			</form>
			<?PHP 
		}
		else 
		{
			//confirmation requested
			if (strtoupper($_POST['deleteyesno'])=="YES")
				{$go_ahead_with_deletion="YES";}
			else
				{
				$go_ahead_with_deletion="NO";
				echo '<p>Delete request cancelled for Category # '.$_POST['cat_id_to_edit'].'</p>';
				}
		}
	}
	else
	{
		echo '<p>Problem in delete command - something wrong with the ID number.</p>';
		echo '<p>Received: '.$_POST['cat_id_to_edit'].' to delete. Please check.</p>';
	}

?>

<?PHP 
	//session_start();
	include "./include/hillarticleconfig.php";

	//retrieve the main article and proceed to delete it. 
	if ($go_ahead_with_deletion=="YES")
	{
		if( isset($_POST['cat_id_to_edit']) && strlen(trim($_POST['cat_id_to_edit']))>0 )
		{
			$deletecategories="DELETE FROM categories WHERE catid = ".$_POST['cat_id_to_edit']."";
			if(!$detelecategoriesresult = mysql_query($deletecategories))
			{
				echo '<p>Error in executing delete command. '.$deletecategories.'</p>';
				echo '<p>'.mysql_error().'</p>';
			}
			else
			{
				//success.
				echo '<p>Article '.$_POST['cat_id_to_edit'].' Deleted.</p>';
				//unset the session variables
				unset($_POST['cat_id_to_edit']);
				unset($_POST['deleteyesno']);
				header('location:hill_admin.php');
			}
		}
		else 
		{	
			echo '<p>Problem in delete command - something wrong with the ID number.</p>';
			echo '<p>Received: '.$_POST['cat_id_to_edit'].' to delete. Please check.</p>';
		}
	}
?>





<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
