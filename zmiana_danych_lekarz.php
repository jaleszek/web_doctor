<?php
session_start();
require "baza_data/baza.inc";

;

$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo?a po?czy?i?' . mysql_error());
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');

// input $id_Doctors
$id_Doctors = $_SESSION['id_doctors'];

$medical_data_query = "select * from Doctors where id_Doctors=".$id_Doctors;
$medical_data_resource = mysql_query($medical_data_query);

$get_user_id_query = "select id_Users from Doctors where Doctors.id_Doctors=".$id_Doctors;
  $get_user_id_resource = mysql_query($get_user_id_query);
  $get_user_id_array = mysql_fetch_array($get_user_id_resource);
  // pobiera id_user dla lekarza 
  $id_user = $get_user_id_array['id_Users'];
// wczytywanie edytowanych danych

if(isset($_POST['street'])){

  

  $insert_new_data_query = "update Users set ulica='".$_POST['street']."' , miejsce_urodzenia='".$_POST['place_of_born']."' , zip='".$_POST['zip']."' , miasto='".$_POST['city']."' , ulica='".$_POST['street']."' ,
  wojewodztwo='".$_POST['woj']."' , numer_telefonu='".$_POST['tel']."' where id_Users=".$id_user;

  mysql_query($insert_new_data_query);

  // wczytywanie nowych danych do tabeli Doctors
  $update_doctors_query = "update Doctors set nationality='".$_POST['nationality']."' , number_of_permission='".$_POST['number_of_permission']."' , serial_of_permission='".$_POST['serial_of_permission']."'
 , number_of_membership='".$_POST['number_of_membership']."' , member_house_of_doctors='".$_POST['member_house_of_doctors']."' ,
  state='".$_POST['state']."' , specialization='".$_POST['specialization']."' , expiry_date_of_permission='".$_POST['expiry_date_of_permission']."' where id_Doctors=".$id_Doctors;
  
  mysql_query($update_doctors_query);
  
  if(isset($_POST['nowe_haslo']) and isset($_POST['stare_haslo'])){
  $check_pass_q = "select * from Users where haslo=".$_POST['stare_haslo']." and id_Users=".$id_user;
  $check_pass_r = mysql_query($check_pass_q);
  if(mysql_num_rows($check_pass_r)!=1)
  echo "<script>alert('Nieprawidlowe haslo, sprobuj jeszcze raz');</script>";
  else{
    $new_pass_q = "update Users set haslo='".$_POST['nowe_haslo']."' where id_Users=".$id_user;
	$new_pass_r = mysql_query($new_pass_q);
	}
}
  }
// wczytywanie zdjecia
if(isset($_FILES['sciezka_do_zdjecia']['name'])){

	$file_size = $_FILES['sciezka_do_zdjecia']['size'];
	$date_of_add = date("Y").'-'.date("m").'-'.date("d");

		if( is_uploaded_file( $_FILES['sciezka_do_zdjecia']['tmp_name'] ) )
			{
  			$strUploadDir = 'upload/upload_photo/' . $_FILES['sciezka_do_zdjecia']['name'];		
				
                              				
				     if( move_uploaded_file( $_FILES['sciezka_do_zdjecia']['tmp_name'], $strUploadDir ) )
  				   {
    					//echo 'Plik zosta� pomy�lnie uploadowany! <br />';
					$update_query1 = "update Users set photo_path='".$strUploadDir."' where id_Users=".$id_user;
					 mysql_query($update_query1);
  				  }
  				else
  					{
    					echo 'Upload pliku nie powiódł się!';
  			}
                   
		}

	}

if(mysql_num_rows($medical_data_resource)==1)
	{
		$medical_data_array = mysql_fetch_array($medical_data_resource);// IDDane, GrupaKrwi, Uczuleni, PrzebyteChoroby, ChorobyPrzewlekle, ChorobyWRodzinie, InnePrzeciwskazania, 
	}


//-------------------------------------------------------------------------
$personal_data_query = "select * from Users u join Doctors d on (u.id_Users = d.id_Users) where d.id_Doctors=".$id_Doctors;
$personal_data_resource = mysql_query($personal_data_query);

if(mysql_num_rows($personal_data_resource)!=0)
	{
		$personal_data_array = mysql_fetch_array($personal_data_resource); // imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia
	}
else	{$personal_data_array['imie']=elo;}
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

//---------------------------------------------------------------------------------------LEKARZ

$doctor_query = "select*from Doctors d join Users u on (d.id_Users = u.id_Users) where d.id_Doctors=".$id_Doctors;
$doctor_resource = mysql_query($doctor_query);
$doctor_array = mysql_fetch_array($doctor_resource);
//-------------------dane lekarza---------------

$doctor_specialization = $doctor_array['specialization'];
$doctor_number_of_permission = $doctor_array['number_of_permission'];
$doctor_serial_of_permission = $doctor_array['serial_of_permission'];
$doctor_member_house_of_doctors = $doctor_array['member_house_of_doctors'];
$doctor_nationality = $doctor_array['nationality'];
$doctor_expiry_date_of_permission = $doctor_array['expiry_date_of_permission'];
$doctor_state = $doctor_array['state'];


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
var lok = "http://student.agh.edu.pl/soska/emporium/index_lekarz.php?current_patient=" + current_id1 + "&current_patient_id=" + current_id2;
window.location=lok;

}
</script>
<style>

