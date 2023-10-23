<?php
function get_downline_listall($temp,&$new_conn,&$downlinestring)
{
  $sr_resss=$new_conn->query("SELECT id FROM mlm_login WHERE sponsor_id='$temp'");
  if($sr_resss->num_rows>0)
  {
	  while($sr_detailll=$sr_resss->fetch_assoc())
	  {
		  $temp_new=$sr_detailll['id'];
		  if($downlinestring=="")
		  $downlinestring=$sr_detailll['id'];
		  else
		  $downlinestring.=",".$sr_detailll['id'];
		  get_downline_listall($temp_new,$new_conn,$downlinestring);
	  }
  }
  else
  {
  return false;
  }
}
function get_downline_bv($temp,&$new_conn,&$downlinestring,&$total_down_bv)
{
  $sr_resss=$new_conn->query("SELECT a.id,b.my_bv FROM mlm_login a INNER JOIN mlm_bvdetails b ON a.id=b.id WHERE a.sponsor_id='$temp'");
  if($sr_resss->num_rows>0)
  {
	  while($sr_detailll=$sr_resss->fetch_assoc())
	  {
		  $temp_bv=$sr_detailll['my_bv'];
		  if($temp_bv==1)
		  {
			  $total_down_bv++;
		  }
		  $temp_new=$sr_detailll['id'];
		  if($downlinestring=="")
		  $downlinestring=$sr_detailll['id'];
		  else
		  $downlinestring.=",".$sr_detailll['id'];
		  get_downline_bv($temp_new,$new_conn,$downlinestring,$total_down_bv);
	  }
  }
  else
  {
  return false;
  }
}
function calculate_income($tempid,&$new_conn,$total_down_bv)
{
	$res_1=$new_conn->query("SELECT * FROM mlm_bvdetails WHERE id='$tempid'");
	if($res_1->num_rows==1)
	{
		$new_forward_company="";
		$detail_1=$res_1->fetch_assoc();
		$forward_bv=$detail_1['forward_bv'];
		$total_bv=$detail_1['total_bv'];
		$total_bv_to_write=$total_bv+$total_down_bv;
		
		$total_company_forward=$detail_1['total_company_forward'];
		$total_company_forward_to_write=$detail_1['total_company_forward'];
		$total_company_bv=$detail_1['total_company_bv'];
		$total_company_bv_to_write=$detail_1['total_company_bv'];;
		
		
		$forward_bv+=$total_down_bv;
		$forward_bv_to_write=$forward_bv%50;
		$no_of_units=(int)($forward_bv/50);
		$income1=$no_of_units*10;
		$income2=0;
		$res_2=$new_conn->query("SELECT SUM(my_bv) as total FROM mlm_bvdetails WHERE id>'$tempid'");
		if($res_2->num_rows>0)
		{
			$detail_2=$res_2->fetch_assoc();
			$total_company_new=0;
			if($detail_2['total']!=NULL)
			{
				$total_company_new=$detail_2['total'];
			}
			else
			{
				return false;
			}
			$total_company_bv_to_write=$total_company_bv+$total_company_new;
			$total_company_forward+=$total_company_new;
			$total_company_forward_to_write=$total_company_forward%50;
			$no_of_units_2=(int)($total_company_forward/50);
			$income2=$no_of_units_2*75;
			echo($total_company_new);
		}
		$income=$income1+$income2;
		$new_conn->query("UPDATE mlm_bvdetails SET total_bv='$total_bv_to_write',forward_bv='$forward_bv_to_write',total_company_bv='$total_company_bv_to_write',total_company_forward='$total_company_forward_to_write' WHERE id='$tempid'");
		if($new_conn->affected_rows!=1)
		{
				$new_conn->rollback();
				$new_conn->close();
				echo("Error : Interrupted by ID : ".$tempid." .Please contact your administrator 1...");
				exit();
		}
		
		if($income>0)
		{
			$res_3=$new_conn->query("SELECT session FROM mlm_incomes_generated ORDER BY created_date DESC LIMIT 0,1");
			if($res_3->num_rows>0)
			{
				$detail_3=$res_3->fetch_assoc();
				$session_no=$detail_3['session'];
				$session_no++;
			}
			else
			{
				$session_no="0";
			}
			if($new_conn->query("INSERT INTO mlm_incomes_generated(session,id,direct_income,company_income) VALUES('$session_no','$tempid','$income1','$income2')"))
			{
			}
			else
			{
				$new_conn->rollback();
				$new_conn->close();
				echo("Error : Interrupted by ID : ".$tempid." .Please contact your administrator 2...");
				exit();
			}
		}
	}
	else
	{
		$new_conn->rollback();
		$new_conn->close();
		echo("Error : Interrupted by ID : ".$tempid." .Please contact your administrator 3...");
		exit();
	}
}
?>