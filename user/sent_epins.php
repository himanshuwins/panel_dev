<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$start="0";
$start_1="0";
if(isset($_GET['page']))
{
	$start=$_GET['page'];
	$start_1=$_GET['page'];
	if((filter_var($start, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		$start="0";
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
    
<table style="width:100%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:50px;">S.NO</td>
    <td>REQUEST NO</td>
    <td>NO. OF EPINS</td>
    <td>DATE OF REQUEST</td>
    <td>PRODUCT</td>
    <td>AMOUNT</td>
    <td>PAYMENT DETAILS</td>
    <td>STATUS</td>
  </tr>
<?php
$session_id=$_SESSION['log_id'];
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$per_page="50";
	$start=$start*$per_page;
	$sno=$start_1*$per_page+1;
	$res=$new_conn->query("SELECT SQL_CALC_FOUND_ROWS a.epin_product_code,a.req_no,a.created_date,a.mode,a.dd_no,a.dd_date,a.dd_bank,a.dd_branch,a.cheque_no,a.cheque_date,a.cheque_bank,a.cheque_branch,b.name,b.price FROM wb_epins a INNER JOIN wb_ps b ON b.product_id=a.epin_product_code WHERE a.created_by='$session_id' AND a.status='pending' GROUP BY a.req_no ORDER BY a.created_date DESC LIMIT $start,$per_page");
	$res_total=$new_conn->query("SELECT FOUND_ROWS() AS total");
	$detail_total=$res_total->fetch_assoc();
	$total=$detail_total['total'];
	$pages_1=$total%$per_page;
	$pages=(int)($total/$per_page);
	if($pages_1>0)
	{
		$pages++;
	}
	while($detail=$res->fetch_assoc())
	{
		echo("<tr style=\"color:#000;\" valign=\"top\">");
		echo("<td>".$sno."</td>");
		$req_no_t=$detail['req_no'];
		echo("<td>EP".$req_no_t."</td>");
		$res_temp=$new_conn->query("SELECT count(*) as total_epins FROM wb_epins WHERE req_no='$req_no_t'");
		$detail_temp=$res_temp->fetch_assoc();
		$total_epins=$detail_temp['total_epins'];
		echo("<td>".$total_epins."</td>");
		echo("<td>".$detail['created_date']."</td>");
		echo("<td>".$detail['name']."</td>");
		$total_amount=$total_epins*$detail['price'];
		echo("<td>".$total_amount."</td>");
		echo("<td>".strtoupper($detail['mode']));
		if($detail['mode']=="dd")
		{
			echo("<br><span style=\"font-weight:bold;text-decoration:underline;\">Demand Draft details</span>");
			echo("<br>DD No : ".$detail['dd_no']);
			echo("<br>DD Date : ".$detail['dd_date']);
			echo("<br>DD Bank : ".$detail['dd_bank']);
			echo("<br>DD Branch : ".$detail['dd_branch']);
		}
		else if($detail['mode']=="cheque")
		{
			echo("<br><span style=\"font-weight:bold;text-decoration:underline;\">Cheque details</span>");
			echo("<br>Cheque No : ".$detail['cheque_no']);
			echo("<br>Cheque Date : ".$detail['cheque_date']);
			echo("<br>Cheque Bank : ".$detail['cheque_bank']);
			echo("<br>Cheque Branch : ".$detail['cheque_branch']);
		}
		echo("</td>");
		echo("<td>Pending</td>");
		echo("</tr>");
		$sno++;
	}
	$new_conn->close();
}
?>
</table>
<table style="width:100%;margin:auto;font-size:1em;" border="0" cellpadding="3px" cellspacing="0" class="page_no">
  <tr>
    <td>
      <table>
<?php
if($pages>1)
{
	echo("<tr>");
	echo("<td>Page : </td>");
	for($i=1;$i<=$pages;$i++)
	{
		$j=$i-1;
		if($start_1==$j)
		{
			echo("<td>&nbsp;".$i."&nbsp;</td>");
		}
		else
		{
			echo("<td>&nbsp;<a href=\"sent_epins.php?page=".$j."\">".$i."</a>&nbsp;</td>");
		}
	}
	echo("</tr>");
}
?>
      </table>
    </td>
  </tr>
</table>
    <br />
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
