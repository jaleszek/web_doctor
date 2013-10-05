<?php
require "baza_data/baza.inc";



// Odczytywanie z bazy danych
$db = mysql_connect("$serwer", "$login", "$haslo", true) or die('Nie mo¿na po³¹czyæ siê: ' . mysql_error());
mysql_select_db("$baza") or die('Nie mo¿na wybrac bazy danych');






		
		/*  echo '<h1>Wyniki analizy EKG</h1>';
		  $zapytanie = "select Plik from analiza where IDanaliza =". $_POST['plik_id'].";";
		  $wynik = mysql_query($zapytanie) or die('B³êdne zapytanie: ' . mysql_error());
*/
		 
		  $plik = "3.dat";
          $analiza = shell_exec("webdoctor200.exe ".$plik." "."1");

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
		      $zapytanie="insert into wyniki (id_Research,Nrzalamek,QRSklasa,klasa,QRSdetekcja,QRSpoczatek,QRSkoniec,RR,Ppoczatek,Pkoniec,Qpoczatek,Qkoniec,Tpoczatek,Tkoniec) values ('$plik',$index,'$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]') ";

              $wynik = mysql_query($zapytanie) ;

		  }
		  
echo "<script>window.location = 'przenies.php?id_research=". id_research."';</script>";

?>

           
                 