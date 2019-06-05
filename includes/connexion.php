<?php
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pwd = "1234512345";
$db = "bookshop";
$link = mysqli_connect($host, $user, $pwd, $db);

if (!$link) {
    // si la connexion a échoué, on affiche message erreur et on quitte l'app
    echo "Erreur : Impossible de se connecter à MySQL." . "<br/>";
    echo "Errno de débogage : " . mysqli_connect_errno() . "<br/>";
    echo "Erreur de débogage : " . mysqli_connect_error() . "<br/>";
    exit;
}
