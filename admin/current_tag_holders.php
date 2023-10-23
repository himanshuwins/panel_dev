<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts/downline_list.php");?>
<?php
$msg="";
?>
<?php
$search_tag="any";
if(isset($_GET['search_tag']))
{
	$search_tag=$_GET['search_tag'];
	if($search_tag=="")
	{
		$search_tag="any";
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
    <td><a href="index.php">Dashboard</a> > Current Tag Holders</td>
  </tr>
</table><br>
<form method="get" name="my_filters_form">
<table style="width:90%;margin:auto;font-size:1.1em;color:#333;line-height:25px;" border="1" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr valign="top">
    <td>
    <table>
    <tr>
    <td>Session No</td>
    <td>:</td>
    <td>
      <select name="search_tag" id="search_tag">
        <option value="any">-all-</option>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT DISTINCT(tag) FROM wb_ud WHERE tag!='company' AND tag!='Executive' ORDER BY tag");
	while($detail=$res->fetch_assoc())
	{
		echo("<option");
		if($search_tag==$detail['tag'])
		{
			echo(" selected");
		}
		echo(">".$detail['tag']."</option>");
	}
	$new_conn->close();
}
?>
      </select>
    </td>
    </tr>
    </table>
    </td>
  </tr>
</table>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="0" cellpadding="3px" cellspacing="0">
  <tr>
    <td align="right" colspan="2">
      <input type="button" value="Search" onClick="validate_form()" />
      <input type="button" value="Reset" onClick="window.location.href='current_tag_holders.php'" /></td>
  </tr>
</table><br>
<input type="hidden" id="search_tag_reset_page" value="<?php echo($search_tag);?>" />
</form>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;">S.NO</td>
    <td>NAME</td>
    <td>USERNAME</td>
    <td>DID</td>
    <td>CONTACT NO</td>
    <td>EMAIL</td>
    <td>ADDRESS</td>
    <td>TAG</td>
  </tr>
  <?PHP
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$search_tag=$new_conn->real_escape_string($search_tag);
	$sno=1;
	$prep="SELECT a.* FROM wb_ud a WHERE tag!='Executive' AND tag!='company' ";
	if($search_tag!="any")
	{
		$prep.=" AND a.tag='$search_tag'";
	}
	$prep.=" ORDER BY a.tag,a.first_name,a.last_name";
	$res=$new_conn->query($prep);
	while($detail=$res->fetch_assoc())
	{
		echo("<tr style=\"color:#000;\" valign=\"top\">");
		echo("<td>".$sno."</td>");
		echo("<td>".$detail['first_name']." ".$detail['last_name']."</td>");
		echo("<td>".$detail['username']."</td>");
		echo("<td>".$detail['did']."</td>");
		echo("<td>".$detail['phone_no']."</td>");
		echo("<td>".$detail['email_id']."</td>");
		echo("<td>".$detail['c_local']);
		echo(",".$detail['city'].", ".$detail['state'].",<br>".$detail['country']."-".$detail['pincode']);
		echo("</td>");
		echo("<td>".$detail['tag']."</td>");
		echo("</tr>");
		$sno++;
	}
	$new_conn->close();
}
?>
</table><br>
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
function validate_form()
{
	document.my_filters_form.submit();
}
</script>
</body>
</html>