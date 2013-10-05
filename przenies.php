<?php
session_start();

$new_name=$_GET['id_research'];

$new_name =$new_name.'_.txt'; 
rename('raw.txt','raws/'.$new_name);
echo "<script>window.location='index_pacjent.php';</script>";

?>