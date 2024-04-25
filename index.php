<?php
session_start();
if (!isset($_SESSION['loggedin'])){
    header('location: login/');
}else
{
    echo $_SESSION['loggedin'];
    echo $_SESSION['userId'];
    echo $_SESSION['userEmail'];
    echo $_SESSION['userName'];
}
?>