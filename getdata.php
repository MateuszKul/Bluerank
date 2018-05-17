<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require('simple_html_dom.php');
$pagehtml = file_get_html($_POST['URLAdress']);

//Pobieranie danych ze strony
if(!empty($pagehtml->find(".product__header__name em",0)->innertext))
$prod['name']=$pagehtml->find(".product__header__name em",0)->innertext;
else
$prod['name']="";

if(!empty($pagehtml->find(".product__data__price__regular strong",0)->innertext))
$prod['price']= $pagehtml->find(".product__data__price__regular strong",0)->innertext;
else
$prod['price']="";

if(!empty($pagehtml->find(".product__data__price__list strong",0)->innertext))
$prod['original_price']= $pagehtml->find(".product__data__price__list strong",0)->innertext;
else
$prod['original_price']="";

if(!empty($pagehtml->find(".product__header__name em",0)->innertext))
$prod['manufacturer']= $pagehtml->find(".product__header__name em",0)->innertext;
else
$prod['manufacturer']="";

if(!empty($pagehtml->find(".product__data__content",3)->innertext))
$prod['gender']= $pagehtml->find(".product__data__content",3)->innertext;
else
$prod['gender']="";

if(!empty($pagehtml->find(".product__data__content",5)->innertext))
$prod['description']= $pagehtml->find(".product__data__content",5)->innertext;
else
$prod['description']="";

if(!empty($pagehtml->find(".js--swiper-zoom",0)->href))
$prod['image_url']= $pagehtml->find(".js--swiper-zoom",0)->href;
else
$prod['image_url']="";

if(!empty($pagehtml->find(".product__data__content",0)->innertext))
$prod['id']= $pagehtml->find(".product__data__content",0)->innertext;
else
$prod['id']="";


//Dodawanie danych do bazy
require_once "sql.php";

$poloaczenie = @new mysqli($host,$user,$pass,$name);
if($poloaczenie -> connect_errno!=0)
{
    echo $poloaczenie->connect_errno;
}
else
{
 mysql_query("SET CHARSET utf8");
    mysql_query("SET NAMES `utf8` COLLATE `utf8_polish_ci`"); 
header( 'Content-Type: text/html; charset=utf-8' );

    $sql = "INSERT INTO xml (id,url,name,price,original_price,manufacturer,gender,description,image_url) VALUES ('$prod[id]','$_POST[URLAdress]','$prod[name]','$prod[price]','$prod[original_price]','$prod[manufacturer]','$prod[gender]','$prod[description]','$prod[image_url]')";
    
    @$poloaczenie -> query($sql);
@$poloaczenie -> close();
}

//Tworzenie stringa do XML
$xml = '<item>
<id>'.$prod['id'].'</id>
<url>'.$_POST['URLAdress'].'</url>
<name>'.$prod['name'].'</name>
<price>'.$prod['price'].'</price>
<original_price>'.$prod['original_price'].'</original_price>
<manufacturer>'.$prod['manufacturer'].'</manufacturer>
<gender>'.$prod['gender'].'</gender>
<description>'.$prod['description'].'</description>
<image_url>'.$prod['image_url'].'</image_url>
</item>
';

$filename=$_SESSION["login"].".xml";
//Tworzenie pliku XML, jeśli ten nie istnieje
if(!file_exists($filename))
{
    $file = fopen($filename,"w");
    fputs($file, '<?xml version="1.0"?>
    <rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    ');
    fclose($file);
}

$file = fopen($filename,"r");
//Dodawanie do pliku danych 
$olddata = fread($file, filesize($filename));
fclose($file);
$newdata = $olddata.$xml;

$file = fopen($filename, "w");
fputs($file, $newdata);
fclose($file);

header('Location: home.php');
?>	