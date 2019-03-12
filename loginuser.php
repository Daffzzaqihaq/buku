<?php
     // Memasukan koneksi.php ke dalam file ini agar nanti bisa mengakses phpMyAdmin
     include './config/koneksi.php';

     // Membuat penampung response
     $response = array();

     // Mengecek apakah parameter yg dikirimkan itu ada apa gak?
     if (isset($_POST["username"]) && isset($_POST["password"])) {
     	// Kita masukan inputan user ke dalam variable
     	$username = $_POST["username"];
     	$password = md5($_POST["password"]);

     	// Membuat Query untuk mengambil detail user
     	$sql = "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'";
     	$check = mysqli_query($connection, $sql);

     	// Kita cek apakah berhasil atau gk
     	if (!$check) {
        	echo 'Tidak bisa menjalankan query ' . mysqli_error($connection);
        	exit; 
     }

     // Memasukan data hasil query tadi ke dalam variable
     // Mengambil baris pertama dari hasil query
        $row = mysqli_fetch_row($check);

        // Membuat hasil dimasukan ke dalam Array
        $result_data = array(
        	'id_user' => $row[0],
        	'nama_user' => $row[1],
        	'alamat' => $row[2],
        	'jenkel' => $row[3],
        	'no_telp' => $row[4],
        	'username' => $row[5],
        	'password' => $row[6]

        );

        // Mengecek data apakah dia ada atau gak
        if (mysqli_num_rows($check) > 0) {
        	// Mengisi pesan berhasil ke response
        	$response['result'] = "1";
        	$response['message'] = "Berhasil Login!";
        	$response['data'] = $result_data;
        }else{
        	// Mengisi pesan gagal ke response
        	$response['result'] = "0";
        	$response['message'] = "Gagal login!";
        }

        // Mengubah responsenya menjadi JSON
        echo json_encode($response); 

    }


?>