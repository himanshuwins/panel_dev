<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php include("php_scripts_wb/parse_downline_with_details.php");?>
<?php
$session_id=$_SESSION['log_id'];
$msg="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
<?php
if(isset($_GET['username']))
{
	$username_url=$_GET['username'];
	if($username_url=="")
	{
		echo("Error : Invalid Username...");
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
		$username_url=$new_conn->real_escape_string($username_url);
		$res_temp=$new_conn->query("SELECT * FROM wb_ud WHERE username='$username_url'");
		if($res_temp->num_rows==1)
		{
			$detail_temp=$res_temp->fetch_assoc();
			$to_check_for=$detail_temp['table_id'];
			$new_conn->close();
		}
		else
		{
			$new_conn->close();
			echo("Error : Not found...!!!");
			exit();
		}
	}
}
else
{
	echo("Error : Invalid request");
	exit();
}
?>
<?php include("php_scripts_wb/sales_report.php");?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Panel</title>
<script src="../javascript/jquery_file.js"></script>
<link rel="stylesheet" type="text/css" href="css/style_full.css" media="screen, projection" />
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
.downline_chart a{
color:#333;
}
.downline_chart a:link{
}
.downline_chart a:visited{
}
.downline_chart a:hover{
color:#000;
}
.downline_chart a:active{
}
</style>
</head>
<body>

<div id="content_main">
<table style="width:98%;margin:auto;font-size:1em;text-align:center;" border="0" cellpadding="0" cellspacing="0" class="downline_chart">
  <tr>
    <td align="left"><h2 style="color:#333;line-height:50px;">SALES REPORT | <a href="downline_chart.php?username=<?php echo($username_url);?>" style="text-decoration:underline;color:#06C;">DOWNLINE CHART</a></h2></td>
  </tr>
  <tr>
  <td align="left">
  <div class="container">  

	<div class="span-12">
    <p><img src="images/salespeople.jpg" width="400" height="300" alt="Columns" /></p>
    </div>
    <div class="span-12 last sale">
	<h2> <?php echo($name);?></h2>
    <p><h4><?php echo($tag);?></h4></p>
    <hr />
    <p>DID: <span class="bigger"> <?php echo($did);?></span></p>
    <hr />
    <p>Associate Since: <span class="bigger"> <?php echo($total_days);?> Days</span></p>
    <hr />
    <p>Days Left for Expiry: <span class="bigger"> <?php echo($days_left);?> Days</span></p> 
    
    <hr />
    <p>Total No. of Associates: <span class="bigger"> <?php echo($total_sales);?></span></p>   
    </div>

	<hr />
    
    <div class="span-24 text-center">
    <h1>Sale Organization Details</h1>
    <p class="quiet"><i>Complete Sale Organization Report | Associate Status</i></p>
    </div>
    	<hr class="space" />
	<div class="span-24 pricing">
        
        <div class="span-6 pricing-column">  
            <div class="pricing-column-head">
                <h2><strong>FSO</strong></h2>
                <h4>First Sale Organization</h4>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Executive</strong> <span class="bigger right-align"><?php echo($executive_fso);?></span></li>
                    <li><strong>Team Manager</strong> <span class="bigger right-align"><?php echo($team_manager_fso);?></span></li>
                    <li><strong>Manager</strong> <span class="bigger right-align"><?php echo($manager_fso);?></span></li>
                    <li><strong>General Manager</strong> <span class="bigger right-align"><?php echo($general_manager_fso);?></span></li>
                    <li><strong>Diplomat</strong> <span class="bigger right-align"><?php echo($diplomat_fso);?></span></li>
                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($executive_fso+$team_manager_fso+$manager_fso+$general_manager_fso+$diplomat_fso);?></span>
            </div>        
        </div>
        
        <div class="span-6 pricing-column">  
            <div class="pricing-column-head">
                <h2><strong>SSO</strong></h2>
                <h4>Second Sale Organization</h4>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Executive</strong> <span class="bigger right-align"><?php echo($executive_sso);?></span></li>
                    <li><strong>Team Manager</strong> <span class="bigger right-align"><?php echo($team_manager_sso);?></span></li>
                    <li><strong>Manager</strong> <span class="bigger right-align"><?php echo($manager_sso);?></span></li>
                    <li><strong>General Manager</strong> <span class="bigger right-align"><?php echo($general_manager_sso);?></span></li>
                    <li><strong>Diplomat</strong> <span class="bigger right-align"><?php echo($diplomat_sso);?></span></li>
                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($executive_sso+$team_manager_sso+$manager_sso+$general_manager_sso+$diplomat_sso);?></span>
            </div>        
        </div>
        
        <div class="span-11 last sale right-align">
	<h2><strong>Sale Organization</strong> Report</h2>
    <h4>First Sale Organization (FSO)</h4>
    <p><span class="bigger"><?php echo($executive_fso+$team_manager_fso+$manager_fso+$general_manager_fso+$diplomat_fso);?></span>  Associates | <span class="bigger"><?php echo($active_sale_fso);?></span>  Actives | <span class="bigger"><?php echo($executive_fso+$team_manager_fso+$manager_fso+$general_manager_fso+$diplomat_fso-$active_sale_fso);?></span>  Inactives</p>
    <hr />
    <h4>Second Sale Organization (SSO)</h4>
    <p><span class="bigger"><?php echo($executive_sso+$team_manager_sso+$manager_sso+$general_manager_sso+$diplomat_sso);?></span>  Associates | <span class="bigger"><?php echo($active_sale_sso);?></span>  Actives | <span class="bigger"><?php echo($executive_sso+$team_manager_sso+$manager_sso+$general_manager_sso+$diplomat_sso-$active_sale_sso);?></span>  Inactives</p>
    <hr />
    <h4>Your Referral <b>(<?php echo($directs_fso+$directs_sso);?>) Associates<b></h4>
    <p style="font-weight:400;"><span class="bigger"></span>  
    <?php echo($directs_names_string);?>
    </p>
    <hr />
    <h4>Your Sponsors <b>Associates<b></h4>
    <p style="font-weight:400;"><?php echo($sponsor_from_db);?></p>    
 
    </div>
    
