<?php
session_start();
require "baza_data/baza.inc";

$imie = $_SESSION['imie'];
$nazwisko = $_SESSION['nazwisko'];
$id = $_SESSION['id'];
$status = $_SESSION['status'];

$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo?a po?czy?i?' . mysql_error());
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');

$pacjenci = "select* from Users u1 join Patients p1 using (id_Users) join Treatment t1 using(id_Patients) join Doctors using (id_Doctors)" ;

$pacjenci_rekordy = mysql_query($pacjenci) or die("blad bazy danych");
$ilosc_rekordow = mysql_num_rows($pacjenci_rekordy);

if($_GET['current_patient_id']!=null)

{
$id_from_request = $_GET['current_patient'];
$patient_id = $_GET['current_patient_id'];
}
else {
$patient_id = 1;
}
$current_id = "select id_Research, id_Patients from Research where id_Patients='$patient_id'";
$researches = mysql_query($current_id) or die ("blad bazy danych");
$num_rows_researches = mysql_num_rows($researches);

$id_doctors_query = "select id_Doctors from Doctors where id_Users =".$id;
$id_doctors_resource = mysql_query($id_doctors_query);
$id_doctors_array= mysql_fetch_array($id_doctors_resource);
$id_doctors = $id_doctors_array['id_Doctors'];

//---------------------------------------------------------------------------------------LEKARZ

$doctor_query = "select*from Doctors d join Users u on (d.id_Users = u.id_Users) where d.id_Doctors=".$id_doctors;
$doctor_resource = mysql_query($doctor_query);
$doctor_array = mysql_fetch_array($doctor_resource);
//-------------------dane lekarza---------------
$doctor_name = $doctor_array['imie'];
$doctor_last_name = $doctor_array['nazwisko'];
$doctor_date_of_b = $doctor_array['data_urodzenia'];
$doctor_specialization = $doctor_array['specialization'];
$doctor_number_of_permission = $doctor_array['number_of_permission'];
$doctor_member_house_of_doctors = $doctor_array['member_house_of_doctors'];
$doctor_nationality = $doctor_array['nationality'];
$doctor_expiry_date_of_permission = $doctor_array['expiry_date_of_permission'];
$doctor_state = $doctor_array['state'];
//-----------------dane pacjenta ------------------------------------------


if(isset($_POST['sender'])){
$adresat = $_POST['adresat'];

	$sender = $_POST['sender'];
	
	$content = $_POST['content'];

	$header = 	"From: admin@holtermonitor.pl \nContent-Type:".
			' text/plain;charset="iso-8859-2"'.
			"\nContent-Transfer-Encoding: 8bit";
	if (mail($adresat, 'List ze strony', $content, $header))
		echo "";
	else 
		echo "<script>alert('Nie mo¿na wys³aæ wiadomoœæi. Spróbuj ponownie. ');</script>";
}
?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
<title>Holter monitor</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
<link href="kontakt.css" rel="stylesheet" type="text/css" />
<link href="lista.css" rel="stylesheet" type="text/css" />
<link href="photo.css" rel="stylesheet" type="text/css" />
<link href="classic_button.css" rel="stylesheet" type="text/css" />
<link href="button_on_input1.css" rel="stylesheet" type="text/css" />

<script>
function przekieruj(current_id1, current_id2){
var lok = "kontakt_lekarz.php?current_patient=" + current_id1 + "&current_patient_id=" + current_id2;
window.location=lok;

}
</script>

</head>
<body>

<div id="wrapper">
<!-- start header -->
<div id="logo">
	<h1><a href="#">Holter monitor </a></h1>
	<h2> &nbsp;&nbsp;&nbsp;Hurtownia danych holterowych</h2>
</div>
<div id="header">
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="#">EKG</a></li>
			<li><a href="#">O projekcie</a></li>
			<li><a href="#">Kontakt</a></li>
			<li><a href="#">Pomoc</a></li>
			<li class="last"><a href="#">Zaloguj</a></li>
		</ul>
	</div>
