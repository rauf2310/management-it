// untuk filter
function bukaModalFilter() {
  const modal = document.getElementById("modalFilter");
  modal.style.display = "flex";
}

function tutupModalFilter() {
  const modal = document.getElementById("modalFilter");
  modal.style.display = "none";
}
// Tutup modal jika user klik di area hitam (luar kotak)
window.onclick = function (event) {
  const modal = document.getElementById("modalFilter");
  if (event.target == modal) {
    tutupModalFilter();
  }
};

// UNTUK SEARCH OTOMATIS
function searchTable() {
  // 1. Ambil nilai dari input search dan ubah ke huruf besar
  let input = document.getElementById("searchInput");
  let filter = input.value.toUpperCase();

  // 2. Ambil tabel dan semua baris (tr) di dalam tbody
  let table = document.getElementById("itTable");
  let tr = table.getElementsByTagName("tr");

  // 3. Loop melalui semua baris tabel (dimulai dari indeks 1 untuk melewati header)
  for (let i = 1; i < tr.length; i++) {
    let rowData = tr[i];
    if (rowData) {
      // Mengambil seluruh teks yang ada di dalam satu baris
      let txtValue = rowData.textContent || rowData.innerText;

      // 4. Periksa apakah teks yang dicari ada di dalam teks baris tersebut
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        // Tampilkan jika cocok
        rowData.style.display = "";
      } else {
        // Sembunyikan jika tidak cocok
        rowData.style.display = "none";
      }
    }
  }
}

// UNTUK MELIHAT DATA DVR
function showTotalCamera(devisi) {
  // 1. Tampilkan nama devisi di judul modal
  $("#namaDevisiModal").text(devisi);

  // 2. Tampilkan modal dengan efek smooth
  $("#modalDetailKamera").css("display", "flex").hide().fadeIn(300);

  // 3. Beri indikator loading
  $("#isiModalDetail").html(`
        <div style="text-align:center; padding:30px; color:var(--text-gray);">
            <i class="fas fa-spinner fa-spin" style="font-size:2rem; color:var(--accent-cyan);"></i>
            <p style="margin-top:10px;">Mengambil data kamera devisi ${devisi}...</p>
        </div>
    `);

  // 4. Jalankan AJAX
  $.ajax({
    url: "get_detail_kamera.php",
    type: "POST",
    data: {
      devisi: devisi,
    },
    success: function (response) {
      $("#isiModalDetail").html(response);
    },
    error: function () {
      $("#isiModalDetail").html(
        '<p style="color:var(--danger-red); text-align:center;">Gagal mengambil data. Pastikan file get_detail_kamera.php tersedia.</p>'
      );
    },
  });
}

function tutupModalDetail() {
  $("#modalDetailKamera").fadeOut(300);
}

// untuk modal edit table
document.addEventListener("DOMContentLoaded", function () {
  const modalEdit = document.getElementById("modalEditSingle");
  modalEdit.addEventListener("show.bs.modal", function (event) {
    // Tombol yang memicu modal
    const button = event.relatedTarget;

    // Ambil data dari atribut data-bs-*
    const id = button.getAttribute("data-bs-id");
    const devisi = button.getAttribute("data-bs-devisi");
    const user = button.getAttribute("data-bs-user");
    const namabarang = button.getAttribute("data-bs-namabarang");
    const code = button.getAttribute("data-bs-code");
    const ip = button.getAttribute("data-bs-ip");
    const channel = button.getAttribute("data-bs-channel");
    const spesifikasi = button.getAttribute("data-bs-spesifikasi");

    // Isi ke dalam form modal
    modalEdit.querySelector("#form-id").value = id;
    modalEdit.querySelector("#form-devisi").value = devisi;
    modalEdit.querySelector("#form-user").value = user;
    modalEdit.querySelector("#form-namabarang").value = namabarang;
    modalEdit.querySelector("#form-code").value = code;
    modalEdit.querySelector("#form-ip").value = ip;
    modalEdit.querySelector("#form-channel").value = channel; // Otomatis pilih option yang sesuai
    modalEdit.querySelector("#form-spesifikasi").value = spesifikasi;
  });
});

// untuk modal hapus table
document.addEventListener("DOMContentLoaded", function () {
  const modalHapus = document.getElementById("modalHapusSingle");

  modalHapus.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget; // Tombol yang diklik

    // Ambil data dari atribut data-bs-*
    const id = button.getAttribute("data-bs-id");
    const nama = button.getAttribute("data-bs-nama");
    const devisi = button.getAttribute("data-bs-devisi"); // Ambil devisi

    // Isi data ke dalam modal
    modalHapus.querySelector("#hapus-id").value = id;
    modalHapus.querySelector("#hapus-nama").textContent = nama;
    modalHapus.querySelector("#hapus-devisi").textContent = devisi; // Tampilkan devisi
  });
});
