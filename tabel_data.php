<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <div class="container">
    <h1>Data Mahasiswa</h1>
    <p>Add more data <span><a href="index.html">here</a></span></p>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>NIM</th>
          <th>Alamat</th>
          <th>Prodi</th>
          <th>UKT</th>
        </tr>
      </thead>
      <tbody>
        <!-- Contoh data -->
        <tr>
          <?php
          $conn = mysqli_connect("localhost", "root", '', "basdat");
          if($conn->connect_error){
            die("Connection failed : ".$conn->connect_error);
          }

          $sql = "SELECT id, nama, nim, alamat, prodi, ukt FROM siswa";
          $result = $conn-> query($sql);
          
          if ($result-> num_rows > 0) {
            while ($row = $result-> fetch_assoc()) {
              echo "<tr><td>".$row['id']."</td><td>".$row['nama']."</td><td>".$row['nim']."</td><td>".$row['alamat']."</td><td>".$row['prodi']."</td><td>".$row['ukt']."</td></tr>";
            }
            echo "</table>";
          }
          $conn-> close();

          ?>
  </div>

    <div class="query-section">
        <button onclick="showStatistic()">Statistik 5 Serangkai</button>
        <button onclick="showOutlier()">Data Pencilan</button>
        <button onclick="showStdDev()">Standar Deviasi</button>
    </div>
</body>
</html>
