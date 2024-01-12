<?php
require_once '../../vendor/autoload.php';
use MyApp\Model\WikiModel;

session_start();

if (!isset($_SESSION['userId'])) {
    header('Location: ../auth/login.php');
    exit();
}

$wikiModel = new WikiModel();
$userWikis = $wikiModel->getWikisByUserId($_SESSION['userId']);

$wikis = $wikiModel->getAllWikis();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wiki Page Layout</title>
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

    <div class="container-fluid mx-auto mt-5">

        <div class="row">
            <div class="col-8">
                <h2 style="text-align: center;">Wiki Articles</h2>
                <div class="row">
                    <?php foreach ($wikis as $wiki): ?>
                        <?php
                        $categoryName = $wikiModel->getCategoryName($wiki->getCategoryId());
                        $userName = $wikiModel->getUserName($wiki->getUserId());
                        $tags = $wikiModel->getTagsForWiki($wiki->getId());
                        $tagList = implode(', ', $tags);
                        $imagePath = $wiki->getImage() ? '../../Assets/uploads/' . htmlspecialchars($wiki->getImage()) : null;
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card main-section">
                                <?php if ($imagePath && file_exists($imagePath)): ?>
                                    <img src="<?= $imagePath ?>" class="card-img-top" alt="Wiki Image">
                                <?php else: ?>
                                    <p class="text-center mt-2">No image or image not found.</p>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= htmlspecialchars($wiki->getTitle()) ?>
                                    </h5>
                                    <p class="card-text">
                                        <?= htmlspecialchars($wiki->getContent()) ?>
                                    </p>
                                    <div class="wiki-meta">
                                        <p>Posted by:
                                            <?= $userName !== null ? htmlspecialchars($userName) : "Unknown" ?>
                                        </p>
                                        <p>Category:
                                            <?= $categoryName !== null ? htmlspecialchars($categoryName) : "Uncategorized" ?>
                                        </p>
                                        <p>Tags:
                                            <?= $tagList !== null ? htmlspecialchars($tagList) : "No Tags" ?>
                                        </p>
                                    </div>
                                </div>
                                <a href="wikiDetail.php?wikiId=<?= $wiki->getId() ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    <?php endforeach; ?>


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
                                <textarea class="form-control" id="wikiContent" name="wikiContent" required></textarea>
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
                        <button type="submit" form="addWikiForm" class="btn mainBtnColor">Post a
                            wiki</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function loadWikis(userOnly = false) {
            // const url = userOnly ? '../../Api/wikis/user' : '/api/wikis/all';
            const url = userOnly ? '../../Api/fetchUserWikis.php' : '../../Api/fetchAllWikis.php';
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const wikisSection = document.querySelector('.wiki-cards-section');
                    wikisSection.innerHTML = '';
                    data.forEach(wiki => {
                        wikisSection.innerHTML += `
                    <div class="wiki-card">
                        <h3>${wiki.title}</h3>
                        <p>${wiki.content}</p>
                        <!-- Add other wiki details here -->
                    </div>
                `;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleWikisView() {
            const button = document.getElementById('toggleButton');
            if (button.innerText === 'View my wikis') {
                loadWikis(true);
                button.innerText = 'View all wikis';
            } else {
                loadWikis(false);
                button.innerText = 'View my wikis';
            }
        }

    </script>
    <script src="../../Assets/Wiki.js"></script>
    <?php include '../../View/template/footer.php'; ?>
</body>

</html>