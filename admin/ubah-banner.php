<?php include "../koneksi.php" ?>

<!-- Menampilkan Daftar Produk -->
<?php
	$query = "SELECT * FROM tbl_produk";
	$result = mysqli_query($db, $query);
?>

<div class="content">
    <div class="container">
        <?php 
            $id = $_GET['id'];
            $panggil = "SELECT * FROM tbl_banner WHERE id_banner='$id' ";
            $resultpanggil = mysqli_query($db, $panggil);
            $dataBanner = mysqli_fetch_assoc($resultpanggil);
        ?>
        <?php
        if (isset($_POST['ubah']))
        {
            $judul = $_POST['judul'];
            $isi = $_POST['isi'];
            $diskon= $_POST['diskon'];
            $status= $_POST['status'];
            $nmGambar = $_FILES['gambar']['name'];
            $lokasi = $_FILES['gambar']['tmp_name'];
            $id_produk = json_encode($_POST['id_produk'], true);

            if (!empty($lokasi)) {
                move_uploaded_file($lokasi, "assets/images/foto_banner/$nmGambar");

                $queryEdit = "UPDATE tbl_banner SET judul='$judul', isi='$isi', gambar='$nmGambar', diskon='$diskon', status='$status', id_produk='$id_produk' WHERE id_banner='$id'";
                $resultEdit = mysqli_query($db, $queryEdit);
            }
            else {
                $queryEdit = "UPDATE tbl_banner SET judul='$judul', isi='$isi', diskon='$diskon', status='$status', id_produk='$id_produk' WHERE id_banner='$id'";
                $resultEdit = mysqli_query($db, $queryEdit);
            }
            echo "<script>alert('Data Banner sudah di ubah')</script>";
            echo "<script>location='index.php?pages=banner';</script>";
        };
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">Judul</label>
                                <input type="text" class="form-control" name="judul" value="<?php echo $dataBanner['judul']; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Produk</label>
                                <select class="form-control select2" id="id_produk" name="id_produk[]" multiple>
                                    <option>Pilih Produk</option>
                                    <?php $id_produks = json_decode($dataBanner['id_produk'], true); ?>
                                    <?php while($pilih = mysqli_fetch_array($result)): ?>
                                    <?php $active = (in_array($pilih['id_produk'], $id_produks))?"selected":""?>
                                    <option value="<?php echo $pilih['id_produk']?>" <?php echo $active?>>
                                        <?php echo $pilih['nm_produk']  ?>
                                    </option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Isi Banner </label>
                                <textarea id="elm1" name="isi" value=""><?php echo $dataBanner['isi']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">Diskon (%)</label>
                                <input type="number" class="form-control" name="diskon" value="<?php echo $dataBanner['diskon']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" id="" class="form-control" required="required">
                                    <option value="">Pilih Status</option>
                                    <option value="active" <?php echo ($dataBanner['status'] == 'active')?"selected":""?>>Aktif</option>
                                    <option value="inactive" <?php echo ($dataBanner['status'] == 'inactive')?"selected":""?>>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="form-group">
								<label class="font-weight-bold">Gambar Sebelumnya</label><br>
								<?php if($dataBanner['gambar']!=null):?>
									<img src="assets/images/foto_banner/<?php echo $dataBanner['gambar']; ?>" alt="pos img" class="img-fluid"
									style="max-height: 125px;" />
								<?php endif;?>
								
							</div>
                            <div class="form-group">
                                <label class="font-weight-bold">Ganti Gambar</label>
                                <input type="file" class="filestyle" data-buttonname="btn-secondary" name="gambar">
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-3" name="ubah">Ubah Banner</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>