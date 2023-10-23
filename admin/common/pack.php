<?php
$data = file_get_contents('main_menu.php');
$data = preg_replace('/\s\s+/', ' ', $data);
file_put_contents('main_menu_min.php',$data);
?>