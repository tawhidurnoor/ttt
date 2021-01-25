<?php include 'includes/session.php'; ?>
<?php
$where = '';
if (isset($_GET['category'])) {
  $catid = $_GET['category'];
  $where = 'WHERE category_id =' . $catid;
}

?>

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
                  <i class="pe-7s-shopbag icon-gradient bg-mean-fruit">
                  </i>
                </div>
                <div>Product List
                  <div class="page-title-subheading">List of all products.
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

                  <div>
                    <span class="pull-left">
                      <a href="#addnew" data-toggle="modal" class="mb-2 mr-2 btn btn-primary btn-sm" id="addproduct"><i class="fa fa-plus"></i> New</a>
                    </span>

                    <div class="pull-right">
                      <form class="form-inline">
                        <div class="form-group">
                          <select class="form-control input-sm" id="select_category">
                            <option value="0">ALL</option>
                            <?php
                            $conn = $pdo->open();

                            $stmt = $conn->prepare("SELECT * FROM category");
                            $stmt->execute();

                            foreach ($stmt as $crow) {
                              $selected = ($crow['id'] == $catid) ? 'selected' : '';
                              echo "
                            <option value='" . $crow['id'] . "' " . $selected . ">" . $crow['name'] . "</option>
                          ";
                            }

                            $pdo->close();
                            ?>
                          </select>
                        </div>
                      </form>
                    </div>
                  </div>

                  <table id="example1" class="table table-borderless table-hover productstable">
                    <thead>
                      <th>Name</th>
                      <th>Photo</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Views Today</th>
                      <th>Status</th>
                      <th>Tools</th>
                    </thead>
                    <tbody>
                      <?php
                      $conn = $pdo->open();
                      
                      try {
                        $now = date('Y-m-d');
                        $stmt = $conn->prepare("SELECT * FROM products $where");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                          $image = (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/noimage.jpg';
                          $counter = ($row['date_view'] == $now) ? $row['counter'] : 0;
                          echo "
                          <tr>
                            <td>" . $row['name'] . "</td>
                            <td>
                              <a href='" . $image . "' target='_blank'> <img src='" . $image . "' height='30px' width='30px'> </a>
                              <span ><a href='#edit_photo' class='photo' data-toggle='modal' data-id='" . $row['id'] . "'><i class='fas fa-pencil-alt'></i></a></span>
                            </td>
                            <td><a href='#description' data-toggle='modal' class='mb-2 mr-2 btn btn-info desc' data-id='" . $row['id'] . "'><i class='fas fa-eye'></i> View</a></td>
                            <td>‎৳ " . number_format($row['price'], 2) . "</td>
                            <td>" . $counter . "</td>
                            <td>
                              <select name='' id=''>
                                <option value='Avaliable'>Avaliable</option>
                                <option value='Stock_out'>Stock Out</option>
                              </select>
                            </td>
                            <td>
                              <button class='mb-2 mr-2 btn btn-success edit' data-id='" . $row['id'] . "'><i class='fas fa-pencil-alt'></i> Edit</button>
                              <button class='mb-2 mr-2 btn btn-danger delete' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                          </tr>
                        ";
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

        </div>

        <?php include 'includes/footer.php'; ?>

      </div>
      <!-- Main Body Ends -->

    </div>

  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      $(document).on('click', '.edit', function(e) {
        e.preventDefault();
        $('#edit').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        $('#delete').modal('show');
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.photo', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

      $(document).on('click', '.desc', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

      $('#select_category').change(function() {
        var val = $(this).val();
        if (val == 0) {
          window.location = 'products.php';
        } else {
          window.location = 'products.php?category=' + val;
        }
      });

      $('#addproduct').click(function(e) {
        e.preventDefault();
        getCategory();
      });

      $("#addnew").on("hidden.bs.modal", function() {
        $('.append_items').remove();
      });

      $("#edit").on("hidden.bs.modal", function() {
        $('.append_items').remove();
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'products_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#desc').html(response.description);
          $('.name').html(response.prodname);
          $('.prodid').val(response.prodid);
          $('#edit_name').val(response.prodname);
          $('#catselected').val(response.category_id).html(response.catname);
          $('#edit_price').val(response.price);

          $('#editor2').summernote('code', response.description);
          getCategory();
        }
      });
    }

    function getCategory() {
      $.ajax({
        type: 'POST',
        url: 'category_fetch.php',
        dataType: 'json',
        success: function(response) {
          $('#category').append(response);
          $('#edit_category').append(response);
        }
      });
    }
  </script>

</body>

</html>

<?php include 'includes/products_modal.php'; ?>
<?php include 'includes/products_modal2.php'; ?>