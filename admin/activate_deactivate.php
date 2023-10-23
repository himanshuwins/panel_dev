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
		$new_pass=$_POST['new_status'];
		
		if(($new_pass!="active")&&($new_pass!="deactive_terminated")&&($new_pass!="deactive_expired")&&($new_pass!="deactive_payment_not_received"))
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
			$res=$new_conn->query("UPDATE wb_ud SET status='$new_pass' WHERE table_id='$id'");
			if($new_conn->affected_rows==1)
			{
				$new_conn->close();
				$msg="Status changed successfully...";
				$temp_filename="activate_deactivate_id.php";
				header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
			}
			else
			{
				$new_conn->close();
				throw new Exception('Error : Couldn\'t change...Please contact your administrator');
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
	$res=$new_conn->query("SELECT username,status FROM wb_ud WHERE table_id='$id'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : Not found...");
		exit();
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Activate / Deactivate User</title>
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
    <td align="center"><h2 style="color:#333;line-height:100px;">ACTIVATE / DEACTIVATE USER ID</h2></td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend>ACTIVATE / DEACTIVATE</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td>Username</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" disabled value=" <?php echo($detail['username']);?>" style="width:300px;" class="textboxes" /></td>
          </tr>
          <tr>
            <td>Current Status</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" disabled value="<?php echo($detail['status']);?>" name="old_pass" style="width:300px;" class="textboxes" id="old_pass" />
            <input type="hidden" name="old_status" id="old_status" value="<?php echo($detail['status']);?>"/></td>
          </tr>
          <tr>
            <td>New Status</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;">
              <select name="new_status" class="textboxes" id="new_status" style="width:300px;">
                <option value="none">--- select ---</option>
				<?php
				if($detail['status']!="active")
				{
					echo("<option>active</option>");
				}
				?>
				<?php
				if($detail['status']!="deactive_terminated")
				{
					echo("<option>deactive_terminated</option>");
				}
				?>
				<?php
				if($detail['status']!="deactive_expired")
				{
					echo("<option>deactive_expired</option>");
				}
				?>
				<?php
				if($detail['status']!="deactive_payment_not_received")
				{
					echo("<option>deactive_payment_not_received</option>");
				}
				?>
              </select>
            </td>
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
$left_act_deact=$left_val;
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
	var old=$("#old_status").val();
	if(old=="active")
	{
		old="Activate";
	}
	else if(old=="inactive")
	{
		old="Deactivate";
	}
	if($("#new_status").val()=="none")
	{
		alert("Error : Please select new status for the ID...");
		$("#new_status").focus();
		return false;
	}
	if($("#new_status").val()==old)
	{
		alert("Status changed successfully...");
		return false;
	}
	document.myform.submit();
}
</script>
</body>
</html>