<?php

$output = "";

if (isset($_SESSION['user'])) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $row) {
            $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
            $stmt->execute(['user_id' => $user['id'], 'product_id' => $row['productid']]);
            $crow = $stmt->fetch();
            if ($crow['numrows'] < 1) {
                $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
                $stmt->execute(['user_id' => $user['id'], 'product_id' => $row['productid'], 'quantity' => $row['quantity']]);
            } else {
                $stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id");
                $stmt->execute(['quantity' => $row['quantity'], 'user_id' => $user['id'], 'product_id' => $row['productid']]);
            }
        }
        unset($_SESSION['cart']);
    }
    try {
        $total = 0;
        $stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user");
        $stmt->execute(['user' => $user['id']]);
        foreach ($stmt as $row) {
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        }
        if ($total > 0) {
            $output .= '<div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Subtotal <span id="t1">&#2547; ' . number_format($total, 2) . '</span></li>
                                <li>Total <span id="t2">&#2547; ' . number_format($total, 2) . '</span></li>
                            </ul>
                            <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>';
        } else {
            $output .= '<!-- Cart Empty(Handeled in cart_details) -->';
        }
    } catch (PDOException $e) {
        $output .= $e->getMessage();
    }
} else {
    if (count($_SESSION['cart']) != 0) {
        $total = 0;
        foreach ($_SESSION['cart'] as $row) {
            $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
            $stmt->execute(['id' => $row['productid']]);
            $product = $stmt->fetch();
            $subtotal = $product['price'] * $row['quantity'];
            $total += $subtotal;
        }

        if (isset($_SESSION['user'])) {
            $button =  '<a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>';
        } else {
            $button =  "<strong>You need to <a href='login.php'>Login</a> to checkout.</strong><br>";
        }

        $output .= '<div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Subtotal <span id="t1">&#2547; ' . number_format($total, 2) . '</span></li>
                                <li>Total <span id="t2">&#2547; ' . number_format($total, 2) . '</span></li>
                            </ul>
                            '.$button.'
                        </div>
                    </div>';
    } else {
        $output .= '<!-- Cart Empty(Handeled in cart_details) -->';
    }
}

echo $output;
