<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$last_session_closed_timestamp="0000-00-00 00:00:00";
	$res_session=$new_conn->query("SELECT created_date FROM wb_ch ORDER BY created_date DESC LIMIT 0,1");
	if($res_session->num_rows==1)
	{
		$detail_session=$res_session->fetch_assoc();
		$last_session_closed_timestamp=$detail_session['created_date'];
	}
	$prepare="SELECT a.*,DATE(a.created_date) AS start_date,b.* FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE a.table_id='$session_id'";
	$res=$new_conn->query($prepare);
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$name=$detail['first_name']." ".$detail['last_name'];
		$tag=$detail['tag'];
		$did=$detail['did'];
		$fso=$detail['fso'];
		$sso=$detail['sso'];
		$start_date=$detail['start_date'];
		$today_date=date("Y-m-d");
		$datetime1 = new DateTime($today_date);
		$datetime2 = new DateTime($start_date);
		
		$difference = $datetime1->diff($datetime2);
		
		$total_days=$difference->days;
		
		$expiry_array=explode("-",$start_date);
		$next_date=($expiry_array[0]+1)."-".$expiry_array[1]."-".$expiry_array[2];
		
		$days_left="";
		$datetime_temp=new DateTime($next_date);
		if($datetime_temp>$datetime1)
		{
			$difference = $datetime_temp->diff($datetime1);
			$days_left=$difference->days-1;
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+2)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+3)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+4)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+5)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		
		$fso_array=array();
		$sso_array=array();
		
		$active_sale_fso=0;
		$to_be_linked_fso=0;
		$linked_fso=0;
		$renewed_fso=0;
		$disabled_fso=0;
		$executive_fso=0;
		$team_manager_fso=0;
		$manager_fso=0;
		$general_manager_fso=0;
		$diplomat_fso=0;
		
		$active_sale_sso=0;
		$to_be_linked_sso=0;
		$linked_sso=0;
		$renewed_sso=0;
		$disabled_sso=0;
		$executive_sso=0;
		$team_manager_sso=0;
		$manager_sso=0;
		$general_manager_sso=0;
		$diplomat_sso=0;
		
		if($fso!="")
		{
		parse_downline_with_details($new_conn,$fso,$active_sale_fso,$to_be_linked_fso,$linked_fso,$renewed_fso,$disabled_fso,$executive_fso,$team_manager_fso,$manager_fso,$general_manager_fso,$diplomat_fso,$last_session_closed_timestamp);
		}
		if($sso!="")
		{
		parse_downline_with_details($new_conn,$sso,$active_sale_sso,$to_be_linked_sso,$linked_sso,$renewed_sso,$disabled_sso,$executive_sso,$team_manager_sso,$manager_sso,$general_manager_sso,$diplomat_sso,$last_session_closed_timestamp);
		}
		
		$commissionable_fso=$detail['total_fso'];
		$commissionable_sso=$detail['total_sso'];
		$forward_fso=$detail['forward_fso'];
		$forward_sso=$detail['forward_sso'];
		$commissionable_fso-=$forward_fso;
		$commissionable_sso-=$forward_sso;
		$balance_fso=$forward_fso;
		$balance_sso=$forward_sso;
		
		$total_sales=$active_sale_fso+$to_be_linked_fso+$disabled_fso+$active_sale_sso+$to_be_linked_sso+$disabled_sso;
		
		$directs_names_string="";
		$directs_string="";
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE sponsor_id='$session_id'");
		while($detail=$res->fetch_assoc())
		{
			if($directs_names_string=="")
			{
				$directs_names_string=$detail['username']." (".$detail['did'].")";
			}
			else
			{
				$directs_names_string.="<br />".$detail['username']." (".$detail['did'].")";
			}
			if($directs_string=="")
			{
				$directs_string=$detail['table_id'];
			}
			else
			{
				$directs_string.=",".$detail['table_id'];
			}
		}
		
		$directs_fso=0;
		$directs_sso=0;
		if($directs_string!="")
		{
			$res=$new_conn->query("SELECT * FROM wb_ud WHERE fso IN ($directs_string)");
			$directs_fso=$res->num_rows;
			
			$res=$new_conn->query("SELECT * FROM wb_ud WHERE sso IN ($directs_string)");
			$directs_sso=$res->num_rows;
		}
		
		$sponsor_from_db="";
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE fso='$session_id' OR sso='$session_id'");
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$sponsor_from_db=$detail['first_name']." ".$detail['last_name']." (".$detail['username'].") | ".$detail['did'];
		}
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : Profile not found");
		exit();
	}
}
?>