<?php
session_start();
require "baza_data/baza.inc";

$imie = $_SESSION['imie'];
$nazwisko = $_SESSION['nazwisko'];
$id = $_SESSION['id'];
$status = $_SESSION['status'];

$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo?a po?czy?i?' . mysql_error());
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');

$id_doctors_q = "select id_Doctors from Treatment t join Patients p on p.id_Patients = t.id_Patients join Users u on u.id_Users = p.id_Users where u.id_Users=".$id;
$id_doctors_r = mysql_query($id_doctors_q);
$id_doctors_q = mysql_fetch_array($id_doctors_r);
$id_doctors = $id_doctors_q['id_Doctors'];
if($id_doctors==null)
$id_doctors=1;


$id_patient_query = "select id_Patients from Patients where id_Users=".$id;
$id_patient_resource = mysql_query($id_patient_query);
$id_patient_array = mysql_fetch_array($id_patient_resource);
$id_patient = $id_patient_array['id_Patients'];

$research_query = "select id_Research, date_of_add from Research where id_Patients=".$id_patient;
$research_resource = mysql_query($research_query);
 
$num_rows_of_research = mysql_num_rows($research_resource);

$medical_data = "select * from Patients where id_Patients=".$id_patient;
$medical_data_resource = mysql_query($medical_data);

if(mysql_num_rows($medical_data_resource)==1)
	{
		$medical_data_array = mysql_fetch_array($medical_data_resource);// IDDane, GrupaKrwi, Uczuleni, PrzebyteChoroby, ChorobyPrzewlekle, ChorobyWRodzinie, InnePrzeciwskazania, 
	}

$personal_data_query = "select * from Users u join Patients p on (u.id_Users = p.id_Users) where p.id_Patients=".$id_patient;
$personal_data_resource = mysql_query($personal_data_query);

if(mysql_num_rows($personal_data_resource)==1)
	{
		$personal_data_array = mysql_fetch_array($personal_data_resource); // imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia
	}
else	{$personal_data_array['imie']='brak nazwiska';}
//-----------------dane pacjenta ------------------------------------------
$patient_name = $personal_data_array['imie'];
$patient_last_name = $personal_data_array['nazwisko'];
$patient_date_of_born = $personal_data_array['data_urodzenia'];
$patient_place_of_born = $personal_data_array['miejsce_urodzenia'];
$patient_street = $personal_data_array['ulica'];
$patient_zip = $personal_data_array['zip'];
$patient_city = $personal_data_array['miasto'];
$patient_woj = $personal_data_array['wojewodztwo'];
$patient_tel = $personal_data_array['numer_telefonu'];
$patient_email = $personal_data_array['adres_email'];

$patient_blood = $medical_data_array['GrupaKrwi'];
$patient_uczulenia = $medical_data_array['Uczulenia'];
$patient_przebyte_choroby = $medical_data_array['PrzebyteChoroby'];
$patient_choroby_przewlekle = $medical_data_array['ChorobyPrzewlekle'];
$patient_choroby_w_rodzinie = $medical_data_array['ChorobyWRodzinie'];
$patient_przeciwskazania = $medical_data_array['InnePrzeciwskazania'];

