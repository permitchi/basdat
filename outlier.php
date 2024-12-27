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

    // Menghitung rata-rata dan standar deviasi UKT
    $query = "SELECT AVG(ukt) AS avg_ukt, STDDEV(ukt) AS std_dev FROM siswa";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mendapatkan rata-rata dan standar deviasi
    $avgUkt = $result['avg_ukt'];
    $stdDevUkt = $result['std_dev'];

    // Menentukan batas untuk outlier
    $lowerBound = $avgUkt - 2 * $stdDevUkt;
    $upperBound = $avgUkt + 2 * $stdDevUkt;

    // Memeriksa apakah nilai UKT yang dimasukkan adalah outlier
    if ($ukt < $lowerBound || $ukt > $upperBound) {
        echo "Nilai UKT ($ukt) adalah outlier.";
    } else {
        echo "Nilai UKT ($ukt) tidak termasuk outlier.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
