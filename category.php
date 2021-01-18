<?php include 'includes/session.php'; ?>
<?php include 'includes/connection.php'; ?>
<?php

if (isset($_GET['category'])) {
    $slug = $_GET['category'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("SELECT * FROM category WHERE cat_slug = :slug");
        $stmt->execute(['slug' => $slug]);
        $cat = $stmt->fetch();
        $catid = $cat['id'];
    } catch (PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }

    $pdo->close();
}


?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <!-- Product Section Begin -->
        <section class="product spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-5">
                        <div class="sidebar">
                            <div class="sidebar__item">
                                <div class="latest-product__text">
                                    <h4>Latest Products</h4>
                                    <div class="latest-prdouct__slider__item">

                                        <?php

                                        $conn = $pdo->open();

                                        try {

                                            if (isset($_GET['category'])) {
                                                $stmt1 = $conn->prepare("SELECT * FROM products WHERE category_id = :catid ORDER BY id DESC LIMIT 5");
                                                $stmt1->execute(['catid' => $catid]);
                                            } else {
                                                $stmt1 = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 5");
                                                $stmt1->execute();
                                            }


                                            foreach ($stmt1 as $row1) {
                                                $image1 = (!empty($row1['photo'])) ? 'images/' . $row1['photo'] : 'images/noimage.jpg';
                                                echo '<a href="product.php?product=' . $row1['slug'] . '" class="latest-product__item">';
                                                echo '	<div class="latest-product__item__pic">';
                                                echo '		<img src="' . $image1 . '" alt="">';
                                                echo '	</div>';
                                                echo '	<div class="latest-product__item__text">';
                                                echo '		<h6>' . $row1['name'] . '</h6>';
                                                echo '		<span>৳' . number_format($row1['price'], 2) . '</span>';
                                                echo '	</div>';
                                                echo '</a>';
                                            }
                                        } catch (PDOException $e) {
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-7">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-4 col-md-5">
                                    <div class="filter__sort">
                                        <span>Sort By</span>
                                        <select>
                                            <option value="0">Default</option>
                                            <option value="0">Price(Low to high)</option>
                                            <option value="0">Price(High to low)</option>
                                            <option value="0">Recent</option>
                                        </select>
                                    </div>
                                </div>
                                <!--
                                <div class="col-lg-4 col-md-4">
                                    <div class="filter__found">
                                        <h6><span>20</span> Products found</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3">
                                    <div class="filter__option">
                                        <span class="icon_grid-2x2"></span>
                                        <span class="icon_ul"></span>
                                    </div>
								</div>
									-->
                            </div>
                        </div>
                        <div class="row">

                            <?php

                            $conn = $pdo->open();

                            // define how many results you want per page
                            $results_per_page = 15;

                            try {
                                $inc = 3;

                                if (isset($_GET['category'])) {
                                    //$stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :catid");
                                    //$stmt->execute(['catid' => $catid]);
                                    $sql = 'SELECT * FROM products WHERE category_id = ' . $catid;
                                    $result = mysqli_query($connection, $sql);

                                    // find out the number of results stored in database
                                    $number_of_results = mysqli_num_rows($result);
                                } else {
                                    //$stmt = $conn->prepare("SELECT * FROM products");
                                    //$stmt->execute();
                                    $sql = 'SELECT * FROM products';
                                    $result = mysqli_query($connection, $sql);
                                    // find out the number of results stored in database
                                    $number_of_results = mysqli_num_rows($result);
                                }

                                // determine number of total pages available
                                $number_of_pages = ceil($number_of_results / $results_per_page);

                                // determine which page number visitor is currently on
                                if (!isset($_GET['page'])) {
                                    $page = 1;
                                } else {
                                    $page = $_GET['page'];
                                }

                                // determine the sql LIMIT starting number for the results on the displaying page
                                $this_page_first_result = ($page - 1) * $results_per_page;


                                if (isset($_GET['category'])) {
                                    $stmt = $conn->prepare('SELECT * FROM products WHERE category_id = :catid LIMIT ' . $this_page_first_result . ',' .  $results_per_page);
                                    $stmt->execute(['catid' => $catid]);
                                } else {
                                    $stmt = $conn->prepare('SELECT * FROM products LIMIT ' . $this_page_first_result . ',' .  $results_per_page);
                                    $stmt->execute();
                                }


                                foreach ($stmt as $row) {
                                    $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';

                                    echo '<div class="col-lg-4 col-md-6 col-sm-6">';
                                    echo '	<div class="product__item">';
                                    echo '		<div class="product__item__pic set-bg" data-setbg="' . $image . '">';
                                    echo '			<ul class="product__item__pic__hover">';
                                    echo '				<!-- <li><a href="#"><i class="fa fa-heart"></i></a></li>';
                                    echo '				<li><a href="#"><i class="fa fa-retweet"></i></a></li>';
                                    echo '				<li><a href="#"><i class="fa fa-shopping-cart"></i></a></li> -->';
                                    echo '			</ul>';
                                    echo '		</div>';
                                    echo '		<div class="product__item__text">';
                                    echo '			<h6><a href="product.php?product=' . $row['slug'] . '">' . $row['name'] . '</a></h6>';
                                    echo '			<h5>৳' . number_format($row['price'], 2) . '</h5>';
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
                        <div class="product__pagination">
                            <?php
                            // display the links to the pages
                            for ($page = 1; $page <= $number_of_pages; $page++) {

                                if (isset($_GET['category'])) {
                                    $category = $_GET['category'];
                                    echo '<a href="category.php?category='.$category.'&page=' . $page . '">' . $page . '</a> ';
                                } else {
                                    echo '<a href="category.php?page=' . $page . '">' . $page . '</a> ';
                                }
                                
                            }
                            ?>
                        </div>
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