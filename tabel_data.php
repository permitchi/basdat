<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="./css/style2.css">
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
    
    <div id="resultContainer">
      <div id="resultStats" style="display: none;"></div>
      <div id="resultOutlier" style="display: none;"></div>
      <div id="resultStdev" style="display: none;"></div>
    </div>
</body>

<script>
function showStatistic() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            resetDisplay(); // Hide other sections
            var statsDiv = document.getElementById('resultStats');
            statsDiv.innerHTML = "Statistik 5 serangkai: " + this.responseText;
            statsDiv.style.display = 'block'; // Show the stats section
        }
    };
    request.open("GET", "stats.php", true);
    request.send();
}

function showOutlier() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            resetDisplay(); // Hide other sections
            var outlierDiv = document.getElementById('resultOutlier');
            outlierDiv.innerHTML = "Outlier: " + this.responseText;
            outlierDiv.style.display = 'block'; // Show the outlier section
        }
    };
    request.open("GET", "outlier.php", true);
    request.send();
}

function showStdDev() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            resetDisplay(); // Hide other sections
            var stdevDiv = document.getElementById('resultStdev');
            stdevDiv.innerHTML = "Standard Deviation: " + this.responseText;
            stdevDiv.style.display = 'block'; // Show the stdev section
        }
    };
    request.open("GET", "stdev.php", true);
    request.send();
}

function resetDisplay() {
    // Hide all result sections
    document.getElementById('resultStats').style.display = 'none';
    document.getElementById('resultOutlier').style.display = 'none';
    document.getElementById('resultStdev').style.display = 'none';
}
</script>

</html>
