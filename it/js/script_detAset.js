// PROSES CEK IP STARTT ----------------
function cekIpTersedia() {
  let table = document.getElementById("itTable");
  let tr = table.getElementsByTagName("tr");

  // Initialiser arrays til hvert segment
  let terpakai0 = []; // Til 192.168.0.x
  let terpakai1 = []; // Til 192.168.1.x
  let terpakai2 = []; // Til 192.168.2.x

  // 1. Scan tabellen og sorter IP'erne i de rigtige arrays
  for (let i = 1; i < tr.length; i++) {
    let ipElement = tr[i].querySelector(".net-code");
    if (ipElement) {
      let rawText = ipElement.textContent.trim();

      // Cari pola IP menggunakan Regex (Mencari format X.X.X.X)
      let match = rawText.match(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);

      if (match) {
        let ipFull = match[0];
        let lastDigit = parseInt(ipFull.split(".").pop());

        // Gunakan startsWith atau regex agar lebih akurat membagi segment
        if (ipFull.includes(".0.")) {
          terpakai0.push(lastDigit);
        } else if (ipFull.includes(".1.")) {
          terpakai1.push(lastDigit);
        } else if (ipFull.includes(".2.")) {
          terpakai2.push(lastDigit);
        }
      }
    }
  }

  // 2. Klargør containeren til visning
  let listContainer = document.getElementById("listIpKosong");
  document.getElementById("hasilCekIp").classList.remove("d-none");
  listContainer.innerHTML = ""; // Ryd tidligere resultater

  // 3. Render de 3 segmenter korrekt
  renderSegmen("192.168.0.", terpakai0, listContainer);
  renderSegmen("192.168.1.", terpakai1, listContainer);
  renderSegmen("192.168.2.", terpakai2, listContainer);
}
function renderSegmen(prefix, arrayTerpakai, container) {
  // 1. Hitung jumlah IP tersedia untuk badge di header
  let jmlTersedia = 254 - arrayTerpakai.length;

  // 2. Header Segmen
  let header = document.createElement("div");
  header.className = "col-12 mt-4 mb-2";
  header.innerHTML = `
        <div class="d-flex align-items-center justify-content-between bg-dark p-2 border-start border-info border-4">
            <span class="fw-bold text-info ml-2">Subnet: ${prefix}x</span>
            <span class="badge rounded-pill bg-secondary text-light">${jmlTersedia} IP Tersedia</span>
        </div>`;
  container.appendChild(header);

  // 3. Row Container
  let gridRow = document.createElement("div");
  gridRow.className = "row g-2";
  container.appendChild(gridRow);

  // 4. Render SEMUA IP dari 1 sampai 254
  for (let j = 1; j <= 254; j++) {
    let col = document.createElement("div");
    col.className = "col-lg-2 col-md-3 col-4";

    let ipLengkap = prefix + j;

    // Cek apakah IP ini ada dalam daftar yang terpakai
    let isTerpakai = arrayTerpakai.includes(j);

    // Tentukan class dan fungsi klik
    let statusClass = isTerpakai ? "terpakai" : "";
    let clickAction = isTerpakai
      ? ""
      : `onclick="copyToClipboard('${ipLengkap}')"`;
    let titleTooltip = isTerpakai ? "IP Sudah Terpakai" : "Klik untuk salin IP";

    col.innerHTML = `
            <div class="ip-mini-box ${statusClass}" ${clickAction} title="${titleTooltip}">
                ${ipLengkap}
            </div>`;
    gridRow.appendChild(col);
  }
}
// PROSES CEK IP END ----------------

