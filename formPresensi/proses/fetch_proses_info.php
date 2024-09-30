<?php
$host = 'localhost'; // Adjust as needed
$dbname = 'presensi_01'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

date_default_timezone_set("Asia/Jakarta");

try {
    // Koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['nis'])) {
        $nis = $_POST['nis'];
        $today = new DateTime();
        $formattedDate = $today->format('Y-m-d H:i:s'); // Format for database with time
        $currentDate = $today->format('Y-m-d'); // Format only the date
        $currentHour = $today->format('H');
        $currentMinute = $today->format('i');

        // Determine attendance status
        $status = ($currentHour > 8 || ($currentHour == 7 && $currentMinute > 0)) ? 'Terlambat' : 'Tepat Waktu';

        // Check if the student has already checked in today
        $checkStmt = $pdo->prepare("SELECT nama, kelas, nomer, DATE(tanggal) AS tanggal_absen FROM daftar WHERE nis = :nis AND DATE(tanggal) = :currentDate");
        $checkStmt->bindParam(':nis', $nis, PDO::PARAM_STR);
        $checkStmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
        $checkStmt->execute();
        $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($checkResult) {
            // If the student has already checked in today
            echo json_encode(['error' => 'Anda sudah absen hari ini!']);
        } else {
            // Proceed to update attendance
            $updateStmt = $pdo->prepare("UPDATE daftar SET status = :status, tanggal = :tanggal WHERE nis = :nis");
            $updateStmt->bindParam(':nis', $nis, PDO::PARAM_STR);
            $updateStmt->bindParam(':tanggal', $formattedDate, PDO::PARAM_STR);
            $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
            $updateStmt->execute();

            // Get student data
            $getStudentStmt = $pdo->prepare("SELECT nama, kelas, nomer FROM daftar WHERE nis = :nis");
            $getStudentStmt->bindParam(':nis', $nis, PDO::PARAM_STR);
            $getStudentStmt->execute();
            $studentData = $getStudentStmt->fetch(PDO::FETCH_ASSOC);

            // Send the updated data as JSON response
            echo json_encode([
                'nama' => $studentData['nama'],
                'kelas' => $studentData['kelas'],
                'nomer' => $studentData['nomer'],
                'status' => $status,
                'tanggal' => $formattedDate
            ]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
?>
