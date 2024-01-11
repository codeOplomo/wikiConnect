<?php
session_start();
require_once '/../vendor/autoload.php';
use MyApp\Model\WikiModel;

if (!isset($_SESSION['userId'])) {
    echo json_encode([]); // Handle the case where the user is not logged in
    exit;
}

$wikiModel = new WikiModel();
$userId = $_SESSION['userId'];
$userWikis = $wikiModel->getWikisByUserId($userId);

header('Content-Type: application/json');
echo json_encode($userWikis); // Convert the user-specific wikis to JSON and output
