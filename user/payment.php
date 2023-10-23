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
    <h2>Payment Status</h2>
    <a href="sales-reports.php" class="button small nice blue radius">SALE ORGANIZATION REPORT</a> <a href="payment.php" class="button small nice red radius">PAYMENT DETAILS</a> <a href="genealogy.php" class="button small nice green radius">SALE ORGANIZATION CHART</a> <a href="vat.php" class="button small nice black radius">VAT INVOICE</a> </div>
</div>

<div class="container">
    <div class="span-24">
    
        <h3>Status of Last Payment Dispatched</h3>

    </div>


<div class="span-24">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="alternate">
  <tr>
    <th>S.No</th>
    <th>Issued Date</th>
    <th>Payment Mode</th>
    <th>Total Income</th>
    <th>TDS</th>
    <th>Handling Charge</th>
    <th>Dispatched</th>
  </tr>
<?php
$displayed="none";
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$sno=1;
	$res=$new_conn->query("SELECT *,DATE(created_date) AS income_date FROM wb_ch WHERE id='$session_id' ORDER BY created_date DESC LIMIT 0,1");
	while($detail=$res->fetch_assoc())
	{
		$displayed=$detail['table_id'];
		echo("<tr>");
		echo("<td>".$sno."</td>");
		echo("<td>".$detail['income_date']."</td>");
		echo("<td>".$detail['payment_mode']."</td>");
		echo("<td>".$detail['total_amount']."</td>");
		echo("<td>".$detail['tds']."</td>");
		echo("<td>".$detail['handling_charge']."</td>");
		echo("<td>".$detail['amount_payable']."</td>");
		echo("</tr>");
		$sno++;
	}
	$new_conn->close();
}
?>
       
</table>
     </div>

<hr  />
    <div class="span-24">
    
        <h3>Status of All Previous Payment Dispatched</h3>

    </div>

	<div class="span-24">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="alternate">
  <tr>
    <th>S.No</th>
    <th>Issued Date</th>
    <th>Payment Mode</th>
    <th>Total Income</th>
    <th>TDS</th>
    <th>Handling Charge</th>
    <th>Dispatched</th>
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
	$sno=1;
	$res=$new_conn->query("SELECT *,DATE(created_date) AS income_date FROM wb_ch WHERE id='$session_id' AND table_id!='$displayed' ORDER BY created_date DESC");
	while($detail=$res->fetch_assoc())
	{
		echo("<tr>");
		echo("<td>".$sno."</td>");
		echo("<td>".$detail['income_date']."</td>");
		echo("<td>".$detail['payment_mode']."</td>");
		echo("<td>".$detail['total_amount']."</td>");
		echo("<td>".$detail['tds']."</td>");
		echo("<td>".$detail['handling_charge']."</td>");
		echo("<td>".$detail['amount_payable']."</td>");
		echo("</tr>");
		$sno++;
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
