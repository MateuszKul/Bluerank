<?php
//Logowanie do strony

session_start();
require_once "sql.php";

$poloaczenie = @new mysqli($host,$user,$pass,$name);
if($poloaczenie -> connect_errno!=0)
{
    echo $poloaczenie->connect_errno;
}
else
{
    $login=$_POST['login'];
    $pass=$_POST['pass'];

$login=htmlentities($login,ENT_QUOTES,"UTF-8");
$pass=htmlentities($pass,ENT_QUOTES,"UTF-8");

    $sql = "SELECT * FROM users WHERE Login='$login' AND Pass='$pass'";
    
    if($result=@$poloaczenie ->query($sql))
    {   
        if($result->num_rows==1)
        {
            $row=$result->fetch_assoc();
            $_SESSION['login'] = $row['Login'];
            $result->free();
            header('Location: home.php');  
unlink($_SESSION["login"].".xml");			
        }
        else
        {
            $result->free();
            header('Location: error.php');
        }
    }
    else
    {
        header('Location: index.php');
    }
$poloaczenie->close();
}

?>