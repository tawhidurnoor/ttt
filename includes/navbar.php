<!-- Page Preloder 
<div id="preloder">
  <div class="loader"></div>
</div>
-->

<!-- Humberger Begin (Mobile view) -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="./"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="#"><i class="fa fa-heart"></i> <span>0</span></a></li>
            <li><a href="cart_view.php"><i class="fa fa-shopping-bag"></i><span class="cart_count"></span></a></li>
        </ul>
    </div>
    <div class="humberger__menu__widget">
        <!--
            <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            -->
        <div class="header__top__right__auth">
            <?php
            if (isset($_SESSION['user'])) {
                echo '<a href="profile.php">' . $user['firstname'] . ' ' . $user['lastname'] . '\'s account</a>
              <a href="logout.php">Logout</a>';
            } else {
                echo "
                <a href='login.php'><i class='fa fa-user'></i> Login</a>
              ";
            }
            ?>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="./">Home</a></li>
            <li><a href="category.php">Shop</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> tentothousand@gmail.com</li>
            <li>Free Shipping for all Order of 2000 taka</li>
        </ul>
    </div>
</div>
<!-- Humberger End (Mobile view) -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> tentothousand@gmail.com</li>
                            <li>Free Shipping for all Order of 2000 taka</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <!--
                            <div class="header__top__right__language">
                                <img src="img/language.png" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">Spanis</a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div>
                            -->
                        <div class="header__top__right__auth">
                            <?php
                            if (isset($_SESSION['user'])) {
                                echo '<a href="profile.php">' . $user['firstname'] . ' ' . $user['lastname'] . '\'s account</a>
                      <a href="logout.php">Logout</a>';
                            } else {
                                echo "
                <a href='login.php'><i class='fa fa-user'></i> Login</a>
              ";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="./"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <center>
                        <ul>
                            <li class="active"><a href="./">Home</a></li>
                            <li><a href="category.php">Shop</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </center>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="#"><i class="fa fa-heart"></i> <span>0</span></a></li>
                        <li><a href="cart_view.php"><i class="fa fa-shopping-bag"></i><span class="cart_count"></span></a></li>
                    </ul>
                    <!--
          <div class="header__cart__price">item: <span>$150.00</span></div>
-->
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        <?php

                        $conn = $pdo->open();
                        try {
                            $stmt = $conn->prepare("SELECT * FROM category");
                            $stmt->execute();
                            foreach ($stmt as $row) {
                                echo "
                                  <li><a href='category.php?category=" . $row['cat_slug'] . "'>" . $row['name'] . "</a></li>
                                ";
                            }
                        } catch (PDOException $e) {
                            echo "There is some problem in connection: " . $e->getMessage();
                        }

                        $pdo->close();

                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form method="POST" action="search.php">
                            <!--
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            -->
                            <input type="text" id="navbar-search-input" name="keyword" placeholder="What do yo u need?" required>
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>



                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha256-fzFFyH01cBVPYzl16KT40wqjhgPtq6FFUB6ckN2+GGw=" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js" integrity="sha256-4sETKhh3aSyi6NRiA+qunPaTawqSMDQca/xLWu27Hg4=" crossorigin="anonymous"></script>
                <script src="slider/js/script.js"></script>

                <!-- =====Old Slider Below===== -->
                <!--
        <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
          <div class="hero__text">
            <span>STYLE</span>
            <h2>SOOTHINGLY <br />SUBDUDE</h2>
            <p>Make a statement in trendy styles!</p>
            <a href="#" class="primary-btn">SHOP NOW</a>
          </div>
        </div>
          -->
            </div>
        </div>
    </div>
</section>

<!-- Hero Section End -->