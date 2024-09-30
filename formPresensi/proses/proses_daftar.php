<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "presensi_01";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$nomer = $_POST['nomer'];

$sql = "INSERT INTO daftar (id, nama, kelas, nomer, nis) VALUES ('$nis', '$nama', '$kelas', '$nomer', '$nis')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Location: ../daftar.php"); // Redirect to daftar.php
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
