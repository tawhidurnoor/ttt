<?php
include 'includes/session.php';
$conn = $pdo->open();

$output = '';

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
		$stmt = $conn->prepare("SELECT *, cart.id AS cartid, products.name AS prodname, products.id AS productid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user");
		$stmt->execute(['user' => $user['id']]);
		foreach ($stmt as $row) {
			$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
			$subtotal = $row['price'] * $row['quantity'];
			$total += $subtotal;
			
			$output .= '<tr>
							<td class="shoping__cart__item">
								<img class="img-responsive" width="100px" src="' . $image . '" alt="">
								<h5><a href="product.php?product=' . $row['slug'] . '">' . $row['prodname'] . '</a></h5>
							</td>
							<td class="shoping__cart__price">
								&#2547; ' . number_format($row['price'], 2) . '
							</td>
							<td class="shoping__cart__quantity">
								<div class="quantity">
									<div class="pro-qty">
										<span class="dec qtybtn" data-id="'.$row['productid'].'">-</span>
										<input type="text" value="' . $row['quantity'] . '" id="qty_' . $row['cartid'] . '" readonly>
										<span class="inc qtybtn" data-id="'.$row['productid'].'">+</span>
									</div>									
								</div>
							</td>
							<td class="shoping__cart__total">
							&#2547; ' . number_format($subtotal, 2) . '
							</td>
							<td class="shoping__cart__item__close">
								<span class="icon_close cart_delete" data-id="' . $row['cartid'] . '"></span>
							</td>
						</tr>';
		}

		if($total <= 0){
			$output .= "
				<tr>
					<td colspan='6' align='center'>Shopping cart empty</td>
				<tr>
			";
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
			$image = (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg';
			$subtotal = $product['price'] * $row['quantity'];
			$total += $subtotal;
			$output .= '<tr>
							<td class="shoping__cart__item">
								<img class="img-responsive" width="100px" src="' . $image . '" alt="">
								<h5><a href="product.php?product=' . $product['slug'] . '">' . $product['prodname'] . '</a></h5>
							</td>
							<td class="shoping__cart__price">
								&#2547; ' . number_format($product['price'], 2) . '
							</td>
							<td class="shoping__cart__quantity">
								<div class="quantity">
									<div class="pro-qty">
										<input type="text" value="' . $row['quantity'] . '" id="qty_' . $row['productid'] . '" readonly>
									</div>
								</div>
							</td>
							<td class="shoping__cart__total">
							&#2547; ' . number_format($subtotal, 2) . '
							</td>
							<td class="shoping__cart__item__close">
								<span class="icon_close cart_delete" data-id="' . $row['productid'] . '"></span>
							</td>
						</tr>';
		}

	} else {
		$output .= "
				<tr>
					<td colspan='6' align='center'>Shopping cart empty</td>
				<tr>
			";
	}
}

$pdo->close();
echo json_encode($output);
