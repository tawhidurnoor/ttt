<?php
include 'includes/session.php';
include 'includes/format.php';
?>

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
                  <i class="pe-7s-rocket icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Dashboard
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
            <div class="col-md-6 col-xl-3">
              <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                  <div class="widget-content-left">
                    <div class="widget-heading">Total Sales</div>
                    <div class="widget-subheading">Sales amount</div>
                  </div>
                  <div class="widget-content-right">
                    <div class="widget-numbers text-white">
                      <span>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id");
                        $stmt->execute();

                        $total = 0;
                        foreach ($stmt as $srow) {
                          $subtotal = $srow['price'] * $srow['quantity'];
                          $total += $subtotal;
                        }

                        echo "&#2547; " . number_format_short($total, 2);
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3">
              <div class="card mb-3 widget-content bg-night-sky">
                <div class="widget-content-wrapper text-white">
                  <div class="widget-content-left">
                    <div class="widget-heading">Products</div>
                    <div class="widget-subheading">Total product</div>
                  </div>
                  <div class="widget-content-right">
                    <div class="widget-numbers text-white">
                      <span>
                        <?php
                        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products");
                        $stmt->execute();
                        $prow =  $stmt->fetch();

                        echo $prow['numrows'];
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3">
              <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                  <div class="widget-content-left">
                    <div class="widget-heading">Users</div>
                    <div class="widget-subheading">Total number of users</div>
                  </div>
                  <div class="widget-content-right">
                    <div class="widget-numbers text-white">
                      <span>
                        <?php
                        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users");
                        $stmt->execute();
                        $urow =  $stmt->fetch();

                        echo $urow['numrows'];
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3">
              <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                  <div class="widget-content-left">
                    <div class="widget-heading">Sales Today</div>
                    <div class="widget-subheading">Sales amount of today</div>
                  </div>
                  <div class="widget-content-right">
                    <div class="widget-numbers text-white">
                      <span>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE sales_date=:sales_date");
                        $stmt->execute(['sales_date' => $today]);

                        $total = 0;
                        foreach ($stmt as $trow) {
                          $subtotal = $trow['price'] * $trow['quantity'];
                          $total += $subtotal;
                        }

                        echo "&#2547; " . number_format_short($total, 2);

                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sales Report will be here-->



        </div>

        <?php include 'includes/footer.php'; ?>

      </div>
      <!-- Main Body Ends -->

    </div>

  </div>




  <!-- Chart Data -->
  <?php
  $months = array();
  $sales = array();
  for ($m = 1; $m <= 12; $m++) {
    try {
      $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date)=:month AND YEAR(sales_date)=:year");
      $stmt->execute(['month' => $m, 'year' => $year]);
      $total = 0;
      foreach ($stmt as $srow) {
        $subtotal = $srow['price'] * $srow['quantity'];
        $total += $subtotal;
      }
      array_push($sales, round($total, 2));
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    $num = str_pad($m, 2, 0, STR_PAD_LEFT);
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);

  ?>
  <!-- End Chart Data -->

  <?php $pdo->close(); ?>
  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function() {
      var barChartCanvas = $('#canvas').get(0).getContext('2d')
      var barChart = new Chart(barChartCanvas)
      var barChartData = {
        labels: <?php echo $months; ?>,
        datasets: [{
          label: 'SALES',
          fillColor: 'rgba(60,141,188,0.9)',
          strokeColor: 'rgba(60,141,188,0.8)',
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: <?php echo $sales; ?>
        }]
      }
      //barChartData.datasets[1].fillColor   = '#00a65a'
      //barChartData.datasets[1].strokeColor = '#00a65a'
      //barChartData.datasets[1].pointColor  = '#00a65a'
      var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      }

      barChartOptions.datasetFill = false
      var myChart = barChart.Bar(barChartData, barChartOptions)
      document.getElementById('legend').innerHTML = myChart.generateLegend();
    });
  </script>
  <script>
    $(function() {
      $('#select_year').change(function() {
        window.location.href = 'home.php?year=' + $(this).val();
      });
    });
  </script>




</body>

</html>