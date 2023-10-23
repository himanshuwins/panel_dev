<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$session_id=$_SESSION['log_id'];
$msg="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	if((filter_var($id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid ID...");
		exit();
	}
}
else
{
	echo("Error : Invalid ID...");
	exit();
}
if(!empty($_POST))
{
	try
	{
		$new_pass=$_POST['new_pass'];
		
		if($new_pass=="")
		{
			echo('Error : Invalid request');
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
			$new_pass=$new_conn->real_escape_string($new_pass);
			
			$res=$new_conn->query("UPDATE wb_ud SET password='$new_pass' WHERE table_id='$id'");
			if($new_conn->affected_rows==1)
			{
				$new_conn->close();
				$msg="Password changed successfully...";
				$temp_filename_1=$_SERVER['SCRIPT_FILENAME'];
				$temp_filename_2=explode("/",$temp_filename_1);
				$temp_filename="change_password_id.php";
				header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
			}
			else
			{
				$new_conn->close();
				throw new Exception('Error : Incorrect current password...');
			}
		}
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
	}
}
?>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT a.password,a.first_name,a.last_name,a.username FROM wb_ud a WHERE a.table_id='$id'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : Username not found...");
		exit();
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Change Password</title>
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
<div id="content_main">
<form name="myform" method="post">
<table style="display:table;margin:auto;font-size:1em;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><h2 style="color:#333;line-height:100px;">CHANGE PASSWORD</h2></td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend>CHANGE PASSWORD</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td>Username</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" disabled value="<?php $user_name_t=$detail['first_name']." ".$detail['last_name'];echo($detail['username']." (".$user_name_t.")");?>" style="width:300px;" class="textboxes" /></td>
          </tr>
          <tr>
            <td>Current Password</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" disabled value="<?php echo($detail['password']);?>" name="old_pass" style="width:300px;" class="textboxes" id="old_pass" /></td>
          </tr>
          <tr>
            <td>New Password</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" name="new_pass" style="width:300px;" id="new_pass" class="textboxes" /></td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr style="height:50px;">
    <td align="right"><div class="buttons" onClick="submit_form()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Now&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;<div class="buttons" onClick="window.location.href = 'index.php';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  </tr>

</table>
</form><br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
$left_change_password=$left_val;
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>

<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_personal_details=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function submit_form()
{
	if($("#new_pass").val()=="")
	{
		alert("Error : Please enter new password...");
		$("#new_pass").focus();
		return false;
	}
	if($("#new_pass").val().length<6)
	{
		alert("Error : New password must be atleast 6 characters long...");
		$("#new_pass").focus();
		return false;
	}
	var old=$("#old_pass").val();
	var new_pass=$("#new_pass").val();
	if(old==new_pass)
	{
		alert("Error : Password change successfully...");
		return false;
	}
	document.myform.submit();
}
</script>
</body>
</html>