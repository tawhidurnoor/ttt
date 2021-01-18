<?php include 'includes/session.php'; ?>
<?php
if (isset($_SESSION['user'])) {
  header('location: cart_view.php');
}
?>
<?php include 'includes/header.php'; ?>

<body>
  <div class="wrapper">

    <?php include 'includes/navbar.php'; ?>

    <style>
      .shadow {
        width: auto;
        height: auto;

        margin-bottom: 50px;
        padding: 20px;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
      }
    </style>

    <div class="container" style="text-align: center;">
      <h4 style="margin-bottom: 50px;">Welcome to Ten to Thousand! Please login.</h4>
    </div>

    <div class="container shadow">

      <?php
      if (isset($_SESSION['error'])) {
        echo "
          <div class='callout callout-danger text-center'>
            <p>" . $_SESSION['error'] . "</p> 
          </div>
        ";
        unset($_SESSION['error']);
      }
      if (isset($_SESSION['success'])) {
        echo "
          <div class='callout callout-success text-center'>
            <p>" . $_SESSION['success'] . "</p> 
          </div>
        ";
        unset($_SESSION['success']);
      }
      ?>

      <form action="verify.php" method="post">
        <div class="row">
          <div class="col-md-2">
          </div>

          <div class="col-md-4 col-sm-12">
            <div class="form-group has-feedback">
              <input type="email" class="form-control" name="email" placeholder="Email" required>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
          </div>

          <div class="col-md-4 col-sm-12">
            <button type="submit" class="primary-btn" style="border: 0px;width:100%" name="login"><i class="fa fa-sign-in"></i> LOG IN</button>
            <br>
            <a href="password_forgot.php">Forgot password ?</a><br>
            <a href="signup.php" class="text-center">Register a new membership</a><br>
          </div>

          <div class="col-md-2">
          </div>

        </div>
      </form>
    </div>


    <?php include 'includes/footer.php'; ?>
  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    //
  </script>
</body>

</html>