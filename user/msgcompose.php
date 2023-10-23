<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
if(!empty($_POST))
{
	$subject=$_POST['subject'];
	$message=$_POST['msg_body'];
	$message=nl2br($message);
	
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$subject=$new_conn->real_escape_string($subject);
		$message=$new_conn->real_escape_string($message);
		if($subject=="Domain Registration")
		{
			$res_check=$new_conn->query("SELECT * FROM wb_msg WHERE by_id='$session_id' AND subject='Domain Registration'");
			if($res_check->num_rows>0)
			{
				$new_conn->close();
				echo("Error : You have already sent request for Domain Registration...Only 1 request can be sent...!!!");
				exit();
			}
		}
		if($subject=="new")
		{
			$subject=$_POST['othersubject'];
		}
		if($new_conn->query("INSERT INTO wb_msg(for_id,by_id,subject,message,created_ip,created_browser) VALUES('admin','$session_id','$subject','$message','$ip','$browser')"))
		{
			$new_conn->close();
			$my_msg="Message sent successfully";
			$temp_filename="support-center.php";
			header("Location: /panel/user/redirect_back.php?q=".$temp_filename."&msg=".$my_msg);
		}
		else
		{
			$new_conn->close();
			echo("Error : Couldn't send message...Please contact your administrator");
			exit();
		}
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


<script language="javascript">
function checkForm(thisform)
 {
	 if($("#subject").val()!="new")
	 {
		 if($("#subject").val()=="")
		 {
			 alert("Error : Please select subject...");
			 $("#subject").focus();
			 return false;
		 }
	 }
	 else
	 {
		 if($("#othersubject").val()=="")
		 {
			 alert("Error : Please enter subject...");
			 $("#othersubject").focus();
			 return false;
		 }
	 }
	 if($("#msg_body").val()=="")
	 {
		 alert("Error : Please enter message...");
		 $("#msg_body").focus();
		 return false;
	 }
}	
   </script>
<script language="javascript">
function showchoice(eleid,spanid)
{
	if(document.getElementById(eleid).value == 'new'){
	document.getElementById(spanid).innerHTML =
	'<br /><p><input name="othersubject"  class="form2" id="othersubject"/></p>';
	}
	else 
	document.getElementById(spanid).innerHTML ='';
}

function showupdate(spanid)
{
	document.getElementById(spanid).style.visibility = "visible"; 
}
</script>

<div id="top-main-container">
  <div class="inner">
    <div class="user-img">
      <div class="img-inner"> 
      </div>
    </div>
    <h2>Support Center </h2></div>
</div>
<div class="container">
  <table width="100%" border="0" cellspacing="20" cellpadding="0">
    <tr>
      <td></td>
    </tr>
    <tr>
      <td align="left"><h2>
          Compose          Center</h2></td>
    </tr>
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
         
      </table>    <tr>
      <td align="center">&nbsp;</td>
      <td align="left"><span class="arialRedbold">
                </span></td>
    </tr>
    <tr>
    
      <td colspan="2"><form method="post" name="sendmsg" onSubmit="return checkForm(this);">
          <table width="98%" border="0" align="center" cellpadding="5" cellspacing="0" class="arial11">
            <tr>
              <td width="200px" height="30" class="arialblack12"><strong> Sender :</strong></td>
              <td height="30" colspan="2"><input name="sender" type="text" class="form2" id="sender" size="25" maxlength="50" value="<?php echo($_SESSION['log_username']);?>" readonly="readonly"/>
                <input type="hidden" name="userid" value="60769" /></td>
            </tr>
            <tr>
              <td class="arialblack12">&nbsp;</td>
              <td colspan="2" class="arial12light_blue"><?php echo($_SESSION['log_username']." (".$_SESSION['log_name']);?></td>
            </tr>
            <tr>
              <td height="30" class="arialblack12"><strong>Receiver : </strong></td>
              <td colspan="2"><input name="receiver" type="text" class="form2" id="receiver" readonly="readonly" value="company" />
                <input type="hidden" name="recevid" value="no" /></td>
            </tr>
            <tr>
              <td class="arialblack12"><span class="arial12light_blue">
                                 </span></td>
              <td colspan="2">Use '<strong>company</strong>' in Receiver field to send message to Webillion Infocom Pvt. Ltd. Type only username in receiver field to send message.</td>
            </tr>
            <tr>
              <td height="30" class="arialblack12"><strong>Subject : </strong></td>
              <td colspan="2">                <select name="subject" id="subject" class="form2" onChange="showchoice('subject','choice2')">
                  <option value="">Select Query ....</option>
                  <option value="Increase Webspace">Increase Webspace</option>
                  <option value="Increase Bandwidth">Increase Bandwidth</option>
                  <option value="Reset CPANEL Password">Reset CPANEL Password</option>
                  <option value="Reset Admin Password">Reset Admin Password</option>
                  <option value="Application Issues">Application Issues</option>
                  <option value="Domain Renewal">Domain Renewal</option>
                  <option value="new">Others ....</option>
                </select>
                </p>
                <span id="choice2"></span>
                </td>
            </tr>
            <tr>
              <td height="30" class="arialblack12"><strong>Date : </strong></td>
              <td colspan="2"><input name="date"  class="form2" value="
              <?php 
			$dob=date("Y-m-d");
			if($dob!="0000-00-00")
			{
				$date_obj = new DateTime($dob);
				$dob=$date_obj->format('d-M-Y');
				echo($dob);
			}
			  ?>
              " disabled="disabled" /></td>
            </tr>
            <tr>
              <td class="arialblack12"><strong>Message :</strong></td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td class="arialblack12" colspan="3">
              <textarea name="msg_body" id="msg_body" style="padding:5px;margin:0;width:98%;resize:none;text-indent:0;" rows="20"></textarea>
              </td>
            </tr>
            <tr>               
              <td  width="" colspan="3"><input type="submit" name="submit" value="Send Now" />&nbsp;&nbsp;<a href="msgbox.php">Back to Inbox</a></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
  </td>
  </tr>
  </table>
</div>
</div>

<?php
	require_once("footer.php");
?>
</body>
</html>
