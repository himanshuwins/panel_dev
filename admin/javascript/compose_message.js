// JavaScript Document
function send_message()
{
	if($("#to").val()=="")
	{
		alert("Error : Please enter recepient...");
		$("#to").focus();
		return false;
	}
	if($("#subject").val()=="")
	{
		alert("Error : Please enter the subject...");
		$("#subject").focus();
		return false;
	}
	if($("#message").val()=="")
	{
		alert("Error : Please enter a message...");
		$("#message").focus();
		return false;
	}
	document.myform.submit();
}