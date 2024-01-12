<?php
require_once '../../vendor/autoload.php';
use MyApp\Model\WikiModel;
use MyApp\Model\CategoryModel;
use MyApp\Model\TagModel;
use MyApp\Model\UserModel;

session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: ../auth/login.php');
    exit();
}

$userModel = new UserModel();

$requiredRoleId = 1;

$userRole = $userModel->getUserRole($_SESSION['userId']);

if ($userRole !== $requiredRoleId) {
    header('Location: ../auth/login.php');
    session_destroy();
    exit();
}
$userDetails = $userModel->getUserDetailsById($_SESSION['userId']);

if ($userDetails) {
    $userName = isset($userDetails['name']) ? htmlspecialchars($userDetails['name']) : 'test';
} else {
    $userName = 'test';
}

$wikiModel = new WikiModel();
$categoryModel = new CategoryModel();
$tagModel = new TagModel();

$wikis = $wikiModel->getAllWikisDash();
$categories = $categoryModel->getAllCategories();
$tags = $tagModel->getAllTags();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WikiConnect</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery (Slim version) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <!-- Popper.js Core -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery (Latest version) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link href="../../Assets/js/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <!-- Tempus Dominus -->
    <link href="../../Assets/js/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="../../Assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Dashboard Styles -->
    <link href="../../Assets/css/Dashboard.css" rel="stylesheet">
    <style>
        .content-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>


</head>

