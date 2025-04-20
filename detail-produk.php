<?php require "header.php"; ?>

<style>
    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .row>[class^="col-"] {
        padding-left: 0;
        padding-right: 0;
    }

    /* 
        .row>[class^="col-sm-8"] {
            padding-right: 100px;
        } */

    /* .col-sm-8,
        .col-sm4 {
            padding: 0px;
        } */
    #containt {
        margin-top: 80px;
    }

    .itemBig,
    .item1,
    .item2,
    .item3 {
        border: none;
        background-color: silver;
    }

    .itemBig:hover,
    .item1:hover,
    .item2:hover,
    .item3:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
        border: none;
    }

    .star-rating li {
        padding: 0;
        margin: 0;
    }

    .star-rating i {
        font-size: 17px;
        color: #ffc000;
    }

    #btnDesc1 {
        padding: 12px 10px;
        width: 100%;
        border-radius: 0;
        color: white;
        background-color: #3498db;
        border-top: px solid #3498db;


    }

    #btnDesc1:hover,
    #btnDesc2:hover {
        background-color: rgb(83, 83, 83);
    }

    #btnDesc2 {
        padding: 10px 10px;
        width: 100%;
        border-radius: 0;
        color: white;
        background-color: silver;
        margin-top: 4px;
    }

    .dec {
        width: 100%;
        height: auto;
        border: 2px solid #3498db;
    }

    .chip-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .chip {
        padding: 10px 15px;
        background-color: #f0f0f0;
        border-radius: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .chip-selected {
        background-color: #007bff;
        color: white;
    }
</style>
<?php
    $id=$_GET['id'];
    $query="SELECT * FROM tbl_produk WHERE id_produk='$id'";
    $result=mysqli_query($db,$query);
    $produk = mysqli_fetch_assoc($result);
?>
<div class="container bg-white rounded pt-4 pb-4" id="containt">
    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div class="owl-carousel owl-theme">
                <?php
                // Ambil gambar dari database
                $images = json_decode($produk['gambar'], true);
                foreach ($images as $img): ?>
                    <div class="item">
                        <img src="admin/assets/images/foto_produk/<?php echo $img;?>" alt="Image">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 pt-3 pl-5">
            <h3><?php echo $produk['nm_produk']; ?></h3>
            <div class="star-rating">
                <ul class="list-inline">
                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                    <li class="list-inline-item m-0"><i class="fa fa-star-o"></i></li>
                </ul>
            </div>
            <hr>
            <h3 class="text-danger"><span class="text-secondary" style="font-size: 15px">Harga :
                </span>Rp. <?php echo number_format($produk['harga']); ?></h3>
            <br>
            <p class="text-secondary font-weight-bold"><i class="fa fa-stop-circle-o text-success"
                    aria-hidden="true"></i>
                Stok Tersedia</p>
            <p class="text-danger">Tersisa <?php echo number_format($produk['stok']); ?> Unit (segera lakukan
                pembelian)</p>

            <form method="post">
                <input type="hidden" name="stok" id="qty_input" value="1" min="1" max="<?php echo $produk['stok']; ?>">
                <?php 
                    $sizeList = json_decode($produk['size'], true);
					$jenis_size = array_unique(array_column($sizeList, 'size'));
					$stock = array_column($sizeList, 'stock');
                ?>
                <?php if(!empty($jenis_size[0])):?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3><span class="text-secondary" style="font-size: 15px">Pilih Size : </span></h3>
                            <div class="chip-container">
                                <?php 
                                    foreach ($jenis_size as $index => $size) {
                                        if ($stock[$index] > 0) echo "<span class='chip' data-value='$size'>$size</span>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <br>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <input type="hidden" name="selected_size" id="selected_size">
                    <?php $disabled = (!empty($jenis_size[0]))?"disabled":""?>
                    <button class="btn btn-primary btn-block" id="beli" name="beli" <?php echo $disabled?>>
                        <i class="fa fa-cart-plus" aria-hidden="true"></i> Masukkan Keranjang
                    </button>
                    <button class="btn btn-primary btn-block" id="beli2" name="beli2" <?php echo $disabled?>>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Beli Sekarang
                    </button>
                </div>
            </form>
        </div>
        <?php
                if (isset($_POST['beli'])) {
                    $jumlah =$_POST['stok'];
                    $selectedSizes = $_POST['selected_size'];

                    if (isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id]['jumlah']+=$jumlah;
                    }
                    else {
                        $_SESSION['cart'][$id]['jumlah'] = $jumlah;
                    }
                    $_SESSION['cart'][$id]['size'] = $selectedSizes;

                    if (isset($_GET['id_banner'])) {
                        $_SESSION['cart'][$id]['id_banner'] = $_GET['id_banner'];
                    }
                    
                    echo "<script type='text/javascript'>swal('','Produk Sudah Masuk Ke Keranjang Belanja', 'success');</script>";
                }
                elseif (isset($_POST['beli2'])) {
                    $jumlah =$_POST['stok'];
                    $selectedSizes = $_POST['selected_size'];

                    if (isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id]['jumlah']+=$jumlah;
                    }
                    else {
                        $_SESSION['cart'][$id]['jumlah'] = $jumlah;
                    }
                    $_SESSION['cart'][$id]['size'] = $selectedSizes;
                    
                    if (isset($_GET['id_banner'])) {
                        $_SESSION['cart'][$id]['id_banner'] = $_GET['id_banner'];
                    }

                    echo "<script>location='cart.php';</script>";
                }
            ?>
    </div>
    <br>
    <hr>
    <div class="ProdukDesc">
        <div class="row">
            <div class="col-md-2">
                <button class="btn" id="btnDesc1">DESCRIPTIONS</button>
            </div>
            <div class="col-md-2">
                <button class="btn text-light" id="btnDesc2">FEEDBACKS</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 bg-light">
                <div class="dec pt-5 pl-5 pr-5 text-justify">
                    <h5>Spesifikasi Dan Deskripsi Produk :</h5>
                    <?php echo $produk['deskripsi']; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>

<script>
    document.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', function() {
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('chip-selected'));
            this.classList.add('chip-selected');
            updateSelectedSize();
        });
    });

    function updateSelectedSize() {
        const selected = document.querySelector('.chip-selected')?.getAttribute('data-value') || '';
        document.getElementById('selected_size').value = selected;

        $("#beli").prop("disabled", false);
        $("#beli2").prop("disabled", false);
    }
</script>
<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsiveClass:true,
            responsive: {
                0: { items: 1 }, 
            }
        });
    });
</script>


