<?php
session_start();
require "baza_data/baza.inc";


$imie = $_SESSION['imie'];
$nazwisko = $_SESSION['nazwisko'];
$id = $_SESSION['id'];
$status = $_SESSION['status'];
$id_doctors_ = $_SESSION['id_doctors'];

$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo?a po?czy?i?' . mysql_error());
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');

$pacjenci = "select distinct* from Users u1 join Patients p1 using (id_Users) join Treatment t1 using (id_Patients) where t1.id_Doctors=".$id_doctors_;

$pacjenci_rekordy = mysql_query($pacjenci) or die("blad bazy danych1");
$ilosc_rekordow = mysql_num_rows($pacjenci_rekordy);

$id_from_request = $_GET['current_patient'];
$patient_id = $_GET['current_patient_id'];
$current_id = "select id_Research, id_Patients from Research where id_Patients='$patient_id'";
$researches = mysql_query($current_id) or die ("blad bazy danych2");
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


// nowy pacjent 

if(isset($_POST['imie_']) and isset($_POST['nazwisko_'])){
  $imie_nowego = $_POST['imie_'];
  $nazwisko_nowego = $_POST['nazwisko_'];
  $new_user_query = "select* from Users  where imie= '".$imie_nowego."' and nazwisko= '".$nazwisko_nowego. "' and status= '1'";
  $new_user_res = mysql_query($new_user_query) or die('nic z tego');

  if(mysql_num_rows($new_user_res)==0){

  echo "<script>alert('Osoby o podanych danych nie ma w bazie. Spróbuj jeszcze raz');</script>";
  }
  else {
  $array_p = mysql_fetch_array($new_user_res);
  $id_user_  = $array_p['id_Users'];
  
  $query2 = "select id_Patients from Patients where id_Users = ".$id_user_;
  $resource_ = mysql_query($query2);
  $arr1 = mysql_fetch_array($resource_);
  $id_p = $arr1['id_Patients'];
  
  $query1 = "insert into Treatment (id_Patients, id_Doctors) values (".$id_p.",".$id_doctors.");";
  if(isset($id_doctors) and isset($id_p)){
    $res2 = mysql_query($query1);  
	echo"<script>window.location='lista_pacjentow.php';</script>";
    }
  }
}

// kasowanie pacjenta

if(isset($_GET['patient'])){
$id_do_usuniecia = $_GET['patient'];
  $query4 = "delete from Treatment where id_Patients=".$id_do_usuniecia;
  mysql_query($query4);
  	echo"<script>window.location='lista_pacjentow.php';</script>";
}
?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
var lok = "lista_pacjentow.php?current_patient=" + current_id1 + "&current_patient_id=" + current_id2;
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
	if($ilosc_rekordow == 0)
	  echo "<tr><td>brak pacjentów </td><td></td></tr>";
	for($a = 0; $a<$ilosc_rekordow; $a++){

	$tablica_pacjentow = mysql_fetch_array($pacjenci_rekordy);

	$id_patient = $tablica_pacjentow['id_Patients'];
	

	echo "<tr><td> {$tablica_pacjentow['imie']}"."  ".$tablica_pacjentow['nazwisko']." </td><td><a href='lista_pacjentow.php?patient=".$id_patient."'>usuń</a></td></tr> " ;
}
?>

</tbody>
</table>  

</div>


<div id="stylized" style = "float:left;width:295px;margin-left:20px;">

<div style="font-size:11px;font-weight:normal;padding:13px;">Podaj imie i nazwisko pacjenta którego masz zamiar leczyć. Pacjent musi wczesniej zarejestrować się w systemie i być dostępny w bazie.</div>

<form method = "post" action = "lista_pacjentow.php" class = "myform" style="margin-left:-10px; margin-top:5px;">
<label style="margin-left:25px;">Imie pacjenta</label><br/><input  type= "text" name = "imie_" />
<label style="margin-top:40px; margin-left:-155px;">Nazwisko pacjenta</label><br/><br/><input type="text" name = "nazwisko_" style="margin-top:10px;" />
<input type="submit" class="medium blue button1" value="dodaj pacjenta" style="margin-top:15px;"/>


</form>

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
<a class="button" href="kontakt_lekarz.php" ><span><center>kontakt</center></span></a>
<a class="button" href="wyloguj.php" ><span><center>wyloguj</center></span></a>
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