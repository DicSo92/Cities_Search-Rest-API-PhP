<?php
header('Content-Type: Application/json');

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

try {
    $db = new PDO('mysql:host=localhost;dbname=myweather;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $response["successBdd"] = true;
    $response["searchDatas"] = [];
}
catch (Exception $exception) {
    $response["successBdd"] = false;
    die( 'Erreur : ' . $exception->getMessage() );
}



if (isset($_GET["search"]) AND strlen($_GET["search"]) > 0) {
    $search = $_GET["search"];

    $query = $db->prepare("SELECT * FROM `cities` WHERE `name` LIKE '%{$search}%' LIMIT 20");
    $query->execute();
    $result = $query->fetchAll();

    $response["searchDatas"] = $result;
}

echo json_encode($response);
