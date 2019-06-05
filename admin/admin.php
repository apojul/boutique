<?php
session_start();
include ('../includes/connexion.php');
?>
<link rel="stylesheet" href="../style/bootstrap.css">

<h1>Bienvenue <?php echo($_SESSION['Auth']['username']); ?></h1>
<br>
<a href="?action=add">Ajouter un produit</a>&nbsp&nbsp&nbsp&nbsp
<a href="?action=modify_or_delete">Modifier ou supprimer un produit</a><br><br>
<!-- <a href="?action=delete">Supprimer un produit</a> -->
<?php

if (isset($_SESSION)) {
    if (isset($_GET['action'])) {
        # code...
    
    if ($_GET['action']=='add') {
        if(isset($_POST)) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $gender = $_POST['gender'];
            $price = $_POST['price'];
            if ($title && $year && $price) {
                $query = "INSERT INTO `livre` VALUES ('', '$title', '$year', '$author', '$gender', '$price')";
                $query = mysqli_query($link, $query);
            } else {
                echo 'Veuillez remplir tous les champs';
            }
        }
?>
<form action="" method="post">
    <h3>Titre : </h3><input type="text" name="title" id="">
    <h3>Auteur : </h3><input type="text" name="author" id="">
    <h3>Année : </h3><input type="text" name="year" id="">
    <h3>Genre : </h3><input type="text" name="gender" id="">
    <h3>Prix : </h3><input type="text" name="price" id=""><br><br>
    <input type="submit" value="Envoyer" />
</form>
<?php
    } elseif ($_GET['action']=='modify_or_delete') {
        $query = "SELECT `auteur`.name, `livre`.titre, `livre`.prix, `livre`.id FROM `auteur` INNER JOIN `livre` on `auteur`.id = `livre`.auteur_id";
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['titre'].'&nbsp';
            ?>
            <a href="?action=modify&amp;id=<?php echo $row['id']; ?>">Modifier</a>&nbsp&nbsp
            <a href="?action=delete&amp;id=<?php echo $row['id']; ?>">Suppr</a><br>
            <?php
        }
    } elseif ($_GET['action']=='modify') {
        
        $id = $_GET['id'];
        $query = "SELECT * FROM `livre` WHERE id=$id";
        $result = mysqli_query($link, $query);
        //var_dump($result);
        $row = mysqli_fetch_assoc($result);
        //var_dump($row);
        ?>
    <form action="" method="post">
    <h3>Titre : </h3><input type="text" name="title" id="" value ="<?php echo $row['titre']; ?>">
    <h3>Auteur : </h3><input type="text" name="author" id="" value ="<?php echo $row['auteur']; ?>">
    <h3>Année : </h3><input type="text" name="year" id=""value ="<?php echo $row['year']; ?>">
    <h3>Genre : </h3><input type="text" name="gender" id=""value ="<?php echo $row['genre']; ?>">
    <h3>Prix : </h3><input type="text" name="price" id=""value ="<?php echo $row['prix']; ?>"><br><br>
    <input type="submit" value="Modifier" />
</form>
        <?php
        if(isset($_POST)) {
            var_dump($_POST);
            $title = $_POST['title'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $gender = $_POST['gender'];
            $price = $_POST['price'];
            $query = "UPDATE `livre` SET titre='$title',year='$year', auteur_id='$author', genre_id='$gender', prix='$price' WHERE id=$id";
            $result = mysqli_query($link, $query);
            //header('http://127.1.1.1/LDNR/groupe3/admin/admin.php?action=modify_or_delete');
        }
    } elseif ($_GET['action']=='delete') {
        $id = $_GET['id'];
        $query = "DELETE FROM `livre` WHERE id=$id";
        $result = mysqli_query($link, $query);
    } else {
        die("Une erreur s'est produite.");
    }
} else {
    # code...
}
} else {
    header('location: ../index.php');
}
?>
