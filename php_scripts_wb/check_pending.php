<?php
session_start();
$timenow=time();
if(!(isset($_SESSION['logged']) && $_SESSION['logged']=="pending_linked"))
{
session_unset();
session_destroy();
header ("Location: /index.php");
}
else if(($timenow-$_SESSION['lastactivity'])>3600)
{
session_unset();
session_destroy();
header ("Location: /index.php");
}
else
{
$_SESSION['lastactivity']=time();
}
$session_id=$_SESSION['log_id'];
$ip=$_SERVER['REMOTE_ADDR'];
$browser=$_SERVER['HTTP_USER_AGENT'];
$my_msg="";
if(isset($_SESSION['msg']))
{
	$my_msg=$_SESSION['msg'];
	$my_msg=str_replace("<br />","\n",$my_msg);
	unset($_SESSION['msg']);
}

?>