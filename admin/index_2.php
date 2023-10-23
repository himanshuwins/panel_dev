<?php include(dirname(__FILE__)."/../php_scripts/check_admin.php");?>
<?php include(dirname(__FILE__)."/../php_scripts/connection.php");?>
<?php include(dirname(__FILE__)."/php_scripts/downline_list.php");?>
<?php
$session_id=$_SESSION['log_id'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
<div id="content_main">
<table style="width:90%;margin:auto;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td style="width:20px;" rowspan="4"></td>
    <td></td>
  </tr>
  <tr>
    <td style="width:70%;height:100px;"><img src="../images/genericlrg.png" height="70px" /></td>
    <td><div style="position:relative;background-color:#565555;background-image:url(../images/notification.png);background-repeat:no-repeat;line-height:26px;padding-left:40px;color:#FC0;font-size:14px;font-weight:bold;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;">USER ID : <?php echo($_SESSION['log_id']);?></div></td>
  </tr>
  <tr>
    <td>
      <table style="width:100%;" border="0" cellpadding="0" border="0" cellspacing="0">
        <tr>
          <td align="center" style="width:32%;"><img src="../images/watch-1.png" style="width:80%;" /></td>
          <td style="width:2%;" rowspan="2"></td>
          <td style="width:32%;"><img src="../images/pen-new.png" style="width:100%;" /></td>
          <td style="width:2%;" rowspan="2"></td>
          <td style="width:32%;"><img src="../images/suitcase_1.png" style="width:100%;" /></td>
        </tr>
        <tr>
          <td style="width:32%;"><img src="../images/suitcase_2.png" style="width:100%;" /></td>
          <td align="center" style="width:32%;"><img src="../images/watch-2.png" style="width:80%;" /></td>
          <td style="width:32%;"><img src="../images/pen-new-2.png" style="width:100%;" /></td>
        </tr>
      </table>
    </td>
    <td valign="top">
      <div style="position:relative;">
        <div style="position:relative;background-color:#565555;line-height:40px;color:#f1f1f1;font-size:16px;-webkit-border-top-left-radius:8px;-moz-border-top-left-radius:8px;border-top-left-radius:8px;-webkit-border-top-right-radius:8px;-moz-border-top-right-radius:8px;border-top-right-radius:8px;letter-spacing:1px;">&nbsp;&nbsp;Profile Status</div>
        <div style="position:relative;border-left:2px solid #565555;border-right:2px solid #565555;border-bottom:2px solid #565555;">
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
	$res=$new_conn->query("SELECT a.phone_no,a.email_id,b.last_login_date FROM mlm_user_details a INNER JOIN mlm_login b ON a.id=b.id WHERE a.id='$session_id'");
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
        <div style="position:relative;border-left:2px solid #565555;border-right:2px solid #565555;border-bottom:2px solid #565555;">
          <table style="width:100%;font-size:12px;color:#565555;line-height:22px;" border="0">
            <tr style="font-weight:bold;color:#565555;" valign="top">
              <td style="width:30px;">S.NO</td>
              <td>&nbsp;ID</td>
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
	$downlinestring="";
	get_downline_listall($session_id,$new_conn,$downlinestring);
	if($downlinestring=="")
	{
		$pages="0";
	}
	else
	{
		$downline_array=explode(",",$downlinestring);
		$total=count($downline_array);
		$sno="1";
		$res=$new_conn->query("SELECT id,first_name,last_name FROM mlm_user_details WHERE id IN($downlinestring) ORDER BY id DESC LIMIT 0,5");
		while($detail=$res->fetch_assoc())
		{
			echo("<tr valign=\"top\">");
			echo("<td>".$sno."</td>");
			echo("<td>&nbsp;".$detail['id']."</td>");
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
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
$left_dashboard=$left_val;
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>
<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_dashboard=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="../javascript/jquery_file.js"></script>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
</body>
</html>