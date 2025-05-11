<?php
session_start();
session_unset();
session_destroy();
unset($_COOKIE['user_id']);
$user_id = 0;
setcookie('user_id', '', time() - 3600, '/'); 
header("Location: ../index.php");
