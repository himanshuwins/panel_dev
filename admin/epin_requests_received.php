<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$from_notification="no";
if(isset($_GET['notify']))
{
	$notify=$_GET['notify'];
	if($notify=="")
	{
		echo("Error : Invalid request...");
		exit();
	}
	if((filter_var($notify, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^a-z]+/")))))
	{
		echo("Error : Invalid request...");
		exit();
	}
	$from_notification="yes";
}
?>
<?php
function generateRandomString($length = 8)
{
	$characters = '123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++)
	{
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
    return $randomString;
}
?>
<?php
$msg="";
$session_id=$_SESSION['log_id'];
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
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
<?php
if( (!empty($_POST)) && (isset($_POST['issue'])) && ($_POST['issue']=="yes"))
{
	if($_POST['issue']!="yes")
	{
		echo("Invalid request...");
		exit();
	}
	if($_POST['no_epin']=="")
	{
		echo("Invalid request epin...");
		exit();
	}
	$epin_table_id=$_POST['issue_val'];
	$no_epin=$_POST['no_epin'];
	if((filter_var($no_epin, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Invalid request epin 2...");
		exit();
	}
	if((filter_var($epin_table_id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Invalid request...");
		exit();
	}
	if($no_epin>20)
	{
		echo("Invalid request epin...");
		exit();
	}
	
	$ip=$_SERVER['REMOTE_ADDR'];
	$browser=$_SERVER['HTTP_USER_AGENT'];
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{	
		$total_found_epins=$no_epin;
		
		if($total_found_epins<1)
		{
			echo("Error : Invalid request total");
			exit();
		}
		
		$res_epin_old=$new_conn->query("SELECT * FROM wb_epins WHERE req_no='$epin_table_id' LIMIT 0,1");
		if($res_epin_old->num_rows!=1)
		{
			$new_conn->close();
			echo("Error : not found...");
			exit();
		}
		$detail_epin_old=$res_epin_old->fetch_assoc();
		
		$date_updated=date("Y-m-d");
		$new_conn->query("START TRANSACTION");
		$new_conn->query("DELETE FROM wb_epins WHERE req_no='$epin_table_id' AND status='pending'");
		for($i=0;$i<$total_found_epins;$i++)
		{
			$passed="no";
			while($passed=="no")
			{
				$new_epin=generateRandomString(16);
				$res=$new_conn->query("SELECT epin FROM wb_epins WHERE epin='$new_epin'");
				if($res->num_rows==0)
				{
					$passed="yes";
				}
			}
			
			$prepared="INSERT INTO wb_epins(epin,req_no,epin_product_code,mode,dd_no,dd_date,dd_bank,dd_branch,cheque_no,cheque_date,cheque_bank,cheque_branch,created_by,created_ip,created_browser,updated_date,updated_by,updated_ip,updated_browser,status) VALUES('$new_epin','$epin_table_id','{$detail_epin_old['epin_product_code']}','{$detail_epin_old['mode']}','{$detail_epin_old['ddno']}','{$detail_epin_old['dd_date']}','{$detail_epin_old['dd_bank']}','{$detail_epin_old['dd_branch']}','{$detail_epin_old['cheque_no']}','{$detail_epin_old['cheque_date']}','{$detail_epin_old['cheque_bank']}','{$detail_epin_old['cheque_branch']}','{$detail_epin_old['created_by']}','{$detail_epin_old['created_ip']}','{$detail_epin_old['created_browser']}','$date_updated','$session_id','$ip','$browser','issued')";
			if(!($new_conn->query($prepared)))
			{
				$new_conn->rollback();
				$new_conn->close();
				echo("Error : invalid request..couldn't create new");
				exit();
			}
		
			$new_conn->query($prep);
			if($new_conn->affected_rows!=1)
			{
				$new_conn->rollback();
				$new_conn->close();
				echo("Error : Cannot issue epin...Please contact your administrator");
				exit();
			}
		}
		$new_conn->commit();
		$new_conn->close();
		$msg="E-Pins issued successfully...";
		$temp_filename_1=$_SERVER['SCRIPT_FILENAME'];
		$temp_filename_2=explode("/",$temp_filename_1);
		$temp_filename=end($temp_filename_2);
		header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
	}
}
else if( (!empty($_POST)) && (isset($_POST['delete_proceed'])) && ($_POST['delete_proceed']=="yes"))
{
	if($_POST['delete_proceed']!="yes")
	{
		echo("Invalid request...");
		exit();
	}
	$epin_table_id=$_POST['delete_val'];
	if((filter_var($epin_table_id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Invalid request...");
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
		$new_conn->query("DELETE FROM wb_epins WHERE req_no='$epin_table_id' AND status='pending'");
		$new_conn->close();
		$msg="Deleted successfully...";
		$temp_filename_1=$_SERVER['SCRIPT_FILENAME'];
		$temp_filename_2=explode("/",$temp_filename_1);
		$temp_filename=end($temp_filename_2);
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
</head>
<body>
<div id="content_main"><br><br>

<table style="width:90%;margin:auto;font-size:1.5em;color:#333;" border="0" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr>
    <td><a href="index.php">Dashboard</a> > E-Pins Requests Received</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:30px;">S.NO</td>
    <td>REQUEST NO</td>
    <td>NO OF EPINS</td>
    <td>DATE OF REQUEST</td>
    <td>AMOUNT</td>
    <td>MODE</td>
    <td>REQUESTED BY</td>
    <td></td>
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
	$per_page="50";
	$start=$start*$per_page;
	$sno=$start_1*$per_page+1;
	$res=$new_conn->query("SELECT SQL_CALC_FOUND_ROWS a.req_no,a.epin,a.table_id,a.updated_date,a.mode,a.dd_no,a.dd_date,a.dd_bank,a.dd_branch,a.cheque_no,a.cheque_date,a.cheque_bank,a.cheque_branch,a.created_date,a.created_by,a.viewed_or_not_admin,b.username,b.first_name,b.last_name,c.price FROM wb_epins a INNER JOIN wb_ud b ON a.created_by=b.table_id INNER JOIN wb_ps c ON c.product_id=a.epin_product_code WHERE a.status='pending' GROUP BY a.req_no ORDER BY a.created_date DESC LIMIT $start,$per_page");
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
		if($detail['viewed_or_not_admin']=="no")
		{
			echo("<tr style=\"color:#000;font-weight:bold;\" valign=\"top\">");
		}
		else
		{
			echo("<tr style=\"color:#000;\" valign=\"top\">");
		}
		echo("<td>".$sno."</td>");
		$req_no_t=$detail['req_no'];
		echo("<td>EP".$req_no_t."</td>");
		$res_temp=$new_conn->query("SELECT count(*) as total_epins FROM wb_epins WHERE req_no='$req_no_t'");
		$detail_temp=$res_temp->fetch_assoc();
		$total_epins=$detail_temp['total_epins'];
		echo("<td><input type=\"text\" style=\"width:50px;\" value=\"".$total_epins."\" name=\"no_epin_".$sno."\" id=\"no_epin_".$sno."\" /></td>");
		echo("<td>".$detail['created_date']."</td>");
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
		echo("<td>".$detail['username']." (".$detail['first_name']." ".$detail['last_name'].")</td>");
		echo("<td><a href=\"javascript:submit_form('".$detail['req_no']."','".$sno."')\">Issue these E-Pins</a> | <a href=\"javascript:submit_delete_form('".$detail['req_no']."')\">Delete</a></td>");
		echo("</tr>");
		$sno++;
	}
	if($from_notification=="yes")
	{
		$new_conn->query("UPDATE wb_epins SET viewed_or_not_admin='yes' WHERE status='pending'");
	}
	$new_conn->close();
}
?>
</table>
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
			echo("<td>&nbsp;<a href=\"epin_requests_received.php?page=".$j."\">".$i."</a>&nbsp;</td>");
		}
	}
	echo("</tr>");
}
?>
      </table>
    </td>
  </tr>
</table>
<form name="myform" method="post">
<input type="hidden" name="issue" id="issue" value="no" />
<input type="hidden" name="no_epin" id="no_epin" value="" />
<input type="hidden" name="issue_val" id="issue_val" value="N/A" />
<input type="hidden" name="error" id="error" value="<?php echo($msg);?>" />
</form>
<form name="myform_delete" method="post">
<input type="hidden" name="delete_proceed" id="delete_proceed" value="no" />
<input type="hidden" name="delete_val" id="delete_val" value="N/A" />
</form>
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
$left_epin=$left_val;
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>
<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_epin=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function submit_form(val,no_epin)
{
	var id_new="#no_epin_"+no_epin;
	var no_epin_value=$(id_new).val();
	if(no_epin_value=="")
	{
		alert("Error : Please enter no of epins to issue...");
		$(id_new).focus();
		return false;
	}
	if(no_epin_value>20)
	{
		alert("Error : Must be less than or equal to 20...");
		$(id_new).focus();
		return false;
	}
	var temp=confirm("Are you sure you want to issue this E-Pin ?");
	if(temp==true)
	{
		$("#issue").val("yes");
		$("#no_epin").val(no_epin_value);
		$("#issue_val").val(val);
		document.myform.submit();
	}
}
function submit_delete_form(val)
{
	var temp=confirm("Are you sure you want to delete it permanently ?");
	if(temp==true)
	{
		$("#delete_proceed").val("yes");
		$("#delete_val").val(val);
		document.myform_delete.submit();
	}
}
</script>
</body>
</html>