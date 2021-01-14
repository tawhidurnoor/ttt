<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt_1 = $conn->prepare("SELECT * FROM products WHERE id=:id");
			$stmt_1->execute(['id' => $id]);
			foreach($stmt_1 as $image){
				if(unlink("../images/".$image['photo'])){

					try{
					$stmt = $conn->prepare("DELETE FROM products WHERE id=:id");
					$stmt->execute(['id' => $id]);

					$_SESSION['success'] = 'Product deleted successfully!';

					}
					catch (PDOException $e) {
					$_SESSION['error'] = $e->getMessage();
					}

				}
			}

		}

		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select product to delete first';
	}

	header('location: products.php');
