<?php
$csv_file = "output/hasil_data_siswa.csv";
$akurasi_file = "output/akurasi.csv";
$data = [];
$akurasi = [];

// Baca hasil clustering
if (file_exists($csv_file) && ($handle = fopen($csv_file, "r")) !== FALSE) {
    $header = fgetcsv($handle);
    while (($row = fgetcsv($handle)) !== FALSE) {
        $data[] = $row;
    }
    fclose($handle);
}

// Baca hasil akurasi
if (file_exists($akurasi_file) && ($handle = fopen($akurasi_file, "r")) !== FALSE) {
    $akurasi_header = fgetcsv($handle);
    while (($row = fgetcsv($handle)) !== FALSE) {
        $akurasi[] = $row;
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
< lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Clustering</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Hasil Clustering Siswa</h2>
    <table border="1">
        <thead>
            <tr>
                <?php foreach ($header as $col) echo "<th>$col</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) {
                echo "<tr>";
                foreach ($row as $col) {
                    echo "<td>$col</td>";
                }
                echo "</tr>";
            } ?>
        </tbody>
    </table>

    <h2>Ringkasan Akurasi (Silhouette Score)</h2>
    <table border="1">
        <thead>
            <tr>
                <?php foreach ($akurasi_header as $col) echo "<th>$col</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($akurasi as $row) {
                echo "<tr>";
                foreach ($row as $col) {
                    echo "<td>$col</td>";
                }
                echo "</tr>";
            } ?>
        </tbody>
    </table>

    <br>
    <!-- Tombol Download CSV -->
    <a href="<?= $csv_file; ?>" download="hasil_data_siswa.csv" class="btn">Download Hasil Clustering</a>

</body>
