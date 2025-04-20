<?php include "../koneksi.php" ?>

<?php

if (isset($_GET['level']))
{
    $level = isset($_GET['level']) ? $_GET['level'] : '';
    $new_level = $level - 1;
	$query = "SELECT * FROM tbl_kat_produk WHERE level = '$new_level' ";
	$result = mysqli_query($db, $query);

    // Initialize an empty array
    $data = [];

    // Fetch all results into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Output as JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
}

if (isset($_GET['id_kategori']))
{
    $id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : '';
	$query = "SELECT * FROM tbl_kat_produk WHERE parent_id = '$id_kategori' ";
	$result = mysqli_query($db, $query);

    // Initialize an empty array
    $data = [];

    // Fetch all results into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Output as JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
}