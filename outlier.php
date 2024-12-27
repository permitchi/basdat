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

    // Ambil data UKT dari tabel mahasiswa dan urutkan
    $query = "SELECT ukt FROM mahasiswa ORDER BY ukt";
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($data) < 4) {
        echo "Data tidak cukup untuk menghitung pencilan.";
        exit;
    }

    // Calculate Q1, Median, and Q3 using proper indexing
    $count = count($data);
    
    // Calculate Q1 (25th percentile)
    $q1Index = floor(($count + 1) / 4) - 1;
    $q1 = $data[$q1Index];
    
    // Calculate Median (50th percentile)
    $medianIndex = floor(($count + 1) / 2) - 1;
    $median = $data[$medianIndex];
    
    // Calculate Q3 (75th percentile)
    $q3Index = floor((3 * ($count + 1)) / 4) - 1;
    $q3 = $data[$q3Index];

    // Calculate IQR
    $iqr = $q3 - $q1;

    // Calculate Lower and Upper bounds
    $lowerBound = $q1 - (1.5 * $iqr);
    $upperBound = $q3 + (1.5 * $iqr);

    // Display statistics
    echo "<br>Data UKT: " . implode(", ", $data);
    echo "<br>Q1: $q1";
    echo "<br>Median: $median";
    echo "<br>Q3: $q3";
    echo "<br>IQR: $iqr";
    echo "<br>Lower Bound: $lowerBound";
    echo "<br>Upper Bound: $upperBound";

    // Identify outliers
    $outliers = array_filter($data, function($value) use ($lowerBound, $upperBound) {
        return $value < $lowerBound || $value > $upperBound;
    });

    // Calculate standard deviation directly from the database
    $stdQuery = $pdo->query("SELECT STDDEV(ukt) as std FROM mahasiswa");
    $stdDev = $stdQuery->fetch(PDO::FETCH_ASSOC)['std'];
    echo "<br>Standar Deviasi: $stdDev";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
