<?php
session_start();
try
{
    $db = new PDO('mysql:host=localhost;dbname=bookshop', 'root', '1234512345');
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {

    echo 'une erreur est survenue';
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<?php

require_once 'includes/header.php';
require_once 'includes/functions_panier.php';

$erreur = false;
$action = (isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null));

if ($action !== null) {

    if (!in_array($action, array('ajout', 'suppression', 'refresh'))) {
        $erreur = true;
    }

    $l = (isset($_POST['l']) ? $_POST['l'] : (isset($_GET['l']) ? $_GET['l'] : null));
    $q = (isset($_POST['q']) ? $_POST['q'] : (isset($_GET['q']) ? $_GET['q'] : null));
    $p = (isset($_POST['p']) ? $_POST['p'] : (isset($_GET['p']) ? $_GET['p'] : null));
    //suppr les espaces (remplace les espaces par rien)
    $l = preg_replace('#\v#', '', $l);
    //retourne la valeur de type
    $p = floatval($p);
    if (is_array($q)) {
        $QteProduit = array();
        $i = 0;
        foreach ($q as $contenu) {
            $QteProduit[$i++] = intval($contenu);
        }
    } else {
        $q = intval($q);
    }

}
if (!$erreur) {
    switch ($action) {

        case "ajout":
            ajouterProduit($l, $q, $p);

            break;

        case "suppression":
            supprimerProduit($l);

            break;

        case "refresh":
            for ($i = 0; $i < count($QteProduit); $i++) {
                modifierQteProduit($_SESSION['panier']['libelleProduit'][$i], round($QteProduit[$i]));

            }

            break;

        default:

            break;
    }
}

?>

<h1>Votre Panier</h1>

<form action="" method="post" >

<table width='400'>
    <tr>
        <td colspan="4">votre panier</td>
    </tr>
    <tr>
    <td>Libellé produit</td>
    <td>Prix unitaire</td>
    <td>Quantité</td>
    <!-- <td>TVA</td> -->
    <td>Action</td>
    </tr>
    <?php

if (isset($_GET['deletePanier']) && $_GET['deletePanier'] == true) {
    supprimerPanier();
}

if (creationPanier()) {

    $nbProduits = count($_SESSION['panier']['libelleProduit']);
    if ($nbProduits <= 0) {
        echo '<br /><p style="font-size:20px; color:Red;"> Oops le panier est vide !</p>';
    } else {

        for ($i = 0; $i < $nbProduits; $i++) {
            ?>
                <tr>
                   <td><br/><?php echo $_SESSION['panier']['libelleProduit'][$i]; ?></td>
                   <td><br/><?php echo number_format($_SESSION['panier']['prixProduit'][$i],2,',',' '); ?></td>
                   <td><br/><input name="q[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]; ?>" size="5"/></td>
                   <!-- <td><br/><?php echo $_SESSION['panier']['tva'] . " %"; ?></td> -->
                   <td><br/><a href="panier.php?action=suppression&amp;l=<?php echo rawurlencode($_SESSION['panier']['libelleProduit'][$i]); ?>"><img src="img/Corbeillevide.jpg" alt="" width="35" height="43"></a></td>

                </tr>
                <?php }?>
                <tr>
                    <td colspan="2"><br/>
                    <p>Total : <?php echo number_format(MontantGlobal(), 2, ',', ' '); ?></p><br/>
                    <!-- <p>Total Taxes Comprises : <?php echo MontantGlobalTVA(); ?></p> -->
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <input type="submit" value="rafraichir"/>
                        <input type="hidden" name="action" value="refresh"/>
                        <a href="?deletePanier=true">Supprimer le panier</a>

                    </td>
                </tr>


                <?php

    }

}

?>

</table>


</form>


<?php

require_once 'includes/footer.php';

?>

</body>
</html>