</div>
<hr class="space" \>

<div class="span-24 pricing">
<div class="span-6 pricing-column green-box">  
            <div class="pricing-column-head">
                <h2>Active Sale</h2>
                <h5>Your Total Linked Associates</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($active_sale_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($active_sale_sso);?></span></li>
                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($active_sale_fso+$active_sale_sso);?></span>
            </div>        
        </div>
<div class="span-6 pricing-column red-box">  
            <div class="pricing-column-head">
                <h2>To Be Linked</h2>
                <h5>Cheque has yet to be verified</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($to_be_linked_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($to_be_linked_sso);?></span></li>
                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($to_be_linked_fso+$to_be_linked_sso);?></span>
            </div>        
        </div>
     <div class="span-6 pricing-column lightgreen-box">  
            <div class="pricing-column-head">
                <h2>Renewed Sale</h2>
                <h5>Total Renewed Associates</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($renewed_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($renewed_sso);?></span></li>

                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($renewed_fso+$renewed_sso);?></span>
            </div>        
        </div>     
        
 <div class="span-6 pricing-column last black-box">  
            <div class="pricing-column-head">
                <h2>Disabled Sale</h2>
                <h5>Cheques are disqualified</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($disabled_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($disabled_sso);?></span></li>

                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($disabled_fso+$disabled_sso);?></span>
            </div>        
    </div>       
    </div>
    
   <div class="span-24 pricing">
<div class="span-6 pricing-column orange-box">  
            <div class="pricing-column-head">
                <h2>Commissionable</h2>
                <h5>Ratio upto 2012-07-06</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($commissionable_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($commissionable_sso);?></span></li>
                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($commissionable_fso+$commissionable_sso);?></span>
            </div>        
        </div>
<div class="span-6 pricing-column blue-box">  
            <div class="pricing-column-head">
                <h2>Your Referrals</h2>
                <h5>Active Associate from your ref</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($directs_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($directs_sso);?></span></li>
                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($directs_fso+$directs_sso);?></span>
            </div>        
        </div>
     <div class="span-6 pricing-column magenta-box last">  
            <div class="pricing-column-head">
                <h2>Balance Sale</h2>
                <h5>Total FSO and SSO Balanc Sale</h5>
            </div>        
            <div class="pricing-column-body">
                <ul>
                    <li><strong>Active FSO</strong> <span class="bigger right-align"><?php echo($balance_fso);?></span></li>
                    <li><strong>Active SSO</strong> <span class="bigger right-align"><?php echo($balance_sso);?></span></li>

                </ul>
            </div>        
            <div class="pricing-column-foot">
                <strong>Total</strong> <span class="bigger right-align"><?php echo($balance_fso+$balance_sso);?></span>
            </div>        
        </div>     
 </div> 

</div>
</td>
</tr>
</table>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
$left_downline_chart=$left_val;
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>

<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_genealogy=$top_val;
?>
<?php include(dirname(__FILE__)."/common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="../javascript/error_alert.js"></script>
</body>
</html>