<?php
    include "../koneksi.php";
?>
<!-- Lihat Data Produk -->
<?php
if (isset($_GET['id']))
{
    //mengambil id produk
    $id = $_GET['id'];
    //menghapus data
    $queryHapus = "DELETE FROM tbl_kat_produk WHERE id_kategori='$id'";
    $execHapus = mysqli_query($db, $queryHapus);

    if ($execHapus)
    {
        //menampilkan pesan dan redirec ke halaman produk
        echo "<script>alert('Kategori sudah dihapus');</script>";
        echo "<script>location='index.php?pages=tambah-kategori';</script>";
    }
}
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
                                <input id="productname" name="nama" type="text" class="form-control" required></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="level">Level Kategori</label>
                                <select class="form-control select2" name="level" onchange="get_kategori(this);" required>
                                    <option value="">Pilih Level</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="parent_id">Kategori Utama</label>
                                <select class="form-control select2" name="parent_id" id="parent_id">
                                    <option value="">Pilih Kategori Utama</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success waves-effect waves-light" name="tambah">Tambah</button>
                </form>
                <?php
                    if(isset($_POST['tambah']) && isset($_POST['nama'])){
                        $nama = $_POST['nama'];
                        $level = $_POST['level'];
                        $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : NULL;
                        $db->query("INSERT INTO tbl_kat_produk (nm_kategori,level,parent_id) VALUES ('$nama','$level','$parent_id')");
                    }
                    
                ?>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card m-b-20">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="productname">Kategori Produk</label><br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Kategori</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Kategori Utama</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; ?>
                                    <?php $ambil=$db->query("SELECT a.id_kategori, a.nm_kategori, a.level, b.nm_kategori as kategori_utama FROM tbl_kat_produk a LEFT JOIN tbl_kat_produk b ON a.parent_id = b.id_kategori"); ?>
                                    <?php while($pecah=$ambil->fetch_assoc()){ ?>
                                    <tr>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php echo $pecah['nm_kategori'] ?></td>
                                        <td><?php echo $pecah['level'] ?></td>
                                        <td><?php echo $pecah['kategori_utama'] ?></td>
                                        <td>
                                            <a href="index.php?pages=ubah-kategori&id=<?php echo $pecah['id_kategori']; ?>" class="m-r-15 text-muted" data-toggle="tooltip"
                                                data-placement="top" title="" data-original-title="Edit"><i
                                                    class="mdi mdi-pencil font-18"></i></a>
                                            <a href="index.php?pages=tambah-kategori&id=<?php echo $pecah['id_kategori']; ?>"
                                                class="text-muted" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus Kategori tersebut?')"><i
                                                    class="mdi mdi-close font-18"></i></a>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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