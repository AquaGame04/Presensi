<?php
$host = 'sql105.infinityfree.com';
$dbname = 'if0_37642941_presensi_01';
$username = 'if0_37642941';
$password = 'WHpdXo2sjdFo6P';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date
$today = date('Y-m-d');

// Get selected date from the form or use today's date
$selectedDate = isset($_GET['date']) ? $_GET['date'] : $today;

// Get sort parameters from the URL
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'nama';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Get search term from the URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Validate sort and order
$valid_sort_columns = ['nama', 'kelas', 'nomer', 'nis'];
if (!in_array($sort, $valid_sort_columns)) {
    $sort = 'nama';
}
$order = $order === 'DESC' ? 'DESC' : 'ASC';

// Query to get data from the table 'daftar' with sorting and search
$sql = "SELECT id, nama, kelas, nomer, nis, status, DATE_FORMAT(tanggal, '%Y-%m-%d %H:%i') AS tanggal 
        FROM daftar 
        WHERE DATE(tanggal) = ? 
        AND (nama LIKE ? OR nis LIKE ? OR kelas LIKE ?)
        ORDER BY $sort $order";

$searchTerm = '%' . $search . '%';

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $selectedDate, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Collect data in an array
    }
}

$stmt->close();
$conn->close();

// Return the data to the calling script
return $data;
?>
