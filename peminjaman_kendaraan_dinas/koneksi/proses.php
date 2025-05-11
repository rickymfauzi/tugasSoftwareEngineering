<?php

require 'koneksi.php';
if($_GET['id'] == 'login'){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ? AND password = md5(?)");
    
    $row->execute(array($user,$pass));
    
    $hitung = $row->rowCount();

    if($hitung > 0)
    {

        session_start();
        $hasil = $row->fetch();
        
        $_SESSION['USER'] = $hasil;

        if($_SESSION['USER']['level'] == 'admin')
        {
            echo '<script>alert("Login Sukses");window.location="../admin/index.php";</script>';    
        }
        else
        {
            echo '<script>alert("Login Sukses");window.location="../index.php";</script>'; 
        }

    }
    else
    {
        echo '<script>alert("Maaf Login Gagal");window.location="../index.php";</script>'; 
    }
}

if($_GET['id'] == 'daftar')
{
    $data[] = $_POST['nama'];
    $data[] = $_POST['user'];
    $data[] = md5($_POST['pass']);
    $data[] = 'pengguna';

    $row = $koneksi->prepare("SELECT * FROM login WHERE username = ?");
    
    $row->execute(array($_POST['user']));
    
    $hitung = $row->rowCount();

    if($hitung > 0)
    {
        echo '<script>alert("Daftar Gagal, Username Sudah digunakan ");window.location="../index.php";</script>'; 
    }
    else
    {

        $sql = "INSERT INTO `login`(`nama_pengguna`, `username`, `password`, `level`)
                VALUES (?,?,?,?)";
        $row = $koneksi->prepare($sql);
        $row->execute($data);
    
        echo '<script>alert("Daftar Sukses Silahkan Login");window.location="../index.php";</script>'; 
    }


}

if($_GET['id'] == 'booking')
{
    $total = 1 * $_POST['lama_sewa'];
    
    $data[] = time();
    $data[] = $_POST['id_login'];
    $data[] = $_POST['id_mobil'];
    $data[] = $_POST['ktp'];
    $data[] = $_POST['nama'];
    $data[] = $_POST['alamat'];
    $data[] = $_POST['no_tlp'];
    $data[] = $_POST['tanggal'];
    $data[] = $_POST['lama_sewa'];
    $data[] = date('Y-m-d');

    $sql = "INSERT INTO booking (kode_booking, 
    id_login, 
    id_mobil, 
    ktp, 
    nama, 
    alamat, 
    no_tlp, 
    tanggal, lama_sewa, tgl_input) 
        VALUES (?,?,?,?,?,?,?,?,?,?)";
    $row = $koneksi->prepare($sql);
    $row->execute($data);

    echo '<script>alert("Anda Sukses melakukan Pengajuan Peminjaman");
    window.location="../bayar.php?id='.time().'";</script>'; 
}

if($_GET['id'] == 'konfirmasi')
{

    $data[] = $_POST['id_booking'];
    $data[] = $_POST['nama'];
    $data[] = $_POST['tgl'];

    $sql = "INSERT INTO `pembayaran`(`id_booking`, `nama_rekening`, `tanggal`) 
    VALUES (?,?,?)";
    $row = $koneksi->prepare($sql);
    $row->execute($data);

    $data2[] = 'Sedang di proses';
    $data2[] = $_POST['id_booking'];
    $sql2 = "UPDATE `booking` SET `nama_rekening``=? WHERE id_booking=?";
    $row2 = $koneksi->prepare($sql2);
    $row2->execute($data2);

    echo '<script>alert("Pengajuan Anda sedang diproses");history.go(-2);</script>'; 
}