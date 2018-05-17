<?php

//Pobieranie pliku XML na komputer

session_start();
$filename=$_SESSION["login"].".xml";

if(file_exists($filename))
{
    $file = fopen($filename,"r");
    $olddata = fread($file, filesize($filename));
    fclose($file);
    $newdata = $olddata.'</rss>';
    $file = fopen($filename,"w");
    fputs($file, $newdata);
    fclose($file);

    header('Content-type: application/xml');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    readfile($filename);
    exit();
}
else
exit();
?>