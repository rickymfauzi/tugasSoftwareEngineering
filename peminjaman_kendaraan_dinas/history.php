<?php

    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("Harap Login");window.location="index.php"</script>';
    }
    $hasil = $koneksi->query("SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
    booking.id_mobil=mobil.id_mobil ORDER BY id_booking DESC")->fetchAll();
?>
<br>
<br>
<div class="container">
<div class="row">
    <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
                Daftar Catatan Peminjaman
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Kode Peminjaman</th>
                            <th>Merk Mobil</th>
                            <th>Nama </th>
                            <th>Tanggal Peminjaman </th>
                            <th>Lama Pinjam </th>
                           
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $no=1; foreach($hasil as $isi){?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?= $isi['kode_booking'];?></td>
                            <td><?= $isi['merk'];?></td>
                            <td><?= $isi['nama'];?></td>
                            <td><?= $isi['tanggal'];?></td>
                            <td><?= $isi['lama_sewa'];?> hari</td>
                            <td>
                                <a class="btn btn-primary" href="bayar.php?id=<?= $isi['kode_booking'];?>" 
                                role="button">Detail</a>   
                            </td>
                        </tr>
                        <?php $no++;}?>
                    </tbody>
                </table>
           </div>
         </div> 
    </div>
</div>
</div>

<br>

<br>

<br>


<?php include 'footer.php';?>