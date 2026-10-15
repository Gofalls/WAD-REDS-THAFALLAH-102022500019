<?php
require "koneksi.php";
require "pilihan.php";

$error = "";

// Isi awal form (kosong = mode tambah)
$data = [
    "id_lapangan"     => 0,
    "nama_lapangan"   => "",
    "jenis_permukaan" => "",
    "ukuran"          => "",
    "status_lapangan" => "tersedia",
];

// Kalau ada ?edit=ID di alamat, ambil data lama untuk mengisi form
$id_edit = (int) ($_GET["edit"] ?? 0);
if ($id_edit > 0) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM lapangan WHERE id_lapangan = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_edit);
    mysqli_stmt_execute($stmt);
    $baris = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if ($baris) {
        $data = $baris;
    }
}

// Kalau tombol Simpan ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = (int) $_POST["id_lapangan"];
    $nama   = trim($_POST["nama_lapangan"]);
    $jenis  = $_POST["jenis_permukaan"];
    $ukuran = trim($_POST["ukuran"]);
    $status = $_POST["status_lapangan"];

    if ($nama == "" || $ukuran == "" || !isset($label_jenis[$jenis]) || !isset($label_status[$status])) {
        $error = "Semua kolom wajib diisi dengan benar.";

        // Biar isian tidak hilang saat error
        $data = [
            "id_lapangan"     => $id,
            "nama_lapangan"   => $nama,
            "jenis_permukaan" => $jenis,
            "ukuran"          => $ukuran,
            "status_lapangan" => $status,
        ];
    } else {
        if ($id > 0) {
            // id ada = UBAH data lama
            $stmt = mysqli_prepare(
                $koneksi,
                "UPDATE lapangan SET nama_lapangan = ?, jenis_permukaan = ?, ukuran = ?, status_lapangan = ? WHERE id_lapangan = ?"
            );
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $jenis, $ukuran, $status, $id);
            $kode_pesan = "edit";
        } else {
            // id kosong = TAMBAH data baru
            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO lapangan (nama_lapangan, jenis_permukaan, ukuran, status_lapangan) VALUES (?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $jenis, $ukuran, $status);
            $kode_pesan = "tambah";
        }
        mysqli_stmt_execute($stmt);

        header("Location: index.php?pesan=" . $kode_pesan);
        exit;
    }
}

// Apakah form sedang dalam mode edit?
$mode_edit = ((int) $data["id_lapangan"] > 0);

// Ambil semua data untuk tabel
$hasil = mysqli_query($koneksi, "SELECT * FROM lapangan ORDER BY id_lapangan ASC");

// Teks pesan yang boleh muncul
$daftar_pesan = [
    "tambah" => "Data lapangan berhasil ditambahkan.",
    "edit"   => "Data lapangan berhasil diubah.",
    "hapus"  => "Data lapangan berhasil dihapus.",
];
$kode_pesan = $_GET["pesan"] ?? "";
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lapangan & Area</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <?php if (isset($daftar_pesan[$kode_pesan])) { ?>
      <div class="pesan"><?= $daftar_pesan[$kode_pesan] ?></div>
    <?php } ?>

    <?php if ($error != "") { ?>
      <div class="pesan pesan-error"><?= $error ?></div>
    <?php } ?>

    <!-- ===== FORM (di atas) ===== -->
    <div class="area-Form <?= $mode_edit ? "edit" : "" ?>">
      <section>
        <form method="post" action="index.php">
          <input type="hidden" name="id_lapangan" value="<?= (int) $data["id_lapangan"] ?>" />

          <div class="form-group">
            <label for="nama_lapangan">Nama / ID Lapangan</label>
            <input type="text" id="nama_lapangan" name="nama_lapangan"
                   placeholder="Lapangan Basket"
                   value="<?= htmlspecialchars($data["nama_lapangan"]) ?>" required />
          </div>

          <div class="form-group">
            <label for="jenis_permukaan">Jenis Rumput</label>
            <select id="jenis_permukaan" name="jenis_permukaan" required>
              <option value="">Pilih jenis</option>
              <?php foreach ($label_jenis as $nilai => $teks) { ?>
                <option value="<?= $nilai ?>"
                  <?= $nilai == $data["jenis_permukaan"] ? "selected" : "" ?>>
                  <?= $teks ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label for="ukuran">Ukuran (Meter)</label>
            <input type="text" id="ukuran" name="ukuran"
                   placeholder="Contoh: 25x15"
                   value="<?= htmlspecialchars($data["ukuran"]) ?>" required />
          </div>

          <div class="form-group">
            <label for="status_lapangan">Status Lapangan</label>
            <select id="status_lapangan" name="status_lapangan" required>
              <?php foreach ($label_status as $nilai => $teks) { ?>
                <option value="<?= $nilai ?>"
                  <?= $nilai == $data["status_lapangan"] ? "selected" : "" ?>>
                  <?= $teks ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="form-action">
            <button type="submit">
              <?= $mode_edit ? "Simpan Perubahan" : "Simpan Data Lapangan" ?>
            </button>
            <?php if ($mode_edit) { ?>
              <a href="index.php" class="btn-batal">Batal</a>
            <?php } ?>
          </div>
        </form>
      </section>
    </div>

    <!-- ===== TABEL (di bawah) ===== -->
    <div class="area-Table">
      <section>
        <table>
          <thead>
            <tr>
              <th>ID Lapangan</th>
              <th>Nama Lapangan</th>
              <th>Jenis Rumput</th>
              <th>Ukuran</th>
              <th>Status Fisik</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($hasil) == 0) { ?>
              <tr>
                <td colspan="6">Belum ada data lapangan.</td>
              </tr>
            <?php } ?>

            <?php while ($baris = mysqli_fetch_assoc($hasil)) { ?>
              <tr>
                <td><?= $baris["id_lapangan"] ?></td>
                <td><?= htmlspecialchars($baris["nama_lapangan"]) ?></td>
                <td><?= $label_jenis[$baris["jenis_permukaan"]] ?? "-" ?></td>
                <td><?= htmlspecialchars($baris["ukuran"]) ?></td>
                <td><?= $label_status[$baris["status_lapangan"]] ?? "-" ?></td>
                <td>
                  <a href="index.php?edit=<?= $baris["id_lapangan"] ?>">Edit</a> |
                  <a href="hapus.php?id=<?= $baris["id_lapangan"] ?>"
                     onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </section>
    </div>
  </body>
</html>