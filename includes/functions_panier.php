<?php
//session_start();
//include_once('connexion.php');
function creationPanier()
{

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=bookshop', 'root', '1234512345');
        $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {

        echo 'une erreur est survenue';
        die();
    }

    if (!isset($_SESSION['panier'])) {

        $_SESSION['panier'] = array();
        $_SESSION['panier']['libelleProduit'] = array();
        $_SESSION['panier']['qteProduit'] = array();
        $_SESSION['panier']['prixProduit'] = array();
        $_SESSION['panier']['verrou'] = false;
        /* $query = "SELECT tva_1 FROM tva";
        $result = mysqli_query($link, $query);
        //var_dump($result);
        $row = mysqli_fetch_assoc($result);
        var_dump($row);
        $_SESSION['panier']['tva'] = $row['tva_1']; */
    }

    return true;
}

function ajouterProduit($libelleProduit, $qteProduit, $prixProduit)
{

    if (creationPanier() && !isVerrouille()) {

        $positionProduit = array_search($libelleProduit, $_SESSION['panier']['libelleProduit']);

        if ($positionProduit !== false) {
            $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit;
        } else {
            array_push($_SESSION['panier']['libelleProduit'], $libelleProduit);
            array_push($_SESSION['panier']['qteProduit'], $qteProduit);
            array_push($_SESSION['panier']['prixProduit'], $prixProduit);
        }
    } else {

        echo "Erreur, veuillez contacter l'administrateur du site";
    }
}

function ModifierQteProduit($libelleProduit, $qteProduit)
{
    //si le panier existe
    if (creationPanier() && !isVerrouille()) {
        // si la quantité est positive modification ou suppression
        if ($qteProduit > 0) {
            //recherche du produite dans le panier
            $positionProduit = array_search($libelleProduit, $_SESSION['panier']['libelleProduit']);

            if ($positionProduit !== false) {
                $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit;
            }
        } else {
            supprimerProduit($libelleProduit);
        }

    } else {
        echo "Erreur, veuillez contacter l'administrateur du site";
    }
}

function supprimerProduit($libelleProduit)
{

    if (creationPanier() && !isVerrouille()) {
        $tmp = array();
        $tmp['libelleProduit'] = array();
        $tmp['qteProduit'] = array();
        $tmp['prixProduit'] = array();
        $tmp['verrou'] = $_SESSION['panier']['verrou'];

        for ($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++) {
            if ($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit) {

                //array_push($_SESSION['panier']['libelleProduit'], $_SESSION['panier']['libelleProduit'][$i]);
                //array_push($_SESSION['panier']['qteProduit'], $_SESSION['panier']['qteProduit'][$i]);
                //array_push($_SESSION['panier']['prixProduit'], $_SESSION['panier']['prixProduit'][$i]);
                array_push($tmp['libelleProduit'], $_SESSION['panier']['libelleProduit'][$i]);
                array_push($tmp['qteProduit'], $_SESSION['panier']['qteProduit'][$i]);
                array_push($tmp['prixProduit'], $_SESSION['panier']['prixProduit'][$i]);
            }

        }
        $_SESSION['panier'] = $tmp;

        unset($tmp);

    } else {
        echo "Erreur, veuillez contacter l'administrateur du site";
    }

}

function montantGlobal()
{
    $total = 0;
    for ($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++) {
        $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
    }
    return $total;
}

function montantGlobalTVA()
{
    $total = 0;
    for ($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++) {
        $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
    }
    return $total + $total * $_SESSION['panier']['tva'] / 100;
}

function supprimerPanier()
{
    if (isset($_SESSION['panier'])) {
        unset($_SESSION['panier']);
    }
}

function isVerrouille()
{

    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou']) {
        return true;
    } else {
        return false;
    }
}

function compterProduit()
{

    if (isset($_SESSION['panier'])) {
        return count($_SESSION['panier']['libelleProduit']);
    } else {
        return 0;
    }
}
