<?php 
require "koneksi.php";
require "header.php";

if (!isset($_SESSION["pelanggan"])) {
/*     echo "<script>alert('Silahkan Login Dulu');</script>"; */
    echo "<script>location='login.php';</script>";
}elseif (empty($_SESSION["cart"])) {
    echo "<script>location='index.php';</script>";
};
?>

<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        padding: 0px;
        margin: 0px;
    }

    .img .box {
        height: 250px;
        background-color: rgb(41, 41, 41, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: white;
        padding-top: 70px;
    }

    .box a {
        color: #0066FF;
    }

    .box a:hover {
        text-decoration: none;
        color: rgb(6, 87, 209);
    }
</style>
<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>Checkout</h3>
            <p>Home > <a href="#">Checkout</a></p>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Data Pengiriman</h4>
                        <p class="text-muted m-b-30 font-14">Sebelum melanjutkan pembayaran, Isilah data pengiriman
                            dibawah ini dengan lengkap dan benar.</p>
                        <form action="" method="post">
                            <input type="hidden" name="subtotal" id="subtotal_value">
                            <input type="hidden" name="ongkir" id="ongkir_value">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama</label>
                                <input type="text" class=" form-control" value="" name="nama" id="nama"
                                    placeholder="nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">No Telp</label>
                                <input type="number" class=" form-control" value="" name="no_telp"
                                    placeholder="contoh: 085xxxx" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Provinsi</label>
                                <select name="province_destination" id="province_destination"
                                    class="all_province form-control" onchange="get_city_destination(this);" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Kota</label>
                                <select name="city_destination" id="city_destination" class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Kode Pos</label>
                                <input type="number" class=" form-control" value="" name="kodePos"
                                    placeholder="kode pos" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Alamat Lengkap</label>
                                <textarea id="textarea" class="form-control" maxlength="225" rows="3"
                                    placeholder="Masukkan alamat lengkap (nama jalan, nama dusun, Rt/Rw, dst)"
                                    name="alamat" required></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" name="pesan">Buat Pesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Menampilkan Rincian Belanja -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mt-0 header-title">Keranjang Belanja</h5>
                                <p class="text-muted m-b-30 font-14">Lihat <a href="cart.php"
                                        style="text-decoration: none;">detail</a> detail
                                    keranjang belanja</p>
                                <table class="table" style="font-size: small;">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Size</th>
                                            <th class="text-right">Subharga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $subtotal = 0;
                                            $total_berat = 0;
                                            foreach ($_SESSION["cart"] as $id_produk => $value) : ?>
                                        <?php
                                            $query="SELECT * FROM tbl_produk WHERE id_produk='$id_produk'";
                                            $result=mysqli_query($db,$query);
                                            $produk=mysqli_fetch_array($result);
                                            $subberat = $produk['berat']*$value['jumlah'];
                                            $subharga=$produk['harga']*$value['jumlah'];

                                            $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
                                            $queryPembelianPertama="SELECT count(*) as total FROM tbl_order WHERE id_pelanggan='$id_pelanggan'";
                                            $resultPembelianPertama=mysqli_query($db,$queryPembelianPertama);
                                            $pembelianPertama=mysqli_fetch_assoc($resultPembelianPertama);

                                            $diskon = 0;
                                            if ($pembelianPertama['total'] == 0) {
                                                $diskon=$subharga*(15/100);
                                            } else if (isset($value['id_banner'])) {
                                                $id_banner = $value['id_banner'];
                                                $queryBanner="SELECT * FROM tbl_banner WHERE id_banner='$id_banner'";
                                                $resultBanner=mysqli_query($db,$queryBanner);
                                                $dataBanner=mysqli_fetch_array($resultBanner);
                                                $diskon=$subharga*($dataBanner['diskon']/100);
                                            }
                                        ?>
                                        <tr>
                                            <td class="product-list-img">
                                                <?php 
                                                    $gambarList = json_decode($produk['gambar'], true); // Decode JSON to array
                                                ?>
                                                <?php if($gambarList!=null):?>
                                                <img width="40" src="admin/assets/images/foto_produk/<?php echo $gambarList[0]?>" class="img-fluid" alt="tbl">
                                                <?php endif;?>
                                            </td>
                                            <td><?php echo $produk['nm_produk']; ?></td>
                                            <td><?php echo $value['jumlah'];?></td>
                                            <td><?php echo $value['size']; ?></td>
                                            <td class="text-right">Rp. <?php echo number_format($subharga-$diskon);?></td>
                                        </tr>
                                        <?php $subtotal+=($subharga-$diskon); ?>
                                        <?php $total_berat+=$produk['berat']; ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menampilkan Rincian Pembayaran -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mt-0 header-title">Rincian Pembayaran</h5>
                                <br>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        Subtotal Produk
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        Rp. <span id="subtotal"
                                            name="subtotal"><?php echo number_format($subtotal); ?></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        Subtotal Berat
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <span id="total_berat"
                                            name="total_berat"><?php echo $total_berat; ?></span> (Kg)
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        Biaya Pengiriman <span class="text-danger" style="font-size: 11px;">*(Pos
                                            Indonesia)</span>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        Rp. <span id="ongkir"></span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h6>Total Pembayaran</h6>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <h6 class="text-danger"> Rp. <span id="total"></span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_POST['pesan'])) {
                    $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
                    $nmPenerima = $_POST['nama'];
                    $no_telp = $_POST['no_telp'];
                    $provinsi = $_POST['province_destination'];
                    $kota = $_POST['city_destination'];
                    $kdPos = $_POST['kodePos'];
                    $alamat = $_POST['alamat'];
                    $tgl_order = date('Y-m-d');
                    $ongkir=$_POST['ongkir'];
                    $totalbayar= $_POST['subtotal'];
                    $stockAvailable = true;                    

                    //simpan data ke pelanggan
                    $query = "INSERT INTO tbl_order (id_pelanggan,nm_penerima,telp,provinsi,kota,kode_pos,alamat_pengiriman,tgl_order,ongkir,total_order)
                            VALUES ('$id_pelanggan','$nmPenerima','$no_telp','$provinsi','$kota','$kdPos','$alamat','$tgl_order','$ongkir','$totalbayar')";
                    $result = mysqli_query($db,$query);

                    //mengambil id_order barusan terjadi
                    $id_order_barusan = $db->insert_id;

                    //simpat detail_order
                    foreach ($_SESSION['cart'] as $id_produk2 => $value2) {
                        //mendapatkan data produk berdasarkan id_produk
                        $ambil="SELECT * FROM tbl_produk WHERE id_produk='$id_produk2'";
                        $result2=mysqli_query($db,$ambil);
                        $data=mysqli_fetch_array($result2);

                        $nmProduk = $data['nm_produk'];
                        $harga = $data['harga'];
                        $berat = $data['berat'];
                        $jumlah2 = $value2['jumlah'];
                        $size2 = $value2['size'];
                        $subberat2 = $berat*$jumlah2;
                        $subharga2=$harga*$jumlah2;

                        $diskon2 = 0;
                        $id_banner = 0;
                        if (isset($value2['id_banner'])) {
                            $id_banner = $value2['id_banner'];
                            $queryBanner="SELECT * FROM tbl_banner WHERE id_banner='$id_banner'";
                            $resultBanner=mysqli_query($db,$queryBanner);
                            $dataBanner=mysqli_fetch_array($resultBanner);
                            $diskon2=$subharga2*($dataBanner['diskon']/100);
                        }

                        // Initialized Stock
                        $size_stock = json_decode($data['size'], true);
                        for ($i = 0; $i < count($size_stock); $i++) {
                            if (empty($size2)) {
                                $size_stock[$i]['stock'] -= $jumlah2;
                                $stockAvailable = true;
                                break;
                            } else{
                                if ($size_stock[$i]['size'] == $size2 && $size_stock[$i]['stock'] > 0) {
                                    if ($jumlah2 <= $size_stock[$i]['stock']) {
                                        $size_stock[$i]['stock'] -= $jumlah2;
                                        $stockAvailable = true;
                                    } else{
                                        $stockAvailable = false;
                                    }
                                    break;
                                }
                            }
                        }

                        $total_stock = array_sum(array_column($size_stock, 'stock'));
                        $sizes_json = json_encode($size_stock);

                        if ($stockAvailable) {
                            // Insert tbl order detail
                            $final_subharga = ($subharga2-$diskon2);
                            $query3 = "INSERT INTO tbl_detail_order (id_order,id_produk,nm_produk,harga,jml_order,berat,subberat,subharga,size,diskon,id_banner)
                                VALUES ('$id_order_barusan','$id_produk2', '$nmProduk','$harga','$jumlah2','$berat','$subberat2','$final_subharga','$size2','$diskon2','$id_banner' )";
                            $result3 = mysqli_query($db,$query3);
                            
                            // Update Stock                       
                            $query4 = "UPDATE tbl_produk SET size='$sizes_json', stok='$total_stock' WHERE id_produk='$id_produk2'";
                            $result4 = mysqli_query($db,$query4);
                        }
                    }

                    if ($stockAvailable) {
                        //mengkosongkan keranjang
                        unset($_SESSION['cart']);

                        //redirec ke halamn nota pembayaran
                        echo "<script type='text/javascript'>
                                swal({
                                    title: 'Pemesanan Berhasil',
                                    text: 'Data Sudah Tersimpan Ke Database Kami!',
                                    icon: 'success',
                                    button: false
                                });
                                </script>";
                        echo "<meta http-equiv='refresh' content='1;url=pembayaran.php?id=$id_order_barusan'>";
                        /*  echo "<script>alert('Pemesanan Berhasil');</script>";
                        echo "<script>location='pembayaran.php?id=$id_order_barusan';</script>";  */
                    } else{
                        $queryHapus = "DELETE FROM tbl_order WHERE id_order='$id_order_barusan'";
                        $execHapus = mysqli_query($db, $queryHapus);

                        if ($execHapus)
                        {
                            echo "<script>alert('Jumlah Order melebihi Stock tersedia!');</script>";
                            echo "<script>location='checkout.php';</script>";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- menampilkan data provinsi dan kabupaten/kota dengan api raja ongkir -->
<script>
    $(document).ready(function () {
        $.getJSON("assets/checkout/province.php", function (all_province) {
            if (all_province) {
                $(".all_province").html("<option value=''>Pilih Provinsi</option>");
                $.each(all_province['rajaongkir']['results'], function (key, value) {
                    $(".all_province").append(
                        "<option value='" + value.province_id + "'>" + value.province +
                        "</option>"
                    );
                });
            }
        });
    });

    function get_city_destination(sel) {
        $.getJSON("assets/checkout/city.php?id=" + sel.value, function (get_city) {
            if (get_city) {
                $("#city_destination").html("<option value=''>Pilih Kota</option>");
                $.each(get_city['rajaongkir']['results'], function (key, value) {
                    $("#city_destination").append(
                        "<option value='" + value.city_id + "'>" + value.type + " - " + value
                        .city_name + "</option>"
                    );
                });
            }
        });
    }
</script>

<!-- menampilkan Ongkir dan total Bayar -->
<script type="text/javascript">
    var htmlobjek;

    $(document).ready(function () {
        $("#city_destination").change(function () {
            var city_destination = $("#city_destination").val();
            var total_berat = '<?php echo $total_berat ?>';
            $.ajax({
                url: "assets/checkout/ongkir.php",
                data: "city_destination=" + city_destination + "&total_berat=" + total_berat,
                cache: false,
                success: function (msg) {
                    let price = parseInt(msg);
                    let formatted = price.toLocaleString('en-GB', {
                        maximumFractionDigits: 0
                    });
                    $("#ongkir_value").val(price);
                    console.log(price, formatted);
                    $("#ongkir").html(formatted);
                }
            });
        });
        $("#city_destination").change(function () {
            var city_destination = $("#city_destination").val();
            var subtotal = '<?php echo $subtotal ?>';
            var total_berat = '<?php echo $total_berat ?>';
            $.ajax({
                url: "assets/checkout/total.php",
                data: {
                    'city_destination': city_destination,
                    'subtotal': subtotal,
                    'total_berat': total_berat
                    /* 'idpel' : idpel, */
                },
                cache: false,
                success: function (msg) {
                    let price = parseInt(msg);
                    let formatted = price.toLocaleString('en-GB', {
                        maximumFractionDigits: 0
                    });
                    $("#subtotal_value").val(price);
                    console.log(price, formatted);
                    $("#total").html(formatted);
                }
            });
        });
    });
</script>

<?php require "footer.php"; ?>