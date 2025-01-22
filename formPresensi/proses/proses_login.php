<?php
$host = 'sql206.infinityfree.com';
$dbname = 'prif0_37504562_presensi_01'; // Corrected database name
$username = 'if0_37504562';
$password = 'RrlikE41LUjNCjZ'; // Removed trailing space

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize input data
$nis = trim($_POST['nis']);
$nomer = trim($_POST['nomer']);

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM daftar WHERE nis = ? AND absen = ?");
$stmt->bind_param("ss", $nis, $nomer); // Bind parameters

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Login successful";
    // Redirect or start session here
} else {
    echo "Invalid NIS or Nomer";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
