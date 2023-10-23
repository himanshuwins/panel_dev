<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$msg="";
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
	$url_post="all_incomes.php";
}
if(isset($_GET['ref_no']))
{
	$ref_no=$_GET['ref_no'];
	if((filter_var($ref_no, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid ID...");
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
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT b.*,a.first_name,a.last_name,a.username FROM wb_ch b INNER JOIN wb_ud a ON a.table_id=b.id WHERE b.table_id='$ref_no'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : Not found...");
		exit();
	}
}
?>
<?php
if(!empty($_POST))
{
	$total_amount=$_POST['total_amount'];
	$tds=$_POST['tds'];
	$handling_charge=$_POST['handling_charge'];
	$amount_payable=$_POST['amount_payable'];
	$payment_mode=$_POST['payment_mode'];
	
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$total_amount=$new_conn->real_escape_string($total_amount);
		$tds=$new_conn->real_escape_string($tds);
		$handling_charge=$new_conn->real_escape_string($handling_charge);
		$amount_payable=$new_conn->real_escape_string($amount_payable);
		$payment_mode=$new_conn->real_escape_string($payment_mode);
		
		$prep="UPDATE wb_ch SET total_amount='$total_amount',tds='$tds',handling_charge='$handling_charge',amount_payable='$amount_payable',payment_mode='$payment_mode' WHERE table_id='$ref_no'";
		$new_conn->query($prep);
		$new_conn->close();
		$msg="Updated successfully...";
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
<script type="text/javascript">
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>
</head>
<body>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<div id="content_main">
<form name="myform" method="post" onSubmit="return validate_form()">
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="0" cellspacing="0">
  <tr style="height:50px;">
    <td align="center" colspan="2"><h2 style="color:#333;line-height:50px;">CHANGE INCOME DETAILS</h2></td>
  </tr>
  <tr>
    <td colspan="2">
      <fieldset>
        <legend>INCOME DETAILS</legend>
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
            <td style="width:150px;">Income</td>
            <td style="width:20px;">:</td>
            <td>
              <input type="text" name="total_amount" id="total_amount" value="<?php echo($detail['total_amount']);?>" onkeypress="return isNumberKey(event)" class="textboxes" style="width:120px;" />
            </td>
          </tr>
          <tr>
            <td style="width:150px;">TDS</td>
            <td style="width:20px;">:</td>
            <td>
              <input type="text" name="tds" id="tds" value="<?php echo($detail['tds']);?>" onkeypress="return isNumberKey(event)" class="textboxes" style="width:120px;" />
            </td>
          </tr>
          <tr>
            <td style="width:150px;">Handling Charge</td>
            <td style="width:20px;">:</td>
            <td>
              <input type="text" name="handling_charge" id="handling_charge" value="<?php echo($detail['handling_charge']);?>" onkeypress="return isNumberKey(event)" class="textboxes" style="width:120px;" />
            </td>
          </tr>
          <tr>
            <td style="width:150px;">Amount Payable</td>
            <td style="width:20px;">:</td>
            <td>
              <input type="text" name="amount_payable" id="amount_payable" value="<?php echo($detail['amount_payable']);?>" onkeypress="return isNumberKey(event)" class="textboxes" style="width:120px;" />
            </td>
          </tr>
          <tr>
            <td style="width:150px;">Payment Mode</td>
            <td style="width:20px;">:</td>
            <td>
              <select name="payment_mode" id="payment_mode" class="textboxes" style="width:auto;">
                <option
                <?php
				if($detail['payment_mode']=="cheque")
				{
					echo(" selected");
				}
				?>
                >cheque</option>
                <option
                <?php
				if($detail['payment_mode']=="neft")
				{
					echo(" selected");
				}
				?>
                >neft</option>
                </select>
            </td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr style="height:50px;">
    <td align="right"><div class="buttons" onClick="validate_form()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update Now&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;<div class="buttons" onClick="window.location.href = '<?php echo($url_post);?>';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
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