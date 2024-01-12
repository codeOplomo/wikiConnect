<?php
require_once '../vendor/autoload.php';
use MyApp\Model\WikiModel;

$wikiModel = new WikiModel();
$wikis = $wikiModel->getAllWikis();

$wikisArray = [];

foreach ($wikis as $wikiEntity) {
    
    $defaultImagePath = '../../Assets/uploads/default-image-path.jpg';
    $imagePath = isset($wikiEntity['imgLink']) ? '../../Assets/uploads/' . htmlspecialchars($wikiEntity['imgLink']) : $defaultImagePath;
    $tagsList = implode(', ', $wikiModel->getTagsForWiki($wikiEntity['id'])) ?? 'No Tags';

    $wikiArray = [
        'id' => $wikiEntity['id'],
        'title' => $wikiEntity['title'],
        'content' => $wikiEntity['content'],
        'categoryId' => $wikiEntity['categoryId'],
        'userId' => $wikiEntity['userId'],
        'imgLink' => $imagePath,
        'categoryName' => $wikiModel->getCategoryName($wikiEntity['categoryId']),
        'userName' => $wikiModel->getUserName($wikiEntity['userId']),
        'tagsList' => $tagsList,
    ];


    $wikisArray[] = $wikiArray;
}

header('Content-Type: application/json');
echo json_encode($wikisArray);


