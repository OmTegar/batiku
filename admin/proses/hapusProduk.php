<?php 
  // require('../config/db.php');
  include '../config/db.php';
  $idProduk = $_GET['id_produk'];
  $query = mysqli_query($conn, "DELETE FROM tabel_produk WHERE idProduk = '$idProduk' ");
  if($query){
    echo '
      <script>
      alert("Produk berhasil dihapus !");
      window.location = "../admin.php";
      </script>
    ';
  }

 ?>