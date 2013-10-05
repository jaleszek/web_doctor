<?php
require "baza_data/baza.inc";
//require "baza_data/naglowek.inc";


// Odczytywanie z bazy danych
$db = mysql_connect("$serwer", "$login", "$haslo", true) or die('Nie mo¿na po³¹czyæ siê: ' . mysql_error());
mysql_select_db("$baza") or die('Nie mo¿na wybrac bazy danych');





if(isset($_POST["channel"]))
		{
		  echo '<h1>Wyniki analizy EKG</h1>';
		  $zapytanie = "select file_path from Research where id_Research =11";
		  $wynik = mysql_query($zapytanie) or die('B³êdne zapytanie: ' . mysql_error());

		  $row = mysql_fetch_assoc($wynik);

          $analiza = shell_exec("webdoctor200.exe upload/elo.dat 1");

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
		   mysql_free_result($wynik2);

		  foreach($wynik as $row){
		      $index++;
		      $zapytanie="insert into wyniki (IDanaliza,Nrzalamek,QRSklasa,klasa,QRSdetekcja,QRSpoczatek,QRSkoniec,RR,Ppoczatek,Pkoniec,Qpoczatek,Qkoniec,Tpoczatek,Tkoniec) values ('$plik',$index,'$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]') ";

              $wynik = mysql_query($zapytanie) or die('B³êdne zapytanie: ' . mysql_error());

		  }


		  $zapytanie = "select * from uzytkownicy u left join analiza a on u.IDuzytkownika = a.IDuzytkownika where u.IDanaliza =". $_POST['plik_id']."";
		  $wynik = mysql_query($zapytanie) or die('B³êdne zapytanie: ' . mysql_error());
		    $row =mysql_fetch_array($wynik);


		  echo "<p>Pacjent: ".$row['Imie']." ".$row['Nazwisko']."<br>Data badania: ".$linia['Data']." </p>" ;
?>

	   	  <table>
		  <tr>

            <th>Ilosæ za³amków QRS</th>
            <th>Ilosæ klas za³amków QRS</th>
          </tr>
          <tr>

            <td><?php echo $out1[0] ?></td>
            <td><?php echo  $out1[1]?></td>
          </tr>
		  <table/>

               <html></br><br><a href ="index.php?id=27">Analiza QRS</a></html>

             <?php }
                   else{
                       echo '<h1>Analiza EKG</h1>';

                   ?>
                           <form action="analiza_wykresu.php" method= "post">
                     <p><input type="hidden" name="plik_id" value=<?php echo $_GET["plik_id"] ?>></p>
                           <h2>Czêstotliwosæ</h2>

                               <p>

                                   <label><input type="radio" name="fs" value="200" checked="true"/> - 200 Hz</label><br/>



                     <h2>Wybierz kana³</h2>
                       <p>
                          <label for="first"><input type="radio" id="first" name="channel" value="1" checked="checked" /> - 1</label><br/>
                          <label for="second"><input type="radio" id="second" name="channel" value="2"/> - 2</label><br/>
                       <p/>

                             <p><input type="submit" value="Analizuj"></p>
                     <form/>
                 <?php } ?>