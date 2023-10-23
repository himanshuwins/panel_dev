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
$view="no";
$epin="";
if(isset($_GET['epin_value']))
{
	$epin=$_GET['epin_value'];
}
if($epin!="")
{
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$epin=$new_conn->real_escape_string($epin);
		$res=$new_conn->query("SELECT a.*,b.first_name,b.last_name,b.username FROM wb_epins a INNER JOIN wb_ud b ON b.table_id=a.created_by WHERE a.epin='$epin' AND (a.status='issued' OR a.status='issued_inactive') AND a.used_by='N/A'");
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$new_conn->close();
			$view="yes";
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
<table style="margin:auto;" border="0" cellpadding="0" cellspacing="0">
  <tr style="height:100px;">
    <td align="center"><h2 style="color:#333;">ACTIVATE/DEACTIVATE EPIN</h2></td>
  </tr>
  <tr>
    <td>
      <fieldset style="padding:20px;">
        <legend>ENTER EPIN TO CHANGE</legend>
        <form name="myform" method="get">
        <table style="min-width:300px;">
          <tr style="font-weight:bold;">
            <td>Epin</td>
            <td>:</td>
            <td><input type="text" name="epin_value" id="epin_value" style="width:100%;" /></td>
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
<?php
if($view=="yes")
{
	echo("<br><br>");
	echo("<table cellspacing=\"0\" cellpadding=\"3px\" border=\"1\" style=\"margin:auto;\">");
	echo("<tr style=\"font-weight:bold;\">");
	echo("<td>E-Pin</td>");
	echo("<td>Status</td>");
	echo("<td>Issued To</td>");
	echo("<td>Issued On</td>");
	echo("<td></td>");
	echo("</tr>");
	echo("<tr>");
	echo("<td>".$epin."</td>");
	echo("<td id=\"status_td\">");
	if($detail['status']=="issued")
	{
		echo("active");
	}
	else if($detail['status']=="issued_inactive")
	{
		echo("inactive");
	}
	echo("</td>");
	echo("<td>".$detail['username']." (".$detail['first_name']." ".$detail['last_name'].")</td>");
	echo("<td>".$detail['updated_date']."</td>");
	echo("<td id=\"action_td\">");
	if($detail['status']=="issued")
	{
		echo("<a href=\"javascript:deactivate_epin('".$detail['table_id']."')\">Deactivate Now</a>");
	}
	else if($detail['status']=="issued_inactive")
	{
		echo("<a href=\"javascript:activate_epin('".$detail['table_id']."')\">Activate Now</a>");
	}
	echo("</td>");
	echo("</tr>");
	echo("</table>");
}
?>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>

<?php include("common/main_menu_var.php");?>
<?php
$top_epin=$top_val;
?>
<?php include("common/main_menu.php");?>
<div id="blackout">
          	<div id="canvasloader-container" style="position:absolute;left:50%;top:50%;margin-left:-25px;margin-top:-25px;" class="wrapper">
            <img src="../images/495.GIF" height="50px"  /></div>
            </div>
</div>
<script src="../javascript/jquery_file.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function submit_form()
{
	if($("#epin_value").val()=="")
	{
		alert("Error : Please enter Epin first...");
		$("#epin_value").focus();
		return false;
	}
	document.myform.submit();
}
</script>
<script src="javascript/update_epin_status.js"></script>
</body>
</html>