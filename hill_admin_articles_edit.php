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
	if(isset($_POST['art_num_to_edit']) && strlen(trim($_POST['art_num_to_edit']))>0)
	{
		$_SESSION['art_num_to_edit']=$_POST['art_num_to_edit'];
		$editarticle="SELECT * FROM article WHERE artid = ".$_POST['art_num_to_edit']."";
		if(!$editresult = mysql_query($editarticle))
		{
		echo mysql_error();
		}
		else
		{
		$num=mysql_num_rows($editresult);
			?>
			<!-- code to show the existing article info -->
			</table>
			<p>Selected Article</p>
			<p>Please make the needed changes and submit the form</p>
			<?PHP 
			while($row_edit=mysql_fetch_assoc($editresult))
			{
			?>
			<!--Write the form to show the existing data.  When done user taken to EXEC code where the database is updated or record deleted -->
			<form name="input" action="hill_admin_articles_edit_exec.php" method="post">
				<p>Article ID: <input type="text" name="artidtoupdate" value="<?PHP  echo $row_edit['artid'];?>" readonly="readonly" /></p>
				<p>Author: <input type="text" name="nametoupdate" value="<?PHP echo $row_edit['name'];?>" /></p>
				<p>Title: <br/> <textarea name="titletoupdate" rows="2" cols="50"><?PHP echo $row_edit['title'];?></textarea></p>
				<p>MainText/Comments: <br/>  <textarea name="commentstoupdate" rows="20" cols="50"><?PHP echo $row_edit['comments'];?></textarea>  </p>
				<p>Summary: <br/> <textarea name="summarytoupdate" rows="5" cols="50"><?PHP echo $row_edit['art_summary'];?></textarea></p>
				<p>Date Posted: <input type="text" name="date_postedtoupdate" value="<?PHP echo $row_edit['date_posted'];?>" /></p>
				<p>Category ID: <input type="text" name="categoryIDtoupdate" value="<?PHP echo $row_edit['categoryID'];?>"/></p>
				<p>Article Child: <input type="text" name="artchildtoupdate" value="<?PHP echo $row_edit['artchild'];?>" readonly="readonly" /></p>
				<input type="submit" value="Submit" />
			</form> 
			<?PHP 
			}
			?></table>
			<?PHP 
		}
	}
	else {echo '<p>Problem - Article ID not correct.  Received: '.$_POST['art_num_to_edit'].' Please check.</p>';}

?>





<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
