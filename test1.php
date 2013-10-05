<?php 
// sciezka do pliku raw.txt
$id_Research = 27;
$kat = "raws/";
$dir = opendir($kat);
while(false!=($file = readdir($dir))){
  $file_name = $id_Research."_.txt";
  if($file == $file_name and is_file($kat.'/'.$file)){ 
    $file_path = $kat."/".$file;
	break;
	}

}
echo $file;
?>