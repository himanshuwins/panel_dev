<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
if(!empty($_POST))
{
	$cnumber=$_POST['cnumber'];
	$email=$_POST['email'];
	$PostalCode=$_POST['PostalCode'];
	$state=$_POST['state'];
	$city=$_POST['city'];
	$address2=$_POST['address2'];
	$address2=nl2br($address2);
	$old_password=$_POST['old_password'];
	$new_password=$_POST['new_password'];
	$pic_path="";
  
	$filename="";
	$path="";
	$path_1="";
	$i=0;
	$uploaded_before_error=0;
	
	try
	{
	  $counter_name = "uploads/counters.txt";
	  $upload_directory="uploads/files";
	  if (!is_dir($upload_directory))
	  {
		  if (!mkdir($upload_directory, 0777, true))
		  {
			  throw new Exception('Error : Some files missing...Please contact customer care...');
		  }
	  }
	  if(is_uploaded_file($_FILES["file_tmp"]["tmp_name"]))
	  {
		  if (!file_exists($counter_name))
		  {
			  throw new Exception('Error : Some files missing...Please contact customer care...2');
		  }
		  $f = fopen($counter_name,"r");
		  $counterVal = fread($f, filesize($counter_name));
		  $counterVal++;
		  fclose($f);
		  
		  $f = fopen($counter_name, "w");
		  if(!fwrite($f, $counterVal))
		  {
			  throw new Exception('Error : Unable to upload...');
		  }
		  fclose($f);
				
		  $filename = $_FILES["file_tmp"]['tmp_name'];
		  if(!($_FILES["file_tmp"]["size"] < 20971520))
		  {
			  throw new Exception('Error : Size of photo must be less than (20 MB)...!!!');
		  }
		  
		  $allowedExts = array("JPG","JPEG","GIF","PNG","jpg","jpeg","gif","png");
		  $temp = explode(".", $_FILES["file_tmp"]["name"]);
		  $extension = end($temp);
		  if(!(in_array($extension, $allowedExts)))
		  {
			  throw new Exception('Error : Not a valid file type...!!!');
		  }
		  $pic_path=$upload_directory."/".$counterVal."-".$_FILES["file_tmp"]["name"];
		  if(!(move_uploaded_file($filename,$pic_path)))
		  {
			  throw new Exception('Error : File upload feature not available at this time...Try again later...(Error 1)!!!');
		  }
	  }
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$cnumber=$new_conn->real_escape_string($cnumber);
		$email=$new_conn->real_escape_string($email);
		$PostalCode=$new_conn->real_escape_string($PostalCode);
		$state=$new_conn->real_escape_string($state);
		$city=$new_conn->real_escape_string($city);
		$address2=$new_conn->real_escape_string($address2);
		$address2=nl2br($address2);
		$old_password=$new_conn->real_escape_string($old_password);
		$new_password=$new_conn->real_escape_string($new_password);
		$pic_path=$new_conn->real_escape_string($pic_path);
		
		$throwable="no";
		$prepared="UPDATE wb_ud SET phone_no='$cnumber',email_id='$email',pincode='$PostalCode',state='$state',city='$city',c_local='$address2'";
		if($new_password!="")
		{
			$res=$new_conn->query("SELECT * FROM wb_ud WHERE table_id='$session_id' AND password='$old_password'");
			if($res->num_rows!=1)
			{
				$new_conn->close();
				throw new Exception('Error : Old password is incorrect...Go back and try again...');
			}
			$prepared.=",password='$new_password'";
		}
		if($pic_path!="")
		{
			$prepared.=",profile_path='$pic_path'";
			$throwable="yes";
		}
		$prepared.=" WHERE table_id='$session_id'";
		$new_conn->query($prepared);
		$new_conn->close();
		$msg_to_post="Saved successfully...";
		$temp_filename="edit-profile.php";
		header("Location: /panel/user/redirect_back.php?q=".$temp_filename."&msg=".$msg_to_post);
	}
	}
	catch (Exception $e)
	{
		if($pic_path!="")
		{
			unlink($filename);
		}
		echo($e->getMessage());
		exit();
	}
}
?>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_ud WHERE table_id='$session_id'");
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$new_conn->close();
	}
	else
	{
		$new_conn->close();
		echo("Error : not found...");
		exit();
	}
}
?>
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
      <div class="img-inner"><img src="<?php echo($profile_path_db);?>" width="83" height="83" alt="<?php echo($tag_db);?>" title="<?php echo($tag_db);?>"></div>
    </div>
    <h2>Update Your Profile</h2>
    <h3>
      <?php echo($_SESSION['log_name']);?>    </h3>
  </div>
