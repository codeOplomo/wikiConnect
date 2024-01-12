<?php
require_once '../vendor/autoload.php';
use MyApp\Model\WikiModel;

if (isset($_GET['categoryId'])) {
    $categoryId = $_GET['categoryId'];

    $wikiModel = new WikiModel();

    $filteredArticles = $wikiModel->getWikisByCategory($categoryId); 

    $filteredArray = [];

    foreach ($filteredArticles as $filteredEntity) {
        $defaultImagePath = '../../Assets/uploads/default-image-path.jpg';
        $imagePath = isset($filteredEntity['imgLink']) ? '../../Assets/uploads/' . htmlspecialchars($filteredEntity['imgLink']) : $defaultImagePath;
        $tagsList = implode(', ', $wikiModel->getTagsForWiki($filteredEntity['id'])) ?? 'No Tags';

        $filteredArray[] = [
            'id' => $filteredEntity['id'],
            'title' => $filteredEntity['title'],
            'content' => $filteredEntity['content'],
            'categoryId' => $filteredEntity['categoryId'],
            'userId' => $filteredEntity['userId'],
            'imgLink' => $imagePath,
            'categoryName' => $wikiModel->getCategoryName($filteredEntity['categoryId']),
            'userName' => $wikiModel->getUserName($filteredEntity['userId']),
            'tagsList' => $tagsList,
        ];
    }

    header('Content-Type: application/json');
    echo json_encode(['filteredContent' => $filteredArray]);
} else {
    echo 'Category ID not specified';
}
?>


