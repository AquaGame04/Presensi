<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="stylesheet" href="css/style_daftar.css">
    <script src="js/script_daftar.js"></script>
</head>
<body>
    <form action="proses/proses_daftar.php" method="post" onsubmit="return showPopUp();" id="nis-daftar">
        <div class="header">
            <a href="tabel.php">
                <img src="img/Logo.png" id="logo" alt="SMKN 10">
            </a>
            <h2>Presensi Siswa SMK Negeri 10 Semarang</h2>
        </div>
        <table>
            <tr>
                <td>
                    <div class="group">
                        <input required="" type="text" name="nama" id="nama" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Nama Siswa :</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="group">
                        <input required="" type="text" name="kelas" id="kelas" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Kelas :</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="group">
                        <input required="" type="number" name="nis" id="nis" class="input" maxlength="5">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>NIS :</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="group">
                        <input required="" type="number" name="nomer" id="nomer" class="input">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>No. Absen :</label>
                    </div>
                </td>
            </tr>
        </table>
        <input type="submit" value="Daftar" name="add" id="add">
        <div class="login-button">
            <a href="login.php">Login</a>
        </div>
    </form>

    <!-- Modal (Pop-Up) -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>Anda sudah terdaftar!</p>
            <button class="close-btn" onclick="closePopUp()">Tutup</button>
        </div>
    </div>

    <button class="fixed-btn" id="secretButton" style="display: none;">Click Me</button>
    <audio id="soundEffect" src="sfx/VineBoom.mp3"></audio>
</body>
</html>
