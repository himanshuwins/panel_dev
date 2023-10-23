<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
if(!empty($_POST))
{
	try
	{
		$product_code=$_POST['product_code'];
		$number=$_POST['number'];
		if((filter_var($number, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
		{
			echo("Invalid request");
			exit();
		}
		if((filter_var($product_code, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^A-Za-z0-9]+/")))))
		{
			echo("Invalid request");
			exit();
		}
		$ddno="N/A";
		$dd_date="0000-00-00";
		$dd_bank="N/A";
		$dd_branch="N/A";
		
		$cheque_no="N/A";
		$cheque_date="0000-00-00";
		$cheque_bank="N/A";
		$cheque_branch="N/A";
		
		$mode=$_POST['mode'];
		if($mode=="dd")
		{
			$ddno=$_POST['ddno'];
			$dd_day=$_POST['dd_day'];
			$dd_month=$_POST['dd_month'];
			$dd_year=$_POST['dd_year'];
			$dd_date=$dd_year."-".$dd_month."-".$dd_day;
			$dd_bank=$_POST['dd_bank'];
			$dd_branch=$_POST['dd_branch'];
			if((filter_var($dd_date, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9-]+/")))))
			{
				echo("Invalid request");
				exit();
			}
		}
		else if($mode=="cheque")
		{
			$cheque_no=$_POST['cheque_no'];
			$cheque_day=$_POST['cheque_day'];
			$cheque_month=$_POST['cheque_month'];
			$cheque_year=$_POST['cheque_year'];
			$cheque_date=$cheque_year."-".$cheque_month."-".$cheque_day;
			$cheque_bank=$_POST['cheque_bank'];
			$cheque_branch=$_POST['cheque_branch'];
			if((filter_var($cheque_date, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9-]+/")))))
			{
				echo("Invalid request");
				exit();
			}
		}
		
		$ip=$_SERVER['REMOTE_ADDR'];
		$browser=$_SERVER['HTTP_USER_AGENT'];
		$session_id=$_SESSION['log_id'];
		
		$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
		if ($new_conn->connect_errno)
		{
			echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
			exit();
		}
		else
		{
			$dd_bank=$new_conn->real_escape_string($dd_bank);
			$dd_branch=$new_conn->real_escape_string($dd_branch);
			$cheque_bank=$new_conn->real_escape_string($cheque_bank);
			$cheque_branch=$new_conn->real_escape_string($cheque_branch);
			$number=$new_conn->real_escape_string($number);
			$mode=$new_conn->real_escape_string($mode);
			if($mode=="dd")
			{
				$ddno=$new_conn->real_escape_string($ddno);
				$dd_date=$new_conn->real_escape_string($dd_date);
				$dd_bank=$new_conn->real_escape_string($dd_bank);
				$dd_branch=$new_conn->real_escape_string($dd_branch);
			}
			else if($mode=="cheque")
			{
				$cheque_no=$new_conn->real_escape_string($cheque_no);
				$cheque_date=$new_conn->real_escape_string($cheque_date);
				$cheque_bank=$new_conn->real_escape_string($cheque_bank);
				$cheque_branch=$new_conn->real_escape_string($cheque_branch);
			}
			
			$res=$new_conn->query("SELECT req_no FROM wb_epins ORDER BY table_id DESC LIMIT 0,1");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$req_no=$detail['req_no'];
				$req_no++;
			}
			else
			{
				$req_no="101";
			}
			$new_conn->query("START TRANSACTION");
			for($i=0;$i<$number;$i++)
			{
				$prepared="INSERT INTO wb_epins(req_no,epin_product_code,mode,dd_no,dd_date,dd_bank,dd_branch,cheque_no,cheque_date,cheque_bank,cheque_branch,created_by,created_ip,created_browser) VALUES('$req_no','$product_code','$mode','$ddno','$dd_date','$dd_bank','$dd_branch','$cheque_no','$cheque_date','$cheque_bank','$cheque_branch','$session_id','$ip','$browser')";
				if($new_conn->query($prepared))
				{
				}
				else
				{
					$new_conn->rollback();
					$new_conn->close();
					echo("Error : Invalid request...");
					exit();
				}
			}

			$new_conn->commit();
			$new_conn->close();
			$msg="E-Pin request with REQUEST NO : EP".$req_no." sent successfully...";
			$temp_filename="request_epins.php";
			header("Location: /panel/user/redirect_back.php?q=".$temp_filename."&msg=".$msg);
		}
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
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
<div id="top-main-container" style="background:url(images/header.jpg);">
  <div class="inner">


    <h2 class="super-big">Request Epin</h2>
		
    </div>
</div>
<div class="container"> 
    <div class="span-24">
         <form name="myform" method="post" onsubmit="return submit_form()"> 
          <fieldset>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:150px;">Select Product</td>
            <td style="text-align:center;">:</td>
            <td style="font-weight:400;">
              <select class="textboxes" name="product_code" id="product_code" onChange="update_epin_fields()">
                <option value="none">--- select ---</option>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo(" COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$price="";
	$product_code_price="";
	$res_folder=$new_conn->query("SELECT product_id,name,price,currency FROM wb_ps WHERE status='active' ORDER BY product_id");
	while($detail_folder=$res_folder->fetch_assoc())
	{
		if($price=="")
		{
			$price=$detail_folder['price'];
		}
		echo("<option value=\"".$detail_folder['product_id']."\">".$detail_folder['name']." (".$detail_folder['currency'].")</option>");
		if($product_code_price=="")
		{
			$product_code_price="[".$detail_folder['product_id'].",".$detail_folder['price'];
		}
		else
		{
			$product_code_price.="!@!@"."[".$detail_folder['product_id'].",".$detail_folder['price'];
		}
	}
	$new_conn->close();
}
?>
              </select>
<input type="hidden" id="product_code_price" value="<?php echo($product_code_price);?>" />
            </td>
          </tr>
          <tr>
            <td>Cost per unit</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" class="textboxes" id="price_per_unit" style="padding-left:3px;" disabled value="---" /></td>
          </tr>
          <tr>
            <td>No. of E-Pins</td>
            <td style="text-align:center;">:</td>
            <td style="font-weight:400;">
              <select name="number" id="number" class="textboxes" style="width:auto;" onChange="update_epin_fields()">
                <option value="1">01</option>
                <option value="2">02</option>
                <option value="3">03</option>
                <option value="4">04</option>
                <option value="5">05</option>
                <option value="6">06</option>
                <option value="7">07</option>
                <option value="8">08</option>
                <option value="9">09</option>
                <option value="10">10</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Total Amount</td>
            <td style="width:20px;text-align:center;">:</td>
            <td style="font-weight:400;"><input type="text" name="total" id="total" class="textboxes" style="padding-left:3px;" disabled value="---" /></td>
          </tr>
        </table>
      </fieldset>
      <br />
      <fieldset>
        <legend>MODE OF PAYMENT</legend>
          <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Payment Mode</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;">
                    <select class="textboxes" style="width:auto;" name="mode" id="mode" onChange="view_payment_details()">
                      <option value="cash">Cash</option>
                      <option value="cheque">Cheque</option>
                      <option value="dd">Demand Draft</option>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
            <td>
            </td>
          </tr>
          <tr id="dd_1" style="display:none;">
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">DD no</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;"><input type="text" class="textboxes" onkeypress="return isNumberKey(event)" maxlength="6"  name="ddno" id="ddno" /></td>
                </tr>
              </table>
            </td>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">DD date</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;">
                    <select name="dd_day" id="dd_day" class="textboxes" style="width:auto;">
                      <option value="1">01</option>
                      <option value="2">02</option>
                      <option value="3">03</option>
                      <option value="4">04</option>
                      <option value="5">05</option>
                      <option value="6">06</option>
                      <option value="7">07</option>
                      <option value="8">08</option>
                      <option value="9">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                      <option value="24">24</option>
                      <option value="25">25</option>
                      <option value="26">26</option>
                      <option value="27">27</option>
                      <option value="28">28</option>
                      <option value="29">29</option>
                      <option value="30">30</option>
                      <option value="31">31</option>
                    </select>
                    <select name="dd_month" id="dd_month" class="textboxes" style="width:auto;">
                      <option value="01">Jan</option>
                      <option value="02">Feb</option>
                      <option value="03">Mar</option>
                      <option value="04">Apr</option>
                      <option value="05">May</option>
                      <option value="06">Jun</option>
                      <option value="07">Jul</option>
                      <option value="08">Aug</option>
                      <option value="09">Sep</option>
                      <option value="10">Oct</option>
                      <option value="11">Nov</option>
                      <option value="12">Dec</option>
                    </select>
                    <select name="dd_year" id="dd_year" class="textboxes" style="width:auto;">
                      <option value="2014">2014</option>
                      <option value="2015">2015</option>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr id="dd_2" style="display:none;">
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Bank</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;"><input type="text" class="textboxes" name="dd_bank" id="dd_bank" /></td>
                </tr>
              </table>
            </td>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Branch</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;"><input type="text" class="textboxes" name="dd_branch" id="dd_branch" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr id="cheque_1" style="display:none;">
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Cheque no</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;"><input type="text" class="textboxes" onkeypress="return isNumberKey(event)" maxlength="6"  name="cheque_no" id="cheque_no" /></td>
                </tr>
              </table>
            </td>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Cheque date</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;">
                    <select name="cheque_day" id="cheque_day" class="textboxes" style="width:auto;">
                      <option value="1">01</option>
                      <option value="2">02</option>
                      <option value="3">03</option>
                      <option value="4">04</option>
                      <option value="5">05</option>
                      <option value="6">06</option>
                      <option value="7">07</option>
                      <option value="8">08</option>
                      <option value="9">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                      <option value="21">21</option>
                      <option value="22">22</option>
                      <option value="23">23</option>
                      <option value="24">24</option>
                      <option value="25">25</option>
                      <option value="26">26</option>
                      <option value="27">27</option>
                      <option value="28">28</option>
                      <option value="29">29</option>
                      <option value="30">30</option>
                      <option value="31">31</option>
                    </select>
                    <select name="cheque_month" id="cheque_month" class="textboxes" style="width:auto;">
                      <option value="01">Jan</option>
                      <option value="02">Feb</option>
                      <option value="03">Mar</option>
                      <option value="04">Apr</option>
                      <option value="05">May</option>
                      <option value="06">Jun</option>
                      <option value="07">Jul</option>
                      <option value="08">Aug</option>
                      <option value="09">Sep</option>
                      <option value="10">Oct</option>
                      <option value="11">Nov</option>
                      <option value="12">Dec</option>
                    </select>
                    <select name="cheque_year" id="cheque_year" class="textboxes" style="width:auto;">
                      <option value="2015">2015</option>
                      <option value="2016">2016</option>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr id="cheque_2" style="display:none;">
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Bank</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;"><input type="text" class="textboxes" name="cheque_bank" id="cheque_bank" /></td>
                </tr>
              </table>
            </td>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Branch</td>
                  <td style="width:20px;text-align:center;">:</td>
                  <td style="font-weight:400;"><input type="text" class="textboxes" name="cheque_branch" id="cheque_branch" /></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </fieldset>
          </form>
  <tr style="height:50px;">
    <td align="right"><input type="button" onClick="submit_form()" value="Send Now" />&nbsp;&nbsp;<input type="button" onClick="window.location.href = 'index.php'" value="Cancel" /></td>
  </tr>
          
          
</table><br />
<br />  
 </div>
 </div>         
<?php
	require_once("footer.php");
?>
<script>
function submit_form_page_no(temp_val)
{
	$("#page_no").val(temp_val);
	document.my_filters.submit();
}
</script>
<script>
function update_epin_fields()
{
	var selected_value=$("#product_code").val();
	var value_to_search="["+selected_value+",";
	var product_code_price=$("#product_code_price").val();
	var product_code_price_array=new Array();
	product_code_price_array=product_code_price.split("!@!@");
	var t=product_code_price_array.length;
	for(var i=0;i<t;i++)
	{		
		if(product_code_price_array[i].indexOf(value_to_search)!=-1)
		{
			var temp_array=product_code_price_array[i].split(",");
			var cost=temp_array[1];
			$("#price_per_unit").val(cost);
			var total_epins=$("#number").val();
			var total_cost=total_epins*cost;
			$("#total").val(total_cost);
			break;
		}
	}
}
function view_payment_details()
{
	var mode=$("#mode").val();
	if(mode=="cash")
	{
		$("#dd_1,#dd_2").css({'display':'none'});
	}
	else if(mode=="dd")
	{
		$("#dd_1,#dd_2").show();
		$("#cheque_1,#cheque_2").hide();
	}
	else if(mode=="cheque")
	{
		$("#dd_1,#dd_2").hide();
		$("#cheque_1,#cheque_2").show();
	}
}
function calculate_total()
{
	var no_epin=$("#number").val();
	var total=no_epin*2000;
	total=" Rs. "+total;
	$("#total").val(total);
}
function submit_form()
{
	if($("#product_code").val()=="none")
	{
		alert("Error : Please select a product first...");
		$("#product_code").focus();
		return false;
	}
	var mode=$("#mode").val();
	if(mode=="dd")
	{
		if($("#ddno").val()=="")
		{
			alert("Error : Please enter DD no...");
			$("#ddno").focus();
			return false;
		}
		if($("#dd_bank").val()=="")
		{
			alert("Error : Please enter bank name...");
			$("#dd_bank").focus();
			return false;
		}
		if($("#dd_branch").val()=="")
		{
			alert("Error : Please enter bank branch...");
			$("#dd_branch").focus();
			return false;
		}
	}
	if(mode=="cheque")
	{
		if($("#cheque_no").val()=="")
		{
			alert("Error : Please enter Cheque no...");
			$("#cheque_no").focus();
			return false;
		}
		if($("#cheque_bank").val()=="")
		{
			alert("Error : Please enter cheque bank name...");
			$("#cheque_bank").focus();
			return false;
		}
		if($("#cheque_branch").val()=="")
		{
			alert("Error : Please enter bank branch...");
			$("#cheque_branch").focus();
			return false;
		}
	}
	var submit_or_not=confirm("Are you sure you want to send this epin request ?");
	if(submit_or_not==true)
	{
		document.myform.submit();
	}
	else
	{
		return false;
	}
}
</script>
</body>
</html>
