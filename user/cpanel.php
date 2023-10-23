<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	require_once("header.php");
?>
<script language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js" type="text/javascript"></script>

<div class="container">

	<div class="span-15"> 
    	<div class="post-entry">
        	<div class="entry-thumb">
        	  <p><img src="images/cpanel.jpg" width="590" height="376" alt="Blog post" /></p></div>
      
            
            <div class="entry-content"><p><strong>CPanel</strong> is the industry leader for turning standalone servers into a fully automated point-and-click hosting platform. Tedious tasks are replaced by web interfaces and API-based calls. cPanel is designed with multiple levels of administration including admin, reseller, end user, and email-based interfaces. These multiple levels provide security, ease of use, and flexibility for everyone from the server administrator to the email account user. </p>
            
            <h3>Managing a website with cPanel</h3>
            <p>The most important part of a website ownerâ€™s job is creating, uploading, and editing web pages. In cPanel, a site owner has several options for managing content. He or she can:
<ul>
<li>Easily upload and manage web pages in cPanel's File Manager.</li>
<li>Use cPanelâ€™s Web Disk feature to drag and drop files into the customers account.</li>
<li>Use traditional file transfer methods (including FTP, SFTP, and FTPS).</li>
<li>Create additional FTP accounts for employees.</li>
</ul></p>

<p>Site owners can install commonly used web-based applications, such as WordPress blogs, osCommerce stores, and phpBB forums, simply by answering a few quick questions in the cPanel interface.</p>

<p>Backing up data is simple with cPanelâ€™s Backup Wizard. Our software comes equipped with an interface to help site owners manage and acquire backups for their entire account.</p>

<p>Virus protection makes it easy to scan files for viruses. Site owners can even prevent other websites from inappropriately using their bandwidth, password-protect areas of a site, and set up cPanel to automatically ban a user who shares a password to a restricted area of the website.</p>

<p>Many SEOs prefer cPanel because of the amount of information it provides about web traffic. Web statistics can be generated by three different statistics generators. In addition, logs of errors encountered by website visitors, bandwidth tracking, and even raw FTP access logs are available via the cPanel interface.</p>

<p>Professional web developers love cPanel, too. They can quickly view a server's PHP configuration, install Ruby Gems, customize error pages and how content is served.</p>

<p>Localization allows webmasters to use cPanel in Arabic, Bengali, Brazilian Portuguese, Chinese, Dutch, English, French, German, Hindi, Japanese, Portuguese, Russian or Spanish.</p>
<h3>CPanel provides comprehensive email management</h3>
<p>Website owners can use cPanel to create email accounts associated with a website. cPanel supports the standard mail protocols, including POP, IMAP, and SMTP, both with and without SSL encryption. </p>
<p>CPanel provides a web-based interface for checking email, so account holders can access mail at any time, from any computer with a web browser. cPanel also supports the latest email technologies to ensure messages reach the intended destination. </p>
<p>CPanel users can set up email forwarding, which allows account holders to have an address at one domain (such as webmaster@cpanelexample.com) forward incoming messages to another (such as your-name@example.com). This can also be useful to businesses that need to route email to an employeeâ€™s BlackBerryÂ® or other mobile device. </p>
<p>For power users, mail filtering and mailing lists are available.</p><br />
<h3>cPanel is easy to use</h3>
<p>Our expert team continuously refines the cPanel interface. The result is an intuitive product that allows website owners to maintain their sites easily without needing to contact their hosting provider. </p>
<p>To minimize setup time, cPanel includes a Getting Started Wizard, which walks new users through the initial configuration of an account. Users also have access to built-in video tutorials and on-screen documentation, for step-by-step instructions and other useful information. </p>
<p>Try it for yourself: log into our demo cPanel account. </p>
<p><strong>Demo:</strong>&nbsp; &nbsp;<a href="http://cpanel.demo.cpanel.net/frontend/x3/index.html?post_login=17750141964958">http://cpanel.demo.cpanel.net/frontend/x3/index.html?post_login=17750141964958</a><br />

<strong>username:</strong> x3demob<br />
<strong>password:</strong> x3demob</p>
            
            <div class="span-12 push-1 last">
		<div class="span-11">
        	<p><img src="images/round_checkmark_icon&32.png" width="32" height="32" alt="Pop" class="float-left" />Site owners can install commonly used web-based applications, such as WordPress blogs
            <p><img src="images/round_checkmark_icon&32.png" width="32" height="32" alt="Pop" class="float-left" />Many SEOs prefer cPanel because of the amount of information it provides about web traffic. </p>
            <p><img src="images/round_checkmark_icon&32.png" width="32" height="32" alt="Pop" class="float-left" />CPanel provides a web-based interface for checking email, so account holders can access mail at any time, from any computer with a web browser.</p>
        </div>
        </div></div>
        </div>
        
    	        
    	
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_msg WHERE by_id='$session_id' AND subject='Domain Registration'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$domain=$detail['message'];
		$cpanel_link=$detail['cpanel_link'];
		$found="yes";
	}
	else
	{
		$new_conn->close();
		$found="no";
	}
}
?>
<?php
if($found=="yes")
{
	echo("<a class=\"button nice radius green small\" href=\"http://".$cpanel_link."\">GO TO CPANEL LOGIN</a>");
}
else
{
	echo("<a class=\"button nice radius green small\" href=\"http://".$cpanel_link."\">GO TO CPANEL LOGIN</a>");
}
?>      
               
    </div>
      <div class="span-8 sidebar last push-1">
<div class="span-8 widget last">
    <?php include("common/services_menu.php");?>
</div>


</div>
<div class="container-shadow"></div>
</div>


<?php
	require_once("footer.php");
?>
</body>
</html>
