<?php
$nama = isset($_POST['nama']) ? $_POST['nama'] : null;
$nim = isset($_POST['nim']) ? $_POST['nim'] : null;
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
$prodi = isset($_POST['prodi']) ? $_POST['prodi'] : null;
$ukt = isset($_POST['ukt']) ? (float)$_POST['ukt'] : null;

$host = "localhost";
$dbname = "basdat";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT ukt FROM siswa ORDER BY ukt";
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($data) < 4) {
        echo "Data tidak cukup untuk menghitung pencilan.";
        exit;
    }

    $count = count($data);
    $q1Index = floor(($count + 1) / 4) - 1; //  Q1
    $medianIndex = floor(($count + 1) / 2) - 1; //  Median
    $q3Index = floor((3 * ($count + 1)) / 4) - 1; //  Q3

    $q1 = $data[$q1Index];
    $median = $data[$medianIndex];
    $q3 = $data[$q3Index];

    $iqr = $q3 - $q1;

    $lowerBound = $q1 - (1.5 * $iqr);
    $upperBound = $q3 + (1.5 * $iqr);

    echo "<br>Data UKT: " . implode(", ", $data);
    echo "<br>Q1: $q1";
    echo "<br>Median: $median";
    echo "<br>Q3: $q3";
    echo "<br>IQR: $iqr";
    echo "<br>Lower Bound: $lowerBound";
    echo "<br>Upper Bound: $upperBound";

    // Identifikasi outlier
    $outliers = array_filter($data, function($value) use ($lowerBound, $upperBound) {
        return $value < $lowerBound || $value > $upperBound;
    });

    // Hitung standar deviasi langsung dari database
    $stdQuery = $pdo->query("SELECT STDDEV(ukt) as std FROM siswa");
    $stdDev = $stdQuery->fetch(PDO::FETCH_COLUMN);
    echo "<br>Standar Deviasi: $stdDev";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
