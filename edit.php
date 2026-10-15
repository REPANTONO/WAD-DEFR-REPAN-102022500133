<?php
include 'koneksi.php';
include 'upload.php';
$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM menu WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$m = $stmt->get_result()->fetch_assoc();
if (!$m) die("Menu tidak ditemukan.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $foto = simpanFoto($_FILES['foto'] ?? null, $m['foto']);   // kalau tidak upload baru, foto lama dipakai
  $stmt = $conn->prepare(
    "UPDATE menu SET nama=?, kategori=?, harga=?, deskripsi=?, halal=?, alergen=?, foto=? WHERE id=?");
  $stmt->bind_param("ssissssi",
    $_POST['nama'], $_POST['kategori'], $_POST['harga'],
    $_POST['deskripsi'], $_POST['halal'], $_POST['alergen'], $foto, $id);
  $stmt->execute();
  header("Location: admin.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><title>Edit Menu</title>
  <style>
    body{font-family:Arial,sans-serif;margin:30px;max-width:520px}
    input,select,textarea{width:100%;padding:8px;box-sizing:border-box}
    label{display:block;margin-top:12px;font-weight:bold}
    button{margin-top:18px;padding:9px 18px}
    img.pre{width:140px;border-radius:6px;margin-top:6px}
  </style>
</head>
<body>
  <h1>Edit Menu</h1>
  <form method="post" enctype="multipart/form-data">
    <label>Nama</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($m['nama']) ?>" required>

    <label>Kategori</label>
    <select name="kategori">
      <?php foreach (['Main Course','Dessert','Drink'] as $k): ?>
        <option <?= $m['kategori'] === $k ? 'selected' : '' ?>><?= $k ?></option>
      <?php endforeach; ?>
    </select>

    <label>Harga (Rp)</label>
    <input type="number" name="harga" value="<?= $m['harga'] ?>" min="0">

    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="3"><?= htmlspecialchars($m['deskripsi'] ?? '') ?></textarea>

    <label>Status Halal</label>
    <select name="halal">
      <?php foreach (['Halal','Non-Halal'] as $h): ?>
        <option <?= $m['halal'] === $h ? 'selected' : '' ?>><?= $h ?></option>
      <?php endforeach; ?>
    </select>

    <label>Alergen (pisahkan dengan koma)</label>
    <input type="text" name="alergen" value="<?= htmlspecialchars($m['alergen']) ?>">

    <label>Foto</label>
    <?php if ($m['foto']): ?>
      <img class="pre" src="uploads/<?= htmlspecialchars($m['foto']) ?>" alt="foto saat ini"><br>
      <small>Pilih file baru hanya jika ingin mengganti foto.</small>
    <?php endif; ?>
    <input type="file" name="foto" accept="image/*">

    <button type="submit">Update</button>
    <a href="admin.php">Batal</a>
  </form>
</body>
</html>
