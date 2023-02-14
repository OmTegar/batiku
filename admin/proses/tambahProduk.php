<?php
include '../config/db.php';

$UploadDir = 'image/';

if (isset($_POST['upload'])) {
  include '../config/db.php';

  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
  $harga = mysqli_real_escape_string($conn, $_POST['harga']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $ukuran = mysqli_real_escape_string($conn, $_POST['ukuran']);
  $stock = mysqli_real_escape_string($conn, $_POST['stock']);

  $file = $_FILES['foto'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png', 'gif');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize < 1000000) {
        $fileNameNew = md5(($fileName) . time()) . "." . $fileActualExt;
        $fileDestination = $UploadDir . $fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);

        $query = mysqli_query($conn, "INSERT INTO tabel_produk (nama, gambar, ukuran, keterangan, kategori, harga, stock, path, size) VALUES ('$nama', '$fileNameNew', '$ukuran', '$keterangan', '$kategori', '$harga', '$stock', '$fileDestination', '$fileSize')");

        if ($query) {
          echo '
                       <script>
                         alert("Produk ditambahkan");
                         window.location = "../admin.php"
                       </script>
                     ';
        } else {
          echo '
                     <script>
                         alert("Gagal menambahkan produk. Silahkan coba lagi.");
                         window.location="../admin.php"
                     </script>
                   ';
        }
      } else {
        echo '
                     <script>
                         alert("Ukuran file terlalu besar. Ukuran file maksimal 1MB.");
                         window.location="../admin.php"
                     </script>
                   ';
      }
    } else {
      echo '
                 <script>
                     alert("Ada kesalahan saat mengupload file. Silahkan coba lagi.");
                     window.location="../admin.php"
                     </script>
                     ';
    }
  } else {
    echo '
                     <script>
                     alert("Jenis file yang diperbolehkan hanya jpg, jpeg, png, dan gif.");
                     window.location="../admin.php"
                     </script>
                     ';
  }
}
