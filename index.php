<?php

include 'config.php';

require 'body.php';

try {
    $conn = new PDO("mysql:host=$domain;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


    $alert = null;

if (isset($_POST['submit'])) {

	if (isset($_POST['product']) && !empty($_POST['product'])) {
		
		if (isset($_POST['price']) && !empty($_POST['price'])) {

			$alert = '<div class="alert alert-warning" role="alert">
		Prekė sekmingai pridėta!</div>';

		$conn->query("INSERT INTO products (product, description, price) VALUES ('".$_POST['product']."','".$_POST['description']."','".$_POST['price']."')");
			

		} else {

			$alert = '<div class="alert alert-warning" role="alert">
			Įveskite prekės kainą!</div>';
		}
	} else {

		$alert = '<div class="alert alert-warning" role="alert">
		Įveskite prekės pavadinimą!</div>';
	}
}



if (isset($_GET['delete']) && !empty($_GET['delete']) ) {
    $query = $conn->prepare("DELETE FROM products WHERE id = :id");
    $query->execute([
        'id' => $_GET['delete']
    ]);
}



$stmt = $conn->query("SELECT id, product, description, price FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);



