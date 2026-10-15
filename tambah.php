<?php
include 'koneksi.php';
include 'upload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $foto = simpanFoto($_FILES['foto'] ?? null);
  $stmt = $conn->prepare(
    "INSERT INTO menu (nama, kategori, harga, deskripsi, halal, alergen, foto) VALUES (?,?,?,?,?,?,?)");
  $stmt->bind_param("ssissss",
    $_POST['nama'], $_POST['kategori'], $_POST['harga'],
    $_POST['deskripsi'], $_POST['halal'], $_POST['alergen'], $foto);
  $stmt->execute();
  header("Location: admin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><title>Tambah Menu</title>
  <style>
    body{font-family:Arial,sans-serif;margin:30px;max-width:520px}
    input,select,textarea{width:100%;padding:8px;box-sizing:border-box}
    label{display:block;margin-top:12px;font-weight:bold}
    button{margin-top:18px;padding:9px 18px}
  </style>
</head>
<body>
  <h1>Tambah Menu</h1>
  <form method="post" enctype="multipart/form-data">
    <label>Nama</label>
    <input type="text" name="nama" required>

    <label>Kategori</label>
    <select name="kategori">
      <option>Main Course</option><option>Dessert</option><option>Drink</option>
    </select>

    <label>Harga (Rp)</label>
    <input type="number" name="harga" value="0" min="0">

    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="3" placeholder="Contoh: Nasi goreng dengan telur mata sapi dan acar"></textarea>

    <label>Status Halal</label>
    <select name="halal">
      <option>Halal</option><option>Non-Halal</option>
    </select>

    <label>Alergen (pisahkan dengan koma)</label>
    <input type="text" name="alergen" placeholder="Contoh: Telur, Kacang, Susu">

    <label>Foto (JPG/PNG/WEBP, maks 2 MB)</label>
    <input type="file" name="foto" accept="image/*">

    <button type="submit">Simpan</button>
    <a href="admin.php">Batal</a>
  </form>
</body>
</html>
