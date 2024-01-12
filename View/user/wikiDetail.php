<?php
require_once '../../vendor/autoload.php';
use MyApp\Model\WikiModel;
use MyApp\Model\TagModel;

session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: ../auth/login.php');
    exit();
}

$wikiModel = new WikiModel();
$tagModel = new TagModel();
$wikiId = $_GET['wikiId'] ?? null;
$wiki = $wikiId ? $wikiModel->getWikiById($wikiId) : null;
$tags = $tagModel->getAllTags();


$isAuthor = false;
$wikiTags = [];

if ($wiki) {
    $categoryName = $wikiModel->getCategoryName($wiki['categoryId']) ?? 'No Category';
    $authorName = $wikiModel->getUserName($wiki['userId']) ?? 'No Author';
    $tagsList = implode(', ', $wikiModel->getTagsForWiki($wiki['id'])) ?? 'No Tags';
    $imagePath = isset($wiki['imgLink']) ? '../../Assets/uploads/' . htmlspecialchars($wiki['imgLink']) : 'default-image-path.jpg';
    $isAuthor = isset($_SESSION['userId']) && $wiki['userId'] == $_SESSION['userId'];
    $wikiTags = $wikiModel->getTagsForWiki($wiki['id']);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WikiDetails Page Layout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/css/wikiStyles.css">
    <link href="../../Assets/css/authstyle.css" rel="stylesheet">

    <!-- Bootstrap JS and its dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <?php include '../../View/template/header.php'; ?>

    <div class="container-fluid d-flex flex-column mt-5">

        <div class="row">
            <div class="col-8">
                <h2 style="text-align: center;">Wiki Detail</h2>
                <div class="main-section p-3">
                    <img src="<?= $imagePath ?>" alt="cover" class="cover img-fluid mx-auto d-block p-3"
                        name="coverImage">
                    <?php if ($isAuthor): ?>
                        <button type="button" class="btn mainBtnColor" data-toggle="modal" data-target="#editWikiModal"
                            onclick="editWiki(<?= $wiki['id'] ?>)">Edit</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWikiModal"
                            onclick="setWikiIdToDelete(<?= $wiki['id'] ?>)">Delete</button>
                    <?php endif; ?>

                    <h4 name="wikiTitle">
                        <?= htmlspecialchars($wiki['title']) ?>
                    </h4>
                    <div class="wiki-details">
                        <p><strong>Author:</strong> <span name="wikiAuthor">
                                <?= htmlspecialchars($authorName) ?>
                            </span></p>
                        <p><strong>Category:</strong> <span name="wikiCategory">
                                <?= htmlspecialchars($categoryName) ?>
                            </span></p>
                        <p><strong>Tags:</strong> <span name="wikiTags">
                                <?= htmlspecialchars($tagsList) ?>
                            </span></p>
                    </div>
                    <div class="wiki-content">
                        <p name="wikiContent">
                            <?= htmlspecialchars($wiki['content']) ?>
                        </p>
                    </div>

                    <!-- Inside the main-section div -->
                    <div class="modal fade" id="deleteWikiModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteWikiModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteWikiModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this wiki?
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteWikiForm" method="POST"
                                        action="../../App/Controllers/WikiDetail.php?action=delete">
                                        <input type="hidden" name="wikiIdToDelete" id="wikiIdToDelete" value="">
                                        <button type="button" class="btn mainBtnColor"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-md-4">

                <div class="button-section">
                    <button type="button" id="toggleButton" onclick="toggleWikisView()">View my wikis</button>
                    <button type="button" class="btn mainBtnColor" data-toggle="modal" data-target="#addWikiModal">Add a
                        wiki</button>
                </div>

                <!-- Categories Section -->
                <aside class="categories-section">
                    <h2>Categories</h2>
                    <ul>
                        <?php
                        $categories = $wikiModel->getAllCategories();
                        foreach ($categories as $category):
                            echo '<li>' . htmlspecialchars($category['name']) . '</li>';
                        endforeach;
                        ?>
                    </ul>
                </aside>

                <!-- Tags Section -->
                <aside class="tags-section">
                    <h2>Tags</h2>
                    <ul>
                        <?php
                        $tags = $wikiModel->getAllTags();
                        foreach ($tags as $tag):
                            echo '<li>' . htmlspecialchars($tag['name']) . '</li>';
                        endforeach;
                        ?>
                    </ul>
                </aside>
            </div>
        </div>


            <!-- Eddit Wiki Modal -->
            <div class="modal fade" id="editWikiModal" tabindex="-1" role="dialog" aria-labelledby="editWikiModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content main-section">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addWikiModalLabel">Edit Wiki</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body main-section">
                            <form id="addWikiForm" method="POST"
                                action="../../App/Controllers/WikiDetail.phpaction=edit" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="formFile" class="form-label"></label>
                                    <div>
                                        <img src="<?= $imagePath ?>" alt="Current Image" class="img-fluid">
                                    </div>
                                    <label for="formFile" class="form-label mt-2">Choose image:</label>
                                    <input name="formFile" class="form-control" type="file" id="formFile">
                                </div>



                                <input type="hidden" name="wikiId" value="<?= $wiki['id'] ?>">

                                <div class="form-group">
                                    <label for="wikiTitle">Title:</label>
                                    <input type="text" class="form-control" id="wikiTitle" name="wikiTitle" required
                                        value="<?= htmlspecialchars($wiki['title']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="wikiContent">Content:</label>
                                    <textarea class="form-control" id="wikiContent" name="wikiContent"
                                        required><?= htmlspecialchars($wiki['content']) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="wikiCategory">Category:</label>
                                    <select class="form-control" id="wikiCategory" name="wikiCategory">
                                        <!-- Default option: currently selected category -->
                                        <?php
                                        $currentCategoryName = $wikiModel->getCategoryName($wiki['categoryId']);
                                        ?>
                                        <option value="<?= htmlspecialchars($wiki['categoryId']) ?>">
                                            <?= htmlspecialchars($currentCategoryName) ?>
                                        </option>

                                        <!-- Other categories from the database -->
                                        <?php
                                        $categories = $wikiModel->getAllCategories();
                                        foreach ($categories as $category):
                                            // Skip the current category to avoid duplication
                                            if ($category['id'] != $wiki['categoryId']): ?>
                                                <option value="<?= htmlspecialchars($category['id']) ?>">
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endif;
                                        endforeach;
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="wikiTags">Tags:</label>
                                    <!-- Section for checked (pre-filled) tags -->
                                    <div id="checkedWikiTags" class="flex-container">
                                        <label>Checked Tags:</label>
                                        <?php foreach ($tags as $tag):
                                            $isChecked = in_array($tag['name'], $wikiTags);
                                            if ($isChecked): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input tag-checkbox" type="checkbox"
                                                        name="wikiTags[]" id="tag<?= htmlspecialchars($tag['id']) ?>"
                                                        value="<?= htmlspecialchars($tag['id']) ?>" checked>
                                                    <label class="form-check-label"
                                                        for="tag<?= htmlspecialchars($tag['id']) ?>">
                                                        <?= htmlspecialchars($tag['name']) ?>
                                                    </label>
                                                </div>
                                            <?php endif;
                                        endforeach; ?>
                                    </div>

                                    <!-- Section for unchecked tags -->
                                    <div id="uncheckedWikiTags" class="flex-container">
                                        <label>Unchecked Tags:</label>
                                        <?php foreach ($tags as $tag):
                                            $isChecked = in_array($tag['name'], $wikiTags);
                                            if (!$isChecked): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input tag-checkbox" type="checkbox"
                                                        name="wikiTags[]" id="tag<?= htmlspecialchars($tag['id']) ?>"
                                                        value="<?= htmlspecialchars($tag['id']) ?>">
                                                    <label class="form-check-label"
                                                        for="tag<?= htmlspecialchars($tag['id']) ?>">
                                                        <?= htmlspecialchars($tag['name']) ?>
                                                    </label>
                                                </div>
                                            <?php endif;
                                        endforeach; ?>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" form="addWikiForm" class="btn mainBtnColor">Save a wiki</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Wiki Modal -->
            <div class="modal fade" id="addWikiModal" tabindex="-1" role="dialog" aria-labelledby="addWikiModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content main-section">
                        <div class="modal-header ">
                            <h5 class="modal-title" id="addWikiModalLabel">Add New Wiki</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">
                            <form id="addWikiForm" method="POST" action="../../App/Controllers/Wiki.php"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose image:</label>
                                    <input name="formFile" class="form-control" type="file" id="formFile">
                                </div>


                                <div class="form-group">
                                    <label for="wikiTitle">Title:</label>
                                    <input type="text" class="form-control" id="wikiTitle" name="wikiTitle" required>
                                </div>
                                <div class="form-group">
                                    <label for="wikiContent">Content:</label>
                                    <textarea class="form-control" id="wikiContent" name="wikiContent"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="wikiCategory">Category:</label>
                                    <?php $categories = $wikiModel->getAllCategories(); ?>
                                    <select class="form-control" id="wikiCategory" name="wikiCategory">
                                        <option value="" disabled selected>Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="wikiTags">Tags:</label>
                                    <?php $tags = $wikiModel->getAllTags(); ?>
                                    <div id="wikiTags" class="flex-container">
                                        <?php foreach ($tags as $tag): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="wikiTags[]"
                                                    id="tag<?php echo htmlspecialchars($tag['id']); ?>"
                                                    value="<?php echo htmlspecialchars($tag['id']); ?>">
                                                <label class="form-check-label"
                                                    for="tag<?php echo htmlspecialchars($tag['id']); ?>">
                                                    <?php echo htmlspecialchars($tag['name']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" form="addWikiForm" class="btn mainBtnColor">Post a wiki</button>
                        </div>
                    </div>
                </div>
            </div>

    </div>

    <script src="../../Assets/Wiki.js"></script>
    <?php include '../../View/template/footer.php'; ?>
</body>

</html>