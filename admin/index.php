<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts/parse_downline.php");?>
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
$session_id=$_SESSION['log_id'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<div id="content_main">
<table style="width:90%;margin:auto;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td style="width:20px;" rowspan="4"></td>
    <td></td>
  </tr>
  <tr>
    <td style="width:70%;height:100px;">&nbsp;</td>
    <td><div style="position:relative;background-color:#565555;background-image:url(../images/notification.png);background-repeat:no-repeat;line-height:26px;padding-left:40px;color:#FC0;font-size:14px;font-weight:bold;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;">USER ID : <?php echo($_SESSION['log_username']);?></div></td>
  </tr>
  <tr>
    <td style="background-color:#FFF;padding:20px;-webkit-box-shadow:0px 0px 5px #999;-moz-box-shadow:0px 0px 5px #999;box-shadow:0px 0px 5px #999;">&nbsp;
    
    </td>
    <td valign="top">
      <table cellpadding="0" cellspacing="0">
        <tr style="border:none;padding:0;margin:0;">
                <td style="border:none;padding:0;margin:0;">
                <a href="epin_requests_received.php?notify=a">
                <div style="position:relative;height:20px;width:20px;background-image:url(images/img1.png);">
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT a.epin,a.epin_product_code,a.updated_date,a.mode,a.dd_no,a.dd_date,a.dd_bank,a.dd_branch,a.cheque_no,a.cheque_date,a.cheque_bank,a.cheque_branch,b.name,b.price,b.currency FROM wb_epins a INNER JOIN wb_ps b ON b.product_id=a.epin_product_code WHERE a.status='pending' AND a.viewed_or_not_admin='no'");
	if($res->num_rows>0)
	{
		echo("<div style=\"position:absolute;right:-10px;top:-10px;padding:0 5px;-webkit-border-radius:3px;background-color:#F00;color:#FFF;font-weight:400;font-size:10px;line-height:15px;\">");
		echo($res->num_rows);
		echo("</div>");
	}
	$new_conn->close();
}
?>
</div>
</a>
                </td>
                <td style="border:none;padding:0;padding-left:15px;margin:0;">
                <a href="inbox_not_answered.php?notify=a">
                <div style="position:relative;height:20px;width:20px;background-image:url(images/img2.png);">
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE for_id='admin' AND subject!='Domain Registration' AND read_or_not_admin='no'");
	if($res->num_rows>0)
	{
		echo("<div style=\"position:absolute;right:-10px;top:-10px;padding:0 5px;-webkit-border-radius:3px;background-color:#F00;color:#FFF;font-weight:400;font-size:10px;line-height:15px;\">");
		echo($res->num_rows);
		echo("</div>");
	}
	$new_conn->close();
}
?>
</div>
</a>
                </td>
                <td style="border:none;padding:0;padding-left:15px;margin:0;">
		<a href="domains_to_be_linked.php?notify=a">
        <div style="position:relative;height:20px;width:20px;background-image:url(images/img3.png);">
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE for_id='admin' AND subject='Domain Registration' AND read_or_not_admin='no' AND cpanel_link=''");
	if($res->num_rows>0)
	{
		echo("<div style=\"position:absolute;right:-10px;top:-10px;padding:0 5px;-webkit-border-radius:3px;background-color:#F00;color:#FFF;font-weight:400;font-size:10px;line-height:15px;\">");
		echo($res->num_rows);
		echo("</div>");
	}
	$new_conn->close();
}
?>
		</div>
		</a>
                </td>
                </tr>
                </table><br>
      
      
      <div style="position:relative;">
        <div style="position:relative;background-color:#565555;line-height:40px;color:#f1f1f1;font-size:16px;-webkit-border-top-left-radius:8px;-moz-border-top-left-radius:8px;border-top-left-radius:8px;-webkit-border-top-right-radius:8px;-moz-border-top-right-radius:8px;border-top-right-radius:8px;letter-spacing:1px;">&nbsp;&nbsp;Profile Status</div>
        <div style="position:relative;border-left:2px solid #565555;padding:5px;border-right:2px solid #565555;border-bottom:2px solid #565555;background-color:#FFF;">
          <table style="width:100%;font-size:12px;color:#565555;line-height:22px;">
            <tr valign="top">
              <td style="font-weight:bold;">Name</td>
              <td style="font-weight:bold;">:</td>
              <td><?php echo($_SESSION['log_name']);?></td>
            </tr>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$prepared="SELECT * FROM wb_ud a WHERE a.table_id='$session_id'";
	$res=$new_conn->query($prepared);
	$detail=$res->fetch_assoc();
	$new_conn->close();
	$email_id=$detail['email_id'];
	$phone_no=$detail['phone_no'];
	$last_login=$detail['last_login_date'];
	$temp_last_login=explode("!@!@",$last_login);
	if(count($temp_last_login)>1)
	{
		$total=count($temp_last_login);
		$total=$total-2;
		$last_login=$temp_last_login[$total];
	}
	else
	{
		$last_login=end($temp_last_login);
	}
}
?>
            <tr valign="top">
              <td style="font-weight:bold;">Phone no</td>
              <td style="font-weight:bold;">:</td>
              <td><?php echo($phone_no);?></td>
            </tr>
            <tr valign="top">
              <td style="font-weight:bold;">Email Id</td>
              <td style="font-weight:bold;">:</td>
              <td><?php echo($email_id);?></td>
            </tr>
            <tr valign="top">
              <td style="font-weight:bold;">Last Login</td>
              <td style="font-weight:bold;">:</td>
              <td><?php echo($last_login);?></td>
            </tr>
          </table>
        </div>
      </div><br><br><br>
        <div style="position:relative;background-color:#565555;line-height:40px;color:#f1f1f1;font-size:16px;-webkit-border-top-left-radius:8px;-moz-border-top-left-radius:8px;border-top-left-radius:8px;-webkit-border-top-right-radius:8px;-moz-border-top-right-radius:8px;border-top-right-radius:8px;letter-spacing:1px;">&nbsp;&nbsp;Latest Sales</div>
        <div style="position:relative;border-left:2px solid #565555;border-right:2px solid #565555;border-bottom:2px solid #565555;background-color:#FFF;padding:5px;">
          <table style="width:100%;font-size:12px;color:#565555;line-height:22px;" border="0">
            <tr style="font-weight:bold;color:#565555;" valign="top">
              <td style="width:30px;">S.NO</td>
              <td>&nbsp;USERNAME</td>
              <td>NAME</td>
            </tr>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$downline_array=array();
	parse_downline($new_conn,$session_id,$downline_array);
	if(count($downline_array)==0)
	{
		$pages="0";
	}
	else
	{
		$total=count($downline_array);
		$downlinestring=implode(",",$downline_array);
		$sno="1";
		$res=$new_conn->query("SELECT username,table_id,first_name,last_name FROM wb_ud WHERE table_id IN($downlinestring) ORDER BY table_id DESC LIMIT 0,5");
		while($detail=$res->fetch_assoc())
		{
			echo("<tr valign=\"top\">");
			echo("<td>".$sno."</td>");
			echo("<td>&nbsp;".$detail['username']."</td>");
			echo("<td>".$detail['first_name']." ".$detail['last_name']."</td>");
			echo("</tr>");
			$sno++;
		}
	}
	$new_conn->close();
}
?>
            <tr>
              <td colspan="3" align="right"><a href="downline_list.php">view all</a></td>
            </tr>
          </table>
        </div>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</div>
<?php include("common/left_menu_var.php");?>
<?php
$left_dashboard=$left_val;
?>
<?php include("common/left_menu.php");?>
<?php include("common/main_menu_var.php");?>
<?php
$top_dashboard=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="../javascript/jquery_file.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
</body>
</html>