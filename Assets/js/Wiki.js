let selectedCategoryId = null;
let isUserOnlyView = false;

document.addEventListener('DOMContentLoaded', function () {
    const userId = document.getElementById('userId').getAttribute('data-userid');
    let allWikis = [];

    var tagCheckboxes = document.querySelectorAll('.tag-checkbox');

    tagCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var checkboxDiv = checkbox.closest('.form-check');
            if (checkbox.checked) {
                document.getElementById('checkedWikiTags').appendChild(checkboxDiv);
            } else {
                document.getElementById('uncheckedWikiTags').appendChild(checkboxDiv);
            }
        });
    });

    const showMyWikisButton = document.getElementById('toggleButton');

    showMyWikisButton.addEventListener('click', function () {
        isUserOnlyView = !isUserOnlyView;

        if (isUserOnlyView) {
            showMyWikisButton.textContent = 'View all wikis';
            loadContent(selectedCategoryId, userId);
        } else {
            showMyWikisButton.textContent = 'View my wikis';
            loadContent(selectedCategoryId);
        }

        toggleWikisView(isUserOnlyView, userId);
    });

    function loadContent(categoryId = null, userId = null) {
        let url;
        if (categoryId !== null) {
            url = `../../Api/fetchWikisByCategory.php?categoryId=${categoryId}`;
        } else {
            url = '../../Api/fetchAllWikis.php';
        }

        if (userId !== null) {
            url += `&userId=${userId}`;
        }

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                allWikis = data;
                displayWikis(allWikis);
            })
            .catch(error => console.error('Error:', error));
    }

    function createWikiCard(wiki) {
        const wikiCard = document.createElement('div');
        wikiCard.classList.add('card', 'mb-3', 'main-section');
        wikiCard.style.cursor = 'pointer';

        const imgElement = createElement('img');
        imgElement.src = wiki.imgLink;
        imgElement.alt = 'Wiki Image';
        imgElement.classList.add('card-img-top');

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');

        const anchorLink = document.createElement('a');
        anchorLink.href = `../../View/user/wikiDetail.php?wikiId=${wiki.id}`;
        anchorLink.classList.add('stretched-link');
        cardBody.appendChild(anchorLink);

        wikiCard.appendChild(imgElement);
        wikiCard.appendChild(cardBody);
        cardBody.appendChild(createElement('h3', `${wiki.title}`));
        const content = createElement('p', `${wiki.content}`);
        content.classList.add('card-text');
        cardBody.appendChild(content);
        cardBody.appendChild(createElement('p', `Category: ${wiki.categoryName}`));
        cardBody.appendChild(createElement('p', `Author: ${wiki.userName}`));

        const tagsElement = createElement('p', `Tags: ${wiki.tagsList}`);
        cardBody.appendChild(tagsElement);

        return wikiCard;
    }

    const categoryLinks = document.querySelectorAll('.category-link');

    categoryLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            selectedCategoryId = link.getAttribute('data-category-id');

            if (isUserOnlyView) {
                loadContent(selectedCategoryId, userId);
            } else {
                loadContent(selectedCategoryId);
            }
        });
    });

    function createElement(tagName, text) {
        const element = document.createElement(tagName);
        element.textContent = text;
        return element;
    }

    function displayWikis(data) {
        const wikisSection = document.getElementById('wikiContentContainer');
        wikisSection.innerHTML = '';

        if (data.length === 0) {
            wikisSection.innerHTML = '<p>No wikis available.</p>';
        } else {
            const row = document.createElement('div');
            row.classList.add('row');

            data.forEach(wiki => {
                const wikiCard = createWikiCard(wiki);
                const col = document.createElement('div');
                col.classList.add('col-md-4');
                col.appendChild(wikiCard);
                row.appendChild(col);
            });

            wikisSection.appendChild(row);
        }
    }

    function toggleWikisView(isUserOnlyView, userId) {
        if (isUserOnlyView) {
            const userWikis = allWikis.filter(wiki => wiki.userId === parseInt(userId));
            displayWikis(userWikis);
        } else {
            displayWikis(allWikis);
        }
    }

    window.addEventListener('load', function () {
        loadContent();
    });
});








