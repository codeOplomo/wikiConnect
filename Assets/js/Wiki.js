// function loadWikis(url, userOnly = false) {
//     // const fullUrl = userOnly ? `${url}?userOnly=true` : url;
//     const fullUrl = userOnly ? '../../App/Model/fetchUserWikis.php' : '../../App/Model/fetchAllWikis.php';
//     fetch(fullUrl)
//         .then(response => response.json())
//         .then(data => {
//             const wikisSection = document.querySelector('.wiki-cards-section');
//             wikisSection.innerHTML = '';  

//             data.forEach(wiki => {
//                 // Here, create the HTML structure for each wiki
//                 // This is a basic example, adjust it according to your actual wiki structure
//                 wikisSection.innerHTML += `
//                     <div class="wiki-card">
//                         <h3>${wiki.title}</h3>
//                         <p>${wiki.content}</p>
//                         <!-- Add other wiki details -->
//                     </div>
//                 `;
//             });
//         })
//         .catch(error => console.error('Error:', error));
// }

// function toggleWikisView() {
//     const button = document.getElementById('toggleButton');
//     if (button.innerText === 'View my wikis') {
//         loadWikis('../../App/Model/fetchUserWikis.php', true); // Load user wikis
//         button.innerText = 'View all wikis';
//     } else {
//         loadWikis('../../App/Model/fetchAllWikis.php'); // Load all wikis
//         button.innerText = 'View my wikis';
//     }
// }


// Load all wikis on page load
// document.addEventListener('DOMContentLoaded', function() {
//     loadWikis('getAllWikis.php');  
// });



function setWikiIdToDelete(wikiId) {
    document.getElementById('wikiIdToDelete').value = wikiId;
    console.log("heeeey");
}

document.addEventListener('DOMContentLoaded', function () {
    var tagCheckboxes = document.querySelectorAll('.tag-checkbox');

    tagCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var checkboxDiv = checkbox.closest('.form-check');
            if (checkbox.checked) {
                // Move to checked tags area
                document.getElementById('checkedWikiTags').appendChild(checkboxDiv);
            } else {
                // Move to unchecked tags area
                document.getElementById('uncheckedWikiTags').appendChild(checkboxDiv);
            }
        });
    });
});


