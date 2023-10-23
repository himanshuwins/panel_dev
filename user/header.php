<title>Panel</title>
<link rel="stylesheet" type="text/css" href="css/custom.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, projection" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="js/jquery.js" ></script>
<script language="javascript">
function showstate(str)
{
if (str=="")
{
document.getElementById("txtHint").innerHTML="";
return;
}else if(str==101){
document.getElementById('forindia').className='shdo';
document.getElementById('fornepal').className='';
document.getElementById('forother').className='';

}else if(str==154){
document.getElementById('fornepal').className='shdo';
document.getElementById('forindia').className='';
document.getElementById('forother').className='';
}else {
document.getElementById('forother').className='shdo';
document.getElementById('forindia').className='';
document.getElementById('fornepal').className='';
document.getElementById("txtHintcity").innerHTML="<input type='text' name='city' value='' />";
}
if (window.XMLHttpRequest)
{
xmlhttp=new XMLHttpRequest();
}
else
{
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("txtHintstate").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("GET","state_ajax.php?q="+str,true);
xmlhttp.send();
}

function showcity(str)
{
if (str=="")
{
document.getElementById("txtHint").innerHTML="";
return;
}
if (window.XMLHttpRequest)
{
xmlhttp=new XMLHttpRequest();
}
else
{
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{

if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("txtHintcity").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("GET","city_ajax.php?q="+str,true);
xmlhttp.send();
}
</script>
</head>
<?php require_once("php_scripts_wb/parse_downline_with_details.php");?>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$last_session_closed_timestamp="0000-00-00 00:00:00";
	$res_session=$new_conn->query("SELECT created_date FROM wb_ch ORDER BY created_date DESC LIMIT 0,1");
	if($res_session->num_rows==1)
	{
		$detail_session=$res_session->fetch_assoc();
		$last_session_closed_timestamp=$detail_session['created_date'];
	}
	$prepare="SELECT a.*,DATE(a.created_date) AS start_date,b.* FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE a.table_id='$session_id'";
	$res=$new_conn->query($prepare);
	if($res->num_rows==1)
	{
		$detail_main=$res->fetch_assoc();
		$profile_path_db=$detail_main['profile_path'];
		$tag_db=$detail_main['tag'];
		$name=$detail_main['first_name']." ".$detail_main['last_name'];
		$tag=$detail_main['tag'];
		$did=$detail_main['did'];
		$fso=$detail_main['fso'];
		$sso=$detail_main['sso'];
		$start_date=$detail_main['start_date'];
		$today_date=date("Y-m-d");
		$datetime1 = new DateTime($today_date);
		$datetime2 = new DateTime($start_date);
		
		$difference = $datetime1->diff($datetime2);
		
		$total_days=$difference->days;
		
		$expiry_array=explode("-",$start_date);
		$next_date=($expiry_array[0]+1)."-".$expiry_array[1]."-".$expiry_array[2];
		
		$days_left="";
		$datetime_temp=new DateTime($next_date);
		if($datetime_temp>$datetime1)
		{
			$difference = $datetime_temp->diff($datetime1);
			$days_left=$difference->days-1;
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+2)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+3)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+4)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		if($days_left=="")
		{
			$next_date=($expiry_array[0]+5)."-".$expiry_array[1]."-".$expiry_array[2];
			$datetime_temp=new DateTime($next_date);
			if($datetime_temp>$datetime1)
			{
				$difference = $datetime_temp->diff($datetime1);
				$days_left=$difference->days-1;
			}
		}
		
		$fso_array=array();
		$sso_array=array();
		
		$active_sale_fso=0;
		$to_be_linked_fso=0;
		$linked_fso=0;
		$renewed_fso=0;
		$disabled_fso=0;
		$executive_fso=0;
		$team_manager_fso=0;
		$manager_fso=0;
		$general_manager_fso=0;
		$diplomat_fso=0;
		
		$active_sale_sso=0;
		$to_be_linked_sso=0;
		$linked_sso=0;
		$renewed_sso=0;
		$disabled_sso=0;
		$executive_sso=0;
		$team_manager_sso=0;
		$manager_sso=0;
		$general_manager_sso=0;
		$diplomat_sso=0;
		
		if($fso!="")
		{
		parse_downline_with_details($new_conn,$fso,$active_sale_fso,$to_be_linked_fso,$linked_fso,$renewed_fso,$disabled_fso,$executive_fso,$team_manager_fso,$manager_fso,$general_manager_fso,$diplomat_fso,$last_session_closed_timestamp);
		}
		if($sso!="")
		{
		parse_downline_with_details($new_conn,$sso,$active_sale_sso,$to_be_linked_sso,$linked_sso,$renewed_sso,$disabled_sso,$executive_sso,$team_manager_sso,$manager_sso,$general_manager_sso,$diplomat_sso,$last_session_closed_timestamp);
		}
		
		$commissionable_fso=$detail_main['total_fso'];
		$commissionable_sso=$detail_main['total_sso'];
		$forward_fso=$detail_main['forward_fso'];
		$forward_sso=$detail_main['forward_sso'];
		$balance_fso=$forward_fso+$linked_fso;
		$balance_sso=$forward_sso+$linked_sso;
		
		$total_sales=$active_sale_fso+$to_be_linked_fso+$disabled_fso+$active_sale_sso+$to_be_linked_sso+$disabled_sso;
		
		$directs_names_string="";
		$directs_string="";
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE sponsor_id='$session_id'");
		while($detail=$res->fetch_assoc())
		{
			if($directs_names_string=="")
			{
				$directs_names_string=$detail['username']." (".$detail['did'].")";
			}
			else
			{
				$directs_names_string.="<br />".$detail['username']." (".$detail['did'].")";
			}
			if($directs_string=="")
			{
				$directs_string=$detail['table_id'];
			}
			else
			{
				$directs_string.=",".$detail['table_id'];
			}
		}
		
		$directs_fso=0;
		$directs_sso=0;
		if($directs_string!="")
		{
			$res=$new_conn->query("SELECT * FROM wb_ud WHERE fso IN ($directs_string)");
			$directs_fso=$res->num_rows;
			
			$res=$new_conn->query("SELECT * FROM wb_ud WHERE sso IN ($directs_string)");
			$directs_sso=$res->num_rows;
		}
		
		$sponsor_from_db="";
		$res=$new_conn->query("SELECT * FROM wb_ud WHERE fso='$session_id' OR sso='$session_id'");
		if($res->num_rows==1)
		{
			$detail_sponsor=$res->fetch_assoc();
			$sponsor_from_db=$detail_sponsor['first_name']." ".$detail_sponsor['last_name']." (".$detail_sponsor['username'].") | ".$detail_sponsor['did'];
		}
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : Profile not found");
		exit();
	}
}
?>
<body style="background:url(images/bg_pattern.jpg) !important;">

