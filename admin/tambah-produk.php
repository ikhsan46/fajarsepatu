<?php include "../koneksi.php" ?>

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

<!-- Menambahkan Data Produk -->
<?php
if (isset($_POST['tambah']))
{
	$kategori = $_POST['id_kategori3'];
    $kdProduk = $_POST['kode'];
    $nmProduk = $_POST['nama'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $modal = $_POST['modal'];
    $stok = $_POST['stok'];
    $size = $_POST['size'];
    $deskripsi = $_POST['deskripsi'];
    $nmGambar = json_encode($_FILES['img']['name'], true);

    //memindah file gambar dari file temporari ke folder assets/images/foto_produk/
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

	$total = count($stok);
    for ($i = 0; $i < $total; $i++) {
        if (!empty($stok[$i])) {
            $size_stock[] = ["size" => $size[$i], "stock" => (int)$stok[$i]];
        }
    }

    $stock = array_sum(array_column($size_stock, 'stock'));
    $sizes_json = json_encode($size_stock);
	
    $kategori_json = json_encode($kategori);
	
	//Memasukkan data ke tabel tbl_produk
	$query_add = "INSERT INTO tbl_produk
			(id_kategori,kd_produk,nm_produk,berat,harga,stok,gambar,deskripsi,size,modal)
			VALUE('$kategori_json', '$kdProduk', '$nmProduk', '$berat', '$harga', '$stock','$nmGambar', '$deskripsi', '$sizes_json', '$modal')";
	$exec_add = mysqli_query($db, $query_add);
	//Menampilkan pesan jika data berhasil di masukkan
	echo "<p class='alert alert-success' role='alert'>
			Berhasil Menambahkan Data Produk.<br />
			<a href='index.php?pages=produk'>Lihat Semua Produk</a>
			</p>";
};
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
								<input name="kode" type="text" class="form-control" required></div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label>Nama Produk</label>
								<input name="nama" type="text" class="form-control" required></div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Kategori Produk</label>
								<div id="kategori-container">
									<div class="row kategori-row">
										<div class="col-sm-4">
											<div class="form-group">
												<select class="form-control select2" id="id_kategori_0" name="id_kategori[]" onchange="get_kategori2(this, 0);">
													<option>Pilih Kategori</option>
													<?php while($pilih = mysqli_fetch_array($result)): ?>
													<option  value="<?php echo $pilih['id_kategori']?>" >
														<?php echo $pilih['nm_kategori']  ?>
													</option>
													<?php endwhile;?>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<select class="form-control select2" id="id_kategori2_0" name="id_kategori2[]" onchange="get_kategori3(this, 0);">
												</select>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<select class="form-control select2" id="id_kategori3_0" name="id_kategori3[]" required>
												</select>
											</div>
										</div>
										<div class="col-sm-1">
											<button type="button" class="btn btn-primary" onclick="addRowKategori()">+</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Berat Produk (Kg)</label>
								<input name="berat" type="text" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Harga Produk</label>
								<input name="harga" type="text" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Modal Produk</label>
								<input name="modal" type="text" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Stock Produk</label>
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
										<tr>
											<td>
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
												</select>
											</td>
											<td><input type="number" name="stok[]" class="form-control" required></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Masukkan Gambar Produk</label>
								<input type="file" class="filestyle" data-buttonname="btn-secondary" name="img[]" multiple accept="image/*" required></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Deskripsi Produk</label>
								<textarea id="elm1" name="deskripsi"></textarea>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success waves-effect waves-light" name="tambah">Tambah</button>
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
	var index = 0;
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