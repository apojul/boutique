<?php
require_once 'includes/header.php';

$query = "SELECT `auteur`.name, `livre`.titre, `livre`.prix, `livre`.id, `livre`.year FROM `auteur` INNER JOIN `livre` on `auteur`.id = `livre`.auteur_id";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <a href="panier.php?action=ajout&amp;l=<?php echo $row['titre']; ?> &amp;q=1&amp;p=<?php echo number_format($row['prix'], 2, ',', ' '); ?>&amp;"><img src="img/<?= $row['id'] ?>.jpeg" alt="image de couverture" width="57" height="80" style = "float:left"></a>
    <h4><?php echo $row['titre'] . '&nbsp'; ?></h4>
    <h5><?php echo $row['name'] . '&nbsp'; ?></h5>
    <h5><?php echo $row['year'] . '&nbsp'; ?></h5>
    <h4><?php echo number_format($row['prix'], 2, ',', ' ') . '&nbsp'; ?> €</h4>
    <a href="panier.php?action=ajout&amp;l=<?php echo $row['titre']; ?> &amp;q=1&amp;p=<?php echo number_format($row['prix'], 2, ',', ' '); ?>&amp;">Ajouter au panier</a>
    <br>
    <hr>
    <?php
}
require_once 'includes/footer.php';