<?php include 'includes/session.php'; ?>
<?php
$conn = $pdo->open();

$slug = $_GET['product'];

try {

    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE slug = :slug");
    $stmt->execute(['slug' => $slug]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}

//page view
$now = date('Y-m-d');
if ($product['date_view'] == $now) {
    $stmt = $conn->prepare("UPDATE products SET counter=counter+1 WHERE id=:id");
    $stmt->execute(['id' => $product['prodid']]);
} else {
    $stmt = $conn->prepare("UPDATE products SET counter=1, date_view=:now WHERE id=:id");
    $stmt->execute(['id' => $product['prodid'], 'now' => $now]);
}

?>
<?php include 'includes/header.php'; ?>

<body>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <style>
            .link_style {
                color: #023246 !important;
            }
        </style>

        <!-- Path Section Begin -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a class="link_style" href="./">Home</a>
                    >
                    <a class="link_style" href="category.php?category=<?php echo $product['cat_slug']; ?>"><?php echo $product['catname']; ?></a>
                    >
                    <?php echo $product['prodname']; ?>
                </div>
            </div>
        </div>
        <!-- Path Section End -->

        <span class="message"></span>

        <!-- Product Details Section Begin -->
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__item">
                                <img src="<?php echo (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg'; ?>">
                            </div>
                            <!--
                            <div class="product__details__pic__slider owl-carousel">
                                <img data-imgbigurl="img/product/details/product-details-2.jpg"
                                    src="img/product/details/thumb-1.jpg" alt="">
                                <img data-imgbigurl="img/product/details/product-details-3.jpg"
                                    src="img/product/details/thumb-2.jpg" alt="">
                                <img data-imgbigurl="img/product/details/product-details-5.jpg"
                                    src="img/product/details/thumb-3.jpg" alt="">
                                <img data-imgbigurl="img/product/details/product-details-4.jpg"
                                    src="img/product/details/thumb-4.jpg" alt="">
							</div>
-->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__text">
                            <h3><?php echo $product['prodname']; ?></h3>
                            <div class="product__details__price">৳ <?php echo number_format($product['price'], 2); ?>
                            </div>

                            <ul>
                                <li><b>Availability</b> <span>In Stock</span></li>
                                <li><b>Shipping</b> <span>Max 07 days shipping. <samp>Free pickup from office</samp></span>
                                </li>
                            </ul>

                            <form id="productForm">
                                <div class="product__details__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" name="quantity" id="quantity" value="1">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $product['prodid']; ?>" name="id">
                                <button type="submit" class="primary-btn" style="border: 0px;background: #044e6d"><i class="fa fa-shopping-cart"></i> ADD TO
                                    CART</button>
                                <!--<a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>-->
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Products Infomation</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <?php echo $product['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Details Section End -->

        <!-- Fb comments plugin Section Begin -->
        <div class="container">
            <div class="fb-comments" data-href="http://localhost/ecommerce/product.php?product=<?php echo $slug; ?>" data-numposts="10" width="100%"></div>
        </div>
        <!-- Fb comments plugin Section End -->

        <!-- Related Product Section Begin -->
        <section class="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title related__product__title">
                            <h2>Related Product</h2>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <?php

                    try {

                        try {

                            $stmt2 = $conn->prepare("SELECT * FROM category WHERE name = :name");
                            $stmt2->execute(['name' => $product['catname']]);
                            $catagory = $stmt2->fetch();
                        } catch (PDOException $e) {
                            echo "There is some problem in connection: " . $e->getMessage();
                        }

                        $id = $catagory['id'];
                        $stmt3 = $conn->prepare("SELECT * FROM products WHERE category_id = :id ORDER BY id DESC LIMIT 4");
                        $stmt3->execute(['id' => $id]);
                        foreach ($stmt3 as $row) {
                            $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';


                            echo '<div class="col-lg-3 col-md-4 col-sm-6">';
                            echo '    <div class="product__item">';
                            echo '        <div class="product__item__pic set-bg" data-setbg="' . $image . '">';
                            echo '            <ul class="product__item__pic__hover">';
                            echo '                <!-- <li><a href="#"><i class="fa fa-heart"></i></a></li>';
                            echo '                <li><a href="#"><i class="fa fa-retweet"></i></a></li>';
                            echo '                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li> -->';
                            echo '            </ul>';
                            echo '        </div>';
                            echo '        <div class="product__item__text">';
                            echo '			  <h6><a href="product.php?product=' . $row['slug'] . '">' . $row['name'] . '</a></h6>';
                            echo '            <h5>৳ ' . number_format($row['price'], 2) . '</h5>';
                            echo '        </div>';
                            echo '    </div>';
                            echo '</div>';
                        }
                    } catch (PDOException $e) {
                        echo "There is some problem in connection: " . $e->getMessage();
                    }

                    ?>
                </div>
            </div>
        </section>
        <!-- Related Product Section End -->








        <?php $pdo->close(); ?>
        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function() {
            $('#add').click(function(e) {
                e.preventDefault();
                var quantity = $('#quantity').val();
                quantity++;
                $('#quantity').val(quantity);
            });
            $('#minus').click(function(e) {
                e.preventDefault();
                var quantity = $('#quantity').val();
                if (quantity > 1) {
                    quantity--;
                }
                $('#quantity').val(quantity);
            });

        });
    </script>

    <script>

        'use strict';

        (function($) {

            /*-------------------
		Quantity change
    --------------------- */
            
            var proQty = $('.pro-qty');
            proQty.prepend('<span class="dec qtybtn">-</span>');
            proQty.append('<span class="inc qtybtn">+</span>');
            proQty.on('click', '.qtybtn', function () {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    // Don't allow decrementing below zero
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                $button.parent().find('input').val(newVal);
            });
            

        })(jQuery);
    </script>


</body>

</html>