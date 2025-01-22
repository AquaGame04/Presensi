window.onload = function() {
    document.getElementById('nis-form').addEventListener('submit', function(e) {
        e.preventDefault();

        var nis = document.getElementById('nis').value;
        var nama = document.getElementById('nama').value; // Assuming there's an input for nama
        var kelas = document.getElementById('kelas').value; // Assuming there's an input for kelas
        var nomer = document.getElementById('nomer').value; // Assuming there's an input for nomer

        // AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../proses/proses_daftar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showPopUp(); // Show modal on success
                    } else {
                        alert("Submission failed: " + response.message); // Alert error
                    }
                } else {
                    console.error("Error: ", xhr.status);
                }
            }
        };

        xhr.send("nis=" + encodeURIComponent(nis) + "&nama=" + encodeURIComponent(nama) + "&kelas=" + encodeURIComponent(kelas) + "&nomer=" + encodeURIComponent(nomer));
    });
};


function showPopUp() {
    // Display the modal after the form is submitted successfully
    document.getElementById('myModal').style.display = 'block';
}

function closePopUp() {
    // Hide the modal
    document.getElementById('myModal').style.display = 'none';
}
