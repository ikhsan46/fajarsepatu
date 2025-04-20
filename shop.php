<?php require "header.php"; ?>

<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        padding: 0;
        margin: 0;
    }

    .img .box {
        height: 250px;
        background-color: rgba(41, 41, 41, 0.7);
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

    .atas .card {
        padding: 1px;
        border: 1px solid silver;
    }

    .atas .card:hover {
        border: none;
    }

    .item:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5), 0 6px 20px rgba(0, 0, 0, 0.4);
    }
</style>

<div class="banner mb-5">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>SHOP</h3>
            <p>Home > <a href="#">Shop</a></p>
        </div>
    </div>
</div>

<div class="container">
    <?php
    if (isset($_GET['kategori'])) {
        $kategori = $_GET['kategori'];
        $query = "SELECT * FROM tbl_produk WHERE JSON_CONTAINS(id_kategori, '\"$kategori\"')";
    } elseif (isset($_GET['id_banner'])) {
        $id_banner = $_GET['id_banner'];
        $queryBanner = "SELECT * FROM tbl_banner WHERE id_banner='$id_banner'";
        $resultBanner = mysqli_query($db, $queryBanner);
        $dataBanner = mysqli_fetch_assoc($resultBanner);

        if (isset($dataBanner['id_produk'])) {
            $id_produk = $dataBanner['id_produk'];
            $id_array = json_decode($id_produk, true);
            if (is_array($id_array) && !empty($id_array)) {
                $join_str = implode("','", $id_array);
                $id_list_str = "'" . $join_str . "'";
                $query = "SELECT * FROM tbl_produk WHERE id_produk IN ($id_list_str) ORDER BY id_produk ASC";
            } else {
                $query = "SELECT * FROM tbl_produk ORDER BY id_produk ASC";
            }
        }
    } elseif (isset($_GET['select'])) {
        $cari = $_GET['select'];
        $query = "SELECT * FROM tbl_produk WHERE nm_produk LIKE '%" . $cari . "%' ORDER BY id_produk ASC";
    } else {
        $query = "SELECT * FROM tbl_produk ORDER BY id_produk ASC";
    }
    ?>
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
                        echo "<h4><i>Hasil pencarian : " . htmlspecialchars($cari) . "</i></h4>";
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

<?php require "footer.php"; ?>

<script>
    function toggleSubCategory(id) {
        const subCategory = document.getElementById(id);
        subCategory.style.display = (subCategory.style.display === 'block') ? 'none' : 'block';
    }

    function showSubCategory(id) {
        const subCategory = document.getElementById(id);
        subCategory.style.display = (subCategory.style.display === 'block') ? 'none' : 'block';
        event.stopPropagation();
    }
</script>