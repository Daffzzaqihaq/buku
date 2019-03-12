<?php
// Memasukan koneksi untuk menggunakna connnection
include './config/koneksi.php';

// Membuat penampung response array
$response = array();

// Cek apakah method POST apa bukan ?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// Mengecek parameter inputan user
	if (isset($_POST["iduser"]) &&
        isset($_POST["namauser"]) &&
        isset($_POST["alamat"]) &&
        isset($_POST["jenkel"]) &&
        isset($_POST["notelp"])
) {
        // Memasukan inputan user ke dalam variable
		$iduser = $_POST("iduser");
	    $namauser = $_POST("namauser");
	    $alamat = $_POST("alamat");
	    $jenkel = $_POST("jenkel");
	    $notelp = $_POST("notelp");

	    // Buat query untuk mengupdate ke database
	     $query = "UPDATE tb_user SET nama_user = '$namauser', alamat = '$alamat', jenkel = '$jenkel', no_telp = '$notelp' WHERE id_user = '$iduser'";


	     if (mysqli_query($connection, $query)) {
	     	$response["result"] = 1;
        	$response["message"] = "Update berhasil";
	     }else{
	     	$response["result"] = 0;
        	$response["message"] = "Update gagal";
	     }

	     echo json_encode($response);
		
	}
}


?>