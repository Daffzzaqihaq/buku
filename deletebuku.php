<?php
header("Content-Type: application/json; charset=UTF-8");
// Memasukan koneksi untuk menggunakna connnection
include './config/koneksi.php';

// Kita cek methode POST atau bukan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // pengecekan parameter inputan user
    if (isset($_POST["idbuku"]) &&
        isset($_POST["fotobuku"])) {

    	// Memasukan data yang sudah dikirim oleh user di dalam parameter ke variable penampung baru
    	$idbuku = $_POST["idbuku"];
        $fotobuku = $_POST["fotobuku"];

        // Membuat query untuk delete
        $query = "DELETE FROM tb_buku WHERE id_buku = '$idbuku'";
        // Mengeksekusi query delete dan langsung mengecek apakah berhasil atau tidak
        if (mysqli_query($connection, $query)) {

        	// Menghapus image sebelumnya
        unlink("./uploads/" . $fotobuku);

        	// Mengisi respon dengan pesan berhasil delete
        	$response['result'] = 1;
        	$response['message'] = "Data buku berhasil dihapus !";
        	# code...
        }else{
        	// Apabila gagal melakukan query tampilkan pesan gagal
        	$response['result'] = 0;
        	$response['message'] = "Maaf! menghapus data gagal";
        }
    
     }else{
            // Apabila gagal melakukan query tampilkan pesan gagal
        	$response['result'] = 0;
        	$response['message'] = "Maaf! menghapus data gagal, Data Kurang !";

     }

     // Merubah response menjadi JSON
     echo json_encode($response);

     // Mematikan koneksi
     mysqli_query($connnection);
}










?>