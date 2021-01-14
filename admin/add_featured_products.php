<?php
	include 'includes/session.php';

	if(isset($_POST['id'])){

        $conn = $pdo->open();

        $product_id = $_POST['id'];

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM featured_products WHERE product_id=:product_id");
		$stmt->execute(['product_id'=> $product_id]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Product already in Featured Product';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO featured_products (product_id) VALUES (:product_id)");
				$stmt->execute(['product_id'=> $product_id]);
				$_SESSION['success'] = 'Product added to Featured Product';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up product form first';
	}

	header('location: featured.php');
