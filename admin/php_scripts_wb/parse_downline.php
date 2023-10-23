<?php
function parse_downline($new_conn,$to_check,&$downline_array)
{
	$prep="SELECT table_id,fso,sso FROM wb_ud WHERE table_id='$to_check'";
	$res=$new_conn->query($prep);
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$to_return=$detail['table_id'];
		$fso=$detail['fso'];
		$sso=$detail['sso'];
		if($fso!="")
		{
			$downline_array[]=$fso;
			parse_downline($new_conn,$fso,$downline_array);
		}
		if($sso!="")
		{
			$downline_array[]=$sso;
			parse_downline($new_conn,$sso,$downline_array);
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