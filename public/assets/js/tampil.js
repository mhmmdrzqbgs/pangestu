document.addEventListener("DOMContentLoaded", function () {
    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");

    // Toggle dropdown saat tombol diklik
    profileBtn.addEventListener("click", function () {
        profileDropdown.classList.toggle("hidden");
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener("click", function (event) {
        if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add("hidden");
        }
    });
});
