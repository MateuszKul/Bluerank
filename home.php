<?php
session_start();
if(!isset($_SESSION['Log'])){
header('Location: index.php');
exit();}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>

    <form action="getdata.php" method="post">
    <div class="cont">
    <?php
        echo 'Witaj '.$_SESSION['login'];
    ?>
        <div class="inp">
            <div class="line">
                <input type="text" name="URLAdress" placeholder="URL" style="margin:10px 0px;width:350px;"/>
            </div>
            <input type="submit" value="Dodaj"/>
        </div>
    </form>
    <form action="download.php" method="post">
        <input style="margin:10px 0px;" type="submit" value="Pobierz"/>
    </form> 
    <form action="logout.php" method="post">
        <input style="margin:10px 0px;" type="submit" value="Wyloguj"/>
        </div>
    </form> 
</body>
</html>