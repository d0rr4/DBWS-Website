<?php

$server = "localhost";
$username = "djovanoska";
$mysql_password = "2OY2RP";
$database = "Group-13";

$mysqli = new mysqli($server, $username, $mysql_password, $database);

if ($mysqli->connect_error) {
    die("MySQL Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT Password FROM User WHERE Username = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        echo "Preparation Error: " . $mysqli->error;
    } else {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            $hashedPasswordFromDB = $user['Password'];

            if (password_verify($password, $hashedPasswordFromDB)) {
                echo "Sign-In Successful!";
                header("Location: user2.html");
                exit();
            } else {
                echo "Sign-In Error: Invalid password.";
            }
        } else {
            echo "Sign-In Error: Username not found.";
        }
    }
}

$mysqli->close();

?>