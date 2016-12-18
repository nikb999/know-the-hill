<?PHP
	//require_once("./include/membersite_config.php");
	require_once("./include/membersite_config.php");
	if(!$hill_func->CheckLogin())
	{
		session_destroy();
	    $hill_func->RedirectToURL("hill_login.php");
	    exit;
	}
	else
	{
		if (strtoupper($hill_func->UserType())=="BASIC")
		{
			$max_search_elements = $max_elements_basic;
		}
		else
		{
			$max_search_elements = $max_elements_premier;
		}			
	}
	
?>

<div id="wrap">

	<!-- Site header is called from site-header file -->
	<?php 
		$hd_file="./site_header.php";
		include($hd_file);
	?>


<div id="body_sty">

<?php

    //Check if a valid user is logged on.
	//session_start();
	$search_error = 0;	
	if(!$hill_func->CheckLogin() )
	{
		session_destroy();
		header('Location:hill_start.php');	
		exit;
	}
	elseif($hill_func->CheckLogin() )
	{
		//main program now

		//if both the state and agency are not selected, send back the user to the form
		if (!isset($_POST['stname']) & !isset($_POST['agencyid']) )
		{
			$_SESSION['qstag_error'] = "---- Please submit form again.  Select at least one State or one Agency. ---";
			$search_error = 1;
			echo '<p>Error: '.$_SESSION['qstag_error'].'</p>';
		}
		elseif (isset($_POST['stname']) or isset($_POST['agencyid']) )
		//if either the state or the agency is selected
		{
			if (isset($_POST['stname'])) 
			{
				$statename = $_POST['stname'];
				if (count($statename)>$max_search_elements)  
					{
						$_SESSION['qstag_error'] = "---- Too many States selected. Please limit selection of States to ".$max_search_elements;
						echo '<p>Error: '.$_SESSION['qstag_error'].'</p>';
						$search_error = 1;
						//$hill_func->RedirectToURL("hill_search_state_agency.php");
						//header('Location:hill_search_state_agency.php');
						//exit;		
					}
			}
				
			if (isset($_POST['agencyid'])) 
			{
				$comm_id = $_POST['agencyid'];
				if (count($comm_id)>$max_search_elements)  
					{
						$_SESSION['qstag_error'] = "---- Too many Agencies selected. Please limit selection of Agencies to ".$max_search_elements;
						$search_error = 1;
						echo '<p>Error: '.$_SESSION['qstag_error'].'</p>';
					}
			}
		}

		//if (isset($_POST['stname'])) {$statename = $_POST['stname'];}
        //if (isset($_POST['agencyid'])) {$comm_id = $_POST['agencyid'];}
				
        $cutoff_yr = '2011';
        $cutoff_date =  $cutoff_yr . "-01-01";
        
		//echo '</br> cutoffdate -- ' . $cutoff_date . '</br>' ;

	if ($search_error == 0)
	{
		echo "Query Parameters.".'</br>';
		echo "State(s): ";
				
		// Use the string-split method to split the state names into 
		// individual names.  
		$st_cond = "";
        if (isset($statename))
		{
			//iterate thru each state name
			$st_name_num = count($statename);
			for ($i_st=0;$i_st<$st_name_num;$i_st++ )
			{
				//create the compare statement
				if ( ($i_st == 0) && (strlen($statename[$i_st])>1) ) {
					$st_cond = $st_cond . "(people_roles.state = '" . strtoupper(trim($statename[$i_st])) . "')" ;
				}
				elseif ( ($i_st > 0) && (strlen($statename[$i_st])>1) ) {
					$st_cond = $st_cond . " OR " . "(people_roles.state = '" . strtoupper(trim($statename[$i_st])) . "')" ;
				}                
				echo strtoupper(trim($statename[$i_st]))." ";
			}
			unset($i_st);		//unset command takes care of a pointer issue after the last iteration.
		}
		else
		{
			$st_cond = "(people_roles.state IS NOT NULL)";
			echo "All states (no State selected in the previous step.)";
		}

        
		// Use the string-split method to split the committee names into 
		// individual names.  
		echo '</br>'."Agency(ies): ";
		$comm_cond = "";
		if (isset($comm_id))
		{
			//iterate thru each agency name
			$comm_id_num = count($comm_id);
			for ($i_comm=0;$i_comm<$comm_id_num;$i_comm++)
			{
				//create the compare statement
				if ( ($i_comm == 0) && (strlen($comm_id[$i_comm])>1) ) {
					$comm_cond = $comm_cond . "(agency_comm.fedsubagencycode = '" . strtoupper(trim($comm_id[$i_comm])) . "')" ;
				}
				elseif ( ($i_comm > 0) && (strlen($comm_id[$i_comm])>1) ) {
					$comm_cond = $comm_cond . " OR " . "(agency_comm.fedsubagencycode = '" . strtoupper(trim($comm_id[$i_comm])) . "')" ;
				}                
				echo strtoupper(trim($comm_id[$i_comm]))." ";
				}
			unset($i_comm);		//unset to take care of last iteration pointer issue
		}
		else
		{
			$comm_cond = "(agency_comm.fedsubagencycode IS NOT NULL)";
			echo "All Agencies (no agency selected in previous step.)";
		}

		
        //echo '</br>' . " printing out state and committee conditions ".'</br>';
		//echo $st_cond . '</br>' . $comm_cond . '</br>' ;
		
		// st_cond = "(people_roles.state='CA') or (people_roles.state='TX')";

		require_once("./include/congdbconfig.php");

			// Connect to server and select database.
			mysql_connect($host, $username, $password) or die('cannot connect '.mysql_error()); 

			$cong_con = mysql_connect($host, $username, $password);
			if (!$cong_con)
			  {
			  die('Could not connect: ' . mysql_error());
			  }
			else 
				{
					//echo '<p> connected database </p>'; 
					//echo $username . " - " . $password . " - " . $host . " " ;
					echo '<p> </p>';
					// mysql_query("show databases",$cong_con);
				}

			mysql_select_db($cong_db)or die("cannot select DB");

            //distinct keyword forces selection of the individual only once		
			$qstr1 = "SELECT DISTINCT people.id, people.lastname, people.firstname, "
					   . "people_committees.committeeid, people_committees.role, "
                       . "people_roles.type, people_roles.party, "
                       . "people_roles.state, "
					   . "agency_comm.fedagency, agency_comm.commcode, agency_comm.commname "
                       . "from people, people_committees, people_roles, agency_comm  "
                       . "where ( ( people.id = people_committees.personid) "
                       . "       and (people.id = people_roles.personid and "
                       . "            people_roles.enddate>'" . $cutoff_yr . "-01-01') "
                       . "       and ( " . $comm_cond . " ) "
                       . "       and ( " . $st_cond . " ) "
						."       and (people_committees.committeeid = agency_comm.commcode) "
						."     )" 
						." ORDER BY people_roles.state " ;
						
   
        $query_string1 = $qstr1;
        
        $query_string2 = "describe people";
        $query_string3 = "describe people_committees";
        $query_string4 = "show tables";
        
		$res_q1=mysql_query($query_string1);
		//$res_q2=mysql_query($query_string2);
		//$res_q3=mysql_query($query_string3);
		//$res_q4=mysql_query($query_string4);

		//echo '<p> Query String  </p>';
		//echo $query_string1 ;
		
		if (!$res_q1)
		{
			echo '<p> Query could not be processed.  Error: ' . mysql_error() . '</p>';
		}
		else
		{
			echo '<p>Query Results. </p>';
		}
		
        //show the results

		$write_output_array = array();
		$write_personid_array = array();
		$write_personinfo_array = array();
		//move the record pointer to the first record
		//echo '<p>'.mysql_num_rows($res_q1).'</p>';
		mysql_data_seek($res_q1,0);
		while ($resq1_row = mysql_fetch_array($res_q1,MYSQL_NUM)) 
		{
			//echo '<p> -- </p>';
			if (strlen($resq1_row[4]=0)) {
				$commrole = "a member";
				}
				else
				{
				$commrole = $resq1_row[4];
				}
				
			$mem_name = ucfirst($resq1_row[5]).". ".$resq1_row[1]." (".substr($resq1_row[6],0,1).", ".$resq1_row[7].")";
			
			$out_result=$mem_name
						." (".substr($resq1_row[6],0,1).", ".$resq1_row[7]."-".$resq1_row[8].") "
						." is ".$commrole
						." of ". $resq1_row[2] ."."
						." Member ID: ". $resq1_row[7]. "."
						;
			
			$out_result_graph =	$resq1_row[7]." -> "
								."\"".$mem_name."\" -> "
								.$resq1_row[2].";"
								;
			$out_result2=" is ".$commrole
						." of ". $resq1_row[10] ." "
						." with jurisdiction over ". $resq1_row[8] ."."
						;
			
			//print_r(array_values($resq1_row));
			//add item to the output array
			//check if it exists, if yes, then don't show the output
			$w_to_array_specific_value = trim($resq1_row[0]).'-'.trim($resq1_row[3]).'-'.trim($resq1_row[8]);
			$w_to_personinfo_specific_value = trim($resq1_row[0]).'-'.trim($mem_name).'-'.trim($out_result2);
			if (!in_array($w_to_array_specific_value,$write_output_array))
			{
				array_push($write_output_array,$w_to_array_specific_value);
				array_push($write_personinfo_array,$w_to_personinfo_specific_value);
				if (!in_array($resq1_row[0],$write_personid_array,false))
				{
					array_push($write_personid_array,$resq1_row[0]);
				}
			}
			
			//create links to the member page
			// 0 people.id
			// 1 people.lastname
			// 2 people.firstname, 
			// 3  committeeid, 
			// 4 people_committees.role, 
			// 5  people role type, 
			// 6 people_roles party, 
			// 7 people_roles state, 
			// 8 agency_comm.fed agency sub code 
			// 9 agency_comm.commcode
			// 10 agency_comm.folionum
			
			//echo $resq1_row[0].'</br>';
			//echo $resq1_row['committeeid'];
			//echo $resq1_row['people_committees.role'];
			//echo $resq1_row['people_roles.type'];
			//echo $resq1_row['people_roles.party'];
			//echo $resq1_row['people_roles.state'];
			//echo $resq1_row['people_roles.district'];
		}
		
		if ( count($write_output_array) > 0 )
			{ 
				//print_r(array_values($write_output_array));
				sort($write_personid_array);
				//print_r(array_values($write_personid_array));
				$total_personid = count($write_personid_array);
				for ($tpi = 0; $tpi<$total_personid; $tpi++)
				{
					//echo '<p>'.$write_personid_array[$tpi].'</p>';
					$write_mem_name = 0;
					for ($woa = 0; $woa < count($write_output_array); $woa++)
					{
						$curr_arr_val = explode("-",$write_personinfo_array[$woa]);
						if ($curr_arr_val[0] == $write_personid_array[$tpi])
						{
							if ($write_mem_name == 0)
							{
								//echo '<p>'.$curr_arr_val[1].'</p>';
								?>
								<form action="hill_memberinfo.php" method="post">
								<input type="hidden" name="mem_name" value="<?php echo $curr_arr_val[0]?>"/>
								<input type="Submit" value="<?php echo $curr_arr_val[1]?>" style="color:blue;text-align:center;background:yellow;" />
								</form>
								<?php
							}
							echo '<p>...........'.$curr_arr_val[2].'</p>';
							$write_mem_name = 1;
						}
					}
				}
			}
		else
			{
			print("No results found for this query.  Please try a new query.");
			}
		unset($write_output_array);
		unset($write_personid_array);
		unset($write_personinfo_array);
		unset($_SESSION['qstag_error']);
        mysql_free_result($res_q1);
	}
	}

	echo '<p><a href="hill_search_state_agency.php">New Search</a></p>';

?>

</div>

	<div id="rightbox_sty">
		<?php include('./right_box_text.php'); ?>
	</div>


	<?php   
		//get footer
		$ft_file = "./site_footer.php";
		include($ft_file);
	?>

</div>

