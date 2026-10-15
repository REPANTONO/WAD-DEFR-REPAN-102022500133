<?php
$conn = new mysqli("localhost", "root", "", "restoran_sxio");
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
