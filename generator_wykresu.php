<?php

include "libchart/classes/libchart.php";
header("Content-type: image/png");


$nazwa_pliku = $_GET['file_path'];

$chart = new LineChart(1200,500);	

if (is_readable($nazwa_pliku))
  {
   if ($plik = fopen($nazwa_pliku, "r"))
     {
      $dane = fread($plik, filesize($nazwa_pliku));
      
	
      if ($dane === FALSE) 
	  echo "Odczyt danych z pliku nie powiód³ siê...";
        else {
			$array = explode("\n",$dane);
			}
    fclose($plik);

     } 
	 
  }
  		$serie1 = new XYDataSet();
		$rozmiar = sizeof($array);
	
	for($i = 0; $i < 1500; $i++){
		$serie1->addPoint(new Point("", (int)($array[$i])));
	}
	
	
	$dataSet = new XYSeriesDataSet();
	
	$dataSet->addSerie("seria 1", $serie1);
	$chart;
	$chart->setDataSet($dataSet);
	$chart->setTitle(":)");

  $chart->render();
	

?>