<?php require "../koneksi.php" ?>
<?php require "query.php" ?>
<?php
$query = "SELECT COUNT(*) AS jml FROM tbl_order_offline WHERE status='Belum Dibayar'";
$result = mysqli_query($db,$query);
$data = mysqli_fetch_array($result);
/* echo $data['jml']; */

?> 


<div class="row">
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-primary mr-0 float-right"><i class="mdi mdi-cart-outline"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($totalOrderOffline['jml']); ?></h3>
            </div>
            <div class="clearfix"></div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">
                Total Order
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1 ;
                            $query="SELECT * FROM tbl_order_offline";
                            $result = mysqli_query($db,$query);
                            while ($data = mysqli_fetch_assoc($result)) {
                                $tgl = $data['tgl_order'];
                                $status = $data['status'];
                        ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo date("d/m/Y", strtotime($tgl)); ?></td>
                            <td>
                                <?php 
                                    if ($status == 'Belum Dibayar') {
                                        echo "<span class='badge badge-warning'>".$status."</span>";
                                    }
                                    elseif ($status == 'Sudah Dibayar') {
                                        echo "<span class='badge badge-secondary'>".$status."</span>";
                                    }
                                    elseif ($status == 'Menyiapkan Produk') {
                                        echo "<span class='badge badge-info'>".$status."</span>";
                                    }
                                    elseif ($status == 'Produk Dikirim') {
                                        echo "<span class='badge badge-danger'>".$status."</span>";
                                    }
                                    elseif ($status == 'Produk Diterima') {
                                                echo "<span class='badge badge-success'>".$status."</span>";
                                    }
                                ?>
                            </td>
                            <td>Rp. <?php echo number_format($data['total_order'], 2, '.', ',') ?></td>
                            <td>
                                <a href="index.php?pages=detail-order-offline&id=<?php echo $data['id_order']; ?>"
                                    class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="Detail"><i class="mdi mdi-buffer font-18"></i></a>
                            </td>
                        </tr>
                        <?php  
                            $no++;
                            }    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>