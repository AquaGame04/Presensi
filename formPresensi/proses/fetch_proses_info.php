<?php
header('Content-Type: application/json'); // Ensure JSON response

$host = 'sql206.infinityfree.com';
$dbname = 'prif0_37504562_presensi_01'; // Corrected database name
$username = 'if0_37504562';
$password = 'RrlikE41LUjNCjZ'; // Removed trailing space

date_default_timezone_set("Asia/Jakarta");

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['nis'])) {
        $nis = trim($_POST['nis']); // Trim to remove extra whitespace
        $today = new DateTime();
        $formattedDate = $today->format('Y-m-d H:i:s');
        $currentDate = $today->format('Y-m-d');
        $currentHour = (int)$today->format('H'); // Cast to int for comparison
        $currentMinute = (int)$today->format('i'); // Cast to int for comparison

        // Determine attendance status
        $status = ($currentHour > 8 || ($currentHour == 7 && $currentMinute > 0)) ? 'Terlambat' : 'Tepat Waktu';

        // Check if the student has already checked in today
        $checkStmt = $pdo->prepare("SELECT nama, kelas, nomer, DATE(tanggal) AS tanggal_absen FROM daftar WHERE nis = :nis AND DATE(tanggal) = :currentDate");
        $checkStmt->bindParam(':nis', $nis, PDO::PARAM_STR);
        $checkStmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
        $checkStmt->execute();
        $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($checkResult) {
            // Student already checked in today
            echo json_encode(['error' => 'Anda sudah absen hari ini!']);
        } else {
            // Update attendance status
            $updateStmt = $pdo->prepare("UPDATE daftar SET status = :status, tanggal = :tanggal WHERE nis = :nis");
            $updateStmt->bindParam(':nis', $nis, PDO::PARAM_STR);
            $updateStmt->bindParam(':tanggal', $formattedDate, PDO::PARAM_STR);
            $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
            $updateStmt->execute();

            // Retrieve student data
            $getStudentStmt = $pdo->prepare("SELECT nama, kelas, nomer FROM daftar WHERE nis = :nis");
            $getStudentStmt->bindParam(':nis', $nis, PDO::PARAM_STR);
            $getStudentStmt->execute();
            $studentData = $getStudentStmt->fetch(PDO::FETCH_ASSOC);

            if ($studentData) {
                // Send JSON response with attendance details
                echo json_encode([
                    'nama' => $studentData['nama'],
                    'kelas' => $studentData['kelas'],
                    'nomer' => $studentData['nomer'],
                    'status' => $status,
                    'tanggal' => $formattedDate
                ]);
            } else {
                echo json_encode(['error' => 'Data siswa tidak ditemukan']);
            }
        }
    } else {
        echo json_encode(['error' => 'NIS tidak ditemukan dalam permintaan']);
    }
} catch (PDOException $e) {
    // Send connection or query error as JSON
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
?>
