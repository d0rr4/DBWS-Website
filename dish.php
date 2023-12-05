<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {

    $dish_name = $_POST["dish_name"];
    $calories = $_POST["calories"];
    $dish_type = $_POST["dish_type"];

    
} else {
    echo "Access Denied";
}
?>