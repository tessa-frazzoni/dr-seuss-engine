<?php 
$dsn ="mysql:host=localhost;dbname=seussology";
$user = "root";
$pass="";

try {
    $db = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo 'Error';
    die();
}

?>