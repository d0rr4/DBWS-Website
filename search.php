<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['search'];

    $server = "localhost";
    $username = "djovanoska";
    $mysql_password = "2OY2RP";
    $database = "Group-13";

    $conn = new mysqli($server, $username, $mysql_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query1 = "SELECT Mid, DishName FROM Meals ORDER BY Calories DESC LIMIT 1";

    $query2 = "SELECT Mid, DishName FROM Meals ORDER BY Calories ASC LIMIT 1";

    $query3 = "SELECT Meals.Mid, Meals.DishName FROM Meals INNER JOIN DType ON Meals.TID = DType.TID WHERE DType.DTypeName = '$searchTerm'";

    $query4 = "SELECT Workouts.Wid, Workouts.Name
               FROM Workouts
               INNER JOIN WCategory ON Workouts.CatID = WCategory.CatID
               WHERE WCategory.Name = '$searchTerm'";

    $query5 = "SELECT Workouts.Wid, Workouts.Name, FitnessGoals.Goals AS Goal
               FROM Workouts
               INNER JOIN FitnessGoals ON Workouts.GoalID = FitnessGoals.Fid
               WHERE FitnessGoals.Goals = '$searchTerm'";


    $result = null;

    if ($searchTerm == 'most calories') {
        $result = $conn->query($query1);
        if ($result->num_rows > 0) {
            echo "<h2>Most Caloric Dish:</h2>";
            while ($row = $result->fetch_assoc()) {
                // echo "<p>" . $row['DishName'] . "</p>";
                echo "<p><a href='details.php?id=" . $row['Mid'] . "&type=dish'>" . $row['DishName'] . "</a></p>";
            }
        } else {
            echo "<h2>No most caloric dish found.</h2>";
        }

    } elseif ($searchTerm == 'least calories') {
        $result = $conn->query($query2);
        if ($result->num_rows > 0) {
            echo "<h2>Least Caloric Dish:</h2>";
            while ($row = $result->fetch_assoc()) {
                // echo "<p>" . $row['DishName'] . "</p>";
                echo "<p><a href='details.php?id=" . $row['Mid'] . "&type=dish'>" . $row['DishName'] . "</a></p>";
            }
        } else {
            echo "<h2>No least caloric dish found.</h2>";
        }

    } elseif ($searchTerm == 'Salads' || $searchTerm == 'Vegetarian' || $searchTerm == 'Vegan' || 
                $searchTerm == 'Gluten-Free' || $searchTerm == 'Dairy-Free' || $searchTerm == 'Low-Calorie' ||
                $searchTerm == 'High-Protein' || $searchTerm == 'Low-Carb' || $searchTerm == 'Mediterranean') {
        $result = $conn->query($query3);
        if ($result->num_rows > 0) {
            echo "<h2>Meals by desired type:</h2>";
            while ($row = $result->fetch_assoc()) {
                // echo "<p>" . $row['DishName'] . "</p>";
                echo "<p><a href='details.php?id=" . $row['Mid'] . "&type=dish'>" . $row['DishName'] . "</a></p>";
            }
        } else {
            echo "<h2>No dish found.</h2>";
        }

    } elseif ($searchTerm == 'HIIT' || $searchTerm == 'Cardio' || $searchTerm == 'Yoga' ||
                $searchTerm == 'Strength Training' || $searchTerm == 'CrossFit') {
        $result = $conn->query($query4);
        if ($result->num_rows > 0) {
            echo "<h2>$searchTerm Workouts:</h2>";
            while ($row = $result->fetch_assoc()) {
                // echo "<p>" . $row['Name'] . "</p>";
                echo "<p><a href='details.php?id=" . $row['Wid'] . "&type=workout'>" . $row['Name'] . "</a></p>";
            }
        } else {
            echo "<h2>No results for $searchTerm</h2>";
        }

    } elseif ($searchTerm == 'Lose Weight' || $searchTerm == 'Build Muscle' || $searchTerm == 'Improve Endurance' ||
                $searchTerm == 'Flexibility Mastery' || $searchTerm == 'Maintain Overall Health') {
        $result = $conn->query($query5);
        if ($result->num_rows > 0) {
            echo "<h2>Workouts to $searchTerm:</h2>";
            while ($row = $result->fetch_assoc()) {
                // echo "<p>" . $row['Name'] . "</p>";
                echo "<p><a href='details.php?id=" . $row['Wid'] . "&type=workout'>" . $row['Name'] . "</a></p>";
            }
        } else {
            echo "<h2>No results for $searchTerm</h2>";
        }
    
    } else {
        die("Invalid search term");
    }

    $conn->close();
}
?>