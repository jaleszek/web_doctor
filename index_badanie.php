<?php

require "baza_data/baza.inc";


session_start();

$_SESSION['chart_index'] = 1;

$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo?a po?czy?i?' . mysql_error());
mysql_select_db("$baza") or die('Nie mo?a wybrac bazy danych');


$id_Research= $_GET['id_Research'];// input

if(isset($_POST['content'])){

	$content = $_POST['content'];
// odwolania do tabeli przez Research. inaczej nie dziala
	$insert_query = "update Research set Research.opinion=".$content." where Research.id_Research= ".$id_Research;
	mysql_query($insert_query);

}

$patient_query = "select id_Patients, date_of_add , opinion from Research where id_Research =".$id_Research;
$id_Patient_resource = mysql_query($patient_query);
	
if(mysql_num_rows($id_Patient_resource)==1)
	{
		$id_Patient_array = mysql_fetch_array($id_Patient_resource);
		$id_Patient = $id_Patient_array['id_Patients'];
		$date_of_add = $id_Patient_array['date_of_add'];
	}

$medical_data_query = "select * from Patients where id_Patients=".$id_Patient;
$medical_data_resource = mysql_query($medical_data_query);

if(mysql_num_rows($medical_data_resource)==1)
	{
		$medical_data_array = mysql_fetch_array($medical_data_resource);// IDDane, GrupaKrwi, Uczuleni, PrzebyteChoroby, ChorobyPrzewlekle, ChorobyWRodzinie, InnePrzeciwskazania, 
	}

$personal_data_query = "select imie, nazwisko, miasto, zip, ulica data_urodzenia, miejsce_urodzenia
from Users u join Patients p on (u.id_Users = p.id_Users) where p.id_Patients=".$id_Patient;
$personal_data_resource = mysql_query($personal_data_query);

if(mysql_num_rows($personal_data_resource)==1)
	{
		$personal_data_array = mysql_fetch_array($personal_data_resource); // imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia
	}
else	{$personal_data_array['imie']=elo;}

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

<script type="text/javascript" src="js/lightbox2/js/prototype.js"></script>
<script type="text/javascript" src="js/lightbox2/js/lightbox.js"></script>
<script type="text/javascript" src="js/lightbox2/js/scriptaculous.js?load=effects,builder"></script>

<link rel="stylesheet" href="js/lightbox2/css/lightbox.css" type="text/css" media="screen" />

<script type="text/javascript">
function

</script>

