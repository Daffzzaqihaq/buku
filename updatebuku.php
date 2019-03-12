<?php
header("Content-Type: application/json; charset=UTF-8");
// Memasukan koneksi untuk menggunakna connnection
include './config/koneksi.php';

// Membuat nama folder upload image
   $upload_path = 'uploads/';

   // Mengambil ip server
   $server_ip = gethostbyname(gethostname());

   // Membuat url upload
   $upload_url = 'http://'.$server_ip.'/buku/'.$upload_path;

// Membuat penampung response array
$response = array();

// Kita cek methode POST atau bukan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // pengecekan parameter inputan usser
    if (isset($_POST["idbuku"]) &&
    	isset($_POST["idkategori"]) &&
    	isset($_POST["namabuku"]) &&
    	isset($_POST["descbuku"]) &&
        isset($_POST["fotobuku"]) &&
        isset($_POST["inserttime"])) {

    	// Memasukan inputan user ke dalam variable
    	$idbuku =  $_POST["idbuku"];
        $idkategori = $_POST["idkategori"];
        $namabuku = $_POST["namabuku"];
        $descbuku = $_POST["descbuku"];
        $inserttime = $_POST["inserttime"];
        $fotobuku = $_POST["fotobuku"];
        $image = $_FILES["image"]['tmp_name'];

        if (isset($image)) {
            // Menghapus image sebelumnya
            unlink("./uploads/" . $fotobuku);

            // Menghilangkan nama dan mengambil extension file
            $temp = explode(".", $_FILES["image"]["name"]);

            // Menggambungkan nama baru dengan extension
            $newfilename = round(microtime(true)) . '.' . end($temp);

            // Memasukan file ke dalam folder
            move_uploaded_file($image, $upload_path . $newfilename);

            // Memasukan inputan user ke dalam database menggunakan operasi insert
            $sql = "UPDATE tb_buku SET id_kategori = '$idkategori',
                                          nama_buku = '$namabuku',
                                          desc_buku = '$descbuku',
                                          insert_time = '$inserttime',
                                          foto_buku = '$newfilename'
                                          WHERE id_buku = $idbuku";
        }else{
            // Mengisi variable $bewfilename dengan nama file yg sebelumnya
            // Membuat query update tanpa kolom foto_makanan
            $sql = "UPDATE tb_buku SET id_kategori = '$idkategori',
                                          nama_buku = '$namabuku',
                                          desc_buku = '$descbuku',
                                          insert_time = '$inserttime'
                                          WHERE id_buku = $idbuku";
        }

        // Melakukan operasi update dengan perintah yang sudah kita buat di dalam variable $sql
        // dan langsung cek apakah eksekusinya berhasil
        if (mysqli_query($connection, $sql)) {
            // Memasukan pesan berhasil ke response
            $response["result"] = 1;
            $response["message"] = "Update berhasil";
            $response['url'] = $upload_url . $newfilename;
            $response['name'] = $namabuku;
        }else{
            // Menampilkan pesan gagal update
            $response["result"] = 0;
            $response["message"] = "Update gagal";
        }
    }else{
               // Menampilkan pesan gagal update
               $response["result"] = 0;
               $response["message"] = "Update gagal, data kurang";
         }

         // Mengubah response menjadi JSOn
         echo json_encode($response);
    }













?>