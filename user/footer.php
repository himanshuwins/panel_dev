<div id="footer" style="background:url(images/header.jpg);">
  <div class="inner">
    <div class="span-6">
      <p style="text-align:center;"><img src="images/logo.png" width="100" alt="AS" /><br>AS</p>
    </div>
        <div class="span-6">
      <h3 class="widget-title"><strong>Sitemap</strong></h3>
      <ul class="default">
        <li><a href="payment_mode.php">Payment Modes</a></li>
        <li><a href="user-agreement.php">Legal Agreement</a></li>
        <li><a href="highest_earner.php">Highest Achiever of the Week</a></li>
      </ul>
      <h3 class="widget-title"><strong>Downloads</strong></h3>
      <ul class="default">
        <li><a href="#" target="_blank">Training manual</a></li>
        <li><a href="#" target="_blank" >Declaration Form</a></li>
        <li><a href="#" target="_blank">Portfolio</a></li>
        <li><a href="#" target="_blank">NOC Form</a></li>
      </ul>
    </div>
    <div class="span-6">
      <h3 class="widget-title"><strong>Highest Earner </strong></h3>
      <ul class="popular-posts">

<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT session_no FROM wb_ch ORDER BY session_no DESC LIMIT 0,1");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$session_to_check=$detail['session_no'];
		
		$res=$new_conn->query("SELECT a.total_amount,b.first_name,b.last_name,b.city,b.profile_path FROM wb_ch a INNER JOIN wb_ud b ON b.table_id=a.id WHERE a.session_no='$session_to_check' AND a.total_amount>='5000' AND b.status='active' ORDER BY a.total_amount DESC LIMIT 0,4");
		while($detail=$res->fetch_assoc())
		{
			echo("<li><img src=\"".$detail['profile_path']."\" width=\"30\" height=\"30\" alt=\"Popular\" />");
			echo("<p><a href=\"highest_earner.php\">".$detail['first_name']." ".$detail['last_name']."</a></p>");
			echo("<span>".$detail['city']." | ".$detail['total_amount']." </span> </li>");
		}
	}
	$new_conn->close();
}
?>         
              </ul>
    </div>
        <div class="span-6 last" style="float:right">
      <h3><strong>About</strong> Us</h3>
      <p>AS visions to become the best I.T. company of the world. With our strong leadership and strategy we are considered an evolution today. </p>
      <ul class="social-icons">
      </ul>
    </div>
  </div>
</div>

<div id="copyright" style="background:url(images/footer.jpg) !important;">
  <div class="inner">
    <div class="span-24 last">
      <div class="span-12">
        <p>&#169; 2015 AS. All rights reserved.</p>
      </div>
      <div class="span-142 last text-right"> <a href="user-agreement.php" >Terms and Conditions</a> | <a href="http://aspiresociety.com/index.php/contact/" target="_blank">Contact Us</a> </div>
    </div>
  </div>
</div>


<div id="blackout" style="position:fixed;background-color:#000;opacity:0.9;left:0;top:0;height:100%;width:100%;z-index:99999;visibility:hidden;">
</div>
<div id="blackout_container" style="position:fixed;left:50%;top:50%;margin-left:-25px;margin-top:-25px;background-color:#FFF;">

        <link media="screen" rel="stylesheet" target="_blank" href="css/colorbox.css" />
  <link media="screen" rel="stylesheet" target="_blank" href="css/popup.css" />
  <script language="javascript" src="js/colorbox.js"></script> 
  <script>
<?php
if($days_left<=30)
{
	echo("$(\"document\").ready(function (){ $.colorbox({width:\"580px\", inline:true, href:\"#subscribe_popup\"});$(\".open_popup\").colorbox({width:\"580px\", inline:true, href:\"#subscribe_popup\"});});");
}
?>
    
    
    </script>
  <div style="display:none;">
    <div id='subscribe_popup' style='padding:10px;'>
      <h2 class="box-title">Your Account will be expired within <?php echo($days_left)?> Days</h2>
      <h3 class="box-tagline">To Continued With Us Kindly Renew Your AS WEB PACKAGE</h3>
      <div id="subs-container" class="clearfix"> 
        <div class="box-side left">
          <div class="box-icon"><img src="images/check.png"/></div>
          <h4>Payment With Bank</h4>
          <h5>You  can  make the payment to through RTGS/NEFT/DD</h5>
          <a href="#" class="button nice radius blue small">Make Payment</a> 
        </div>
        <div id="box-or">OR</div>
        <div class="box-side right">
          <div class="box-icon"><img src="images/card-option.png"/></div>
          <h4>Payment With Online <span style="color:#0000FF"><b>*</b></span></h4>
          <h5>You  can also make the payment through Debit/Credit/Cash Card Or Net Banking.</h5>
          <a href="#" class="button nice radius blue small">Make Payment</a><br />
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript" src="js/jquery.primarynav.js"></script>
<script type="text/javascript" src="js/jquery.supersubs.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="js/jquery.effects.core.js"></script>
<script type="text/javascript" src="js/jquery.effects.toggle.js"></script>
<script type="text/javascript" src="js/jquery.cycle.js"></script>
<script type="text/javascript" src="js/jquery.tweets.js"></script>
<script type="text/javascript" src="js/jquery.custom.js"></script>
