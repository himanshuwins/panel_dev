<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$msg="";
$to="";
$subject="";
$message="";
$id="";
$ref_id="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
if(isset($_GET['url_post']))
{
	$url_post=$_GET['url_post'];
}
else
{
	$url_post="domains_to_be_linked.php";
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
else if(isset($_GET['ref_id']))
{
	$ref_id=$_GET['ref_id'];
	if((filter_var($ref_id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid ID 2...");
		exit();
	}
}
else
{
	echo("Error : Invalid ID...");
	exit();
}
?>
<?php
if($id!="")
{
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT b.*,a.first_name,a.last_name,a.username FROM wb_msg b INNER JOIN wb_ud a ON a.table_id=b.by_id WHERE b.table_id='$id' AND b.subject='Domain Registration'");
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
}
else if($ref_id!="")
{
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT b.*,a.first_name,a.last_name,a.username FROM wb_msg b INNER JOIN wb_ud a ON a.table_id=b.by_id WHERE b.by_id='$ref_id' AND b.subject='Domain Registration'");
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
}
?>
<?php
if(!empty($_POST))
{
	$message=$_POST['message'];
	$new_username=$_POST['new_username'];
	$new_password=$_POST['new_password'];
	$cpanel_link=$_POST['cpanel_link'];
	$wordpress_link=$_POST['wordpress_link'];
	if(($new_username=="")||($new_password=="")||($message=="")||($cpanel_link=="")||($wordpress_link==""))
	{
		$echo("Invalid request...");
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
		$new_username=$new_conn->real_escape_string($new_username);
		$new_password=$new_conn->real_escape_string($new_password);
		$cpanel_link=$new_conn->real_escape_string($cpanel_link);
		$wordpress_link=$new_conn->real_escape_string($wordpress_link);
		$message=$new_conn->real_escape_string($message);
		$datetime=date("Y-m-d H:i:s");
		if($id!="")
		{
			$prep="UPDATE wb_msg SET message='$message',cpanel_link='$cpanel_link',cpanel_username='$new_username',cpanel_password='$new_password',wordpress_link='$wordpress_link',datetime='$datetime',created_browser='$browser',created_ip='$ip' WHERE table_id='$id' AND subject='Domain Registration'";
			$new_conn->query($prep);
		}
		else if($ref_id!="")
		{
			$prep="UPDATE wb_msg SET message='$message',cpanel_link='$cpanel_link',cpanel_username='$new_username',cpanel_password='$new_password',wordpress_link='$wordpress_link',datetime='$datetime',created_browser='$browser',created_ip='$ip' WHERE by_id='$ref_id' AND subject='Domain Registration'";
			$new_conn->query($prep);
		}
		$new_conn->close();
		$msg="Saved successfully...";
		$temp_filename=$url_post;
		header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
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
<div id="content_main">
<form name="myform" method="post" onSubmit="return validate_form()">
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="0" cellspacing="0">
  <tr style="height:50px;">
    <td align="center" colspan="2"><h2 style="color:#333;line-height:50px;">REGISTER DOMAIN NAME</h2></td>
  </tr>
  <tr>
    <td colspan="2">
      <fieldset>
        <legend>DOMAIN DETAILS</legend>
        <table border="0" class="tables_fieldset" cellpadding="5px" cellspacing="0">
          <tr>
            <td style="width:150px;">NAME</td>
            <td style="width:20px;">:</td>
            <td>
            <?php
			echo($detail['first_name']." ".$detail['last_name']);
			?>
            </td>
          </tr>
          <tr>
            <td style="width:150px;">USERNAME</td>
            <td style="width:20px;">:</td>
            <td>
            <?php
			echo($detail['username']);
			?>
            </td>
          </tr>
          <tr>
            <td style="width:150px;">DOMAIN NAME</td>
            <td style="width:20px;">:</td>
            <td>
              <input type="text" name="message" id="message" value="<?php echo($detail['message']);?>" class="textboxes" style="width:300px;" />
              &nbsp;<span style="color:#999;letter-spacing:1px;">(e.g. www.domainname.com)</span>
            </td>
          </tr>
          <tr>
            <td style="width:150px;">CPANEL LINK</td>
            <td style="width:20px;">:</td>
            <td>
              <input type="text" name="cpanel_link" id="cpanel_link" value="<?php echo($detail['cpanel_link']);?>" class="textboxes" style="width:300px;" />
            </td>
          </tr>
          <tr>
            <td>USERNAME</td>
            <td>:</td>
            <td>
              <input type="text" name="new_username" id="new_username" value="<?php echo($detail['cpanel_username']);?>" class="textboxes" style="width:300px;" />
            </td>
          </tr>
          <tr>
            <td>PASSWORD</td>
            <td>:</td>
            <td>
              <input type="text" name="new_password" id="new_password" value="<?php echo($detail['cpanel_password']);?>" class="textboxes" style="width:300px;" />
            </td>
          </tr>
          <tr style="height:20px;">
            <td colspan="3"><div style="position:relative;height:1px;border-bottom:1px dotted #AAA;"></div></td>
          </tr>
          <tr>
            <td>WORDPRESS LINK</td>
            <td>:</td>
            <td>
              <input type="text" name="wordpress_link" id="wordpress_link" class="textboxes" value="<?php echo($detail['wordpress_link']);?>" style="width:300px;" />
            </td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr style="height:50px;">
    <td align="right"><div class="buttons" onClick="validate_form()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add Now&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;<div class="buttons" onClick="window.location.href = '<?php echo($url_post);?>';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
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
$top_support_center=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script>
function validate_form()
{
	if($("#message").val()=="")
	{
		alert("Error : Please enter Domain Name...");
		$("#message").focus();
		return false;
	}
	if($("#cpanel_link").val()=="")
	{
		alert("Error : Please enter Cpanel Link...");
		$("#cpanel_link").focus();
		return false;
	}
	if($("#new_password").val()=="")
	{
		alert("Error : Please enter Password...");
		$("#new_password").focus();
		return false;
	}
	if($("#new_username").val()=="")
	{
		alert("Error : Please enter Username...");
		$("#new_username").focus();
		return false;
	}
	if($("#wordpress_link").val()=="")
	{
		alert("Error : Please enter Wordpress Link...");
		$("#wordpress_link").focus();
		return false;
	}
	document.myform.submit();
}
</script>
<script src="../javascript/error_alert.js"></script>
</body>
</html>