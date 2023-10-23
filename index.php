<?php require("php_scripts_wb/login.php");?>
<?php require_once("php_scripts_wb/connection.php");?>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$today_date=date("Y-m-d");
	$new_conn->query("UPDATE wb_ud SET status='deactive_expired' WHERE end_date!='0000-00-00' AND end_date<'$today_date'");
	$new_conn->close();
}
?>
<?php
$msg="";
$username="";
$password="";
if(isset($_POST['submitform']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$login_obj=new check_login();
	$login_obj->db_login_check($username,$password);
	if($login_obj->error_status=="yes")
	{
		$msg=$login_obj->msg_error;
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login Panel</title>
<style>
body{
padding:0;
margin:0;
font-size:12px;
font-family:Arial, Helvetica, sans-serif;
}
#header{
position:relative;
min-width:980px;
}
#footer{
position:absolute;
display:none;
bottom:0;
width:100%;
font-weight:bold;
min-width:980px;
}
#footer a:link{
color:#E00;
}
#footer a:visited{
color:#E00;
}
#footer a:hover{
color:#2978b0;
}
#footer a:active{
color:#E00;
}
#username{
background-image:url(images/username-icon-small.png);
background-repeat:no-repeat;
background-size:25px 100%;
}
#password{
background-image:url(images/key-small.png);
background-repeat:no-repeat;
background-size:25px 100%;
}
#username,#password{
height:25px;
padding-left:30px;
background-color:#EEE;
width:150px;
}
#loginbox{
position:relative;
display:table;
background-color:#BBB;
margin:auto;
padding:20px;
padding-left:30px;
padding-right:30px;
-webkit-border-radius:8px;
-moz-border-radius:8px;
border-radius:8px;
box-shadow:0px 3px 5px #333333;
}
#loginbox a{
text-decoration:none;
font-weight:bold;
}
#loginbox a:link{
color:#2978b0;
}
#loginbox a:visited{
color:#2978b0;
}
#loginbox a:hover{
color:#C00;
}
#loginbox a:active{
color:#2978b0;
}
#error_msg{
position:relative;
background-color:#C00;
color:#FFF;
font-weight:bold;
letter-spacing:1px;
text-align:center;
line-height:30px;
font-size:14px;
}
#success_msg{
position:relative;
background-color:#060;
color:#FFF;
font-weight:bold;
letter-spacing:1px;
text-align:center;
line-height:30px;
font-size:14px;
}
</style>
</head>
<body>
<div id="error_msg"><?php echo($msg);?></div>
<div id="success_msg"></div>
<div style="position:relative;min-width:980px;">
  <table border="0" style="width:940px;margin:auto;">
    <tr style="height:50px;">
      <td></td>
    </tr>
    <tr>
      <td align="center"><img src="admin/images/logo.png" /></td>
    </tr>
    <tr>
      <td><br>
        <div id="loginbox">
          <form method="post">
          <table>
            <tr>
              <td style="font-size:20px;font-weight:bold;text-align:center;color:#C00;">User Login</td>
            </tr>
            <tr style="height:10px;">
              <td></td>
            </tr>
            <tr>
              <td><input type="text" name="username" id="username" placeholder="Username" /></td>
            </tr>
            <tr>
              <td><input type="password" name="password" id="password" placeholder="Password" /></td>
            </tr>
            <tr>
              <td align="right"><input type="submit" name="submitform" value="Login" style="background-color:#C00;color:#FFF;border:none;padding-top:5px;padding-bottom:5px;box-shadow:0px 0px 2px #FFF;width:100%;" /></td>
            </tr>
            <tr style="height:25px;">
              <td><!--<a href="#">Forgot password ?</a>--></td>
            </tr>
          </table>
          </form>
        </div>
      </td>
    </tr>
  </table>
</div>
<div id="footer">
        <table style="width:940px;margin:auto;">
          <tr style="height:30px;">
            <td align="center">Copyright &copy; 2015 Aspire Society. All rights reserved.</td>
          </tr>
        </table>
</div>
<script src="javascript/jquery_file.js"></script>
<script>
$(window).resize(function() {
var h = $(window).height();
if(h<500)
{
		$("#footer").css({'top':'500px'});
}
else
{
		$("#footer").css({'top':'auto','bottom':'0px'});
}
});
$(document).ready(function() {
    var h = $(window).height();
	if(h<500)
	{
		$("#footer").css({'display':'block','top':'500px'});
	}
	else
	{
		$("#footer").css({'display':'block'});
	}
});
</script>
</body>
</html>