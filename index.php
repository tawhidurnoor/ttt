<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>


<body>
	<?php include 'includes/navbar_home.php'; ?>

	<section class="featured spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>Featured Product</h2>
					</div>
					<div class="featured__controls">
						<ul>
							<li class="active" data-filter="*">All</li>
							<?php

							$conn = $pdo->open();
							try {
								$stmt = $conn->prepare("SELECT * FROM category");
								$stmt->execute();
								foreach ($stmt as $row) {
									echo "<li data-filter=." . $row['cat_slug'] . ">" . $row['name'] . "</li>";
								}
							} catch (PDOException $e) {
								echo "There is some problem in connection: " . $e->getMessage();
							}

							$pdo->close();

							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="row featured__filter">

				<?php

				$conn = $pdo->open();

				try {
					$inc = 3;
					$stmt = $conn->prepare("SELECT *, products.name AS proname FROM products INNER JOIN category ON products.category_id = category.id ORDER BY products.id DESC LIMIT 8");
					$stmt->execute();
					foreach ($stmt as $row) {
						$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
						echo '<div class="col-lg-3 col-md-4 col-sm-6 mix ' . $row['cat_slug'] . '">';
						echo '	<div class="featured__item">';
						echo '		<div class="featured__item__pic set-bg" data-setbg="' . $image . '">';
						echo '			<ul class="featured__item__pic__hover">';
						echo '				<li><a href="#"><i class="fa fa-heart"></i></a></li>';
						echo '				<li><a href="#"><i class="fa fa-retweet"></i></a></li>';
						echo '				<li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>';
						echo '			</ul>';
						echo '		</div>';
						echo '		<div class="featured__item__text">';
						echo '			<h6><a href="product.php?product=' . $row['slug'] . '">' . $row['proname'] . '</a></h6>';
						echo '			<h5>৳ ' . number_format($row['price'], 2) . '</h5>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					}
				} catch (PDOException $e) {
					echo "There is some problem in connection: " . $e->getMessage();
				}

				$pdo->close();

				?>

			</div>
		</div>
	</section>
	<!-- Featured Section End -->

	<!-- Banner Begin -->
	<div class="banner">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<div class="hero__item set-bg" data-setbg="img/banner/banner-1.jpg" style="background-image: url(&quot;img/banner/banner-1.jpg&quot;);">
						<div class="hero__text">
							<span>HOT DEALS</span>
							<h2 style="color:#FFF">Exclusive Sharees</h2>
							<a href="#" class="primary-btn">SHOP NOW</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<div class="hero__item set-bg" data-setbg="img/banner/banner-2.jpg" style="background-image: url(&quot;img/banner/banner-2.jpg&quot;);">
						<div class="hero__text">
							<span>HOT DEALS</span>
							<h2 style="color:#FFF">Exclusive Kurtees</h2>
							<a href="#" class="primary-btn">SHOP NOW</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Banner Ends -->

	<!-- Latest Product Section Begin -->
	<section class="latest-product spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="latest-product__text">
						<h4>Latest Products</h4>
						<div class="latest-prdouct__slider__item">

							<?php

							$conn = $pdo->open();

							try {
								$inc = 3;
								$stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 3");
								$stmt->execute();
								foreach ($stmt as $row) {
									$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';

									echo '<a href="product.php?product=' . $row['slug'] . '" class="latest-product__item"> ';
									echo '	<div class="latest-product__item__pic"> ';
									echo '		<img src="' . $image . '" > ';
									echo '	</div> ';
									echo '	<div class="latest-product__item__text"> ';
									echo '		<h6>' . $row['name'] . '</h6> ';
									echo '		<span>৳ ' . number_format($row['price'], 2) . '</span> ';
									echo '	</div> ';
									echo '</a>';
								}
							} catch (PDOException $e) {
								echo "There is some problem in connection: " . $e->getMessage();
							}

							$pdo->close();

							?>

						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="latest-product__text">
						<h4>Top Rated Products</h4>
						<div class="latest-product__slider owl-carousel">
							<div class="latest-prdouct__slider__item">
								<a href="#" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="img/latest-product/lp-1.jpg" alt="">
									</div>
									<div class="latest-product__item__text">
										<h6>Crab Pool Security</h6>
										<span>$30.00</span>
									</div>
								</a>
								<a href="#" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="img/latest-product/lp-2.jpg" alt="">
									</div>
									<div class="latest-product__item__text">
										<h6>Crab Pool Security</h6>
										<span>$30.00</span>
									</div>
								</a>
								<a href="#" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="img/latest-product/lp-3.jpg" alt="">
									</div>
									<div class="latest-product__item__text">
										<h6>Crab Pool Security</h6>
										<span>$30.00</span>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="latest-product__text">
						<h4>Review Products</h4>
						<div class="latest-product__slider owl-carousel">
							<div class="latest-prdouct__slider__item">
								<a href="#" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="img/latest-product/lp-1.jpg" alt="">
									</div>
									<div class="latest-product__item__text">
										<h6>Crab Pool Security</h6>
										<span>$30.00</span>
									</div>
								</a>
								<a href="#" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="img/latest-product/lp-2.jpg" alt="">
									</div>
									<div class="latest-product__item__text">
										<h6>Crab Pool Security</h6>
										<span>$30.00</span>
									</div>
								</a>
								<a href="#" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="img/latest-product/lp-3.jpg" alt="">
									</div>
									<div class="latest-product__item__text">
										<h6>Crab Pool Security</h6>
										<span>$30.00</span>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Latest Product Section End -->


	<?php include 'includes/footer.php'; ?>
	<?php include 'includes/scripts.php'; ?>
	<?php include 'includes/slider_js.php' ?>
</body>

</html>