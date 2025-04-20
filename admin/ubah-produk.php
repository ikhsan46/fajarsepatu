<?php require "../koneksi.php" ?>

<!-- Menampilkan Daftar Kategori Produk -->
<?php
	$query = "SELECT * FROM tbl_kat_produk WHERE level = 1";
	$result = mysqli_query($db, $query);

	// Store results in an array
    $categories = [];
	$result2 = mysqli_query($db, $query);
    while($row = mysqli_fetch_assoc($result2)) {
        $categories[] = $row;
    }
?>

<!-- Lihat Data Produk -->
<?php 
	$id = $_GET['id'];
	$queryProduk = "SELECT * FROM tbl_produk WHERE id_produk='$id' ";
	$resultProduk = mysqli_query($db, $queryProduk);
	$produk = mysqli_fetch_assoc($resultProduk);
	$size_stock = json_decode($produk['size'], true);
?>
<?php
$id = $_GET['id'];
if (isset($_POST['ubah'])) {
	$kategori = $_POST['id_kategori3'];
    $kdProduk = $_POST['kode'];
    $nmProduk = $_POST['nama'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $modal = $_POST['modal'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $size = $_POST['size'];
    $nmGambar = json_encode($_FILES['img']['name'], true);
	
	$size_stock = [];
	$total = count($stok);
    for ($i = 0; $i < $total; $i++) {
        if (!empty($stok[$i])) {
            $size_stock[] = ["size" => $size[$i], "stock" => (int)$stok[$i]];
        }
    }

    $stock = array_sum(array_column($size_stock, 'stock'));
    $sizes_json = json_encode($size_stock);

	$kategori_json = json_encode($kategori);

	if (!empty($_FILES['img']['name'][0])) {
		$totalFiles = count($_FILES['img']['name']);
		for ($i = 0; $i < $totalFiles; $i++) {
			$fileName = $_FILES['img']['name'][$i];
			$fileTmp = $_FILES['img']['tmp_name'][$i];
			$fileError = $_FILES['img']['error'][$i];

			// Validasi jika tidak ada error
			if ($fileError === 0) {
				// Pindahkan file ke folder tujuan
				if (move_uploaded_file($fileTmp, "assets/images/foto_produk/" . $fileName)) {
					
				} else {
					echo "<p class='alert alert-success' role='alert'>
							Gagal mengunggah " . $fileName . "</p>";
				}
			} else {
				echo "<p class='alert alert-success' role='alert'>
							Terjadi error pada file " . $fileName . "</p>";
			}
		}

		$queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori_json', kd_produk='$kdProduk', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stock', gambar='$nmGambar', deskripsi='$deskripsi', size='$sizes_json', modal='$modal'
		WHERE id_produk='$id'";
		$resultEdit = mysqli_query($db, $queryEdit);
	}
	else {
		$queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori_json', kd_produk='$kdProduk', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stock', deskripsi='$deskripsi', size='$sizes_json', modal='$modal'
		WHERE id_produk='$id'";
		$resultEdit = mysqli_query($db, $queryEdit);
	}
	echo "<script>alert('Data produk sudah di ubah')</script>";
	echo "<script>location='index.php?pages=produk';</script>";
}
// if (!empty($_POST))
// {
// 	$kategori = $_POST['id_ kategori'];
//     $nama = $_POST['nama'];
//     $berat = $_POST['berat'];
// 	$harga = $_POST['harga'];
// 	$stok = $_POST['stok'];
// 	$deskripsi = $_POST['deskripsi'];
	
//     if ($_FILES['img']['error'] == 0)
//     { //apakah form menyertakan gambar
//         $img = $_FILES['img']; //menyimpan file gambar
//         $new_img = 'assets/images/foto_produk/img_' . date('YmdHis') . '.jpg'; //nama file setelah di upload ke server
//         if (copy($img['tmp_name'], $new_img)) 
//         {
//             $query_add = "INSERT INTO tbl_produk
//                 (id_kategori,nm_produk,berat,harga,stok,gambar,deskripsi)
//                 VALUE('$kategori', '$nama', '$berat', '$harga', '$stok','$new_img', '$deskripsi')";
//             $exec_add = mysqli_query($db, $query_add);
//         }
//         else
//         {
//             echo "<p class='alert alert-danger' role='alert'>
//                 [Error] Upload Gambar Gagal.<br />
//                 </p>";
//         }
//     }
//     else
//     {
//          $query_add = "INSERT INTO tbl_produk
//                 (id_kategori,nm_produk,berat,harga,stok,gambar,deskripsi)
//                 VALUE('$kategori', '$nama', '$berat', '$harga', '$stok',null, '$deskripsi')";
//             $exec_add = mysqli_query($db, $query_add);
//     }

//     if ($exec_add) echo "<p class='alert alert-success' role='alert'>
//                 Berhasil Menambahkan Data Produk.<br />
//                 <a href='index.php?pages=produk'>Lihat Semua Produk</a>
//                 </p>";
//     else echo "<p class='alert alert-danger' role='alert'>
//                 [Error] Gagal Menambahkan Data Produk.<br />" . mysqli_error($db) . "
// 				</p>";
				
	
// }
?>
<div class="row">
	<div class="col-12">
		<div class="card m-b-20">
			<div class="card-body">
				<form method="post" enctype="multipart/form-data" id="form-produk">
					<div class="row">
						<div class="col-sm-1">
							<div class="form-group">
								<label>Kode Produk</label>
								<input name="kode" type="text" class="form-control"
									value="<?php echo $produk['kd_produk']; ?>" required></div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label>Nama Produk</label>
								<input name="nama" type="text" class="form-control"
									value="<?php echo $produk['nm_produk']; ?>" required></div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Kategori Produk</label>
								<?php 
									$kategoriList = json_decode($produk['id_kategori'], true);
									$index = 0;
								?>

								<?php foreach ($kategoriList as $key => $id_kategori3) { 
									$index = $key;
									//query menampilkan kategori 1
									$query1 = "SELECT a.id_kategori FROM tbl_kat_produk a LEFT JOIN tbl_kat_produk b ON a.id_kategori = b.parent_id LEFT JOIN tbl_kat_produk c ON b.id_kategori = c.parent_id WHERE c.id_kategori = '$id_kategori3' ";
									$result1 = mysqli_query($db, $query1);
									$id_kategori1 = mysqli_fetch_assoc($result1)['id_kategori'];
									
									//query menampilkan kategori 2
									$query2 = "SELECT b.id_kategori FROM tbl_kat_produk a LEFT JOIN tbl_kat_produk b ON a.id_kategori = b.parent_id LEFT JOIN tbl_kat_produk c ON b.id_kategori = c.parent_id WHERE c.id_kategori = '$id_kategori3' ";
									$result2 = mysqli_query($db, $query2);
									$id_kategori2 = mysqli_fetch_assoc($result2)['id_kategori'];
									
									//query menampilkan list kategori
									$queryKat = "SELECT * FROM tbl_kat_produk WHERE level = 1 ";
									$resultKat = mysqli_query($db, $queryKat);
									
									$queryKat2 = "SELECT * FROM tbl_kat_produk WHERE parent_id = '$id_kategori1' ";
									$resultKat2 = mysqli_query($db, $queryKat2);
									
									$queryKat3 = "SELECT * FROM tbl_kat_produk WHERE parent_id = '$id_kategori2' ";
									$resultKat3 = mysqli_query($db, $queryKat3);
								?>
								<div id="kategori-container">
									<div class="row kategori-row">
										<div class="col-sm-4">
											<div class="form-group">
												<select class="form-control select2" id="id_kategori_<?php echo $index; ?>" name="id_kategori[]" onchange="get_kategori2(this);">
													<option>Pilih Kategori</option>
													<?php while($pilih = mysqli_fetch_array($resultKat)): ?>
													<?php $active = ($id_kategori1 == $pilih['id_kategori'])?"selected":""?>
													<option value="<?php echo $pilih['id_kategori']?>" <?php echo $active?>>
														<?php echo $pilih['nm_kategori']?>
													</option>
													<?php endwhile;?>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<select class="form-control select2" id="id_kategori2_<?php echo $index; ?>" name="id_kategori2[]" onchange="get_kategori3(this);">
												<option>Pilih Kategori</option>
													<?php while($pilih2 = mysqli_fetch_array($resultKat2)): ?>
													<?php $active = ($id_kategori2 == $pilih2['id_kategori'])?"selected":""?>
													<option value="<?php echo $pilih2['id_kategori']?>" <?php echo $active?>>
														<?php echo $pilih2['nm_kategori']?>
													</option>
													<?php endwhile;?>
												</select>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<select class="form-control select2" id="id_kategori3_<?php echo $index; ?>" name="id_kategori3[]" required>
												<option>Pilih Kategori</option>
													<?php while($pilih3 = mysqli_fetch_array($resultKat3)): ?>
													<?php $active = ($id_kategori3 == $pilih3['id_kategori'])?"selected":""?>
													<option value="<?php echo $pilih3['id_kategori']?>" <?php echo $active?>>
														<?php echo $pilih3['nm_kategori']?>
													</option>
													<?php endwhile;?>
												</select>
											</div>
										</div>
										<div class="col-sm-1">
											<?php if ($index == 0) { ?>
												<button type="button" class="btn btn-primary" onclick="addRowKategori()">+</button>
											<?php } else { ?>
												<button type="button" class="btn btn-danger" onclick="removeRowKategori()">-</button>
											<?php } ?>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Berat Produk (Kg)</label>
								<input name="berat" type="text" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
									value="<?php echo $produk['berat']; ?>"></div>							
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Harga Produk</label>
								<input name="harga" type="text" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
									value="<?php echo $produk['harga']; ?>" required></div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Modal Produk</label>
								<input name="modal" type="number" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
									value="<?php echo $produk['modal']; ?>" required></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Stock Produk</label>
								<table id="sizeStockTable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
									cellspacing="0">
									<thead>
										<tr>
											<th>Size</th>
											<th>Stock</th>
											<th><button type="button" class="btn btn-primary waves-effect waves-light" onclick="addRow()">+</button></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($size_stock as $item) { ?>
										<tr>
											<td>
												<select name="size[]" class="form-control">
													<option value="">Tidak Ada Size</option>
													<option value="20" <?php if ($item['size'] == '20') echo 'selected'; ?>>20</option>
													<option value="21" <?php if ($item['size'] == '21') echo 'selected'; ?>>21</option>
													<option value="22" <?php if ($item['size'] == '22') echo 'selected'; ?>>22</option>
													<option value="23" <?php if ($item['size'] == '23') echo 'selected'; ?>>23</option>
													<option value="24" <?php if ($item['size'] == '24') echo 'selected'; ?>>24</option>
													<option value="25" <?php if ($item['size'] == '25') echo 'selected'; ?>>25</option>
													<option value="26" <?php if ($item['size'] == '26') echo 'selected'; ?>>26</option>
													<option value="27" <?php if ($item['size'] == '27') echo 'selected'; ?>>27</option>
													<option value="28" <?php if ($item['size'] == '28') echo 'selected'; ?>>28</option>
													<option value="29" <?php if ($item['size'] == '29') echo 'selected'; ?>>29</option>
													<option value="30" <?php if ($item['size'] == '30') echo 'selected'; ?>>30</option>
													<option value="31" <?php if ($item['size'] == '31') echo 'selected'; ?>>31</option>
													<option value="32" <?php if ($item['size'] == '32') echo 'selected'; ?>>32</option>
													<option value="33" <?php if ($item['size'] == '33') echo 'selected'; ?>>33</option>
													<option value="34" <?php if ($item['size'] == '34') echo 'selected'; ?>>34</option>
													<option value="35" <?php if ($item['size'] == '35') echo 'selected'; ?>>35</option>
													<option value="36" <?php if ($item['size'] == '36') echo 'selected'; ?>>36</option>
													<option value="37" <?php if ($item['size'] == '37') echo 'selected'; ?>>37</option>
													<option value="38" <?php if ($item['size'] == '38') echo 'selected'; ?>>38</option>
													<option value="39" <?php if ($item['size'] == '39') echo 'selected'; ?>>39</option>
													<option value="40" <?php if ($item['size'] == '40') echo 'selected'; ?>>40</option>
													<option value="41" <?php if ($item['size'] == '41') echo 'selected'; ?>>41</option>
													<option value="42" <?php if ($item['size'] == '42') echo 'selected'; ?>>42</option>
													<option value="43" <?php if ($item['size'] == '43') echo 'selected'; ?>>43</option>
													<option value="44" <?php if ($item['size'] == '44') echo 'selected'; ?>>44</option>
													<option value="45" <?php if ($item['size'] == '45') echo 'selected'; ?>>45</option>
												</select>
											</td>
											<td><input type="number" name="stok[]" value="<?php echo $item['stock']; ?>" class="form-control" required></td>
											<td><button type="button" class="btn btn-danger waves-effect waves-light" onclick="deleteRow(this)">-</button></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Gambar Sebelumnya</label><br>
								<?php 
									$gambarList = json_decode($produk['gambar'], true); // Decode JSON to array
								?>
								<?php if($gambarList!=null):?>
									<?php foreach($gambarList as $gambar){ ?>
										<img src="assets/images/foto_produk/<?php echo $gambar; ?>" alt="product img" class="img-fluid"
										style="max-height: 125px;" />
									<?php }; ?>
								<?php endif;?>
								
							</div>
							<div class="form-group">
								<label>Ganti Gambar</label>
								<input type="file" class="filestyle" data-buttonname="btn-secondary" name="img[]" multiple accept="image/*"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Deskripsi Produk</label>
								<textarea id="elm1" name="deskripsi"><?php echo $produk['deskripsi']; ?></textarea>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success waves-effect waves-light" name="ubah">Ubah</button>
					<button type="submit" class="btn btn-secondary waves-effect">Batal</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	function addRow() {
		const table = document.getElementById('sizeStockTable');
		const row = table.insertRow();

		const sizeCell = row.insertCell(0);
		const stockCell = row.insertCell(1);
		const actionCell = row.insertCell(2);

		sizeCell.innerHTML = `
		<select name="size[]" class="form-control">
			<option value="">Tidak Ada Size</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
			<option value="32">32</option>
			<option value="33">33</option>
			<option value="34">34</option>
			<option value="35">35</option>
			<option value="36">36</option>
			<option value="37">37</option>
			<option value="38">38</option>
			<option value="39">39</option>
			<option value="40">40</option>
			<option value="41">41</option>
			<option value="42">42</option>
			<option value="43">43</option>
			<option value="44">44</option>
			<option value="45">45</option>
		</select>`;
		
		stockCell.innerHTML = '<input type="number" name="stok[]" class="form-control" required>';
		actionCell.innerHTML = '<button type="button" class="btn btn-danger waves-effect waves-light" onclick="deleteRow(this)">-</button>';
	}

	function deleteRow(button) {
		const row = button.parentElement.parentElement;
		row.remove();
	}

	const categories = <?php echo json_encode($categories); ?>;
	var index = <?php echo $index; ?>;
	function addRowKategori() {
		index++;
		const container = document.getElementById('kategori-container');
		
		const newRow = document.createElement('div');
		newRow.classList.add('row', 'kategori-row', 'mt-2');
		
		// Generate dynamic options from categories
		let options = '<option value="">Pilih Kategori</option>';
		categories.forEach(cat => {
			options += `<option value="${cat.id_kategori}">${cat.nm_kategori}</option>`;
		});
		
		newRow.innerHTML = `
			<div class="col-sm-4">
				<div class="form-group">
					<select class="form-control select2" id="id_kategori_${index}" name="id_kategori[]" onchange="get_kategori2(this, ${index});">
						${options}
					</select>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="form-group">
					<select class="form-control select2" id="id_kategori2_${index}" name="id_kategori2[]" onchange="get_kategori3(this, ${index});"></select>
				</div>
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<select class="form-control select2" id="id_kategori3_${index}" name="id_kategori3[]" required></select>
				</div>
			</div>
			
			<div class="col-sm-1">
				<button type="button" class="btn btn-danger" onclick="removeRowKategori(this)">-</button>
			</div>
		`;

		// Append the new row to the container
		container.appendChild(newRow);
		
		// Re-initialize your select2 if needed
		$('.select2').select2(); 
	}

	// Function to remove row
	function removeRowKategori(button) {
		// Remove the row where the button is located
		index--;
		button.parentElement.parentElement.remove();
	}

	function validateSizeSelection() {
        let sizeDropdowns = document.querySelectorAll('select[name="size[]"]');
        let selectedValues = [];
        for (let i = 0; i < sizeDropdowns.length; i++) {
            if (selectedValues.includes(sizeDropdowns[i].value)) {
				swal({
					title: 'Informasi',
					text: 'Tidak boleh memilih ukuran yang sama!',
					icon: 'info',
					button: false
				});
                return false;
            }
            selectedValues.push(sizeDropdowns[i].value);
        }
        return true;
    }

    document.getElementById('form-produk').addEventListener('submit', function(e) {
        if (!validateSizeSelection()) {
            e.preventDefault();
        }
    });
</script>

<!-- menampilkan data kategori berdasarkan parent id -->
<script>
    function get_kategori2(ele, index) {
		$("#id_kategori2_"+index).html("");
		$("#id_kategori3_"+index).html("");
        $.getJSON("get-kategori.php?id_kategori=" + ele.value, function (result) {
            if (result) {
                $("#id_kategori2_"+index).html("<option value=''>Pilih Kategori</option>");
                $.each(result, function (key, value) {
                    $("#id_kategori2_"+index).append(
                        "<option value='" + value.id_kategori + "'>" + value.nm_kategori + "</option>"
                    );
                });
            }
        });
    }

	function get_kategori3(ele, index) {
		$("#id_kategori3_"+index).html("");
        $.getJSON("get-kategori.php?id_kategori=" + ele.value, function (result) {
            if (result) {
                $("#id_kategori3_"+index).html("<option value=''>Pilih Kategori</option>");
                $.each(result, function (key, value) {
                    $("#id_kategori3_"+index).append(
                        "<option value='" + value.id_kategori + "'>" + value.nm_kategori + "</option>"
                    );
                });
            }
        });
    }
</script>