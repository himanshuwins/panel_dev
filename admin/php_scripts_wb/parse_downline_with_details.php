<?php
function parse_downline_with_details($new_conn,$to_check,&$active_sale_fso,&$to_be_linked_fso,&$linked_fso,&$renewed_fso,&$disabled_fso,&$executive_fso,&$team_manager_fso,&$manager_fso,&$general_manager_fso,&$diplomat_fso,$last_session_closed_timestamp)
{
	$prep="SELECT a.*,DATE(a.created_date) AS start_date FROM wb_ud a WHERE a.table_id='$to_check'";
	$res=$new_conn->query($prep);
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$to_return=$detail['table_id'];
		$fso=$detail['fso'];
		$sso=$detail['sso'];
		if(($detail['status']=="active")&&($detail['created_date']>$last_session_closed_timestamp))
		{
			$linked_fso++;
			$active_sale_fso++;
		}
		else if($detail['status']=="active")
		{
			$active_sale_fso++;
		}
		else if($detail['status']=="pending_linked")
		{
			$to_be_linked_fso++;
		}
		else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
		{
			$disabled_fso++;
		}
		
		if($detail['tag']=="Executive")
		{
			$executive_fso++;
		}
		else if($detail['tag']=="Team Manager")
		{
			$team_manager_fso++;
		}
		else if($detail['tag']=="Manager")
		{
			$manager_fso++;
		}
		else if($detail['tag']=="General Manager")
		{
			$general_manager_fso++;
		}
		else if($detail['tag']=="Diplomat")
		{
			$diplomat_fso++;
		}
		
		$start_date=$detail['start_date'];
		$today_date=date("Y-m-d");
		$datetime1 = new DateTime($today_date);
		$datetime2 = new DateTime($start_date);
		$difference = $datetime1->diff($datetime2);
		$total_days=$difference->d;
		
		if(($detail['status']=="active")&&($total_days>365))
		{
			$renewed_fso++;
		}
		
		
		if($fso!="")
		{
			parse_downline_with_details($new_conn,$fso,$active_sale_fso,$to_be_linked_fso,$linked_fso,$renewed_fso,$disabled_fso,$executive_fso,$team_manager_fso,$manager_fso,$general_manager_fso,$diplomat_fso,$last_session_closed_timestamp);
		}
		if($sso!="")
		{
			parse_downline_with_details($new_conn,$sso,$active_sale_fso,$to_be_linked_fso,$linked_fso,$renewed_fso,$disabled_fso,$executive_fso,$team_manager_fso,$manager_fso,$general_manager_fso,$diplomat_fso,$last_session_closed_timestamp);
		}
		if(($fso=="")&&($sso==""))
		{
			return;
		}
	}
	else
	{
		$new_conn->close();
		echo("Error : Cannot parse complete downline...!!!");
		exit();
	}
}
?>