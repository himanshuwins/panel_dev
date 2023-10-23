<?php include("../php_scripts_wb/check_user.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
function get_validity($date_str, $months)
{
    $date = new DateTime($date_str);
    $start_day = $date->format('j');

    $date->modify("+{$months} month");
    $end_day = $date->format('j');

    if ($start_day != $end_day)
        $date->modify('last day of last month');
		
    $date->modify("-1 day");

    return $date;
}
?>
<?php
if(isset($_GET['epin']))
{
	$epin_url=$_GET['epin'];
	if((filter_var($epin_url, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9A-Za-z]+/")))))
	{
		echo("Invalid request...");
		exit();
	}
}
else
{
	header("Location: /panel/user/received_epins.php");
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
	$res=$new_conn->query("SELECT a.* FROM wb_epins a INNER JOIN wb_ps b ON b.product_id=a.epin_product_code WHERE a.epin='$epin_url' AND a.created_by='$session_id' AND a.status='issued' AND a.used_by='N/A'");
	if($res->num_rows!=1)
	{
		$new_conn->close();
		echo("Error : Epin Invalid...");
		exit();
	}
}
?>
<?php
function generateRandomString($length = 8)
{
	$characters = '123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++)
	{
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
    return $randomString;
}
function calculate_linking_id($new_conn,$to_check,$side,&$imm_sponsor_ref)
{
	if($side=="L")
	{
		$prep="SELECT table_id,fso FROM wb_ud WHERE table_id='$to_check'";
		$res=$new_conn->query($prep);
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$to_return=$detail['table_id'];
			$fso=$detail['fso'];
			if($fso!="")
			{
				calculate_linking_id($new_conn,$fso,$side,$imm_sponsor_ref);
			}
			else
			{
				$imm_sponsor_ref=$to_return;
			}
		}
		else
		{
			$new_conn->close();
			echo("Error : Cannot calculate sponsor...Please contact your administrator...!!!");
			exit();
		}
	}
	if($side=="R")
	{
		$prep="SELECT table_id,sso FROM wb_ud WHERE table_id='$to_check'";
		$res=$new_conn->query($prep);
		if($res->num_rows==1)
		{
			$detail=$res->fetch_assoc();
			$to_return=$detail['table_id'];
			$sso=$detail['sso'];
			if($sso!="")
			{
				calculate_linking_id($new_conn,$sso,$side,$imm_sponsor_ref);
			}
			else
			{
				$imm_sponsor_ref=$to_return;
			}
		}
		else
		{
			$new_conn->close();
			echo("Error : Cannot calculate sponsor...Please contact your administrator...!!!");
			exit();
		}
	}
}
	$username="";
	$password="";
	$uid="";
	$did="";
	$leg="L";
	$linkCode="";
	$f_name="";
	$l_name="";
	$cnumber="";
	$nominee="";
	$email="";
	$birth_month="";
	$birth_date="";
	$birth_year="";
	$father_name="";
	$address2="";
	$address1="";
	$state="";
	$city="";
	$zip="";
	$domain1="";
	$extD1="";
	$domain2="";
	$extD2="";
	$domain3="";
	$extD3="";
	$draft_no="";
	$draft_month="";
	$draft_day="";
	$draft_year="";
	$amount="";
	$bank_branch="";
	$bank_name="";
	$pay_type="";
if(!empty($_POST))
{
	$username=$_POST['new_username'];
	$password=$_POST['formpassword'];
	$uid=$_POST['uid'];
	$did=$_POST['did'];
	$leg=$_POST['leg'];
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$cnumber=$_POST['cnumber'];
	$nominee=$_POST['nominee'];
	$email=$_POST['email'];
	$birth_month=$_POST['birth_month'];
	$birth_date=$_POST['birth_date'];
	$birth_year=$_POST['birth_year'];
	$father_name=$_POST['father_Name'];
	$address2=$_POST['address2'];
	$address1=$_POST['address1'];
	$address2=nl2br($address2);
	$address1=nl2br($address1);
	$state=$_POST['state'];
	$city=$_POST['city'];
	$zip=$_POST['zip'];
	$domain1=$_POST['domain1'];
	$extD1=$_POST['extD1'];
	$draft_no=$_POST['draft_no'];
	$draft_month=$_POST['draft_month'];
	$draft_day=$_POST['draft_day'];
	$draft_year=$_POST['draft_year'];
	$amount=$_POST['amount'];
	$bank_branch=$_POST['bank_branch'];
	$bank_name=$_POST['bank_name'];
	$pay_type=$_POST['pay_type'];
	
	try
	{
	$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
	if ($new_conn->connect_errno)
	{
		echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
		exit();
	}
	else
	{
		$username=$new_conn->real_escape_string($username);
		$password=$new_conn->real_escape_string($password);
		$uid=$new_conn->real_escape_string($uid);
		$did=$new_conn->real_escape_string($did);
		$leg=$new_conn->real_escape_string($leg);
		$f_name=$new_conn->real_escape_string($f_name);
		$l_name=$new_conn->real_escape_string($l_name);
		$cnumber=$new_conn->real_escape_string($cnumber);
		$nominee=$new_conn->real_escape_string($nominee);
		$email=$new_conn->real_escape_string($email);
		$birth_month=$new_conn->real_escape_string($birth_month);
		$birth_date=$new_conn->real_escape_string($birth_date);
		$birth_year=$new_conn->real_escape_string($birth_year);
		$dob=$birth_year."-".$birth_month."-".$birth_date;
		$father_name=$new_conn->real_escape_string($father_name);
		$address2=$new_conn->real_escape_string($address2);
		$address1=$new_conn->real_escape_string($address1);
		$state=$new_conn->real_escape_string($state);
		$city=$new_conn->real_escape_string($city);
		$zip=$new_conn->real_escape_string($zip);
		$domain1=$new_conn->real_escape_string($domain1);
		$extD1=$new_conn->real_escape_string($extD1);
		$domain1_final="www.".$domain1.$extD1;
		$draft_no=$new_conn->real_escape_string($draft_no);
		$draft_month=$new_conn->real_escape_string($draft_month);
		$draft_day=$new_conn->real_escape_string($draft_day);
		$draft_year=$new_conn->real_escape_string($draft_year);
		$draft_date=$draft_year."-".$draft_month."-".$draft_day;
		$amount=$new_conn->real_escape_string($amount);
		$bank_branch=$new_conn->real_escape_string($bank_branch);
		$bank_name=$new_conn->real_escape_string($bank_name);
		$pay_type=$new_conn->real_escape_string($pay_type);
		
		
		$prep="SELECT a.table_id FROM wb_ud a WHERE a.username='$username'";
		$res=$new_conn->query($prep);
		if($res->num_rows>0)
		{
			$new_conn->close();
			throw new Exception('Error : Username already taken...!!!');
		}
		
		$res=$new_conn->query("SELECT a.table_id FROM wb_ud a WHERE TRIM(a.username)='$uid' AND TRIM(a.did)='$did' AND a.type='user'");
		if($res->num_rows!=1)
		{
			$new_conn->close();
			throw new Exception('Error : Invalid Sponsor details...!!!');
		}
		else
		{
			$detail=$res->fetch_assoc();
			$sponsor_id=$detail['table_id'];
		}
		
		$passed="no";
		while($passed=="no")
		{
			$new_did=generateRandomString();
			$res=$new_conn->query("SELECT a.table_id FROM wb_ud a WHERE a.did='$new_did'");
			if($res->num_rows==0)
			{
				$passed="yes";
			}
		}
		
		
		
		$imm_sponsor_ref=$sponsor_id;
		calculate_linking_id($new_conn,$sponsor_id,$leg,$imm_sponsor_ref);
		$imm_sponsor=$imm_sponsor_ref;
		
		$validity=12;
		$temp_2=get_validity($start_date_new,$validity);
		$end_date_new = $temp_2->format('Y-m-d');
		if($end_date=="0000-00-00")
		{
			echo("Error : Cannot calculate end date...");
			exit();
		}
		
		$new_conn->query("START TRANSACTION");
		
		
		if(!($new_conn->query("INSERT INTO wb_ud(username,did,password,status,sponsor_id,first_name,last_name,dob,father_name,phone_no,email_id,c_local,p_local,city,state,pincode,nominee_name,start_date,end_date,created_by,created_ip,created_browser) VALUES ('$username','$new_did','$password','pending_linked','$sponsor_id','$f_name','$l_name','$dob','$father_name','$cnumber','$email','$address1','$address2','$city','$state','$zip','$nominee','$start_date_new','$end_date_new','$session_id','$ip','$browser')")))
		{
			$new_conn->close();
			throw new Exception('Error : Could not create new sale...Please contact your administrator...!!!');		
		}
		else
		{
			$generated_table_id=$new_conn->insert_id;
		}
		
		if(!($new_conn->query("INSERT INTO wb_msg(for_id,by_id,subject,message,created_ip,created_browser) VALUES('admin','$generated_table_id','Domain Registration','$domain1_final','$ip','$browser')")))
		{
			$new_conn->rollback();
			$new_conn->close();
			throw new Exception('Error : Could not send domain request...Please contact your administrator...!!!');		
		}
		
		if(!($new_conn->query("INSERT INTO wd_pss(user_id,draft_no,draft_date,draft_bank,draft_branch,created_by,created_ip,created_browser) VALUES('$generated_table_id','$draft_no','$draft_date','$bank_name','$bank_branch','$session_id','$ip','$browser')")))
		{
			$new_conn->rollback();
			$new_conn->close();
			throw new Exception('Error : Could not save draft details...Please contact your administrator...!!!');		
		}
		
		if(!($new_conn->query("INSERT INTO wb_bvd(user_id) VALUES('$generated_table_id')")))
		{
			$new_conn->rollback();
			$new_conn->close();
			throw new Exception('Error : Could not save bv details...Please contact your administrator...!!!');		
		}
		
		
		if($new_conn->query("INSERT INTO wb_in(id,epin) VALUES('$generated_table_id','$epin_url')"))
		{
		}
		else
		{
			$new_conn->rollback();
			$new_conn->close();
			throw new Exception('Error : Unable to create invoice...5...Please contact customer care');
		}
		
		if($leg=="L")
		{
			$prepared="UPDATE wb_ud SET fso='$generated_table_id' WHERE table_id='$imm_sponsor' AND fso=''";
			$new_conn->query($prepared);
		}
		else if($leg=="R")
		{
			$prepared="UPDATE wb_ud SET sso='$generated_table_id' WHERE table_id='$imm_sponsor' AND sso=''";
			$new_conn->query($prepared);
		}
		if($new_conn->affected_rows!=1)
		{
			$new_conn->rollback();
			$new_conn->close();
			throw new Exception('Error : Could not link new sale in the chart...Please contact your administrator...!!!');	
		}
		
		$new_conn->query("UPDATE wb_epins SET status='used',used_by='$generated_table_id' WHERE epin='$epin_url'");
		if($new_conn->affected_rows!=1)
		{
			$new_conn->rollback();
			$new_conn->close();
			throw new Exception('Error : Could not use linking code...Please contact your administrator...!!!');	
		}
		
		$new_conn->commit();
		$new_conn->close();
		$my_msg="Sale created successfully";
		$temp_filename="index.php";
		header("Location: /panel/user/redirect_back.php?q=".$temp_filename."&msg=".$my_msg);
	}
	}
	catch (Exception $e)
	{
		$my_msg=$e->getMessage();
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
<script language="javascript1.2" src="js/ajax.js" type="text/javascript"></script>
<LINK REL="stylesheet" HREF="../css/dhtmlgoodies_calendar.css" MEDIA="screen"></LINK>
<SCRIPT TYPE="text/javascript" SRC="../css/dhtmlgoodies_calendar.js"></SCRIPT>
<script type="text/javascript">
function apply()
{
  document.submitnewsale.submitform.disabled=true;
  if(document.submitnewsale.iagree.checked==true)
  {
    document.submitnewsale.submitform.disabled=false;
  }
  if(document.submitnewsale.iagree.checked==false)
  {
    document.submitnewsale.submitform.enabled=false;
  }
}
function checkForm(thisform)
 {
	 
   if (thisform.u_name1)
      {
	  
		var my_car=thisform.u_name1.value;
		var fn = my_car.replace(/^\s+|&|%|@|.|\s+$/, '');
	    var exprText=/^[a-zA-Z. ]+$/;
	if(thisform.new_username.value==null || thisform.new_username.value=="")
	  { 
		alert("Login Name must be Filled Out!!");
		thisform.new_username.focus();
		return false;
	  }
		else if(fn=='')
		{
		alert("Empty Login Name.Please Enter Login Name !!");
		thisform.u_name1.value="";
		thisform.u_name1.focus();
		return false;
		}
	   }
	if(thisform.formpassword.value==null || thisform.formpassword.value=="")
	  { 
		alert("Please Enter Password !")
		thisform.formpassword.focus();
		return false;
	  }
	  
	if(thisform.repassword.value==null || thisform.repassword.value=="")
	  { 
		alert("Re Enter Password !")
		thisform.repassword.focus();
		return false;
	  }
	  
	 if(thisform.formpassword.value != thisform.repassword.value)
	   {
		 alert(" The Entered passwords do not match.");
		thisform.formpassword.value="";
		thisform.repassword.value="";
		thisform.formpassword.focus();
	    return false;
	   }   
	
	if (thisform.uid)
	{
		var my_car2=thisform.uid.value;
		var fn2 = my_car2.replace(/^\s+|\s+$/, '');
	 
	if(thisform.uid.value==null || thisform.uid.value=="")
	  { 
		alert("Sponsor's U.I.D must be Filled Out !!");
		thisform.uid.focus();
		return false;
	  }
		else if(fn2=='')
		{
		alert("Empty Sponsor's U.I.D.Please Enter Sponsor's U.I.D !!");
		thisform.uid.value="";
		thisform.uid.focus();
		return false;
		}
	 }
	 
	 
	if (thisform.did)
	{
	var my_car3=thisform.did.value;
	var fn3 = my_car3.replace(/^\s+|\s+$/, '');
	 
	if(thisform.did.value==null || thisform.did.value=="")
	  { 
		alert("Sponsor's D.I.D must be Filled Out !!");
		thisform.did.focus();
		return false;
	  }
		else if(fn3=='')
		{
		alert("Empty Sponsor's D.I.D.Please Enter Sponsor's D.I.D !!");
		thisform.did.value="";
		thisform.did.focus();
		return false;
		}
	 }
	 
	if(thisform.linkCode.value==null || thisform.linkCode.value=="")
	  { 
		alert("Please Enter linkcode !")
		thisform.linkCode.focus();
		return false;
	  }
	   
	 
   if (thisform.f_name)
      {
	  
		var my_car4=thisform.f_name.value;
		var fn4 = my_car4.replace(/^\s+|\s+$/, '');
	    var exprText=/^[a-zA-Z. ]+$/;
		 
	if(thisform.f_name.value==null || thisform.f_name.value=="")
	  { 
		alert("First Name must be Filled out!");
		thisform.f_name.focus();
		return false;
	  }
		else if(fn4=='')
		{
		alert("Empty First Name.Please Enter First Name !!");
		thisform.f_name.value="";
		thisform.f_name.focus();
		return false;
		}
	   }
	   
	   
   if (thisform.l_name)
      {
	  
		var my_car5=thisform.l_name.value;
		var fn5 = my_car5.replace(/^\s+|\s+$/, '');
	    var exprText1=/^[a-zA-Z. ]+$/;
		 
	if(thisform.l_name.value==null || thisform.l_name.value=="")
	  { 
		alert("Last Name must be Filled out!");
		thisform.l_name.focus();
		return false;
	  }
		else if(fn5=='')
		{
		alert("Empty Last Name.please Enter Last Name !!");
		thisform.l_name.value="";
		thisform.l_name.focus();
		return false;
		}
	   }
	   
	   
	 if(thisform.cnumber)
	    {
		
		var my_car6=thisform.cnumber.value;
		var fn6 = my_car6.replace(/^\s+|\s+$/, '');
		  var exprPhone=/^[0-9,-]+$/;
		   if(thisform.cnumber.value==null || thisform.cnumber.value=="")
	     { 
		  alert("Contact No must be filled Out!");
		  thisform.cnumber.focus();
		  return false;
	  }
	  else if(exprPhone.test(thisform.cnumber.value)==false)
	  {
	     alert("Please Fill Correct Contact No!");
		thisform.cnumber.focus();
		thisform.cnumber.value="";
		return false;
	   }
		else if(fn6=='')
		{
		alert("Empty Contact No.Please Enter Contact No !!");
		thisform.cnumber.value="";
		thisform.cnumber.focus();
		return false;
		}
	   
	 }
	   
	   
   if (thisform.email)
      {
	    var exprEmail=/^\b[a-z|A-Z0-9._%-]+@[a-z|A-Z0-9.-]+\.[a-z|A-Z]{2,4}\b/;
	  if(thisform.email.value==null || thisform.email.value=="")
	  { 
		alert("Email Id must be filled Out!");
		thisform.email.focus();
		return false;
	  }else if(exprEmail.test(thisform.email.value)==false)
	  {
	     alert("Please Fill Correct Email Id !");
		thisform.email.focus();
		thisform.email.value="";
		return false;
	   }
	 }
	 
	 
	 
	  if(thisform.birth_month.value=="" || thisform.birth_month.value==null)
	  { 
		alert("Please Select Birth Month !");
		thisform.birth_month.focus();
		return false;
	  }
	 
	  if(thisform.birth_date.value==null || thisform.birth_date.value=="")
	  { 
		alert("Please Select Birth Day !");
		thisform.birth_date.focus();
		return false;
	  }
	 

	  if(thisform.birth_year.value==null || thisform.birth_year.value=="")
	  { 
		  alert("Birth Year must be filled Out !");
		  thisform.birth_year.focus();
		  return false;
	  }
	 
	 
	 
	 
	  if(thisform.address2.value==null || thisform.address2.value=="")
	  { 
		alert("Please Enter Permanent Address !");
		thisform.address2.focus();
		return false;
	  }
	  
	  if(thisform.address1.value==null || thisform.address1.value=="")
	  { 
		alert("Please Enter Postal Address !");
		thisform.address1.focus();
		return false;
	  }
	  
	  if(thisform.country.value==null || thisform.country.value=="")
	  { 
		alert("Please Select Country !");
		thisform.country.focus();
		return false;
	  }
	   
		 
	if(thisform.state.value==null || thisform.state.value=="")
	  { 
		alert("Please Select State!");
		thisform.state.focus();
		return false;
	  }
	  if(thisform.city.value==null || thisform.city.value=="")
	  { 
		alert("Please Select City!");
		thisform.city.focus();
		return false;
	  }
	  
	 if(thisform.country.value == '101'){
	 if(thisform.zip)
	    {
		
		var my_car8=thisform.zip.value;
		var fn8 = my_car8.replace(/^\s+|\s+$/, '');
		  var exprPhone=/^[0-9,-]+$/;
		   if(thisform.zip.value==null || thisform.zip.value=="")
	     { 
		  alert("PIN no must be filled Out !");
		  thisform.zip.focus();
		  return false;
	  }
	  else if(exprPhone.test(thisform.zip.value)==false)
	  {
	     alert("Please Fill Correct PIN No !");
		thisform.zip.focus();
		thisform.zip.value="";
		return false;
	   }
		else if(fn8=='')
		{
		alert("Empty PIN No.Please Enter PIN No !!");
		thisform.zip.value="";
		thisform.zip.focus();
		return false;
		}
	   
	 }
	 }
	 if(thisform.draft_no)
	    {
		
		var my_car9=thisform.draft_no.value;
		var fn9 = my_car9.replace(/^\s+|\s+$/, '');
		  var exprPhone=/^[0-9,-]+$/;
		   if(thisform.draft_no.value==null || thisform.draft_no.value=="")
	     { 
		  alert("Draft NO must be filled Out !");

		  thisform.draft_no.focus();
		  return false;
	  }
	  else if(exprPhone.test(thisform.draft_no.value)==false)
	  {
	     alert("Please Fill Correct Draft NO !");
		thisform.draft_no.focus();
		thisform.draft_no.value="";
		return false;
	   }
		else if(fn9=='')
		{
		alert("Empty Draft NO.Please Enter Draft NO !!");
		thisform.draft_no.value="";
		thisform.draft_no.focus();
		return false;
		}
	   
	 }
	 if(thisform.draft_month.value=="" || thisform.draft_month.value==null)
	  { 
		alert("Please Select Draft Month !");
		thisform.draft_month.focus();
		return false;
	  }
	 
	  if(thisform.draft_day.value==null || thisform.draft_day.value=="")
	  { 
		alert("Please Select Draft Day !");
		thisform.draft_day.focus();
		return false;
	  }
	 

	 if(thisform.draft_year.value==null || thisform.draft_year.value=="")
	  { 
		  alert("Draft Year must be filled Out !");
		  thisform.draft_year.focus();
		  return false;
	  }
	  
   if (thisform.bank_name)
      {
	  
		var my_car11=thisform.bank_name.value;
		var fn11 = my_car11.replace(/^\s+|\s+$/, '');
	    var exprText1=/^[a-zA-Z. ]+$/;
		 
	if(thisform.bank_name.value==null || thisform.bank_name.value=="")
	  { 
		alert("Bank Name must be Filled out!");
		thisform.bank_name.focus();
		return false;
	  }
		else if(fn11=='')
		{
		alert("Empty Bank Name.Please Enter Bank Name !!");
		thisform.bank_name.value="";
		thisform.bank_name.focus();
		return false;
		}
	   }

   if (thisform.bank_branch)
      {
	  
		var my_car12=thisform.bank_branch.value;
		var fn12 = my_car12.replace(/^\s+|\s+$/, '');
	    var exprText1=/^[a-zA-Z. ]+$/;
		 
	if(thisform.bank_branch.value==null || thisform.bank_branch.value=="")
	  { 
		alert("Bank Branch must be Filled out!");
		thisform.bank_branch.focus();
		return false;
	  }
		else if(fn12=='')
		{
		alert("Empty Bank Branch.Please Enter Bank Branch !!");
		thisform.bank_branch.value="";
		thisform.bank_branch.focus();
		return false;
		}
	   }

	  
	   
	 
	return true; 
	}
	function checkAddr2()
	{		
		var iChars = "!@#$%^&*()+=[]\\\';{}|\":<>?";
		
		  for (var i = 0; i < document.form1.address2.value.length; i++) {
			if (iChars.indexOf(document.form1.address2.value.charAt(i)) != -1) {
			alert ("Your Address has special characters. \nThese are not allowed.\n Please remove them and try again.");
			return false;
			}
		  }
	}
	function handle()
	{
		var passwd = document.getElementById('formpassword').value;
		var repasswd = document.getElementById('repassword').value;
		var errors = "";
		
		if(passwd != repasswd)
		{
			errors += "Password and Re-Password should match.\n";
		}
		for(var i = 0;i<handle.arguments.length;i++)
		{
	
			var elem = document.getElementById(handle.arguments[i]).value;
			if((elem == "") || (elem == null) || isblank(elem) )
			{
				
				errors += document.getElementById(handle.arguments[i]).name + " should not be empty.\n";
			}
	
		} 
		if(errors == "")
		{
			return true;
		}
		else
		{	
			alert("The Following errors where occured : \n" + errors);
			return false
		}
		
		
	}
	function checkAddr1()
	{		
			var iChars = "!@#$%^&*()+=[]\\\';{}|\":<>?";
			
			  for (var i = 0; i < document.form1.address1.value.length; i++) {
				if (iChars.indexOf(document.form1.address1.value.charAt(i)) != -1) {
				alert ("Your Address has special characters. \nThese are not allowed.\n Please remove them and try again.");
				return false;
				}
			  }
	}
	function checkUser(elementid)
    {	
		forLoading('ajaxLoading','targetDiv');
		var obj = document.getElementById('targetDiv');
		obj.innerHTML = '';
		var url = 'check_user.php?uname='+document.getElementById(elementid).value;
		getData(url,'targetDiv');
		return true;	
    }
	function checkEmail(elementid)
	{	
		forLoading('ajaxLoading1','targetDiv1');
		var obj = document.getElementById('targetDiv1');
		obj.innerHTML = '';
		var url = 'check_email.php?email='+document.getElementById(elementid).value;
		getData(url,'targetDiv1');
		return true;	
	}
	function checkUid(elementid)
    {	
		forLoading('ajaxLoading2','targetDiv2');
		var obj = document.getElementById('targetDiv2');
		obj.innerHTML = '';
		var url = 'check_uid.php?uid='+document.getElementById(elementid).value;
		getData(url,'targetDiv2');
		return true;	
    }
	function checkDid(elementid)
	{	
		forLoading('ajaxLoading3','targetDiv3');
		var obj = document.getElementById('targetDiv3');
		obj.innerHTML = '';
		var url = 'check_did.php?did='+document.getElementById(elementid).value;
		getData(url,'targetDiv3');
		return true;	
	}
	function checkCode(elementid)
	{	
		forLoading('ajaxLoading4','targetDiv4');
		var obj = document.getElementById('targetDiv4');
		obj.innerHTML = '';
		var url = 'check_code.php?lcode='+document.getElementById(elementid).value;
		getData(url,'targetDiv4');
		return true;	
	}
</script>
<style>
.shdo {box-shadow: 5px 5px 5px #888888;
	background:#f7f7f7;
	border:#006eb1 2px solid;
	}
</style>
<div id="top-main-container" style="background:url(images/header.jpg)">
  <div class="inner">
    <div class="user-img">
      <div class="img-inner">
      </div>
    </div>
    <h2>Submit a New Sale </h2> </div>
</div>
<div class="container">
      <form action="" name="submitnewsale" id="submitnewsale" method="post" onSubmit="return checkForm(this);">
   <input type="hidden" name="lnkmng" value="51507659">
    <div class="span-24">
      <fieldset>
      <legend>User Account</legend>
      <div class="span-7">
        <label>Username <span style="color:#FF0000">*</span></label>
        <input name="new_username"  title="Maximum 50 Characters Allowed" value="<?php echo($username);?>" size="20" maxlength="50" type="text" id="new_username" />
		<img class="ajaxLoader" name="ajaxLoading" id="ajaxLoading" src="../images/loading.gif" style="visibility:hidden;"/>
		<span style="color:#FF0000" id="targetDiv"></span>
      </div>
      <div class="span-7 last">
        <label>Password <span style="color:#FF0000">*</span></label>
        <input name="formpassword" id="formpassword" title="Minimum 6  &amp; Maximum 20 Characters Allowed" size="20" maxlength="20" type="password" value="" />
      </div>
      <div class="span-7 last">
        <label>Confirm Password <span style="color:#FF0000">*</span></label>
        <input name="repassword" id="repassword" title="Minimum 6 &amp; Maximum 20 Characters Allowed" size="20" maxlength="20" type="password" value=""/>
      </div>
      </fieldset>
      <fieldset>
      <legend>Sponsorship Information </legend>
      <div class="span-7">
        <label>Sponsor's U.I.D. <span style="color:#FF0000">*</span></label>
        <input name="uid" onBlur="checkUid('uid')"  title="Maximum 50 Characters Allowed" value="" size="20" maxlength="50" type="text" id="uid" />
        <img class="ajaxLoader" name="ajaxLoading2" id="ajaxLoading2" src="../images/loading.gif" style="visibility:hidden;"/>
		<span style="color:#FF0000" id="targetDiv2"></span>
      </div>
      <div class="span-7 last">
        <label>Sponsor's D.I.D. <span style="color:#FF0000">*</span></label>
        <input name="did" id="did" onBlur="checkDid('did')" title="Minimum 6  &amp; Maximum 20 Characters Allowed" value="" type="text" size="20" maxlength="20"  />
        <img class="ajaxLoader" name="ajaxLoading3" id="ajaxLoading3" src="../images/loading.gif" style="visibility:hidden;"/>
		<span style="color:#FF0000" id="targetDiv3"></span>
      </div>
      <div class="span-7 last">
        <label>Select the Sale Organization where you wish to be placed below your Sponsor.*
        
        FSO: First Sale Organization
        
        SSO: Second Sale Organization </label>
        <input name="leg" type="radio" value="L" 
		<?php
		if($leg=="L") 
		echo("checked");
		?>
        />
        <span class="b2">FSO</span>&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="leg" value="R" type="radio"
		<?php
		if($leg=="R") 
		echo("checked");
		?>
        />
        <span class="b2">SSO</span> </div>
        <div class="span-7">
        <label>Linking Code <span style="color:#FF0000">*</span></label>
        <input name="linkCode"  value="<?php echo($epin_url);?>" size="20" maxlength="50" type="text" id="linkCode" disabled="disabled" />
      </div>
      </fieldset>
      <fieldset>
      <legend>Personal Information</legend>
      <div class="span-7">
        <label>First Name <span style="color:#FF0000">*</span></label>
        <input name="f_name" id="f_name" type="text"  value="<?php echo($f_name);?>" />
      </div>
      <div class="span-7">
        <label>Last Name <span style="color:#FF0000">*</span></label>
        <input name="l_name"  id="l_name"  value="<?php echo($l_name);?>" type="text" />
      </div>
      <div class="span-7">
        <label>Contact No. <span style="color:#FF0000">*</span></label>
        <input name="cnumber" id="cnumber"   value="<?php echo($cnumber);?>" type="text" />
      </div>
      <div class="span-7">
        <label>Nominee (if any)</label>
        <input name="nominee"   value="<?php echo($nominee);?>" type="text" />
      </div>
      <div class="span-7">
        <label>Email <span style="color:#FF0000">*</span></label>
        <input name="email" id="email" value="<?php echo($email);?>" type="text" onBlur="checkEmail('email')" title="You will recieve a confirmation email on this email address after sumbssion of this form."/>
		<img class="ajaxLoader" name="ajaxLoading1" id="ajaxLoading1" src="../images/loading.gif" style="visibility:hidden;"/>
		<span class="arialRedbold" id="targetDiv1"></span>
      </div>
      <div style="clear:both">
      <div class="span-7">
        <label>Date Of Birth <span style="color:#FF0000">*</span></label>
        <select name="birth_month" size="1">
          <option value="">Month </option>
          <option value="1"
          <?php
		  if($birth_month=="1")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jan </option>
          <option value="2"
          <?php
		  if($birth_month=="2")
		  {
			  echo(" selected");
		  }
		  ?>
          >Feb </option>
          <option value="3"
          <?php
		  if($birth_month=="3")
		  {
			  echo(" selected");
		  }
		  ?>
          >Mar </option>
          <option value="4"
          <?php
		  if($birth_month=="4")
		  {
			  echo(" selected");
		  }
		  ?>
          >Apr </option>
          <option value="5"
          <?php
		  if($birth_month=="5")
		  {
			  echo(" selected");
		  }
		  ?>
          >May </option>
          <option value="6"
          <?php
		  if($birth_month=="6")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jun </option>
          <option value="7"
          <?php
		  if($birth_month=="7")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jul </option>
          <option value="8"
          <?php
		  if($birth_month=="8")
		  {
			  echo(" selected");
		  }
		  ?>
          >Aug </option>
          <option value="9"
          <?php
		  if($birth_month=="9")
		  {
			  echo(" selected");
		  }
		  ?>
          >Sep </option>
          <option value="10"
          <?php
		  if($birth_month=="10")
		  {
			  echo(" selected");
		  }
		  ?>
          >Oct </option>
          <option value="11"
          <?php
		  if($birth_month=="11")
		  {
			  echo(" selected");
		  }
		  ?>
          >Nov </option>
          <option value="12"
          <?php
		  if($birth_month=="12")
		  {
			  echo(" selected");
		  }
		  ?>
          >Dec </option>
        </select>
        <select name="birth_date" size="1" id="day">
          <option value="">Day </option>
          <?php
		  for($i=1;$i<=31;$i++)
		  {
			  echo("<option");
			  if($birth_date==$i)
			  {
				  echo(" selected");
			  }
			  echo(">".$i."</option>");
		  }
		  ?>
        </select>
        <select name="birth_year" id="birth_year">
         <option value="">Year</option>
          <?php
		  for($i=1955;$i<=1997;$i++)
		  {
			  echo("<option");
			  if($birth_year==$i)
			  {
				  echo(" selected");
			  }
			  echo(">".$i."</option>");
		  }
		  ?>
                </select>
        </div>
      <div class="span-7">
        <label>Father / Guardian's</label>
        <input name="father_Name" type="text" value="<?php echo($father_name);?>" />
      </div>
      </div>
      </fieldset>
      <fieldset>
      <div class="span-7">
        <label>Permanent Address <span style="color:#FF0000">*</span></label>
<?php
$address1=str_replace("<br>","",$address1);
$address1=str_replace("<br />","",$address1);
$address1=str_replace("<br/>","",$address1);
$address2=str_replace("<br>","",$address2);
$address2=str_replace("<br />","",$address2);
$address2=str_replace("<br/>","",$address2);
?>        
        <textarea name="address2" cols="30" title="Maximum 60 Characters Allowed" onBlur="checkAddr2('address2')" ><?php echo($address2);?></textarea>
      </div>
      <div class="span-7 last">
        <label>Postal Address <span style="color:#FF0000">*</span></label>
        <textarea name="address1" id="address1" cols="30" title="Maximum 60 Characters Allowed"  onblur="checkAddr1('address1')" ><?php echo($address1);?></textarea>
      </div>
      <div class="span-7 last">
        <label>State <span style="color:#FF0000">*</span></label>
		<div id="txtHintstate">
		<select name="state">
        <option value="">--Select State--</option>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_st");
	while($detail=$res->fetch_assoc())
	{
		echo("<option");
		if($state==$detail['name'])
		{
			echo(" selected");
		}
		echo(">".$detail['name']."</option>");
	}
	$new_conn->close();	
}
?>
</select>
		</div>       
      </div>
	  <div class="span-7 last">
        <label>City <span style="color:#FF0000">*</span></label>
		<div id="txtHintcity">
        <input type="text" name="city" id="city" value="<?php echo($city);?>" />
		</div>       
      </div>
      <div class="span-7 last">
        <label>Postal Code <span style="color:#FF0000">*</span></label>
       
        <input name="zip"   value="<?php echo($zip);?>" maxlength="6" type="text" />
      </div>
      </fieldset>
      <fieldset>
      <legend>Domain Information</legend>
      <div class="domain" style="width:100%;">
        <label>Domain Name 1</label>
        <span>www.</span>
        <input name="domain1" type="text" class="form4" id="domain1"  title="Maximum 50 Characters Allowed" value="<?php echo($domain1);?>" style="width:350px;" size="20" maxlength="50" />
        <select name="extD1" class="arial12" id="extD1" style="height:26px;">
          <option
          <?php
		  if($extD1==".com")
		  {
			  echo(" selected");
		  }
		  ?>
          >.com</option>
          <option
          <?php
		  if($extD1==".org")
		  {
			  echo(" selected");
		  }
		  ?>
          >.org</option>
          <option
          <?php
		  if($extD1==".info")
		  {
			  echo(" selected");
		  }
		  ?>
          >.info</option>
          <option
          <?php
		  if($extD1==".net")
		  {
			  echo(" selected");
		  }
		  ?>
          >.net</option>
          <option
          <?php
		  if($extD1==".co.in")
		  {
			  echo(" selected");
		  }
		  ?>
          >.co.in</option>
          <option
          <?php
		  if($extD1==".in")
		  {
			  echo(" selected");
		  }
		  ?>
          >.in</option>
        </select>
      </div>
      </fieldset>
      <fieldset>
      <legend>Package Details</legend>
      <table width="650" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="210" align="left" valign="top"><table width="210" border="0" cellspacing="10" cellpadding="0" id="fornepal" class="">
              <tr>
                <td height="40" align="left" class="arial14"><strong>For Nepal</strong></td>
              </tr>
              <tr>
                <td height="1" align="left" bgcolor="#D9DFE8"></td>
              </tr>
                            <tr>
                <td align="left" class="arial11"><strong>AS Web Package.<br />
                  <span class="searchlink">
                  NRs.                  10400                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong> Handling Charge<br />
                  <span class="searchlink">
                  NRs.                  100                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>13% VAT<br />
                  <span class="searchlink">
                  NRs.                  1352                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Total Charges<br />
                  <span class="searchlink">
                  NRs.                  11852                  </span></strong></td>
              </tr>
            </table></td>
          <td width="210" align="center" valign="top"><table width="210" border="0" cellspacing="10" cellpadding="0" id="forindia" class="">
              <tr>
                <td height="40" align="left" class="arial14"><strong>For India</strong></td>
              </tr>
              <tr>
                <td height="1" align="left" bgcolor="#D9DFE8"></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>AS Web Package.<br />
                  <span class="searchlink">
                  INR.                  5000                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>VAT (@5% on 7000 INR)<br />
                  <span class="searchlink">
                  INR.                  350                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Annual Maintenance Charge<br />
                  <span class="searchlink">
                  INR.                  1200                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Service Tax (@12.36% on 1200 INR)<br />
                  <span class="searchlink">
                  INR.                  149                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Total Charges<br />
                  <span class="searchlink">
                  INR.                  6999                  </span></strong></td>
              </tr>
            </table></td>
          <td width="210" align="right" valign="top"><table width="210" border="0" cellspacing="10" cellpadding="0" id="forother" class="">
              <tr>
                <td height="40" align="left" class="arial14"><strong>For countries other than India or Nepal</strong></td>
              </tr>
              <tr>
                <td height="1" align="left" bgcolor="#D9DFE8"></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>AS Web Package.<br />
                  <span class="searchlink">
                  $                  174                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Annual Maintenance Charge<br />
                  <span class="searchlink">
                  $                  33                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Handling Charges<br />
                  <span class="searchlink">
                  $                  17                  </span></strong></td>
              </tr>
              <tr>
                <td align="left" class="arial11"><strong>Total Charges<br />
                  <span class="searchlink">
                  $                  224                  </span></strong></td>
              </tr>
            </table></td>
        </tr>
      </table>
      </fieldset>
      <fieldset>
      <legend>Payment Details</legend>
      <div class="span-7">
        <label>Demand Draft No. <span style="color:#FF0000">*</span></label>
        <input name="draft_no" type="text" id="draft_no"   value="<?php echo($draft_no);?>" />
      </div>
      <div class="span-7">
        <label>Issuing Date <span style="color:#FF0000">*</span></label>
   <select name="draft_month" size="1" id="draft_month" >
          <option value="">Month </option>
          <option value="1"
          <?php
		  if($draft_month=="1")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jan </option>
          <option value="2"
          <?php
		  if($draft_month=="2")
		  {
			  echo(" selected");
		  }
		  ?>
          >Feb </option>
          <option value="3"
          <?php
		  if($draft_month=="3")
		  {
			  echo(" selected");
		  }
		  ?>
          >Mar </option>
          <option value="4"
          <?php
		  if($draft_month=="4")
		  {
			  echo(" selected");
		  }
		  ?>
          >Apr </option>
          <option value="5"
          <?php
		  if($draft_month=="5")
		  {
			  echo(" selected");
		  }
		  ?>
          >May </option>
          <option value="6"
          <?php
		  if($draft_month=="6")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jun </option>
          <option value="7"
          <?php
		  if($draft_month=="7")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jul </option>
          <option value="8"
          <?php
		  if($draft_month=="8")
		  {
			  echo(" selected");
		  }
		  ?>
          >Aug </option>
          <option value="9"
          <?php
		  if($draft_month=="9")
		  {
			  echo(" selected");
		  }
		  ?>
          >Sep </option>
          <option value="10"
          <?php
		  if($draft_month=="10")
		  {
			  echo(" selected");
		  }
		  ?>
          >Oct </option>
          <option value="11"
          <?php
		  if($draft_month=="11")
		  {
			  echo(" selected");
		  }
		  ?>
          >Nov </option>
          <option value="12"
          <?php
		  if($draft_month=="12")
		  {
			  echo(" selected");
		  }
		  ?>
          >Dec </option>
        </select>
        <select name="draft_day" size="1" id="draft_day" >
          <option value="">Day </option>
          <?php
		  for($i=1;$i<=31;$i++)
		  {
			  echo("<option");
			  if($draft_day==$i)
			  {
				  echo(" selected");
			  }
			  echo(">".$i."</option>");
		  }
		  ?>
        </select>
<?php
$next_year=date("Y");
$next_year++;
?>
        <select name="draft_year" id="draft_year">
        <option value="">Year</option>
          <?php
		  for($i=2013;$i<=$next_year;$i++)
		  {
			  echo("<option");
			  if($draft_year==$i)
			  {
				  echo(" selected");
			  }
			  echo(">".$i."</option>");
		  }
		  ?>
                </select>
      </div>
      <div class="span-7">
        <label>Amount <span style="color:#FF0000">*</span></label>
        <select name="amount" id="amount">
          <option>Select Amount</option>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res=$new_conn->query("SELECT * FROM wb_ps");
	while($detail=$res->fetch_assoc())
	{
		echo("<option value=\"".$detail['product_id']."\"");
		if($amount==$detail['product_id'])
		{
			echo(" selected");
		}
		echo(">".$detail['currency']." ".$detail['price']."</option>");
	}
	$new_conn->close();	
}
?>
</select>
        </select>
      </div>
      
      <div style="clear:both">
      <div class="span-7 last">
        <label>Issuing Bank Branch <span style="color:#FF0000">*</span></label>
        <input name="bank_branch" type="text" id="bank_branch"  title="Maximum 50 Character Allowed"  value="<?php echo($bank_branch);?>"/>
      </div>
	  <div class="span-7 last" style="margin-left:10px;">
      <label>Issuing Bank <span style="color:#FF0000">*</span></label>
      <input name="bank_name" type="text" id="bank_name"  title="Maximum 50 Character Allowed"  value="<?php echo($bank_name);?>" />
	  </div>
      </div>
      </fieldset>
	  <fieldset>
	   <div class="span-12">
		<label><input name="iagree" type="checkbox" id="iagree" value="iagree" onClick="apply()" /> I read and accept the AS's terms of use and privacy policy</label>
		<label>
		<table width="100%" border="0" cellpadding="0" cellspacing="20">
              <tr>
                <td width="100%"  align="center">
				<style>
				div.terms {
				   width:850px;
				   height:200px;
				   border:1px solid #ccc;
				  
				   padding:6px;
				   overflow:auto;
				   text-align:left;
				}
				div.terms p,
				div.terms li {font:normal 11px/15px arial;color:#333;}
				div.terms h3 {font:bold 14px/19px arial;color:#000;}
				div.terms h4 {font:bold 12px/17px arial;color:#000;}
				div.terms strong {color:#000;}
				</style>
				<div class="terms">
				  <h3>TERMS AND CONDITIONS</h3>
                  <p>
This Agreement is entered between <strong>ASPIRE WORLD IMAGINATIONS PVT LTD</strong> a company duly incorporated under the provisions of the companies Act 1956 and having its office at New Delhi, India, hereinafter to be referred to as the company on the one part and any user Associate who/which buys the product and package of the company, as specified herein below, hereinafter referred to as the Associate" on the other part. The Associate represents and warrants that the product and packages of the company and the plans their limitations and conditions have been read carefully and understood clearly by him/her. And, the Associate is not relying upon any representation or promise that is not contained in this agreement or other official company material. An Associate shall be a person who submits a properly filled and duly signed in application on the requisite format and such application is duly accepted by the company. An Associate shall act and be as an independent person and shall have no relationship, of any nature whatsoever, with the company and the said Associate and shall not have any authority to bind the company for any obligations whatsoever. An Associate is not an agent employee or any other legal representative of the company or its service provider. This Agreement shall not create any relationship of an Employer and an Employee between the company and the Associate herein. The terms and conditions of this Agreement shall come into force once the Agreement is signed by the Associate and duly accepted by the Registering Associate and thereafter accepted by the company and Agreement shall come to an automatic end on its expiry as detailed hereinafter. It is again made clear that the Associate has read and understood in detail the terms and conditions of this Agreement .</p><br />
<p>
NOW, I HEREFORE, THIS AGREEMENT WITNESS THE As UNDER:<br />
1. Grant of Web space Package to the Associate. This agreement grants the Associate a personal license to use the limited web space, allotted to the User, in accordance with the terms and conditions of this agreement. In addition to the right to use the above mentioned limited web space, the Associate will also be entitled under this agreement to receive A Aspire Web & Blogging Package from the company online after receipt of consideration, as is to be paid by an Associate, within the meaning of this agreement. The facilities referred to in this cause are hereinafter referred to collectively as products services. <br />
2. Term Renewal. The term of this agreement is one year which shall commence from the day date of realization of consideration amount deposited by the Associate in the Company. The period of this Agreement may be extended further for such term and on such terms and conditions mutually agreed upon by the Parties and on payment of such amount fee as may be notified by the company at the relevant time for the purchase renewal of the package services availed by the Associate from the Company. <br />
3. Termination. It is mutually agreed between the parties that: - <br />
a) The Associate will not use the product web package software of the company, including the web space for any purpose, which is against the laws of the land or against the public policy or contrary to any of the terms of this agreement. Any reproduction or redistribution or resale or unlawful use of the product services of the company will result, in termination of this agreement by the company and the Associate shall be liable to be prosecuted under the civil criminal law. The company shall have the right to initiate such other proceedings including the recovery of the damages against the Company and in case of any legal action by the company against the Associate; the latter shall be responsible and liable for all the costs and consequences. <br />
(b) Any copying or reproduction of the product service package business plan and web package of the company, in any way or manner by the Associate, shall be deemed to be as violation of this agreement and will attract its immediate termination by the company besides the prosecution of the Associate and legal actions as mentioned in clause (a) above. <br />
(c) Any misrepresentation of the aims and objectives of the company, which include but are not limited to online computer education, trading internet. and designing or helping in design of web pages, that may or may not be harmful to the interest of the company, will invite immediate termination of this agreement by the company, and consequential suspension/cancellation of any rights and obligations that arise out of this agreement. <br />
(d) This agreement will stand automatically terminated the day an Associate sets up his/her/its own firm/business/company with the similar aims and objectives or by and large similar to those of the company. <br />
(e) The company reserves the right to terminate the agreement immediately without any written notice if any Associate is found to indulge in anti-company activities in any manner, whatsoever or found to disturb the private or public business meeting or free training seminar organized either by the Associates or by the company.</p><br />
<strong>CONSIDERATION </strong><br />
<p>(a)	The presently the consideration for the purchase of Aspire Web & Blogging Package is Rs 6666.00- Six Thousand Six Hundred Sixty Six only to be paid in advance by way of Demand Draft Pay order favoring ASPIRE WORLD IMAGINATIONS PVT LTD. payable at Delhi India or other payments mode for specific countries as given on our website or online. <br />
(b)	The total cost includes the annual maintenance charge, rest amount is the handling charges is the valid consideration for the products and services of the company within the ambit of this agreement for the period of one year and rest is the tax payable to the government. If an Associate is willing to buy the product in the next year also the consideration as applicable at  the relevant time has to be paid on such terms and conditions as specified in this agreement. <br />
(c)	 It is mutually agreed between the parties that the Associate can evaluate the purchased product online for 7 days and the consideration should only be sent after complete satisfaction. If satisfied, then the consideration should reach at company office within 7 days from the date of registration of this Agreement. In case the Associate fails to make payment within the aforesaid 7 days period to the company, this agreement will stand terminated and shall be null and void having no binding force The Associate would receive complete product from the company during this period of 7 days. If Associate remits and make the payment of the consideration prior to 7 days, it would be deemed that he/she is completely satisfied with the product. (c) Herein it is also agreed that once the payment is sent and accepted by the company within the given period stated as above, there will not be any refund for the purchased products under any circumstances, whatsoever, the concerned person who is purchasing the products should first be satisfied before making his payment to the company. <br />
(d)	It is mutually agreed between the parties hereto, that the company is at liberty to change modify the quantum of consideration payable under this agreement in future or provide for additional products/services at such additional cost as maybe determined by the company. <br />
(e)	Force Majeure. It is expressly understood by both the parties here that by any art of God or force majeure, that include, but is not limited to natural disaster, war, technical ,Failures and operation of law Government policies that may prevent the due performance of any of the obligations under this agreement, or under any terms Conditions subsidiary agreement that may form an integral part of this agreement will not be construed as failure to perform the contract by either of the parties hereto. It is, however, clarified that the party, so affected will take all possible steps towards normal performance of obligations under this agreement as soon as possible. No party will be responsible for any loss due to the other party under these circumstances.<br />
<strong>REFUND </strong><br />
It is made clear and to avoid any doubt under any circumstances, the company will not refund its associates/Users/Prospective or applicant any money paid by them towards any products or services of the company after complete registration of products & services.</p>
<strong>REMOVAL OF SITES</strong><br />
<p>The company cannot and does not screen all contents provided on user site and does not assume any obligation to monitor.<br />
However, Associates agrees and hereby authorizes the company to monitor sites and contents there of periodically. Company reserves the right at its sole discretion to remove any site or its contents thereof without any notice and without obligation to refund consideration paid which in its judgement is violative of any of the terms and conditions of this agreement or otherwise is unlawful or harmful to the company and or other uses, or is violate of any law or against public policies.</p><br />

<strong>SECURITY</strong><br />
<p>
An Associate is required to keep any password provided by the company and such other secure access, information confidential and notify the company promptly if the Associate believes that the security of an account has been exposed & The company has taken reasonable steps to protect the security of online transactions.</p>
<p>
However, the company does not warrant such security and will not be liable for any losses or damages resulting from any security breaches. The Associate shall be liable for losses or damages resulting from the security breaches.</p>
<p>
<strong>JURISDICTION & DISPUTES RESOLUTION  MECHANISM </strong><br />
All disputes between the Associate/User and the company arising out of or in relation to this agreement directly or indirectly shall be first settled amicably through negotiations between the parties. In case of any dispute or difference, the same shall be referred to the Arbitration as per provisions of the Arbitration and Conciliation Act 1995 and the Rules framed thereunder. The venue of the Arbitration Proceedings shall be Delhi only. It is also specifically agreed between the Parties that the jurisdiction in respect of above or any other dispute, shall be that of courts of Delhi only.</p>

<p>
<strong>GENERAL</strong><br />
i) The Company reserves its right to change the terms and conditions of the agreement under which the product/services of the company are being offered<br />
(ii) The company reserves the right to deny, in its sole discretion, before after termination of this agreement, user access to its website, facilities, products or services, without any notice or reason.<br />
(iii) This agreement constitutes the entire agreement between the parties on the subject matter thereof, however, Associate user understands that any commitment, terms and conditions, as displayed on the web site of the company, will be treated as integral part of this agreement which would be binding on both parties. No additional promises, representation, guarantees or agreements of any kind, shall have any validity concerning the subject matter of this agreement, unless the same is in writing and is agreed upon and signed by an authorized representative of the company in hard copy<br />
(iv) If an Associate refers recommends the products/services of the company to some other prospective user, and consequently decides to accept some payment and/or incentives offered by the company, then the Associate will be bound by agreement, terms and conditions on the subject contained in the company website, and the same agreements/terms & conditions, will form a binding contract between the user and the company, and will be enforceable in the same manner as this agreement being subject to the same restrictions on jurisdictional issues, including arbitration clause.<br />
(v) Associate agrees that the latest version of this agreement, available on the company website, without any modification whatsoever, will be the operative version of this agreement and any modification of this version of the agreement by any user Associate with malafide intent will invite immediate unilateral termination of this agreement by the company and such user shall be liable to be prosecuted under the relevant provisions of the law in force. The operative intent of this clause will extend to all terms, conditions and notices, which are ancillary/incidental to this agreement. including any such terms and conditions which may be contained in the company website or in any other website or web page which is also operated by the company or its affiliate, including any such sites or pages which can be accessed by links contained in the website of the company.<br />
(vi) Headings  to clauses in this agreement are for the purposes of references only, and shall not be construed as indicative for the purpose of interpretation of any cause. <br />
(vii) ASPIRE WORLD IMAGINATIONS PVT LTD. is created primarily to promote computer literacy amongst the masses and to provide ongoing non-formal continuous education online. Though, the incentives are involved to encourage the Associates to promote this noble cause but company does not guarantee any incentives/commissions.<br />
(viii) Commissions/incentives are not the right of any Associates; however, purchased products would be served for the purchased time period.<br />
(ix) In order to take the benefit of previously accumulated sales of Binary and Single leg compensation plan on continuous basis the Associate must fulfill all conditions mentioned in business section of the company. Failing in any one would result in flushing of the entire sale volume.<br />
(x) In order to earn incentives uninterruptedly all the Senior Associates have to organize two free computer learning camps every year on their own under the information to ASPIRE WORLD IMAGINATIONS PVT LTD. This is a mandatory requirement and has to be complied with under all the circumstances.<br />
(xi) Associates residing outside India are not allowed to earn any incentive in India.<br />
(xii) Any Associate found to indulge in any other activity detrimental and adverse to the interest of the Company, he/she would automatically lose his/her right to buy our product next year for the purpose of doing business with us. <br />
(xiii) Any anti-social activity/manhandling to any associate by any other associate would automatically disqualify forever for ongoing commission. However Aspire Product could be enjoyed till the purchased period. <br />
(xiv) Only information available at our website related to company or its President/Directors should be given to other Associates, Guests for promotion of Aspire Business & Aspire mission. Any Associate violating this will not be allowed to promote Business Mission anymore and his/her ongoing incentives commissions will immediately be stopped, however, he/she would continue to enjoy online leaming through product purchased by him/her for the entire purchased period. <br />
 (xv) Promises by the Associates. No product selling Associate is authorized to make any other promise to prospective buying Associates other than those made by the company under this agreement and in other official company material relating to this agreement. Misrepresentation and promises, in that event, such prospective Associate may lodge a complaint against the said Associate with the company. The company will take appropriate action against such Associate, however it is made clear and understood that the company shall not be responsible or liable in anyway or manner about the acts of the said associate.</p>

<p>
<strong>BUSINESS </strong><br />
1. People are encouraged to buy our products only if they are willing to use our Website & Blogging products. People joining our program just to take the benefit of our business or  incentive plan are highly discouraged. People who have tremendous skills and selling abilities make incentives in the marketing plans. Very little percentage of people either possesses these abilities or develops them, so we encourage people to buy “Aspire Web & Blogging Package” primarily for learning & getting success through website designing & blogging only as earning incentives might be difficult for many of them. Please note here again that we are only charging for our “Website & Blogging Package” products only and no money is charged for the business opportunity. It is mandatory for all the Associates to visit our website (www.aspiresociety.com) at least once in a week to see the recent changes or modifications In order to get incentive uninterruptedly all the designated managers and above Associates have to organize two free computer learning camps every year under the name of ASPIRE WORLD IMAGINATIONS PVT LTD. <br />
2.Associate will be entitled to participate in the business and education programmes of the company upon acceptance of an application by the company, with a Business center offered free of cost consisting of matrix to unlimited depth. After referring the sale of two  Aspire Web & Blogging Package. Associate will be qualified & eligible to collect pay out on all levels of the Business centre with fulfilment of the 2:1 ratio & conditions, as explained on the company’s business section. An Associate understands and agrees that to earn pay-out in the programme, Associate is responsible for generating business for his/herself and the company, for doing this, an Associate will personally refer sales of the Aspire Web & Blogging Package which will build his or her sales team and will contact prospects by phone, internet and in person. An Associate has to train those referred by active participation in the programme. Only those who buy an Aspire Web & Blogging Package shall be entitled for Business Model. An Associate having applied to participate in the company’s web based business program (Program, understands and agrees that he will be bound by the terms and conditions hereof, once such application is accepted by the company. An Associate shall be entitled to get company’s site for online Application processing. An Associate is responsible for training those who are referred by participation in the program. An Associate shall be solely responsible for payment of his/her taxes and other levied by central or state Government. The payments made by the company towards the incentive/commission shall be liable to tax deducted at source as per provisions of the Income Tax Act.<br />
3. The Company would release the amount of incentive/commission only to the Associates who are 18 years of age and their Pan (a photocopy of pan card duly self -attested by the Associate) is received by the company. If the Associate is minor and has not attained the age of 18 years and if he/she has not sent the copy of the PAN  card to the company, the Associate will not be entitled to any amount either towards Incentive or Commission, as the case may be. However, the day the Associate attains the age of majority i. 18 years and also the Company receives the copy of the PAN card, the Associate will be eligible for the incentives commissions as per the terms and conditions of this agreement. It is however, made clear that any person, who is minor and has not furnished the copy of the PAN card, shall not be entitled to any incentive/commission and the company shall not make the payment of the incentive commission to him her in any circumstances<br />
4. Any Associate getting incentive commission amounting to Rs. 25,000- or above in a month, he/she is expected to promote Aspire Business & Aspire mission with full zeal and enthusiasm, and is expected to attend contribute and promote all the events proposed by any group, leaders, ASPIRE WORLD IMAGINATIONS PVT LTD, and in case of not doing so, the same may lead to denial of any further incentives without any prior notice. The decision of the company in this regard would be final and shall be binding on the Associate. <br />
5.Any Associate getting incentive commissions from ASPIRE WORLD IMAGINATIONS PVT LTD cannot join other company directly or indirectly otherwise he/she would loose his/her right to get any further incentive/commission from ASPIRE WORLD IMAGINATIONS PVT LTD. However, he/she would continue to enjoy online leaming through product purchased by him/her for the entire purchased period. <br />
6. Being the global company we do not have control over the functioning of each and every Associate so this is the duty of the selling Associate & senior business managers to ensure strictly and verify the authenticity of work & information given or spread by their team. The company shall not be liable and responsible in this regard in any way. If the Company receives any complaint from Associate that the Associate is involved in misguiding, spreading misunderstanding about the company’s rules, policies, activities or functioning directly or indirectly or violating any rules and regulation of the company, then the company reserves its right to stop and appropriate to itself the amount of incentive, if any otherwise payable to the Associate, with immediate effect without any notice to the Associate. <br />
These Complaints should be certified by Managers or above Associates. However, he/she will continue to enjoy products of the company for the unexpired period of purchase period.<br />
</p>


<p>
<strong>PARTICIPATION & DISCLAIMER</strong><br />
Important Read carefully: Be sure to carefully read and understand all of the rights and restrictions described in this Associate Participation. Disclaimer and FAQ<br />
 (a) Associate user clicking on the I agree" button while purchasing the product online shall be construed as that the Associate/user has read carefully, consented and has accepted the terms and conditions of the Associate Participation and Disclaimer. This Associate Participation and disclaimer is a legally binding agreement between the Associate (either an individual company or a legal entity) and the company and the Associate shall be bound by the terms and conditions of this agreement. The clicking of submit button, after the filling of particulars in the provided form, shall be considered as consent and acceptance of the Agreement by the Associate user. The payment of the requisite subscription, as provide hereinafter, will be extension of the acceptance of the agreement and no more formal proof would be required.<br />
(b) To become an ASPIRE WORLD IMAGINATIONS PVT LTD. Associate the person must be of 18 years of age and completed 10th grade of schooling.<br />
(c) The company reserves the right to modify the Terms of Participation by the Associate or prospective applicant for online Registration at any time and without prior notice to its Associates/Users/Prospective applicants. The service may be temporarily unavailable from time to time due to maintenance or other reasons.<br />
(d) All Associates must design their web site using our web builders on the assigned limited web space within 1 year from his/her date of registration otherwise his/her all previously accumulated sales will be washed out and he/she will not get the benefit of any sale till the fulfillment of this condition. <br />
(e) It is the obligation of the Selling Associate to provide correct information and follow all the rules, regulations, orders and notifications of the company, issued made from time to time. Also it is the duty of the Buying associate to verify all the information given to him by visiting our website www.aspiresociety.com. The company will not be responsible for any wrong information given by selling Associate which is accepted by the Buying Associate without verification made from the company. <br />
However, if a written complaint against the Selling Associate is sent to us about promoting wrong information, this would amount a direct termination of the Selling Associate without any notice and compensation to him/her. <br />
(f) Associate further agree that the company reserves the right to suspend the payment of or forfeit the pay out of such applicants or Associates) whose association are liable to be terminated for committing such actions which are declared to be prohibited under this program or for non-fulfillment of any other action or terms or conditions under this program.
</p>
<p><strong>DECLARATION:</strong> It is hereby certified by me that I am a Matriculate10th grade of schooling pass out and had completed 18 years of age. It is further understood by me about how to use Aspire Web & Blogging Package online and I am completely satisfied with the Success Plan which is free of cost, and the product Aspire Web & Blogging Package, being purchased by me online. I shall deposit the product cost to ASPIRE WORLD IMAGINATIONS PVT LTD. within 7 days from the date of registration in the mode and manner provided here under this Registration Form </p>
<p><strong>USER AGREEMENT:</strong>I understand and consent to the term that there is no refund policy and once the product is purchased & Registration form is executed by me, also I have carefully read, understood and consent that once  the deposit of Cash/ Cheque /Demand Draft & signed hardcopy of the Registration Form or user Agreement is received by the company than I do not have any claim against ASPIRE WORLD IMAGINATIONS PVT LTD.</p>

				</div>
				
				</td>
                </tr>

          </table>
		</label>
	  </div>
	  </fieldset>
	  <fieldset>
	   <div class="span-5">
        <label>Mode of Corresponcence</label>
        <input name="pay_type" type="radio" value="speed post" checked="checked" />
Speed  Post
  <input name="pay_type" value="courier" type="radio" />
Courier

      </div>
	 
	  <div class="span-12">
        <label>(If you are residing in interior area then speed post would be a better option.)</label>
	  </div>
	  </fieldset>
      <input type="submit" class="button small nice green radius" value="SUBMIT THIS SALE" name="submitnewsale" id="submitform" disabled="disabled">
    </div>
  </form>
  </div>



<?php
	require_once("footer.php");
?>
</body>
</html>
