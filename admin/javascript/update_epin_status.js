function activate_epin(str)
{
  var xmlhttp;
  if(str.length==0)
  {
	  alert("Error : Invalid request...!!!");
	  return false;
  }
  $("#blackout").css({'visibility':'visible'});
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		if(xmlhttp.responseText=="ok")
		{
			alert("Changed successfully...");
			$("#status_td").html("active");
			var text="<a href=\"javascript:deactivate_epin("+str+")\">Deactivate Now</a>";
			$("#action_td").html(text);
		}
		else if(xmlhttp.responseText=="no")
		{
			alert("Error : Coudn't update...Please contact your administrator...");
		}
		$("#blackout").css({'visibility':'hidden'});
    }
  }
  xmlhttp.open("POST","javascript/activate_epin_db.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+str);
}
function deactivate_epin(str)
{
  var xmlhttp;
  if(str.length==0)
  {
	  alert("Error : Invalid request...!!!");
	  return false;
  }
  $("#blackout").css({'visibility':'visible'});
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		if(xmlhttp.responseText=="ok")
		{
			alert("Changed successfully...");
			$("#status_td").html("inactive");
			var text="<a href=\"javascript:activate_epin("+str+")\">Activate Now</a>";
			$("#action_td").html(text);
		}
		else if(xmlhttp.responseText=="no")
		{
			alert("Error : Coudn't update...Please contact your administrator...");
		}
		$("#blackout").css({'visibility':'hidden'});
    }
  }
  xmlhttp.open("POST","javascript/deactivate_epin_db.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+str);
}