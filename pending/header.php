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
		
		$total_days=$difference->d;
		
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
		parse_downline_with_details($new_conn,$fso,$active_sale_fso,$to_be_linked_fso,$linked_fso,$renewed_fso,$disabled_fso,$executive_fso,$team_manager_fso,$manager_fso,$general_manager_fso,$diplomat_fso);
		}
		if($sso!="")
		{
		parse_downline_with_details($new_conn,$sso,$active_sale_sso,$to_be_linked_sso,$linked_sso,$renewed_sso,$disabled_sso,$executive_sso,$team_manager_sso,$manager_sso,$general_manager_sso,$diplomat_sso);
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
      <img src="images/logo.png"  alt="" width="80" /></a>
    </div>
    <div class="super-info">
      <div class="main-toggles inlines">
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
            			 
               <a href="javascript:open_popup()" class="button small nice green radius">MY PROFILE</a>
                            <a href="javascript:open_popup()" class="button small nice blue radius">ORGANIZATION CHART</a>
            
			            
                <a href="../php_scripts_wb/logout.php" class="button small nice white radius"> Log Out</a>
            
			          </div>
        </div>
      </div>
    </div>
    <ul class="primary-nav">
      <li><a href="javascript:open_popup()"class="current">HOME</a></li>
            
      <li><a href="javascript:open_popup()">RESELLER PANEL</a>
        <ul>
                              <li><a href="javascript:open_popup()">Submit a New Sale</a></li>
          <li><a href="javascript:open_popup()">Sale Organization Report</a></li>
          <li><a href="javascript:open_popup()">Associates List</a></li>
          <li><a href="javascript:open_popup()">Payment Details</a></li>
          <li><a href="javascript:open_popup()">Organization Chart</a></li>
          <li><a href="javascript:open_popup()" >Online Transfer</a></li>
                    <li><a href="javascript:open_popup()" >Generate Invoice</a></li>
                  </ul>
      </li>
      
                  <li><a href="javascript:open_popup()">SERVICES</a>
        <ul>
          <li><a href="javascript:open_popup()">AOIPL</a></li>
          <li><a href="javascript:open_popup()">Apply for Domain Name</a></li>
          <li><a href="javascript:open_popup()">SEO School</a></li>
          <li><a href="javascript:open_popup()">Mobile Site Builder</a></li>
          <li><a href="javascript:open_popup()">Easy Web</a></li>
          <li><a href="javascript:open_popup()">Register for Google AdSense</a></li>
          <li><a href="javascript:open_popup()">Register for Tyro</a></li>
          <li><a href="javascript:open_popup()">User Guides</a></li>
          <li><a href="javascript:open_popup()">cPanel Login</a></li>
          <li><a href="javascript:open_popup()">User Agreement</a></li>
          <li><a href="javascript:open_popup()">Support Center</a></li>
        </ul>
      </li>
                  <li><a href="javascript:open_popup()">E-PINS</a>
        <ul>
          <li><a href="javascript:open_popup()">Request Epins</a></li>
          <li><a href="javascript:open_popup()">Received Epins</a></li>
          <li><a href="javascript:open_popup()">Pending Epins request</a></li>
          <li><a href="javascript:open_popup()">Used Epins</a></li>
        </ul>
      </li>
            <li><a href="javascript:open_popup()">DOMAIN AVAILABILITY</a></li>
      <li><a href="javascript:open_popup()">MEETING AND SEMINAR</a></li>
      <li><a href="javascript:open_popup()">SUPPORT CENTER</a></li>
    </ul>
  </div>
</div>