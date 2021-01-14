<?php include 'includes/session.php'; ?>


<?php include 'includes/header.php'; ?>

<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

        <?php include 'includes/topbar.php'; ?>
        <?php include 'includes/settings_bar.php'; ?>

        <div class="app-main">
            <?php include 'includes/sidebar.php'; ?>

            <!-- Main Body Starts -->
            <div class="app-main__outer">
                <div class="app-main__inner">

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-star icon-gradient bg-mean-fruit">
                                    </i>
                                </div>
                                <div>Featured Products
                                    <div class="page-title-subheading">List of all featured products
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($_SESSION['error'])) {
                        echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
                        unset($_SESSION['success']);
                    }
                    ?>


                    <div class="row">

                        <div class="col-12">
                            <div class="main-card card">
                                <div class="card-body">

                                    <span class="pull-left">
                                        <a href="#addfeatured" data-toggle="modal" class="mb-2 mr-2 btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</a>
                                    </span>


                                    <table id="example1" class="table table-borderless table-hover productstable">
                                        <thead>
                                            <th>Name</th>
                                            <th>Photo</th>
                                            <th>Price</th>
                                            <th>Views Today</th>
                                            <th>Tools</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $conn = $pdo->open();

                                            try {
                                                $now = date('Y-m-d');
                                                $stmt = $conn->prepare("SELECT *, featured_products.id AS f_id FROM featured_products INNER JOIN products ON featured_products.product_id = products.id");
                                                $stmt->execute();
                                                foreach ($stmt as $row) {
                                                    $image = (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/noimage.jpg';
                                                    $counter = ($row['date_view'] == $now) ? $row['counter'] : 0;
                                                    echo "<tr>
                                                            <td>" . $row['name'] . "</td>
                                                            <td>
                                                            <a href='" . $image . "' target='_blank'> <img src='" . $image . "' height='30px' width='30px'> </a>
                                                            </td>
                                                            <td>‎৳ " . number_format($row['price'], 2) . "</td>
                                                            <td>" . $counter . "</td>
                                                            <td>
                                                              <button class='mb-2 mr-2 btn btn-danger delete' data-id='" . $row['f_id'] . "'><i class='fa fa-trash'></i> Remove</button>
                                                            </td>
                                                        </tr>";
                                                }
                                            } catch (PDOException $e) {
                                                echo $e->getMessage();
                                            }

                                            $pdo->close();
                                            ?>
                                        </tbody>
                                    </table>

                                    <script src="datatable/jquery-3.5.1.js"></script>
                                    <script src="datatable/jquery.dataTables.min.js"></script>
                                    <script src="datatable/dataTables.bootstrap4.min.js"></script>
                                    <script>
                                        $('.productstable').DataTable();
                                    </script>

                                </div>
                            </div>
                        </div>

                    </div>
                    <br><br>

                </div>

                <?php include 'includes/footer.php'; ?>

            </div>
            <!-- Main Body Ends -->

        </div>

    </div>

    <?php include 'includes/scripts.php'; ?>

    <script>
        $(function() {

            $(document).on('click', '.delete', function(e) {
                var id = $(this).data('id');
                e.preventDefault();
                $('#removefeatured').modal('show');
            });

        });
    </script>


</body>

</html>

<?php include 'includes/featured_modal.php'; ?>