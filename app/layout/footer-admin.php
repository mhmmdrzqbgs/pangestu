<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuBtn = document.getElementById('menuBtn');
        const sideNav = document.getElementById('sideNav');

        menuBtn.addEventListener('click', () => {
            sideNav.classList.toggle('hidden');
        });

        const profileBtn = document.getElementById("profileBtn");
        const profileDropdown = document.getElementById("profileDropdown");

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener("click", function(event) {
                event.stopPropagation();
                profileDropdown.classList.toggle("hidden");
            });

            document.addEventListener("click", function(event) {
                if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add("hidden");
                }
            });
        }
    });

    function showProfileModal() {
        const modal = document.getElementById("profileModal");
        if (modal) {
            modal.classList.remove("hidden");

            fetch('../../config/get-user-info.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById("modalNama").textContent = data.nama;
                    document.getElementById("modalEmail").textContent = data.email;
                })
                .catch(error => console.error('Error:', error));

            document.getElementById("profileDropdown").classList.add("hidden");
        }
    }

    function hideProfileModal() {
        const modal = document.getElementById("profileModal");
        if (modal) {
            modal.classList.add("hidden");
        }
    }
</script>

</html>