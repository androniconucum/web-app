<?php
$hostname = 'localhost';
$username = 'root';
$password = 'december12';
$dbname = 'mydatabase';

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if(!$conn) {
    die("error: " . mysqli_connect_error());
}




?>