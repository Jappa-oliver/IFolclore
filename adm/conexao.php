
<?php

$user = 'root';
$password = '';
$host = 'localhost';
$database = 'folclore';

$mysqli = new mysqli($host, $user, $password, $database);

if($mysqli->error)
{
    die("Falha ao conectar com o banco de dados!" . $mysqli->error);
} 

?>
