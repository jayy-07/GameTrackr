<?php

$hostname = 'localhost';
$dbname = 'gametrackr';
$port = 3306;
$username = 'root';
$password = '';

$db = new mysqli($hostname, $username, $password, $dbname, $port);


if ($db->connect_error) {

    die("Connection failed: " . $db->connect_error);
}

//echo "Connected successfully";
