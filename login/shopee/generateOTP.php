<?php
$otp = rand(100000, 999999);
session_start();
$_SESSION['otp'] = $otp;
echo $otp;
