<?php require "../koneksi.php" ?>

<!-- Lihat Data Produk -->
<?php
	$query = "SELECT * FROM tbl_produk";
    $result = mysqli_query($db, $query);
?>

<!-- Hapus Data Produk -->
<?php
if (isset($_GET['id']))
{
    //mengambil id produk
    $id = $_GET['id'];
    //memilih data table dengan id yang sudah di ambil
    $query2 = "SELECT * FROM tbl_produk Where id_produk = '$id'";
    $exec = mysqli_query($db, $query2);
    //mengubah data menjadi array
    $produk2 = mysqli_fetch_array($exec);
    //menghapus gambar
    $gambar = $produk2['gambar'];
    if (file_exists("assets/images/foto_produk/$gambar"))
    {
        unlink("assets/images/foto_produk/$gambar");
    }
    //menghapus data
    $queryHapus = "DELETE FROM tbl_produk WHERE id_produk='$id'";
    $execHapus = mysqli_query($db, $queryHapus);

    if ($execHapus)
    {
        //menampilkan pesan dan redirec ke halaman produk
        echo "<script>alert('Produk sudah dihapus');</script>";
        echo "<script>location='index.php?pages=produk';</script>";
    }
}
?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
					cellspacing="0">
					<thead>
						<tr>
							<th>Image</th>
							<th>Kode Produk</th>
							<th>Nama Produk</th>
							<th>Berat (Kg)</th>
							<th>Harga</th>
							<th>Size</th>
							<th>Stok</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($produk = mysqli_fetch_array($result)) : ?>
							<?php
								$size_stock = json_decode($produk['size'], true);
								$jenis_size = implode(', ', array_unique(array_column($size_stock, 'size')));
							?>
						<tr>
							<td class="product-list-img">
								<?php 
									$gambarList = json_decode($produk['gambar'], true); // Decode JSON to array
								?>
								<?php if($gambarList!=null):?>
								<img width="200" src="assets/images/foto_produk/<?php echo $gambarList[0]?>" class="img-fluid" alt="tbl">
								<?php endif;?>
							</td>
							<td>
								<h6 class="mt-0 m-b-5"><?php echo $produk['kd_produk'] ?></h6>
								<!-- <p class="m-0 font-14">
							Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..
						</p> -->
							</td>
							<td>
								<h6 class="mt-0 m-b-5"><?php echo $produk['nm_produk'] ?></h6>
								<!-- <p class="m-0 font-14">
							Lorem ipsum dolor sit consec te imperdiet iaculis ipsum..
						</p> -->
							</td>
							<td><?php echo number_format($produk['berat'], 2, '.', ',') ?> Kg</td>
							<td>Rp. <?php echo number_format($produk['harga'], 2, '.', ',') ?></td>
							<td><?php echo $jenis_size; ?></td>
							<td><?php echo number_format($produk['stok']) ?></td>
							<td>
								<a href="index.php?pages=ubah-produk&id=<?php echo $produk['id_produk']; ?>" class="m-r-15 text-muted" data-toggle="tooltip"
									data-placement="top" title="" data-original-title="Edit"><i
										class="mdi mdi-pencil font-18"></i></a>
								<a href="index.php?pages=produk&id=<?php echo $produk['id_produk']; ?>" class="text-muted" data-toggle="tooltip"
									data-placement="top" title="" data-original-title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk tersebut?')"><i
										class="mdi mdi-close font-18"></i></a>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>