// odebranie content z formularza, i wyslanie
if(isset($_POST['adresat']))
  {

  $adresat = $_POST['adresat'];	
  $content = $_POST['content'].$_POST['sender'];
	
	$od  = "From: holter_monitor@monitor.com \r\n";
       $od .= 'MIME-Version: 1.0'."\r\n";
       $od .= 'Content-type: text/html; charset=iso-8859-2'."\r\n";
	  if (mail($adresat, 'List ze strony', $content, $od))
		echo "";
	  else 
		echo "<script>alert('Nie mo¿na wys³aæ wiadomosci. Spróbuj ponownie. ');</script>";

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
function przekieruj(imie, nazwisko, email){
	var lok = "kontakt_pacjent.php?imie=" + imie + "&nazwisko=" + nazwisko + "&email=" + email;
	window.location=lok;
}
function pokaz(element){
	document.getElementById(element).style.visibility='visible';
}
function ukryj(element){
	document.getElementById(element).style.visibility='hidden';
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

<div id="tabela_pacjenci" style="float:left;">
<table id="box-table-a" style="margin-top:40px">
<thead >
<tr><th>Twoje kontakty
</th><th>
<div onmouseover="pokaz('new_file');" nmouseout="ukryj('new_file');" >zarzadzaj</div>
</th></tr>
</thead>
<tbody>

<?php

	// pobieranie danych o lekarzu
	$_doctor_query = "select imie, nazwisko, adres_email from Users u join Doctors d on u.id_Users = d.id_Users where d.id_Doctors=".$id_doctors;	
	$_doctor_resource = mysql_query($_doctor_query);
	$_doctor_array = mysql_fetch_array($_doctor_resource);
	$_imie_lekarza = $_doctor_array['imie'];
	$_nazwisko_lekarza = $_doctor_array['nazwisko'];
	$_email_lekarza = $_doctor_array['adres_email'];

	$_imie_adm = 'Leszek';
	$_nazw_adm = 'Andrukanis';
	$_email_adm = 'jampolam@poczta.onet.pl';

		
		echo "<tr><td><a href='kontakt_pacjent.php?imie=".$_imie_adm."&nazwisko=".$_nazw_adm."&email=".$_email_adm."'>".$_imie_adm." ".$_nazw_adm."</a></td><td>Administrator</td></tr>";
		echo "<tr><td><a href='kontakt_pacjent.php?imie=".$_imie_lekarza."&nazwisko=".$_nazwisko_lekarza."&email=".$_email_lekarza."'>".$_imie_lekarza." ".$_nazwisko_lekarza."</a></td><td>Lekarz</td></tr>";

?>


</tbody>

</table>  

</div>


<div id="tabela_badania">
<table id="box-table-a" style="margin-top:40px">
<thead >
<tr><th>Zapytanie
</th><th></th></tr>
</thead>
<tbody><tr><td>
<form action="kontakt_pacjent.php" method="post">
<?php
	// wyciagamy gety


echo  "<input type='text' name='sender' style='margin:10px 10px 0 0; width:200px;' value='".$_GET['imie'].$_GET['nazwisko'].$_last_name."' name='imie'/>" ;
echo "<input type='text' name='adresat' style='margin:10px 10px 0 0; width:200px;' value='".$_GET['email']."'/>";
echo "<textarea name='content' style='margin:10px 10px 0 0; width:200px;' rows='4' col='4'></textarea>";


?>
</td></tr><tr><td>
<input type="submit" value="Send" class="medium blue button1" style="margin-left:10px; width:100px;"/></form>
</td></tr>


</tbody>
</table>
  
</div>
</div>
    <?php 
$get_photo = "select photo_path from Users where id_Users=".$id;
$photo_resource = mysql_query($get_photo);
$photo_path_array = mysql_fetch_array($photo_resource);
$photo_path = $photo_path_array['photo_path'];

if(mysql_num_rows($photo_resource)!=1 or $photo_path == null){
$photo_path = "upload/upload_photo/universal.jpg";
}


?>
<div id="photo">	 <img src="<?php echo $photo_path; ?>" alt="" width="147" height="196" />


<div id="user_buttons">
<a class="button" href="zmiana_danych.php"><span><center>administracja</center></span></a>
<a class="button" href="index_pacjent.php"><span><center>badania</center></span></a>
<a class="button" href="kontakt_pacjent.php"><span><center>kontakt</center></span></a>
<a class="button" href="wyloguj.php"><span><center>wyloguj</center></span></a>
</div>
</div>

<div id="dane_uzytkownika" style="margin-left:250px; margin-top:10px;">
<br/>

	<?php
		//imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia

 		echo"<b>".$patient_name."</b>"." ";
		echo "<b>".$patient_last_name."</b><br/>";
		echo $patient_date_of_born."<br/>";
		echo $patient_place_of_born."<br/>";
		echo $patient_street."<br/>";
		echo $patient_zip."<br/>";
		echo $patient_city."<br/>";
		echo $patient_woj."<br/>";
		echo $patient_tel."<br/>";
		echo $patient_email."<br/>";
		echo "Grupa krwi <b> ".$patien_blood."</b><br/>";
		echo "Uczulenia<b> ".$patient_uczulenia."</b><br/>";
		echo "Przebyte choroby<b> ".$patient_przebyte_choroby."</b><br/>";
		echo "Choroby przewlekle <b> ".$patient_choroby_przewlekle."</b><br/>";
		echo "Choroby w rodzinie<b> ".$patient_choroby_w_rodzinie."</b><br/>";
		echo "Dodatkowe informacje <b> ".$patient_przeciwskazania."</b><br/>";

	?></div>
    
  <div style="clear: both;">&nbsp;</div>
</div>
<div id="footer">
	<p id="legal">&nbsp;</p>
</div>
<!-- end footer -->
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/">free website templates</a>.</div></body>
</html>