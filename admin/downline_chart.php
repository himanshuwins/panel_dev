<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts_wb/parse_downline.php");?>
<?php
$session_id=$_SESSION['log_id'];
$msg="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
<?php
if(isset($_GET['username']))
{
	$username_url=$_GET['username'];
	if($username_url=="")
	{
		echo("Error : Invalid Username...");
		exit();
	}
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$username_url=$new_conn->real_escape_string($username_url);
		$res_temp=$new_conn->query("SELECT * FROM wb_ud WHERE username='$username_url'");
		if($res_temp->num_rows==1)
		{
			$detail_temp=$res_temp->fetch_assoc();
			$to_check_for=$detail_temp['table_id'];
			$new_conn->close();
		}
		else
		{
			$new_conn->close();
			echo("Error : Not found...!!!");
			exit();
		}
	}
}
else
{
	$to_check_for=$session_id;
}
?>
<?php
$downline_array=array();
$downline_array[]=$to_check_for;
$red="#900";
$green="#009D4D";
$blue="#E5E5E5";
$black="#000";
$name_array=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
$username_array=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
$did_array=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
$date_array=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
$position_array=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
$colors_array=array($blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue,$blue);
$position_array[0]=$to_check_for;
try
{
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$to_find=$position_array[0];
		$to_find=$new_conn->real_escape_string($to_find);
		$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$name_array[0]=$detail['first_name']." ".$detail['last_name'];
			$username_array[0]=$detail['username'];
			$did_array[0]=$detail['did'];
			$date_array[0]=$detail['date'];
			$position_array[1]=$detail['fso'];
			$position_array[2]=$detail['sso'];
			
			if($detail['status']=="pending_linked")
			{
				$colors_array[0]=$red;
			}
			else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
			{
				$colors_array[0]=$black;
			}
			else if($detail['status']=="active")
			{
				$colors_array[0]=$green;
			}
		}
		
		if($position_array[1]!="")
		{
			$to_find=$position_array[1];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[1]=$detail['first_name']." ".$detail['last_name'];
				$username_array[1]=$detail['username'];
				$did_array[1]=$detail['did'];
				$date_array[1]=$detail['date'];
				$position_array[3]=$detail['fso'];
				$position_array[4]=$detail['sso'];
				
				if($detail['status']=="pending_linked")
				{
					$colors_array[1]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[1]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[1]=$green;
				}
			}	
		}
		
		if($position_array[2]!="")
		{
			$to_find=$position_array[2];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[2]=$detail['first_name']." ".$detail['last_name'];
				$username_array[2]=$detail['username'];
				$did_array[2]=$detail['did'];
				$date_array[2]=$detail['date'];
				$position_array[5]=$detail['fso'];
				$position_array[6]=$detail['sso'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[2]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[2]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[2]=$green;
				}
			}	
		}
		
		if($position_array[3]!="")
		{
			$to_find=$position_array[3];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[3]=$detail['first_name']." ".$detail['last_name'];
				$username_array[3]=$detail['username'];
				$did_array[3]=$detail['did'];
				$date_array[3]=$detail['date'];
				$position_array[7]=$detail['fso'];
				$position_array[8]=$detail['sso'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[3]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[3]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[3]=$green;
				}
			}	
		}
		
		if($position_array[4]!="")
		{
			$to_find=$position_array[4];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[4]=$detail['first_name']." ".$detail['last_name'];
				$username_array[4]=$detail['username'];
				$did_array[4]=$detail['did'];
				$date_array[4]=$detail['date'];
				$position_array[9]=$detail['fso'];
				$position_array[10]=$detail['sso'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[4]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[4]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[4]=$green;
				}
			}	
		}
		
		if($position_array[5]!="")
		{
			$to_find=$position_array[5];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[5]=$detail['first_name']." ".$detail['last_name'];
				$username_array[5]=$detail['username'];
				$did_array[5]=$detail['did'];
				$date_array[5]=$detail['date'];
				$position_array[11]=$detail['fso'];
				$position_array[12]=$detail['sso'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[5]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[5]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[5]=$green;
				}
			}	
		}
		
		if($position_array[6]!="")
		{
			$to_find=$position_array[6];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,fso,sso,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[6]=$detail['first_name']." ".$detail['last_name'];
				$username_array[6]=$detail['username'];
				$did_array[6]=$detail['did'];
				$date_array[6]=$detail['date'];
				$position_array[13]=$detail['fso'];
				$position_array[14]=$detail['sso'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[6]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[6]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[6]=$green;
				}
			}	
		}
		
		if($position_array[7]!="")
		{
			$to_find=$position_array[7];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[7]=$detail['first_name']." ".$detail['last_name'];
				$username_array[7]=$detail['username'];
				$did_array[7]=$detail['did'];
				$date_array[7]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[7]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[7]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[7]=$green;
				}
			}	
		}
		if($position_array[8]!="")
		{
			$to_find=$position_array[8];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[8]=$detail['first_name']." ".$detail['last_name'];
				$username_array[8]=$detail['username'];
				$did_array[8]=$detail['did'];
				$date_array[8]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[8]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[8]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[8]=$green;
				}
			}	
		}
		if($position_array[9]!="")
		{
			$to_find=$position_array[9];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[9]=$detail['first_name']." ".$detail['last_name'];
				$username_array[9]=$detail['username'];
				$did_array[9]=$detail['did'];
				$date_array[9]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[9]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[9]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[9]=$green;
				}
			}	
		}
		if($position_array[10]!="")
		{
			$to_find=$position_array[10];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[10]=$detail['first_name']." ".$detail['last_name'];
				$username_array[10]=$detail['username'];
				$did_array[10]=$detail['did'];
				$date_array[10]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[10]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[10]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[10]=$green;
				}
			}	
		}
		if($position_array[11]!="")
		{
			$to_find=$position_array[11];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[11]=$detail['first_name']." ".$detail['last_name'];
				$username_array[11]=$detail['username'];
				$did_array[11]=$detail['did'];
				$date_array[11]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[11]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[11]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[11]=$green;
				}
			}	
		}
		if($position_array[12]!="")
		{
			$to_find=$position_array[12];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[12]=$detail['first_name']." ".$detail['last_name'];
				$username_array[12]=$detail['username'];
				$did_array[12]=$detail['did'];
				$date_array[12]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[12]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[12]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[12]=$green;
				}
			}	
		}
		if($position_array[13]!="")
		{
			$to_find=$position_array[13];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[13]=$detail['first_name']." ".$detail['last_name'];
				$username_array[13]=$detail['username'];
				$did_array[13]=$detail['did'];
				$date_array[13]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[13]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[13]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[13]=$green;
				}
			}	
		}
		if($position_array[14]!="")
		{
			$to_find=$position_array[14];
			$res=$new_conn->query("SELECT first_name,last_name,username,did,DATE(created_date) AS date,status FROM wb_ud WHERE table_id='$to_find'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$name_array[14]=$detail['first_name']." ".$detail['last_name'];
				$username_array[14]=$detail['username'];
				$did_array[14]=$detail['did'];
				$date_array[14]=$detail['date'];
				if($detail['status']=="pending_linked")
				{
					$colors_array[14]=$red;
				}
				else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
				{
					$colors_array[14]=$black;
				}
				else if($detail['status']=="active")
				{
					$colors_array[14]=$green;
				}
			}	
		}
		$new_conn->close();
	}
}
catch (Exception $e)
{
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Downline Chart</title>
<script src="../javascript/jquery_file.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<style>
legend{
font-weight:bold;
font-size:1.1em;
}
fieldset{
padding:20px;
}
.tables_fieldset{
width:100%;
font-weight:bold;
color:#333;
}
.downline_chart a{
color:#333;
}
.downline_chart a:link{
}
.downline_chart a:visited{
}
.downline_chart a:hover{
color:#000;
}
.downline_chart a:active{
}
</style>
</head>
<body>

<div id="content_main">
<table style="width:98%;margin:auto;font-size:1em;text-align:center;" border="0" cellpadding="0" cellspacing="0" class="downline_chart">
  <tr>
    <td align="left"><h2 style="color:#333;line-height:50px;">DOWNLINE CHART | <a href="user_sales_report.php?username=<?php echo($username_url);?>" style="text-decoration:underline;color:#06C;">SALES REPORT</a></h2></td>
  </tr>
  <tr>
  <td>
  <div class="fluid-container">
  <div class="geanology-container">
    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="8" bgcolor="
        <?php
		echo($colors_array[0])
		?>
        "><p>
        <strong><?php echo($name_array[0]);?></strong><br>
              (<?php echo($username_array[0]);?>)<br>
           <?php
		   if($did_array[0]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[0]);
		   ?><br>
           <?php
		   if($date_array[0]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[0]);
		   ?>
           </p>
           </td>
      </tr>
      <tr>
        <td colspan="4" style="width:50%;" bgcolor="
        <?php
		echo($colors_array[1])
		?>
        "><p>
        <strong><?php echo($name_array[1]);?></strong><br>
              (<?php echo($username_array[1]);?>)<br>
           <?php
		   if($did_array[1]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[1]);
		   ?><br>
           <?php
		   if($date_array[1]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[1]);
		   ?>
           </p>
           </td>
        <td colspan="4" style="width:50%;" bgcolor="
        <?php
		echo($colors_array[2])
		?>
        "><p>
        <strong><?php echo($name_array[2]);?></strong><br>
              (<?php echo($username_array[2]);?>)<br>
           <?php
		   if($did_array[2]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[2]);
		   ?><br>
           <?php
		   if($date_array[2]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[2]);
		   ?>
           </p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="width:25%;" bgcolor="
        <?php
		echo($colors_array[3])
		?>
        "><p>
        <strong><?php echo($name_array[3]);?></strong><br>
              (<?php echo($username_array[3]);?>)<br>
           <?php
		   if($did_array[3]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[3]);
		   ?><br>
           <?php
		   if($date_array[3]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[3]);
		   ?>
           </p>
           
         </td>
        <td colspan="2" style="width:25%;" bgcolor="
        <?php
		echo($colors_array[4])
		?>
        ">
        <p>
        <strong><?php echo($name_array[4]);?></strong><br>
              (<?php echo($username_array[4]);?>)<br>
           <?php
		   if($did_array[4]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[4]);
		   ?><br>
           <?php
		   if($date_array[4]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[4]);
		   ?>
           </p>
         </td>
        <td colspan="2" style="width:25%;" bgcolor="
        <?php
		echo($colors_array[5])
		?>
        ">
        <p>
        <strong><?php echo($name_array[5]);?></strong><br>

              (<?php echo($username_array[5]);?>)<br>
           <?php
		   if($did_array[5]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[5]);
		   ?><br>
           <?php
		   if($date_array[5]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[5]);
		   ?>
           </p>
           
         </td>
        <td colspan="2" style="width:25%;" bgcolor="
        <?php
		echo($colors_array[6])
		?>
        ">
        <p>
        <strong><?php echo($name_array[6]);?></strong><br>
              (<?php echo($username_array[6]);?>)<br>
           <?php
		   if($did_array[6]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[6]);
		   ?><br>
           <?php
		   if($date_array[6]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[6]);
		   ?>
           </p>
         </td>
      </tr>
      <tr>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[7])
		?>
        ">
        <p>
        <strong><?php echo($name_array[7]);?></strong><br>
              (<?php echo($username_array[7]);?>)<br>
           <?php
		   if($did_array[7]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[7]);
		   ?><br>
           <?php
		   if($date_array[7]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[7]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[8])
		?>
        ">
        <p>
        <strong><?php echo($name_array[8]);?></strong><br>
              (<?php echo($username_array[8]);?>)<br>
           <?php
		   if($did_array[8]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[8]);
		   ?><br>
           <?php
		   if($date_array[8]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[8]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[9])
		?>
        ">
        <p>
        <strong><?php echo($name_array[9]);?></strong><br>
              (<?php echo($username_array[9]);?>)<br>
           <?php
		   if($did_array[9]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[9]);
		   ?><br>
           <?php
		   if($date_array[9]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[9]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[10])
		?>
        ">
        <p>
        <strong><?php echo($name_array[10]);?></strong><br>
              (<?php echo($username_array[10]);?>)<br>
           <?php
		   if($did_array[10]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[10]);
		   ?><br>
           <?php
		   if($date_array[10]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[10]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[11])
		?>
        ">
        <p>
        <strong><?php echo($name_array[11]);?></strong><br>
              (<?php echo($username_array[11]);?>)<br>
           <?php
		   if($did_array[11]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[11]);
		   ?><br>
           <?php
		   if($date_array[11]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[11]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[12])
		?>
        ">
        <p>
        <strong><?php echo($name_array[12]);?></strong><br>
              (<?php echo($username_array[12]);?>)<br>
           <?php
		   if($did_array[12]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[12]);
		   ?><br>
           <?php
		   if($date_array[12]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[12]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[13])
		?>
        ">
        <p>
        <strong><?php echo($name_array[13]);?></strong><br>
              (<?php echo($username_array[13]);?>)<br>
           <?php
		   if($did_array[13]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[13]);
		   ?><br>
           <?php
		   if($date_array[13]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[13]);
		   ?>
           </p>
        </td>
        <td style="width:12.5%;" bgcolor="
        <?php
		echo($colors_array[14])
		?>
        ">
        <p>
        <strong><?php echo($name_array[14]);?></strong><br>
              (<?php echo($username_array[14]);?>)<br>
           <?php
		   if($did_array[14]!="&nbsp;")
		   {
			   echo("DID : ");
		   }
		   echo($did_array[14]);
		   ?><br>
           <?php
		   if($date_array[14]!="&nbsp;")
		   {
			   echo("JOIN DATE : ");
		   }
		   echo($date_array[14]);
		   ?>
           </p>
        </td>
      </tr>
      <tr>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[7]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[7]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[8]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[8]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[9]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[9]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[10]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[10]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[11]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[11]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[12]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[12]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[13]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[13]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
        <td bgcolor="#CCCCCC"><a href="
        <?php
		if($did_array[14]!="&nbsp;")
		{
			echo("downline_chart.php?username=".$username_array[14]);
		}
		else
		{
			echo("#");
		}
		?>
        " onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('See Downline1','','images/down2.gif',1)"><span class="down-arrow"></span></a></td>
      </tr>
    </table>
  </div>
</div>
</td>
</tr>
</table>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
$left_downline_chart=$left_val;
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>

<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_genealogy=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
</body>
</html>