// UNTUK EDIT SESUAI perangkat //////////////////////////
function pilihModal(button) {
  // 1. Ambil data dan bersihkan sebersih mungkin
  let rawPerangkat = button.getAttribute("data-perangkat") || "";

  let perangkat = rawPerangkat
    .replace(/<\/?[^>]+(>|$)/g, "")
    .trim()
    .toLowerCase();

  let targetId = "";

  // 2. Logika Penentuan
  if (perangkat.includes("komputer")) {
    targetId = "modalEditKomputer";
  } else if (perangkat.includes("laptop")) {
    targetId = "modalEditLaptop";
  }
  // Penentuan untuk Router
  else if (perangkat.includes("router")) {
    targetId = "modalEditRouter";
  } else if (
    perangkat.includes("printer") ||
    perangkat.includes("fotocopy") ||
    perangkat.includes("scanner")
  ) {
    targetId = "modalEditPrinter";
  } else if (perangkat.includes("dvr")) {
    targetId = "modalEditDvr";
  } else {
    alert(
      "Sistem tidak mengenali jenis perangkat!\n" +
        "Teks asli: '" +
        rawPerangkat +
        "'"
    );
    return;
  }

  const modalElement = document.getElementById(targetId);
  if (!modalElement) {
    alert("Error: Modal #" + targetId + " tidak ditemukan.");
    return;
  }

  // 4. Fungsi Isi Data (Menggunakan Class Selector)
  const fill = (className, dataAttr) => {
    const input = modalElement.querySelector(`.${className}`);
    if (input) {
      input.value = button.getAttribute(`data-${dataAttr}`) || "";
    }
  };

  // --- EKSEKUSI FILL DATA ---

  // Logika Router (Baru)
  if (targetId === "modalEditRouter") {
    fill("e_id_router", "id");
    fill("e_divisi", "divisi");
    fill("e_kategori", "kategori");
    fill("e_spesifikasi", "spesifikasi");
    fill("e_link", "link");
    fill("e_mac", "mac");
    fill("e_user_admin", "user_admin");
    fill("e_pass_admin", "pass_admin");
    fill("e_ssid", "ssid");
    fill("e_pass_ssid", "pass_ssid");
    fill("e_ch24", "ch24");
    fill("e_ch50", "ch50");
    // Mengisi kode aset ke input readonly
    fill("e_kode_aset", "kode_aset");
  }

  // Logika Komputer
  fill("e_idkom", "idkom");
  fill("e_dept", "dept");
  fill("e_npengguna", "npengguna");
  fill("e_useraccount", "useraccount");
  fill("e_namapc", "namapc");
  fill("e_kategori_group", "kategori_group");
  fill("e_ipaddreses", "ipaddreses");
  fill("e_kode_aset", "kode_aset");
  fill("e_mac", "mac");
  fill("e_prosesor", "prosesor");
  fill("e_memory", "memory");
  fill("e_storage", "storage");
  fill("e_videog", "videog");
  fill("e_motherboard", "motherboard");
  fill("e_psu", "psu");
  fill("e_cassing", "cassing");
  fill("e_monitor", "monitor");

  // Logika Printer/Scanner
  fill("e_id_printer", "idp");
  fill("e_pengguna", "pengguna");
  fill("e_departemen", "departemen");
  fill("e_kategori_group", "kategori_group");
  fill("e_kode_aset", "kode_aset");
  fill("e_spesifikasi_prangkat", "spesifikasi_perangkat");
  fill("e_ip_perangkat", "ip_perangkat");
  fill("e_perangkat", "perangkat");

  // Logika DVR
  fill("e_id_dvr", "idd");
  fill("e_lokasi", "lokasi");
  fill("e_devisi_dvr", "devisi_dvr");
  fill("e_ip_dvr", "ip_dvr");
  fill("e_channel_dvr", "channel_dvr");
  fill("e_kode_dvr", "kode_dvr");
  fill("e_spesifikasi_dvr", "spesifikasi_dvr");

  // Logika Laptop
  fill("e_id_laptop", "idlap");
  fill("e_devisi_laptop", "devisi_laptop");
  fill("e_pengguna", "pengguna");
  fill("e_ip_laptop", "ip_laptop");
  fill("e_kode_laptop", "kode_laptop");
  fill("e_tipe_laptop", "tipe_laptop");
  fill("e_os", "os");
  fill("e_sn_laptop", "sn_laptop");
  fill("e_prosesor", "prosesor");
  fill("e_ram", "ram");
  fill("e_storage", "storage");

  // 5. Tampilkan Modal
  const myModal = new bootstrap.Modal(modalElement);
  myModal.show();
}

// UNTUK RESET
function resetTable() {
  // Kosongkan semua input
  document.getElementById("dateStart").value = "";
  document.getElementById("dateEnd").value = "";
  document.getElementById("searchInput").value = "";

  // Tampilkan kembali semua baris
  const tr = document.getElementById("itTable").getElementsByTagName("tr");
  for (let i = 1; i < tr.length; i++) {
    tr[i].style.display = "";
  }
}

// Fungsi pencarian search tabel Anda start------
function searchTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("itTable");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    tr[i].style.display = "none";
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        }
      }
    }
  }
}
function exportData(type) {
  // Gunakan proteksi jika elemen tidak ditemukan
  const startInput = document.getElementById("tgl_awal");
  const endInput = document.getElementById("tgl_akhir");

  const start = startInput ? startInput.value : "";
  const end = endInput ? endInput.value : "";

  // Redirect ke file export
  window.location.href = `export_excel.php?type=${type}&start=${start}&end=${end}`;
}
// Fungsi pencarian search tabel Anda end------

