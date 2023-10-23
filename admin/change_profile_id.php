<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$msg="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
<?php
if(!empty($_POST))
{
	$id=$_POST['id'];
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$id=$new_conn->real_escape_string($id);
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE username='$id'");
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$new_conn->close();
			$msg="";
			$temp_filename="change_profile.php?id=".$detail['table_id'];
			header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
		}
		else
		{
			$new_conn->close();
			$msg="Not found...";
		}
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>View / Edit Profile</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<div id="content_main"><br>
<table style=";margin:auto;" border="0" cellpadding="0" cellspacing="0">
  <tr style="height:100px;">
    <td align="center"><h2 style="color:#333;">VIEW / EDIT PROFILE</h2></td>
  </tr>
  <tr>
    <td>
      <fieldset style="padding:20px;">
        <legend>ENTER ID TO CHANGE</legend>
        <form name="myform" method="post">
        <table style="min-width:300px;">
          <tr style="font-weight:bold;">
            <td>Username</td>
            <td>:</td>
            <td><input type="text" name="id" id="id" style="width:100%;" /></td>
          </tr>
          <tr>
            <td colspan="3" align="right"><div class="buttons" onClick="submit_form()">&nbsp;&nbsp;&nbsp;Continue&nbsp;&nbsp;&nbsp;</div></td>
          </tr>
        </table>
        </form>
      </fieldset>
    </td>
  </tr>
</table>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>

<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_personal_details=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="../javascript/jquery_file.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function submit_form()
{
	if($("#id").val()=="")
	{
		alert("Error : Please enter ID first...");
		$("#id").focus();
		return false;
	}
	document.myform.submit();
}
</script>
</body>
</html>