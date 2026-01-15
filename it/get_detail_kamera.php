<?php
include 'function.php';

if (isset($_POST['devisi'])) {
    $devisi = $_POST['devisi'];

    // PERBAIKAN: Ganti 'nbarang' menjadi 'nama_kamera' (sesuai struktur awal Anda)
    // Jika di database kolomnya bernama 'nkamera', silakan ganti menjadi nkamera
    $query = "SELECT nkamera, lokasi, tgl_update FROM tbl_cctv WHERE devisi = ?";

    if ($stmt = $c->prepare($query)) {
        $stmt->bind_param("s", $devisi);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table style="width:100%; border-collapse: collapse; color: white; font-size: 0.85rem;">';
            echo '<thead style="background: rgba(0, 255, 255, 0.1);">';
            echo '<tr>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid var(--accent-cyan); width: 50px;">NO</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--accent-cyan);">NAMA KAMERA</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--accent-cyan);">LOKASI</th>
                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid var(--accent-cyan);">TGL UPDATE</th>
                  </tr></thead><tbody>';

            $no = 1;
            while ($row = $result->fetch_assoc()) {
                $tanggal = ($row['tgl_update'] && $row['tgl_update'] != '0000-00-00')
                    ? date('d/m/Y', strtotime($row['tgl_update']))
                    : '<span style="opacity:0.5;">-</span>';

                echo "<tr style='border-bottom: 1px solid rgba(255,255,255,0.05); transition: 0.3s;' onmouseover=\"this.style.background='rgba(255,255,255,0.03)'\" onmouseout=\"this.style.background='transparent'\">
                        <td style='padding: 12px; text-align: center; color: #a0aec0;'>" . $no++ . "</td>
                        <td style='padding: 12px; font-weight: 500;'>
                            <i class='fas fa-video' style='margin-right:8px; color:var(--accent-cyan); font-size: 0.7rem;'></i>
                            " . htmlspecialchars($row['nkamera']) . " 
                        </td>
                        <td style='padding: 12px;'>
                            <i class='fas fa-map-marker-alt' style='margin-right:8px; color:#f56565; font-size: 0.7rem;'></i>
                            " . htmlspecialchars($row['lokasi']) . "
                        </td>
                        <td style='padding: 12px; text-align: center; color: #cbd5e0;'>
                            " . $tanggal . "
                        </td>
                      </tr>";
            }
            echo '</tbody></table>';
        } else {
            echo '<div style="text-align:center; padding:40px; color: #718096;">
                    <i class="fas fa-search" style="font-size: 3rem; margin-bottom:15px; opacity:0.2;"></i>
                    <p>Tidak ditemukan kamera di Devisi: <b style="color:#fff;">' . htmlspecialchars($devisi) . '</b></p>
                  </div>';
        }
        $stmt->close();
    } else {
        echo "<div style='color:#ff4d4d; padding:20px;'>Database Error: " . htmlspecialchars($c->error) . "</div>";
    }
}
