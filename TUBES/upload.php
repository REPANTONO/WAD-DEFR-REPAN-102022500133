<?php
// Fungsi bantu upload foto menu. Mengembalikan nama file yang tersimpan di folder uploads/
function simpanFoto($f, $lama = '') {
  if (!isset($f) || $f['error'] === UPLOAD_ERR_NO_FILE) return $lama;   // tidak upload baru
  if ($f['error'] !== UPLOAD_ERR_OK) return $lama;
  if ($f['size'] > 2 * 1024 * 1024) die("Ukuran foto maksimal 2 MB.");

  $info = getimagesize($f['tmp_name']);
  $ok = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
  if (!$info || !isset($ok[$info[2]])) die("Format foto harus JPG, PNG, atau WEBP.");

  $dir = __DIR__ . '/uploads';
  if (!is_dir($dir)) mkdir($dir, 0777, true);

  $nama = 'menu_' . bin2hex(random_bytes(6)) . '.' . $ok[$info[2]];
  move_uploaded_file($f['tmp_name'], "$dir/$nama");

  if ($lama && file_exists("$dir/$lama")) unlink("$dir/$lama");          // hapus foto lama
  return $nama;
}
