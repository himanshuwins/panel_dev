<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
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
    <h2>Support Center </h2></div>
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
                <td bgcolor="#E2E4E9"><table width="651" border="0" align="center" cellpadding="5" cellspacing="0">
                  <tr>
                    <td width="25" align="left" bgcolor="#B9BDCA" class="arial12bold">S.N</td>
                  
				   <td width="203" align="left" bgcolor="#B9BDCA" class="arial12bold">
                  
                    INBOX ( From )                    </td>
                    <td width="229" align = "center" bgcolor="#B9BDCA" class="arial12bold"><div align="left">Subject</div></td>
                    <td width="127" align = "center" bgcolor="#B9BDCA" class="arial12bold">Date</td>
                    <td width="17" align = "left" bgcolor="#B9BDCA" class="arial12bold">&nbsp;</td>
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
	$i=1;
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE (for_id='$session_id') OR (by_id='$session_id' AND subject='Domain Registration' AND cpanel_username!='')");
	while($detail=$res->fetch_assoc())
	{
		echo("<tr>");
		echo("<td>".$i."</td>");
		echo("<td>Company</td>");
		echo("<td>".$detail['subject']."</td>");
		echo("<td>".$detail['datetime']."</td>");
		if($detail['subject']=="Domain Registration")
		{
			echo("<td><a href=\"view_message_sent.php?msg_id=".$detail['table_id']."\">Read</a></td>");
		}
		else
		{
			echo("<td><a href=\"view_message.php?msg_id=".$detail['table_id']."\">Read</a></td>");
		}
		echo("</tr>");
		$i++;
	}
	$new_conn->close();
}
?>
                                  </table></td>
              </tr>
            </table> 
</div>

<?php
	require_once("footer.php");
?>
</body>
</html>
