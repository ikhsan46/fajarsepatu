<?php
if (isset($_GET['pages']))
{
    if ($_GET['pages'] == "dashboard")
    {
        include 'dashboard.php';
    }
    elseif ($_GET['pages'] == "produk")
    {
        include 'produk.php';
    }
    elseif ($_GET['pages'] == "tambah-produk")
    {
        include 'tambah-produk.php';
    }
    elseif ($_GET['pages'] == "ubah-produk")
    {
        include 'ubah-produk.php';
    }
    elseif ($_GET['pages'] == "hapus-produk")
    {
        include 'hapus-produk.php';
    }
    elseif ($_GET['pages'] == "tambah-kategori")
    {
        include 'tambah-kategori.php';
    }
    elseif ($_GET['pages'] == "ubah-kategori")
    {
        include 'ubah-kategori.php';
    }
    elseif ($_GET['pages'] == "pelanggan")
    {
        include 'pelanggan.php';
    }
    elseif ($_GET['pages'] == "order")
    {
        include 'order.php';
    }
    elseif ($_GET['pages'] == "detail-order")
    {
        include 'detail-order.php';
    }
    elseif ($_GET['pages'] == "pembayaran")
    {
        include 'pembayaran.php';
    }
   
    elseif ($_GET['pages'] == "banner")
    {
        include 'banner.php';
    }
    elseif ($_GET['pages'] == "tambah-banner")
    {
        include 'tambah-banner.php';
    }
    elseif ($_GET['pages'] == "ubah-banner")
    {
        include 'ubah-banner.php';
    }
    elseif ($_GET['pages'] == "order-offline")
    {
        include 'order-offline.php';
    }
    elseif ($_GET['pages'] == "tambah-order-offline")
    {
        include 'tambah-order-offline.php';
    }
    elseif ($_GET['pages'] == "ubah-order-offline")
    {
        include 'ubah-order-offline.php';
    }
    elseif ($_GET['pages'] == "hapus-order-offline")
    {
        include 'hapus-order-offline.php';
    }
    elseif ($_GET['pages'] == "detail-order-offline")
    {
        include 'detail-order-offline.php';
    }
    elseif ($_GET['pages'] == "logout")
    {
        include 'logout.php';
    }
}
else
{
    include 'dashboard.php';
}
?>
