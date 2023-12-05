<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {

    $fitness_goals = $_POST["fitness_goals"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $dietary_preference = $_POST["dietary_preference"];
    $food_allergies = $_POST["food_allergies"];
    $age = $_POST["age"];

    
} else {
    echo "Access Denied";
}
?>