<?php include(dirname(__FILE__)."/../php_scripts/check_admin.php");?><?php include(dirname(__FILE__)."/../php_scripts/connection.php");?><?php $msg="";if(isset($_SESSION['msg'])){$msg=$_SESSION['msg'];$msg=str_replace("<br />","\n",$msg);unset($_SESSION['msg']);}?><?php if(isset($_GET['id'])){$id=$_GET['id'];if($id==""){echo("Error : Invalid request");exit();}$id=preg_replace("/[^0-9]/","", $id);if((filter_var($id, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9]+/"))))){echo("Error : Invalid request");exit();}}else{echo("Error : Invalid request...");exit();}?><?php $sponsor_id="";$first_name="";$last_name="";$dob_day="none";$dob_month="none";$dob_year="none";$gender="none";$father_name="";$phone_no="";$email_id="";$pan="";$c_local="";$c_city="";$c_district="";$c_state="none";$c_pincode="";$p_local="";$p_city="";$p_district="";$p_state="none";$p_pincode="";$nominee_name="";$nominee_age="";$nominee_rel="";if(!empty($_POST)){try{$first_name=$_POST['first_name'];$last_name=$_POST['last_name'];$dob_day=$_POST['dob_day'];$dob_month=$_POST['dob_month'];$dob_year=$_POST['dob_year'];$gender=$_POST['gender'];$father_name=$_POST['father_name'];$phone_no=$_POST['phone_no'];$email_id=$_POST['email_id'];$pan=$_POST['pan'];$c_local=$_POST['c_local'];$c_local_db=nl2br($c_local);$c_city=$_POST['c_city'];$c_district=$_POST['c_district'];$c_state=$_POST['c_state'];$c_pincode=$_POST['c_pincode'];$p_local=$_POST['p_local'];$p_local_db=nl2br($p_local);$p_city=$_POST['p_city'];$p_district=$_POST['p_district'];$p_state=$_POST['p_state'];$p_pincode=$_POST['p_pincode'];$nominee_name=$_POST['nominee_name'];$nominee_age=$_POST['nominee_age'];$nominee_rel=$_POST['nominee_rel'];if(($first_name=="")||($last_name=="")||($dob_day=="none")||($dob_month=="none")||($dob_year=="none")||($gender=="none")||($father_name=="")||($phone_no=="")||($email_id=="")||($c_local=="")||($c_city=="")||($c_district=="")||($c_state=="none")||($c_pincode=="")||($p_local=="")||($p_city=="")||($p_district=="")||($p_state=="none")||($p_pincode=="")){echo('Error : Invalid request');exit();}$first_name_db=htmlspecialchars($first_name);$last_name_db=htmlspecialchars($last_name);$dob_day=htmlspecialchars($dob_day);$dob_month=htmlspecialchars($dob_month);$dob_year=htmlspecialchars($dob_year);$gender=htmlspecialchars($gender);$father_name_db=htmlspecialchars($father_name);$phone_no_db=htmlspecialchars($phone_no);$email_id_db=htmlspecialchars($email_id);$pan_db=htmlspecialchars($pan);$c_local_db=htmlspecialchars($c_local_db);$c_city_db=htmlspecialchars($c_city);$c_district_db=htmlspecialchars($c_district);$c_state=htmlspecialchars($c_state);$c_pincode_db=htmlspecialchars($c_pincode);$p_local_db=htmlspecialchars($p_local_db);$p_city_db=htmlspecialchars($p_city);$p_district_db=htmlspecialchars($p_district);$p_state=htmlspecialchars($p_state);$p_pincode_db=htmlspecialchars($p_pincode);$nominee_name_db=htmlspecialchars($nominee_name);$nominee_age_db=htmlspecialchars($nominee_age);$nominee_rel_db=htmlspecialchars($nominee_rel);$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);if ($new_conn->connect_errno){echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");exit();}else{$first_name_db=$new_conn->real_escape_string($first_name_db);$last_name_db=$new_conn->real_escape_string($last_name_db);$dob_day=$new_conn->real_escape_string($dob_day);$dob_month=$new_conn->real_escape_string($dob_month);$dob_year=$new_conn->real_escape_string($dob_year);$dob=$dob_year."-".$dob_month."-".$dob_day;$gender=$new_conn->real_escape_string($gender);$father_name_db=$new_conn->real_escape_string($father_name_db);$phone_no_db=$new_conn->real_escape_string($phone_no_db);$email_id_db=$new_conn->real_escape_string($email_id_db);$pan_db=$new_conn->real_escape_string($pan_db);$c_local_db=$new_conn->real_escape_string($c_local_db);$c_city_db=$new_conn->real_escape_string($c_city_db);$c_district_db=$new_conn->real_escape_string($c_district_db);$c_state=$new_conn->real_escape_string($c_state);$c_pincode_db=$new_conn->real_escape_string($c_pincode_db);$p_local_db=$new_conn->real_escape_string($p_local_db);$p_city_db=$new_conn->real_escape_string($p_city_db);$p_district_db=$new_conn->real_escape_string($p_district_db);$p_state=$new_conn->real_escape_string($p_state);$p_pincode_db=$new_conn->real_escape_string($p_pincode_db);$nominee_name_db=$new_conn->real_escape_string($nominee_name_db);$nominee_age_db=$new_conn->real_escape_string($nominee_age_db);$nominee_rel_db=$new_conn->real_escape_string($nominee_rel_db);if($new_conn->query("UPDATE mlm_user_details SET first_name='$first_name_db',last_name='$last_name_db',dob='$dob',gender='$gender',father_name='$father_name_db',phone_no='$phone_no_db',email_id='$email_id_db',pan='$pan_db',c_local='$c_local_db',c_city='$c_city_db',c_district='$c_district_db',c_state='$c_state',c_pincode='$c_pincode_db',p_local='$p_local_db',p_city='$p_city_db',p_district='$p_district_db',p_state='$p_state',p_pincode='$p_pincode_db',nominee_name='$nominee_name_db',nominee_age='$nominee_age_db',nominee_rel='$nominee_rel_db' WHERE id='$id'")){}else{$new_conn->close();throw new Exception('Error : Unable to create new user...3...Please contact customer care');}$new_conn->close();$msg="Profile updated successfully...";$temp_filename="change_profile_id.php";header("Location: /mlm/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);}}catch(Exception $e){$msg=$e->getMessage();}}?><?php $new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);if ($new_conn->connect_errno){echo("COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");exit();}else{$res=$new_conn->query("SELECT a.*,b.sponsor_id,c.first_name AS sponsor_first_name,c.last_name AS sponsor_last_name,d.epin FROM mlm_user_details a INNER JOIN mlm_login b ON b.id=a.id INNER JOIN mlm_user_details c ON c.id=b.sponsor_id INNER JOIN mlm_epins d ON d.used_by=a.id WHERE a.id='$id'");if($res->num_rows==1){$detail=$res->fetch_assoc();$new_conn->close();$user_name_t=$detail['sponsor_first_name'];$user_name_t=mb_substr($user_name_t, 0, 3);$user_name_t=strtoupper($user_name_t);$sponsor_id=$user_name_t.$detail['sponsor_id']." - ".$detail['sponsor_first_name']." ".$detail['sponsor_last_name'];$epin_used=$detail['epin'];$first_name=$detail['first_name'];$last_name=$detail['last_name'];$dob=$detail['dob'];$dob=explode("-",$dob);$dob_year=$dob[0];$dob_month=$dob[1];$dob_day=$dob[2];$gender=$detail['gender'];$father_name=$detail['father_name'];$phone_no=$detail['phone_no'];$email_id=$detail['email_id'];$pan=$detail['pan'];$c_local=$detail['c_local'];$c_local=str_replace("&lt;br /&gt;","",$c_local);$c_city=$detail['c_city'];$c_district=$detail['c_district'];$c_state=$detail['c_state'];$c_pincode=$detail['c_pincode'];$p_local=$detail['p_local'];$p_local=str_replace("&lt;br /&gt;","",$p_local);$p_city=$detail['p_city'];$p_district=$detail['p_district'];$p_state=$detail['p_state'];$p_pincode=$detail['p_pincode'];$nominee_name=$detail['nominee_name'];$nominee_age=$detail['nominee_age'];$nominee_rel=$detail['nominee_rel'];$username=$detail['username'];}else{$msg="Error : Profile not found...";$temp_filename="change_profile_id.php";header("Location: /mlm/admin/redirect_back.php?q=".$temp_filename."&msg=".$msg);}}?><!doctype html> <html> <head> <meta charset="utf-8"> <title>View / Edit User Profile</title> <script src="../javascript/jquery_file.js"></script> <link rel="stylesheet" type="text/css" href="../css/style.css" /> <style> legend{ font-weight:bold; font-size:1.1em; } fieldset{ padding:20px; } .tables_fieldset{ width:100%; font-weight:bold; color:#333; } </style> <script> function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false; return true; } </script> </head> <body> <input type="hidden" id="error" value="<?php echo($msg);?>" /> <div id="content_main"> <form name="myform" method="post"> <table style="width:90%;margin:auto;font-size:1em;" border="0" cellpadding="0" cellspacing="0"> <tr> <td align="center" colspan="2"><h2 style="color:#333;line-height:50px;">VIEW / EDIT USER PROFILE</h2></td> </tr> <tr> <td colspan="2"><br> <fieldset> <legend>NEW USER DETAILS</legend> <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0"> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">ID</td> <td style="width:5px;">:</td> <td> <?php $user_name_t=$detail['first_name']; $user_name_t=mb_substr($user_name_t, 0, 3); $user_name_t=strtoupper($user_name_t); echo($user_name_t.$id); ?> </td> </tr> </table> </td> </tr> </table> </fieldset><br> <fieldset> <legend>SPONSOR DETAILS</legend> <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0"> <tr> <td> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Sponsor</td> <td style="width:5px;">:</td> <td><?php echo($sponsor_id);?></td> </tr> </table> </td> </tr> </table> </fieldset><br> <fieldset> <legend>PAYMENT DETAILS</legend> <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0"> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">E-PIN</td> <td style="width:5px;">:</td> <td><input type="text" value="<?php echo($epin_used);?>" disabled class="textboxes" /></td> </tr> </table> </td> <td> </td> </tr> </table> </fieldset><br> <fieldset> <legend>PERSONAL DETAILS (NEW USER)</legend> <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0"> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">First Name</td> <td style="width:5px;">:</td> <td><input type="text" name="first_name" id="first_name" class="textboxes" value="<?php echo($first_name);?>" /></td> </tr> </table> </td> <td> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Last Name</td> <td style="width:5px;">:</td> <td><input type="text" name="last_name" id="last_name" class="textboxes" value="<?php echo($last_name);?>" /></td> </tr> </table> </td> </tr> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">D.O.B</td> <td style="width:5px;">:</td> <td> <select class="textboxes" style="width:auto;" name="dob_day" id="dob_day"> <option value="none">-----</option> <option>01</option> <option>02</option> <option>03</option> <option>04</option> <option>05</option> <option>06</option> <option>07</option> <option>08</option> <option>09</option> <option>10</option> <option>11</option> <option>12</option> <option>13</option> <option>14</option> <option>15</option> <option>16</option> <option>17</option> <option>18</option> <option>19</option> <option>20</option> <option>21</option> <option>22</option> <option>23</option> <option>24</option> <option>25</option> <option>26</option> <option>27</option> <option>28</option> <option>29</option> <option>30</option> <option>31</option> </select> <input type="hidden" id="dob_day_postback" value="<?php echo($dob_day);?>" /> <select class="textboxes" style="width:auto;" name="dob_month" id="dob_month"> <option value="none">-----</option> <option value="01">Jan</option> <option value="02">Feb</option> <option value="03">Mar</option> <option value="04">Apr</option> <option value="05">May</option> <option value="06">Jun</option> <option value="07">Jul</option> <option value="08">Aug</option> <option value="09">Sep</option> <option value="10">Oct</option> <option value="11">Nov</option> <option value="12">Dec</option> </select> <input type="hidden" id="dob_month_postback" value="<?php echo($dob_month);?>" /> <select class="textboxes" style="width:auto;" name="dob_year" id="dob_year"> <option value="none">-----</option> <option>1940</option> <option>1941</option> <option>1942</option> <option>1943</option> <option>1944</option> <option>1945</option> <option>1946</option> <option>1947</option> <option>1948</option> <option>1949</option> <option>1950</option> <option>1951</option> <option>1952</option> <option>1953</option> <option>1954</option> <option>1955</option> <option>1956</option> <option>1957</option> <option>1958</option> <option>1959</option> <option>1960</option> <option>1961</option> <option>1962</option> <option>1963</option> <option>1964</option> <option>1965</option> <option>1966</option> <option>1967</option> <option>1968</option> <option>1969</option> <option>1970</option> <option>1971</option> <option>1972</option> <option>1973</option> <option>1974</option> <option>1975</option> <option>1976</option> <option>1977</option> <option>1978</option> <option>1979</option> <option>1980</option> <option>1981</option> <option>1982</option> <option>1983</option> <option>1984</option> <option>1985</option> <option>1986</option> <option>1987</option> <option>1988</option> <option>1989</option> <option>1990</option> <option>1991</option> <option>1992</option> <option>1993</option> <option>1994</option> <option>1995</option> <option>1996</option> <option>1997</option> <option>1998</option> <option>1999</option> <option>2000</option> </select> <input type="hidden" id="dob_year_postback" value="<?php echo($dob_year);?>" /> </td> </tr> </table> </td> <td> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Gender</td> <td style="width:5px;">:</td> <td> <select class="textboxes" style="width:auto;" name="gender" id="gender"> <option value="none">--- select ---</option> <option>Male</option> <option>Female</option> </select> <input type="hidden" id="gender_postback" value="<?php echo($gender);?>" /> </td> </tr> </table> </td> </tr> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Father Name</td> <td style="width:5px;">:</td> <td><input type="text" name="father_name" id="father_name" value="<?php echo($father_name);?>" class="textboxes" /></td> </tr> </table> </td> <td> </td> </tr> <tr> <td colspan="2"> <table cellpadding="0" cellspacing="0" style="width:100%;"> <tr> <td style="width:150px;">Phone no</td> <td style="width:5px;">:</td> <td><input type="text" placeholder=" Multiple phone numbers separated by comma(,)" value="<?php echo($phone_no);?>" style="width:90%;" name="phone_no" id="phone_no" class="textboxes" /></td> </tr> </table> </td> </tr> <tr> <td colspan="2"> <table cellpadding="0" cellspacing="0" style="width:100%;"> <tr> <td style="width:150px;">Email ID</td> <td style="width:5px;">:</td> <td><input type="text" placeholder=" Multiple email IDs separated by comma(,)" value="<?php echo($email_id);?>" style="width:90%;" name="email_id" id="email_id" class="textboxes" /></td> </tr> </table> </td> </tr><tr><td colspan="2"><table cellpadding="0" cellspacing="0" style="width:100%;"><tr><td style="width:150px;">PAN</td><td style="width:5px;">:</td><td><input type="text" value="<?php echo($pan);?>" style="width:90%;" name="pan" id="pan" class="textboxes" /></td></tr></table></td></tr> </table> </fieldset><br> <fieldset style="padding-top:10px;"> <legend>ADDRESS</legend> <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0"> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0" style="width:400px;"> <tr style="height:30px;"> <td>CORRESPONDANCE ADDRESS</td> </tr> <tr> <td><textarea placeholder="Local Address" name="c_local" id="c_local" style="resize:none;width:99%;" rows="3" class="textboxes"><?php echo($c_local);?></textarea></td> </tr> <tr> <td><input type="text" placeholder=" City" name="c_city" id="c_city" value="<?php echo($c_city);?>" style="width:100%;" class="textboxes"></textarea></td> </tr> <tr> <td><input type="text" placeholder=" District" name="c_district" id="c_district" value="<?php echo($c_district);?>" style="width:100%;" class="textboxes"></textarea></td> </tr> <tr> <td> <select class="textboxes" style="width:100%;" name="c_state" id="c_state"> <option value="none">--- Select ---</option> <option>Andaman & Nicobar</option> <option>Andhra Pradesh</option> <option>Arunachal Pradesh</option> <option>Assam</option> <option>Bihar</option> <option>Chandigarh</option> <option>Chhattisgarh</option> <option>Dadrar Nagar Haveli</option> <option>Daman & Diu</option> <option>Delhi</option> <option>Goa</option> <option>Gujarat</option> <option>Haryana</option> <option>Himachal Pradesh</option> <option>Jammu Kashmir</option> <option>Jharkhand</option> <option>Karnataka</option> <option>Kerala</option> <option>Lakshadweep</option> <option>Madhya Pradesh</option> <option>Maharashtra</option> <option>Manipur</option> <option>Meghalaya</option> <option>Mizoram</option> <option>Nagaland</option> <option>Orissa</option> <option>Pondicherry</option> <option>Punjab</option> <option>Rajasthan</option> <option>Sikkim</option> <option>Tamil Nadu</option> <option>Tripura</option> <option>Uttar Pradesh</option> <option>Uttaranchal</option> <option>West Bengal</option> </select> <input type="hidden" id="c_state_postback" value="<?php echo($c_state);?>" /> </td> </tr> <tr> <td><input type="text" placeholder=" Pincode" name="c_pincode" id="c_pincode" value="<?php echo($c_pincode);?>" onkeypress="return isNumberKey(event)" maxlength="6" style="width:50%;" class="textboxes"></textarea></td> </tr> </table> </td> <td> <table cellpadding="0" cellspacing="0" style="width:400px;"> <tr style="height:30px;"> <td>PERMANENT ADDRESS <div class="buttons" style="background-color:#C60;" onClick="copy_addr()">&nbsp;&nbsp;&nbsp;Copy Correspondance Address&nbsp;&nbsp;&nbsp;</div> </td> </tr> <tr> <td><textarea placeholder="Local Address" name="p_local" id="p_local" value="<?php echo($p_local);?>" style="resize:none;width:99%;" rows="3" class="textboxes"><?php echo($p_local);?></textarea></td> </tr> <tr> <td><input type="text" placeholder=" City" name="p_city" id="p_city" value="<?php echo($p_city);?>" style="width:100%;" class="textboxes"></textarea></td> </tr> <tr> <td><input type="text" placeholder=" District" name="p_district" id="p_district" value="<?php echo($p_district);?>" style="width:100%;" class="textboxes"></textarea></td> </tr> <tr> <td> <select class="textboxes" style="width:100%;" name="p_state" id="p_state"> <option value="none">--- Select ---</option> <option>Andaman & Nicobar</option> <option>Andhra Pradesh</option> <option>Arunachal Pradesh</option> <option>Assam</option> <option>Bihar</option> <option>Chandigarh</option> <option>Chhattisgarh</option> <option>Dadrar Nagar Haveli</option> <option>Daman & Diu</option> <option>Delhi</option> <option>Goa</option> <option>Gujarat</option> <option>Haryana</option> <option>Himachal Pradesh</option> <option>Jammu Kashmir</option> <option>Jharkhand</option> <option>Karnataka</option> <option>Kerala</option> <option>Lakshadweep</option> <option>Madhya Pradesh</option> <option>Maharashtra</option> <option>Manipur</option> <option>Meghalaya</option> <option>Mizoram</option> <option>Nagaland</option> <option>Orissa</option> <option>Pondicherry</option> <option>Punjab</option> <option>Rajasthan</option> <option>Sikkim</option> <option>Tamil Nadu</option> <option>Tripura</option> <option>Uttar Pradesh</option> <option>Uttaranchal</option> <option>West Bengal</option> </select> <input type="hidden" id="p_state_postback" value="<?php echo($p_state);?>" /> <script> $("#dob_day").val($("#dob_day_postback").val()); $("#dob_month").val($("#dob_month_postback").val()); $("#dob_year").val($("#dob_year_postback").val()); $("#gender").val($("#gender_postback").val()); $("#c_state").val($("#c_state_postback").val()); $("#p_state").val($("#p_state_postback").val()); </script> </td> </tr> <tr> <td><input type="text" placeholder=" Pincode" name="p_pincode" id="p_pincode" value="<?php echo($p_pincode);?>" onkeypress="return isNumberKey(event)" maxlength="6" style="width:50%;" class="textboxes"></textarea></td> </tr> </table> </td> </tr> </table> </fieldset><br> <fieldset> <legend>NOMINEE DETAILS</legend> <table border="0" class="tables_fieldset" cellpadding="0" cellspacing="0"> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Name</td> <td style="width:5px;">:</td> <td><input type="text" name="nominee_name" id="nominee_name" value="<?php echo($nominee_name);?>" class="textboxes" /></td> </tr> </table> </td> <td> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Age</td> <td style="width:5px;">:</td> <td><input type="text" name="nominee_age" id="nominee_age" value="<?php echo($nominee_age);?>" onkeypress="return isNumberKey(event)" style="width:100px;" class="textboxes" /> (years)</td> </tr> </table> </td> </tr> <tr> <td style="width:50%;"> <table cellpadding="0" cellspacing="0"> <tr> <td style="width:150px;">Relation</td> <td style="width:5px;">:</td> <td><input type="text" name="nominee_rel" id="nominee_rel" class="textboxes" value="<?php echo($nominee_rel);?>" /></td> </tr> </table> </td> <td> </td> </tr> </table> </fieldset> </td> </tr> <tr style="height:50px;"> <td style="font-weight:bold;"></td> <td align="right"><div class="buttons" onClick="validate_form()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;&nbsp;<div class="buttons" onClick="window.location.href = 'index.php';" style="background-color:#900;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td> </tr> </table> </form><br><br> </div> <?php include(dirname(__FILE__)."/common/left_menu_var.php");?> <?php ?> <?php include(dirname(__FILE__)."/common/left_menu.php");?> <?php include(dirname(__FILE__)."/common/main_menu_var.php");?> <?php $top_personal_details=$top_val; ?> <?php include(dirname(__FILE__)."/common/main_menu.php");?> <script src="javascript/menu.js"></script> <script src="javascript/arrange_content.js"></script> <script src="javascript/reg_form.js"></script> <script src="../javascript/error_alert.js"></script> </body> </html>