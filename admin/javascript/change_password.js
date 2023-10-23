// JavaScript Document
function submit_form()
{
	var old=$("#old_pass").val();
	var new_pass=$("#new_pass").val();
	var confirm_pass=$("#confirm_pass").val();
	if(old=="")
	{
		alert("Error : Please enter your current password...");
		$("#old_pass").focus();
		return false;
	}
	if(new_pass=="")
	{
		alert("Error : Please enter new password...");
		$("#new_pass").focus();
		return false;
	}
	if(confirm_pass=="")
	{
		alert("Error : Please confirm new password...");
		$("#confirm_pass").focus();
		return false;
	}
	if(new_pass.length<6)
	{
		alert("Error : New password must be atleast 6 characters long...");
		$("#new_pass").focus();
		return false;
	}
	if(new_pass!=confirm_pass)
	{
		alert("Error : New Password and Confirm Password do not match...");
		$("#confirm_pass").focus();
		return false;
	}
	document.myform.submit();
}