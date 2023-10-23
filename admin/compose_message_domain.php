<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$to_reply="none";
$to_disabled="";
if(isset($_GET['reply_id']))
{
	$to_reply=$_GET['reply_id'];
	$to_disabled=" disabled";
	if((filter_var($to_reply, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Invalid request");
		exit();
	}
}
?>
<?php
$msg="";
$to="";
$message="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
if(!empty($_POST))
{
	$to=$_POST['to'];
	if($to_reply!="none")
	{
		$to=$to_reply;
	}
	$message=$_POST['message'];
	if(($message==""))
	{
		$echo("Invalid request...");
		exit();
	}
	
	$to_db=$to;
	$message_db=nl2br($message);
	$session_id=$_SESSION['log_id'];
	
	$ip=$_SERVER['REMOTE_ADDR'];
	$browser=$_SERVER['HTTP_USER_AGENT'];
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$to_db=$new_conn->real_escape_string($to_db);
		$message_db=$new_conn->real_escape_string($message_db);
		$res_check=$new_conn->query("SELECT * FROM wb_ud WHERE username='$to_db'");
		if($res_check->num_rows==1)
		{
			
			$detail_check=$res_check->fetch_assoc();
			$to_id=$detail_check['table_id'];
			
		if($new_conn->query("INSERT INTO wb_msg(for_id,by_id,subject,message,created_ip,created_browser) VALUES('$to_id','admin','Domain Registration','$message_db','$ip','$browser')"))
		{
			$new_conn->close();
			$msg="Message sent successfully...";
			$temp_filename="domain_outbox.php";
			header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
		}
		else
		{
			$msg="Error : Database error..Pleas contact your administrator...";
			$new_conn->close();
		}
		
		}
		else
		{
			$msg="Error : Recipient Username not found...";
			$new_conn->close();
		}
	}	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Compose Message</title>
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
<form name="myform" method="post" onSubmit="return send_message()">
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="0" cellspacing="0">
  <tr style="height:50px;">
    <td align="center" colspan="2"><h2 style="color:#333;line-height:50px;">COMPOSE MESSAGE</h2></td>
  </tr>
  <tr>
    <td colspan="2">
      <fieldset>
        <legend>COMPOSE NEW MESSAGE</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:150px;">TO (Username)</td>
            <td style="width:20px;">:</td>
            <td>
            <input type="text" value="<?php echo($to);?>" name="to" style="width:99%;" id="to" class="textboxes" />
            </td>
          </tr>
          <tr>
            <td>SUBJECT</td>
            <td>:</td>
            <td><input type="text" value="Domain Registration" name="subject" disabled style="width:99%;" id="subject" class="textboxes" /></td>
          </tr>
          <tr valign="top">
            <td style="line-height:30px;">MESSAGE</td>
            <td style="line-height:30px;">:</td>
            <td>
              <textarea rows="20" value="<?php echo($message);?>" class="textboxes" style="width:98%;resize:none;" name="message" id="message"></textarea>
            </td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr style="height:50px;">
    <td align="right"><div class="buttons" onClick="send_message()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Send&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;<div class="buttons" onClick="window.location.href = 'index.php';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  </tr>

</table>
</form><br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>
<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_domain=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>

function send_message()
{
	if($("#to").val()=="")
	{
		alert("Error : Please enter recepient...");
		$("#to").focus();
		return false;
	}
	if($("#message").val()=="")
	{
		alert("Error : Please enter a message...");
		$("#message").focus();
		return false;
	}
	document.myform.submit();
}
</script>
</body>
</html>