// JavaScript Document
function copy_addr()
{
	$("#p_local").val($("#c_local").val());
}
function validate_form()
{
	if($("#username_new").val()=="")
	{
		alert("Error : Please enter the Username...");
		$("#username_new").focus();
		return false;
	}
	if($("#first_name").val()=="")
	{
		alert("Error : Please enter the First Name...");
		$("#first_name").focus();
		return false;
	}
	if($("#last_name").val()=="")
	{
		alert("Error : Please enter the Last Name...");
		$("#last_name").focus();
		return false;
	}
	if($("#dob_day").val()=="none")
	{
		alert("Error : Please select the Day in your D.O.B...");
		$("#dob_day").focus();
		return false;
	}
	if($("#dob_month").val()=="none")
	{
		alert("Error : Please select the Month in your D.O.B...");
		$("#dob_month").focus();
		return false;
	}
	if($("#dob_year").val()=="none")
	{
		alert("Error : Please select the Year in your D.O.B...");
		$("#dob_year").focus();
		return false;
	}
	if($("#father_name").val()=="")
	{
		alert("Error : Please enter the Father Name...");
		$("#father_name").focus();
		return false;
	}
	if($("#phone_no").val()=="")
	{
		alert("Error : Please enter the Phone no...");
		$("#phone_no").focus();
		return false;
	}
	if($("#email_id").val()=="")
	{
		alert("Error : Please enter the Email ID...");
		$("#email_id").focus();
		return false;
	}
	if($("#c_local").val()=="")
	{
		alert("Error : Please enter the Correspondence Address...");
		$("#c_local").focus();
		return false;
	}
	if($("#p_local").val()=="")
	{
		alert("Error : Please enter the Permanent Address...");
		$("#p_local").focus();
		return false;
	}
	if($("#city").val()=="")
	{
		alert("Error : Please enter the City...");
		$("#city").focus();
		return false;
	}
	if($("#state").val()=="")
	{
		alert("Error : Please select State...");
		$("#state").focus();
		return false;
	}
	if($("#pincode").val()=="")
	{
		alert("Error : Please enter pincode...");
		$("#pincode").focus();
		return false;
	}
	document.myform.submit();
}