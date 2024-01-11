<?php
namespace MyApp\Controllers;

use MyApp\Model\WikiModel;
use MyApp\Entity\WikiEntity;


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['userId'])) {
    
    require_once '../../vendor/autoload.php';

    $title = $_POST['wikiTitle'] ?? '';
    $content = $_POST['wikiContent'] ?? '';
    $categoryId = $_POST['wikiCategory'] ?? null;
    $userId = $_SESSION['userId']; 

    $image = null;
if (isset($_FILES['formFile']) && $_FILES['formFile']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../../Assets/uploads/';
    $fileName = basename($_FILES['formFile']['name']);
    $targetFilePath = $uploadDir . $fileName;
    
    
    if (move_uploaded_file($_FILES['formFile']['tmp_name'], $targetFilePath)) {
        $image = $fileName;
    }
}


    $wikiEntity = new WikiEntity(null, $image, $title, $content, $categoryId, $userId);

    $wikiModel = new WikiModel();
    $wikiId = $wikiModel->saveWiki($wikiEntity);

    if (isset($_POST['wikiTags']) && is_array($_POST['wikiTags'])) {
        $wikiModel->saveWikiTags($wikiId, $_POST['wikiTags']);
    }

    header('Location: ../../View/user/wiki.php'); 
    exit();
}
