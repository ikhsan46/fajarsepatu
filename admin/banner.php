<?php require "../koneksi.php" ?>

<!-- Lihat Data Produk -->
<?php
	$query = "SELECT * FROM tbl_banner";
    $result = mysqli_query($db, $query);
?>
<?php
if (isset($_GET['id']))
{
    //mengambil id banner
    $id = $_GET['id'];
    //menghapus data
    $queryHapus = "DELETE FROM tbl_banner WHERE id_banner='$id'";
    $execHapus = mysqli_query($db, $queryHapus);

    if ($execHapus)
    {
        //menampilkan pesan dan redirec ke halaman produk
        echo "<script>alert('Banner sudah dihapus');</script>";
        echo "<script>location='index.php?pages=banner';</script>";
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
							<th>No</th>
							<th>Judul</th>
							<th>Diskon (%)</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
                        <?php $no = 1;?>
                        <?php while ($data = mysqli_fetch_array($result)) : ?>
						<tr>
							<td><?php echo $no ?></td>
							<td><?php echo $data['judul'] ?></td>
							<td><?php echo number_format($data['diskon']) ?></td>
							<td><?php echo $data['status'] ?></td>
							<td>
								<a href="index.php?pages=ubah-banner&id=<?php echo $data['id_banner']; ?>" class="m-r-15 text-muted" data-toggle="tooltip"
									data-placement="top" title="" data-original-title="Edit"><i
										class="mdi mdi-pencil font-18"></i></a>
								<a href="index.php?pages=banner&id=<?php echo $data['id_banner']; ?>" class="text-muted" data-toggle="tooltip"
									data-placement="top" title="" data-original-title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus banner tersebut?')"><i
										class="mdi mdi-close font-18"></i></a>
							</td>
                        </tr>
                        <?php $no++; ?>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>