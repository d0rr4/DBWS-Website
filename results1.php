<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Results</title>
</head>

<body class="body-u2">
    <nav class="sidebar">
        <ul class="sidebar-nav">
            <a href="#" class="nav-link">
                <li class="nav-item">
                    <span class="link-text">HOME</span>
                </li>
            </a>

            <a href="#About" class="nav-link">
                <li class="nav-item">
                    <span class="link-text">ABOUT US</span>
                </li>
            </a>

            <a href="#Our\Services" class="nav-link">
                <li class="nav-item">
                    <span class="link-text">OUR SERVICES</span>
                </li>
            </a>
        </ul>
    </nav>
    <header>
        <nav class="navBar">
            <a href="index.html"><img src="images/Logo.png" class="logo"></a>
                <form action="search.php" method="post" class="searchbar">
                    <input type="text" placeholder="Search..." name="q">
                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="#fff" class="w-6 h-6">`
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
            </form>
            <a href="imprint.html" class="navLink">IMPRINT</a>
            <a href="contact.html" class="navLink">CONTACT US</a>
            <a href="signin.html" class="navLink">LOG IN</a>
        </nav>
    </header>
    <div class="sucontain2">
        <?php

        $server = "localhost";
        $username = "djovanoska";
        $mysql_password = "2OY2RP";
        $database = "Group-13";

        $conn = mysqli_connect($server, $username, $mysql_password, $database);

        if (!$conn) {
            die("MySQL Connection failed: " . mysqli_connect_error());
        }

        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['searchBox1']) && isset($_POST['searchBox3']) && isset($_POST['searchBox4'])) {
                $searchTerm1 = $_POST['searchBox1'];
                $searchTerm2 = $_POST['searchBox2'];
                $searchTerm3 = $_POST['searchBox3'];
                $searchTerm4 = $_POST['searchBox4'];

                $sqlFitnessGoals = "SELECT * FROM FitnessGoals WHERE Goals LIKE '%$searchTerm1%'";
                $resultFitnessGoals = $conn->query($sqlFitnessGoals);

                $sqlFitness = "SELECT * FROM WDuration WHERE DurID LIKE '%$searchTerm2'";
                $resultFitness = $conn->query($sqlFitness);

                $sqlMeals = "SELECT * FROM Meals WHERE TID LIKE '%$searchTerm3%'";
                $resultMeals = $conn->query($sqlMeals);

                $sqlWorkouts = "SELECT Name FROM WCategory WHERE Name LIKE '%$searchTerm4%'";
                $resultWorkouts = $conn->query($sqlWorkouts);

                if ($resultFitnessGoals->num_rows > 0) {
                    while ($row = $resultFitnessGoals->fetch_assoc()) {
                        echo "<h2>Fitness Goal</h2>";
                        echo "<p><a href='details.php?type=fitness_goal&id=" . $row['Fid'] . "'>" . $row['Goals'] . "</a></p>";
                    }
                } else {
                    echo "<p>No fitness goal found!</p>";
                }

                if ($resultFitness->num_rows > 0) {
                    echo "<h2>Workout Duration</h2>";
                    while ($row = $resultFitness->fetch_assoc()) {
                        echo "<p><a href='details.php?type=workout_duration&id=" . $row['DurID'] . "'>" . $row['Name'] . "</a></p>";
                    }
                }

                if ($resultMeals->num_rows > 0) {
                    echo "<h2>Meals</h2>";
                    while ($row = $resultMeals->fetch_assoc()) {
                        echo "<p><a href='details.php?type=meal&id=" . $row['Mid'] . "'>" . $row['DishName'] . "</a></p>";
                    }
                } else {
                    echo "<p>No meals found for this dietary preference!</p>";
                }

                if ($resultWorkouts->num_rows > 0) {
                    echo "<h2>Workouts</h2>";
                    while ($row = $resultWorkouts->fetch_assoc()) {
                        echo "<p><a href='details.php?type=workout&id=" . $row['Wid'] . "'>" . $row['Name'] . "</a></p>";
                    }
                } else {
                    echo "</p>No workouts found for this category and goal!</p>";
                }

            } else {
                echo "Please fill out all the fields.";
            }
        }

        mysqli_close($conn);

        ?>
    </div>
</body>
</html>