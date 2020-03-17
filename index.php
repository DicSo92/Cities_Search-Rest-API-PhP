<?php
header('Content-Type: Application/json'); // Faire croire au navigateur qu'on est dans du json

try {
    $db = new PDO('mysql:host=localhost;dbname=myweather;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $retour["success"] = true;

}
catch (Exception $exception) {
    $retour["success"] = false;

    die( 'Erreur : ' . $exception->getMessage() );
}
echo json_encode($retour);

    $query = $db->prepare("SELECT * FROM `cities` WHERE `name` LIKE '%new y%'");
    $query->execute();
    $result = $query->fetchAll();

echo json_encode($result);
