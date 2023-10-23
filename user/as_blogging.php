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
        	  <p><img src="images/web-blade.jpg" width="590" height="376" alt="Blog post" /></p></div>
      
            
            <div class="entry-content"><h3>No HTML knowledge needed!</h3><p>Site Management. Easily add, edit, clone and structure your web pages from a single file.<br>
Customizable menus, toolbars, keyboard accelerators, dockable windows, tabs, autohide windows.<br>
Supports Form fields: Editbox, TextArea, etc.<br>
Rich text support: text object can contain different fonts, colors, links and sizes.<br>
Custom HTML object to insert your own HTML or Javascripts.<br>
JAVA, Flash, Windows Media, YouTube, Flash Video. Quicktime, Real Audio and other Plug-In support.<br>
Template support. Already more than 350+ templates available! and much more.....</p>
            </div>
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
		$wordpress_link=$detail['wordpress_link'];
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
	echo("<a class=\"button nice radius green small\" href=\"http://".$wordpress_link."\">GO TO WORDPRESS</a>");
}
else
{
	echo("<a class=\"button nice radius green small\" href=\"http://".$wordpress_link."\">GO TO WORDPRESS</a>");
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
