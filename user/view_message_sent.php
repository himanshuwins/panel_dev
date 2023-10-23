<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
if(isset($_GET['msg_id']))
{
	$msg_id=$_GET['msg_id'];
	if($msg_id=="")
	{
		echo("Error : Invalid Msg ID...");
		exit();
	}
	if((filter_var($msg_id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid Msg ID 2...");
		exit();
	}
}
else
{
	echo("Error : Invalid Msg ID 3...");
	exit();
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
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE by_id='$session_id' AND table_id='$msg_id'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$subject=$detail['subject'];
		$datetime=$detail['datetime'];
		$message=$detail['message'];
		$c_user=$detail['cpanel_username'];
		$c_pass=$detail['cpanel_password'];
		$c_link=$detail['cpanel_link'];
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : Not found");
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	require_once("header.php");
?>
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js" type="text/javascript"></script>

<div id="top-main-container">
  <div class="inner">
    <div class="user-img">
      <div class="img-inner">
      </div>
    </div>
    <h2>Support Center </h2>
    </div>
</div>
<div class="container">
 		<LINK REL="stylesheet" HREF="../dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" MEDIA="screen">
</LINK>
<SCRIPT TYPE="text/javascript" SRC="../dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></SCRIPT>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#E2E4E9">
        <tr>
          <td  align="center" width="25%" valign="middle" nowrap="nowrap"><img src="images/inbox.gif" alt="Inbox" width="15" height="13">&nbsp;<a href="msgbox.php" class="adminlink">Inbox</a> &nbsp;</td>
          <td  align="center" width="25%" valign="middle" nowrap="nowrap">&nbsp;<img src="images/sent_items.gif" alt="Sent Items" width="15" height="11">&nbsp;<a href="sendbox.php?act=sentbox" class="adminlink">Sent Items</a></td>
          <td  align="center" width="30%" valign="middle" nowrap="nowrap">&nbsp;<img src="images/new_msgs.gif" alt="Compose Message" width="15" height="13">&nbsp;<a href="msgcompose_domain.php" class="adminlink">Compose Domain Request</a></td>
          <td  align="right" width="10%" valign="middle" nowrap="nowrap">&nbsp;<img src="images/new_msgs.gif" alt="Compose Message" width="15" height="13">&nbsp;<a href="msgcompose.php" class="adminlink">Compose </a></td>
        </tr>
         
      </table>		<table width="671" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#E2E4E9">
                <table border="0" align="center" cellpadding="5" cellspacing="0">
                  <tr>
                    <Td style="width:150px;font-weight:bold;">TO</Td>
                    <td style="width:20px;text-align:right;">:</td>
                    <td><input type="text" value="Company" disabled="disabled"  style="font-size:16px;"  /></td>
                  </tr>
                  <tr>
                    <Td style="font-weight:bold;">TIME</Td>
                    <td style="text-align:right;">:</td>
                    <td><input type="text" value="<?php echo($datetime);?>" disabled="disabled"  style="font-size:16px;"  /></td>
                  </tr>
                  <tr>
                    <Td style="font-weight:bold;">SUBJECT</Td>
                    <td style="text-align:right;">:</td>
                    <td><input type="text" value="<?php echo($subject);?>" disabled="disabled"  style="font-size:16px;"  /></td>
                  </tr>
                  <tr valign="top">
                    <Td style="font-weight:bold;" valign="top">MESSAGE</Td>
                    <td style="text-align:right;">:</td>
                    <td>
                    <div style="position:relative;background-color:#FFF;min-height:300px;padding:5px;">
                    <?php
					if($subject=="Domain Registration")
					{
						echo("<span style=\"text-decoration:underline;font-weight:bold;\">DOMAIN NAME</span><br />");
						echo($message);
						if($c_user!="")
						{
						echo("<br /><br /><span style=\"text-decoration:underline;font-weight:bold;\">CPANEL DETAILS</span><br />");
						echo("Cpanel Link : <a href=\"http://".$c_link."\">".$c_link."</a>");
						echo("<br />Username : ".$c_user);
						echo("<br />Password : ".$c_pass);
						}
					}
					else
					{
						echo($message);
					}
                    ?>
                    </div>
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table> 
</div>


<?php
	require_once("footer.php");
?>
</body>
</html>
