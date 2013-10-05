<?php
session_start();
define('FPDF_FONTPATH','font/');

require "baza_data/naglowek.inc";
require "baza_data/baza.inc";
require('pdf/fpdf.php');


// input

$id_doctors = $_SESSION['id_doctors'];
//$id_patient = $_REQUEST['id_Patient'];
$id_Research = $_GET['id_Research'];


$db = mysql_connect("$serwer","$login","$haslo", true) or die('blad');
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');
// ------------------------------------------------------------------------------------PACJENT
$patient_query = "select id_Patients from Research where id_Research =".$id_Research;
$id_Patient_resource = mysql_query($patient_query);
	
if(mysql_num_rows($id_Patient_resource)==1)
	{
		$id_Patient_array = mysql_fetch_array($id_Patient_resource);
		$id_Patient = $id_Patient_array['id_Patients'];
	}

$medical_data_query = "select * from Patients where id_Patients=".$id_Patient;
$medical_data_resource = mysql_query($medical_data_query);

if(mysql_num_rows($medical_data_resource)==1)
	{
		$medical_data_array = mysql_fetch_array($medical_data_resource);// IDDane, GrupaKrwi, Uczuleni, PrzebyteChoroby, ChorobyPrzewlekle, ChorobyWRodzinie, InnePrzeciwskazania, 
	}

$personal_data_query = "select imie, nazwisko, data_urodzenia, miejsce_urodzenia
from Users u join Patients p on (u.id_Users = p.id_Users) where p.id_Patients=".$id_Patient;
$personal_data_resource = mysql_query($personal_data_query);

if(mysql_num_rows($personal_data_resource)==1)
	{
		$personal_data_array = mysql_fetch_array($personal_data_resource); // imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia
	}
else	{$personal_data_array['imie']='brak';}
//-----------------dane pacjenta ------------------------------------------
$patient_name = $personal_data_array['imie'];
$patient_last_name = $personal_data_array['nazwisko'];
//$patient_adress = $personal_data_array['adres'];
$patient_date_of_born = $personal_data_array['data_urodzenia'];

$patient_blood = $medical_data_array['GrupaKrwi'];
$patient_uczulenia = $medical_data_array['Uczulenia'];
$patient_przebyte_choroby = $medical_data_array['PrzebyteChoroby'];
$patient_choroby_przewlekle = $medical_data_array['ChorobyPrzewlekle'];
$patient_choroby_w_rodzinie = $medical_data_array['ChorobyWRodzinie'];
$patient_przeciwskazania = $medical_data_array['InnePrzeciwskazania'];

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
$data = date('j F Y, G:i');

$content = $_POST['content'];

$txt =" 
<html><head>
</head>
<body bgcolor=\"#CCC7AD\">
<div><h2><center>Raport z systemu Holter monitor.</center></h2>
<table><tr><td>
<table border=\"3\"><tr><td><center>Data wykonania raportu: </center></td><td>121212</td></tr><tr>
<td>Data badania:</td><td>".$data."</td></tr>
<tr><td> <h4>Dane pacjenta</h4> </td><td>.</td></tr>
<tr><td>imie nazwisko</td><td>".$patient_name." ".$patient_last_name."</td></tr>
<tr><td>grupa krwi</td><td>".$patient_blood."</td></tr>
<tr><td>uczulenia</td><td>".$patient_uczulenia."</td></tr>
<tr><td>przebyte choroby</td><td>".$patient_przebyte_choroby."</td></tr>
<tr><td>choroby przewlekle</td><td>".$patient_choroby_przewlekle."</td></tr>
<tr><td>choroby w rodzinie</td><td>".$patient_choroby_w_rodzinie."</td></tr>
<tr><td>przeciwskazania</td><td>".$patient_przeciwskazania."</td></tr>
</table>
</td>
<td><table border=\"3\">
<tr><td><h4>Lekarz prowadzacy</h4></td><td></td></tr>
<tr><td>imie i nazwisko</td><td>".$doctor_name." ".$doctor_last_name."</td></tr>
<tr><td>data urodzenia</td><td>".$doctor_date_of_b."</td></tr>
<tr><td>specjalizacja</td><td>".$doctor_specialization."</td></tr>
<tr><td>numer licencji lekarskiej</td><td>".$doctor_number_of_permission."</td></tr>
</table></td>
</tr><tr><td>".$content."</td></tr>
</table>
<img src=\"wykres.jpg\" width=\"880\"/>
</div>
</body></html>";



$file = "pdf_temp.html"; // plik do ktorego zapiszemy informacje do konwersji
$fo = fopen($file,"w");
flock($fo,2);
fwrite($fo,$txt);
flock($fo,3);
fclose($fo);


mysql_close($db);

echo "<script language=\"JavaScript\" type=\"text/javascript\"> location.href=\"generuj_pdf.php\";</script>";

?>