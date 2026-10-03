<?php
require_once "koneksi.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari form
    $kode = trim($_POST["kode"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $semester = (int) ($_POST["semester"] ?? 0);
    $dosen_id = trim($_POST["dosen_id"] ?? "");
    // SKS boleh diisi atau dikosongkan
    $sks = ($_POST["sks"] ?? "") !== ""
        ? (int) $_POST["sks"]
        : null;
    // Validasi data
    if (
        $kode === "" ||
        $nama === "" ||
        $semester < 1 ||
        $semester > 14 ||
        ($sks !== null && ($sks < 1 || $sks > 6))
    ) {

        $error = "Mohon isi data dengan benar.";

    } else {

        try {

            // Query untuk menyimpan data
            $sql = "INSERT INTO mata_kuliah
                    (kode, nama, semester, dosen_id, sks)
                    VALUES
                    (:kode, :nama, :semester, :dosen_id, :sks)";

            $stmt = $koneksi->prepare($sql);

            // Jalankan query
            $stmt->execute([
                ":kode" => $kode,
                ":nama" => $nama,
                ":semester" => $semester,
                ":dosen_id" => $dosen_id === "" ? null : $dosen_id,
                ":sks" => $sks
            ]);

            // Jika berhasil, langsung ke halaman daftar mata kuliah
            header("Location: ./mata-kuliah.php");
            exit;

        } catch (PDOException $e) {

            $error = "Gagal menyimpan data. Pastikan kode belum digunakan dan dosen_id valid.";

            // Untuk sementara jika ingin melihat error database sebenarnya,
            // kamu bisa menggunakan:
            // $error = "Gagal menyimpan data: " . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Tambah Mata Kuliah</h2>
    <!-- Pesan error -->
    <?php if ($error !== "") { ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php } ?>
    <!-- Form Tambah Mata Kuliah -->
    <form method="POST">
        <!-- Kode Mata Kuliah -->
        <div class="mb-3">
            <label class="form-label">Kode Mata Kuliah</label>
            <input
                type="text"
                name="kode"
                class="form-control"
                placeholder="Contoh: ICT015"
                value="<?= htmlspecialchars($_POST["kode"] ?? "") ?>"
                required>
        </div>
        <!-- Nama Mata Kuliah -->
        <div class="mb-3">
            <label class="form-label">Nama Mata Kuliah</label>
            <input
                type="text"
                name="nama"
                class="form-control"
                placeholder="Contoh: Pemrograman Web"
                value="<?= htmlspecialchars($_POST["nama"] ?? "") ?>"
                required>
        </div>
        <!-- Semester -->
        <div class="mb-3">
            <label class="form-label">Semester</label>
            <input
                type="number"
                name="semester"
                class="form-control"
                min="1"
                max="14"
                placeholder="Contoh: 3"
                value="<?= htmlspecialchars($_POST["semester"] ?? "") ?>"
                required>
        </div>
        <!-- Dosen -->
        <div class="mb-3">
            <label class="form-label">ID Dosen (opsional)</label>
            <input
                type="number"
                name="dosen_id"
                class="form-control"
                placeholder="Kosongkan jika belum ada"
                value="<?= htmlspecialchars($_POST["dosen_id"] ?? "") ?>">
        </div>
        <!-- SKS -->
        <div class="mb-3">
            <label class="form-label">SKS</label>
            <input
                type="number"
                name="sks"
                class="form-control"
                min="1"
                max="6"
                placeholder="Kosongkan jika belum ada"
                value="<?= htmlspecialchars($_POST["sks"] ?? "") ?>">
        </div>
        <!-- Tombol -->
        <button type="submit"class="btn btn-primary">Simpan</button>
        <a href="mata-kuliah.php"class="btn btn-secondary">Kembali</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