<body>
    <?php include('../template/sidebar.php'); ?>


    <div class="content">
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
            <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-home"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <div class="align-items-center ms-auto">
                <div class="nav-item search-form-container">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" id="searchInput" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success" type="button" id="searchButton">Search</button>
                    </form>
                </div>

            </div>

            <div class="navbar-nav align-items-center ms-auto">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-envelope me-lg-2"></i>
                        <span class="d-none d-lg-inline-flex">Message</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle" src="img/user.png" alt=""
                                    style="width: 40px; height: 40px;">
                                <div class="ms-2">
                                    <h6 class="fw-normal mb-0">User-name send you a message</h6>
                                    <small>15 minutes ago</small>
                                </div>
                            </div>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle" src="img/user.png" alt=""
                                    style="width: 40px; height: 40px;">
                                <div class="ms-2">
                                    <h6 class="fw-normal mb-0">User-name send you a message</h6>
                                    <small>15 minutes ago</small>
                                </div>
                            </div>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle" src="img/user.png" alt=""
                                    style="width: 40px; height: 40px;">
                                <div class="ms-2">
                                    <h6 class="fw-normal mb-0">User-name send you a message</h6>
                                    <small>15 minutes ago</small>
                                </div>
                            </div>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item text-center">See all message</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-bell me-lg-2"></i>
                        <span class="d-none d-lg-inline-flex">Notificatin</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Profile updated</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">New user added</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Password changed</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item text-center">See all notifications</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="img/user.png" alt=""
                            style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex">
                            <?= htmlspecialchars($userName) ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">My Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="../../App/Controllers/Logout.php" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <div class="container-fluid pt-4 px-4" id="content-container">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-line fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Today Sale</p>
                            <h5 class="mb-0">$1234</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-bar fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Sale</p>
                            <h5 class="mb-0">$1234</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-area fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Today Revenue</p>
                            <h5 class="mb-0">$1234</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-chart-pie fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total Revenue</p>
                            <h5 class="mb-0">$1234</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4" id="wikis-section">
            <div class="container-fluid pt-4 px-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">List of Wikis</h6>
                        <div class="form-group">
                            <h6><label for="categoryFilter">Filter by Category:</label></h6>
                            <select class="form-control" id="categoryFilter">
                                <option value="all">All Categories</option>
                                <?php
                                $categories = $wikiModel->getAllCategories();
                                foreach ($categories as $category):
                                    ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <h6><label for="tagFilter">Filter by Tag:</label></h6>
                            <select class="form-control" id="tagFilter">
                                <option value="all">All Tags</option>
                                <?php
                                $tags = $wikiModel->getAllTags(); // Get all available tags
                                foreach ($tags as $tag):
                                    ?>
                                    <option value="<?= htmlspecialchars($tag['id']) ?>">
                                        <?= htmlspecialchars($tag['name']) ?>
                                    </option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>

                    </div>

                    <table class="table table-hover">
                        <colgroup>
                            <col style="width: 5%;">
                            <col style="width: 20%;">
                            <col style="width: 30%;">
                            <col style="width: 10%;">
                            <col style="width: 15%;">
                            <col style="width: 10%;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Wiki Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Category</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Author</th>
                                <th scope="col">Archive</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($wikis) {
                                foreach ($wikis as $wiki) {
                                    $tags = $wikiModel->getTagsForWiki($wiki['id']);
                                    $tagList = implode(', ', $tags);
                                    ?>
                                    <!-- Sample Row -->
                                    <tr>
                                        <td>
                                            <?php echo $wiki['id'] ?>
                                        </td>
                                        <td>
                                            <?php echo $wiki['title'] ?>
                                        </td>
                                        <td class="content-cell">
                                            <?php echo $wiki['content'] ?>
                                        </td>
                                        <td>
                                            <?php echo $wikiModel->getCategoryName($wiki['categoryId']) ?>
                                        </td>
                                        <td class="tag-cell" data-tag="<?= htmlspecialchars($tagList) ?>">
                                            <?php echo htmlspecialchars($tagList); ?>
                                        </td>


                                        <td>
                                            <?php echo $wikiModel->getUserName($wiki['userId']) ?>
                                        </td>
                                        <!-- Archive Column -->
                                        <td>
                                            <?php
                                            if ($wiki['deletedAt'] !== null) {
                                                ?>
                                                <button class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#unarchiveWikiModal_<?php echo $wiki['id']; ?>">
                                                    Unarchive
                                                </button>
                                                <?php
                                            } else {
                                                ?>
                                                <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#archiveWikiModal_<?php echo $wiki['id']; ?>">
                                                    Archive
                                                </button>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td data-category-id="<?= $wiki['categoryId'] ?>"></td>
                                    </tr>
                                    <div class="modal fade" id="archiveWikiModal_<?php echo $wiki['id']; ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="archiveWikiModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="archiveWikiModalTitle">Archive Wiki</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to archive this Wiki?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="../../App/Controllers/Dashmin.php" method="post">
                                                        <input type="hidden" name="wiki_id" value="<?php echo $wiki['id']; ?>">
                                                        <input type="hidden" name="action" value="archiveWiki">
                                                        <button type="submit" name="archive-wiki"
                                                            class="btn btn-primary">Archive</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Unarchive Wiki Modal -->
                                    <div class="modal fade" id="unarchiveWikiModal_<?php echo $wiki['id']; ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="unarchiveWikiModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="unarchiveWikiModalTitle">Unarchive Wiki</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to unarchive this Wiki?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <form action="../../App/Controllers/Dashmin.php" method="post">
                                                        <input type="hidden" name="wiki_id" value="<?php echo $wiki['id']; ?>">
                                                        <input type="hidden" name="action" value="unarchive-wiki">
                                                        <button type="submit" name="unarchive-wiki"
                                                            class="btn btn-primary">Unarchive</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="container-fluid pt-4 px-4" id="categories-section">
            <div class="container-fluid pt-4 px-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Category List</h6>
                        <!-- <a href="">Display All</a> -->
                        <button id="add-category-button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add
                            Category</button>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category) { ?>
                                <tr>
                                    <td>
                                        <?php echo $category['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#editCategoryModal_<?php echo $category['id']; ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteCategoryModal_<?php echo $category['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <!-- Edit Category Modal -->
                                <div class="modal fade" id="editCategoryModal_<?php echo $category['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="editCategoryModalTitle_<?php echo $category['id']; ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editCategoryModalTitle_<?php echo $category['id']; ?>">Edit Category
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="../../App/Controllers/Dashmin.php" method="post">
                                                    <input type="hidden" name="action" value="updateCategory">
                                                    <div class="form-group">
                                                        <label for="editCategoryName">Category Name</label>
                                                        <input type="text" class="form-control" id="editCategoryName"
                                                            name="editCategoryName"
                                                            value="<?php echo htmlspecialchars($category['name']); ?>">
                                                    </div>
                                                    <input type="hidden" name="categoryId"
                                                        value="<?php echo $category['id']; ?>">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delete Category Modal -->
                                <div class="modal fade" id="deleteCategoryModal_<?php echo $category['id']; ?>"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="deleteCategoryModalTitle_<?php echo $category['id']; ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteCategoryModalTitle_<?php echo $category['id']; ?>">Confirm
                                                    Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <p>Are you sure you want to delete the category: <strong>
                                                        <?php echo htmlspecialchars($category['name']); ?>
                                                    </strong>?</p>
                                                <form action="../../App/Controllers/Dashmin.php" method="post">
                                                    <input type="hidden" name="action" value="deleteCategory">
                                                    <input type="hidden" name="categoryId"
                                                        value="<?php echo $category['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </tbody>
                    </table>



                    <div id="add-category-form" style="display: none;">
                        <form action="../../App/Controllers/Dashmin.php" method="post">
                            <input type="hidden" name="action" value="addCategory">
                            <tr class="form-section container-fluid">
                                <td>
                                    <input type="text" class="form-control" name="category" id="categoryInput"
                                        placeholder="Enter category name">
                                    <label class="labell" for="categoryInput"></label>
                                </td>
                                <td><button type="submit" name="submit" class="btn btn-sm btn-success">
                                        Add <i class="fa fa-plus"></i>
                                    </button></td>
                                <td>
                                    <button type="button" class="btn btn-secondary"
                                        id="close-category-form">Close</button>
                                </td>
                            </tr>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4" id="tags-section">
            <div class="container-fluid pt-4 px-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Tag List</h6>
                        <button id="add-tag-button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add
                            Tag</button>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Tag Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $tags = $tagModel->getAllTags(); ?>
                            <?php foreach ($tags as $tag) { ?>
                                <tr>
                                    <td>
                                        <?php echo $tag['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($tag['name']); ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#editTagModal_<?php echo $tag['id']; ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteTagModal_<?php echo $tag['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <!-- Edit Tag Modal -->
                                <div class="modal fade" id="editTagModal_<?php echo $tag['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="editTagModalTitle_<?php echo $tag['id']; ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editTagModalTitle_<?php echo $tag['id']; ?>">
                                                    Edit Tag</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../../App/Controllers/Dashmin.php" method="post">
                                                    <div class="form-group">
                                                        <label for="editTagName">Tag Name</label>
                                                        <input type="text" class="form-control" id="editTagName"
                                                            name="editTagName"
                                                            value="<?php echo htmlspecialchars($tag['name']); ?>">
                                                    </div>
                                                    <input type="hidden" name="tagId" value="<?php echo $tag['id']; ?>">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Tag Modal -->
                                <div class="modal fade" id="deleteTagModal_<?php echo $tag['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteTagModalTitle_<?php echo $tag['id']; ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteTagModalTitle_<?php echo $tag['id']; ?>">
                                                    Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the tag: <strong>
                                                        <?php echo htmlspecialchars($tag['name']); ?>
                                                    </strong>?</p>
                                                <form action="../../App/Controllers/Dashmin.php" method="post">
                                                    <input type="hidden" name="tagId" value="<?php echo $tag['id']; ?>">
                                                    <input type="hidden" name="action" value="deleteTag">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </tbody>
                    </table>

                    <div id="add-tag-form" style="display: none;">
                        <form action="../../App/Controllers/Dashmin.php" method="post">
                            <tr class="form-section container-fluid">
                                <td>
                                    <input type="text" class="form-control" name="tag" id="tagInput"
                                        placeholder="Enter tag name">
                                    <label class="labell" for="tagInput"></label>
                                </td>
                                <td>
                                    <button type="submit" name="submit" class="btn btn-sm btn-success">
                                        Add <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" id="close-tag-form">Close</button>
                                </td>
                            </tr>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../Assets/js/chart.min.js"></script>
        <script src="../../Assets/js/lib/easing/easing.min.js"></script>
        <script src="../../Assets/js/lib/waypoints/waypoints.min.js"></script>
        <script src="../../Assets/js/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="../../Assets/js/lib/tempusdominus/js/moment.min.js"></script>
        <script src="../../Assets/js/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="../../Assets/js/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="../../Assets/js/dashboard.js"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function toggleCategoryForm() {
                    var addCategoryForm = document.getElementById('add-category-form');
                    addCategoryForm.style.display = (addCategoryForm.style.display === 'none' || addCategoryForm.style.display === '') ? 'block' : 'none';
                }

                function closeCategoryForm() {
                    var addCategoryForm = document.getElementById('add-category-form');
                    addCategoryForm.style.display = 'none';
                }

                function toggleTagForm() {
                    var addTagForm = document.getElementById('add-tag-form');
                    addTagForm.style.display = (addTagForm.style.display === 'none' || addTagForm.style.display === '') ? 'block' : 'none';
                }

                function closeTagForm() {
                    var addTagForm = document.getElementById('add-tag-form');
                    addTagForm.style.display = 'none';
                }

                function filterTable() {
                    var selectedCategory = document.getElementById('categoryFilter').value;
                    var selectedTag = document.getElementById('tagFilter').value;
                    var rows = document.querySelectorAll('.table tbody tr');

                    rows.forEach(function (row) {
                        if (shouldDisplayRow(row, selectedCategory, selectedTag)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                function shouldDisplayRow(row, selectedCategory, selectedTag) {
                    var categoryCell = row.querySelector('td[data-category-id]');
                    var categoryId = categoryCell.getAttribute('data-category-id');

                    var tagCell = row.querySelector('.tag-cell');
                    var tagsList = tagCell.getAttribute('data-tag');
                    var tags = tagsList.split(', ').map(tag => tag.trim());

                    var categoryMatch = selectedCategory === 'all' || selectedCategory === categoryId;

                    if (selectedTag === 'all') {
                        return categoryMatch;
                    }

                    if (tags.includes(selectedTag)) {
                        return categoryMatch;
                    }

                    return false;
                }

                document.getElementById('add-category-button').addEventListener('click', toggleCategoryForm);
                document.getElementById('close-category-form').addEventListener('click', closeCategoryForm);
                document.getElementById('add-tag-button').addEventListener('click', toggleTagForm);
                document.getElementById('close-tag-form').addEventListener('click', closeTagForm);
                document.getElementById('categoryFilter').addEventListener('change', filterTable);
                document.getElementById('tagFilter').addEventListener('change', filterTable);

            });

        </script>
</body>

</html>