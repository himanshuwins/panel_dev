<?php
$q=$_POST["q"];
include("../../php_scripts_wb/connection.php");
$new_conn = new mysqli($host_db,$user_db,$pass_db,$name_db);

if ($new_conn->connect_errno)
{
  echo(" COULD NOT CONNECT TO THE SERVER.....TRY AGAIN LATER");   
  exit();
}
else
{
  $sr_res=$new_conn->query("UPDATE wb_epins SET status='issued' WHERE table_id='$q' AND status='issued_inactive'");
  if($new_conn->affected_rows==1)
  {
    $response="ok";
  }
  else
  {
    $response="no";
  }
  $new_conn->close();
}
echo $response;
?>