// untuk button tarik keatas start
window.onscroll = function () {
  if (window.pageYOffset > 300) {
    document.getElementById("btn-back-to-top").style.display = "flex";
  } else {
    document.getElementById("btn-back-to-top").style.display = "none";
  }
};
// button keata end

// UNTUK BARCODE START____
function prosesCetakMasal() {
  const selected = document.querySelectorAll(".barcode-checkbox:checked");

  if (selected.length === 0) {
    alert("Silakan pilih minimal satu perangkat melalui checkbox!");
    return;
  }

  cetakLabelPersegiKecil(selected);
}

/**
 * FUNGSI CETAK: Bentuk Persegi Kecil (110x110), Header PT + QR Code
 */
function cetakLabelPersegiKecil(selectedElements) {
  const printWindow = window.open("", "_blank", "width=800,height=500");

  let labelContent = "";
  let qrCodesToRender = [];

  selectedElements.forEach((box, index) => {
    const kode = box.getAttribute("data-kode");
    const id = "qrcode-" + index;

    labelContent += `
            <div class="label-box">
                <div class="header">
                    <span class="title">
                        <span class="text-black">PT. </span>
                        <span class="text-yellow">CMBP</span>
                    </span>
                </div>
                <div id="${id}" class="qr-img"></div>
            </div>
        `;
    qrCodesToRender.push({ id: id, kode: kode });
  });

  const fullHTML = `
        <html>
        <head>
            <title>Cetak Label Persegi Kecil</title>
            <style>
                @page { size: auto; margin: 3mm; }
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 0; padding: 10px;
                    display: flex; flex-wrap: wrap; gap: 10px;
                    justify-content: flex-start; 
                }
                .label-box { 
                    border: 1px solid #000; 
                    padding: 5px; 
                    /* UKURAN PERSEGI KECIL */
                    width: 110px; 
                    height: 110px; 
                    text-align: center;
                    background: white;
                    page-break-inside: avoid;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    box-sizing: border-box;
                    overflow: hidden;
                }
                .header { 
                    width: 100%;
                    border-bottom: 1.5px solid #333; 
                    padding-bottom: 3px; 
                    margin-bottom: 5px;
                    text-align: center;
                }
                .title { font-size: 11px; font-weight: bold; line-height: 1; }
                .text-black { color: #000000 !important; }
                .text-yellow { color: #FFD700 !important; } 
                
                .qr-img { 
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-grow: 1;
                }
                /* Ukuran QR Code menyesuaikan kotak 110px */
                .qr-img canvas, .qr-img img {
                    width: 80px !important;
                    height: 80px !important;
                }

                @media print {
                    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                }
            </style>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"><\/script>
        </head>
        <body>
            ${labelContent}
            <script>
                window.onload = function() {
                    const data = ${JSON.stringify(qrCodesToRender)};
                    data.forEach(item => {
                        new QRCode(document.getElementById(item.id), {
                            text: item.kode,
                            width: 80,
                            height: 80,
                            correctLevel : QRCode.CorrectLevel.M
                        });
                    });

                    setTimeout(function() {
                        window.print();
                        window.close();
                    }, 600);

                    window.onafterprint = function() {
                        window.close();
                    };
                };
            <\/script>
        </body>
        </html>
    `;

  printWindow.document.write(fullHTML);
  printWindow.document.close();
}
// BARCODE END ____

// EFEK AGAR TIDAK LKAG SAAT DI SCROL STARTT
// akan menonaktifkan efek berat hanya saat jari/mouse sedang scroll
const body = document.body;
let timer;

window.addEventListener(
  "scroll",
  function () {
    clearTimeout(timer);
    if (!body.classList.contains("disable-hover")) {
      body.classList.add("disable-hover"); // Mematikan pointer-events & hover
    }

    timer = setTimeout(function () {
      body.classList.remove("disable-hover");
    }, 200);
  },
  false
);
// EFEK AGAR TIDAK LKAG SAAT DI SCROL ENDD

// fungsi untuk checbox ALL/ SEMUA barcode start >>>>     JANGAN HAPPUS BISA DI BUTUHKAN
// Fungsi Pilih Semua
// document.getElementById("checkAll").addEventListener("click", function () {
//   const isChecked = this.checked;
//   document.querySelectorAll(".barcode-checkbox").forEach((cb) => {
//     cb.checked = isChecked;
//   });
// });