</div>
<!-- end header -->
</div>
<!-- start page -->
<div id="page">

<div id="content" style="width:500px;">

<div id="tabela_pacjenci">
<table id="box-table-a" style="margin-top:40px">
<thead >
<tr><th>Twoi pacjenci
</th><th></th></tr>
</thead>
<tbody>
<?php

	for($a = 0; $a<$ilosc_rekordow; $a++){

	$tablica_pacjentow = mysql_fetch_array($pacjenci_rekordy);

	$id_patient = $tablica_pacjentow['id_Patients'];
	
	echo "<tr onclick='javascript:przekieruj({$a},{$id_patient})'><td> {$tablica_pacjentow['imie']} {$tablica_pacjentow['nazwisko']} </td><td>.</td></tr> " ;
}


?>

</tbody>
</table>  

</div>


<div id="tabela_badania">
<table id="box-table-a" style="margin-top:40px; margin-bottom:30px;">
<thead >
<tr><th>Zapytanie
</th><th></th></tr>
</thead>
<tbody><tr><td>
<form action="kontakt_lekarz.php" method="post">
<?php
	//$patient_id
$q= "select imie, nazwisko, adres_email from Users u join Patients p on (u.id_Users = p.id_Users) where p.id_Patients =".$patient_id;	
$q1 = mysql_query($q);
$q2 = mysql_fetch_array($q1);
$_name = $q2['imie'];
$_last_name = $q2['nazwisko'];
$adress_email = $q2['adres_email'];

echo  "<input type='text' name='sender' style='margin:10px 10px 0 0; width:200px;' value='".$_name."  ".$_last_name."' name='imie'/>" ;
echo "<input type='text' name='adresat' style='margin:10px 10px 0 0; width:200px;' value='".$adress_email."'/>";
echo "<textarea name='content' style='margin:10px 10px 0 0; width:200px;' rows='4' col='4'></textarea>";


?>
</td></tr><tr><td>
<input type="submit" value="Send" class="medium blue button1" style="margin-left:10px; width:100px;"/></form>
</td></tr>


</tbody>
</table>
  
</div>



</div>
    
<div id="photo">	

<?php 
$get_photo = "select photo_path from Users where id_Users=".$id;
$photo_resource = mysql_query($get_photo);
$photo_path_array = mysql_fetch_array($photo_resource);
$photo_path = $photo_path_array['photo_path'];

if(mysql_num_rows($photo_resource)!=1 or $photo_path==null ){
$photo_path = "upload/upload_photo/universal.jpg";
}

?>
<img src="<?php echo $photo_path; ?>" alt="" width="147" height="196" />

<div id="user_buttons">
<a class="button" href="zmiana_danych_lekarz.php"><span><center>administracja</center></span></a>
<a class="button" href="lista_pacjentow.php"><span><center>pacjenci</center></span></a>
<a class="button" href="index_lekarz.php"><span><center>badania</center></span></a>
<a class="button" href="kontakt_lekarz.php"><span><center>kontakt</center></span></a>
<a class="button" href="wyloguj.php"><span><center>wyloguj</center></span></a>
</div>
</div>

<div id="dane_uzytkownika">

<?php
echo "<b>".$doctor_name."</b>&nbsp";
echo "<b>".$doctor_last_name."</b> <br/>";
echo $doctor_date_of_b."<br/>";
echo $doctor_state." <br/>";
echo $doctor_specialization." <br/>";
echo $doctor_number_of_permission." <br/>";
echo $doctor_member_house_of_doctors." <br/>";
echo $doctor_nationality." <br/>";
echo $doctor_expiry_date_of_permission." <br/>";


?>

</div>
    
  <div style="clear: both;">&nbsp;</div>
</div>




<div id="footer">
	<p id="legal">&nbsp;</p>
</div>
<!-- end footer -->
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/">free website templates</a>.</div></body>
</html>