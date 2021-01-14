<?php include 'includes/session.php'; ?>
<?php
$today = date('Y-m-d');
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}

$conn = $pdo->open();
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
                  <i class="pe-7s-user icon-gradient bg-mean-fruit">
                  </i>
                </div>
                <div>Users
                  <div class="page-title-subheading">List of all registered user.
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
                    <a href="#addnew" data-toggle="modal" class="mb-2 mr-2 btn btn-primary btn-sm"><i class="fa fa-plus"></i> New</a>
                  </span>

                  <table id="example1" class="table table-borderless table-hover userstable">
                    <thead>
                      <th>Photo</th>
                      <th>Email</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Date Added</th>
                      <th>Tools</th>
                    </thead>
                    <tbody>
                      <?php
                      $conn = $pdo->open();

                      try {
                        $stmt = $conn->prepare("SELECT * FROM users WHERE type=:type");
                        $stmt->execute(['type' => 0]);
                        foreach ($stmt as $row) {
                          $image = (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/profile.jpg';
                          $status = ($row['status']) ? '<span class="label label-success">active</span>' : '<span class="label label-danger">not verified</span>';
                          $active = (!$row['status']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="' . $row['id'] . '"><i class="fa fa-check-square-o"></i></a></span>' : '';
                          echo "
                          <tr>
                            <td>
                              <img src='" . $image . "' height='30px' width='30px'>
                              <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='" . $row['id'] . "'><i class='fas fa-pencil-alt'></i></a></span>
                            </td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                            <td>
                              " . $status . "
                              " . $active . "
                            </td>
                            <td>" . date('M d, Y', strtotime($row['created_on'])) . "</td>
                            <td>
                              <a href='cart.php?user=" . $row['id'] . "' class='mb-2 mr-2 btn btn-info btn-sm'><i class='fas fa-shopping-cart'></i> Cart</a>
                              <button class='mb-2 mr-2 btn btn-success btn-sm edit' data-id='" . $row['id'] . "'><i class='fas fa-pencil-alt'></i> Edit</button>
                              <button class='mb-2 mr-2 btn btn-danger btn-sm delete' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
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
                    $('.userstable').DataTable();
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

      $(document).on('click', '.status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
      });

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'users_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.userid').val(response.id);
          $('#edit_email').val(response.email);
          $('#edit_password').val(response.password);
          $('#edit_firstname').val(response.firstname);
          $('#edit_lastname').val(response.lastname);
          $('#edit_address').val(response.address);
          $('#edit_contact').val(response.contact_info);
          $('.fullname').html(response.firstname + ' ' + response.lastname);
        }
      });
    }
  </script>

</body>

</html>

<?php include 'includes/users_modal.php'; ?>