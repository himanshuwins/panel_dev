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
    <h2>Highest Achiever of the Week</h2>
  </div>
</div>
<div class="container" style="padding-bottom:15px;">
          

<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT session_no FROM wb_ch ORDER BY session_no DESC LIMIT 0,1");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$session_to_check=$detail['session_no'];
		
		$res=$new_conn->query("SELECT b.table_id,a.total_amount,b.first_name,b.last_name,b.city,b.profile_path,b.tag FROM wb_ch a INNER JOIN wb_ud b ON b.table_id=a.id WHERE a.session_no='$session_to_check' AND a.total_amount>='5000' AND b.status='active' ORDER BY a.total_amount DESC");
		while($detail=$res->fetch_assoc())
		{
			echo("<table border=\"1\" width=\"100%\">");
			echo("<tr>");
			echo("<td valign=\"top\" align=\"left\" width=\"112\"><img src=\"".$detail['profile_path']."\" border=\"0\" width=\"112\" title=\"".$detail['tag']."\"></td>");
			echo("<td valign=\"top\" align=\"left\"><h2>".$detail['first_name']." ".$detail['last_name']."</h2>");
			$to_check=$detail['table_id'];
			$res_check=$new_conn->query("SELECT * FROM wb_msg WHERE by_id='$to_check' AND subject='Domain Registration' AND cpanel_username!=''");
			if($res_check->num_rows==1)
			{
				$detail_check=$res_check->fetch_assoc();
				echo("<a href=\"http://".$detail['message']."\" target=\"_blank\">".$detail['message']."</a><br />");
			}
			else
			{
				echo("&nbsp;<br />");
			}
			echo("<br>".$detail['city']."</td>");
			echo("<td width=\"200\" align=\"left\" valign=\"top\"><h2>".$detail['total_amount']."</h2></td>");
			echo("</tr>");
			echo("</table>");
		}
	}
	$new_conn->close();
}
?>
</div>
</div>
</div>

<?php
	require_once("footer.php");
?>
</body>
</html>
