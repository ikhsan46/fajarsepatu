<?php
    include "../koneksi.php";
?>
<!-- Lihat Data Produk -->
<?php
if (isset($_GET['id']))
{
    //mengambil id produk
    $id = $_GET['id'];
    $panggil = "SELECT * FROM tbl_kat_produk WHERE id_kategori='$id'";
    $resultpanggil = mysqli_query($db, $panggil);
    $dataKategori = mysqli_fetch_assoc($resultpanggil);
}
?>
<?php
    if (isset($_POST['ubah']))
    {
        $nama = $_POST['nama'];
        $level = $_POST['level'];
        $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : NULL;

        $queryEdit = "UPDATE tbl_kat_produk SET nm_kategori='$nama', level='$level', parent_id='$parent_id' WHERE id_kategori='$id'";
        $resultEdit = mysqli_query($db, $queryEdit);

        echo "<script>alert('Data Kategori sudah di ubah')</script>";
        echo "<script>location='index.php?pages=tambah-kategori';</script>";
    };
?>
<div class="row">
    <div class="col-6">
        <div class="card m-b-20">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="productname">Nama Kategori</label>
                                <input id="productname" name="nama" type="text" class="form-control" value="<?php echo $dataKategori['nm_kategori']; ?>" required></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="level">Level Kategori</label>
                                <select class="form-control select2" name="level" onchange="get_kategori(this);" required>
                                    <option value="">Pilih Level</option>
                                    <option value="1" <?php echo ($dataKategori['level'] == '1')?"selected":""?>>1</option>
                                    <option value="2" <?php echo ($dataKategori['level'] == '2')?"selected":""?>>2</option>
                                    <option value="3" <?php echo ($dataKategori['level'] == '3')?"selected":""?>>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="parent_id">Kategori Utama</label>
                                <select class="form-control select2" name="parent_id" id="parent_id">
                                    <!-- Menampilkan Daftar Kategori Produk -->
                                    <?php
                                        $level = $dataKategori['level']-1;
                                        $query = "SELECT * FROM tbl_kat_produk WHERE level = '$level' ";
                                        $resultParent = mysqli_query($db, $query);
                                    ?>
                                    <option value="">Pilih Kategori Utama</option>
                                    <?php while($pilih = mysqli_fetch_array($resultParent)): ?>
                                    <?php $active = ($dataKategori['parent_id'] == $pilih['id_kategori'])?"selected":""?>
                                    <option value="<?php echo $pilih['id_kategori']?>" <?php echo $active?>>
                                        <?php echo $pilih['nm_kategori']  ?>
                                    </option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success waves-effect waves-light" name="ubah">Ubah</button>
					<a type="button" href="index.php?pages=tambah-kategori" class="btn btn-secondary waves-effect">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- menampilkan data kategori berdasarkan level -->
<script>
    function get_kategori(ele) {
        $.getJSON("get-kategori.php?level=" + ele.value, function (result) {
            if (result) {
                $("#parent_id").html("<option value=''>Pilih Kategori Utama</option>");
                $.each(result, function (key, value) {
                    $("#parent_id").append(
                        "<option value='" + value.id_kategori + "'>" + value.nm_kategori + "</option>"
                    );
                });
            }
        });
    }
</script>