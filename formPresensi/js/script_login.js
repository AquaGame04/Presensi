// Tentukan latitude dan longitude dari lokasi yang diizinkan
const allowedLatitude = -6.966327934796169;  // contoh latitude
const allowedLongitude = 110.40234914612068; // contoh longitude
const allowedRadius = 50; // radius dalam meter (misalnya 100 meter)
 
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

navigator.geolocation.getCurrentPosition(showPosition, showError, {
    timeout: 10000 // Timeout set to 10 seconds
});


function showPosition(position) {
    const userLatitude = position.coords.latitude;
    const userLongitude = position.coords.longitude;

    // Hitung jarak menggunakan Haversine formula
    const distance = calculateDistance(userLatitude, userLongitude, allowedLatitude, allowedLongitude);
    if (distance <= allowedRadius) {
        document.getElementById("nis-form").style.display = "block";
        document.getElementById("locationMessage").innerHTML = "Anda berada di lokasi yang diizinkan!";
    } else {
        document.getElementById("locationMessage").innerHTML = "Anda berada di luar lokasi yang diizinkan.";
        document.getElementById("nis-form").style.display = "none"; // Hide form if outside allowed location
    }
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3; // Radius bumi dalam meter
    const φ1 = lat1 * Math.PI / 180;
    const φ2 = lat2 * Math.PI / 180;
    const Δφ = (lat2 - lat1) * Math.PI / 180;
    const Δλ = (lon2 - lon1) * Math.PI / 180;

    const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
              Math.cos(φ1) * Math.cos(φ2) *
              Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return R * c; // Jarak dalam meter
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

window.onload = getLocation; // Load location check on window load

window.onload = function(){
document.getElementById('nis-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var nis = document.getElementById('nis').value;
    var today = new Date();

    document.getElementById("nama").innerText = "";
    document.getElementById("kelas").innerText = "";
    document.getElementById("status").innerText = "";
    document.getElementById("tanggal").innerText = "";
    document.getElementById("result-box").style.display = "none";

    // Auto-fill date in format DD-MM-YYYY
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0
    var year = today.getFullYear();
    var formattedDate = `${day}-${month}-${year}`;

    // Determine status based on time (e.g., Late if after 07:00 AM)
    var currentHour = today.getHours();
    var currentMinute = today.getMinutes();
    var status = (currentHour > 7 || (currentHour === 7 && currentMinute > 0)) ? "Terlambat" : "Tepat Waktu";

    document.getElementById("tanggal").innerText = formattedDate;
    document.getElementById("status").innerText = status;

    if (nis) {
    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "proses/fetch_proses_info.php", true); // Communicating with the PHP script
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Response Text: ", xhr.responseText);
            var presensiInfo = JSON.parse(xhr.responseText);

            if (presensiInfo.error) {
                alert("Anda Sudah Absen");
                document.getElementById("nama").innerText = "";
                document.getElementById("kelas").innerText = "";
                document.getElementById("status").innerText = "";
                document.getElementById("tanggal").innerText = "";
                document.getElementById("result-box").style.display = "none";

            } else {
                document.getElementById("nama").innerText = presensiInfo.nama;
                document.getElementById("kelas").innerText = presensiInfo.kelas + "/" + presensiInfo.nomer;
                document.getElementById("status").innerText = presensiInfo.status;
                document.getElementById("tanggal").innerText = presensiInfo.tanggal;
                document.getElementById("result-box").style.display = "block";
            }
        }
    };

    // Send the request with the NIS value
    xhr.send("nis=" + encodeURIComponent(nis));
    } else {
        alert("Please enter a NIS");
    }
})};

// Array dari Konami Code
const konamiCode = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑ ↑ ↓ ↓ ← → ← → B A
let konamiIndex = 0;
console.log("Konami Code");
// Event listener untuk mendeteksi input tombol
window.addEventListener('keydown', function(e) {
    // Cek apakah tombol yang ditekan sesuai dengan Konami Code
    if (e.keyCode === konamiCode[konamiIndex]) {
        konamiIndex++;

        // Jika Konami Code lengkap, tampilkan tombol rahasia
        if (konamiIndex === konamiCode.length) {
            document.getElementById('secretButton').style.display = 'block';
            konamiIndex = 0; // Reset index untuk penggunaan berikutnya
            alert('Easter Egg Unlocked!');
        }
    } else {
        konamiIndex = 0; // Reset jika urutan salah
    }

    // Tambahkan event listener untuk tombol jika ingin suara saat tombol ditekan
    document.getElementById('secretButton').addEventListener('click', function() {

        soundEffect.play(); // Mainkan suara saat tombol diklik
    });
});