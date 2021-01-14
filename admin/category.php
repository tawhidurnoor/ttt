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
                  <i class="pe-7s-note2 icon-gradient bg-mean-fruit">
                  </i>
                </div>
                <div>Product Category
                  <div class="page-title-subheading">All product categories
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


                  <table id="example1" class="table table-borderless table-hover">
                    <thead>
                      <th>Category Name</th>
                      <th>Tools</th>
                    </thead>
                    <tbody>
                      <?php
                      $conn = $pdo->open();

                      try {
                        $stmt = $conn->prepare("SELECT * FROM category");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                          echo "
                          <tr>
                            <td>" . $row['name'] . "</td>
                            <td>
                              <button class='mb-2 mr-2 btn btn-success edit' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
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

    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'category_row.php',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('.catid').val(response.id);
          $('#edit_name').val(response.name);
          $('.catname').html(response.name);
        }
      });
    }
  </script>

</body>

</html>

<?php include 'includes/category_modal.php'; ?>