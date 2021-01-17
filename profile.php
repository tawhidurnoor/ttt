<?php include 'includes/session.php'; ?>
<?php
if (!isset($_SESSION['user'])) {
	header('location: index.php');
}
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.cssstyle.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">


	<div class="wrapper">

		<?php include 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">


				<?php
				if (isset($_SESSION['error'])) {
					echo "<div class='callout callout-danger'>" . $_SESSION['error'] . "</div>";
					unset($_SESSION['error']);
				}

				if (isset($_SESSION['success'])) {
					echo "<div class='callout callout-success'>" . $_SESSION['success'] . "</div>";
					unset($_SESSION['success']);
				}
				?>
				<div class="container-fluid" style="margin-bottom: 50px;">
					<!-- ============================================================== -->
					<!-- Start Page Content -->
					<!-- ============================================================== -->
					<!-- Row -->
					<div class="row">
						<!-- Column -->
						<div class="col-lg-4 col-xlg-3 col-md-5">
							<div class="card" style="background-color: #f5f5f5;">
								<div class="card-body">
									<center class="m-t-30"> <img src="<?php echo (!empty($user['photo'])) ? 'images/' . $user['photo'] : 'images/profile.jpg'; ?>" class="rounded-circle" width="150" />
										<h4 class="card-title m-t-10"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h4>
										<h6 class="card-subtitle">Member since <?php echo date('M d, Y', strtotime($user['created_on'])); ?></h6>
									</center>
								</div>

								<div class="card-body">
									<small class="text-muted">Email address </small>
									<h6><?php echo $user['email']; ?></h6>

									<small class="text-muted p-t-30 db">Phone</small>
									<h6><?php echo (!empty($user['contact_info'])) ? $user['contact_info'] : 'N/a'; ?></h6>

									<small class="text-muted p-t-30 db">Address</small>
									<h6><?php echo (!empty($user['address'])) ? $user['address'] : 'N/a'; ?></h6>
								</div>

								<a href="#edit" class="btn btn-success btn-flat btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
							</div>
						</div>
						<!-- Column -->
						<!-- Column -->
						<div class="col-lg-8 col-xlg-9 col-md-7">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title m-t-10">Order History</h4>
								</div>
								<div class="card-body">
									<div class="shoping__cart__table">
										<table class="table-hover table-responsive-sm" id="example">
											<thead>
												<th>Date</th>
												<th>Transaction#</th>
												<th>Amount</th>
												<th>Full Details</th>
											</thead>
											<tbody>
												<?php
												$conn = $pdo->open();

												try {
													$stmt = $conn->prepare("SELECT * FROM sales WHERE user_id=:user_id ORDER BY sales_date DESC");
													$stmt->execute(['user_id' => $user['id']]);
													foreach ($stmt as $row) {
														$stmt2 = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id=:id");
														$stmt2->execute(['id' => $row['id']]);
														$total = 0;
														foreach ($stmt2 as $row2) {
															$subtotal = $row2['price'] * $row2['quantity'];
															$total += $subtotal;
														}
														echo "
	        									<tr>
	        										<td>" . date('M d, Y', strtotime($row['sales_date'])) . "</td>
	        										<td>" . $row['pay_id'] . "</td>
	        										<td>&#36; " . number_format($total, 2) . "</td>
	        										<td><button class='btn btn-sm btn-flat btn-info transact' data-id='" . $row['id'] . "'><i class='fa fa-search'></i> View</button></td>
	        									</tr>
	        								";
													}
												} catch (PDOException $e) {
													echo "There is some problem in connection: " . $e->getMessage();
												}

												$pdo->close();
												?>
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
						<!-- Column -->
					</div>
					<!-- Row -->
					<!-- ============================================================== -->
					<!-- End PAge Content -->
					<!-- ============================================================== -->
					<!-- ============================================================== -->
					<!-- Right sidebar -->
					<!-- ============================================================== -->
					<!-- .right-sidebar -->
					<!-- ============================================================== -->
					<!-- End Right sidebar -->
					<!-- ============================================================== -->
				</div>


			</div>
		</div>

		<?php include 'includes/footer.php'; ?>
		<?php include 'includes/profile_modal.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>
	<script>
		$(function() {
			$(document).on('click', '.transact', function(e) {
				e.preventDefault();
				$('#transaction').modal('show');
				var id = $(this).data('id');
				$.ajax({
					type: 'POST',
					url: 'transaction.php',
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

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		});
	</script>
</body>

</html>