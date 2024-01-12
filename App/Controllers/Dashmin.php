<?php 
use MyApp\Model\CategoryModel;
use MyApp\Model\TagModel;
use Routes\route\Route;


require_once __DIR__ . '/../../vendor/autoload.php';

$categoryModel = new CategoryModel();
$tagModel = new TagModel();
$router = new Route();


$router->post('addCategory', function ($data) use ($categoryModel) {
    if (isset($data["category"])) {
        $categoryName = $data["category"];
        $categoryAdded = $categoryModel->addCategory($categoryName);
        if ($categoryAdded) {
            header("Location: ../../View/admin/dashmin.php");
        } else {
            echo "Category already exists or error adding category!";
        }
    } else {
        echo "Invalid POST data for adding category.";
    }
});

$router->post('updateCategory', function ($data) use ($categoryModel) {
    if (isset($data["editCategoryName"]) && isset($data["categoryId"])) {
        $categoryId = $data["categoryId"];
        $newCategoryName = $data["editCategoryName"];
        $categoryUpdated = $categoryModel->updateCategory($categoryId, $newCategoryName);
        if ($categoryUpdated) {
            header("Location: ../../View/admin/dashmin.php");
        } else {
            echo "Category already exists or error updating category!";
        }
    } else {
        echo "Invalid POST data for updating category.";
    }
});

$router->post('deleteCategory', function ($data) use ($categoryModel) {
    if (isset($data["categoryId"])) {
        $categoryId = $data["categoryId"];
        $categoryDeleted = $categoryModel->deleteCategory($categoryId);
        if ($categoryDeleted) {
            header("Location: ../../View/admin/dashmin.php");
        } else {
            echo "Error deleting category!";
        }
    } else {
        echo "Invalid POST data for deleting category.";
    }
});

$router->post('addTag', function ($data) use ($tagModel) {
    if (isset($data["tag"])) {
        $tagName = $data["tag"];
        $tagAdded = $tagModel->addTag($tagName);
        if ($tagAdded) {
            header("Location: ../../View/admin/dashmin.php");
        } else {
            echo "Tag already exists or error adding tag!";
        }
    } else {
        echo "Invalid POST data for adding tag.";
    }
});

$router->post('updateTag', function ($data) use ($tagModel) {
    if (isset($data["editTagName"]) && isset($data["tagId"])) {
        $tagId = $data["tagId"];
        $newTagName = $data["editTagName"];
        $tagUpdated = $tagModel->updateTag($tagId, $newTagName);
        if ($tagUpdated) {
            header("Location: ../../View/admin/dashmin.php");
        } else {
            echo "Tag already exists or error updating tag!";
        }
    } else {
        echo "Invalid POST data for updating tag.";
    }
});

$router->post('deleteTag', function ($data) use ($tagModel) {
    if (isset($data["tagId"])) {
        $tagId = $data["tagId"];
        $tagDeleted = $tagModel->deleteTag($tagId);
        if ($tagDeleted) {
            header("Location: ../../View/admin/dashmin.php");
        } else {
            echo "Error deleting tag!";
        }
    } else {
        echo "Invalid POST data for deleting tag.";
    }
});

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $router->handleRequest();
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST["action"])) {
//         $action = $_POST["action"];

//         switch ($action) {
//             case "addCategory":
//                 if (isset($_POST["category"])) {
//                     $categoryName = $_POST["category"];
//                     $categoryAdded = $categoryModel->addCategory($categoryName);

//                     if ($categoryAdded) {
//                         header("Location: ../../View/admin/dashmin.php");
//                     } else {
//                         echo "Category already exists or error adding category!";
//                     }
//                 } else {
//                     echo "Invalid POST data for adding category.";
//                 }
//                 break;
            
//             case "updateCategory":
//                 if (isset($_POST["editCategoryName"]) && isset($_POST["categoryId"])) {
//                     $categoryId = $_POST["categoryId"];
//                     $newCategoryName = $_POST["editCategoryName"];

//                     $categoryUpdated = $categoryModel->updateCategory($categoryId, $newCategoryName);

//                     if ($categoryUpdated) {
//                         header("Location: ../../View/admin/dashmin.php");
//                     } else {
//                         echo "Category already exists or error updating category!";
//                     }
//                 } else {
//                     echo "Invalid POST data for updating category.";
//                 }
//                 break;
//                 case "deleteCategory":
//                     if (isset($_POST["categoryId"])) {
//                         $categoryId = $_POST["categoryId"];
    
//                         $categoryDeleted = $categoryModel->deleteCategory($categoryId);
    
//                         if ($categoryDeleted) {
//                             header("Location: ../../View/admin/dashmin.php");
//                         } else {
//                             echo "Error deleting category!";
//                         }
//                     } else {
//                         echo "Invalid POST data for deleting category.";
//                     }
//                     break;
                    
//             case "addTag":
//                 if (isset($_POST["tag"])) {
//                     $tagName = $_POST["tag"];
//                     $tagAdded = $tagModel->addTag($tagName);

//                     if ($tagAdded) {
//                         header("Location: ../../View/admin/dashmin.php");
//                     } else {
//                         echo "Tag already exists or error adding tag!";
//                     }
//                 } else {
//                     echo "Invalid POST data for adding tag.";
//                 }
//                 break;

//             case "updateTag":
//                 if (isset($_POST["editTagName"]) && isset($_POST["tagId"])) {
//                     $tagId = $_POST["tagId"];
//                     $newTagName = $_POST["editTagName"];

//                     $tagUpdated = $tagModel->updateTag($tagId, $newTagName);

//                     if ($tagUpdated) {
//                         header("Location: ../../View/admin/dashmin.php");
//                     } else {
//                         echo "Tag already exists or error updating tag!";
//                     }
//                 } else {
//                     echo "Invalid POST data for updating tag.";
//                 }
//                 break;

//             case "deleteTag":
//                 if (isset($_POST["tagId"])) {
//                     $tagId = $_POST["tagId"];

//                     $tagDeleted = $tagModel->deleteTag($tagId);

//                     if ($tagDeleted) {
//                         header("Location: ../../View/admin/dashmin.php");
//                     } else {
//                         echo "Error deleting tag!";
//                     }
//                 } else {
//                     echo "Invalid POST data for deleting tag.";
//                 }
//                 break;
            

//             default:
//                 echo "Unknown action.";
//                 break;
//         }
//     } else {
//         echo "Action parameter missing.";
//     }
// }
