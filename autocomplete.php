<?php
session_start();

$server = "localhost";
$username = "djovanoska";
$mysql_password = "2OY2RP";
$database = "Group-13";

$conn = new mysqli($server, $username, $mysql_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['term']) && isset($_GET['searchBox'])) {
    $searchTerm = $_GET['term'];
    $searchBox = $_GET['searchBox'];
    $matches = [];

    switch ($searchBox) {
        case 1:
            $sql = "SELECT Goals FROM FitnessGoals WHERE Goals LIKE '%$searchTerm%'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $matches[] = $row['Goals'];
            }
            break;

        case 2:
            $sql = "SELECT Minutes FROM WDuration WHERE Minutes LIKE '%$searchTerm%'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $matches[] = $row['Minutes'];
            }
            break;

        case 3:
            $sql = "SELECT DTypeName FROM DType WHERE DTypeName LIKE '%$searchTerm%'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $matches[] = $row['DTypeName'];
            }
            break;

        case 4:
            $sql = "SELECT Name FROM WCategory WHERE Name LIKE '%$searchTerm%'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $matches[] = $row['Name'];
            }
            break;

        default:
            break;
    }

    echo json_encode($matches);
}
?>