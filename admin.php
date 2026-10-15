<?php
include 'koneksi.php';
$hasil = $conn->query("SELECT * FROM menu ORDER BY kategori, id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin Menu SXIO</title>
  <style>
    body{font-family:Arial,sans-serif;margin:30px}
    table{border-collapse:collapse;margin-top:15px}
    th,td{border:1px solid #999;padding:8px 12px;vertical-align:top}
    th{background:#eee}
    td img{width:70px;height:70px;object-fit:cover;border-radius:6px}
    .btn{padding:6px 12px;background:#2d6a4f;color:#fff;text-decoration:none;border-radius:4px}
    .hapus{background:#c0392b}
    .halal{color:#1b7a3d;font-weight:bold}
    .non{color:#c0392b;font-weight:bold}
  </style>
</head>
<body>
  <h1>Kelola Menu Restoran SXIO</h1>
  <a class="btn" href="tambah.php">+ Tambah Menu</a>
  <a href="index.php">Lihat halaman pelanggan</a>

  <table>
    <tr>
      <th>No</th><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th>
      <th>Deskripsi</th><th>Halal</th><th>Alergen</th><th>Aksi</th>
    </tr>
    <?php $no = 1; while ($r = $hasil->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $r['foto'] ? '<img src="uploads/'.htmlspecialchars($r['foto']).'" alt="">' : '-' ?></td>
      <td><?= htmlspecialchars($r['nama']) ?></td>
      <td><?= $r['kategori'] ?></td>
      <td>Rp <?= number_format($r['harga'], 0, ',', '.') ?></td>
      <td style="max-width:220px"><?= htmlspecialchars($r['deskripsi'] ?? '') ?></td>
      <td class="<?= $r['halal'] === 'Halal' ? 'halal' : 'non' ?>"><?= $r['halal'] ?></td>
      <td><?= htmlspecialchars($r['alergen']) ?: '-' ?></td>
      <td>
        <a class="btn" href="edit.php?id=<?= $r['id'] ?>">Edit</a>
        <a class="btn hapus" href="hapus.php?id=<?= $r['id'] ?>"
           onclick="return confirm('Yakin hapus menu ini?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
