<?php
class client_log_details
{
	public function ip_address()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		if((filter_var($ip, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9. ]+/")))))
		{
			throw new Exception('Error : IP address not invalid...!!!');
		}
		return $ip;
	}
	public function mac_address()
	{
		// Turn on output buffering
		ob_start();
		//Get the ipconfig details using system commond
		system('ipconfig /all');
		// Capture the output into a variable
		$mycom=ob_get_contents();
		// Clean (erase) the output buffer
		ob_clean();
		$findme = "Physical";
		//Search the "Physical" | Find the position of Physical text
		$pmac = strpos($mycom, $findme);
		// Get Physical Address
		$mac=substr($mycom,($pmac+36),17);
		//Display Mac Address
		if((filter_var($mac, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[^0-9A-Za-z:. \-]+/")))))
		{
			throw new Exception('Error : MAC address not invalid...!!!');
		}
		return $mac;
	}
	public function browser_agent()
	{
		$browser=$_SERVER['HTTP_USER_AGENT'];
		return $browser;
	}
}
?>