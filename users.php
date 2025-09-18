<?php
// --- Database Connection ---

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Load database credentials securely from the .env file
$servername = $_ENV['DB_HOST'];
$username   = $_ENV['DB_USER'];
$password   = $_ENV['DB_PASS'];
$port       = $_ENV['DB_PORT'];
$dbname     = $_ENV['DB_NAME'];



//create connection including the port number
$conn = new mysqli($servername, $username, $password, $dbname, $port);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the '" . $dbname . "' database.";
}


// --- Fetch Users ---
// SQL query to get all users, ordered by their ID
$sql = "SELECT id, name, email, reg_date FROM app_users ORDER BY id ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registered Users</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        ol { list-style-type: decimal; } /* This ensures the list is numbered */
    </style>
</head>
<body>

    <h1>List of Registered Users</h1>

    <ol>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<li>Name: " . htmlspecialchars($row["name"]) . " - Email: " . htmlspecialchars($row["email"]) . " - Registered: " . $row["reg_date"] . "</li>";
            }
        } else {
            echo "<li>No users found.</li>";
        }
        $conn->close();
        ?>
    </ol>

</body>
</html>