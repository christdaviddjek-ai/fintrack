<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

if(isset($_GET['id'])) {
    $stmt = $cbd->prepare("DELETE FROM depenses WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    header('Location: crud_depense.php');
    exit();
} else {
    echo "ID de dépense manquant";
    exit();
}
?>