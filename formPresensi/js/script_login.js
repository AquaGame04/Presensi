window.onload = function() {
    document.getElementById('nis-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        var nis = document.getElementById('nis').value.trim(); // Get the NIS and trim whitespace
        var today = new Date();

        // Reset result fields
        resetResultFields();

        // Format the date
        var formattedDate = formatDate(today);
        document.getElementById("tanggal").innerText = formattedDate;

        // Determine attendance status
        var status = determineStatus(today);
        document.getElementById("status").innerText = status;

        if (nis) {
            // Create and send an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../proses/fetch_proses_info.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log("Request completed. Status: ", xhr.status);
                    if (xhr.status === 200) {
                        handleResponse(xhr.responseText);
                    } else {
                        console.error("Error: ", xhr.status);
                    }
                }
            };

            xhr.send("nis=" + encodeURIComponent(nis)); // Send NIS to the server
        } else {
            alert("Please enter a NIS"); // Alert if NIS is empty
        }
    });
};

// Function to reset result fields
function resetResultFields() {
    document.getElementById("nama").innerText = "";
    document.getElementById("kelas").innerText = "";
    document.getElementById("status").innerText = "";
    document.getElementById("tanggal").innerText = "";
    document.getElementById("result-box").style.display = "none"; // Hide result box
}

// Function to format date to DD-MM-YYYY
function formatDate(date) {
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var year = date.getFullYear();
    return `${day}-${month}-${year}`; // Return formatted date
}

// Function to determine attendance status
function determineStatus(date) {
    var currentHour = date.getHours();
    var currentMinute = date.getMinutes();
    return (currentHour > 7 || (currentHour === 7 && currentMinute > 0)) ? "Terlambat" : "Tepat Waktu";
}

// Function to handle AJAX response
function handleResponse(responseText) {
    var presensiInfo = JSON.parse(responseText);
    if (presensiInfo.error) {
        alert("Anda Sudah Absen"); // Alert if student has already checked in
    } else {
        document.getElementById("nama").innerText = presensiInfo.nama;
        document.getElementById("kelas").innerText = presensiInfo.kelas + "/" + presensiInfo.nomer;
        document.getElementById("status").innerText = presensiInfo.status;
        document.getElementById("tanggal").innerText = presensiInfo.tanggal;
    }
    // Show the result box
    document.getElementById("result-box").style.display = "block";
}
