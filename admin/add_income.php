<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts/downline_list.php");?>
<?php
$msg="";
if(!empty($_POST))
{
	$in_username=$_POST['in_username'];
	$in_name=$_POST['in_name'];
	$in_income=$_POST['in_income'];
	$in_city=$_POST['in_city'];
	
	if((($in_username=="")&&($in_name==""))||(($in_username=="")&&($in_city==""))||($in_income==""))
	{
		echo("Error : empty details....");
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
		$in_username=$new_conn->real_escape_string($in_username);
		$in_name=$new_conn->real_escape_string($in_name);
		$in_income=$new_conn->real_escape_string($in_income);
		$in_city=$new_conn->real_escape_string($in_city);
		if($in_name=="")
		{
			$res=$new_conn->query("SELECT * FROM wb_ud WHERE username='$in_username'");
			if($res->num_rows!=1)
			{
				$new_conn->close();
				echo("Error : username not found...");
				exit();
			}
			$detail=$res->fetch_assoc();
			$in_name=$detail['first_name']." ".$detail['last_name'];
			$in_city=$detail['city'];
		}
		
		if(!($new_conn->query("INSERT INTO wb_ha(name,username,income,city) VALUES('$in_name','$in_username','$in_income','$in_city')")))
		{
			$new_conn->close();
			echo("Error : Couldn't create");
			exit();
		}
		$new_conn->close();
		$msg="Added Successfully...";
		header("Location: /panel/admin/highest_achiever_list.php");
	}
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
    <td><a href="index.php">Dashboard</a> > Add Income</td>
  </tr>
</table><br>
<form name="new_income_form" method="post" onSubmit="return validate_form()">
<fieldset style="display:inline-block;margin-left:5%;">
<legend>NEW INCOME DETAILS</legend>
<table style="font-size:1em;color:#000;" border="0" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;">
    <td>Username</td>
    <td style="padding:0 5px;">:</td>
    <td><input type="text" name="in_username" id="in_username" /></td>
  </tr>
  <tr style="font-weight:bold;">
    <td>Name</td>
    <td style="padding:0 5px;">:</td>
    <td><input type="text" name="in_name" id="in_name" /></td>
  </tr>
  <tr style="font-weight:bold;">
    <td>Income</td>
    <td style="padding:0 5px;">:</td>
    <td><input type="text" name="in_income" id="in_income" required /></td>
  </tr>
  <tr style="font-weight:bold;">
    <td>City</td>
    <td style="padding:0 5px;">:</td>
    <td><input type="text" name="in_city" id="in_city" /></td>
  </tr>
  <tr style="height:10px;">
    <td colspan="3"></td>
  </tr>
  <tr style="font-weight:bold;">
    <td colspan="3"><input type="submit" value="Add Now" /></td>
  </tr>
</table>
</fieldset>
</form><br>
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>
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
	if(($("#in_username").val()=="")&&($("#in_name").val()==""))
	{
		alert("Error : please enter either username or name or both");
		$("#in_username").focus();
		return false;
	}
	if($("#in_income").val()=="")
	{
		alert("Error : please enter income");
		$("#in_income").focus();
		return false;
	}
	if(($("#in_username").val()=="")&&($("#in_city").val()==""))
	{
		alert("Error : please enter either username or city or both");
		$("#in_username").focus();
		return false;
	}
	document.new_income_form.submit();
}
</script>
</body>
</html>