<style>
.wyniki td
{
border : 1px solid #B7DDF2;
}
#nawigacja
{
margin: 5px 0 0 10px;
}
.lekarz_prowadzacy
{
width:300px;
height:50px;
float:left;
margin: 15px 40px 0 3px ;
//padding: 5px;
}
.lekarz_prowadzacy a {
margin: 5px 0 0 10px;;
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
  <div id="wykres" style="float:left; width:550px;">
<a href="generator_wykresu.php" rel="lightbox">

<?php 
// sciezka do pliku raw.txt
$kat = "raws/";
$dir = opendir($kat);
while(false!=($file = readdir($dir))){
  $file_name = $id_Research."_.txt";
  if($file == $file_name and is_file($kat.'/'.$file)){ 
    $file_path = $kat."/".$file;
	break;
	}

}
?>
<a href="generator_wykresu.php<?php echo"?file_path=".$file_path;?>" rel="lightbox">
 <img src="generator_wykresu.php<?php echo"?file_path=".$file_path;?>" width="750" rel="lightbox"/>
</a>
  </div>



<div class="rozpoznanie" id="stylized" style="float:left;margin-top:45px;width:450px; padding:5px; font-weight:bold;">

<form id="form" style="margin-top:20px" method="post" name="opinia" action="pdf.php">
<label style="font-size:11px;">Rozpoznanie badania
<span class="small" style="font-size:10px; margin-left:14px; text-align:left;">Podaj rozpoznanie<br/> badania EKG.</span>
</label>
<textarea name="content" id="content" rows="6"
col="8" ><?php echo $id_Patient_array['opinion']; ?></textarea>
<input type="hidden" name="id_research" value="<?php echo $id_Research; ?>" />
<input type="submit" class="medium blue button1" value="zapisz badanie" onclick="document.opinia.action='index_badanie.php<?php 
echo "?id_Research=".$id_Research; ?>'"></input>
<input type="submit" class="medium blue button1" value="generuj PDF" onclick="document.opinia.action='pdf.php<?php echo"?id_Research=".$id_Research; ?>'"></input>
</form>
</div>



</div>
<div id="dane_uzytkownika" style="margin-top:9px;text-align:left;" width="80">
	<br/>

	<?php
		//imie, nazwisko, adres, data_urodzenia, miejsce_urodzenia

 		echo"<b>".$personal_data_array['imie']."</b>";
		echo $personal_data_array['nazwisko']."<br/>";
		echo $personal_data_array['miasto'].$personal_data_array['zip'].$personal_data_array['ulica']."<br/>";
		echo $personal_data_array['data_urodzenia']."<br/>";
		echo $personal_data_array['miejsce_urodzenia']."<br/>";
// IDDane, GrupaKrwi, Uczuleni, PrzebyteChoroby, ChorobyPrzewlekle, ChorobyWRodzinie, InnePrzeciwskazania, 
		echo "grupa krwi: ".$medical_data_array['GrupaKrwi']."<br/>";
		echo "uczulenia: ".$medical_data_array['Uczulenia']."<br/>";
		echo "przebyte choroby: ".$medical_data_array['PrzebyteChoroby']."<br/>";
		echo "choroby przewlekle: ".$medical_data_array['ChorobyPrzewlekle']."<br/>";
		echo "choroby w rodzinie: ".$medical_data_array['ChorobyWRodzinie']."<br/>";
		echo "dodatkowe informacje".$medical_data_array['InnePrzeciwskazania']."<br/>";
		
	
	?>

</div>

<?php
$id_d = "select id_Doctors from Treatment where id_Patients=".$id_Patient;
$res4 = mysql_query($id_d);
$id_doktor_a = mysql_fetch_array($res4);
$id_doktor = $id_doktor_a['id_Doctors'];

$dane_d = "select imie, nazwisko from Users u join Doctors d on (u.id_Users = d.id_Users) where d.id_Doctors=".$id_doktor;
$dane_res = mysql_query($dane_d);
$dane_arr = mysql_fetch_array($dane_res);
$imie_prowadz = $dane_arr['imie'];
$nazwisko_prowadz = $dane_arr['nazwisko'];
// pobieranie warto�ci za�amk�w z tabeli wyniki
$zalamki_q = "select * from wyniki where id_Research=".$id_Research;
$zalamki_r = mysql_query($zalamki_q);
//$zalamki_a = mysql_fetch_array($zalamki_r);
$index = 0;
while(($zalamki_a = mysql_fetch_array($zalamki_r))!=null){

$tab[$index]['Nrzalamek'] = $zalamki_a['Nrzalamek'];
$tab[$index]['Ppoczatek'] = $zalamki_a['Ppoczatek'];
$tab[$index]['Pkoniec'] = $zalamki_a['Pkoniec'];
$tab[$index]['Qpoczatek'] = $zalamki_a['Qpoczatek'];
$tab[$index]['Qkoniec'] = $zalamki_a['Qkoniec'];
$tab[$index]['RR'] = $zalamki_a['RR'];
$tab[$index]['Tpoczatek'] = $zalamki_a['Tpoczatek'];
$tab[$index]['Tkoniec'] = $zalamki_a['Tkoniec'];
$tab[$index]['QRSpoczatek'] = $zalamki_a['QRSpoczatek'];
$tab[$index]['QRSkoniec'] = $zalamki_a['QRSkoniec'];
$tab[$index]['QRSdetekcja'] = $zalamki_a['QRSdetekcja'];
$index++;
}
$licznik = 0;
if(isset($_GET['licznik'])){
  $licznik = $_GET['licznik'];
}
$odcinek_pq = abs($tab[$licznik]['Qkoniec'] - $tab[$licznik]['Ppoczatek']);
$odcinek_st = abs($tab[$licznik]['Tpoczatek'] - $tab[$licznik][QRSkoniec]);
$odstep_pq = abs($odcinek_pq+$tab[$licznik]['Pkoniec']-$tab[$licznik][Ppoczatek]);
$odstep_qt = abs($tab[$licznik]['Tkoniec']-$tab[$licznik]['QRSpoczatek']);

?>
<div id="stylized" style="width:300px; float:right;margin-right:40px; margin-top:10px;">
<table style="font-size:10px;width:300px;" class="wyniki"><thead><tr><th>Badanie:</th><th> <?php echo  $id_Research." ".$date_of_add; ?></th></tr></thead><tbody>
<tr><td>numer zalamka</td><td><?php echo $tab[$licznik]['Nrzalamek']; ?></td></tr>
<tr><td>poczatek P</td><td><?php echo $tab[$licznik]['Ppoczatek']; ?></td></tr>
<tr><td>koniec P</td><td><?php echo $tab[$licznik]['Pkoniec']; ?></td></tr>
<tr><td>poczatek Q</td><td><?php echo $tab[$licznik]['Qpoczatek']; ?></td></tr>
<tr><td>koniec Q</td><td><?php echo $tab[$licznik]['Qkoniec']; ?></td></tr>
<tr><td>RR</td><td><?php echo $tab[$licznik]['RR']; ?></td></tr>
<tr><td>poczatek T</td><td><?php echo $tab[$licznik]['Tpoczatek']; ?></td></tr>
<tr><td>koniec T</td><td><?php echo $tab[$licznik]['Tkoniec']; ?></td></tr>
<tr><td>poczatek QRS</td><td><?php echo $tab[$licznik]['QRSpoczatek']; ?></td></tr>
<tr><td>koniec QRS</td><td><?php echo $tab[$licznik]['QRSkoniec']; ?></td></tr>
<tr><td>detekcja QRS</td><td><?php echo $tab[$licznik]['QRSdetekcja']; ?></td></tr>

<tr
style="<?php if($odcinek_pq < 0.11)
echo"color:blue;";
else echo"color:red;";
?>"
><td>odcinek PQ</td><td><?php echo $odcinek_pq." s"; ?></td></tr> 
<tr style="<?php if($odcinek_st < 0.2)
echo"color:blue;";
else echo"color:red;";
?>"><td >odcinek ST</td><td><?php echo $odcinek_st." s"; ?></td></tr>
<tr
style="<?php if($odstep_pq < 0.2)
echo"color:blue;";
else echo"color:red;";
?>"
><td>odstep PQ</td><td><?php echo $odstep_pq." s"; ?></td></tr>

<tr
style="<?php if($odstep_qt < 0.4)
echo"color:blue;";
else echo"color:red;";
?>"><td>odstep QT</td><td><?php echo $odstep_qt." s" ?></td></tr>
</tbody></table> 

<div id="nawigacja">
<a class="button" href="index_badanie.php?<?php 
$licznikt=$licznik;
$licznikt--;
echo "id_Research=".$id_Research."&licznik=".$licznikt;?>"><span><center>wstecz</center></span></a>

<a class="button" href="index_badanie.php?<?php 
$licznikt1 = $licznik;
$licznikt1++;
echo "id_Research=".$id_Research."&licznik=".$licznikt1;?>"><span><center>dalej</center></span></a>
</div>

</div>
<div id="stylized" class="lekarz_prowadzacy"><span>Lekarz prowadzacy: <?php echo $imie_prowadz.$nazwisko_prowadz; ?></span>
<a class="button"  href="index_lekarz.php"><span><center>badania</center></span></a>
<a class="button"  href="repozytorium.php"><span><center>repozytorium</center></span></a>
</div>

  <div style="clear: both;">&nbsp;</div>
</div>




<div id="footer">
	<p id="legal">&nbsp;</p>
</div>
<!-- end footer -->
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/">free website templates</a>.</div></body>
</html>