<div id="header"> 
  <div class="inner">
    <div id="logo"> 
      <img src="images/logo.png"  alt="" height="75" /></a>
    </div>
    <div class="super-info">
      <div class="main-toggles inlines">
      <div style="position:relative;height:20px;">
      <table cellpadding="0" cellspacing="0" style="border:none;width:auto;padding:0;margin:0;float:right;">
        <tr style="border:none;padding:0;margin:0;">
                <td style="border:none;padding:0;margin:0;">
                <a href="received_epins.php?notify=a">
                <div style="position:relative;height:20px;width:20px;background-image:url(images/img1.png);">
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT a.epin,a.epin_product_code,a.updated_date,a.mode,a.dd_no,a.dd_date,a.dd_bank,a.dd_branch,a.cheque_no,a.cheque_date,a.cheque_bank,a.cheque_branch,b.name,b.price,b.currency FROM wb_epins a INNER JOIN wb_ps b ON b.product_id=a.epin_product_code WHERE a.created_by='$session_id' AND (a.status='issued' OR a.status='issued_inactive') AND a.viewed_or_not='no'");
	if($res->num_rows>0)
	{
		echo("<div style=\"position:absolute;right:-10px;top:-10px;padding:0 5px;-webkit-border-radius:3px;background-color:#F00;color:#FFF;font-weight:400;font-size:10px;\">");
		echo($res->num_rows);
		echo("</div>");
	}
	$new_conn->close();
}
?>
</div>
</a>
                </td>
                <td style="border:none;padding:0;padding-left:15px;margin:0;">
                <a href="support-center.php?notify=a">
                <div style="position:relative;height:20px;width:20px;background-image:url(images/img2.png);">
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE ((for_id='$session_id') OR (by_id='$session_id' AND last_reply_by='admin')) AND read_or_not='no'");
	if($res->num_rows>0)
	{
		echo("<div style=\"position:absolute;right:-10px;top:-10px;padding:0 5px;-webkit-border-radius:3px;background-color:#F00;color:#FFF;font-weight:400;font-size:10px;\">");
		echo($res->num_rows);
		echo("</div>");
	}
	$new_conn->close();
}
?>
</div>
</a>
                </td>
                <td style="border:none;padding:0;padding-left:15px;margin:0;">
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE by_id='$session_id' AND subject='Domain Registration' AND cpanel_username!='' AND read_or_not='no'");
	if($res->num_rows>0)
	{
		$detail_temp=$res->fetch_assoc();
		echo("<a href=\"view_message_sent.php?msg_id=".$detail_temp['table_id']."&notify=a\">");
		echo("<div style=\"position:relative;height:20px;width:20px;background-image:url(images/img3.png);\">");
		echo("<div style=\"position:absolute;right:-10px;top:-10px;padding:0 5px;-webkit-border-radius:3px;background-color:#F00;color:#FFF;font-weight:400;font-size:10px;\">");
		echo($res->num_rows);
		echo("</div>");
		echo("</div>");
		echo("</a>");
	}
	$new_conn->close();
}
?>
                </td>
                </tr>
                </table>
      
      </div>
      <div style="position:relative;height:5px;"></div>
        <div data-id='closed' class="toggle">
        <h5>Welcome <strong><?php echo($_SESSION['log_name']);?></strong></h5>
          <div class="toggle-content" style="display:none;">
            <div class="img">
            <img src="<?php echo($profile_path_db);?>" width="83" height="83" alt="<?php echo($tag_db);?>" title="<?php echo($tag_db);?>"></div>
            <div class="right-content">
              <p><strong><?php echo($_SESSION['log_name']);?></strong></p>
              <p><?php echo($_SESSION['log_tag']);?></p>
              <p><strong>DID:</strong> <?php echo($_SESSION['log_did']);?></p>
              <p><strong>Associate Since:</strong><?php echo($total_days);?> Days</p>
              <p><strong>Days Left for Expiry:</strong><?php echo($days_left);?> Days</p>
              <div class="liner"></div>
               <h3>First Sale Organization (FSO)</h3>
              <p><?php echo($executive_fso+$team_manager_fso+$manager_fso+$general_manager_fso+$diplomat_fso);?> Associate(s)</p>
              <p><?php echo($active_sale_fso);?> Actives, <?php echo($executive_fso+$team_manager_fso+$manager_fso+$general_manager_fso+$diplomat_fso-$active_sale_fso);?> Inactives</p>
              <div class="liner"></div>
              <h3>Second Sale Organization (SSO)</h3>
              <p><?php echo($executive_sso+$team_manager_sso+$manager_sso+$general_manager_sso+$diplomat_sso);?> Associate(s)</p>
              <p><?php echo($active_sale_sso);?> Actives, <?php echo($executive_sso+$team_manager_sso+$manager_sso+$general_manager_sso+$diplomat_sso-$active_sale_sso);?> Inactives</p>
            </div>
            <div style="clear:both"></div>
            			 
               <a href="edit-profile.php" class="button small nice green radius">MY PROFILE</a>
                            <a href="genealogy.php" class="button small nice blue radius">ORGANIZATION CHART</a>
            
			            
                <a href="../php_scripts_wb/logout.php" class="button small nice white radius"> Log Out</a>
            
			          </div>
        </div>
      </div>
    </div>
    <div style="position:relative;height:15px;"></div>
    <ul class="primary-nav">
      <li><a href="index.php"class="current">HOME</a></li>
            
      <li><a href="#">RESELLER PANEL</a>
        <ul>
                              <li><a href="reseller_new.php">Submit a New Sale</a></li>
          <li><a href="sales-reports.php">Sale Organization Report</a></li>
          <li><a href="associatesearch.php">Associates List</a></li>
          <li><a href="payment.php">Payment Details</a></li>
          <li><a href="genealogy.php">Organization Chart</a></li>
          <li><a href="online_transfer.php" >Online Transfer</a></li>
                    <li><a href="vat.php" >Generate Invoice</a></li>
                  </ul>
      </li>
      
                  <li><a href="#">SERVICES</a>
        <ul>
          <li><a href="woipl.php">AOIPL</a></li>
          <li><a href="domain-name.php">Apply for Domain Name</a></li>
          <li><a href="seo-school.php">SEO School</a></li>
          <li><a href="mobile-web.php" >Mobile Site Builder</a></li>
          <li><a href="easyweb.php">AS Easy Web</a></li>
          <li><a href="adsense.php">Register for Google AdSense</a></li>
          <li><a href="tyro.php">Register for Tyro</a></li>
          <li><a href="user-agreement.php">User Guides</a></li>
          <li><a href="cpanel.php">cPanel Login</a></li>
          <li><a href="user-agreement.php">User Agreement</a></li>
          <li><a href="support-center.php">Support Center</a></li>
        </ul>
      </li>
                  <li><a href="#">E-PINS</a>
        <ul>
          <li><a href="request_epins.php">Request Epins</a></li>
          <li><a href="received_epins.php">Received Epins</a></li>
          <li><a href="sent_epins.php">Pending Epins request</a></li>
          <li><a href="used_epins.php">Used Epins</a></li>
        </ul>
      </li>
            <li><a href="checkdomain.php">DOMAIN AVAILABILITY</a></li>
      <li><a href="meeting_home.php">MEETING AND SEMINAR</a></li>
      <li><a href="support-center.php">SUPPORT CENTER</a></li>
    </ul>
  </div>
</div>
<input type="hidden" id="my_error_alert" value="<?php echo($my_msg);?>" />
<script>
if($("#my_error_alert").val()!="")
{
	var msg=$("#my_error_alert").val();
	alert(msg);
}
</script>