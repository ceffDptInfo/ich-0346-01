<?php
// Initialisation de l'accès à la base de données
$pdo = null;

try{
    $pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
}
catch(Exception $e) {
    die('Impossible d\'accéder à la base de données : ' . $e->getMessage());
}



// Obtention de l'adresse IP source
$httpHeaderLocationKeys = $_ENV['HTTP_HEADER_LOCATION_KEYS'];
$httpHeaderLocationKeys = explode(';', $httpHeaderLocationKeys);
$httpHeaderLocationKeys = array_map('trim', $httpHeaderLocationKeys);

$remoteAddress = null;

foreach ($httpHeaderLocationKeys as $httpHeaderKey) {
    if (array_key_exists($httpHeaderKey, $_SERVER)) {
        $remoteAddress = $_SERVER[$httpHeaderKey];
        break;
    }
}

if ($remoteAddress === null) {
    die('Impossible de déterminer l\'adresse IP source');
}



// Invocation de l'API geoplugin
$response = file_get_contents("http://www.geoplugin.net/json.gp?ip={$remoteAddress}");

if ($response === false) {
    die('Impossible de récupérer les informations sur l\'adresse IP');
}

$data = json_decode($response, true);



// Insertion de la visite
$stmt = $pdo->prepare($_ENV['DB_QUERY_INSERT']);

try {
    $stmt->execute([
        'ipAddress' => $data['geoplugin_request'],
        'userAgent' => @$_SERVER['HTTP_USER_AGENT'],
        'geoLatitude' => $data['geoplugin_latitude'],
        'geoLongitude' => $data['geoplugin_longitude'],
        'geoCountryCode' => $data['geoplugin_countryCode']
    ]);
}
catch (Exception $e) {
    die('Impossible d\'exécuter la requête d\'insertion : ' . $e);
}



// Sélection des dernières visites
$stmt = $pdo->prepare($_ENV['DB_QUERY_SELECT']);

try {
    $stmt->execute(['historyLength' => $_ENV['APP_HISTORY_LENGTH']]);
}
catch (Exception $e) {
    die('Impossible d\'exécuter la requête de sélection : ' . $e);
}

$visites = $stmt->fetchAll();



// Rendu de la vue
require_once(dirname(__FILE__) . '/VisiteView.php');