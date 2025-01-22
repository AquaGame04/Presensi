<?php
$host = 'sql206.infinityfree.com';
$dbname = 'prif0_37504562_presensi_01'; // Corrected database name
$username = 'if0_37504562';
$password = 'RrlikE41LUjNCjZ'; // Removed trailing space

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Collect and sanitize input data
$nis = trim($_POST['nis']);
$nama = trim($_POST['nama']);
$kelas = trim($_POST['kelas']);
$nomer = (int)$_POST['nomer']; // Cast to int for security

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO daftar (nis, nama, kelas, nomer) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nis, $nama, $kelas, $nomer); // Bind parameters properly

// Execute the statement and check for errors
if ($stmt->execute()) {
    // If the execution is successful, return a success message
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} else {
    // If there's an error during execution, return the error message
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
