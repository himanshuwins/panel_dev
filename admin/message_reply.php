<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
if(isset($_GET['msg_id']))
{
	$msg_id=$_GET['msg_id'];
	if((filter_var($msg_id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Invalid request");
		exit();
	}
	else
	{
	}
}
else
{
	echo("Invalid request");
	exit();
}
?>
<?php
if(!empty($_POST))
{
	$new_remarks=$_POST['new_remarks'];
	if($new_remarks=="")
	{
		echo("Error : Remarks cannot be empty...");
		exit();
	}
	$new_remarks=nl2br($new_remarks);
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$new_remarks=$new_conn->real_escape_string($new_remarks);
		if(!($new_conn->query("INSERT INTO wb_remarks(msg_id,remarks,created_by,created_ip,created_browser) VALUES('$msg_id','$new_remarks','{$_SESSION['log_id']}','{$_SERVER['REMOTE_ADDR']}','{$_SERVER['HTTP_USER_AGENT']}')")))
		{
			$new_conn->close();
			echo("Error : Couldn't add new remarks...Please contact your administrator");
			exit();
		}
		$new_conn->query("UPDATE wb_msg SET last_reply_by='admin' WHERE table_id='$msg_id'");
		$new_conn->close();
		header("Location: /panel/admin/message_reply.php?msg_id=".$msg_id);
	}
}
?>
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
	$res=$new_conn->query("SELECT a.*,b.username FROM wb_msg a INNER JOIN wb_ud b ON b.table_id=a.by_id WHERE a.table_id='$msg_id' AND a.for_id='admin'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
	}
	$new_conn->close();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Message</title>
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
    <td><a href="index.php">Dashboard</a> > Reply</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#333;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <fieldset>
        <legend>ORIGINAL MESSAGE</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:150px;">FROM</td>
            <td style="width:10px;">:</td>
            <td style="font-weight:400;"><?php echo($detail['username']);?></td>
          </tr>
          <tr style="height:10px;">
            <td colspan="3"></td>
          </tr>
          <tr>
            <td>DATE</td>
            <td>:</td>
            <td style="font-weight:400;"><?php echo($detail['datetime']);?></td>
          </tr>
          <tr style="height:10px;">
            <td colspan="3"></td>
          </tr>
          <tr>
            <td>SUBJECT</td>
            <td>:</td>
            <td style="font-weight:400;"><?php echo($detail['subject']);?></td>
          </tr>
          <tr style="height:10px;">
            <td colspan="3"></td>
          </tr>
          <tr valign="top">
            <td>MESSAGE</td>
            <td>:</td>
            <td style="font-weight:400;"><?php echo($detail['message']);?></td>
          </tr>
        </table>
      </fieldset><br><br>
      <fieldset>
        <legend>REMARKS</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0" style="font-weight:400;">
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
	$sno=1;
	$res_2=$new_conn->query("SELECT a.*,b.username,b.first_name,b.last_name FROM wb_remarks a INNER JOIN wb_ud b ON b.table_id=a.created_by WHERE a.msg_id='{$detail['table_id']}' ORDER BY a.created_date");
	if($res_2->num_rows>0)
	{
	while($detail_2=$res_2->fetch_assoc())
	{
		echo("<tr>");
		echo("<td style=\"line-height:25px;font-weight:bold;text-decoration:underline;\">Remarks ".$sno." added by</span> ".$detail_2['first_name']." ".$detail_2['last_name']."(".$detail_2['username'].") at ".$detail_2['created_date']."</td>");
		echo("</tr>");
		echo("<tr>");
		echo("<td>".$detail_2['remarks']."</td>");
		echo("</tr>");
		echo("<tr style=\"height:30px;\"><td></td></tr>");
		$sno++;
	}
	}
	else
	{
		echo("<span style=\"color:#F00;font-weight:bold;\">No remarks yet...</span>");
	}
	$new_conn->close();
}
?>
        </table>
      </fieldset><br><br>
      <form method="post" name="new_remarks_form" onSubmit="return validate_form()">
      <textarea style="width:98%;resize:none;" name="new_remarks" id="new_remarks" required placeholder=" New remarks here..." rows="10"></textarea><br><br>
      <input type="submit" value="Add Remarks Now" />
    </td>
  </tr>
  <tr style="height:50px;">
    <td align="right"><div class="buttons" onClick="window.location.href = 'inbox.php';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
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
$top_support_center=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script>
function validate_form()
{
	if($("#new_remarks").val()=="")
	{
		alert("Error : Please enter the remarks first...");
		$("#new_remarks").focus();
		return false;
	}
	else
	{
		document.new_remarks_form.submit();
	}
}
</script>
</body>
</html>