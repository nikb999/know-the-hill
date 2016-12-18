<?PHP 
	//require_once("./include/membersite_config.php");
	require_once("./include/membersite_config.php");
	if(!$hill_func->CheckLogin())
	{
	    $hill_func->RedirectToURL("hill_login.php");
	    exit;
	}
?>

<div id="wrap">

	<!-- Site header is called from site-header file -->
	<?PHP  
		$hd_file="./site_header.php";
		include($hd_file);
	?>


<div id="body_sty">

<?PHP 
	include("./include/congdbconfig.php");
    $endresult = "";
    //Check if a valid user is logged on.
	//session_start();	
	if(!$hill_func->CheckLogin() )
		{
		session_destroy();
		header('Location:hill_start.php');	
		}
	elseif($hill_func->CheckLogin() )
		{
		//main program now
		$member_to_display = $_POST['mem_name'];

		//echo '<p>User: '. $_SESSION['userid'].'</p>';
		echo '<p>Information for</p>';
		//echo '<p>'.$member_to_display.'</p>';
				
		$people_query="SELECT * FROM people"
				." WHERE people.id='$member_to_display'";   
		$committee_query="SELECT * FROM people_committees"
				." WHERE people_committees.personid='$member_to_display'";   
		$roles_query="SELECT * FROM people_roles"
				." WHERE people_roles.personid='$member_to_display'";   
		
		$res_mq1=mysql_query($people_query);
		$res_mq2=mysql_query($committee_query);
		$res_mq3=mysql_query($roles_query);	
	
		//echo '<p> Query result  </p>';
        //echo $res_q1;
		
		if (!$res_mq1)
		{
			echo " this could be an issue " . mysql_error();
		}
		else
		{
		//echo '<p> query done </p>';	
	        //show the results ------------------------------------------
		//echo '<p>Query Results from PEOPLE table: </p>';
		$resq1_row = mysql_fetch_array($res_mq1,MYSQL_ASSOC);
		$resq3_row = mysql_fetch_array($res_mq3,MYSQL_ASSOC);
		echo '<h2>'.$resq1_row['firstname'].' '.$resq1_row['lastname'].'</h2>';
		?>
			<table border="0">
			<tr><td>Nick Name</td>  <td><?PHP  echo $resq1_row['nickname']?></td></tr>
			<tr><td>Date of Birth</td>  <td><?PHP  echo $resq1_row['birthday']?></td></tr>
			<tr><td>Religion</td>  	<td><?PHP  echo $resq1_row['religion']?></td></tr>
			<tr><td>Twitter ID</td> <td><?PHP  echo $resq1_row['twitterid']?></td></tr>
			<tr><td> </td>          <td></td></tr>
			<tr><td>Party </td>     <td><?PHP  echo $resq3_row['party']?></td></tr>
			<tr><td>State </td>     <td><?PHP  echo $resq3_row['state']?></td></tr>
			<tr><td>District </td>  <td><?PHP  echo $resq3_row['district']?></td></tr>
			<tr><td>Website</td>       <td><?PHP  echo $resq3_row['url']?></td></tr>
			<tr><td>Address </td>   <td><?PHP  echo $resq3_row['address']?></td></tr>
			<tr><td> </td>          <td></td></tr>
			<?PHP 
			while ($resq2_row = mysql_fetch_array($res_mq2,MYSQL_ASSOC))
			{
				$comm_name= $resq2_row['name'];
				$subcomm_name = $resq2_row['subname'];
				$role = $resq2_row['role'];
				$subyes="";
				$roleyes="";
				if (strlen($subcomm_name)>0) $subyes='<br/>(Subcommittee: '.$subcomm_name.')';
				if (strlen($role)>0) $roleyes='<br/>'.$role;
				echo '<tr><td>Committee</td><td>'.$comm_name.
					$subyes.$roleyes.'</td></tr>';
			}
			?>
			</table>
		<?PHP 
		mysql_free_result($res_mq1);
		mysql_free_result($res_mq2);
		mysql_free_result($res_mq3);
		}
	mysql_close();
    }
	
?>

</div>

	<div id="rightbox_sty">
		<?PHP  include('./right_box_text.php'); ?>
	</div>


	<?PHP    
		//get footer
		$ft_file = "./site_footer.php";
		include($ft_file);
	?>

</div>

