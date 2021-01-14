<?php include 'includes/session.php'; ?>
<?php
if (!isset($_GET['user'])) {
  header('location: users.php');
  exit();
} else {
  $conn = $pdo->open();

  $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
  $stmt->execute(['id' => $_GET['user']]);
  $user = $stmt->fetch();

  $pdo->close();
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
                  <i class="pe-7s-cart icon-gradient bg-mean-fruit">
                  </i>
                </div>
                <div><?php echo $user['firstname'] . ' ' . $user['lastname'] . '`s Cart' ?>
                  <div class="page-title-subheading">Cart details of <?php echo $user['firstname'] . ' ' . $user['lastname']  ?>
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
                    <a href="#addnew" data-toggle="modal" id="add" data-id="<?php echo $user['id']; ?>" class="mb-2 mr-2 btn btn-primary btn-sm"><i class="fa fa-plus"></i> New</a>
                    <a href="users.php" class="mb-2 mr-2 btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Users</a>
                  </span>

                  <table id="example1" class="table table-borderless table-hover">
                    <thead>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>Tools</th>
                    </thead>
                    <tbody>
                      <?php
                      $conn = $pdo->open();

                      try {
                        $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
                        $stmt->execute(['user_id' => $user['id']]);
                        foreach ($stmt as $row) {
                          echo "
                          <tr>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['quantity'] . "</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['cartid'] . "'><i class='fa fa-edit'></i> Edit Quantity</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['cartid'] . "'><i class='fa fa-trash'></i> Delete</button>
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

      $('#add').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getProducts(id);
      });

      $("#addnew").on("hidden.bs.modal", function() {
        $('.append_items').remove();
      });

    });

    function getProducts(id) {
      $.ajax({
        type: 'POST',
        url: 'products_all.php',
        dataType: 'json',
        success: function(response) {
          $('#product').append(response);
          $('.userid').val(id);
        }
      });
    }

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'cart_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.cartid').val(response.cartid);
          $('.userid').val(response.user_id);
          $('.productname').html(response.name);
          $('#edit_quantity').val(response.quantity);
        }
      });
    }
  </script>

</body>

</html>

<?php include 'includes/cart_modal.php'; ?>