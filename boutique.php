<?php
//require_once('includes/connexion.php');
require_once 'includes/header.php';

$query = "SELECT `auteur`.name, `livre`.titre, `livre`.prix, `livre`.id, `livre`.year FROM `auteur` INNER JOIN `livre` on `auteur`.id = `livre`.auteur_id";
$result = mysqli_query($link, $query);
//var_dump($result);
while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <h3><?php echo $row['titre'] . '&nbsp'; ?></h3>
    <h4><?php echo $row['name'] . '&nbsp'; ?></h4>
    <h4><?php echo $row['year'] . '&nbsp'; ?></h4>
    <h3><?php echo number_format($row['prix'], 2, ',', ' ') . '&nbsp'; ?> €</h3>
    <br><br>
    <?php
}
require_once 'includes/footer.php';