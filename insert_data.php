<?php
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $alamat = $_POST['alamat'];
    $prodi = $_POST['prodi'];
    $ukt = $_POST['ukt'];

    $conn = new mysqli('localhost', 'root', '', 'basdat');
    if($conn->connect_error) {
        die('Connection Error: '.$conn->connect_error);
    }else{
        $stmt = $conn->prepare("Insert into siswa(nama,nim,alamat,prodi,ukt)values(?,?,?,?,?)");
        $stmt->bind_param("sissi", $nama, $nim, $alamat, $prodi, $ukt);
        $stmt->execute();
        $stmt->close();
        $conn-> close();

        header('Location: /basdat/tabel_data.php');
    }
?>
