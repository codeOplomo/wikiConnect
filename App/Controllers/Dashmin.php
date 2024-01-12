<?php 
use MyApp\Model\CategoryModel;
use MyApp\Model\TagModel;


require_once __DIR__ . '/../../vendor/autoload.php';

$categoryModel = new CategoryModel();
$tagModel = new TagModel();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        switch ($action) {
            case "addCategory":
                if (isset($_POST["category"])) {
                    $categoryName = $_POST["category"];
                    $categoryAdded = $categoryModel->addCategory($categoryName);

                    if ($categoryAdded) {
                        header("Location: ../../View/admin/dashmin.php");
                    } else {
                        echo "Category already exists or error adding category!";
                    }
                } else {
                    echo "Invalid POST data for adding category.";
                }
                break;
            
            case "updateCategory":
                if (isset($_POST["editCategoryName"]) && isset($_POST["categoryId"])) {
                    $categoryId = $_POST["categoryId"];
                    $newCategoryName = $_POST["editCategoryName"];

                    $categoryUpdated = $categoryModel->updateCategory($categoryId, $newCategoryName);

                    if ($categoryUpdated) {
                        header("Location: ../../View/admin/dashmin.php");
                    } else {
                        echo "Category already exists or error updating category!";
                    }
                } else {
                    echo "Invalid POST data for updating category.";
                }
                break;
                case "deleteCategory":
                    if (isset($_POST["categoryId"])) {
                        $categoryId = $_POST["categoryId"];
    
                        $categoryDeleted = $categoryModel->deleteCategory($categoryId);
    
                        if ($categoryDeleted) {
                            header("Location: ../../View/admin/dashmin.php");
                        } else {
                            echo "Error deleting category!";
                        }
                    } else {
                        echo "Invalid POST data for deleting category.";
                    }
                    break;
                    
            case "addTag":
                if (isset($_POST["tag"])) {
                    $tagName = $_POST["tag"];
                    $tagAdded = $tagModel->addTag($tagName);

                    if ($tagAdded) {
                        header("Location: ../../View/admin/dashmin.php");
                    } else {
                        echo "Tag already exists or error adding tag!";
                    }
                } else {
                    echo "Invalid POST data for adding tag.";
                }
                break;

            case "updateTag":
                if (isset($_POST["editTagName"]) && isset($_POST["tagId"])) {
                    $tagId = $_POST["tagId"];
                    $newTagName = $_POST["editTagName"];

                    $tagUpdated = $tagModel->updateTag($tagId, $newTagName);

                    if ($tagUpdated) {
                        header("Location: ../../View/admin/dashmin.php");
                    } else {
                        echo "Tag already exists or error updating tag!";
                    }
                } else {
                    echo "Invalid POST data for updating tag.";
                }
                break;

            case "deleteTag":
                if (isset($_POST["tagId"])) {
                    $tagId = $_POST["tagId"];

                    $tagDeleted = $tagModel->deleteTag($tagId);

                    if ($tagDeleted) {
                        header("Location: ../../View/admin/dashmin.php");
                    } else {
                        echo "Error deleting tag!";
                    }
                } else {
                    echo "Invalid POST data for deleting tag.";
                }
                break;
            

            default:
                echo "Unknown action.";
                break;
        }
    } else {
        echo "Action parameter missing.";
    }
}
