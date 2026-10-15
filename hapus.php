<?php
include 'koneksi.php';
$id = (int) $_GET['id'];

// hapus file foto-nya juga
$stmt = $conn->prepare("SELECT foto FROM menu WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$m = $stmt->get_result()->fetch_assoc();
if ($m && $m['foto'] && file_exists(__DIR__ . '/uploads/' . $m['foto'])) {
  unlink(__DIR__ . '/uploads/' . $m['foto']);
}

$stmt = $conn->prepare("DELETE FROM menu WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: admin.php");
exit;
