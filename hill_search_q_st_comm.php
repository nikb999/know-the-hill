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

    $endresult = "";
    //Check if a valid user is logged on.
	//session_start();
	$search_error = 0;		
	if(!$hill_func->CheckLogin() )
		{
		session_destroy();
		header('Location:hill_start.php');	
		}
	elseif($hill_func->CheckLogin() )
		{
		//define the heading blocks if the user is logged in.
		//main program now
		
		//if both the state and committee are not selected, send back the user to the form
		if (!isset($_POST['stname']) & !isset($_POST['commid']) )
		{
			$_SESSION['qstag_error'] = "---- Please submit form again.  Select at least one State or one Committee. ---";
			$search_error = 1;
			echo '<p>Error: '.$_SESSION['qstag_error'].'</p>';
		}
		elseif (isset($_POST['stname']) or isset($_POST['commid']) )
		//if either the state or the committee is selected
		{
			if (isset($_POST['stname'])) 
			{
				$statename = $_POST['stname'];
				if (count($statename)>$max_search_elements)  
					{
						$_SESSION['qstag_error'] = "---- Too many States selected. Please limit selection of States to ".$max_search_elements;
						$search_error = 1;
						echo '<p>Error: '.$_SESSION['qstag_error'].'</p>';
					}
			}
				
			if (isset($_POST['commid'])) 
			{
				$comm_id = $_POST['commid'];
				if (count($comm_id)>$max_search_elements)  
					{
						$_SESSION['qstag_error'] = "---- Too many Committees selected. Please limit selection of Committees to ".$max_search_elements;
						$search_error = 1;
						echo '<p>Error: '.$_SESSION['qstag_error'].'</p>';
					}
			}
		}
	
	if ($search_error == 0)
	{
		//$statename = $_POST['stname'];
		//$comm_id = $_POST['commid'];
        $cutoff_yr = "2011";
	  
	        //echo '</br>' . $statename . '</br>' . $comm_id . '</br>' . $cutoff_yr ;
	        
	        $cutoff_date =  $cutoff_yr . "-01-01";
        
		//echo '</br> cutoffdate -- ' . $cutoff_date . '</br>' ;

		//echo '<p> User </p>';
		echo '<p> State names: ';
				
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
		echo '</p> <p> Committee(s): ';
		$comm_cond = "";
		if (isset($comm_id))
		{
			//iterate thru each state name
			$comm_id_num = count($comm_id);
			for ($i_comm=0;$i_comm<$comm_id_num;$i_comm++)
			{
				//create the compare statement
				if ( ($i_comm == 0) && (strlen($comm_id[$i_comm])>1) ) {
					$comm_cond = $comm_cond . "(people_committees.committeeid = '" . strtoupper(trim($comm_id[$i_comm])) . "')" ;
				}
				elseif ( ($i_comm > 0) && (strlen($comm_id[$i_comm])>1) ) {
					$comm_cond = $comm_cond . " OR " . "(people_committees.committeeid = '" . strtoupper(trim($comm_id[$i_comm])) . "')" ;
				}                
				echo strtoupper(trim($comm_id[$i_comm]))." ";
				}
			unset($i_comm);		//unset to take care of last iteration pointer issue
		}
		else
		{
			$comm_cond = "(people_committees.committeeid IS NOT NULL)";
			echo "All Committees (no committee selected in previous step.)";
		}
		
        	echo '</p>';
        	
        	//echo '</br>' . " printing out state and committee conditions ".'</br>';
		//echo $st_cond . '</br>' . $comm_cond . '</br>' ;
		
		// st_cond = "(people_roles.state='CA') or (people_roles.state='TX')";
				
			require_once("./include/congdbconfig.php");
			
			// Connect to server and select database.
			mysql_connect($host, $username, $password)or die('cannot connect '.mysql_error()); 

			$cong_con = mysql_connect($host, $username, $password);
			if (!$cong_con)
			  {
			  die('Could not connect: ' . mysql_error());
			  }
			else 
				{
					// echo '<p> connected database: '.$cong_db.'</p>'; 
					// echo '<p> Username '. $username . ' Password: ' . $password . ' Host: ' . $host . '</p>' ;
					echo '<p> </p>';
					// mysql_query("show databases",$cong_con);
				}

			mysql_select_db($cong_db)or die("cannot select DB");
                
			$qstr1 = "select people.lastname, people.firstname, "
					   . "people_committees.committeeid, people_committees.role, "
                       . "enddate, people_roles.type, people_roles.party, "
                       . "people_roles.state, people_roles.district, people.id, "
					   . "people_committees.name, people_committees.subname "
                       . "from people, people_committees, people_roles  "
                       . "    where ( ( people.id = people_committees.personid) "
                       . "            and (people.id = people_roles.personid and "
                       . "                    people_roles.enddate>'" . $cutoff_yr . "-01-01') "
                       . "            and ( " . $comm_cond . " ) "
                       . "            and ( " . $st_cond . " ) "
                       . "           )" ;

        
        	$query_string1 = $qstr1;
        
        	$query_string2 = "describe people";
        	$query_string3 = "describe people_committees";
        	$query_string4 = "show tables";
        
		$res_q1=mysql_query($query_string1);
		//$res_q2=mysql_query($query_string2);
		//$res_q3=mysql_query($query_string3);
		//$res_q4=mysql_query($query_string4);

		// echo '<p> Query String  </p> <p>' .$query_string1.'</p>' ;
		
		if (!$res_q1)
		{
			echo " this could be an issue " . mysql_error();
		}
		else
		{
			echo '<p>Query Results: </p>';
		}
		
        //show the results
		//start by unsetting the variable
		
		if ( mysql_num_rows($res_q1) > 0 )
		{
			echo '<p>No. of options found: '.mysql_num_rows($res_q1).'</p>';
			//print_r(mysql_fetch_row($res_q1));
			//print_r(array_values(mysql_fetch_array($res_q1,mysql_num)));
			//$numrecords = 0;
			//need to move the data pointer back to the first row.  
			mysql_data_seek($res_q1,0);
			while ($resq1_row = mysql_fetch_array($res_q1,MYSQL_NUM)) 
			{
				//$numrecords = $numrecords + 1;
				//echo '<p>Record no. '.$numrecords.'</p>';
				//print_r(array_values($resq1_row));
				if (strlen($resq1_row[3]=0)) {
					$commrole = "a member";
					}
					else
					{
					$commrole = $resq1_row[3];
					}
					
				$mem_name = ucfirst($resq1_row[5]).". ".$resq1_row[0];
				//echo '<p>' .$mem_name. '</p>';

				$out_result=$mem_name
							." (".substr($resq1_row[6],0,1).", ".$resq1_row[7]."-".$resq1_row[8].") "
							." is ".$commrole
							." of ". $resq1_row[2] ."."
							." Member ID: ". $resq1_row[9]. "."
							;
				
				$out_result_graph =	$resq1_row[7]." -> "
									."\"".$mem_name."\" -> "
									.$resq1_row[2].";"
									;
				
				$out_sub_name = "";
				if ( strlen($resq1_row[11]) > 0 )
				{
					$out_sub_name = " (Subcommittee on ". $resq1_row[11] .")";
				}
				
				$out_result2= "(".substr($resq1_row[6],0,1).", ".$resq1_row[7].") "
							." is ".$commrole
							." of ". $resq1_row[10].$out_sub_name. "."
							;

							?>
							<form action="hill_memberinfo.php" method="post">
								<input type="hidden" name="mem_name" value="<?php echo $resq1_row[9]?>"/>
								<input type="Submit" value="<?php echo $mem_name?>" style="color:blue;text-align:center;background:yellow;" />
								<?php echo $out_result2; ?>
							</form>
							<?php
				
				//echo '<p>'.$out_result2.'</p>';
				
				//echo $out_result.'</br>';
				//echo '<p>'.$out_result_graph.'</p>';
				
				
				// 0 people.lastname
				// 1 people.firstname, 
				// 2  committeeid, 
				// 3 people_committees.role, 
				// 4  enddate, 
				// 5 people_roles.type, 
				// 6 people_roles.party, 
				// 7 people_roles.state, 
				// 8 people_roles.district 
				// 9 people.id
				// 10 people_committees.name
				// 11 people_committees.subname
				
				
			}
		}
		else
		{
			print("No results found for this query.  Please try a new query.");
		}
        
		mysql_free_result($res_q1);
		mysql_close(); 
		unset($_SESSION['qstag_error']);
	
    }
	}

	echo '<p><a href="hill_search_state_committee.php">New Search</a></p>';

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

