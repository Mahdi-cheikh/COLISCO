document.addEventListener("DOMContentLoaded", function () {
    const profilePic = document.getElementById("profilePic");
    const profileDropdown = document.getElementById("profileDropdown");

    profilePic.addEventListener("click", function () {
        profileDropdown.classList.toggle("active");
    });

    // Close the dropdown if clicked outside
    document.addEventListener("click", function (event) {
        if (!profilePic.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.remove("active");
        }
    });
});