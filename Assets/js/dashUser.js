document.addEventListener("DOMContentLoaded", function () {
    var profileLink = document.querySelector("#profileLink");
    var profileSection = document.getElementById("profile-section");

    profileLink.addEventListener("click", function (event) {
        event.preventDefault();

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
        profileSection.classList.add("d-none");
    });
});