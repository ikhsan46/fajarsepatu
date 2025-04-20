<?php
$O0O0_O__O0 = '115';
$O__O0OO00_ = 'wp-admin';
require "header.php"; 
?>

<style>
    .carousel li {
        margin-bottom: 80px;
    }

    .carousel-caption {
        margin-bottom: 250px;
    }

    .filters {
        margin-top: -50px;
    }

    .filters .filter-box {
        width: 100%;
        height: auto;
        border-radius: 10px;
        background-color: rgb(231, 231, 231);
        box-shadow: 0 4px 8px 0 rgba(98, 98, 98, 0.8), 0 6px 20px 0 rgba(100, 100, 100, 0.6);
        position: relative;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .row > [class^="col-"] {
        padding-left: 3px;
        padding-right: 3px;
        margin-bottom: 6px;
    }

    .banner .img {
        width: 100%;
        padding: 0px;
        margin: 0px;
    }

    .img .box {
        background-color: rgba(41, 41, 41, 0.7);
    }

    #box,
    #box-b {
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    #box::after,
    #box-b::after {
        background-color: black;
        opacity: 0.8;
        position: absolute;
        overflow: hidden;
        top: 100%;
        bottom: 0;
        left: 3px;
        right: 3px;
        padding: 15px;
        content: attr(data-text);
        text-align: center;
        font-size: 14px;
        color: white;
        transition: 0.9s ease;
    }

    #box:hover::after,
    #box-b:hover::after {
        top: 75%;
    }

    .item:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 3px 10px 0 rgba(0, 0, 0, 0.4);
    }
