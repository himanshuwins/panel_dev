<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts_wb/parse_downline.php");?>
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
if(isset($_GET['page_no']))
{
	$page_no_postback=$_GET['page_no'];
	if((filter_var($page_no_postback, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		$page_no_postback="0";
	}
}
?>
<?php
$per_page_url="50";
$page_no_postback=0;	
?>

<?php
$downline_array=array();
$side="";
if(isset($_GET['child']))
{
	$side=$_GET['child'];
	$side=strtolower($side);
	if($side=="fso")
	{
		$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
		if ($new_conn->connect_errno)
		{
			echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
			exit();
		}
		else
		{
			$res=$new_conn->query("SELECT fso FROM wb_ud WHERE table_id='$session_id'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$fso=$detail['fso'];
				$downline_array[]=$fso;
				if($fso!="")
				{
					parse_downline($new_conn,$fso,$downline_array);
				}
				$new_conn->close();	
			}
			else
			{
				$new_conn->close();
				exit();
			}
		}
	}
	else if($side=="sso")
	{
		$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
		if ($new_conn->connect_errno)
		{
			echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
			exit();
		}
		else
		{
			$res=$new_conn->query("SELECT sso FROM wb_ud WHERE table_id='$session_id'");
			if($res->num_rows==1)
			{
				$detail=$res->fetch_assoc();
				$fso=$detail['sso'];
				$downline_array[]=$fso;
				if($fso!="")
				{
					parse_downline($new_conn,$fso,$downline_array);
				}
				$new_conn->close();	
			}
			else
			{
				$new_conn->close();
				exit();
			}
		}
	}
	else
	{
		$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
		if ($new_conn->connect_errno)
		{
			echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
			exit();
		}
		else
		{
			parse_downline($new_conn,$session_id,$downline_array);
			$new_conn->close();
		}
	}
}
else
{
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		parse_downline($new_conn,$session_id,$downline_array);
		$new_conn->close();
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


    <h2 class="super-big">Associates By Sale Organization</h2>
    <h3>List of Associates by FSO and SSO</h3>
		
    </div>
</div>
<div class="container"> 
    <div class="span-24">
		<table border="0" cellspacing="0" cellpadding="0" style="width:345px; float:right;">
<tr>
                          
                          <form id="form1" name="form1" method="get" action="">
                            <td  align="left" width="75%">List By
                        <select name="child" id="jumpMenu">
                                  <option value="all"
                                  <?php
								  if($side=="all")
								  {
									  echo(" selected");
								  }
								  ?>
                                  >All</option>
                                  <option value="fso"
                                  <?php
								  if($side=="fso")
								  {
									  echo(" selected");
								  }
								  ?>
                                  >First Sale Organization</option>
                                  <option value="sso"
                                  <?php
								  if($side=="sso")
								  {
									  echo(" selected");
								  }
								  ?>
                                  >Second Sale Organization</option>
                              </select></td>
                            <td align="left" width="27%"><a class="button nice radius green small" href="javascript:form1.submit()" style="position:relative;top:20px;">GO</a></td>
                          </form>
          </tr>
      </table>
        <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
                        <tr>
                          <th>Name</th>
                          <th>Username </th>
                          <th>DID</th>
                          <th>Status</th>
                          <th>PIN</th>
						  <th>Join Date</th>
                        </tr>
<?php
$per_page=$per_page_url;
$start=$page_no_postback;
$start_1=$page_no_postback;
$start=$start*$per_page;
$sno=$start_1*$per_page+1;
$downlinestring=implode(",",$downline_array);
if($downlinestring!="")
{
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$color="#dcdee4";
	$prepared_statement="SELECT SQL_CALC_FOUND_ROWS *,DATE(created_date) AS join_date FROM wb_ud WHERE table_id IN ($downlinestring) ORDER BY created_date";
	$res=$new_conn->query($prepared_statement);
	$prepared_statement="SELECT FOUND_ROWS() AS total";
	$res_total=$new_conn->query($prepared_statement);
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
		if($color=="#dcdee4")
		{
			$color="#e9eaee";
		}
		else if($color=="#e9eaee")
		{
			$color="#dcdee4";
		}
		echo("<tr>");
		echo("<td bgcolor=\"".$color."\">".$detail['first_name']." ".$detail['last_name']."</td>");
		echo("<td align = \"left\" bgcolor=\"".$color."\">".$detail['username']."</td>");
		echo("<td align = \"left\" bgcolor=\"".$color."\">".$detail['did']."</td>");
		echo("<td align = \"left\" bgcolor=\"".$color."\">".$detail['status']."</td>");
		echo("<td align = \"left\" bgcolor=\"".$color."\">".$detail['tag']."</td>");
		echo("<td align = \"left\" bgcolor=\"".$color."\">");
		$dob=$detail['join_date'];
		if($dob!="0000-00-00")
		{
			$date_obj = new DateTime($dob);
			$dob=$date_obj->format('d-M-Y');
			echo($dob);
		}
		echo("</td>");
		echo("</tr>");
	}
	$new_conn->close();
}
}
?>
                              </table>
          
<table style="width:100%;margin:auto;font-size:1em;" border="1" cellpadding="3px" cellspacing="0" class="page_no">
  <tr>
    <td align="left">
      <table>
      <?php
	  if($downlinestring!="")
	  {
if($pages>1)
{
	echo("<tr>");
	echo("<td>Page : ");
	for($i=1;$i<=$pages;$i++)
	{
		$j=$i-1;
		if($start_1==$j)
		{
			echo(" ".$i." ");
		}
		else
		{
			echo(" <a href=\"javascript:submit_form_page_no('".$j."')\">".$i."</a> ");
		}
	}
	echo("</td></tr>");
}
	  }
?>
      </table>
    </td>
  </tr>
</table>
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
</body>
</html>
