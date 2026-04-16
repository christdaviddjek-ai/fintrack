<?php
$dsn = 'mysql:host=localhost;dbname=gestion_depenses;  charset=utf8';
$user = 'root';
$password='';

try {
    $cbd = new PDO($dsn,$user,$password);
    $cbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>