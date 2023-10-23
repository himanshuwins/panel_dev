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
$session_id=$_SESSION['log_id'];
?>
<?php
if(!empty($_POST)&&($_POST['submitted']=="yes"))
{
	require("webillions_session_close.php");
	if($to_reply=="ok")
	{
		$msg="Session closed successfully";
		$temp_filename="index.php";
		//header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
	}
	else
	{
		$msg="Error : Unable to close session";
		$temp_filename="close_session.php";
		//header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Close Session</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<style>
legend{
font-weight:bold;
font-size:1.1em;
color:#333;
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
    <td><a href="index.php">Dashboard</a> > Close Session</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="3px" cellspacing="0">
  <tr>
    <td>
      <fieldset>
        <legend>CLOSE SESSION</legend>
        <form name="myform" method="post">
        <table class="tables_fieldset">
          <tr>
            <td>NOTE : Closing this session generates payment report for all IDs and <span style="color:#C00;">cannot be UNDO</span></td>
          </tr>
          <tr style="height:150px;">
            <td align="center"><div class="buttons" onClick="submitform()">&nbsp;&nbsp;&nbsp;Close Session Now&nbsp;&nbsp;&nbsp;</div></td>
          </tr>
        </table>
        <input type="hidden" name="submitted" id="submitted" value="no" />
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
$top_session=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="../javascript/jquery_file.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function submitform()
{
	var temp=confirm("Are you sure you want to close session now ?");
	if(temp==true)
	{
		$("#submitted").val("yes");
		document.myform.submit();
	}
	else
	{
	}
}
</script>
</body>
</html>