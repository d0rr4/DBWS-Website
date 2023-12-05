<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {

    $workout_name = $_POST["workout_name"];
    $description = $_POST["description"];
    $difficulty = $_POST["difficulty"];
    $category = $_POST["category"];
    $duration = $_POST["duration"];


} else {
    echo "Access Denied";
}
?>