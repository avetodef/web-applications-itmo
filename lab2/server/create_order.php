<?php

$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "web_lab_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$payment = $_POST['payment'];

$sql = "INSERT INTO user (address, email, name, payment) VALUES (?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $address, $email, $name, $payment);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "SELECT user_id FROM user WHERE address = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $address);
$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (!empty($data)) {
    $user_id = $data[0]['user_id'];
} else {
    echo "User with address $address not found.";
}

$created = date('Y-m-d H:i:s'); 
$status = 1;

$sql = "INSERT INTO orders (address, created, email, status, user_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $address,$created , $email, $status,  $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "SELECT order_id FROM orders WHERE address = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $address);
$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Проверяем, найден ли заказ с указанным адресом
if (!empty($data)) {
    // Если найден, получаем order_id
    $order_id = $data[0]['order_id'];
} else {
    // Если не найден, обработка ошибки или другие действия
    echo "Order with address $address not found.";
}


$sql = "SELECT product_id FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$products = array();

while ($row = $result->fetch_assoc()) {
    $products[] = $row['product_id'];
}

foreach ($products as $product_id) {
    $quantity = 1; 

    $sql = "INSERT INTO order_detail (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $order_id, $product_id, $quantity);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "DELETE FROM cart WHERE 0";
$stmt = $conn->prepare($sql);
$stmt->execute();


$conn->commit();

$stmt->close();
$conn->close();