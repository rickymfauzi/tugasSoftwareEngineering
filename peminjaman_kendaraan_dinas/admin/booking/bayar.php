<?php

    require '../../koneksi/koneksi.php';
    $title_web = 'Konfirmasi';
    include '../header.php';
    session_start();
    if(empty($_SESSION['USER']))
    {
        echo '<script>alert("login dulu");window.location="index.php"</script>';
    }
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

    $id_booking = $hasil['id_booking'];
    $hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
    $c = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->rowCount();


    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
    
?>
<br>
<br>
<div class="container">
<div class="row">
    <div class="col-sm-4">
        <div class="card">
           
            <div class="card-body">
                <?php if($c > 0){?>
                <table class="table">
                   
                    <tr>
                        <td>Atas Nama </td>
                        <td> :</td>
                        <td><?= $hsl['nama_rekening'];?></td>
                    </tr>
                    
                    <tr>
                        <td>Tgl Pinjam</td>
                        <td> :</td>
                        <td><?= $hsl['tanggal'];?></td>
                    </tr>
                </table>
                <?php }else{?>
                    
                <?php }?>
            </div>
        </div>
        <br/>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?php echo $isi['merk'];?></h5>
            </div>
            <ul class="list-group list-group-flush">

                <?php if($isi['status'] == 'Tersedia'){?>

                    <li class="list-group-item bg-primary text-white">
                        <i class="fa fa-check"></i> Available
                    </li>

                <?php }else{?>

                    <li class="list-group-item bg-danger text-white">
                        <i class="fa fa-close"></i> Not Available
                    </li>

                <?php }?>
            
            
               
            </ul>
            <div class="card-footer">
                <a href="<?php echo $url;?>admin/peminjaman/peminjaman.php?id=<?php echo $hasil['kode_booking'];?>" 
                    class="btn btn-success btn-md">Ubah Status Peminjaman</a>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
         <div class="card">
            <div class="card-header">
            </div>
           <div class="card-body">
               <form method="post" action="proses.php?id=konfirmasi">
                    <table class="table">
                        <tr>
                            <td>Kode Booking  </td>
                            <td> :</td>
                            <td><?php echo $hasil['kode_booking'];?></td>
                        </tr>
                        <tr>
                            <td>Nama Bidang  </td>
                            <td> :</td>
                            <td><?php echo $hasil['ktp'];?></td>
                        </tr>
                        <tr>
                            <td>Nama  </td>
                            <td> :</td>
                            <td><?php echo $hasil['nama'];?></td>
                        </tr>
                        <tr>
                            <td>telepon  </td>
                            <td> :</td>
                            <td><?php echo $hasil['no_tlp'];?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Peminjaman </td>
                            <td> :</td>
                            <td><?php echo $hasil['tanggal'];?></td>
                        </tr>
                        <tr>
                            <td>Lama Peminjaman </td>
                            <td> :</td>
                            <td><?php echo $hasil['lama_sewa'];?> hari</td>
                        </tr>
                        
                        <tr>
                            <td>Status </td>
                            <td> :</td>
                            <td>
                                <select class="form-control" name="status">
                                    <option <?php if($hasil['konfirmasi_pembayaran'] == 'Sedang di proses'){echo 'selected';}?>>
                                        Sedang di proses
                                    </option>
                                    <option <?php if($hasil['konfirmasi_pembayaran'] == 'Pembayaran di terima'){echo 'selected';}?>>
                                        Pembayaran di terima
                                    </option>
                                </select>    
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="id_booking" value="<?php echo $hasil['id_booking'];?>">
                    <button type="submit" class="btn btn-primary float-right">
                        Ubah Status
                    </button>
            </form>
               
           </div>
         </div> 
    </div>
</div>
</div>
<br>
<br>
<br>

<?php include '../footer.php';?>