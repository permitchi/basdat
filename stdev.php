<?php
$nama = isset($_POST['nama']) ? $_POST['nama'] : null;
$nim = isset($_POST['nim']) ? $_POST['nim'] : null;
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
$prodi = isset($_POST['prodi']) ? $_POST['prodi'] : null;
$ukt = isset($_POST['ukt']) ? $_POST['ukt'] : null;

$host = "localhost";
$dbname = "basdat";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to calculate standard deviation
    $query = "SELECT STDDEV(ukt) AS std_dev FROM siswa";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Output the standard deviation
    echo "" . $result['std_dev'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
    
