<?php
session_start();
include_once '../includes/connexion.php';
//$user ='root';
//$pass = '6eeafaef013319822a1f30407a5353f778b59790';
if (isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    //$username = $_POST['username'];
    //$password = $_POST['password'];
    extract($_POST);
    //print_r($_POST);
    $password = sha1($password);
    //var_dump($_SESSION);
    $query = "SELECT id_users FROM users WHERE username='$username' AND password='$password'";
    $query = mysqli_query($link, $query) or die(mysqli_error);
    if (mysqli_num_rows($query) > 0) {
        //if ($username&&$password) {
        //if ($username==$user&&$password==$pass) {
        //$_SESSION['Auth'] = array(
            //'username' => $username,
            //'password' => $password,
        //);

        //var_dump($_SESSION);
        header('location: admin.php');
    } else {
        echo 'Identifiants erronés';
        //}
        //} else {
        //echo'veuillez remplir tous les champs !';
    }
}
?>

<link rel="stylesheet" href="../style/bootstrap.css">
<h1>Administration - Connexion</h1>
<form action="" method="post">
<h3>Pseudo</h3><input type="text" name="username" id=""><br><br>
<h3>Mot de passe</h3><input type="password" name="password" id=""><br><br>
<input type="submit" value="submit"><br><br>
</form>
