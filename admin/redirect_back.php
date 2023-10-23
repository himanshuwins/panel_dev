<?php
include("../php_scripts_wb/check_admin.php");
if(isset($_GET['msg']))
{
	$_SESSION['msg']=$_GET['msg'];
}
if(isset($_GET['q']))
{
	$q=$_GET['q'];
}
header("Location: /panel/admin/".$q);
?>