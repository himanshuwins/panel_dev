<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$start="0";
$start_1="0";
if(isset($_GET['page']))
{
	$start=$_GET['page'];
	$start_1=$_GET['page'];
	if((filter_var($start, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		$start="0";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>My Directs</title>
<script src="../javascript/jquery_file.js"></script>
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
</style>
</head>
<body>
<div id="content_main"><br><br>

<table style="width:90%;margin:auto;font-size:1.5em;color:#333;" border="0" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr>
    <td><a href="index.php">Dashboard</a> > My Directs</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;">S.NO</td>
    <td style="width:100px;">ID</td>
    <td>NAME</td>
    <td>CITY, STATE</td>
    <td>PHONE NO</td>
    <td>EMAIL ID</td>
    <td>REGISTRATION DATE</td>
    <td>STATUS</td>
  </tr>
<?php
$session_id=$_SESSION['log_id'];
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$per_page="10";
	$start=$start*$per_page;
	$sno=$start_1*$per_page+1;
	$res=$new_conn->query("SELECT SQL_CALC_FOUND_ROWS a.id,a.first_name,a.last_name,a.created_date,a.phone_no,a.email_id,a.c_city,a.c_state,b.status FROM mlm_user_details a INNER JOIN mlm_login b ON a.id=b.id WHERE b.sponsor_id='$session_id' ORDER BY a.first_name,a.last_name,a.id LIMIT $start,$per_page");
	$res_total=$new_conn->query("SELECT FOUND_ROWS() AS total");
	$detail_total=$res_total->fetch_assoc();
	$total=$detail_total['total'];
	$pages_1=$total%$per_page;
	$pages=(int)($total/$per_page);
	if($pages_1>0)
	{
		$pages++;
	}
	while($detail=$res->fetch_assoc())
	{
		echo("<tr style=\"color:#000;\" valign=\"top\">");
		echo("<td>".$sno."</td>");
		echo("<td>".$detail['id']."</td>");
		echo("<td>".$detail['first_name']." ".$detail['last_name']."</td>");
		echo("<td>".$detail['c_city'].", ".$detail['c_state']."</td>");
		$phone=explode(",",$detail['phone_no']);
		$total_phone_no=count($phone);
		echo("<td>");
		for($i=0;$i<$total_phone_no;$i++)
		{
			echo($phone[$i]."<br />");
		}
		echo("</td>");
		$phone=explode(",",$detail['email_id']);
		$total_phone_no=count($phone);
		echo("<td>");
		for($i=0;$i<$total_phone_no;$i++)
		{
			echo($phone[$i]."<br />");
		}
		echo("</td>");
		echo("<td>".$detail['created_date']."</td>");
		echo("<td>".ucfirst($detail['status'])."</td>");
		echo("</tr>");
		$sno++;
	}
	$new_conn->close();
}
?>
</table>
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="3px" cellspacing="0" class="page_no">
  <tr>
    <td>
      <table>
<?php
if($pages>1)
{
	echo("<tr>");
	echo("<td>Page : </td>");
	for($i=1;$i<=$pages;$i++)
	{
		$j=$i-1;
		if($start_1==$j)
		{
			echo("<td>&nbsp;".$i."&nbsp;</td>");
		}
		else
		{
			echo("<td>&nbsp;<a href=\"my_directs.php?page=".$j."\">".$i."</a>&nbsp;</td>");
		}
	}
	echo("</tr>");
}
?>
      </table>
    </td>
  </tr>
</table>
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>
<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_genealogy=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
</body>
</html>