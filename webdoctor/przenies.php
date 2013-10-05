<?php
session_start();

$new_name=$_GET['id_research'];

$new_name =$new_name.'_.txt'; 
rename('raw.txt',$new_name);
echo "<script>window.location='ekg.php';</script>";

?>