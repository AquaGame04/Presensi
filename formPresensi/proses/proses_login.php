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
$nomer = $_POST['nomer'];

$sql = "SELECT * FROM daftar WHERE nis='$nis' AND absen='$nomer'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Login successful";
    // Redirect or start session here
} else {
    echo "Invalid NIS or Nomer";
}

$conn->close();
?>
