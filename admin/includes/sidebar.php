<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">REPORST</li>
                <li>
                    <a href="home.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'home.php') echo 'mm-active'; ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="sales.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'sales.php') echo 'mm-active'; ?>">
                        <i class="metismenu-icon pe-7s-cash"></i>
                        Sales
                    </a>
                </li>
                <li class="app-sidebar__heading">MANAGE</li>
                <li>
                    <a href="users.php" class="<?php if (basename($_SERVER['PHP_SELF']) == 'users.php') echo 'mm-active'; ?>">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == 'products.php' || basename($_SERVER['PHP_SELF']) == 'category.php'|| basename($_SERVER['PHP_SELF']) == 'featured.php') echo 'mm-active'; ?>">
                        <i class="metismenu-icon pe-7s-shopbag"></i>
                        Products
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="products.php">
                                Product List
                            </a>
                        </li>
                        <li>
                            <a href="category.php">
                                </i>Category
                            </a>
                        </li>
                        <li>
                            <a href="featured.php">
                                </i>Featured
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>