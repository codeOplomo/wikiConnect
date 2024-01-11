document.addEventListener("DOMContentLoaded", function () {
    // Get the profile link and the profile section
    var profileLink = document.querySelector("#profileLink");
    var profileSection = document.getElementById("profile-section");

    // Add a click event listener to the profile link
    profileLink.addEventListener("click", function (event) {
        // Prevent the default behavior of the link
        event.preventDefault();

        // Toggle the visibility of the profile section
        profileSection.classList.toggle("d-none");
    });
});


var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

toggleButton.onclick = function () {
    el.classList.toggle("toggled");
};

document.addEventListener("DOMContentLoaded", function () {
    var closeIcon = document.getElementById("close-profile-section");
    var profileSection = document.getElementById("profile-section");

    closeIcon.addEventListener("click", function () {
        // Hide the profile section
        profileSection.classList.add("d-none");
    });
});