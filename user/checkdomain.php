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

<div id="top-main-container">
  <div class="inner">
    <div class="user-img">
      <div class="img-inner">
      </div>
    </div>
    <h2>Domain Name Availability Checker</h2> </div>
</div>
<div class="container">
  <form action="" method="post" name="frmsearchposition" class="frmstyle" id="frmsearchposition">
<table width="100%"   border="0" cellspacing="1" cellpadding="3">
<tr align="left">
<td width="20%" align="left" valign="middle" style="color: rgb(66, 66, 66);">Enter Domains  1 per line. (Ex: google.com) </td>
<td width="40%"><textarea name="domains" cols="55" rows="2" class="frmelements_ta" id="domains" style="height:73px;"></textarea></td>
</tr>
<tr>
&nbsp;
<td>
</td>
<td colspan="2" align="right"><input type="submit" name="Submit" value="Check Domain Availability"/></td>

</tr>
</table>
</form></td>
</tr>

<tr>
<td width="70%" align="center" valign="top">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
<td align="center"><h2>Domain Name Availability Report</h2></td>
</tr>
<tr>


<td align="left" class="tbl_texttd"><table width="740"   border="0" cellspacing="0" cellpadding="2">
<tr>
<td align="left">Please enter one or more domains!<div class="div"></div></td>
</tr>
</table></td>
</tr>
</table>
</td>
</tr>
</table>
  
  
 
</div>
<?php
	require_once("footer.php");
?>
</body>
</html>
