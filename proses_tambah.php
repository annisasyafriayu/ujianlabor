<?php
// memanggil file koneksi.php untuk melakukan koneksi database
include 'koneksi.php';

// membuat variabel untuk menampung data dari form
$id = $_POST['id'];
$nama_produk = $_POST['nama_produk'];
$deskripsi = $_POST['deskripsi'];
$harga_beli = $_POST['harga_beli'];
$harga_jual = $_POST['harga_jual'];
$gambar_produk = $_FILES['gambar_produk']['name'];

//cek dulu jika ada gambar produk jalankan coding ini
if($gambar_produk != "") {
    $ekstensi_diperbolehkan = array('png','jpg'); //ekstensi file gambar yang bisa diupload
    $x = explode('.', $gambar_produk); //memisahkan nama file dengan ekstensi yang diupload
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['gambar_produk']['tmp_name'];
    $angka_acak = rand(1,999);
    $nama_gambar_baru = $angka_acak.'-'.$gambar_produk; //menggabungkan angka acak dengan nama file sebenarnya
    
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        //memindah file gambar ke folder gambar
        move_uploaded_file($file_tmp, 'gambar/'.$nama_gambar_baru);
        
        // jalankan query INSERT untuk menambah data ke database (Tabel: produk)
        $query = "INSERT INTO produk (nama_produk, deskripsi, harga_beli, harga_jual, gambar_produk) 
                  VALUES ('$nama_produk', '$deskripsi', '$harga_beli', '$harga_jual', '$nama_gambar_baru')";
        $result = mysqli_query($koneksi, $query);
        
        // periksa query apakah ada error
        if(!$result){
            die ("Query gagal dijalankan: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
        } else {
            //tampil alert dan akan redirect ke halaman index.php
            echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
        }
    } else {
        //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
        echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='tambah_produk.php';</script>";
    }
} else {
    // PERBAIKAN: Kata 'produksi' diganti menjadi 'produk' agar tidak error
    $query = "INSERT INTO produk (nama_produk, deskripsi, harga_beli, harga_jual, gambar_produk) 
              VALUES ('$nama_produk', '$deskripsi', '$harga_beli', '$harga_jual', null)";
    $result = mysqli_query($koneksi, $query);
    
    // periksa query apakah ada error
    if(!$result){
        die ("Query gagal dijalankan: ".mysqli_errno($koneksi)." - ".mysqli_error($koneksi));
    } else {
        //tampil alert dan akan redirect ke halaman index.php
        echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
    }
}
?>