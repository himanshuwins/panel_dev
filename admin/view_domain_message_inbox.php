<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
if(isset($_GET['msg']))
{
	$msg_id=$_GET['msg'];
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
		if($detail['read_or_not']=="unread")
		{
			$new_conn->query("UPDATE wb_msg SET read_or_not='read' WHERE table_id='$msg_id'");
		}
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
    <td><a href="index.php">Dashboard</a> > <a href="inbox.php">Domain Inbox</a> > View Message</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#333;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <fieldset>
        <legend>VIEW MESSAGE</legend>
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
      </fieldset>
    </td>
  </tr>
  <tr style="height:50px;">
    <td align="right"><div class="buttons" onClick="window.location.href = 'domain_inbox.php';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
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
$top_domain=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
</body>
</html>