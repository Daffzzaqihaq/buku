<?php

header("Content-Type: application/json; charset=UTF-8");
include './config/koneksi.php';

    // Membuat folder upload image
   $upload_path = 'uploads/';

   // Mengambil ip server
   $server_ip = gethostbyname(gethostname());

   // Membuat url upload
   $upload_url = 'http://'.$server_ip.'/buku/'.$upload_path;

   // Membuat folder uploads apabila folder tidak ada
   if (!is_dir($upload_url)) {
      // Perintah membuat folder
      mkdir("uploads",0775,true);
   }

   // Membuat response array
   $response = array();

   // Cek method POST
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
      $iduser = $_POST['iduser'];
      $idkategori = $_POST['idkategori'];
      $namabuku = $_POST['namabuku'];
      $descbuku = $_POST['descbuku'];
      $timeinsert = $_POST['timeinsert'];

      // Membuat try catch agar mencoba menyimpan file ke direktori dengan aman
      try {
        // Mengambil namanya
        $temp = explode(".", $_FILES["image"]["name"]);
        // Menggambungkan nama baru dengan extension
        $newfilename = round(microtime(true)) . '.' . end($temp); 

        // Mmasukan file ke dalam folder
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $newfilename);

        $query = "INSERT INTO tb_buku (
                  id_user,
                  id_kategori,
                  nama_buku,
                  desc_buku,
                  foto_buku,
                  insert_time
                    )
                    VALUES (
                    '$iduser',
                    '$idkategori',
                    '$namabuku',
                    '$descbuku',
                    '$newfilename',
                    '$timeinsert'
                )";

                // Mengeksekusi query dan langsung mengecek apakah berhasil atau tidak
                if (mysqli_query($connection, $query)) {
                    $response['result'] = 1;
                    $response['message'] = "Upload Successfully";
                    $response['url'] = $upload_url . $newfilename;
                    $response['name'] = $namabuku;
                  }else {
                    // Menampilkan pesan error
                    $response['result'] = 0;
                     $response['message'] = "Upload Failed";
                  }

                

      } catch (Exception $e) {
        $response['result'] = 0;
        $response['message'] = $e->getMessage();
      }


                  // displaying the response JSON
                  echo json_encode($response);

                  // closing the connection
                  mysqli_close($connection);
   }





?>