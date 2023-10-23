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
if(!empty($_POST))
{
	try
	{
		$old_pass=$_POST['old_pass'];
		$new_pass=$_POST['new_pass'];
		$confirm_pass=$_POST['confirm_pass'];
		
		if(($old_pass=="")||($new_pass=="")||($confirm_pass==""))
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
			$old_pass=$new_conn->real_escape_string($old_pass);
			$new_pass=$new_conn->real_escape_string($new_pass);
			$confirm_pass=$new_conn->real_escape_string($confirm_pass);
			
			$res=$new_conn->query("UPDATE wb_ud SET password='$new_pass' WHERE table_id='$session_id' AND password='$old_pass'");
			if($new_conn->affected_rows==1)
			{
				$new_conn->close();
				$msg="Password changed successfully...";
				$temp_filename_1=$_SERVER['SCRIPT_FILENAME'];
				$temp_filename_2=explode("/",$temp_filename_1);
				$temp_filename=end($temp_filename_2);
				header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
			}
			else
			{
				$new_conn->close();
				throw new Exception('Error : Incorrect current password......');
			}
		}
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
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
    <td align="center"><h2 style="color:#333;line-height:100px;">CHANGE MY PASSWORD</h2></td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend>CHANGE PASSWORD</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td>Current Password</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="password" name="old_pass" style="width:300px;" class="textboxes" id="old_pass" /></td>
          </tr>
          <tr>
            <td>New Password</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="password" name="new_pass" style="width:300px;" id="new_pass" class="textboxes" /></td>
          </tr>
          <tr>
            <td>Confirm New Password</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="password" name="confirm_pass" id="confirm_pass" style="width:300px;" class="textboxes" /></td>
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
<script src="javascript/change_password.js"></script>
<script src="../javascript/error_alert.js"></script>
</body>
</html>