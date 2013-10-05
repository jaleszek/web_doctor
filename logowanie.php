<?php
session_start();
require "baza_data/naglowek.inc";
	require "baza_data/baza.inc";


if(isset($_POST['login']) and isset($_POST['password'])){

	

	$db = mysql_connect("$serwer","$login","$haslo", true) or die('Nie mona poczy si: ' . mysql_error());
	mysql_select_db("$baza") or die('Nie mona wybrac bazy danych');

	$login = mysql_real_escape_string($_POST['login']);
	$haslo = mysql_real_escape_string($_POST['password']);
	$zapytanie = "select imie, nazwisko, status, autoryzacja, id_Users from Users where adres_email='$login' and haslo='$haslo' and autoryzacja = true";

	if($login!="" and $haslo!=""){
		$resource = mysql_query($zapytanie) or die ("Wystapil blad");
		$licznik = mysql_num_rows($resource);
	
		if($licznik == 1){
			$dane = mysql_fetch_array($resource);
			
			$id = $dane['id_Users'];
			$imie = $dane['imie'];
			$nazwisko = $dane['nazwisko'];
			$status = $dane['status'];
			$autoryzacja = $dane['autoryzacja'];
		
			if($autoryzacja==TRUE){
				$_SESSION['id'] = $id;
				$_SESSION['imie'] = $imie;
				$_SESSION['nazwisko'] = $nazwisko;
				$_SESSION['status'] = $status;
						if($status==1){
						
						  $zap3 = "select id_Patients from Patients where id_Users=".$id;
						  $res2=mysql_query($zap3);
						    if(mysql_num_rows($res2)==0){

     						    $zap4 = "insert into Patients(id_Users) values($id)";
						    mysql_query($zap4);
						   
						    } echo "<script>parent.location.href='index_pacjent.php'</script>";
						}
					else if ($status==2){
						$zap1 = "select id_Doctors from Doctors where id_Users=".$id;
						$res=mysql_query($zap1);
						if(mysql_num_rows($res)==0){

     						  $zap = "insert into Doctors(id_Users) values($id)";
						  mysql_query($zap);
							}
						echo "<script>parent.location.href='index_lekarz.php'</script>";
						}
					else {
						echo"<script>alert('Co nie tak, sprbuj ponownie');</script>";
						echo "<script>parent.location.href='logowanie.php'</script>";

						}
			}
			
		}
	}
}

?>


<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Holter monitor</title>
<meta name="keywords" content="" />
<meta name="description" content="" />

<link href="default.css" rel="stylesheet" type="text/css" />


<link href="button_on_input.css" rel="stylesheet" type="text/css"/>
<link href="msg_.css" rel="stylesheet" type="text/css"/>
<link href="logowanie.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="walidacja_logowanie.js"></script>
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
			<li class="current_page_item"><a href="ekg_opis.html">EKG</a></li>
			<li><a href="dokumentacja.pdf">O projekcie</a></li>
			<li><a href="kontakt.php">Kontakt</a></li>
			<li><a href="dokumentacja.pdf">Pomoc</a></li>
			<li class="last"><a href="logowanie.php">Zaloguj</a></li>
		</ul>
	</div>
</div>
<!-- end header -->
</div>
<!-- start page -->
<div id="page">
	<!-- start content -->
	<div id="content">
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
		<div id="stylized" class="myform">

<form id="register_form" name="form" method="post" onSubmit="return validate(this)" action="logowanie.php">
<label>Login
<span class="small">Podaj swój adres email</span>
</label>
<input type="text" name="login" id="login" />

<label>Hasło
<span class="small">Podaj swoje hasło</span>
</label>
<input type="password" name="password" id="password" />

<input type="submit" class="medium blue button" value="Zaloguj" style="margin-left:80px;margin-top:30px;width:110px;height:30px;"></input>
<input type="button" class="medium blue button" value="Zarejestruj" style="width:110px; height:30px; margin-top:30px;margin-left:20px;" onClick="location.href='rejestracja.php';"/>

<div class="spacer"></div>
</form>


</div>
	
	<!-- end content -->
	<!-- start sidebar -->
	<div id="sidebar">
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
<div style="text-align: center; font-size: 0.75em;">Design downloaded from <a href="http://www.freewebtemplates.com/">free website templates</a>.</div></body>
</html>
<?php

?>
