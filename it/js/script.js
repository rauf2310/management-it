// Inisialisasi Vanilla-Tilt pada elemen dengan atribut data-tilt
VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
    max: 20, // Maksimal sudut kemiringan
    speed: 400, // Kecepatan transisi
    glare: true, // Efek cahaya
    "max-glare": 0.5, // Intensitas efek cahaya
});

// Anda bisa menambahkan JavaScript kustom di sini jika diperlukan.
// Contoh: Mengubah warna latar belakang secara dinamis, atau efek lain.

