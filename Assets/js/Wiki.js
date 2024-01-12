let selectedCategoryId = null;
let isUserOnlyView = false;
let userId = null; 
let selectedTag = null;

document.addEventListener('DOMContentLoaded', function () {
    userId = document.getElementById('userId').getAttribute('data-userid');

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
            filterWikis(); // Apply filters when tags change
        });
    });

    const showMyWikisButton = document.getElementById('toggleButton');

    showMyWikisButton.addEventListener('click', function () {
        isUserOnlyView = !isUserOnlyView;
        filterWikis(); // Apply filters when the "View my wikis" button is clicked
    });

    function loadContent(categoryId = null, additionalUserId = null) {
        let url;
        if (categoryId !== null) {
            url = `../../Api/fetchWikisByCategory.php?categoryId=${categoryId}`;
        } else {
            url = '../../Api/fetchAllWikis.php';
        }

        if (additionalUserId !== null) {
            url += `&userId=${additionalUserId}`;
        }

        console.log('Fetching from URL:', url);

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Received Data:', data);
                allWikis = data;
                filterWikis(); // Apply filters after loading the content
            })
            .catch(error => console.error('Error:', error));
    }

    // Initially load all wikis
    loadContent();

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

    const tagLinks = document.querySelectorAll('.tag-text');

    tagLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            selectedTag = link.textContent; 
            filterWikis();
        });
    });

    const categoryLinks = document.querySelectorAll('.category-link');

    categoryLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            selectedCategoryId = link.getAttribute('data-category-id');

            console.log('Selected Category ID:', selectedCategoryId);

            filterWikis(); // Apply filters when a category is selected
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

    function filterWikis() {
        let filteredWikis = allWikis;
    
        if (selectedCategoryId !== null) {
            filteredWikis = filteredWikis.filter(wiki => wiki.categoryId === parseInt(selectedCategoryId));
        }
    
        if (isUserOnlyView) {
            filteredWikis = filteredWikis.filter(wiki => wiki.userId === parseInt(userId));
        }
    
        if (selectedTag !== null) {
            // Split the tagsList into an array
            const selectedTagArray = selectedTag.split(', ');
    
            // Filter wikis that contain the selected tag
            filteredWikis = filteredWikis.filter(wiki => {
                const wikiTags = wiki.tagsList.split(', ');
                return wikiTags.some(tag => selectedTagArray.includes(tag));
            });
        }
    
        displayWikis(filteredWikis);
    }
    


    window.addEventListener('load', function () {
        loadContent();
    });
});








