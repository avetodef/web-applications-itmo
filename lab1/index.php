<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Comment</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
      }

      .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      h2 {
        color: #333;
        text-align: center;
      }

      form {
        margin-top: 20px;
      }

      textarea {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        resize: vertical;
      }

      input[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
      }

      input[type="submit"]:hover {
        background-color: #45a049;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Add a Comment</h2>
      <form action="form.php" method="POST">
        <textarea
          name="comment"
          rows="4"
          placeholder="Enter your comment here"
        ></textarea
        ><br />
        <input type="submit" value="Submit" />
      </form>
    </div>
    <h2>Comments</h2>
    <div class="comments">
      <?php
$servername = "localhost";
$username = 'root';
$password = '';
$dbname = "web_lab_1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM notes ORDER BY date_added DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display each comment
    while($row = $result->fetch_assoc()) {
      ?>
      <p><?= $row["comment"] . " - " . $row["date_added"] ?></p>
      <?php
    }
} else {
    echo "No comments yet.";
}

$conn->close();
?>

    </div>
  </div>
  </body>
</html>
