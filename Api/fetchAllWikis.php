<?php
require_once '/../vendor/autoload.php';
use MyApp\Model\WikiModel;

$wikiModel = new WikiModel();
$wikis = $wikiModel->getAllWikis();

header('Content-Type: application/json');
echo json_encode($wikis); // Convert the wikis to JSON and output
