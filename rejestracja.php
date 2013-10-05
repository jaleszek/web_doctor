<?php
session_start();
require "baza_data/naglowek.inc";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Holter monitor</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
<link href="kontakt.css" rel="stylesheet" type="text/css" />
<link href="button_on_input.css" rel="stylesheet" type="text/css"/>
<link href="msg_.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="walidacja.js"></script>
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
		<div style="margin-top:0px"><b>Formularz rejestracji.</b> W celu uzyskania dostÄ™pu do systemu holter monitor, dokonaj bezpÅ‚atnej rejestracji, wpisujÄ…c dane w odpowiednie pola. W przypadku lekarzy prosimy o zaznaczenie pola
		'lekarz' w formularzu. Dalszy proces autoryzacji zostanie opisany w wiadomoÅ›ci email wysÅ‚anej na podany adres.<br/></div>
		</div>
		<div id="stylized" class="myform">
<form id="register_form" name="form" method="post" onsubmit="return validate(this) " action="rejestracja.php" >
<label>ImiÄ™
<span class="small">Podaj imiÄ™.</span>
</label>
<input type="text" name="imie" id="imie" />
<label>Nazwisko
<span class="small">Podaj nazwisko.</span>
</label>
<input type="text" name="nazwisko" id="nazwisko" />
<label>Miasto
<span class="small">Podaj swoje miasto.</span>
</label>
<textarea name="adres" id="content" rows="3"
col="2"></textarea>
<label>Data urodzenia
<span class="small">Kiedy siÄ™ urodziÅ‚eÅ›.</span>
</label>
<input type="text" name="data_urodzenia" id="data_urodzenia" />
<label>Miejsce urodzenia
<span class="small">Gdzie siÄ™ urodziÅ‚eÅ›.</span>
</label>
<input type="text" name="miejsce_urodzenia" id="miejsce_urodzenia" />
<label>Adres email.
<span class="small">Podaj adres email..</span>
</label>
<input type="text" name="adres_email" id="adres_email" />
<label>Rejestrujesz siÄ™ jako.</label>
<select name="status">
<option>pacjent</option>
<option>lekarz</option>
</select>
<input style="cursor:default;margin-top:20px;margin-left:110px;" class="medium blue button" type="submit" value="ZaÅ‚Ã³Å¼ konto"></input>
<?php
require "baza_data/baza.inc";
$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mo¿na po³¹czyæ siê: ' . mysql_error());
mysql_select_db("$baza") or die('Nie mo¿na wybrac bazy danych');
if (isset($_REQUEST['imie']) and isset($_REQUEST['nazwisko']) and isset($_REQUEST['adres']) and isset($_REQUEST['data_urodzenia']) 
and isset($_REQUEST['miejsce_urodzenia']) and isset($_REQUEST['adres_email'])){
$rodzaj = mysql_real_escape_string($_REQUEST['Rodzaj']);
$imie = mysql_real_escape_string($_REQUEST['imie']);
$nazwisko = mysql_real_escape_string($_REQUEST['nazwisko']);
$data_urodzenia =  mysql_real_escape_string($_REQUEST['data_urodzenia']);
$miejsce_urodzenia = mysql_real_escape_string($_REQUEST['miejsce_urodzenia']);
$adres = mysql_real_escape_string($_REQUEST['adres']);
$status = mysql_real_escape_string($_REQUEST['status']);
if($status=='lekarz'){$status=2;}
else {$status=1;}
$adres_email = mysql_real_escape_string($_REQUEST['adres_email']);
$password = sha1(md5(mysql_real_escape_string (str_shuffle("qwertyuiopasdfghjklzxcvbnm"))));
$kod_aktywacyjny=str_shuffle("qwertyuiopasdfghjklzxcvbnm1234567890");
$od  = "From: holter_monitor@monitor.com \r\n";
$od .= 'MIME-Version: 1.0'."\r\n";
$od .= 'Content-type: text/html; charset=iso-8859-2'."\r\n";
$tytul = "Aktywacja konta na Holter Monitor";
$wiadomosc = "<h1>Witaj <b><u>$imie</u></b> w systemie Holter Monitor</h1>
<br> Twoj login na naszej platformie to : <b>$adres_email</b></br>
<br>Has³o otrzymasz drog¹ e-mail op klikniêciu w link aktywacyjny</br>
<br> Aby aktywowaæ konto proszê kliknaæ w poni¿szy link </br>
<br><a href=\"http://student.agh.edu.pl/~soska/emporium/rejestracja_komunikat.php?id=1&kod=".$kod_aktywacyjny."\"> <u>LINK AKTYWACYJNY</u> </a><br>";
mail($adres_email, $tytul, $wiadomosc, $od);
$zapytanie="INSERT INTO Users (imie,nazwisko, miasto, adres_email, data_urodzenia, miejsce_urodzenia, status, kod_aktywacyjny, haslo) VALUES('$imie','$nazwisko','$adres','$adres_email','$data_urodzenia','$miejsce_urodzenia','$status','$kod_aktywacyjny','$password')";
mysql_query($zapytanie) or die("Wyst¹pi³ b³¹d" );
echo "<script>parent.location.href='rejestracja_potwierdzenie.html';</script>";          
}
    ?>
<div class="spacer"></div>
</form>
</div> 
	<div id="sidebar">
	</div>
	<div style="clear: both;">&nbsp;</div>
</div>
<div id="footer">
	<p id="legal">( c ) 2008. All Rights Reserved. <a href="http://www.freecsstemplates.org/">Bestfriends</a> designed by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
</body>
</html>