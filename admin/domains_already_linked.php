<?php include("../php_scripts_wb/check_admin.php");?>
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
<?php
$msg="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
<?php
if((isset($_POST['to_del']))&&($_POST['to_del']!="")&&($_POST['to_del']!="none"))
{
	$to_del=$_POST['to_del'];
	if((filter_var($to_del, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Erorr : Invalid request...");
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
		$res=$new_conn->query("SELECT by_id FROM wb_msg WHERE table_id='$to_del'");
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$id=$detail['by_id'];
		}
		else
		{
			$new_conn->close();
			echo("Error : Invalid request...2");
			exit();
		}
		
		$new_conn->query("DELETE FROM wb_msg WHERE (by_id='$id' OR for_id='$id') AND subject='Domain Registration'");
		$new_conn->close();
		$msg="Deleted successfully...";
		$temp_filename="domains_to_be_linked.php";
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
<input type="hidden" name="error" id="error" value="<?php echo($msg);?>" />
<div id="content_main"><br><br>
<form method="post" name="myform">
<input type="hidden" name="to_del" id="to_del" value="none" />
</form>
<table style="width:90%;margin:auto;font-size:1.5em;color:#333;" border="0" cellpadding="3px" cellspacing="0" class="breadcrumb">
  <tr>
    <td><a href="index.php">Dashboard</a> > Domain to be Linked</td>
  </tr>
</table><br>
<table style="width:90%;margin:auto;font-size:1em;color:#FFF;" border="1" cellpadding="3px" cellspacing="0">
  <tr style="font-weight:bold;background-color:#333;color:#EEE;">
    <td style="width:50px;">S.NO</td>
    <td>NAME</td>
    <td>USERNAME</td>
    <td>DID</td>
    <td>DOMAIN NAME</td>
    <td>TIME</td>
    <td style="width:200px;">CPANEL DETAILS</td>
    <td></td>
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
	$res=$new_conn->query("SELECT SQL_CALC_FOUND_ROWS a.*,b.username,b.first_name,b.last_name,b.did FROM wb_msg a INNER JOIN wb_ud b ON b.table_id=a.by_id WHERE a.for_id='admin' AND a.subject='Domain Registration' AND a.cpanel_link!='' ORDER BY a.datetime DESC LIMIT $start,$per_page");
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
		echo("<tr style=\"color:#000;\">");
		echo("<td>".$sno."</td>");
		echo("<td>".$detail['first_name']." ".$detail['last_name']."</td>");
		echo("<td>".$detail['username']."</td>");
		echo("<td>".$detail['did']."</td>");
		echo("<td>".$detail['message']."</td>");
		echo("<td>".$detail['datetime']."</td>");
		echo("<td>");
		if(($detail['cpanel_username']!="")&&($detail['cpanel_username']!=""))
		{
			echo("Username : ".$detail['cpanel_username']."<br>Password : ".$detail['cpanel_password']);
		}
		echo("</td>");
		echo("<td><a href=\"register_domain.php?id=".$detail['table_id']."\">Register Now</a> | <a href=\"javascript:delete_request('".$detail['table_id']."')\">Delete</a></td>");
		echo("</tr>");
		$sno++;
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
			echo("<td>&nbsp;<a href=\"domains_to_be_linked.php?page=".$j."\">".$i."</a>&nbsp;</td>");
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
$top_domain=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
<script>
function delete_request(val)
{
	if((val!="")&&(val!="none"))
	{
		$("#to_del").val(val);
		document.myform.submit();
	}
	else
	{
		return false;
	}
	var ans=confirm("Delete Permanently ?");
	if(ans==true)
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