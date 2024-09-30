function showPopUp() {
    // Tampilkan modal setelah form dikirim
    document.getElementById('myModal').style.display = 'block';
    return false; // Cegah pengiriman form untuk tujuan demo
}

function closePopUp() {
    document.getElementById('myModal').style.display = 'none';
    // Pengiriman form dilanjutkan setelah pop-up ditutup (atau bisa disesuaikan)
    document.getElementById('nis-daftar').submit(); 
}

const konamiCode = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; 
let konamiIndex = 0;

window.onload = function() {
    document.getElementById('secretButton').addEventListener('click', function() {
        document.getElementById('soundEffect').play();
    });
    
    const konamiCode = ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "KeyB", "KeyA"];
    let konamiIndex = 0;
    
    window.addEventListener('keydown', function(e) {
        if (e.code === konamiCode[konamiIndex]) {
            konamiIndex++;
            if (konamiIndex === konamiCode.length) {
                document.getElementById('secretButton').style.display = 'block';
                konamiIndex = 0;
                alert('Easter Egg Unlocked!');
            }
        } else {
            konamiIndex = 0;
        }
    });
};


document.getElementById('secretButton').addEventListener('click', function() {
    document.getElementById('soundEffect').play();
});