<?php

$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "web_lab_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$json_data = json_encode($data);
echo ($json_data);

$stmt->close();
$conn->close();
?>
