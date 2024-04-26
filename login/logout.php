<?php
session_start();
session_destroy();
foreach (array_keys($_SESSION) as $key)
{
    unset($_SESSION[$key]);
}
header('location: ../login');
?>