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
	//code to edit USERs
	
	include "blogconfig.php";

	//retrieve the main article 
	if(isset($_POST['user_id_to_edit']) && strlen(trim($_POST['user_id_to_edit']))>0)
	{
		//$_SESSION['user_id_to_edit']=$_POST['user_id_to_edit'];
		mysql_connect($xhost, $xusername, $xpassword) or die("Line 37 Cannot Connect to DB");
		mysql_select_db($xdb_name) or die("Line 38 Cannot select DB");		
		$edituser = "SELECT id_user,name,email,phone_number,username,confirmcode,usertype,regisdate,lastupdate FROM $xtbl_name where id_user=".$_POST['user_id_to_edit'].""; 
		if(!$edituserresult = mysql_query($edituser))
		{
		echo mysql_error();
		}
		else
		{
			$numuser=mysql_num_rows($edituserresult);
			?>
			<!-- code to show the existing article info -->
			<p>Selected User</p>
			<p>Please make the needed changes and submit the form</p>
			<?PHP 
			while($rowuser_edit=mysql_fetch_assoc($edituserresult))
			{
			?>
			<!--Write the form to show the existing data.  
			When done user taken to EXEC code where the database is updated or record deleted -->
			<form name="input" action="hill_admin_users_edit_exec.php" method="post">
				<p>User ID (cannot be changed): <input type="text" name="useridtoupdate" value="<?PHP echo $rowuser_edit['id_user'];?>" readonly="readonly" /></p>
				<p>Full Name: <input type="text" name="nametoupdate" value="<?PHP echo $rowuser_edit['name'];?>" /></p>
				<p>Email: <input type="text" name="emailtoupdate" value="<?PHP echo $rowuser_edit['email'];?>" /></p>
				<p>Phone Num: <input type="text" name="phonetoupdate" value="<?PHP echo $rowuser_edit['phone_number'];?>" /></p>
				<p>UserName: <input type="text" name="usernametoupdate" value="<?PHP echo $rowuser_edit['username'];?>" /></p>
				<p>Confirm Code: <input type="text" name="confirmcodetoupdate" value="<?PHP echo $rowuser_edit['confirmcode'];?>" readonly="readonly" /></p>				
				<p>Registration Date: <input type="text" name="blank1" value="<?PHP echo $rowuser_edit['regisdate'];?>" readonly="readonly" /></p>				
				<p>Last Update: <input type="text" name="blank2" value="<?PHP echo $rowuser_edit['lastupdate'];?>" readonly="readonly" /></p>				
				<p>Select user type (current selection: <?PHP echo $rowuser_edit['usertype'];?>) </p>
				<input type="radio" name="usertypetoupdate" value="BASIC" <?PHP if($rowuser_edit['usertype']=="BASIC"){echo "checked";}?> />Basic <br/>
				<input type="radio" name="usertypetoupdate" value="PREMIER" <?PHP if($rowuser_edit['usertype']=="PREMIER"){echo "checked";}?> />Premier <br/>
				<input type="radio" name="usertypetoupdate" value="INACTIVE" <?PHP if($rowuser_edit['usertype']=="INACTIVE"){echo "checked";}?> />Inactive <br/>
				<input type="radio" name="usertypetoupdate" value="ADMIN" <?PHP if($rowuser_edit['usertype']=="ADMIN"){echo "checked";}?> />Admin <br/>
				<input type="submit" value="Submit" />
			</form> 
			<?PHP 
			}
		}
	}
	else {echo '<p>Problem - USER ID not correct.  Received: '.$_POST['user_id_to_edit'].'. Please check.</p>';}

?>


<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
