<?php
function parse_downline($new_conn,$to_check,&$downline_array)
{
	$prep="SELECT table_id,fso,sso FROM wb_ud WHERE table_id='$to_check'";
	$res=$new_conn->query($prep);
	if($res->num_rows==1)
	{
		$detail=$res->fetch_assoc();
		$to_return=$detail['table_id'];
		$fso=$detail['fso'];
		$sso=$detail['sso'];
		if($fso!="")
		{
			$downline_array[]=$fso;
			parse_downline($new_conn,$fso,$downline_array);
		}
		if($sso!="")
		{
			$downline_array[]=$sso;
			parse_downline($new_conn,$sso,$downline_array);
		}
		if(($fso=="")&&($sso==""))
		{
			return;
		}
	}
	else
	{
		$new_conn->close();
		echo($to_check." parse_downline");
		exit();
	}
}
?>
<?php
$to_reply="";
if(!empty($_POST))
{
	try
	{
		$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);
		if ($new_conn->connect_errno)
		{
			echo(6);
			exit();
		}
		else
		{
			$res_3=$new_conn->query("SELECT session_no FROM wb_ch ORDER BY created_date DESC LIMIT 0,1");
			if($res_3->num_rows>0)
			{
				$detail_3=$res_3->fetch_assoc();
				$session_no=$detail_3['session_no'];
				$session_no++;
			}
			else
			{
				$session_no=1;
			}
			
			$new_conn->query("START TRANSACTION");
			$new_conn->query("DELETE FROM wb_ha");
			$new_conn->query("UPDATE wb_ud SET tag_upgraded_session='no'");
			$start_id="10028";
			//$start_id="10299";
			$prep="SELECT a.table_id FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE a.table_id>'$start_id' ORDER BY a.table_id DESC";//desc so that below downline tags also counts 
			//$prep="SELECT a.table_id FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE a.table_id='$start_id'";
			//echo($prep);
			$downline_array=array();
			$res_1=$new_conn->query($prep);
			//$sno=1;
			while($detail_1=$res_1->fetch_assoc())
			{
				//echo("<br />SNO:".$sno."<br />");
				//$sno++;
				$to_check=$detail_1['table_id'];
				//echo($to_check."<br />");
				$fso_downline_array=array();
				$sso_downline_array=array();
				$fso_downline_string="";
				$sso_downline_string="";
				$fso_directs=0;
				$sso_directs=0;
				$fso_total_previous=0;
				$sso_total_previous=0;
				$fso_fwd_previous=0;
				$sso_fwd_previous=0;
				$fso_fwd_new=0;
				$sso_fwd_new=0;
				$fso_biggest_tag="";
				$sso_biggest_tag="";
				$fso_tag_no=0;
				$sso_tag_no=0;
				
				$first_trio_only="no";
				
				
				$tag_1="Team Leader";
				$tag_2="Team Manager";
				$tag_3="Manager";
				$tag_4="General Manager";
				$tag_5="Diplomat";
				$tag_6="Team Manager Diplomat";
				$tag_7="Manager Diplomat";
				$tag_8="General Manager Diplomat";
				$tag_9="Ambassador";
				$tag_10="Team Manager Ambassador";
				$tag_11="Manager Ambassador";
				$tag_12="General Manager Ambassador";
				$tag_13="Board of Director";
				
				$res=$new_conn->query("SELECT a.*,b.* FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE a.table_id='$to_check'");
				if($res->num_rows==0)
				{
					$new_conn->rollback();
					$new_conn->close();
					throw new Exception($to_check.",find");
				}
				$detail_main=$res->fetch_assoc();
				$tag=$detail_main['tag'];
				$name=$detail_main['first_name']." ".$detail_main['last_name'];
				$username=$detail_main['username'];
				$city=$detail_main['city'];
				
				$tag_no=0;
				switch($tag)
				{
					case "Executive":$tag_no=0;break;
					case "Team Leader":$tag_no=1;break;
					case "Team Manager":$tag_no=2;break;
					case "Manager":$tag_no=3;break;
					case "General Manager":$tag_no=4;break;
					case "Diplomat":$tag_no=5;break;
					case "Team Manager Diplomat":$tag_no=6;break;
					case "Manager Diplomat":$tag_no=7;break;
					case "General Manager Diplomat":$tag_no=8;break;
					case "Ambassador":$tag_no=9;break;
					case "Team Manager Ambassador":$tag_no=10;break;
					case "Manager Ambassador":$tag_no=11;break;
					case "General Manager Ambassador":$tag_no=12;break;
					case "Board of Director":$tag_no=13;break;
				}
				
				$new_tag=$tag;
				$fso=$detail_main['fso'];
				$sso=$detail_main['sso'];
				$pan=$detail_main['pan'];
				$income_mode=$detail_main['income_mode'];
				$status=$detail_main['status'];
				$income_status=$detail_main['income_status'];
				$fso_total_previous=$detail_main['total_fso'];
				$sso_total_previous=$detail_main['total_sso'];
				$fso_fwd_previous=$detail_main['forward_fso'];
				$sso_fwd_previous=$detail_main['forward_sso'];
				$slab_1_completed=$detail_main['slab_1_completed'];
				$slab_income_given=$detail_main['slab_income_given'];
				if($slab_income_given=="")
				{
					$slab_income_given=0;
				}
				if($fso!="")
				{
					$fso_downline_array[]=$fso;
					parse_downline($new_conn,$fso,$fso_downline_array);
					for($j=0;$j<count($fso_downline_array);$j++)
					{
						if($fso_downline_string=="")
						{
							$fso_downline_string=$fso_downline_array[$j];
						}
						else
						{
							$fso_downline_string.=",".$fso_downline_array[$j];
						}
					}
					$res=$new_conn->query("SELECT COUNT(*) AS total FROM wb_ud WHERE (table_id IN ($fso_downline_string)) AND status='active' AND sponsor_id='$to_check'");
					if($res->num_rows==1)
					{
						$detail=$res->fetch_assoc();
						$fso_directs=$detail['total'];
					}
					
					$prepared="SELECT COUNT(a.table_id) AS total FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE (a.table_id IN ($fso_downline_string)) AND a.status='active' AND b.counted='no'";
					$res_news=$new_conn->query($prepared);
					if($res_news->num_rows==1)
					{
						$detail_news=$res_news->fetch_assoc();
						$fso_fwd_new=$detail_news['total'];
					}
					
					$fso_found_tags=array();
					$res=$new_conn->query("SELECT DISTINCT(tag) FROM wb_ud WHERE table_id IN ($fso_downline_string) AND status='active'");
					while($detail=$res->fetch_assoc())
					{
						$fso_found_tags[]=$detail['tag'];
					}
					if(in_array($tag_13,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_13;
						$fso_tag_no=13;
					}
					else if(in_array($tag_12,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_12;
						$fso_tag_no=12;
					}
					else if(in_array($tag_11,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_11;
						$fso_tag_no=11;
					}
					else if(in_array($tag_10,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_10;
						$fso_tag_no=10;
					}
					else if(in_array($tag_9,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_9;
						$fso_tag_no=9;
					}
					else if(in_array($tag_8,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_8;
						$fso_tag_no=8;
					}
					else if(in_array($tag_7,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_7;
						$fso_tag_no=7;
					}
					else if(in_array($tag_6,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_6;
						$fso_tag_no=6;
					}
					else if(in_array($tag_5,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_5;
						$fso_tag_no=5;
					}
					else if(in_array($tag_4,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_4;
						$fso_tag_no=4;
					}
					else if(in_array($tag_3,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_3;
						$fso_tag_no=3;
					}
					else if(in_array($tag_2,$fso_found_tags))
					{
						$fso_biggest_tag=$tag_2;
						$fso_tag_no=2;
					}
				}
				if($sso!="")
				{
					$sso_downline_array[]=$sso;
					parse_downline($new_conn,$sso,$sso_downline_array);
					for($j=0;$j<count($sso_downline_array);$j++)
					{
						if($sso_downline_string=="")
						{
							$sso_downline_string=$sso_downline_array[$j];
						}
						else
						{
							$sso_downline_string.=",".$sso_downline_array[$j];
						}
					}
					$res=$new_conn->query("SELECT COUNT(*) AS total FROM wb_ud WHERE (table_id IN ($sso_downline_string)) AND status='active' AND sponsor_id='$to_check'");
					if($res->num_rows==1)
					{
						$detail=$res->fetch_assoc();
						$sso_directs=$detail['total'];
					}
					$res=$new_conn->query("SELECT COUNT(a.table_id) AS total FROM wb_ud a INNER JOIN wb_bvd b ON b.user_id=a.table_id WHERE (a.table_id IN ($sso_downline_string)) AND a.status='active' AND b.counted='no'");
					if($res->num_rows==1)
					{
						$detail=$res->fetch_assoc();
						$sso_fwd_new=$detail['total'];
					}
					$sso_found_tags=array();
					$res=$new_conn->query("SELECT DISTINCT(tag) FROM wb_ud WHERE table_id IN ($sso_downline_string) AND status='active'");
					while($detail=$res->fetch_assoc())
					{
						$sso_found_tags[]=$detail['tag'];
					}
					if(in_array($tag_13,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_13;
						$sso_tag_no=13;
					}
					else if(in_array($tag_12,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_12;
						$sso_tag_no=12;
					}
					else if(in_array($tag_11,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_11;
						$sso_tag_no=11;
					}
					else if(in_array($tag_10,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_10;
						$sso_tag_no=10;
					}
					else if(in_array($tag_9,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_9;
						$sso_tag_no=9;
					}
					else if(in_array($tag_8,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_8;
						$sso_tag_no=8;
					}
					else if(in_array($tag_7,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_7;
						$sso_tag_no=7;
					}
					else if(in_array($tag_6,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_6;
						$sso_tag_no=6;
					}
					else if(in_array($tag_5,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_5;
						$sso_tag_no=5;
					}
					else if(in_array($tag_4,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_4;
						$sso_tag_no=4;
					}
					else if(in_array($tag_3,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_3;
						$sso_tag_no=3;
					}
					else if(in_array($tag_2,$sso_found_tags))
					{
						$sso_biggest_tag=$tag_2;
						$sso_tag_no=2;
					}
				}
					$fso_total_new=$fso_total_previous+$fso_fwd_new;
					$sso_total_new=$sso_total_previous+$sso_fwd_new;
				$fso_calculate=$fso_fwd_previous+$fso_fwd_new;
				$sso_calculate=$sso_fwd_previous+$sso_fwd_new;
				/*echo("<br />FSO Directs : ".$fso_directs);
				echo("<br />SSO Directs : ".$sso_directs);*/
				if((($fso!="")||($sso!=""))&&($status=="active"))
				{
					$income=0;					
					$pass_next="yes";
					if($slab_1_completed=="no")
					{
						while($pass_next=="yes")
						{
							if($fso_calculate>=$sso_calculate)
							{
								/*echo("<br />fso_calculate>=sso_calculate");
								echo("<br />fso_calculate_before : ".$fso_calculate);
								echo("<br />sso_calculate_before : ".$sso_calculate);
								echo("<br />slab_income_given : ".$slab_income_given);*/
								switch($slab_income_given)
								{
									case 0:
									case 1:
									case 2: if(($fso_calculate>=2)&&($sso_calculate>=1))
											{
												$income+=2000;
												$fso_calculate-=2;
												$sso_calculate-=1;
												$slab_income_given++;
											}
											if(($slab_income_given==1)&&(($fso_calculate<2)||($sso_calculate<1)))
											{
												$first_trio_only="yes";
											}
											if(($slab_income_given<3)&&(($fso_calculate<2)||($sso_calculate<1)))
											{
													$pass_next="no";
											}
											else if(($slab_income_given>=3)&&(($fso_calculate<6)||($sso_calculate<3)))
											{
													$pass_next="no";
											}
											break;
									case 3:
									case 4:
									case 5:
									case 6: if(($fso_calculate>=6)&&($sso_calculate>=3))
											{
												$income+=3000;
												$fso_calculate-=6;
												$sso_calculate-=3;
												$slab_income_given++;
											}
											if(($slab_income_given<7)&&(($fso_calculate<6)||($sso_calculate<3)))
											{
													$pass_next="no";
											}
											else if(($slab_income_given>=7)&&(($fso_calculate<3)||($sso_calculate<2)))
											{
													$pass_next="no";
											}
											break;
											
									case 7: if(($fso_calculate>=3)&&($sso_calculate>=2))
											{
												$income+=8000;
												$fso_calculate-=3;
												$sso_calculate-=2;
												$slab_income_given=0;
												$slab_1_completed="yes";
											}
											$pass_next="no";
											break;
											
								}
								/*echo("<br />income : ".$income);
								echo("<br />fso_calculate_after : ".$fso_calculate);
								echo("<br />sso_calculate_after : ".$sso_calculate);*/
							}
							else
							{
								/*echo("<br />fso_calculate<sso_calculate");
								echo("<br />fso_calculate_before : ".$fso_calculate);
								echo("<br />sso_calculate_before : ".$sso_calculate);
								echo("<br />slab_income_given : ".$slab_income_given);*/
								switch($slab_income_given)
								{
									case 0:
									case 1:
									case 2: if(($fso_calculate>=1)&&($sso_calculate>=2))
											{
												$income+=2000;
												$fso_calculate-=1;
												$sso_calculate-=2;
												$slab_income_given++;
											}
											if(($slab_income_given<3)&&(($fso_calculate<1)||($sso_calculate<2)))
											{
													$pass_next="no";
											}
											else if(($slab_income_given>=3)&&(($fso_calculate<3)||($sso_calculate<6)))
											{
													$pass_next="no";
											}
											break;
									case 3:
									case 4:
									case 5:
									case 6: if(($fso_calculate>=3)&&($sso_calculate>=6))
											{
												$income+=3000;
												$fso_calculate-=3;
												$sso_calculate-=6;
												$slab_income_given++;
											}
											if(($slab_income_given<7)&&(($fso_calculate<3)||($sso_calculate<6)))
											{
													$pass_next="no";
											}
											else if(($slab_income_given>=7)&&(($fso_calculate<2)||($sso_calculate<3)))
											{
													$pass_next="no";
											}
											break;
											
									case 7: if(($fso_calculate>=2)&&($sso_calculate>=3))
											{
												$income+=8000;
												$fso_calculate-=2;
												$sso_calculate-=3;
												$slab_income_given=0;
												$slab_1_completed="yes";
											}
											$pass_next="no";
											break;
											
								}
								/*echo("<br />income : ".$income);
								echo("<br />fso_calculate_after : ".$fso_calculate);
								echo("<br />sso_calculate_after : ".$sso_calculate);*/
							}
						}
					}
					
					//echo("<br /><br />2nd loop<br /><br />");
					$pass_next="yes";
					if($slab_1_completed=="yes")
					{
						while($pass_next=="yes")
						{
							if($fso_calculate>=$sso_calculate)
							{
								/*echo("<br />fso_calculate>=sso_calculate");
								echo("<br />fso_calculate_before : ".$fso_calculate);
								echo("<br />sso_calculate_before : ".$sso_calculate);
								echo("<br />slab_income_given : ".$slab_income_given);*/
								switch($slab_income_given)
								{
									case 0:
									case 1:
									case 2:
									case 3:
									case 4: if(($fso_calculate>=6)&&($sso_calculate>=3))
											{
												$income+=2500;
												$fso_calculate-=6;
												$sso_calculate-=3;
												$slab_income_given++;
											}
											if(($slab_income_given<=4)&&(($fso_calculate<6)||($sso_calculate<3)))
											{
													$pass_next="no";
											}
											else if(($slab_income_given>4)&&(($fso_calculate<3)||($sso_calculate<2)))
											{
													$pass_next="no";
											}
											break;
											
									case 5: if(($fso_calculate>=3)&&($sso_calculate>=2))
											{
												$income+=7500;
												$fso_calculate-=3;
												$sso_calculate-=2;
												$slab_income_given=0;
											}
											if(($fso_calculate<6)||($sso_calculate<3))
											{
												$pass_next="no";
											}
											break;
											
								}
								/*echo("<br />income : ".$income);
								echo("<br />fso_calculate_after : ".$fso_calculate);
								echo("<br />sso_calculate_after : ".$sso_calculate);*/
							}
							else
							{
								/*echo("<br />fso_calculate<sso_calculate");
								echo("<br />fso_calculate_before : ".$fso_calculate);
								echo("<br />sso_calculate_before : ".$sso_calculate);
								echo("<br />slab_income_given : ".$slab_income_given);*/
								switch($slab_income_given)
								{
									case 0:
									case 1:
									case 2:
									case 3:
									case 4: if(($fso_calculate>=3)&&($sso_calculate>=6))
											{
												$income+=2500;
												$fso_calculate-=3;
												$sso_calculate-=6;
												$slab_income_given++;
											}
											if(($slab_income_given<=4)&&(($fso_calculate<3)||($sso_calculate<6)))
											{
													$pass_next="no";
											}
											else if(($slab_income_given>4)&&(($fso_calculate<2)||($sso_calculate<3)))
											{
													$pass_next="no";
											}
											break;
											
									case 5: if(($fso_calculate>=2)&&($sso_calculate>=3))
											{
												$income+=7500;
												$fso_calculate-=2;
												$sso_calculate-=3;
												$slab_income_given=0;
											}
											if(($fso_calculate<3)||($sso_calculate<6))
											{
												$pass_next="no";
											}
											break;
											
								}
								/*echo("<br />income : ".$income);
								echo("<br />fso_calculate_after : ".$fso_calculate);
								echo("<br />sso_calculate_after : ".$sso_calculate);*/
							}
						}
					}
					/*echo("<br /><br />Out of loop<br /><br />");
					echo("Income : ".$income);
					echo("FSO_calculate:".$fso_calculate);
					echo("SSO_calculate:".$sso_calculate);*/
					if($income>0)
					{
						if(($fso_directs>0)&&($sso_directs>0))
						{
							$tds=0.1*$income;
							$handling_charge=0;
							if($income_mode=="cheque")
							{
								$handling_charge=100;
							}
							$amount_payable=$income-($tds+$handling_charge);
							$payment_status="stopped";
							if(($income_status=="allowed")&&($pan!=""))
							{
								$payment_status="pending";
							}
							
							if($first_trio_only=="yes")
							{
								$payment_status="pending";
								$amount_payable=$income;
								$tds=0;
								$handling_charge=0;
							}
							
							if($new_conn->query("INSERT INTO wb_ch(session_no,id,total_amount,tds,handling_charge,amount_payable,payment_status,created_by,created_ip,created_browser) VALUES('$session_no','$to_check','$income','$tds','$handling_charge','$amount_payable','$payment_status','admin','{$_SERVER['REMOTE_ADDR']}','{$_SERVER['HTTP_USER_AGENT']}')"))
							{
							}
							else
							{
								$new_conn->rollback();
								$new_conn->close();
								throw new Exception($to_check.",income");
							}
							
							if($income>=5000)
							{
								if($new_conn->query("INSERT INTO wb_ha(name,username,income,city) VALUES('$name','$username','$income','$city')"))
								{
								}
								else
								{
									$new_conn->rollback();
									$new_conn->close();
									throw new Exception($to_check.",highest achiever");
								}
							}
						}
					}
					
					
					if(($fso_tag_no>1)&&($sso_tag_no>1))
					{
						if($fso_tag_no>$sso_tag_no)
						{
							$new_tag_no=$sso_tag_no;
						}
						else if($fso_tag_no<$sso_tag_no)
						{
							$new_tag_no=$fso_tag_no;
						}
						else if($fso_tag_no==$sso_tag_no)
						{
							$new_tag_no=$fso_tag_no+1;
						}
						if($new_tag_no>$tag_no)
						{
							switch($new_tag_no)
							{
							case 2:$new_tag="Team Manager";break;
							case 3:$new_tag="Manager";break;
							case 4:$new_tag="General Manager";break;
							case 5:$new_tag="Diplomat";break;
							case 6:$new_tag="Team Manager Diplomat";break;
							case 7:$new_tag="Manager Diplomat";break;
							case 8:$new_tag="General Manager Diplomat";break;
							case 9:$new_tag="Ambassador";break;
							case 10:$new_tag="Team Manager Ambassador";break;
							case 11:$new_tag="Manager Ambassador";break;
							case 12:$new_tag="General Manager Ambassador";break;
							case 13:$new_tag="Board of Director";break;
							}
							if($tag!=$new_tag)
							{
								$new_conn->query("UPDATE wb_ud SET tag='$new_tag',tag_upgraded_session='yes' WHERE table_id='$to_check'");
							}
						}
					}
					else if($tag=="Executive")
					{
						if((($fso_total_new>=17)&&($sso_total_new>=33))||(($fso_total_new>=33)&&($sso_total_new>=17))||(($fso_total_new>=20)&&($sso_total_new>=30))||(($fso_total_new>=30)&&($sso_total_new>=20))||(($fso_total_new>=24)&&($sso_total_new>=26))||(($fso_total_new>=26)&&($sso_total_new>=24)))
						{
							$new_conn->query("UPDATE wb_ud SET tag='Team Manager',tag_upgraded_session='yes' WHERE table_id='$to_check'");
						}
					}
				}// fso and sso !=""
				$fso_fwd_untouched=$fso_fwd_new+$fso_fwd_previous;
				$sso_fwd_untouched=$sso_fwd_new+$sso_fwd_previous;
				if($status=="active")
				{
					$new_conn->query("UPDATE wb_bvd SET total_fso='$fso_total_new',total_sso='$sso_total_new',forward_fso='$fso_calculate',forward_sso='$sso_calculate',slab_1_completed='$slab_1_completed',slab_income_given='$slab_income_given' WHERE user_id='$to_check'");
				}
				else
				{
					$new_conn->query("UPDATE wb_bvd SET total_fso='$fso_total_new',total_sso='$sso_total_new',forward_fso='$fso_fwd_untouched',forward_sso='$sso_fwd_untouched' WHERE user_id='$to_check'");
				}
					//exit();
			}// main while loop
			
			$new_conn->query("UPDATE wb_bvd SET counted='yes'");
			$new_conn->commit();
			$new_conn->close();
		}
		$to_reply="ok";
	}
	catch (Exception $e)
	{
		$to_reply=$e->getMessage();
	}
}
?>