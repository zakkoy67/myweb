<?php
require_once "koneksi.php";

$query = $koneksi->query("SELECT * FROM mata_kuliah");
$mata_kuliah = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mata Kuliah</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
        
<div class="container mt-3">
    <div class="row">
        <div class="col-6">
        <h1>Daftar Mata Kuliah</h1>
        </div>
        <div class="col-6 text-end">
        <a class="btn btn-primary" href="tambah-matkul.php">Tambah Matkul</a>
    </div>
        <table class="table">
        <thead>
            <tr>
            <th scope="col">Kode </th>
            <th scope="col">Mata kuliah</th>
            <th scope="col">Dosen</th>
            <th scope="col">sks</th>
            <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mata_kuliah as $mk) { ?>
                <tr>
                    <td><?= htmlspecialchars($mk['kode']) ?></td>
                    <td><?= htmlspecialchars($mk['nama']) ?></td>
                    <td>
                        <?= $mk['dosen_id'] !== null
                            ? htmlspecialchars($mk['dosen_id'])
                            : '-' ?>
                    </td>
                    <td>
                        <?= $mk['sks'] !== null
                            ? htmlspecialchars((string) $mk['sks'])
                            : '-' ?>
                    </td>
                        <td>
                            <a href="edit-matkul.php?kode=<?= $data['kode'] ?>" 
                            class="btn btn-warning btn-sm">Edit</a>

                            <a href="hapus-matkul.php?kode=<?= $data['kode'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Apakah kamu yakin ingin menghapus mata kuliah ini?')">Hapus</a>
                        </td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
        </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>