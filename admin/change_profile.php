<?php include("../php_scripts_wb/check_admin.php");?>
<?php include("../php_scripts_wb/connection.php");?>
<?php
$msg="";
if(isset($_SESSION['msg']))
{
	$msg=$_SESSION['msg'];
	$msg=str_replace("<br />","\n",$msg);
	unset($_SESSION['msg']);
}
?>
<?php
if(isset($_GET['id']))
{
	$id=$_GET['id'];
	if($id=="")
	{
		echo("Error : Invalid request");
		exit();
	}
	if((filter_var($id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/")))))
	{
		echo("Error : Invalid request");
		exit();
	}
}
else
{
	echo("Error : Invalid request...");
	exit();
}
?>
<?php
$sponsor_id="";
$first_name="";
$last_name="";
if(!empty($_POST))
{
	try
	{
		$income_status=$_POST['income_status'];
		$income_mode=$_POST['income_mode'];
		$bank_details=$_POST['bank_details'];
		$bank_details=nl2br($bank_details);
		$username_new=$_POST['username_new'];
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$dob_day=$_POST['dob_day'];
		$dob_month=$_POST['dob_month'];
		$dob_year=$_POST['dob_year'];
		$father_name=$_POST['father_name'];
		$phone_no=$_POST['phone_no'];
		$email_id=$_POST['email_id'];
		$pan=$_POST['pan'];
		$c_local=$_POST['c_local'];
		$c_local=nl2br($c_local);
		
		$p_local=$_POST['p_local'];
		$p_local=nl2br($p_local);
		$city=$_POST['city'];
		$state=$_POST['state'];
		$pincode=$_POST['pincode'];
		$nominee_name=$_POST['nominee_name'];
		
		
		if(($income_status=="")||($username_new=="")||($first_name=="")||($last_name=="")||($dob_day=="none")||($dob_month=="none")||($dob_year=="none")||($father_name=="")||($phone_no=="")||($email_id=="")||($c_local=="")||($p_local=="")||($city=="")||($state=="")||($pincode==""))
		{
			echo('Error : Invalid request');
			exit();
		}
		
		$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
		if ($new_conn->connect_errno)
		{
			echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
			exit();
		}
		else
		{
			$username_new=$new_conn->real_escape_string($username_new);
			$prep="SELECT a.table_id FROM wb_ud a WHERE a.username='$username_new' AND a.table_id!='$id'";
			$res=$new_conn->query($prep);
			if($res->num_rows>0)
			{
				$new_conn->close();
				throw new Exception('Error : Username already taken...!!!');
			}
			
			$income_status=$new_conn->real_escape_string($income_status);
			$income_mode=$new_conn->real_escape_string($income_mode);
			$bank_details=$new_conn->real_escape_string($bank_details);
			$first_name=$new_conn->real_escape_string($first_name);
			$last_name=$new_conn->real_escape_string($last_name);
			$dob_day=$new_conn->real_escape_string($dob_day);
			$dob_month=$new_conn->real_escape_string($dob_month);
			$dob_year=$new_conn->real_escape_string($dob_year);
			
			$dob=$dob_year."-".$dob_month."-".$dob_day;
			
			$father_name=$new_conn->real_escape_string($father_name);
			$phone_no=$new_conn->real_escape_string($phone_no);
			$email_id=$new_conn->real_escape_string($email_id);
			$pan=$new_conn->real_escape_string($pan);
			$c_local=$new_conn->real_escape_string($c_local);
			$p_local=$new_conn->real_escape_string($p_local);
			$city=$new_conn->real_escape_string($city);
			$state=$new_conn->real_escape_string($state);
			$pincode=$new_conn->real_escape_string($pincode);
			$nominee_name=$new_conn->real_escape_string($nominee_name);
			
			if($income_status=="allowed")
			{
				$prep="UPDATE wb_ch SET payment_status='pending' WHERE payment_status='stopped' AND id='$id'";
				$new_conn->query($prep);
			}
			else if($income_status=="stopped")
			{
				$prep="UPDATE wb_ch SET payment_status='stopped' WHERE payment_status='pending' AND id='$id'";
				$new_conn->query($prep);
			}
			else
			{
				$new_conn->close();
				echo("Error : Invalid request");
				exit();
			}
			
			
			$prep="UPDATE wb_ud SET username='$username_new',income_status='$income_status',income_mode='$income_mode',bank_details='$bank_details',first_name='$first_name',last_name='$last_name',dob='$dob',father_name='$father_name',phone_no='$phone_no',email_id='$email_id',pan='$pan',c_local='$c_local',p_local='$p_local',city='$city',state='$state',pincode='$pincode',nominee_name='$nominee_name' WHERE table_id='$id'";
			$new_conn->query($prep);
			$new_conn->close();
			$msg="Profile updated successfully...";
			$temp_filename="change_profile.php?id=".$id;
			header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
		}
	}
	catch(Exception $e)
	{
		$msg=$e->getMessage();
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
$prep="SELECT a.*,c.first_name AS sponsor_first_name,c.last_name AS sponsor_last_name,c.username AS sponsor_username,c.did AS sponsor_did,d.epin FROM wb_ud a INNER JOIN wb_ud c ON c.table_id=a.sponsor_id INNER JOIN wb_epins d ON d.used_by=a.table_id WHERE a.table_id='$id'";
	$res=$new_conn->query($prep);
	if($res->num_rows==1)
	{
	$detail=$res->fetch_assoc();
	$new_conn->close();
	$user_name_t=$detail['sponsor_first_name'];
	$user_name_t=mb_substr($user_name_t, 0, 3);
	$user_name_t=strtoupper($user_name_t); 
	$sponsor_id=$detail['sponsor_username']." (".$detail['sponsor_first_name']." ".$detail['sponsor_last_name'].")"." (".$detail['sponsor_did'].")";
	$epin_used=$detail['epin'];
	$first_name=$detail['first_name'];
	$last_name=$detail['last_name'];
	$dob=$detail['dob'];
	$dob=explode("-",$dob);
	$dob_year=$dob[0];
	$dob_month=$dob[1];
	$dob_day=$dob[2];
	}
	else
	{
		$msg="Error : Profile not found...";
		$temp_filename="change_profile_id.php";
		header("Location: /panel/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Change Profile</title>
<script src="../javascript/jquery_file.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<style>
legend{
font-weight:bold;
font-size:1.1em;
}
fieldset{
padding:20px;
}
.tables_fieldset{
width:100%;
font-weight:bold;
color:#333;
}
</style>
<script>
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>
</head>
<body>
<input type="hidden" id="error" value="<?php echo($msg);?>" />
<div id="content_main">
<form name="myform" method="post">
<table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" colspan="2"><h2 style="color:#333;line-height:50px;">VIEW / EDIT USER PROFILE</h2></td>
  </tr>
  <tr>
    <td colspan="2"><br>
      <fieldset>
        <legend>USER DETAILS</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Username</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" value="<?php echo($detail['username']);?>" class="textboxes" name="username_new" id="username_new" />
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </fieldset><br>
      <fieldset>
        <legend>SPONSOR DETAILS</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Sponsor</td>
                  <td style="width:5px;">:</td>
                  <td><?php echo($sponsor_id);?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </fieldset><br>
      <fieldset>
        <legend>PAYMENT DETAILS</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">E-PIN</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" value="<?php echo($epin_used);?>" disabled class="textboxes" /></td>
                </tr>
              </table>
            </td>
            <td>
            </td>
          </tr>
        </table>
      </fieldset><br>
      <fieldset>
        <legend>INCOME DETAILS</legend>
        <table border="0" class="tables_fieldset" cellpadding="3px" cellspacing="0">
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Income Status</td>
                  <td style="width:5px;">:</td>
                  <td>
                    <select name="income_status" id="income_status" style="width:auto;" class="textboxes">
                      <option value="allowed"
                      <?php
					  if($detail['income_status']=="allowed")
					  {
						  echo(" selected");
					  }
					  ?>
                      >Allowed</option>
                      <option value="stopped"
                      <?php
					  if($detail['income_status']=="stopped")
					  {
						  echo(" selected");
					  }
					  ?>
                      >Stopped</option>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Income Mode</td>
                  <td style="width:5px;">:</td>
                  <td>
                    <select name="income_mode" id="income_mode" style="width:auto;" class="textboxes">
                      <option value="cheque"
                      <?php
					  if($detail['income_mode']=="cheque")
					  {
						  echo(" selected");
					  }
					  ?>
                      >cheque</option>
                      <option value="neft"
                      <?php
					  if($detail['income_mode']=="neft")
					  {
						  echo(" selected");
					  }
					  ?>
                      >neft</option>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table cellpadding="0" cellspacing="0">
                <tr valign="top">
                  <td style="width:150px;">Bank Details</td>
                  <td style="width:5px;">:</td>
                  <td>
                  <textarea name="bank_details" id="bank_details" style="width:500px;" rows="5" class="textboxes"><?php echo($detail['bank_details']);?></textarea>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </fieldset><br>
      <fieldset>
        <legend>PERSONAL DETAILS (NEW USER)</legend>
        <table border="0" class="tables_fieldset" cellpadding="3px" cellspacing="0">
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">First Name</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" name="first_name" id="first_name" class="textboxes" value="<?php echo($first_name);?>" /></td>
                </tr>
              </table>
            </td>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Last Name</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" name="last_name" id="last_name" class="textboxes" value="<?php echo($last_name);?>" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">D.O.B</td>
                  <td style="width:5px;">:</td>
                  <td>
                    <select class="textboxes" style="width:auto;" name="dob_day" id="dob_day">
                      <option value="none">-Day-</option>
          <?php
		  for($i=1;$i<=31;$i++)
		  {
			  echo("<option");
			  if(abs($dob_day)==abs($i))
			  {
				  echo(" selected");
			  }
			  echo(">".$i."</option>");
		  }
		  ?>
                    </select>
                    <select class="textboxes" style="width:auto;" name="dob_month" id="dob_month">
                      <option value="none">-Month-</option>
          <option value="1"
          <?php
		  if($dob_month=="1")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jan </option>
          <option value="2"
          <?php
		  if($dob_month=="2")
		  {
			  echo(" selected");
		  }
		  ?>
          >Feb </option>
          <option value="3"
          <?php
		  if($dob_month=="3")
		  {
			  echo(" selected");
		  }
		  ?>
          >Mar </option>
          <option value="4"
          <?php
		  if($dob_month=="4")
		  {
			  echo(" selected");
		  }
		  ?>
          >Apr </option>
          <option value="5"
          <?php
		  if($dob_month=="5")
		  {
			  echo(" selected");
		  }
		  ?>
          >May </option>
          <option value="6"
          <?php
		  if($dob_month=="6")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jun </option>
          <option value="7"
          <?php
		  if($dob_month=="7")
		  {
			  echo(" selected");
		  }
		  ?>
          >Jul </option>
          <option value="8"
          <?php
		  if($dob_month=="8")
		  {
			  echo(" selected");
		  }
		  ?>
          >Aug </option>
          <option value="9"
          <?php
		  if($dob_month=="9")
		  {
			  echo(" selected");
		  }
		  ?>
          >Sep </option>
          <option value="10"
          <?php
		  if($dob_month=="10")
		  {
			  echo(" selected");
		  }
		  ?>
          >Oct </option>
          <option value="11"
          <?php
		  if($dob_month=="11")
		  {
			  echo(" selected");
		  }
		  ?>
          >Nov </option>
          <option value="12"
          <?php
		  if($dob_month=="12")
		  {
			  echo(" selected");
		  }
		  ?>
          >Dec </option>
                    </select>
                    <select class="textboxes" style="width:auto;" name="dob_year" id="dob_year">
                      <option value="none">-Year-</option>
          <?php
		  for($i=1955;$i<=1997;$i++)
		  {
			  echo("<option");
			  if(abs($dob_year)==abs($i))
			  {
				  echo(" selected");
			  }
			  echo(">".$i."</option>");
		  }
		  ?>
                  </td>
                </tr>
              </table>
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Father Name</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" name="father_name" id="father_name" value="<?php echo($detail['father_name']);?>" class="textboxes" /></td>
                </tr>
              </table>
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                  <td style="width:150px;">Contact no</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" placeholder=" Multiple phone numbers separated by comma(,)" value="<?php echo($detail['phone_no']);?>" style="width:90%;" name="phone_no" id="phone_no" class="textboxes" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                  <td style="width:150px;">Email ID</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" placeholder=" Multiple email IDs separated by comma(,)" value="<?php echo($detail['email_id']);?>" style="width:90%;" name="email_id" id="email_id" class="textboxes" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                  <td style="width:150px;">PAN</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" placeholder=" PAN no" value="<?php echo($detail['pan']);?>" style="width:90%;" name="pan" id="pan" class="textboxes" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0">
                <tr>
                  <td style="width:150px;">Nominee</td>
                  <td style="width:5px;">:</td>
                  <td><input type="text" name="nominee_name" id="nominee_name" value="<?php echo($detail['nominee_name']);?>" class="textboxes" /></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </fieldset><br>
      
<?php
$detail['c_local']=str_replace("<br />","",$detail['c_local']);
$detail['c_local']=str_replace("<br/>","",$detail['c_local']);
$detail['c_local']=str_replace("<br>","",$detail['c_local']);

$detail['p_local']=str_replace("<br />","",$detail['p_local']);
$detail['p_local']=str_replace("<br/>","",$detail['p_local']);
$detail['p_local']=str_replace("<br>","",$detail['p_local']);
?>
      <fieldset style="padding-top:10px;">
        <legend>ADDRESS</legend>
        <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0">
          <tr>
            <td style="width:50%;">
              <table cellpadding="0" cellspacing="0" style="width:400px;">
                <tr style="height:30px;">
                  <td>CORRESPONDANCE ADDRESS</td>
                </tr>
                <tr>
                  <td><textarea placeholder="Local Address" name="c_local" id="c_local" style="resize:none;width:99%;" rows="5" class="textboxes"><?php echo($detail['c_local']);?></textarea></td>
                </tr>
              </table>
            </td>
            <td>
              <table cellpadding="0" cellspacing="0" style="width:400px;">
                <tr style="height:30px;">
                  <td>PERMANENT ADDRESS <div class="buttons" style="background-color:#C60;" onClick="copy_addr()">&nbsp;&nbsp;&nbsp;Copy Correspondance Address&nbsp;&nbsp;&nbsp;</div> </td>
                </tr>
                <tr>
                  <td><textarea placeholder="Local Address" name="p_local" id="p_local" value="<?php echo($detail['p_local']);?>" style="resize:none;width:99%;" rows="5" class="textboxes"><?php echo($detail['p_local']);?></textarea></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td colspan="2"><br>
            <input type="text" placeholder=" City" name="city" id="city" value="<?php echo($detail['city']);?>" style="width:300px;" class="textboxes"><br><br>
                    <select class="textboxes" style="width:auto;" name="state" id="state">
                      <option value="">--- Select State ---</option>
<?php
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
	echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
	exit();
}
else
{
	$res_state=$new_conn->query("SELECT * FROM wb_st");
	while($detail_state=$res_state->fetch_assoc())
	{
		echo("<option");
		if($detail['state']==$detail_state['name'])
		{
			echo(" selected");
		}
		echo(">".$detail_state['name']."</option>");
	}
	$new_conn->close();	
}
?>
                    </select><br><br><input type="text" placeholder=" Pincode" name="pincode" id="pincode" value="<?php echo($detail['pincode']);?>" onkeypress="return isNumberKey(event)" maxlength="6" style="width:100px;" class="textboxes" />
            </td>
          </tr>
        </table>
      </fieldset><br>
    </td>
  </tr>
  <tr style="height:50px;">
    <td style="font-weight:bold;"></td>
    <td align="right"><div class="buttons" onClick="validate_form()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;<div class="buttons" onClick="window.location.href = 'index.php';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  </tr>
</table>
</form><br><br>
</div>
<?php include(dirname(__FILE__)."/common/left_menu_var.php");?>
<?php
?>
<?php include(dirname(__FILE__)."/common/left_menu.php");?>

<?php include(dirname(__FILE__)."/common/main_menu_var.php");?>
<?php
$top_personal_details=$top_val;
?>
<?php include("common/main_menu.php");?>
<script src="javascript/menu.js"></script>
<script src="javascript/arrange_content.js"></script>
<script src="javascript/reg_form.js"></script>
<script src="../javascript/error_alert.js"></script>
</body>
</html>