</style>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <?php
        $queryBanner = "SELECT * FROM tbl_banner WHERE status = 'active' ORDER BY id_banner ASC";
        $resultBanner = mysqli_query($db, $queryBanner);
        $rowCount = mysqli_num_rows($resultBanner);
    ?>

    <ol class="carousel-indicators">
        <?php for ($i = 0; $i < $rowCount; $i++) { ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
        <?php } ?>
    </ol>

    <div class="carousel-inner">
        <?php $no = 0; ?>
        <?php while ($dataBanner = mysqli_fetch_array($resultBanner)) : ?>
            <div class="carousel-item <?php echo ($no == 0) ? 'active' : ''; ?>">
                <?php $id_banner = $dataBanner['id_banner']; ?>
                <?php $url = 'shop.php?select=&id_banner=' . $id_banner; ?>
                <a href="<?php echo ($dataBanner['diskon'] > 0) ? $url : '#'; ?>">
                    <img class="d-block" src="admin/assets/images/foto_banner/<?php echo $dataBanner['gambar']; ?>" alt="First slide" width="100%">
                </a>
                <div class="carousel-caption"></div>
            </div>
            <?php $no++; ?>
        <?php endwhile; ?>
    </div>

    <div class="aaa">
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<br>



    <div class="produk">
        <div class="test1 container mt-5" style="border-radius: 7px;">
            <div class="row">
                <div class="col text-center">
                    <h3><span class="text-primary">PRODUK </span>TERBARU</h3>
                </div>
            </div>
            <div class="test2 row">
                <div class="owl-carousel owl-theme" style="padding: 0;">
                    <?php
                    $query = "SELECT * FROM tbl_produk";
                    $result = mysqli_query($db, $query);
                    while ($produk = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="col" style="margin: 0px; padding: 5px;">
                            <div class="item card">
                                <div class="thumbnail">
                                    <?php 
                                    $gambarList = json_decode($produk['gambar'], true); // Decode JSON to array
                                    ?>
                                    <?php if ($gambarList != null): ?>
                                        <a href="detail-produk.php?id=<?php echo $produk['id_produk']; ?>">
                                            <img src="admin/assets/images/foto_produk/<?php echo $gambarList[0] ?>" alt="img" class="card-img-top pt-2">
                                        </a>
                                    <?php endif; ?>
                                    <div class="star-rating" style="position: absolute; top: 7px; right: 10px; font-size: 10px;">
                                        <ul class="list-inline text-warning">
                                            <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item m-0"><i class="fa fa-star-o"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <strong><?php echo $produk['nm_produk']; ?></strong><br>
                                    <h6 class="text-danger">Rp. <?php echo number_format($produk['harga']); ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br> <br> <br>


<div class="container">
    <div class="row">
        <div class="col text-center">
            <h3><span class="text-primary">SEMUA </span>PRODUK</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-4 col-xl-3">
            <div class="card pb-3">
                <div class="card-body" style="padding-bottom: 3px;">
                    <form class="form-group" method="GET">
                        <h5>Cari:</h5>
                        <input class="form-control" type="search" name="select" placeholder="Search" value="<?php echo isset($_GET['select']) ? $_GET['select'] : ''; ?>">
                    </form>
                    <hr class="text-center" width="80%">
                    <form class="form-group" method="GET">
                        <h5>Urutkan:</h5>
                        <select name="urut" class="form-control" onchange="this.form.submit()">
                            <option value="">Pilih</option>
                            <option value="terbaru" <?php echo (isset($_GET['urut']) && $_GET['urut'] == 'terbaru') ? 'selected' : ''; ?>>Produk Terbaru</option>
                            <option value="hurufA" <?php echo (isset($_GET['urut']) && $_GET['urut'] == 'hurufA') ? 'selected' : ''; ?>>Huruf A-Z</option>
                            <option value="hurufZ" <?php echo (isset($_GET['urut']) && $_GET['urut'] == 'hurufZ') ? 'selected' : ''; ?>>Huruf Z-A</option>
                            <option value="murah" <?php echo (isset($_GET['urut']) && $_GET['urut'] == 'murah') ? 'selected' : ''; ?>>Paling Murah</option>
                            <option value="mahal" <?php echo (isset($_GET['urut']) && $_GET['urut'] == 'mahal') ? 'selected' : ''; ?>>Paling Mahal</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-8 col-xl-9">
            <div class="row">
                <div class="col-md-12 pl-5 text-secondary">
                    <?php 
                    // Menampilkan hasil pencarian
                    if (isset($_GET['select'])) {
                        $cari = $_GET['select'];
                        
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <?php
                // Menentukan query berdasarkan pencarian dan pengurutan
                $query = "SELECT * FROM tbl_produk";
                if (isset($_GET['select'])) {
                    $cari = $_GET['select'];
                    $query .= " WHERE nm_produk LIKE '%" . mysqli_real_escape_string($db, $cari) . "%'";
                }

                // Menambahkan pengurutan
                if (isset($_GET['urut'])) {
                    switch ($_GET['urut']) {
                        case 'terbaru':
                            $query .= " ORDER BY id_produk DESC";
                            break;
                        case 'hurufA':
                            $query .= " ORDER BY nm_produk ASC";
                            break;
                        case 'hurufZ':
                            $query .= " ORDER BY nm_produk DESC";
                            break;
                        case 'murah':
                            $query .= " ORDER BY harga ASC";
                            break;
                        case 'mahal':
                            $query .= " ORDER BY harga DESC";
                            break;
                    }
                } else {
                    $query .= " ORDER BY id_produk ASC"; // Default order
                }

                $result = mysqli_query($db, $query);
                while ($produk = mysqli_fetch_assoc($result)) {
                ?>
                <div class="mb-0 p-1 col-md-6 col-lg-4 col-xl-3">
                    <div class="item card">
                        <div class="thumbnail">
                            <?php 
                            $gambarList = json_decode($produk['gambar'], true);
                            if ($gambarList != null) {
                            ?>
                                <a href="detail-produk.php?id=<?php echo $produk['id_produk']; ?>">
                                    <img src="admin/assets/images/foto_produk/<?php echo $gambarList[0] ?>" alt="img" class="card-img-top pt-2">
                                </a>
                            <?php } ?>
                            <div class="star-rating" style="position: absolute; top: 7px; right: 10px; font-size: 10px;">
                                <ul class="list-inline text-warning">
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item m-0"><i class="fa fa-star-o"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong><?php echo htmlspecialchars($produk['nm_produk']); ?></strong><br>
                            <h6 class="text-danger">Rp. <?php echo number_format($produk['harga']); ?></h6>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });
    });
</script>

<?php require "footer.php"; ?>