.myform label {
	//font-size:12px;
	}
label{
	text-align:justify;
	font-size:11px;
}
</style>
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
<center style="font-size:16px; margin-bottom:30px;">Edycja danych lekarza</center>
  <div id="stylized">
  <form class="myform"  style="margin-left:0px; margin-top:10px;" action="zmiana_danych_lekarz.php" method="post">

    <table>
  	<tr><td><label>Imie
	</label>
	<input type="text" name="name" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_name ;?>" disabled="disabled"/></td>
    <td><label>Nazwisko
	</label>
	<input type="text" name="last_name" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_last_name; ?>" disabled = "disabled"/></td>
    </tr>
    <tr><td><label>Ulica
	</label>
	<input type="text" name="street" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_street; ?>"/></td><td><label>Kod pocztowy
	</label>
	<input type="text" name="zip" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_zip; ?>"/></td></tr>
    <tr><td><label>Miasto
	</label>
	<input type="text" name="city" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_city; ?>" /></td><td><label>Województwo
	</label>
	<input type="text" name="woj" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_woj; ?>"/></td></tr>
    <tr><td><label>Numer telefonu
	</label>
	<input type="text" name="tel" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_tel; ?>"/></td><td><label>Adres email
	</label>
	<input type="text" name="email" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_email; ?>"/></td></tr>
    <tr><td><label>Data urodzenia
	</label>
	<input type="text" name="date_of_born" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_date_of_born; ?>"/></td><td><label>Miejsce urodzenia
	</label>
	<input type="text" name="place_of_born" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $patient_place_of_born; ?>"/></td></tr>
    
    
    <tr><td><label>Narodowość
	</label>
	<input type="text" name="nationality" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_nationality; ?>"/></td><td><label>Numer licencji lekarskiej
	</label>
	<input type="text" name="number_of_permission" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_number_of_permission; ?>" /></td></tr>
    
    <tr><td><label>Seria licencji lekarskiej
	</label>
	<input type="text" name="serial_of_permission" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_serial_of_permission; ?>"/></td><td><label>Numer członka Izby Lekarskiej
	</label>
	<input type="text" name="number_of_membership" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_number_of_membership; ?>" /></td></tr>

    <tr><td><label>Członkostwo w Izbie Lekarskiej
	</label>
	<input type="text" name="member_house_of_doctors" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_member_house_of_doctors; ?>"/></td><td><label>Status lekarski
	</label>
	<input type="text" name="state" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_state; ?>"/></td></tr>

    <tr><td><label>Specjalizacja lekarska
	</label>
	<input type="text" name="specialization" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_specialization; ?>"/></td><td><label>Data licencji
	</label>
	<input type="text" name="expiry_date_of_permission" id="miejsce_urodzenia"  style="width:		     150px;" value="<?php echo $doctor_expiry_date_of_permission; ?>"/></td></tr>
	
	<tr><td><label>Podaj stare haslo
	</label>
	<input type="text" name="stare_haslo" id="stare_haslo"  style="width:		     150px;"/></td><td><label>Nowe haslo
	</label>
	<input type="text" name="nowe_haslo" id="nowe_haslo"  style="width:		     150px;" /></td></tr>
    </table>
	<input type="submit" class="medium blue button1" value="akceptuj zmiany" style="margin:20px 0 0 120px;"/>
</form>
  
  </div>

<div style="margin-top:15px; height:150px;" id="stylized">

<form class="myform" style="margin-left:-20px; margin-top:10px;" action="zmiana_danych_lekarz.php" method = "post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="30000"/>
	<tr><td><label>Dodaj fotografie</label><input type="file" name="sciezka_do_zdjecia"/></td></tr>
	<input type="submit" value="Dodaj" class="medium blue button1" style="margin:0 0 30px 140px"/>
</form>
</div>

</div>
    <?php 
$get_photo = "select photo_path from Users where id_Users=".$id_user;
$photo_resource = mysql_query($get_photo);
$photo_path_array = mysql_fetch_array($photo_resource);


if(mysql_num_rows($photo_resource)!=1){
$photo_path = "upload/upload_photo/universal.jpg";
}
else if(!$photo_resource)
$photo_path='upload/upload_photo/universal.jpg';
else {
$photo_path = $photo_path_array['photo_path'];
}


?>
<div id="photo">	 <img src="<?php echo $photo_path; ?>" alt="" width="147" height="196" />

<div id="user_buttons">
<a class="button" href="zmiana_danych_lekarz.php"><span><center>administracja</center></span></a>
<a class="button" href="lista_pacjentow.php"><span><center>pacjenci</center></span></a>
<a class="button" href="index_lekarz.php"><span><center>badania</center></span></a>
<a class="button" href="kontakt_lekarz.php"><span><center>kontakt</center></span></a>
<a class="button" href="wyloguj.php"><span><center>wyloguj</center></span></a>
</div>
</div>

<div id="dane_uzytkownika" style="margin-top:30px;text-align:left;" width="80">

	<?php
		//imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia

 	echo "<b>".$patient_name."</b>&nbsp";
	echo "<b>".$patient_last_name."</b> <br/>";
	echo $patient_date_of_born."<br/>";
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