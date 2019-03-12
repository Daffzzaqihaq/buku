<?php
header("Content-Type: application/json; charset=UTF-8");
include './config/koneksi.php';

 // Membuat nama folder upload image
   $upload_path = 'uploads/';

   // Mengambil ip server
   $server_ip = gethostbyname(gethostname());

   // Membuat url upload
   $upload_url = 'http://'.$server_ip.'/buku/'.$upload_path;

// Membuat penampung query
$query = "SELECT tb.id_buku, tb.id_user, tb.id_kategori, tb.nama_buku, tb.desc_buku, tb.foto_buku, tb.insert_time, tb.view, tk.nama_kategori, tu.nama_user FROM tb_user tu, tb_buku tb, tb_kategori tk WHERE tu.id_user = tb.id_user && tk.id_kategori = tb.id_kategori ORDER BY tb.view DESC";

// Membuat penampung result/hasil dari eksekusi query
$result = mysqli_query($connection, $query) or die ("Error in selecting") . mysqli_error($connection);

// Membuat penampung array untuk data yang diambil
$temparray = array();
// Membuat penampung untuk respon terakhir
$response = array();
// Membuat penampung untuk mengecek isi data setelah di query
$cek = mysqli_num_rows($result);

// Membuat penampung untuk mengecek isi data setelah query
$cek = mysqli_num_rows($result);

// Melakukan kondisi untuk mengecek apakah query tadi ada isinya
if ($cek > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
 	array_push($row['url_buku'] = $upload_url . $row['foto_buku']);
 	$temparray[] = $row;
 } 

 // Membuat tambahan item untuk menampilkan pesan Sukses
 $response['result'] = 1;
 $response['message'] = "Data berhasil diambil";

// Memasukan data tadi ke dalam variable respon
 $response ['DataBuku'] = $temparray;

}else{
	// Menampilkan response data kosong
	$response['result'] = 1;
 $response['message'] = "Data kosong";
}

 echo json_encode($response);

 // Close conection
 mysqli_close($connection);










?>