</div>
<div class="container forms">
  <div class="span-24">
    <h3>Personal Profile</h3>
  </div>
      <form enctype="multipart/form-data" id="form1" name="form1" method="post" onSubmit="return validateform()">
	  <div class="span-24">
    <table width="100%" cellspacing="20" cellpadding="0" border="0" bgcolor="#FFFFFF" class="alternate">
      <tbody>
        <tr>
          <td colspan="3" align="center" valign="top" class="arial12light_blue">
            		</td>
        </tr>
        <tr>
          <td width="20%" align="left" valign="top" class="arial12light_blue"><strong>Name</strong></td>
          <td width="37%" align="left" valign="top" class="arial11"><?php echo($detail_main['first_name']." ".$detail_main['last_name']);?></td>
          <td width="43%" align="left" valign="top" class="arial10">Not Editable</td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Date of Birth</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['dob']);?></td>
          <td valign="top" align="left"><span class="arial10"><input type="hidden"name="DOB"value="1993-01-01"/>Not Editable</span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Contact Number</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['phone_no']);?></td>
          <td valign="top" align="left"><input type="text" onChange="checkform('cnumber','cn','numExp')" value="<?php echo($detail_main['phone_no']);?>" id="cnumber" name="cnumber">
            &nbsp;<span id="cn" class="arialRedbold"></span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Email</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['email_id']);?></td>
          <td valign="top" align="left"><input type="text" onChange="checkform('email','em','email')" value="<?php echo($detail_main['email_id']);?>" id="email" name="email">
            &nbsp;<span id="em" class="arialRedbold"> </span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>PAN</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['pan']);?></td>
          <td valign="top" align="left"><span class="arial10">Not Editable</span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Distributor ID</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['did']);?></td>
          <td valign="top" align="left"><span class="arial10">Not Editable</span></td>
        </tr>
      </tbody>
    </table>
    </div>
  <div class="span-24">
    <h3>Mailing Address</h3>
  </div>
  <div class="span-24">
    <table cellspacing="20" cellpadding="0" border="0" bgcolor="#FFFFFF" class="alternate">
      <tbody>
        <tr>
          <td width="20%" align="left" valign="top" class="arial12light_blue"><strong>Country</strong></td>
          <td width="37%" align="left" valign="top" class="arial11"><?php echo($detail_main['country']);?></td>
          <td width="43%" align="left" valign="top"><span class="arial10">Not Editable</span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Postal Code / PIN</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['pincode']);?></td>
          <td valign="top" align="left"><label>
            <input type="text" value="<?php echo($detail_main['pincode']);?>" id="PostalCode" name="PostalCode">
            &nbsp;<span id="ad1" class="arialRedbold"> </span></label></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Permanent Address</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['p_local']);?></td>
          <td valign="top" align="left"><label>
            <textarea disabled="disabled" name="address1"><?php echo($detail_main['p_local']);?></textarea>
            </label>
          </td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>State</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['state']);?></td>
          <td valign="top" align="left"><input type="text" value="<?php echo($detail_main['state']);?>" id="state" name="state">
            &nbsp;<span class="arialRedbold"> </span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>City</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['city']);?></td>
          <td valign="top" align="left"><input type="text"  value="<?php echo($detail_main['city']);?>" id="city" name="city"></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Postal Address </strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['c_local']);?></td>
          <td valign="top" align="left"><textarea name="address2"><?php echo($detail_main['c_local']);?></textarea>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="span-24">
    <h3>Change Your Password</h3>
  </div>
  <div class="span-24">
    <table cellspacing="20" cellpadding="0" border="0" bgcolor="#FFFFFF" class="alternate">
      <tbody>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Username:</strong></td>
          <td valign="top" align="left" class="arial11"><?php echo($detail_main['username']);?></td>
          <td valign="top" align="left"><label><span class="arial10">Not Editable</span></label></td>
        </tr>
        <tr>
          <td valign="top" align="left"><strong><span class="arial12light_blue">Old password</span></strong></td>
          <td valign="top" align="left" class="arial11"><input type="password" id="old_password" name="old_password"></td>
          <td valign="top" align="left"><span class="arialRedbold"> </span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>New Password</strong></td>
          <td valign="top" align="left" class="arial11"><input type="password" id="new_password" name="new_password"></td>
          <td valign="top" align="left"><span id="ps" class="arialRedbold"> </span></td>
        </tr>
        <tr>
          <td valign="top" align="left" class="arial12light_blue"><strong>Retype Password</strong></td>
          <td valign="top" align="left" class="arial11"><input type="password" onChange="checkpassword('new_password','repassword','ps')" id="repassword" name="repassword"></td>
          <td valign="top" align="left">&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="span-24">
    <h3>Update Your Photo</h3>
  </div>
  <div class="span-24">
    <table width="100%" cellspacing="10" cellpadding="0" border="0" bgcolor="#FFFFFF" class="alternate">
      <tbody>
              <tr>
          <td width="10%" align="left" valign="middle" class="arial12light_blue"><strong>Photo</strong></td>
          <td width="49%" align="left" valign="middle" class="arial11"><label>
        <input type="file" name="file_tmp" />
            </label>
            <strong>Size: 112px X 112px </strong> </td>
          <td width="41%" align="left" valign="top"><table cellspacing="4" cellpadding="0" border="0" align="right">
              <tbody>
                <tr>
                  <td><img width="180" height="180" title="<?php echo($tag_db);?>" alt="<?php echo($tag_db);?>" src="<?php echo($profile_path_db);?>"></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        
		<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="button3" id="button3" value="Update Profile" /></td>
		<td>&nbsp;</td>				
      </tbody>
    </table>
	
  </div>
  </form>
</div>
    
    
<?php
	require_once("footer.php");
?>
<script>
function validateform()
{
	var ans=confirm("Are you sure you want to update ?");
	if(ans==true)
	{
		document.form1.submit();
	}
	else
	{
		return false;
	}
}
</script>
</body>
</html>
