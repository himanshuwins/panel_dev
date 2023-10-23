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
<title>Used E-Pins</title>
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
    <td><a href="index.php">Dashboard</a> > Used E-Pins</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;">S.NO</td>
    <td>E-PIN NO</td>
    <td>REQUEST NO</td>
    <td>DATE OF ISSUE</td>
    <td>AMOUNT</td>
    <td>MODE</td>
    <td>ISSUED TO</td>
    <td>USED FOR</td>
    <td>USED ON</td>
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
	$per_page="50";
	$start=$start*$per_page;
	$sno=$start_1*$per_page+1;
	$res=$new_conn->query("SELECT SQL_CALC_FOUND_ROWS a.req_no,a.epin,a.updated_date,a.mode,a.dd_no,a.dd_date,a.dd_bank,a.dd_branch,a.cheque_no,a.cheque_date,a.cheque_bank,a.cheque_branch,a.created_by,a.used_by,b.username AS issued_to_username,b.first_name AS issued_to_first,b.last_name AS issued_to_last,c.username AS used_to_username,c.first_name AS used_to_first,c.last_name AS used_to_last,c.created_date AS date_of_use,d.price FROM wb_epins a INNER JOIN wb_ud b ON a.created_by=b.table_id INNER JOIN wb_ud c ON a.used_by=c.table_id INNER JOIN wb_ps d ON d.product_id=a.epin_product_code WHERE a.status='used' ORDER BY c.created_date DESC LIMIT $start,$per_page");
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
		echo("<td>".$detail['epin']."</td>");
		echo("<td>EP".$detail['req_no']."</td>");
		echo("<td>".$detail['updated_date']."</td>");
		echo("<td>".$detail['price']."</td>");
		echo("<td>".strtoupper($detail['mode']));
		if($detail['mode']=="dd")
		{
			echo("<br><span style=\"font-weight:bold;text-decoration:underline;\">Demand Draft details</span>");
			echo("<br>DD No : ".$detail['dd_no']);
			echo("<br>DD Date : ".$detail['dd_date']);
			echo("<br>DD Bank : ".$detail['dd_bank']);
			echo("<br>DD Branch : ".$detail['dd_branch']);
		}
		else if($detail['mode']=="cheque")
		{
			echo("<br><span style=\"font-weight:bold;text-decoration:underline;\">Cheque details</span>");
			echo("<br>Cheque No : ".$detail['cheque_no']);
			echo("<br>Cheque Date : ".$detail['cheque_date']);
			echo("<br>Cheque Bank : ".$detail['cheque_bank']);
			echo("<br>Cheque Branch : ".$detail['cheque_branch']);
		}
		echo("</td>");
		echo("<td>".$detail['issued_to_username']." (".$detail['issued_to_first']." ".$detail['issued_to_last'].")</td>");
		echo("<td>".$detail['used_to_username']." (".$detail['used_to_first']." ".$detail['used_to_last'].")</td>");
		echo("<td>".$detail['date_of_use']."</td>");
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
			echo("<td>&nbsp;<a href=\"used_epins.php?page=".$j."\">".$i."</a>&nbsp;</td>");
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
$top_epin=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>

</body>
</html>