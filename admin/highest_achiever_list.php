<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts/downline_list.php");?>
<?php
$msg="";
if(!empty($_POST) && (isset($_POST['delete_it'])) && ($_POST['delete_it']=="yes"))
{
	$to_delete=$_POST['to_delete'];
	if((filter_var($to_delete, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : invalid request 1.....");
		exit();
	}
	
	$new_conn=new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$to_delete=$new_conn->real_escape_string($to_delete);
		$new_conn->query("DELETE FROM wb_ha WHERE table_id='$to_delete'");
		$new_conn->close();
		$msg="Deleted Successfully...";
		header("Location: /panel/admin/highest_achiever_list.php");
	}
}
?>
<?php
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Panel</title>
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
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<div id="content_main"><br><br>

<table style="width:90%;margin:auto;font-size:1.5em;color:#333;" border="0" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr>
    <td><a href="index.php">Dashboard</a> > Highest Achiever List</td>
  </tr>
</table><br>
<table style="margin-left:5%;font-size:1em;" border="0" cellpadding="3px" cellspacing="0">
  <tr>
    <td><a href="add_income.php">+ Add Income</a></td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;">S.NO</td>
    <td>USERNAME</td>
    <td>NAME</td>
    <td>INCOME</td>
    <td>CITY</td>
    <td></td>
  </tr>
<?php
$sno=1;
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_ha ORDER BY convert(income,decimal) DESC");
	while($detail=$res->fetch_assoc())
	{
		echo("<tr>");
		echo("<td>".$sno."</td>");
		echo("<td>".$detail['username']."</td>");
		echo("<td>".$detail['name']."</td>");
		echo("<td>".$detail['income']."</td>");
		echo("<td>".$detail['city']."</td>");
		echo("<td><a href=\"edit_record.php?ref_id=".$detail['table_id']."\">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"javascript:delete_record('".$detail['table_id']."')\">Delete</a></td>");
		echo("</tr>");
		$sno++;
	}
	$new_conn->close();
}
?>
</table>
<form method="post" name="delete_form">
<input type="hidden" name="to_delete" id="to_delete" value="none" />
<input type="hidden" name="delete_it" id="delete_it" value="no" />
</form>
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include("common/left_menu.php");?>
<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_reports=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function delete_record(val)
{
	var ans=confirm("Delete permanently?");
	if(ans==true)
	{
		$("#delete_it").val("yes");
		$("#to_delete").val(val);
		document.delete_form.submit();
	}
	else
	{
		return false;
	}
}
</script>
</body>
</html>