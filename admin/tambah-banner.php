<?php include "../koneksi.php" ?>

<!-- Menampilkan Daftar Produk -->
<?php
	$query = "SELECT * FROM tbl_produk";
	$result = mysqli_query($db, $query);
?>

<div class="content">
    <div class="container">
        <?php
        if (isset($_POST['post']))
        {
            $judul = $_POST['judul'];
            $isi = $_POST['isi'];
            $diskon= $_POST['diskon'];
            $status= $_POST['status'];
            $nmGambar = $_FILES['gambar']['name'];
            $lokasi = $_FILES['gambar']['tmp_name'];
            $id_produk = json_encode($_POST['id_produk'], true);

            if (!empty($lokasi)) //Jika temporari tidak kosong 
            { 
                //memindah file gambar dari file temporari ke folder assets/images/foto_produk/
                move_uploaded_file($lokasi, "assets/images/foto_banner/" . $nmGambar);
                //Memasukkan data ke tabel tbl_produk
                $query = "INSERT INTO tbl_banner
                        (judul,isi,gambar,diskon,status,id_produk)
                        VALUE('$judul','$isi','$nmGambar','$diskon','$status','$id_produk')";
                $exec= mysqli_query($db, $query);
                //Menampilkan pesan jika data berhasil di masukkan
                echo "<p class='alert alert-success' role='alert'>
                        Berhasil Menambahkan Banner.<br />
                        <a href='index.php?pages=banner'>Lihat Banner</a>
                        </p>";
            }
            else //jika temporari kosong
            {
                //Menampilkan pesan jika gambar belum dimasukkan
                echo "<p class='alert alert-danger' role='alert'>
                        [Error] Upload Gambar Gagal.<br />
                        </p>";
            }
        };
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">Judul</label>
                                <input type="text" class="form-control" name="judul" required="required">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Produk</label>
                                <select class="form-control select2" id="id_produk" name="id_produk[]" multiple>
                                    <option>Pilih Produk</option>
                                    <?php while($pilih = mysqli_fetch_array($result)): ?>
                                    <option  value="<?php echo $pilih['id_produk']?>" >
                                        <?php echo $pilih['nm_produk']  ?>
                                    </option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Isi Banner </label>
                                <textarea id="elm1" name="isi"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">Diskon (%)</label>
                                <input type="number" class="form-control" name="diskon">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" id="" class="form-control" required="required">
                                    <option value="">Pilih Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Gambar</label>
                                <input type="file" class="filestyle" data-buttonname="btn-secondary" name="gambar" required>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-3" name="post">Tambah Banner</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>