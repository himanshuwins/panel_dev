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
<div id="top-main-container" style="background:url(images/header.jpg);">
  <div class="inner">

<div class="user-img">
      <div class="img-inner"><img src="<?php echo($profile_path_db);?>" width="83" height="83"></div>
    </div>
    <h2>Invoice of
      <?php echo($_SESSION['log_name']);?>    </h2>
  </div>
</div>
<br>

<div class="container">
  <div class="span-24">
    <h3 style="color:rgb(233, 28, 33);">Vat Invoice</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="alternate">
      <tr>
        <th>Invoice number</th>
        <th>Generated Date</th>
        <th>Invoice</th>
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
	$prep="SELECT a.* FROM wb_in a WHERE a.id='$session_id' ORDER BY a.table_id";
	$res=$new_conn->query($prep);
	while($detail=$res->fetch_assoc())
	{
		echo("<tr style=\"color:#000;\">");
		echo("<td>".$detail['table_id']."</td>");
		echo("<td>".$detail['created_date']."</td>");
		echo("<td><a href=\"my_invoice.php?pass_code=".$detail['table_id']."\" target=\"_blank\">Print Invoice</a></td>");
		echo("</tr>");
	}
	$new_conn->close();
}
?>
          </table>
  </div>
  </div>

<?php
	require_once("footer.php");
?>
</body>
</html>
