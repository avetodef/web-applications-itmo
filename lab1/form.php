<?php

$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "web_lab_1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$comment = $_POST['comment'];
$date_added = date('Y-m-d H:i:s'); 


$sql = "INSERT INTO notes (comment, date_added) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $comment, $date_added);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();

header('Location: ' . '/web-applications/lab1/index.php');
?>
