<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="stylesheet" href="../css/style_daftar.css">
    <script src="../js/script_daftar.js"></script>
</head>
<body>
    <form id="nis-form" action="../proses/proses_daftar.php" method="POST">
        <div class="header">
            <a href="tabel.php">
                <img src="../img/Logo.png" id="logo" alt="SMK Negeri 10 Semarang">
            </a>
            <h2>Presensi Siswa SMK Negeri 10 Semarang</h2>
        </div>
        <table>
            <tr>
                <td>
                    <div class="group">
                        <input required type="text" name="nama" id="nama" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="nama">Nama Siswa :</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="group">
                        <input required type="text" name="kelas" id="kelas" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="kelas">Kelas :</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="group">
                        <input required type="number" name="nis" id="nis" class="input" maxlength="5">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="nis">NIS :</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="group">
                        <input required type="number" name="nomer" id="nomer" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label for="nomer">No. Absen :</label>
                    </div>
                </td>
            </tr>
        </table>
        <button type="submit" id="add">Daftar</button>
        <div class="login-button">
            <a href="users/login.php">Login</a> <!-- Updated path if files were moved -->
        </div>
    </form>

    <!-- Modal (Pop-Up) -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>Anda sudah terdaftar!</p>
            <button class="close-btn" onclick="closePopUp()">Tutup</button>
        </div>
    </div>
</body>
</html>
