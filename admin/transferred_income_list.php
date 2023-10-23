<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts/downline_list.php");?>
<?php
$msg="";
if(isset($_POST['to_change_status']))
{
	$to_change=$_POST['to_change_status'];
	if($to_change=="")
	{
		echo("Error : invalid request....");
		exit();
	}
	$new_status=$_POST['new_status'];
	if($new_status=="")
	{
		echo("Error : invalid request.....");
		exit();
	}
	if((filter_var($to_change, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9,]+/")))))
	{
		echo("Error : invalid request.....");
		exit();
	}
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$new_status=$new_conn->real_escape_string($new_status);
		$new_conn->query("UPDATE wb_ch SET payment_status='$new_status' WHERE table_id IN ($to_change) AND payment_status='transferred'");
		$new_conn->close();
		$msg="Updated Successfully...";
	}
}
?>
<?php
$side="all";
if(isset($_GET['group']))
{
	$side=$_GET['group'];
	if(($side!="left")&&($side!="right")&&($side!="all"))
	{
		echo("Error : Invalid request...!!!");
		exit();
	}
}
$per_page_url=50;
$page_no_postback=0;
$session_id=$_SESSION['log_id'];
$start="0";
$start_1="0";
if(isset($_GET['page_no']))
{
	$page_no_postback=$_GET['page_no'];
	$start=$_GET['page_no'];
	$start_1=$_GET['page_no'];
	if((filter_var($start, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		$start="0";
	}
}
$sort_by="a.session_no,a.income";
if(isset($_GET['sort_by']))
{
	$sort_by=$_GET['sort_by'];
}
$session_no="all";
if(isset($_GET['session_no']))
{
	$session_no=$_GET['session_no'];
	if((filter_var($session_no, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9a-z]+/")))))
	{
		echo("Error : Invalid request...");
		exit();
	}
}
if(isset($_GET['per_page']))
{
	$per_page_url=$_GET['per_page'];
	if((filter_var($per_page_url, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid request...");
		exit();
	}
}
$search_did="";
$search_username="";
if(isset($_GET['search_did']))
{
	$search_did=$_GET['search_did'];
}
if(isset($_GET['search_username']))
{
	$search_username=$_GET['search_username'];
}
?>
<?php
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
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
</head>
<body>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<div id="content_main"><br><br>

<table style="width:90%;margin:auto;font-size:1.5em;color:#333;" border="0" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr>
    <td><a href="index.php">Dashboard</a> > Transferred Income List</td>
  </tr>
</table><br>
<form method="get" name="my_filters_form">
<table style="width:90%;margin:auto;font-size:1.1em;color:#333;line-height:25px;" border="1" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr valign="top">
    <td style="width:50%;">
    <table>
    <tr>
    <td>Session No</td>
    <td>:</td>
    <td>
      <select name="session_no" id="session_no">
        <option value="all">-all-</option>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT DISTINCT(session_no) FROM wb_ch");
	while($detail=$res->fetch_assoc())
	{
		echo("<option");
		if($session_no==$detail['session_no'])
		{
			echo(" selected");
		}
		echo(">".$detail['session_no']."</option>");
	}
	$new_conn->close();
}
?>
      </select>
    </td>
    </tr>
    <tr>
    <td>Username</td>
    <td>:</td>
    <td>
    <input type="text" placeholder="Username" name="search_username" id="search_username" value="<?php echo($search_username);?>" />
    </td>
    </tr>
    <tr>
    <td>DID</td>
    <td>:</td>
    <td>
    <input type="text" placeholder="DID" name="search_did" id="search_did" value="<?php echo($search_did);?>" />
    </td>
    </tr>
    </table>
    </td>
    <td style="width:50%;">
    <table>
    <tr>
    <td>Group</td>
    <td>:</td>
    <td>
    <select name="group" id="group">
      <option value="all"
      <?php
	  if($side=="all")
	  {
		  echo(" selected");
	  }
	  ?>
      >All</option>
      <option value="left"
      <?php
	  if($side=="left")
	  {
		  echo(" selected");
	  }
	  ?>
      >Left Group</option>
      <option value="right"
      <?php
	  if($side=="right")
	  {
		  echo(" selected");
	  }
	  ?>
      >Right Group</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>Sort By</td>
    <td>:</td>
    <td>
    <select name="sort_by" id="sort_by">
      <option value="a.session_no,a.income"
      <?php
	  if($sort_by=="a.session_no,a.income")
	  {
		  echo(" selected");
	  }
	  ?>
      >Session No,Income</option>
      <option value="a.created_date"
      <?php
	  if($sort_by=="a.created_date")
	  {
		  echo(" selected");
	  }
	  ?>
      >Income Date</option>
      <option value="b.username"
      <?php
	  if($sort_by=="b.username")
	  {
		  echo(" selected");
	  }
	  ?>
      >Username</option>
      <option value="b.first_name,b.last_name"
      <?php
	  if($sort_by=="b.first_name,b.last_name")
	  {
		  echo(" selected");
	  }
	  ?>
      >Name</option>
      <option value="b.did"
      <?php
	  if($sort_by=="b.did")
	  {
		  echo(" selected");
	  }
	  ?>
      >DID</option>
    </select>
    </td>
    </tr>
    <tr>
    <td>Per Page</td>
    <td>:</td>
    <td>
      <select name="per_page" id="per_page">
        <option
<?php
if($per_page_url=="50")
{
echo(" selected");
}
?>
>50</option>
        <option
<?php
if($per_page_url=="100")
{
echo(" selected");
}
?>
>100</option>
        <option
<?php
if($per_page_url=="500")
{
echo(" selected");
}
?>
>500</option>
        <option
<?php
if($per_page_url=="1000")
{
echo(" selected");
}
?>
>1000</option>
      </select>
    </td>
    </tr>
    </table>
    </td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="0" cellpadding="3px" cellspacing="0">
  <tr>
    <td align="right" colspan="2">
      <input type="button" value="Search" onClick="validate_form()" />
      <input type="button" value="Reset" onClick="window.location.href='transferred_income_list.php'" /></td>
  </tr>
</table><br>
<input type="hidden" name="page_no" id="page_no" value="<?php echo($page_no_postback);?>" />
<input type="hidden" id="per_page_url" value="<?php echo($per_page_url);?>" />
<input type="hidden" id="session_no_reset_page" value="<?php echo($session_no);?>" />
<input type="hidden" id="sort_by_reset_page" value="<?php echo($sort_by);?>" />
<input type="hidden" id="search_username_reset_page" value="<?php echo($search_username);?>" />
<input type="hidden" id="search_did_reset_page" value="<?php echo($search_did);?>" />
</form>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;">S.NO</td>
    <td>NAME</td>
    <td>USERNAME</td>
    <td>DID</td>
    <td>PAN</td>
    <td>SESSION</td>
    <td>INCOME DATE</td>
    <td>INCOME</td>
    <td>TDS</td>
    <td>HANDLING CHARGE</td>
    <td>AMOUNT PAYABLE</td>
    <td>STATUS</td>
    <td style="width:30px;"><input type="checkbox" id="select_all" onClick="check_all()" /></td>
  </tr>
<?php
if($sort_by=="a.created_date")
{
	$sort_by="TRIM(a.created_date)";
}
else if($sort_by=="a.session_no,a.income")
{
	$sort_by="TRIM(a.session_no,a.income)";
	$sort_by="a.session_no ASC,convert(a.amount_payable,decimal) DESC";
}
else if($sort_by=="b.first_name,b.last_name")
{
	$sort_by="TRIM(b.first_name),TRIM(b.last_name)";
}
else if($sort_by=="b.did")
{
	$sort_by="TRIM(b.did)";
}
else if($sort_by=="b.username")
{
	$sort_by="TRIM(b.username)";
}
else
{
	echo("Error : Invalid request.....!!!");
	exit();
}

$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$downline_array=array();
	if(($side=="left")||($side=="right"))
	{
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE table_id='$session_id'");
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$fso=$detail['fso'];
			$sso=$detail['sso'];
		}
		if(($side=="left")&&($fso!=""))
		{
			$downline_array[]=$fso;
			parse_downline($new_conn,$fso,$downline_array);
		}
		else if(($side=="right")&&($sso!=""))
		{
			$downline_array[]=$sso;
			parse_downline($new_conn,$sso,$downline_array);
		}
	}
	else
	{
		parse_downline($new_conn,$session_id,$downline_array);
	}
	if(count($downline_array)==0)
	{
		$pages="0";
	}
	else
	{
		$total=count($downline_array);
		
		$downlinestring=implode(",",$downline_array);
		
		$start=$start*$per_page_url;
		$sno=$start_1*$per_page_url+1;
		
		$search_username=$new_conn->real_escape_string($search_username);
		$search_did=$new_conn->real_escape_string($search_did);
		$session_no=$new_conn->real_escape_string($session_no);
		
		$prep="SELECT SQL_CALC_FOUND_ROWS a.*,DATE(a.created_date) AS income_date,a.table_id AS target_id,b.* FROM wb_ch a INNER JOIN wb_ud b ON b.table_id=a.id WHERE a.payment_status='transferred' ";
		if($search_username!="")
		{
			$prep.=" AND b.username LIKE ('%$search_username%')";
		}
		if($search_did!="")
		{
			$prep.=" AND b.did LIKE ('%$search_did%')";
		}
		if($session_no!="all")
		{
			$prep.=" AND a.session_no='$session_no'";
		}
		$prep.=" ORDER BY $sort_by LIMIT $start,$per_page_url";
		$res=$new_conn->query($prep);
		
		
		$prepared_statement="SELECT FOUND_ROWS() AS total";
		$res_total=$new_conn->query($prepared_statement);
		$detail_total=$res_total->fetch_assoc();
		$total=$detail_total['total'];
		
		$pages_1=$total%$per_page_url;
		$pages=(int)($total/$per_page_url);
		if($pages_1>0)
		{
			$pages++;
		}
		
		while($detail=$res->fetch_assoc())
		{
			echo("<tr style=\"color:#000;\" valign=\"top\">");
			echo("<td>".$sno."</td>");
			echo("<td>".$detail['first_name']." ".$detail['last_name']."</td>");
			echo("<td>".$detail['username']."</td>");
			echo("<td>".$detail['did']."</td>");
			echo("<td>".$detail['pan']."</td>");
			echo("<td>".$detail['session_no']."</td>");
			echo("<td>".$detail['income_date']."</td>");
			echo("<td>".$detail['total_amount']."</td>");
			echo("<td>".$detail['tds']."</td>");
			echo("<td>".$detail['handling_charge']."</td>");
			echo("<td>".$detail['amount_payable']."</td>");
			echo("<td style=\"background-color:#090;color:#FFF;font-weight:bold;\">".$detail['payment_status']."</td>");
			echo("<td><input type=\"checkbox\" class=\"user_ids\" value=\"".$detail['target_id']."\" /></td>");
			echo("</tr>");
			$sno++;
		}
	}
	$new_conn->close();
}
?>
</table><br>
<form name="change_status" method="post">
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="0" cellpadding="3px" cellspacing="0">
<tr>
  <td>
    <select name="new_status" id="new_status">
      <option value="">-New Status-</option>
      <option>pending</option>
    </select>&nbsp;<input type="button" value="Change Now" onClick="change_status_func()" /></td>
</tr>
</table>
<input type="hidden" id="to_change_status" name="to_change_status" value="" />
</form><br>
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="3px" cellspacing="0" class="page_no">
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
			echo("<td>&nbsp;<a href=\"javascript:submit_form_page_no('".$j."')\">".$i."</a>&nbsp;</td>");
		}
	}
	echo("</tr>");
}
?>
      </table>
    </td>
  </tr>
</table>
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>
<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_reports=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function submit_form_page_no(temp_val)
{
	$("#page_no").val(temp_val);
	document.my_filters_form.submit();
}
function validate_form()
{
	if($("#per_page").val()!=$("#per_page_url").val())
	{
		$("#page_no").val("0");
	}
	if($("#sort_by").val()!=$("#sort_order_reset_page").val())
	{
		$("#page_no").val("0");
	}
	if($("#search_username").val()!=$("#search_username_reset_page").val())
	{
		$("#page_no").val("0");
	}
	if($("#search_did").val()!=$("#search_did_reset_page").val())
	{
		$("#page_no").val("0");
	}
	if($("#session_no").val()!=$("#session_no_reset_page").val())
	{
		$("#page_no").val("0");
	}
	document.my_filters_form.submit();
}

function change_status_func()
{
	if($("#new_status").val()=="")
	{
		alert("Error : Please select New Status first");
		$("#new_status").focus();
		return false;
	}
	var checkedItemsAsString = $('.user_ids:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
	if(checkedItemsAsString=="")
	{
		alert("Error : Please select atleast 1 id...");
		return false;
	}
	var ans=confirm("Are you sure?");
	if(ans==true)
	{
		$("#to_change_status").val(checkedItemsAsString);
		document.change_status.submit();
	}
	else
	{
		return false;
	}
}
	$(document).ready(function() {
    $('#select_all').click(function(event) { //on click 
        if(this.checked) { // check select status
            $('input[type=checkbox]').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('input[type=checkbox]').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});
</script>
</body>
</html>