// // Contoh cara mengambil data yang dicentang untuk dicetak
// function prosesCetakMasal() {
//   const terpilih = document.querySelectorAll(".barcode-checkbox:checked");
//   if (terpilih.length === 0) {
//     alert("Pilih perangkat terlebih dahulu!");
//     return;
//   }

//   terpilih.forEach((cb) => {
//     const kode = cb.getAttribute("data-kode");
//     const user = cb.getAttribute("data-user");
//     console.log("Mencetak:", kode, "atas nama", user);
//     // Panggil fungsi generate barcode Anda di sini
//   });
// }
// checkbox endd >>>>

// UNTUK PENGATURAN TABLE agar halaman teratur start >>>>>>
let currentPage = 1;
let cachedRows = null; // Menyimpan data di memori agar cepat

function initPagination() {
  const tableBody = document.querySelector("table tbody");
  const searchInput = document.getElementById("searchInput");
  const entriesSelect = document.getElementById("entriesPerPage");

  if (!tableBody) return;

  // Ambil baris ke memori hanya sekali (sangat penting untuk ribuan data)
  cachedRows = Array.from(tableBody.querySelectorAll("tr"));

  // 2. Proteksi jika data kosong setelah difilter PHP
  if (cachedRows.length === 0) {
    const container = document.getElementById("floating-pagination-container");
    if (container) container.style.display = "none";
    // Tampilkan pesan "Data tidak ditemukan" di dalam tabel agar informatif
    tableBody.innerHTML =
      '<tr><td colspan="10" class="text-center py-4 text-muted">Data tidak ditemukan untuk periode ini.</td></tr>';
    return;
  }

  const searchTerm = searchInput.value.toLowerCase();
  const entriesPerPage = parseInt(entriesSelect.value);

  // 1. Filter Data (Cepat karena di memori)
  const filteredRows = cachedRows.filter((row) => {
    const text = row.textContent.toLowerCase();
    const isMatch = text.includes(searchTerm);
    row.style.display = "none"; // Sembunyikan semua dulu
    return isMatch;
  });

  // 2. Hitung Total Halaman
  const totalPages = Math.ceil(filteredRows.length / entriesPerPage) || 1;
  if (currentPage > totalPages) currentPage = 1;

  // 3. Tampilkan Data Halaman Aktif
  const start = (currentPage - 1) * entriesPerPage;
  const end = start + entriesPerPage;

  filteredRows.slice(start, end).forEach((row) => {
    row.style.display = "";
  });

  // 4. Update Navigasi < 1 >
  renderPaginationButtons(totalPages);
}

function renderPaginationButtons(totalPages) {
  const wrapper = document.getElementById("paginationWrapper");
  const container = document.getElementById("floating-pagination-container");

  if (!wrapper || !container) return;
  wrapper.innerHTML = "";

  // Tampilkan container jika data lebih dari 1 halaman
  if (totalPages <= 1) {
    container.style.display = "none";
    return;
  } else {
    container.style.display = "flex";
  }

  // Tombol Next (Atas)
  const nextBtn = document.createElement("button");
  nextBtn.className = "custom-page-btn";
  nextBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
  nextBtn.disabled = currentPage === totalPages;
  nextBtn.onclick = () => {
    currentPage++;
    initPagination();
  };

  // Angka Halaman (Tengah)
  const pageNum = document.createElement("button");
  pageNum.className = "custom-page-btn active-page";
  pageNum.innerText = currentPage;

  // Tombol Prev (Bawah)
  const prevBtn = document.createElement("button");
  prevBtn.className = "custom-page-btn";
  prevBtn.innerHTML = '<i class="fas fa-chevron-down"></i>';
  prevBtn.disabled = currentPage === 1;
  prevBtn.onclick = () => {
    currentPage--;
    initPagination();
  };

  // Susun ke dalam wrapper
  const liNext = document.createElement("li");
  liNext.appendChild(nextBtn);
  const liPage = document.createElement("li");
  liPage.appendChild(pageNum);
  const liPrev = document.createElement("li");
  liPrev.appendChild(prevBtn);

  wrapper.appendChild(liNext);
  wrapper.appendChild(liPage);
  wrapper.appendChild(liPrev);
}

// Reset ke halaman 1 saat user mulai mengetik
function resetAndSearch() {
  currentPage = 1;
  initPagination();
}
document.addEventListener("DOMContentLoaded", initPagination);

// UNTUK PENGATURAN TABLE agar halaman teratur end >>>>>>
