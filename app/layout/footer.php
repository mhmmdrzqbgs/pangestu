<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // side
        const menuBtn = document.getElementById('menuBtn');
        const sideNav = document.getElementById('sideNav');

        if (menuBtn && sideNav) {
            menuBtn.addEventListener('click', () => {
                sideNav.classList.toggle('hidden');
            });
        }

        // dropdown
        const profileBtn = document.getElementById("profileBtn");
        const profileDropdown = document.getElementById("profileDropdown");

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener("click", function(event) {
                event.stopPropagation();
                profileDropdown.classList.toggle("hidden");
            });

            profileDropdown.addEventListener("click", function(event) {
                event.stopPropagation();
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

    // sembunyi
    function hideProfileModal() {
        const modal = document.getElementById("profileModal");
        if (modal) {
            modal.classList.add("hidden");
        }
    }
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const chartElement = document.getElementById('chartSemester');

    if (chartElement) {
        console.log("Chart Found, Initializing...");
        const ctx = chartElement.getContext('2d');

        const semesterData = <?= json_encode($data_siswa['semester_data']); ?>;
        
        const labels = semesterData.map(data => {
            const tahun = data.tahun_ajaran.split("/");
            const tahunSingkat = `${tahun[0].slice(-2)}/${tahun[1].slice(-2)}`; 
            return `smt ${data.semester} (${tahunSingkat})`; // Format 
        });

        const nilai = semesterData.map(data => data.rata_rata);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: nilai,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        suggestedMin: 50,
                        suggestedMax: 100
                    }
                }
            }
        });
    } else {
        console.warn("Chart element not found on this page!");
    }
});

</script>
</html>