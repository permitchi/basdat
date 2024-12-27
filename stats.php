<?php
$host = "localhost";
$dbname = "basdat";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil semua nilai UKT dari database
    $query = "SELECT ukt FROM siswa";
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ekstrak hanya nilai UKT ke dalam array
    $uktValues = array_column($data, 'ukt');

    // Urutkan data UKT
    sort($uktValues);

    // Hitung statistik 5 serangkai
    $min = $uktValues[0]; // Minimum
    $max = $uktValues[count($uktValues) - 1]; // Maksimum
    $median = calculateMedian($uktValues); // Median
    $q1 = calculateMedian(array_slice($uktValues, 0, floor(count($uktValues) / 2))); // Kuartil 1
    $q3 = calculateMedian(array_slice($uktValues, ceil(count($uktValues) / 2))); // Kuartil 3

    // Tampilkan hasil statistik 5 serangkai
    echo "Minimum: " . $min . "<br>";
    echo "Q1: " . $q1 . "<br>";
    echo "Median: " . $median . "<br>";
    echo "Q3: " . $q3 . "<br>";
    echo "Maximum: " . $max . "<br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fungsi untuk menghitung median
function calculateMedian($data) {
    $n = count($data);
    if ($n % 2 == 0) {
        // Median untuk jumlah data genap
        return ($data[$n / 2 - 1] + $data[$n / 2]) / 2;
    } else {
        // Median untuk jumlah data ganjil
        return $data[floor($n / 2)];
    }
}
?>
