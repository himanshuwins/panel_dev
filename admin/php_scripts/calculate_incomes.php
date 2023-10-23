<?php

$new_conn= new mysqli($host_db,$user_db,$pass_db,$name_db);
if ($new_conn->connect_errno)
{
  echo(" COULD NOT CONNECT TO THE ASPIRE RETAILTECH SERVER.....TRY AGAIN LATER");
  exit();
}
else
{
  $notupdatedids="";
  $resss=$new_conn->query("SELECT rs_imml,rs_immr FROM sr_draw_chart WHERE rs_uid='$diplomatuid'");
  $detailll=$resss->fetch_assoc();
  $new_conn->query("START TRANSACTION");
  try
  {
  closesession($diplomatuid,$new_conn,$notupdatedids);
  $immlefttt=$detailll['rs_imml'];
  $immrighttt=$detailll['rs_immr'];
  traverseall($immlefttt,$new_conn,$notupdatedids);
  traverseall($immrighttt,$new_conn,$notupdatedids);
  echo("Error ids:".$notupdatedids);
  $new_conn->commit();
  }
  catch(Exception $e)
  {
       $new_conn->rollback();
  }
}
function traverse_downline($tempid,&$new_conn,&$thissession)
{
  if($tempid==NULL)
  {
  return false;
  }
  else if($resbv=$new_conn->query("SELECT rs_selfthisweek FROM sr_bvdetails WHERE rs_uid='$tempid'"))
  {
    if($resbv->num_rows==1)
    {
      $detailbv=$resbv->fetch_assoc();
	  $thisweekthisid=$detailbv['rs_selfthisweek'];
	  $thissession=$thissession+$thisweekthisid;
	  $res=$new_conn->query("SELECT rs_imml,rs_immr FROM sr_draw_chart WHERE rs_uid='$tempid'");
	  $detail=$res->fetch_assoc();
	  $imm_l=$detail['rs_imml'];
	  $imm_r=$detail['rs_immr'];
	  traverse_downline($imm_l,$new_conn,$thissession);
	  traverse_downline($imm_r,$new_conn,$thissession);
	  return $thissession;
	}
  }
}
function traverseall($tempid,&$new_conn,&$notupdatedids)
{
  if($tempid==NULL)
  {
    return false;
  }
  else
  {
    closesession($tempid,$new_conn,$notupdatedids);
    $resall=$new_conn->query("SELECT rs_imml,rs_immr FROM sr_draw_chart WHERE rs_uid='$tempid'");
    if($resall->num_rows==1)
	{
      $detailall=$resall->fetch_assoc();
	  $imm_l=$detailall['rs_imml'];
	  $imm_r=$detailall['rs_immr'];
	  traverseall($imm_l,$new_conn,$notupdatedids);
	  traverseall($imm_r,$new_conn,$notupdatedids);
	}
	else
	{
	  return false;
	}
  }
}
function closesession($tempuid,&$new_conn,&$notupdatedids)
{
  
    $reschart=$new_conn->query("SELECT rs_imml,rs_immr FROM sr_draw_chart WHERE rs_uid='$tempuid'");
	if($reschart->num_rows==1)
	{
    	  $detailchart=$reschart->fetch_assoc();
	      $immleft=$detailchart['rs_imml'];
	      $immright=$detailchart['rs_immr'];
	      $thissession=0;
	      if($immleft==NULL)
	      {
	          $thissessionleft=0;
	      }
	      else
	      {
	          $thissessionleft=traverse_downline($immleft,$new_conn,$thissession);
	      }
	      $thissession=0;
	      if($immright==NULL)
	      {
	          $thissessionright=0;
	      }
	      else
	      {
	          $thissessionright=traverse_downline($immright,$new_conn,$thissession);
	      }
	}
	else
	{
	      $msg1="exception1";
	      throw new Exception('ERROR');
	}
	$bvres=$new_conn->query("SELECT * FROM sr_bvdetails WHERE rs_uid='$tempuid'");
	if($bvres->num_rows==1)
	{
		  $bvdetail=$bvres->fetch_assoc();
		  $totalleft=$bvdetail['rs_totalbvfro'];
		  $totalright=$bvdetail['rs_totalbvsro'];
		  $forwardleft=$bvdetail['rs_forwardfro'];
		  $forwardright=$bvdetail['rs_forwardsro'];
		  $trio=$bvdetail['rs_trio'];
		  $selfbv=$bvdetail['rs_selfthisweek'];
		  $totalselfbv=$bvdetail['rs_selftotalbv'];
		  $typeofuser=$bvdetail['rs_type'];
		  $targetphase=$bvdetail['rs_targetphase'];
		  $arttag=$bvdetail['rs_arttag'];
		  //echo("<br>Total Left previous:".$totalleft);
		  //echo("<br>Total Right:".$totalright);
		  //start updation
		  //$totalselfbv=$totalselfbv+$selfbv;
		  $totalleft=$totalleft+$thissessionleft;
		  //echo("<br>Total Left this session:".$totalleft);
		  $totalright=$totalright+$thissessionright;
		  //echo("<br>Total Right this session:".$totalright);
		  //echo("<br>Forward left:".$forwardleft);
		  //echo("<br>Forward Right:".$forwardright);
		  $forwardleft=$forwardleft+$thissessionleft;
		  $forwardright=$forwardright+$thissessionright;
		  //echo("<br>Forward left this session:".$forwardleft);
		  //echo("<br>Forward Right this session:".$forwardright);
		  /*if($typeofuser=="distributor")
		  {*/
		  /*}
		  else
		  {
		  }*/
		  /*if($typeofuser=="distributor")
		  {*/
		    //selfbv update in forwards
		  if(($typeofuser=="privileged")&&($totalselfbv>=30))
		  {
			if($forwardleft<=$forwardright)
			{
			  $forwardleft=$forwardleft+$selfbv;
			}
			else
			{
			  $forwardright=$forwardright+$selfbv;
			}
		  }
          $totalselfbv=$totalselfbv+$selfbv;
		    $income=0;
		    $income1=0;
		    $income2=0;
		    $pairs=0;
			$changetrio="no";
		    $basicincome=0;
		    //check for 1st trio
			if($targetphase=="fourth")
			{
			if($trio=="false")
		    {
		       if($forwardleft>=$forwardright)
			   {
			      if(($forwardleft>=100)&&($forwardright>=50))
				  {
				     $trio="true";
					 $changetrio="yes";
					 $income1=500;
					 $trioleft=100;
					 $trioright=50;
				     $forwardleft=$forwardleft-100;
				     $forwardright=$forwardright-50;
				  }
			   }
			   else
			   {
			      if(($forwardleft>=50)&&($forwardright>=100))
				  {
				     $trio="true";
					 $changetrio="yes";
					 $income1=500;
					 $trioleft=50;
					 $trioright=100;
				     $forwardleft=$forwardleft-50;
				     $forwardright=$forwardright-100;
				  }
			   }
		    }
			}
			else if(($targetphase=="first")||($targetphase=="second")||($targetphase=="third"))
			{
		    if($trio=="false")
		    {
		       if($forwardleft>=$forwardright)
			   {
			      if(($forwardleft>=200)&&($forwardright>=100))
				  {
				     $trio="true";
					 $changetrio="yes";
					 if(($targetphase=="first")||($targetphase=="second"))
					 {
				       $income1=500;
					 }
					 else
					 {
					   $income1=1000;
					 }
					 $trioleft=200;
					 $trioright=100;
				     $forwardleft=$forwardleft-200;
				     $forwardright=$forwardright-100;
				  }
			   }
			   else
			   {
			      if(($forwardleft>=100)&&($forwardright>=200))
				  {
				     $trio="true";
					 $changetrio="yes";
				     if(($targetphase=="first")||($targetphase=="second"))
					 {
				       $income1=500;
					 }
					 else
					 {
					   $income1=1000;
					 }
					 $trioleft=100;
					 $trioright=200;
				     $forwardleft=$forwardleft-100;
				     $forwardright=$forwardright-200;
				  }
			   }
		    }
			}
		    //now binary income
		    if($trio=="true")
		    {
		      if(($forwardleft>=50)&&($forwardright>=50))
		      {
		        if($forwardleft<=$forwardright)
		        {
		          $pairs=intval($forwardleft/50);
                  if(($tempuid=="10004")||($tempuid=="10007")||($tempuid=="10009")||($tempuid=="10010")||($tempuid=="10132"))
                  {
                    $income2=($pairs*500);
		          }
                  else
                  {
		            $income2=($pairs*300);
                  }
                  $pairs=$pairs*50;
		          $forwardleft=$forwardleft-$pairs;
				  $forwardright=$forwardright-$pairs;
		        }
			    else
		        {
		          $pairs=intval($forwardright/50);
		          if(($tempuid=="10004")||($tempuid=="10007")||($tempuid=="10009")||($tempuid=="10010")||($tempuid=="10132"))
                  {
                    $income2=($pairs*500);
    	          }
                  else
                  {
		            $income2=($pairs*300);
                  }
				  $pairs=$pairs*50;
		          $forwardleft=$forwardleft-$pairs;
				  $forwardright=$forwardright-$pairs;
		        }
		      }
		    }
			$basicincome=$income1+$income2;
			$tds=$basicincome*0.1;
			$handlingcharge=intval($basicincome*0.05);
			$income=$basicincome-($tds+$handlingcharge);
			/* old formula before phase 4 was launched
			if($income1==1000)
			{
			  $tds=$basicincome*0.1;
		      $incomeaftertds=$basicincome-$tds;
	          $income=$incomeaftertds-$handlingcharge;
			}
			else
			{
			  if($income2>0)
			  {
			    $tds=$income2*0.1;
			    $incomeaftertds=$income2-$tds;
			    $incomeaftertds=$incomeaftertds-$handlingcharge;
			    $income=$income1+$incomeaftertds;
			  }
			  else
			  {
			    $income=$income1;
				$tds=0;
				$handlingcharge=0;
			  }
			}*/
			if($changetrio=="no")
			{
			  $pairsleft=$pairs;
			  $pairsright=$pairs;
			}
			else if($changetrio=="yes")
			{
			  $pairsleft=$pairs+$trioleft;
			  $pairsright=$pairs+$trioright;
			}
			
			//update tag
			if(($totalleft>=10000000 && $totalright>=10000100)||($totalleft>=10000100 && $totalright>=10000000))
			{
			  $arttag="monarch";
			}
			else if(($totalleft>=5000000 && $totalright>=5000100)||($totalleft>=5000100 && $totalright>=5000000))
			{
			 $arttag="blue diamond diplomat";
			}
			else if(($totalleft>=2500000 && $totalright>=2500100)||($totalleft>=2500100 && $totalright>=2500000))
			{
			 $arttag="diplomat";
			}
			else if(($totalleft>=1000000 && $totalright>=1000100)||($totalleft>=1000100 && $totalright>=1000000))
			{
			 $arttag="blue diamond";
			}
			else if(($totalleft>=500000 && $totalright>=500100)||($totalleft>=500100 && $totalright>=500000))
			{
			 $arttag="diamond";
			}
			else if(($totalleft>=250000 && $totalright>=250100)||($totalleft>=250100 && $totalright>=250000))
			{
			 $arttag="platinum";
			}
			else if(($totalleft>=100000 && $totalright>=100100)||($totalleft>=100100 && $totalright>=100000))
			{
			 $arttag="sapphire";
			}
			else if(($totalleft>=50000 && $totalright>=50100)||($totalleft>=50100 && $totalright>=50000))
			{
			 $arttag="gold";
			}
			else if(($totalleft>=25000 && $totalright>=25100)||($totalleft>=25100 && $totalright>=25000))
			{
			 $arttag="emerald";
			}
			else if(($totalleft>=10000 && $totalright>=10100)||($totalleft>=10100 && $totalright>=10000))
			{
			 $arttag="ruby";
			}
			else if(($totalleft>=5000 && $totalright>=5100)||($totalleft>=5100 && $totalright>=5000))
			{
			 $arttag="pearl";
			}
			else if(($totalleft>=2500 && $totalright>=2600)||($totalleft>=2600 && $totalright>=2500))
			{
			 $arttag="silver";
			}
			
		    //update cheque table
		    if($income>0)
		    {
              global $sessnumber;
		      if($new_conn->query("INSERT INTO sr_chequesissued(rs_uid,rs_sessionnumber,rs_income,rs_tds,rs_handlingcharge,rs_netincome) VALUES ('$tempuid','$sessnumber','$basicincome','$tds','$handlingcharge','$income')"))
		      {
		      echo("<br>cheque generated:".$tempuid);
		      }
		      else
	          {
	            $msg1="exception3";
	            throw new Exception('ERROR');
	          }
		    }
			if($new_conn->query("UPDATE sr_bvdetails SET rs_totalbvfro='$totalleft',rs_totalbvsro='$totalright',rs_lastweekfro='$pairsleft',rs_lastweeksro='$pairsright',rs_forwardfro='$forwardleft',rs_forwardsro='$forwardright',rs_trio='$trio',rs_lastsessioncheque='$income',rs_selftotalbv='$totalselfbv',rs_selfthisweek='0',rs_arttag='$arttag' WHERE rs_uid='$tempuid'"))
		    {
		    echo("<br>ID updated in bv:".$tempuid);
		    }
		    else
	        {
	          $msg1="exception3";
	          throw new Exception('ERROR');
	        }
	      //}//end of typeofuser=distributor
		  /*else
		  {
		    if($new_conn->query("UPDATE sr_bvdetails SET rs_totalbvfro='$totalleft',rs_totalbvsro='$totalright',rs_lastweek='0',rs_forwardfro='$forwardleft',rs_forwardsro='$forwardright',rs_lastsessioncheque='0',rs_selftotalbv='$totalselfbv',rs_selfthisweek='0' WHERE rs_uid='$tempuid'"))
		    {
		    //echo("<br>ID updated in bv:".$tempuid);
		    }
		    else
	        {
	          $msg1="exception3";
	          throw new Exception('ERROR');
	        }
		  }*/
	}
	else
	{
	    $msg1="exception2";
	    throw new Exception('ERROR');
	}
}
?>