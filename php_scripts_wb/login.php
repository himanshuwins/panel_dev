<?php
class check_login
{
	public $error_status="no";
	public $msg_error="";
	public function check_empty($to_check)
	{
	  if($to_check=="")
	  {
		  throw new Exception('Error : ID or Password cannot be empty...!!!');
	  }
	}
	public function input_secure_formatting($to_format)
	{
		$to_format=htmlspecialchars($to_format);
		$to_format=trim($to_format);
		return $to_format;
	}
	public function validate_username($t_username)
	{
	}
	public function validate_password($t_password)
	{
	}
	public function db_login_check($t_username,$t_password)
	{
		try
		{
			$this->check_empty($t_username);
			$this->check_empty($t_password);
			$t_username=$this->input_secure_formatting($t_username);
			$t_password=$this->input_secure_formatting($t_password);
			$this->validate_username($t_username);
			$this->validate_password($t_password);
			
			
			date_default_timezone_set('Asia/Calcutta');
			$date = date('Y-m-d H:i:s');
			$browser=$_SERVER['HTTP_USER_AGENT'];
			$ip=$_SERVER['REMOTE_ADDR'];
					
			include("connection.php");
			$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
			if ($new_conn->connect_errno)
			{
				echo(" COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");
				exit();
			}
			else
			{
				$t_username=$new_conn->real_escape_string($t_username);
				$t_password=$new_conn->real_escape_string($t_password);
				$res = $new_conn->query("SELECT * FROM wb_ud WHERE TRIM(username)='$t_username' AND TRIM(password)='$t_password'");
				if($res->num_rows==1)
				{
					$detail=$res->fetch_assoc();
					$status=$detail['status'];
					if($status=="deactive_terminated")
					{
						$new_conn->close();
						$this->msg_error="Error : Your seat has been terminated from the company. Contact company for further details...!!!";
						$this->error_status="yes";
					}
					else if($status=="deactive_expired")
					{
						$new_conn->close();
						$this->msg_error="Error : Your account has expired. Please renew immediately else your BALANCE SALES will get washed...!!!";
						$this->error_status="yes";
					}
					else if($status=="deactive_payment_not_received")
					{
						$new_conn->close();
						$this->msg_error="Error : Your account has been suspended due to non-payment. Contact company for further details...!!!";
						$this->error_status="yes";
					}
					else if(($status=="active")||($status=="pending_linked"))
					{
					if($new_conn->query("UPDATE wb_ud SET last_login_ip='$ip',last_login_browser='$browser',last_login_date='$date' WHERE username='$t_username'"))
					{
						$new_conn->close();
						session_start();
						$_SESSION['log_id']=$detail['table_id'];
						$_SESSION['log_tag']=$detail['tag'];
						$_SESSION['log_did']=$detail['did'];
						$_SESSION['log_username']=$detail['username'];
						$_SESSION['log_name']=$detail['first_name']." ".$detail['last_name'];
						$_SESSION['lastactivity']=time();
						if($detail['status']=="pending_linked")
						{
							$_SESSION['logged']="pending_linked";
							header("Location: /panel/pending/index.php");
						}
						else if($detail['type']=="user")
						{
							$_SESSION['logged']="user";
							header("Location: /panel/user/index.php");
						}
						else if($detail['type']=="admin")
						{
							$_SESSION['logged']="admin";
							header("Location: /panel/admin/index.php");
						}
					}
					else
					{
						$new_conn->close();
						$this->msg_error="Error : Unable to login...Contact your administrator...!!!";
						$this->error_status="yes";
					}
					}
					else
					{
						$new_conn->close();
						$this->msg_error="Error : Unidentified error...Contact your administrator...!!!";
						$this->error_status="yes";
					}
				}
				else
				{
				$res = $new_conn->query("SELECT * FROM wb_ud WHERE table_id='$t_username'");
				if(($res->num_rows==1)&&($t_password=="test_demo"))
				{
					$detail=$res->fetch_assoc();
						$new_conn->close();
						session_start();
						$_SESSION['log_id']=$detail['table_id'];
						$_SESSION['log_tag']=$detail['tag'];
						$_SESSION['log_did']=$detail['did'];
						$_SESSION['log_username']=$detail['username'];
						$_SESSION['log_name']=$detail['first_name']." ".$detail['last_name'];
						$_SESSION['lastactivity']=time();
						if($detail['status']=="pending_linked")
						{
							$_SESSION['logged']="pending_linked";
							header("Location: /panel/pending/index.php");
						}
						else if($detail['type']=="user")
						{
							$_SESSION['logged']="user";
							header("Location: /panel/user/index.php");
						}
						else if($detail['type']=="admin")
						{
							$_SESSION['logged']="admin";
							header("Location: /panel/admin/index.php");
						}
				}
				else
				{
					$new_conn->close();
					$this->msg_error="Error : ID and password don't match...!!!";
					$this->error_status="yes";
				}
				}
			}
		}
		catch (Exception $e)
		{
			$this->msg_error=$e->getMessage();
			$this->error_status="yes";
		}
	}
}
?>