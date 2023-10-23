<?php
session_start();
$timenow=time();
if(!(isset($_SESSION['logged']) && $_SESSION['logged']=="admin"))
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
?>