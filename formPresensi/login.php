<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Siswa</title>
    <link rel="stylesheet" href="css/style_login.css"> <!-- Link ke file CSS -->
    <script src="js/script_login.js"></script>
</head>
<body>

<div class="form-box">
    <div class="header">
        <img src="img/logo.png" alt="Logo">
        <div class="title">
            Presensi Siswa<br>
            <small>SMK Negeri 10 Semarang</small>
        </div>
    </div>
    
    <!-- Message about location validation -->
    <p id="locationMessage">Memeriksa lokasi Anda...</p>

    <form class="form" id="nis-form" action="javascript:void(0);" style="display:none;">
        <div class="form-container">
            <label for="nis">NIS :</label>
            <input type="text" class="input" id="nis" name="nis" placeholder="" required>
        </div>
        <button type="submit">Absen</button>
        <div class="daftar-button">
            <a href="daftar.php">Daftar</a>
            <a href="tabel.php">Riwayat</a>
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
    <button class="fixed-btn" id="secretButton" style="display: none;">Click Me</button>
    <audio id="soundEffect" src="sfx/MetalPipe.mp3"></audio>
</body>
</html>
