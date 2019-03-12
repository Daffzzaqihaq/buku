<?php
// Memasukan koneksi.php ke dalam file ini agar nanti bisa mengakses phpMyAdmin
include './config/koneksi.php';

// Membuat penampung response Array
$response = array();

// Pengeekan methode methode yg di Request oleh User, harus methode Post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pengecekan parameter yang dibutuhkan
	if (isset($_POST["username"]) && 
		isset($_POST["password"]) && 
		isset($_POST["namauser"]) && 
			isset($_POST["alamat"]) && 
			isset($_POST["jenkel"]) && 
			isset($_POST["notelp"])) {
		
		// Memasukan data yg sudah dikirim oleh user di dalam Parameter ke variable penampung Baru
		$username = $_POST["username"];
	    $password = md5($_POST["password"]);
	    $namauser = $_POST["namauser"];
	    $alamat = $_POST["alamat"];
	    $jenkel = $_POST["jenkel"];
	    $notelp = $_POST["notelp"];
	   
	   // Pengecekan data username apakah sudah terpakai
	    // Membuat Query untuk mencari username yang sama di database
	    $sql = "SELECT * FROM tb_user WHERE username = '$username' ";

	    $check = mysqli_fetch_array(mysqli_query($connection, $sql));
	    // Melakukan pengecekan di dalam variable $check
	    if (isset($check)) {
	    	// Membuat response untuk JSON pada saat username sudah terdaftar
	    	$response["result"] = 0;
	    	$response["message"] = "Oops!, username sudah terpakai";
	    	
	    	}else{
	    	// Memasukan inputan user ke dalam database menggunakan operasi INSERT
	    	$sql = "INSERT INTO tb_user(
	    	nama_user, 
	    	alamat, 
	    	jenkel, 
	    	no_telp, 
	    	username, 
	    	password 
	    	
	    ) VALUES(
	        '$namauser',
	        '$alamat',
	        '$jenkel',
	        '$notelp',
	        '$username',
	        '$password'
	    )";

	    // Melakukan operasi insert dengan perintah yg sudah kita buat di dalam Variable $sql
        // Dan langsung mengecek apakah eksekusinya berhasil apa kagak
        if (mysqli_query($connection, $sql)) {
        	    // Berhasil masukkan pesan berhasil ke response
        	$response["result"] = 1;
        	$response["message"] = "Register Berhasil";
        }else{
        	// Menampilkan pesan gagal Regristasi
        	$response["result"] = 0;
        	$response["message"] = "Register Gagal";
        }

	    }

	    // Menampilkan response dalam bentuk JSON
	    echo json_encode($response);

	}
}




?>