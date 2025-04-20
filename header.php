<?php 
    session_start();
    require "koneksi.php";
 ?>

<!-- Menampilkan Daftar Kategori Produk -->
<?php
	$query = "SELECT * FROM tbl_kat_produk WHERE level = 1";
	$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Font -->
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Owl carausel -->
    <link rel="stylesheet" href="assets/css/owl2/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/css/owl2/owl.theme.default.min.css" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/icon/favicon.png">
    <link href="assets/css/material-design/css/materialdesignicons.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="assets/jquery/jquery.min.js"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135974525-2"></script>

    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
    <!-- <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-135974525-2');
    </script> -->

    <style>
        body {
            background-color: rgb(246, 245, 245);
        }

        .navbar {
            padding: 0px;
            margin: 0px;
            box-shadow: 0px 2px 5px grey;
        }

        .navbar-nav li {
            z-index: 1;
        }

        .navbar-nav li a {
            font-size: 17px;
            padding: 15px 30px !important;
        }

        .navbar-nav li a:hover {
            border-bottom: 3.5px solid #0066FF;
            transition: 0.5s all;
            font-size: 15px;
            padding: 14px 32.5px !important;
        }

        .navbar-light .navbar-nav .nav-item .nav-link {
            color: black;
        }

        @media(max-width:1200px) {
            .navbar-nav li {
                font-size: 15px;
            }
        }

        @media(max-width:992px) {
            .navbar-toggler {
                margin: 10px 0px 10px 30px;
                border-color: #ff4f81;
            }

            .navbar-toggler:hover,
            .navbar-toggler:focus {
                background-color: white;
                border-color: #ff4f81;
            }

            .navbar-light {
                background-color: white;
            }

            .navbar-nav li a {
                text-align: center;
                background-color: white;
            }

            .navbar-nav li a:hover {
                background-color: #0066FF;
            }

        }
    </style>
    <style>
        .navbar-dark .navbar-nav a.nav-link {
            color: #ffffff;
            font-size: 1.1em;
        }
        .dropdown-menu {
            border: none;
            border-radius: 0;
            padding: 0.7em;
        }
        @media only screen and (min-width: 992px) {
            .dropdown:hover .dropdown-menu {
                display: flex;
            }
            .dropdown-menu.show {
                display: flex;
            }
        }

        /* Ensure dropdown menu is hidden by default on mobile */
        @media only screen and (max-width: 991px) {
            .dropdown-menu {
                display: none;
                flex-direction: column;
            }
            .dropdown-menu.show {
                display: block;
            }
        }

        .dropdown-menu ul {
            list-style: none;
            padding: 0;
        }
        .dropdown-menu li .dropdown-item {
            color: gray;
            font-size: 1em;
            padding: 0.5em 1em;
        }
        .dropdown-menu li:first-child a {
            font-weight: bold;
            font-size: 1em;
            text-transform: uppercase;
            color: #007bff;
        }
        @media only screen and (max-width: 992px) {
            .dropdown-menu.show {
                flex-wrap: wrap;
                max-height: 350px;
                overflow-y: scroll;
            }
        }
        @media only screen and (min-width: 992px) and (max-width: 1140px) {
            .dropdown:hover .dropdown-menu {
                width: 40vw;
                flex-wrap: wrap;
            }
        }
    </style>

    <title>Fajar Sepatu</title>
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white m-0 p-0">
            <div class="container-fluid pl-3 pr-3">
                <a class="navbar-brand" href="#">
                    <img src="assets/img/icon/logo.png" width="100" height="30" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse  justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <?php while($pilih = mysqli_fetch_array($result)): ?>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <?php echo $pilih['nm_kategori'] ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <!-- Menampilkan Daftar Kategori Produk berdasarkan parent id -->
                                <?php
                                    $query2 = "SELECT * FROM tbl_kat_produk WHERE parent_id = " . $pilih['id_kategori'];
                                    $result2 = mysqli_query($db, $query2);
                                ?>
                                <?php while($pilih2 = mysqli_fetch_array($result2)): ?>
                                    <ul>
                                        <li><a class="dropdown-item" href="#"><?php echo $pilih2['nm_kategori'] ?></a></li>
                                        <!-- Menampilkan Daftar Kategori Produk berdasarkan parent id -->
                                        <?php
                                            $query3 = "SELECT * FROM tbl_kat_produk WHERE parent_id = " . $pilih2['id_kategori'];
                                            $result3 = mysqli_query($db, $query3);
                                        ?>
                                        <?php while($pilih3 = mysqli_fetch_array($result3)): ?>
                                            <li><a class="dropdown-item" href="shop.php?kategori=<?php echo $pilih3['id_kategori'] ?>"><?php echo $pilih3['nm_kategori'] ?></a></li>
                                        <?php endwhile;?>
                                    </ul>
                                <?php endwhile;?>
                            </div>
                            </li>
                        <?php endwhile;?>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="shop.php">Shop</a>
                            <!-- <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                Shop
                            </a>
                            <div class="dropdown-menu"">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div> -->
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION["pelanggan"])){
                                echo "<a class='nav-link' href='orderan.php'>Orderan</a>";
                            }
                            ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="mdi mdi-cart-outline text-primary"
                                    style="font-size: 17px;"></i></a>
                        </li>
                    </ul>
                </div>
                <?php if (isset($_SESSION["pelanggan"])) : ?>
                <button class="btn btn-primary navbar-btn m-2"
                    onclick="window.location.href='logout.php'">Logout</button>
                <?php else: ?>
                <button class="btn btn-primary navbar-btn m-2" onclick="window.location.href='login.php'">Login</button>
                <?php endif ?>

            </div>
        </nav>
    </header>