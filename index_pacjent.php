<?php
session_start();
require "baza_data/baza.inc";




$imie = $_SESSION['imie'];
$nazwisko = $_SESSION['nazwisko'];
$id = $_SESSION['id'];
$status = $_SESSION['status'];


//api $id_patient
$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo?a po?czy?i?' . mysql_error());
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');

$id_patient_query = "select id_Patients from Patients where id_Users=".$id;
$id_patient_resource = mysql_query($id_patient_query);
$id_patient_array = mysql_fetch_array($id_patient_resource);
$id_patient = $id_patient_array['id_Patients'];

$_SESSION['id_Patients'] = $id_patient;

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

<script>
function przekieruj(current_id1, current_id2){
	var lok = "http://student.agh.edu.pl/soska/emporium/index_lekarz.php?current_patient=" + current_id1 + "&current_patient_id=" + current_id2;
	window.location=lok;
}
function pokaz(element){
	document.getElementById(element).style.visibility='visible';
}
function ukryj(element){
	document.getElementById(element).style.visibility='hidden';
}
function przekieruj_badanie(badanie_id){
var lok = "index_badanie_pacjent.php?id_Research=" + badanie_id;
window.location = lok;
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
<tr><th>Twoje badania
</th><th>
<div onmouseover="pokaz('new_file');" nmouseout="ukryj('new_file');" >Dodaj</div>
</th></tr>
</thead>
<tbody>
<?php

	for($a = 0; $a<$num_rows_of_research; $a++){

	$research_array = mysql_fetch_array($research_resource);
	$research_id = $research_array['id_Research'];
	$research_date = $research_array['date_of_add'];
	
	echo "<tr><td onclick='javascript:przekieruj_badanie({$research_id})'> {$research_id} <b style='margin-left:50px;'>{$research_date}</b> </td><td><a href='index_pacjent.php?id_r={$research_id}'>skasuj</a></td></tr> " ;
}
// kasowanie badania
if(isset($_GET['id_r'])){
  $id_r_to_delete = $_GET['id_r'];
  $delete_q = "delete from Research where id_Research=".$id_r_to_delete;
  mysql_query($delete_q);
  echo "<script>window.location='index_pacjent.php';</script>";
}
?>
<div><tr><td id="new_file" style="visibility:hidden">

<form enctype="multipart/form-data" action="index_pacjent.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
  <input name="userfile" type="file" />
  <input type="submit" value="wyslij badanie" />

</form></td><td id="new_file" style="visibility:hidden"></td></tr></div>
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
<div >
<div id="photo">	 <img src="<?php echo $photo_path; ?>" alt="" width="147" height="196" />


<div id="user_buttons">
<a class="button" href="zmiana_danych.php"><span><center>administracja</center></span></a>
<a class="button" href="index_pacjent.php"><span><center>badania</center></span></a>
<a class="button" href="kontakt_pacjent.php"><span><center>kontakt</center></span></a>
<a class="button" href="wyloguj.php"><span><center>wyloguj</center></span></a>
</div>
</div>

<div id="dane_uzytkownika" style="width:250px; margin:30px 40px 0 0; float:right; height:250px; clear:right;">
<br/>

	<?php
		//imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia

 		echo"<b>".$patient_name."</b>"." ";
		echo $patient_last_name."<br/>";
		echo $patient_date_of_born."<br/>";
		echo $patient_place_of_born."<br/>";
		echo $patient_street."<br/>";
		echo $patient_zip."<br/>";
		echo $patient_city."<br/>";
		echo $patient_woj."<br/>";
		echo $patient_tel."<br/>";
		echo $patient_email."<br/>";
		echo "Grupa krwi <b> ".$patient_blood."</b><br/>";
		echo "Uczulenia<b> ".$patient_uczulenia."</b><br/>";
		echo "Przebyte choroby<b> ".$patient_przebyte_choroby."</b><br/>";
		echo "Choroby przewlekle <b> ".$patient_choroby_przewlekle."</b><br/>";
		echo "Choroby w rodzinie<b> ".$patient_choroby_w_rodzinie."</b><br/>";
		echo "Dodatkowe informacje <b> ".$patient_przeciwskazania."</b><br/>";

	?></div>
	</div>
    
  <div style="clear: both;">&nbsp;</div>
</div>

<?php
$file_size = $_FILES['userfile']['size'];
$date_of_add = date("Y").'-'.date("m").'-'.date("d")." ".date("G").":".date("i").":".date("s");
if( is_uploaded_file( $_FILES['userfile']['tmp_name'] ) )
{
  $strUploadDir = 'upload/' . $_FILES['userfile']['name'];
  if( move_uploaded_file( $_FILES['userfile']['tmp_name'], $strUploadDir ) )
  {
    //echo 'Plik zosta³ pomyœlnie uploadowany! <br />';
	

	
	
	
	$insert_query = "insert into Research (id_Patients, file_path, file_size, date_of_add)
	values ('$id_patient', '$strUploadDir', '$file_size', '$date_of_add')";
	$insert_research = mysql_query($insert_query);
	
	
	$select_id_research_q = "select id_Research from Research where file_path='".$strUploadDir."' limit 1;";
	$select_id_research_r = mysql_query($select_id_research_q);
	$select_id_research_a = mysql_fetch_array($select_id_research_r);
	$select_id_research = $select_id_research_a['id_Research'];
	
			  $plik = $strUploadDir;
			  
          $analiza = shell_exec("webdoctor200.exe ".$plik." 1");

          $out1 = explode(":", $analiza);


	      $pos[0] = strpos($out1[2], ';',0);
		  $out2 = explode(":", $out1[2]);
         
		  $substracted[0] = substr($out1[2],0,$pos[0]);


		  for ($i = 1; $i < substr_count($out1[2], ';'); $i++){
		     $pos[$i] = strpos($out1[2], ';',($pos[$i-1]+1));
		     $substracted[$i] = substr($out1[2],$pos[$i-1]+1,$pos[$i] - $pos[$i-1]-1);

		  }

          $wynik2 = array_chunk($substracted,12);
		
          $index = 0;
		 //  mysql_free_result($wynik2);
		foreach($wynik2 as $row){
		      $index++;
		      $zapytanie="insert into wyniki (id_Research,Nrzalamek,QRSklasa,klasa,QRSdetekcja,QRSpoczatek,QRSkoniec,RR,Ppoczatek,Pkoniec,Qpoczatek,Qkoniec,Tpoczatek,Tkoniec) values ('$select_id_research',$index,'$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]') ";

              $wynik = mysql_query($zapytanie);

		  }
		  
  echo "<script>window.location = 'przenies.php?id_research={$select_id_research}';</script>";
	//echo "<script>alert('Plik zostal pomyslnie zuploadowany.');</script>";

  }
  else
  {
    echo "<script>alert('Niepowodzenie w ³adowaniu pliku.');</script>";
  }

}

?>




<div id="footer">
	<p id="legal">&nbsp;</p>
</div>
<!-- end footer -->
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/">free website templates</a>.</div></body>
</html>