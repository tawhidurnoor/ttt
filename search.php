<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body>
    <div>

        <?php include 'includes/navbar.php'; ?>

        <!-- Product Section Begin -->
        <section class="product spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">

                            <?php

							$conn = $pdo->open();

							$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products WHERE name LIKE :keyword");
							$stmt->execute(['keyword' => '%' . $_POST['keyword'] . '%']);
							$row = $stmt->fetch();
							if ($row['numrows'] < 1) {
								echo '<div class="col-lg-12 col-md-12 col-sm-12"><h4>No results found for <i>' . $_POST['keyword'] . '</i></h4></div>';
								echo '</br></br></br>';
							} else {
								echo '<div class="col-lg-12 col-md-12 col-sm-12"><h4>Search results for <i>' . $_POST['keyword'] . '</i></h4></div>';
								echo '</br></br></br>';
								try {
									$inc = 3;
									$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :keyword");
									$stmt->execute(['keyword' => '%' . $_POST['keyword'] . '%']);

									foreach ($stmt as $row) {
										$highlighted = preg_filter('/' . preg_quote($_POST['keyword'], '/') . '/i', '<b>$0</b>', $row['name']);
										$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
										echo '<div class="col-lg-4 col-md-6 col-sm-6">';
										echo '	<div class="product__item">';
										echo '		<div class="product__item__pic set-bg" data-setbg="' . $image . '">';
										echo '			<ul class="product__item__pic__hover"> <!--';
										echo '				<li><a href="#"><i class="fa fa-heart"></i></a></li>';
										echo '				<li><a href="#"><i class="fa fa-retweet"></i></a></li>';
										echo '				<li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>';
										echo '			</ul> -->';
										echo '		</div>';
										echo '		<div class="product__item__text">';
										echo '			<h6><a href="product.php?product=' . $row['slug'] . '">' . $highlighted . '</a></h6>';
										echo '			<h5>৳' . number_format($row['price'], 2) . '</h5>';
										echo '		</div>';
										echo '	</div>';
										echo '</div>';
									}
								} catch (PDOException $e) {
									echo "There is some problem in connection: " . $e->getMessage();
								}
							}

							$pdo->close();

							?>

                        </div>
						<!--
                        <div class="product__pagination">
                            <a href="#">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
						-->
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Section End -->

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>

</html>