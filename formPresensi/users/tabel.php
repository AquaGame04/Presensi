<?php
// Include the PHP processing file
$data = include('proses_tabel.php');

// Get the selected date from the form
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get sort and search values from the URL
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'nama';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
$search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10"> <!-- Refresh setiap 10 detik -->
    <title>Daftar Presensi</title>
    <link rel="stylesheet" href="../css/tabel.css">
    <!-- Link ke Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Presensi</h2>

        <!-- Form untuk memilih tanggal, pencarian, dan pengurutan -->
        <div class="form-container">
            <form method="GET" action="">
                <input type="text" id="customDateInput" name="date" class="date-input" value="<?php echo htmlspecialchars($selectedDate); ?>" onchange="this.form.submit();">
            </form>

            <form method="GET" action="">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>">
                <input type="text" name="search" class="search-input" placeholder="Cari NIS, Nama, atau Kelas" value="<?php echo htmlspecialchars($search); ?>">
                <select class="sort-select" name="sort" id="sort" onchange="this.form.submit();">
                    <option value="nama" <?php echo $sort === 'nama' ? 'selected' : ''; ?>>Nama</option>
                    <option value="kelas" <?php echo $sort === 'kelas' ? 'selected' : ''; ?>>Kelas</option>
                    <option value="nomer" <?php echo $sort === 'nomer' ? 'selected' : ''; ?>>No. Absen</option>
                    <option value="nis" <?php echo $sort === 'nis' ? 'selected' : ''; ?>>NIS</option>
                </select>
                <input type="hidden" name="order" value="<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">
            </form>
        </div>

        <!-- Tabel Presensi -->
        <?php if (!empty($data)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>No. Absen</th>
                        <th>NIS</th>
                        <th>Status Kehadiran</th>
                        <th>Waktu Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["nama"]); ?></td>
                            <td><?php echo htmlspecialchars($row["kelas"]); ?></td>
                            <td><?php echo htmlspecialchars($row["nomer"]); ?></td>
                            <td><?php echo htmlspecialchars($row["nis"]); ?></td>
                            <td><?php echo htmlspecialchars($row["status"]); ?></td>
                            <td><?php echo htmlspecialchars($row["tanggal"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data untuk tanggal ini.</p>
        <?php endif; ?>
    </div>
    
    <!-- Link ke Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Inisialisasi Flatpickr -->
    <script>
        flatpickr("#customDateInput", {
            altInput: true,            // Menampilkan input alternatif yang lebih ramah pengguna
            altFormat: "F j, Y",       // Format tampilan: Contoh 'September 17, 2024'
            dateFormat: "Y-m-d",       // Format tanggal untuk input asli
            defaultDate: "<?php echo htmlspecialchars($selectedDate); ?>" // Tanggal default diambil dari nilai yang sudah ada
        });
    </script>
</body>
</html>
