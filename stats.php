<?php
$host = "localhost";
$dbname = "basdat";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT ukt FROM siswa";
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $uktValues = array_column($data, 'ukt');

    sort($uktValues);

    $min = $uktValues[0]; 
    $max = $uktValues[count($uktValues) - 1]; 
    $median = calculateMedian($uktValues); 
    $q1 = calculateMedian(array_slice($uktValues, 0, floor(count($uktValues) / 2))); 
    $q3 = calculateMedian(array_slice($uktValues, ceil(count($uktValues) / 2)));  

    echo "Minimum: " . $min . "<br>";
    echo "Q1: " . $q1 . "<br>";
    echo "Median: " . $median . "<br>";
    echo "Q3: " . $q3 . "<br>";
    echo "Maximum: " . $max . "<br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function calculateMedian($data) {
    $n = count($data);
    if ($n % 2 == 0) {
        return ($data[$n / 2 - 1] + $data[$n / 2]) / 2; //genap
    } else {
        return $data[floor($n / 2)]; //ganjil
    }
}
?>
