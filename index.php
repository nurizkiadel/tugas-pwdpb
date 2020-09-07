<?php
    //Koneksi Database
    $server ="localhost";
    $user ="root";
    $pass ="";
    $database ="dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    //jika tobol simpan diklik 
    if (isset($_POST['bsimpan']))
    {
        //Pengujian Apakah data akan diedit atau disimpan
        if($_GET['hal'] == "edit")
        {
            //Data akan di edit
                 $edit = mysqli_query($koneksi, "UPDATE tssw set
                                                 nis = '$_POST[tnis]',
                                                 nama = '$_POST[tnama]',
                                                 kelas = '$_POST[tkelas]'
                                                 WHERE Id_ssw = '$_GET[id]'
                                     ");
            if($edit)//JIKA EDIT DATA SUKSES
         {
         echo "<script>
         alert('Edit data SUKSESS!!');
         document.location='index.php';
         </script>";
         }
         else
         {
         echo "<script>
         alert('Edit data GAGAL!!');
         document.location='index.php';
         </script>";
        }
        }else
        {
            //Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO tssw(nis, nama, kelas)
                                              VALUES ('$_POST[tnis]',
                                                      '$_POST[tnama]',
                                                      '$_POST[tkelas]')
                                             ");
        if($simpan)//JIKA SIMPAN SUKSES
        {
           echo "<script>
                   alert('Simpan data SUKSESS!!');
                   document.location='index.php';
                 </script>";
        }
        else
        {
           echo "<script>
                   alert('Simpan data GAGAL!!');
                   document.location='index.php';
                 </script>";
        }
        }

 
    }

    //Pengujian jika tombol Edit / hapus diklik
    if(isset($_GET['hal']))
    {
        //Pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
            //Tampilkan data yang diedit
            $tampil = mysqli_query($koneksi,"SELECT * FROM tssw WHERE id_ssw = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //Jika data ditemukan, maka data ditampung dulu ke dalam variabel
                $vnis = $data['nis'];
                $vnama = $data['nama'];
                $vkelas = $data['kelas'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //Persiapan hapus data
            $hapus = mysqli_query ($koneksi, "DELETE FROM tssw WHERE id_ssw = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus Data Suksess!!');
                        document.location='index.php';
                        </script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <tittle>CRUD 2020 PHP & MySQL + Bootstrap 4</tittle>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

<h1 class="text-center">CRUD 2020 PHP & MySQL + Bootstrap 4</h1>
<h2class="text-center">nurizki adelia azzahro<h2>

    <!-- Awal Card Form -->
    <div class="card mt-3">
    <div class="card-header bg-primary text-white">
        Form Input Data Siswa-Siswi XI TI SMKN 1 PURWOSARI
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="tnis" value="<?=@$vnis?>" class="form-control" placeholder="Input NIS anda disini!" required>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini!" required>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <select class="form-control" name="tkelas"> 
                <option value="<?=@vkelas?>"><?=@$vkelas?></option>
                <option value="XI-RPL">XI-RPL</option>
                <option value="XI-MM">XI-MM</option>
                <option value="XI-TKJ">XI-TKJ</option>
                </select>
            </div>
            <button Type="submit" class="btn btn-success mt-2" name="bsimpan">Simpan</button>
            <button Type="reset" class="btn btn-danger mt-2" name="breset">Kosongkan</button>
        </form>
      </div>
    </div>
    <!-- Akhir Card Form -->

    <!-- Awal Card Tabel -->
    <div class="card mt-3">
    <div class="card-header bg-primary text-white">
        Daftar Siswa-Siswi XI TI SMKN 1 PURWOSARI
    </div>
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tssw order by id_ssw desc");
                while($data = mysqli_fetch_array($tampil)) :

            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nis']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['kelas']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_ssw']?>" class="btn btn-warning"> Edit </a>
                    <a href="index.php?hal=hapus&id=<?$data['id_ssw']?>"
                     onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">
                      Hapus </a>
                </td>
            </tr>
                <?php endwhile;//penutup perulangan while ?>
        </table>

      </div>
    </div>
    <!-- Akhir Card Tabel -->


</div>

<script type="textjavascript" src="js/bootstrap.min.js"></script>
</body>
</html>