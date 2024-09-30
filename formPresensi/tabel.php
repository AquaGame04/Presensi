<?php
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$dbname = "presensi_01";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan tanggal hari ini
$today = date('Y-m-d');

// Mendapatkan tanggal yang dipilih dari formulir
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10"> <!-- Refresh setiap 10 detik -->
    <title>Daftar Presensi</title>
    <link rel="stylesheet" href="css/tabel.css">
    <!-- Link ke Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body>
    <div class="container">
        <h2>Daftar Presensi</h2>

        <!-- Form untuk memilih tanggal, pencarian, dan pengurutan -->
        <div class="form-container">
            <form method="GET" action="">
                <!-- Input date dengan Flatpickr -->
                <input type="text" id="customDateInput" name="date" class="date-input" value="<?= htmlspecialchars($selectedDate) ?>" onchange="this.form.submit();">
            </form>

            <form method="GET" action="">
                <input type="hidden" name="date" value="<?= htmlspecialchars($selectedDate) ?>">
                <input type="text" name="search" class="search-input" placeholder="Cari NIS, Nama, atau Kelas" value="<?= htmlspecialchars($search) ?>">
                <select class="sort-select" name="sort" id="sort" onchange="this.form.submit();">
                    <option value="nama" <?= $sort === 'nama' ? 'selected' : '' ?>>Nama</option>
                    <option value="kelas" <?= $sort === 'kelas' ? 'selected' : '' ?>>Kelas</option>
                    <option value="nomer" <?= $sort === 'nomer' ? 'selected' : '' ?>>No. Absen</option>
                    <option value="nis" <?= $sort === 'nis' ? 'selected' : '' ?>>NIS</option>
                </select>
                <input type="hidden" name="order" value="<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>">
            </form>
        </div>

        <!-- Tabel Presensi -->
        <?php
        if ($result && $result->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nama</th>';
            echo '<th>Kelas</th>';
            echo '<th>No. Absen</th>';
            echo '<th>NIS</th>';
            echo '<th>Status Kehadiran</th>';
            echo '<th>Waktu Presensi</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            // Menampilkan data setiap baris dalam tabel
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["nama"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["kelas"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nomer"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nis"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["status"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["tanggal"]) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Tidak ada data untuk tanggal ini.</p>';
        }
        ?>

    </div>
    

    <!-- Link ke Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Inisialisasi Flatpickr -->
    <script>
        flatpickr("#customDateInput", {
            altInput: true,            // Menampilkan input alternatif yang lebih ramah pengguna
            altFormat: "F j, Y",       // Format tampilan: Contoh 'September 17, 2024'
            dateFormat: "Y-m-d",       // Format tanggal untuk input asli
            defaultDate: "<?= htmlspecialchars($selectedDate) ?>" // Tanggal default diambil dari nilai yang sudah ada
        });
    </script>
</body>
</html>
