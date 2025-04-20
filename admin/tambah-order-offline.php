<?php include "../koneksi.php" ?>

<!-- Menampilkan Daftar Produk -->
<?php
	$queryProduk = "SELECT * FROM tbl_produk";
	$resultProduk = mysqli_query($db, $queryProduk);

	// Store results in an array
    $produks = [];
	$result2 = mysqli_query($db, $queryProduk);
    while($row = mysqli_fetch_assoc($result2)) {
        $produks[] = $row;
    }
?>

<!-- Menambahkan Data Order -->
<?php
	if (isset($_POST['pesan']))
	{
		$tgl_order = $_POST['tgl_order'];
		$totalbayar= $_POST['subtotal_value'];
		$stockAvailable = true;     
		$kd_produk= $_POST['kd_produk'];     
		$nm_produk= $_POST['nm_produk'];   
		$harga= $_POST['harga'];   
		$size= $_POST['size'];   
		
		//simpan data ke pelanggan
		$query = "INSERT INTO tbl_order_offline (tgl_order,total_order,status)
				VALUES ('$tgl_order','$totalbayar', 'Sudah Dibayar')";
		$result = mysqli_query($db,$query);

		//mengambil id_order barusan terjadi
		$id_order_barusan = $db->insert_id;

		//simpat detail_order
		$total = count($kd_produk);
		
		for ($h = 0; $h < $total; $h++) {
			$idProduk = $kd_produk[$h];
			//mendapatkan data produk berdasarkan id_produk
			$ambil="SELECT * FROM tbl_produk WHERE id_produk='$idProduk'";
			$result2=mysqli_query($db,$ambil);
			$data=mysqli_fetch_array($result2);

			$nmProduk2 = $data['nm_produk'];
			$harga2 = $harga[$h];
			$jumlah2 = 1;
			$size2 = $size[$h];

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
				$query3 = "INSERT INTO tbl_detail_order_offline (id_order,id_produk,nm_produk,harga,jml_order,size)
					VALUES ('$id_order_barusan','$idProduk', '$nmProduk2','$harga2','$jumlah2','$size2')";
				$result3 = mysqli_query($db,$query3);
				
				// Update Stock                       
				$query4 = "UPDATE tbl_produk SET size='$sizes_json', stok='$total_stock' WHERE id_produk='$idProduk'";
				$result4 = mysqli_query($db,$query4);
			}
		}
		
		if ($stockAvailable) {
			echo "<script type='text/javascript'>
					swal({
						title: 'Pemesanan Berhasil',
						text: 'Data Sudah Tersimpan Ke Database Kami!',
						icon: 'success',
						button: false
					});
					</script>";
			echo "<p class='alert alert-success' role='alert'>
					Berhasil Menambahkan Data Order.<br />
					<a href='index.php?pages=order-offline'>Lihat Semua Orderan Offline</a>
					</p>";
		} else{
			$queryHapus = "DELETE FROM tbl_order_offline WHERE id_order='$id_order_barusan'";
			$execHapus = mysqli_query($db, $queryHapus);

			if ($execHapus)
			{
				echo "<script>alert('Jumlah Order melebihi Stock tersedia!');</script>";
				echo "<script>location='index.php?pages=tambah-order-offline';</script>";
			}
		}
	};
?>

<div class="row">
	<div class="col-12">
		<div class="card m-b-20">
			<div class="card-body">
				<form method="post" enctype="multipart/form-data" id="form-produk">
					<input type="hidden" name="subtotal_value" id="subtotal_value">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Tgl Order</label>
								<input name="tgl_order" type="date" class="form-control" required></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label font-weight-bold">Detail Produk</label>
								<table id="stockTable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
									cellspacing="0">
									<thead>
										<tr>
											<th>Kode Produk</th>
											<th>Nama Produk</th>
											<th>Harga</th>
											<th>Size</th>
											<th><button type="button" class="btn btn-primary waves-effect waves-light" onclick="addRow()">+</button></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<select class="form-control select2" id="kd_produk0" name="kd_produk[]" onchange="get_produk(0);">
													<option>Pilih Produk</option>
													<?php while($pilih = mysqli_fetch_array($resultProduk)): ?>
													<option value="<?php echo $pilih['id_produk']?>"
														data-nm_produk="<?php echo $pilih['nm_produk']  ?>"
														data-harga="<?php echo $pilih['harga']  ?>"
														data-size='<?php echo htmlspecialchars($pilih['size'], ENT_QUOTES, 'UTF-8'); ?>'>
														<?php echo $pilih['kd_produk']  ?>
													</option>
													<?php endwhile;?>
												</select>
											</td>
											<td><input type="text" id="nm_produk0" name="nm_produk[]" class="form-control" readonly required></td>
											<td><input type="number" id="harga0" name="harga[]" class="form-control harga" onkeyup="calculate(0)" required></td>
											<td>
												<select class="form-control select2" id="size0" name="size[]">
												</select>
											</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr>								
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
												name="subtotal"></span>
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
					<br>
					<button class="btn btn-primary" name="pesan">Buat Pesanan</button>
				</form>
			</div>
		</div>
	</div>	
