    <style>
        .list-unstyled li a {
            color: white;
            text-decoration: none;
        }

        .list-unstyled li a:hover {
            color: rgb(163, 211, 255);
            text-decoration: none;
        }
        input.btn.i {
            border: 2px solid white;
            width: 75%;
            padding: 7px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        button.btn.o {
            border: 2px solid white;
            padding: 7px;
            font-weight: bold;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        ::placeholder {
            color: white;
        }

        footer {
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
    <footer>
        <div class="page-footer font-small indigo  bg-primary mt-3">
            <div class="container-fluid text-center text-md-left">
                <div class="row text-white">
                    <div class="col-md-3 mx-auto">
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-2">ABOUT US</h5>
                        Fajar Sepatu adalah situs web yang menjual produk Fashion seperti Sepatu, Sendal, tas, Koper dll.
                        <br>
                        <img src="assets/img/icon/ig.PNG" height="25px" width="25px" alt="">
                        <img src="assets/img/icon/fb.png" height="25px" width="25px" alt="">
                        <img src="assets/img/icon/twitter.png" height="23px" width="23px" alt="">
                    </div>
                   
                    
                    <div class="col-md-3 mx-auto">
                        <h5 class="font-weight-bold text-uppercase mt-3 mb-2">CONTACT US</h5>
                        <ul class="list-unstyled">
                        <a aria-label="Chat on WhatsApp" href="https://wa.me/+6281240615161"><img alt="Chat on WhatsApp" src="admin/assets/images/waa.png" height="25px" width="120px" alt="" />
                         </a> <br>
                            fajarsepatu@gmail.com <br>
                            Jl. Frans Kaisiepo, Malaingkedi, Kecamatan Sorong Manoi, Kota Sorong, Papua Bar. 98412
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright text-center py-3 bg-dark text-white">© 2025 Fajar Sepatu
                <a href="index.html"> </a>
            </div>
        </div>
    </footer>

    </body>
    <!-- Js Dasar -->
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- Popper -->
    <script src="assets/js/popper/popper.min.js"></script>
    <!-- Owl Carausel -->
    <script src="assets/js/owl2/owl.carousel.min.js"></script>
    <!-- Sweetalert -->
    <script src="assets/js/sweetalert/sweetalert.min.js"></script>

    <!-- Stok Detail Produk -->
    <!-- Plugins js -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>

    <!-- Plugins Init js -->
    <script src="admin/assets/pages/form-advanced.js"></script>

    <!-- Datatable js -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Responsive examples -->
    <script src="plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });

        document.addEventListener("DOMContentLoaded", function () {
            let dropdowns = document.querySelectorAll(".dropdown");

            dropdowns.forEach((dropdown) => {
                let toggle = dropdown.querySelector(".dropdown-toggle");
                let menu = dropdown.querySelector(".dropdown-menu");

                toggle.addEventListener("click", function (event) {
                    event.preventDefault();
                    menu.classList.toggle("show");
                });
            });
        });

    </script>

    </html>