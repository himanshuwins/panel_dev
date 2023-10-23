<?php
require_once("../php_scripts_wb/check_user.php");
if(isset($_GET['msg']))
{
	$_SESSION['msg']=$_GET['msg'];
}
if(isset($_GET['q']))
{
	$q=$_GET['q'];
}
header("Location: /panel/user/".$q);
?>