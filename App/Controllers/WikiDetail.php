<?php

require_once '../../vendor/autoload.php';
use MyApp\Model\WikiModel;

session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: ../auth/login.php');
    exit();
}

$wikiModel = new WikiModel();
$wikiId = $_GET['wikiId'] ?? null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_GET['action'] ?? '';
        if ($action === 'edit') {
            $wikiId = $_POST['wikiId'];
            $title = $_POST['wikiTitle'];
            $content = $_POST['wikiContent'];
            $category = $_POST['wikiCategory'];
            $tags = $_POST['wikiTags'];

            $image = null;

            if (isset($_FILES['formFile']) && $_FILES['formFile']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['formFile']['tmp_name'];
            }

            $success = $wikiModel->updateWiki($wikiId, $title, $content, $category, $image);

            $tagsSuccess = $wikiModel->updateWikiTags($wikiId, $tags);

            if ($success && $tagsSuccess) {
                header("Location: ../../View/user/wikiDetail.php?wikiId=$wikiId");
                exit();
            } else {
                echo "Update failed. Please try again later.";
            }
        } elseif ($action === 'delete') {
            $wikiId = $_POST['wikiIdToDelete'];

            $deleteSuccess = $wikiModel->deleteWiki($wikiId);

            if ($deleteSuccess) {
                header("Location: ../../View/user/wiki.php");
                exit();
            } else {
                echo "Deletion failed. Please try again later.";
            }
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
    }
}

?>