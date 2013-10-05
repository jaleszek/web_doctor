

<?php


if(isset($_POST['sender'])){
$adresat = 'jampolak@poczta.onet.pl';		
	$email = $_POST['email'];
	
	$content = $_POST['content'];
	$theme = $_POST['theme'];
	$sender = $_POST['sender'];
	$name = $_POST['name'];

	$content = $theme."&nbsp".$sender."&nbsp".$name."&nbsp".$content;

	$header = 	"From: admin@holtermonitor.pl \nContent-Type:".
			' text/plain;charset="iso-8859-2"'.
			"\nContent-Transfer-Encoding: 8bit";
	if (mail($adresat, 'List ze strony', $content, $header))
		echo "";
	else 
		echo "<script>alert('Nie mo¿na wys³aæ wiadomoœæi. Spróbuj ponownie. ');</script>";
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
<link href="sexy_button/button.css" rel="stylesheet" type="text/css">
<link href="button_on_input.css" rel="stylesheet" type="text/css">
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
		<div id="stylized" class="myform" style="font-family: 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;
	text-align: justify;	color:#666666; text-align:justify; font-weight:bold; font-size:10px;">

<form id="form" name="form" method="post" action="kontakt.php">

<label>Nazwa
<span class="small">Podaj imiÄ™, nazwe.</span>
</label>
<input type="text" name="name" id="name" />


<label>E-mail
<span class="small">Podaj zwrotny adres e-mail.</span>
</label>
<input type="text" name="sender" id="email" />

<label>Temat
<span class="small">Podaj temat wiadomoÅ›ci.</span>
</label>
<input type="text" name="theme" id="email" />

<label>TreÅ›Ä‡
<span class="small">Wpisz treÅ›Ä‡ pytania.</span>
</label>
<textarea name="content" id="content" rows="3"
col="2"></textarea>

<input type="submit" class="blue medium button" value="Zadaj pytanie" style="margin-left:120px;"/>
<div class="spacer"></div>


</form>

</div>
	
	<!-- end content -->
	<!-- start sidebar -->

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
