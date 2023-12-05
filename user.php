<?php

$server = "localhost";
$username = "djovanoska";
$mysql_password = "2OY2RP";
$database = "Group-13";

$conn = mysqli_connect($server, $username, $mysql_password, $database);

if (!$conn) {
    die("MySQL Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "SELECT Uid FROM User ORDER BY Uid DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $uid = $row['Uid'];

        if ($uid !== null) {
            $uid++;
        } else {
            $uid = 1;
        }
    }

    $Username = $_POST["Username"];
    $Password = $_POST["Password"];
    $Name = $_POST["Name"];
    $LName = $_POST["LName"];
    $Email = $_POST["Email"];
    $Height = $_POST["Height"];
    $Weight = $_POST["Weight"];

    $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO User (Uid, Name, Height, Weight, LName, Email, Username, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "isssssss", $uid, $Name, $Height, $Weight, $LName, $Email, $Username, $hashedPassword);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>You are registered successfully.</div>";
        header("Location: signin.html");
        exit();
    } else {
        die("Something went wrong");
    }
}
mysqli_close($conn);

?>