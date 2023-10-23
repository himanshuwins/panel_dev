<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$session_id=$_SESSION['log_id'];
$invoice_no="";
$invoice_created_date="";
$name="";
$p_local="";
$city="";
$state="";
$pincode="";
$phone_no="";
$email_id="";
$prod_desc="";
$actual_price="";
$tax="";
$amount_in_words="";
if($_GET['pass_code'])
{
	$pass_code=$_GET['pass_code'];
	if($pass_code=="")
	{
		echo("Error : Invalid request...3");
		exit();
	}
	if((filter_var($pass_code, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid request...2");
		exit();
	}
}
else
{
	echo("Error : invalid request 1");
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
	$prep="SELECT * FROM wb_in WHERE id='$session_id' AND table_id='$pass_code'";
	$res=$new_conn->query($prep);
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		if($detail['type']=="initial")
		{
			$prep_2="SELECT a.table_id AS invoice_no,a.created_date As invoice_created_date,b.*,d.prod_desc,d.actual_price,d.tax,d.price_in_words FROM wb_in a INNER JOIN wb_ud b ON b.table_id=a.id INNER JOIN wb_epins c ON c.epin=a.epin INNER JOIN wb_ps d ON d.product_id=c.epin_product_code WHERE a.table_id='$pass_code' AND a.id='$session_id'";
			$res_2=$new_conn->query($prep_2);
			if($res_2->num_rows==1)
			{
				$detail_2=$res_2->fetch_assoc();
				$invoice_no=$detail_2['invoice_no'];
				$invoice_created_date=$detail_2['invoice_created_date'];
				$name=$detail_2['first_name']." ".$detail_2['last_name'];
				$p_local=$detail_2['p_local'];
				$city=$detail_2['city'];
				$state=$detail_2['state'];
				$pincode=$detail_2['pincode'];
				$phone_no=$detail_2['phone_no'];
				$email_id=$detail_2['email_id'];
				$prod_desc=$detail_2['prod_desc'];
				$actual_price=$detail_2['actual_price'];
				$tax=$detail_2['tax'];
				$amount_in_words=$detail_2['price_in_words'];
			}
			else
			{
				$new_conn->close();
				echo("Error : Not found...");
				exit();
			}
		}
		else if($detail['type']=="renew")
		{
			$prep_2="SELECT a.*,a.table_id AS invoice_no,a.created_date As invoice_created_date,b.* FROM wb_in a INNER JOIN wb_ud b ON b.table_id=a.id WHERE a.table_id='$pass_code' AND a.id='$session_id'";
			$res_2=$new_conn->query($prep_2);
			if($res_2->num_rows==1)
			{
				$detail_2=$res_2->fetch_assoc();
				$invoice_no=$detail_2['invoice_no'];
				$invoice_created_date=$detail_2['invoice_created_date'];
				$name=$detail_2['first_name']." ".$detail_2['last_name'];
				$p_local=$detail_2['p_local'];
				$city=$detail_2['city'];
				$state=$detail_2['state'];
				$pincode=$detail_2['pincode'];
				$phone_no=$detail_2['phone_no'];
				$email_id=$detail_2['email_id'];
				$prod_desc=$detail_2['description'];
				$actual_price=$detail_2['actual_price'];
				$tax=$detail_2['tax'];
				$amount_in_words=$detail_2['amount_in_words'];
			}
			else
			{
				$new_conn->close();
				echo("Error : Not found...");
				exit();
			}
		}
		else
		{
			$new_conn->close();
			echo("Error : Not found");
			exit();
		}
	}
	else
	{
		$new_conn->close();
		echo("Error : Not found...");
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="welcome_style.css" type="text/css" />
<title>My Invoice</title>
</head>
<body>
  <div id="welcomeContainer">
    <div id="welcome" style="padding:20px;font-size:12px;border:none;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3" align="center" style="font-size:18px;">RETAIL INVOICE</td>
        </tr>
        <tr>
          <td>
            <table width="100%" cellpadding="3px" cellspacing="0" border="1">
              <tr valign="top">
                <td>
                <strong>Aspire Society</strong><br />
                <!--Office Address:<br />
                25A, Dayanand Colony, Lajpat Nagar - IV<br />
                New Delhi-110024<br /><br />-->
                Phone : (+91)-9990226660<br />
                Email : info@aspiresociety.com<br />
                Website : www.aspiresociety.com
                </td>
                <td rowspan="2">
                <strong>Invoice No*</strong><br />
                <?php
				echo($invoice_no);
				?>
                </td>
                <td rowspan="2"><strong>Dated*</strong><br><?php echo($invoice_created_date);?></td>
              </tr>
              <tr valign="top">
                <td>
                <strong>Customer</strong><br />
                <?php
				echo($name);
				echo("<br>".$p_local.",<br />".$city.",<br />".$state."-".$pincode);
				echo("<br>Contact : ".$phone_no."<br><strong>Email : ".$email_id."</strong>");
				?>
                </td>
              </tr>
              <tr style="font-weight:bold;line-height:25px;text-align:center;">
                <td>Description of Goods</td>
                <td>Quantity</td>
                <td>Amount</td>
              </tr>
              <tr valign="top" style="text-align:center;">
                <td>
                <?php
				echo($prod_desc);
				?>
                <div style="position:relative;height:200px;"></div>
                </td>
                <td>1</td>
                <td>
                <?php
				echo($actual_price+$tax);
				?>
                </td>
              </tr>
              <tr style="font-weight:bold;line-height:25px;text-align:center;">
                <td style="padding-right:2px;text-align:right;">Grand Total</td>
                <td style="padding-right:2px;">1</td>
                <td style="padding-right:2px; width:150px;"><?php echo($actual_price+$tax);?></td>
              </tr>
              <tr>
                <td colspan="5">
                <div style="position:relative;">
                  <strong>Amount Chargeable(in Words)</strong><br />
                  <?php echo($amount_in_words);?><br /><br />
                  <table cellpadding="0" cellspacing="0">
                    <tr>
                      <td>Company's VAT TIN Number</td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                      <td>05848965120</td>
                    </tr>
                  </table><br /><br /><br /><br />
                  <strong>Declaration</strong><br />
                  We declare that this invoice shows the actual Price<br />
                  of the goods described and that all particulars are true and correct.
                  <div style="position:absolute;top:0;right:10px;">
                  E. & O. E.
                  </div>
                </div>
                </td>
              </tr>
            </table><br>
<div style="position:relative;text-align:center;line-height:30px;">This is a computer generated invoice, hence, need not be signed.</div>
          </td>
        </tr>
     </table> 
      
     
    </div>
  </div>
</body>
</html>