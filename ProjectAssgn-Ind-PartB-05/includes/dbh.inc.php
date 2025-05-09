<?php

$dBServername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "b05db";

$conn = mysqli_connect($dBServername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

