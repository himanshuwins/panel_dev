<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	require_once("header.php");
?>
<?php include("common/sales_report.php");?>
	<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js" type="text/javascript"></script>
<div id="top-main-container" style="background:url(images/header.jpg);">
  <div class="inner">

	 <div class="user-img">
      <div class="img-inner"><img src="<?php echo($profile_path_db);?>" width="83" height="83"></div>
    </div>
    <h2>Sale Organization Report</h2>
    <a href="sales-reports.php" class="button small nice blue radius">SALE ORGANIZATION REPORT</a> <a href="payment.php" class="button small nice red radius">PAYMENT DETAILS</a> <a href="genealogy.php" class="button small nice green radius">SALE ORGANIZATION CHART</a> <a href="vat.php" class="button small nice black radius">VAT INVOICE</a> </div>
</div>

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
    <p><span class="bigger"></span>
	<?php echo($directs_names_string);?>
    </p>
    <hr />
    <h4>Your Sponsors</h4>
    <p>  
    <?php
	echo($sponsor_from_db);
	?>
    </p>    
 
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
                <h5>Ratio upto last session</h5>
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


<?php
	require_once("footer.php");
?>
</body>
</html>
