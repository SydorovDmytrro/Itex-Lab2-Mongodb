<?php
require_once __DIR__ . "/vendor/autoload.php";

$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->selectDatabase('dbforlab');

$collection = $database->movies;

$query = [];

if (isset($_GET['media_type']) && !empty($_GET['media_type'])) {
    $query['media_type'] = $_GET['media_type'];
}

if (isset($_GET['actors']) && !empty($_GET['actors'])) {
    $query['actors'] = $_GET['actors'];
}

if (isset($_GET['release_year']) && !empty($_GET['release_year'])) {
    $query['release_year'] = (int)$_GET['release_year'];
}

$result = $collection->find($query);

$data = [];
foreach ($result as $entry) {
    $data[] = [
        'title' => $entry['title'],
        'release_year' => $entry['release_year'],
        'media_type' => $entry['media_type'],
        'director' => $entry['director'],
        'actors' => $entry['actors'],
        'genres' => $entry['genres'],
        'country' => $entry['country']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
