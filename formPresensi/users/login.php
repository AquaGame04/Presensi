<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa</title>
    <link rel="stylesheet" href="../css/style_login.css"> <!-- Link to CSS file -->
    <script src="../js/script_login.js"></script>
</head>
<body>

<div class="form-box">
    <div class="header">
        <img src="../img/logo.png" alt="Logo">
        <div class="title">
            Presensi Siswa<br>
            <small>SMK Negeri 10 Semarang</small>
        </div>
    </div>

    <form class="form" id="nis-form" action="javascript:void(0);">
        <div class="form-container">
            <label for="nis">NIS :</label>
            <input type="text" class="input" id="nis" name="nis" placeholder="" required>
        </div>
        <button type="submit">Absen</button>
        <div class="daftar-button">
            <a href="users/daftar.php">Daftar</a> <!-- Updated path if files were moved to users folder -->
            <a href="users/tabel.php">Riwayat</a> <!-- Updated path for consistency -->
        </div>
    </form>
    
    <div class="siswa-terdaftar" id="siswa-terdaftar" style="display:none;">
        Siswa Terdaftar
    </div>
    
    <div class="result-box" id="result-box" style="display:none;">
        <span class="name" id="nama"></span>
        <span class="info" id="kelas"></span>
        <span class="info" id="status"></span>
        <span class="info" id="tanggal"></span>
    </div>
</div>

</body>
</html>
