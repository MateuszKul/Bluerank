<?php
//Wylogowywanie ze strony
session_start();

unlink($_SESSION["login"].".xml");

session_unset();
header("Location: index.php");

?>