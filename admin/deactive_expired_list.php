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
		echo("Error : invalid request.");
		exit();
	}
	$new_status="active";
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
		$today_date=date("Y-m-d");
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE table_id IN ($to_change) AND status='deactive_expired' AND end_date<'$today_date'");
		while($detail=$res->fetch_assoc())
		{
			$end_date=$detail['end_date'];
			$end_date_array=explode("-",$end_date);
			$year=$end_date_array[0]+1;
			$month=$end_date_array[1];
			$day=$end_date_array[2];
			$new_end_date=$year."-".$month."-".$day;
			$new_conn->query("UPDATE wb_ud SET end_date='$new_end_date',status='active' WHERE table_id ='{$detail['table_id']}'");
			$new_conn->query("INSERT INTO wb_in(id,actual_price,tax,amount_in_words,description,type,created_by,created_ip,created_browser) VALUES('{$detail['table_id']}','2500','125','Two Thousand Six Hundred Twenty Five Only','Webillions Blogging Package','renew','$session_id','$ip','$browser')");
		}
		$new_conn->close();
		$msg="Status Changed Successfully...";
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
$sort_by="a.created_date";
if(isset($_GET['sort_by']))
{
	$sort_by=$_GET['sort_by'];
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
    <td><a href="index.php">Dashboard</a> > Deactive Expired List</td>
  </tr>
</table><br>
<form method="get" name="my_filters_form">
<table style="width:90%;margin:auto;font-size:1.1em;color:#333;line-height:25px;" border="1" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr valign="top">
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
    <td>Sort By</td>
    <td>:</td>
    <td>
    <select name="sort_by" id="sort_by">
      <option value="a.created_date"
      <?php
	  if($sort_by=="a.created_date")
	  {
		  echo(" selected");
	  }
	  ?>
      >Reg Date</option>
      <option value="a.username"
      <?php
	  if($sort_by=="a.username")
	  {
		  echo(" selected");
	  }
	  ?>
      >Username</option>
      <option value="a.first_name,a.last_name"
      <?php
	  if($sort_by=="a.first_name,a.last_name")
	  {
		  echo(" selected");
	  }
	  ?>
      >Name</option>
      <option value="a.did"
      <?php
	  if($sort_by=="a.did")
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
</table>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="0" cellpadding="3px" cellspacing="0">
  <tr>
    <td align="right" colspan="2">
      <input type="button" value="Search" onClick="validate_form()" />
      <input type="button" value="Reset" onClick="window.location.href='deactive_expired_list.php'" /></td>
  </tr>
</table><br>
<input type="hidden" name="page_no" id="page_no" value="<?php echo($page_no_postback);?>" />
<input type="hidden" id="per_page_url" value="<?php echo($per_page_url);?>" />
<input type="hidden" id="sort_by_reset_page" value="<?php echo($sort_by);?>" />
<input type="hidden" id="search_username_reset_page" value="<?php echo($search_username);?>" />
<input type="hidden" id="search_did_reset_page" value="<?php echo($search_did);?>" />
</form>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;"><input type="checkbox" id="select_all" onClick="check_all()" /></td>
    <td style="width:30px;">S.NO</td>
    <td>USERNAME</td>
    <td>DID</td>
    <td>REG. DATE</td>
    <td>NAME</td>
    <td>ADDRESS</td>
    <td>PHONE NO</td>
    <td>EMAIL ID</td>
    <td>STATUS</td>
  </tr>
<?php
if($sort_by=="a.created_date")
{
	$sort_by="TRIM(a.created_date)";
}
else if($sort_by=="a.first_name,a.last_name")
{
	$sort_by="TRIM(a.first_name),TRIM(a.last_name)";
}
else if($sort_by=="a.did")
{
	$sort_by="TRIM(a.did)";
}
else if($sort_by=="a.username")
{
	$sort_by="TRIM(a.username)";
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
		
		$prep="SELECT SQL_CALC_FOUND_ROWS a.did,a.username,a.table_id,a.first_name,a.last_name,a.created_date,a.phone_no,a.email_id,a.c_local,a.city,a.state,a.pincode,a.status,a.sponsor_id,c.first_name AS sponsor_first_name,c.last_name AS sponsor_last_name,c.username AS sponsor_username FROM wb_ud a INNER JOIN wb_ud c ON c.table_id=a.sponsor_id WHERE a.table_id IN($downlinestring) AND a.status='deactive_expired' ";
		if($search_username!="")
		{
			$prep.=" AND a.username LIKE ('%$search_username%')";
		}
		if($search_did!="")
		{
			$prep.=" AND a.did LIKE ('%$search_did%')";
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
			echo("<td><input type=\"checkbox\" class=\"user_ids\" value=\"".$detail['table_id']."\" /></td>");
			echo("<td>".$sno."</td>");
			echo("<td>".$detail['username']."</td>");
			echo("<td>".$detail['did']."</td>");
			echo("<td>".$detail['created_date']."</td>");
			echo("<td>".$detail['first_name']." ".$detail['last_name']."</td>");
			echo("<td>".$detail['c_local']."<br>".$detail['city'].", ".$detail['state']." - ".$detail['pincode']."</td>");
			$phone=explode(",",$detail['phone_no']);
			$total_phone_no=count($phone);
			echo("<td>");
			for($i=0;$i<$total_phone_no;$i++)
			{
				echo($phone[$i]."<br />");
			}
			echo("</td>");
			$phone=explode(",",$detail['email_id']);
			$total_phone_no=count($phone);
			echo("<td>");
			for($i=0;$i<$total_phone_no;$i++)
			{
				echo($phone[$i]."<br />");
			}
			echo("</td>");
			
			echo("<td valign=\"middle\"");
			if($detail['status']=="pending_linked")
			{
				echo(" style=\"text-align:center;background-color:#F00;color:#FFF;font-weight:bold;\"");
			}
			else if($detail['status']=="active")
			{
				echo(" style=\"text-align:center;background-color:#090;color:#FFF;font-weight:bold;\"");
			}
			else if(($detail['status']=="deactive_terminated")||($detail['status']=="deactive_expired")||($detail['status']=="deactive_payment_not_received"))
			{
				echo(" style=\"text-align:center;background-color:#333;color:#FFF;font-weight:bold;\"");
			}
			echo(">".$detail['status']."</td>");
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
    <input type="button" value="Renew Now" onClick="change_status_func()" /></td>
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
$top_genealogy=$top_val;
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
	document.my_filters_form.submit();
}

function change_status_func()
{
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