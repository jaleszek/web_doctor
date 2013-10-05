

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Holter monitor/title>
<meta name="keywords" content="" />
<meta name="description" content="" />

<link href="default.css" rel="stylesheet" type="text/css" />
<link href="kontakt.css" rel="stylesheet" type="text/css" />
<link href="button_on_input.css" rel="stylesheet" type="text/css"/>
<link href="msg_.css" rel="stylesheet" type="text/css"/>

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
	<!-- start content -->
	<div id="content" style="margin-bottom:-60px">
		<div class="post">
			
			<div class="entry">
				
			</div>
			<div class="meta">
				<p class="links"><a href="#" class="more"></a> <b>|</b> <a href="#" class="comments"></a></p>
			</div>
		</div>
		<div class="post">
			<h2 class="title"></h2>
			<div class="entry">
				
			</div>
			<div class="meta">
				<p class="links"><a href="#" class="more"></a> <b>|</b> <a href="#" class="comments"></a></p>
			</div>
		</div>
		</div>
		
		<div id="stylized" class="myform" style="margin-bottom:-70px;margin-top:70px;">
		<div style="margin-top:10px">
		
		<?php
		require "baza_data/baza.inc";
		

		$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo¿na po³¹czyæ siê: ' . mysql_error());
		mysql_select_db("$baza") or die('Nie mo¿na wybrac bazy danych');

		$kod = $_REQUEST['kod'];
		$id = $_REQUEST['id'];
		
		$rows =mysql_num_rows(mysql_query("SELECT * FROM `Users` where kod_aktywacyjny = '$kod'"));
		
		if($id==1 and $rows==1){
		
	

		$zapytanie_autoryzacja = "update Users set autoryzacja=true where kod_aktywacyjny= '$kod'";
		$zapytanie_haslo= "select haslo from Users where kod_aktywacyjny='$kod' limit 1";

		mysql_query($zapytanie_autoryzacja);
		$haslo_resource = mysql_query($zapytanie_haslo);
		$email_resource = mysql_query("select adres_email from Users where kod_aktywacyjny='$kod' limit 1");

		$od  = "From: holter_monitor@monitor.com \r\n";
                                                               $od .= 'MIME-Version: 1.0'."\r\n";
                                                               $od .= 'Content-type: text/html; charset=iso-8859-2'."\r\n";
		$temat="Aktywacja konta na Holter Monitor";
		
		$email = mysql_fetch_array($email_resource);
		$haslo = mysql_fetch_array($haslo_resource);

		$wyslanie_emaila=mail($email[0], "Aktywacja konta na Holter Monitor", "Aktywowa³eœ konto w serwisie Holter Monitor. Twoj login to:<b>'$email[0]'</b> has³o: <b>'$haslo[0]'</b>", $od);
			if($wyslanie_emaila){

			echo "<b>Rejestracja przebiegla pomyslnie.</b> Haslo zostalo przeslane wiadomoscia email na podany przez Ciebie adres.<br/>";
			
			




				}
			else{echo "<b>Wystapil blad procesu aktywacji.</b> Prosze ponownie wypelnic formularz rejestracyjny.<br/>";}


		}
		else {
		echo "<b>Wystapil blad procesu aktywacji.</b> Prosze ponownie wypelnic formularz rejestracyjny.<br/>";
		}
		?>
		</div>
		
	<script>setTimeout("parent.location.href='logowanie.php';",2000); </script>
	</div>
	<!-- end content -->
	<!-- start sidebar -->
	<div id="sidebar" style="margin-top:200px">
		<ul>
		
			<li>
				<h2></h2>
				<ul>
					
				</ul>
			</li>
			<li>
				<h2></h2>
				<ul>
					
				</ul>
			</li>
		</ul>
	</div>
	<!-- end sidebar -->
	<div style="clear: both;">&nbsp;</div>
</div>
<!-- end page -->
<!-- start footer -->
<div id="footer">
	<p id="legal">( c ) 2008. All Rights Reserved. <a href="http://www.freecsstemplates.org/">Bestfriends</a> designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<!-- end footer -->
<div style="text-align: center; font-size: 0.75em;"> <a href="http://www.freewebtemplates.com/"></a>.</div></body>
</html>
