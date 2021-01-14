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
                  <i class="pe-7s-cash icon-gradient bg-mean-fruit">
                  </i>
                </div>
                <div>Sales History
                  <div class="page-title-subheading">System Dashboard shows some curent page stats.
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
                  <table class="table table-borderless table-hover salestable">
                    <thead>
                      <th class="hidden"></th>
                      <th>Date</th>
                      <th>Buyer Name</th>
                      <th>Transaction#</th>
                      <th>Amount</th>
                      <th>Full Details</th>
                    </thead>
                    <tbody>
                      <?php
                      $conn = $pdo->open();

                      try {
                        $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id ORDER BY sales_date DESC");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                          $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE details.sales_id=:id");
                          $stmt->execute(['id' => $row['salesid']]);
                          $total = 0;
                          foreach ($stmt as $details) {
                            $subtotal = $details['price'] * $details['quantity'];
                            $total += $subtotal;
                          }
                          echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>" . date('M d, Y', strtotime($row['sales_date'])) . "</td>
                            <td>" . $row['firstname'] . ' ' . $row['lastname'] . "</td>
                            <td>" . $row['pay_id'] . "</td>
                            <td>&#2547; " . number_format($total, 2) . "</td>
                            <td><button type='button' class='mb-2 mr-2 btn btn-info transact' data-id='" . $row['salesid'] . "'><i class='fa fa-search'></i> View</button></td>
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
                    $('.salestable').DataTable();
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
  <!-- Date Picker -->
  <script>
    $(function() {
      //Date picker
      $('#datepicker_add').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })
      $('#datepicker_edit').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      })

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      })

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'MM/DD/YYYY h:mm A'
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

    });
  </script>
  <script>
    $(function() {
      $(document).on('click', '.transact', function(e) {
        e.preventDefault();
        $('#transaction').modal('show');
        var id = $(this).data('id');
        $.ajax({
          type: 'POST',
          url: 'transact.php',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {
            $('#date').html(response.date);
            $('#transid').html(response.transaction);
            $('#detail').prepend(response.list);
            $('#total').html(response.total);
          }
        });
      });

      $("#transaction").on("hidden.bs.modal", function() {
        $('.prepend_items').remove();
      });
    });
  </script>

</body>

</html>

<?php include 'includes/transaction_history_modal.php'; ?>