<?php
$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "web_lab_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$entityBody = json_decode(file_get_contents('php://input'), true);;

$product_id = $entityBody['product_id'];

$price_sql = "SELECT sale_price FROM product WHERE product_id = ?";
$price_st = $conn->prepare($price_sql);
$price_st->bind_param("i", $product_id);

$price_st->execute();
$price_result = $price_st->get_result();
$price_row = $price_result->fetch_assoc();
$price = $price_row['sale_price'];

$name_sql = "SELECT title FROM product WHERE product_id = ?";
$name_st = $conn->prepare($name_sql);
$name_st->bind_param("i", $product_id);

$name_st->execute();
$name_result = $name_st->get_result();
$name_row = $name_result->fetch_assoc();
$name = $name_row['title'];


$sql = "INSERT INTO cart (product_id, name, price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $product_id, $name, $price);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->commit();

$stmt->close();
$conn->close();
?>