</div>

<!-- menampilkan data provinsi dan kabupaten/kota dengan api raja ongkir -->
<script src="../assets/jquery/jquery.min.js"></script>
<script>
	const produks = <?php echo json_encode($produks); ?>;
	var index = 0;

	function get_produk(index) {
		let selected = $("#kd_produk" + index).find('option:selected');
		if (selected) {
			var nm_produk = selected.data('nm_produk');
			var harga = selected.data('harga');
			const size = selected.data('size');

			document.getElementById('nm_produk' + index).value=nm_produk;
			document.getElementById('harga' + index).value=harga;

			const selectElement = document.getElementById("size" + index);
			selectElement.innerHTML = "";
			size.forEach(item => {
				if (item.stock > 0) {
					let option = document.createElement("option");
					option.value = item.size;
					option.textContent = item.size + " (Stock: " + item.stock + ")";
					selectElement.appendChild(option);
				}
			});

			calculate(index);
		}
	}

	function calculate(index) {
		var harga = $('#harga' + index).val();
		var jumlah = 1;
		var total = harga * jumlah;

		let subtotal = [...document.querySelectorAll('.harga')]
			.map(el => parseFloat(el.value) || 0)
			.reduce((sum, num) => sum + num, 0);
		
		document.getElementById('subtotal_value').value = subtotal;
		document.getElementById('subtotal').textContent = subtotal.toLocaleString('id-ID');
		document.getElementById('total').textContent = subtotal.toLocaleString('id-ID');
	}

	function escapeHTML(str) {
		return str.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
	}

	function addRow() {
		index++;
		const table = document.getElementById('stockTable');
		const row = table.insertRow();

		const kdProdukCell = row.insertCell(0);
		const nmProdukCell = row.insertCell(1);
		const hargaCell = row.insertCell(2);
		const sizeCell = row.insertCell(3);
		const actionCell = row.insertCell(4);

		// Generate dynamic options from produks
		let options = '<option value="">Pilih Produk</option>';
		produks.forEach(cat => {
			const size = escapeHTML(cat.size);
			options += `<option value="${cat.id_produk}" data-nm_produk="${cat.nm_produk}" data-harga="${cat.harga}" data-size="${size}">${cat.kd_produk}</option>`;
		});
		kdProdukCell.innerHTML = `<select class="form-control select2" id="kd_produk${index}" name="kd_produk[]" onchange="get_produk(${index});">
			${options}
		</select>`;
		
		nmProdukCell.innerHTML = `<input type="text" id="nm_produk${index}" name="nm_produk[]" class="form-control" readonly required>`;
		hargaCell.innerHTML = `<input type="number" id="harga${index}" name="harga[]" class="form-control harga" onkeyup="calculate(${index})" required>`;
		sizeCell.innerHTML = `<select class="form-control select2" id="size${index}" name="size[]"></select>`;
		actionCell.innerHTML = '<button type="button" class="btn btn-danger waves-effect waves-light" onclick="deleteRow(this)">-</button>';

		// Re-initialize your select2 if needed
		$('.select2').select2(); 
	}

	function deleteRow(button) {
		const row = button.parentElement.parentElement;
		row.remove();

		calculate(index);
	}

	document.getElementById('form-produk').addEventListener('submit', function(e) {
		if (!validateSizeSelection()) {
			e.preventDefault();
		}
	});
</script>