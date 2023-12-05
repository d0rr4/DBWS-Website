<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Details</title>
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

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['type']) && isset($_GET['id'])) {
                    $type = $_GET['type'];
                    $id = $_GET['id'];
                
                    switch ($type) {
                        case 'fitness_goal':
                            $sql = "SELECT * FROM FitnessGoals WHERE Fid = $id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo "<h2>Fitness Goal Details</h2>";
                                echo "<p>Goal: " . $row['Goals'] . "</p>";
                                echo "<p>Description: " . $row['Description'] . "</p>";
                            } else {
                                echo "No details found for this fitness goal ID.";
                            }
                            break;

                        case 'workout':
                            $sql = "SELECT Workouts.Wid, Workouts.Name AS WorkoutName, WDuration.Minutes AS WorkoutDuration, WCategory.Name AS WorkoutCategory
                                    FROM Workouts
                                    INNER JOIN WDuration ON Workouts.DurID = WDuration.DurID
                                    INNER JOIN WCategory ON Workouts.CatID = WCategory.CatID
                                    WHERE Workouts.Wid = $id";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo "<h1>" . $row['WorkoutName'] . "</h1>";
                                echo "<p>Duration: " . $row['WorkoutDuration'] . " minutes</p>";
                                echo "<p>Category: " . $row['WorkoutCategory'] . "</p>";
                            } else {
                                echo "No details found for this workout ID.";
                            }
                            break;

                        case 'meal':
                            $sql = "SELECT Meals.Mid, Meals.DishName, Calories, DTypeName 
                                    FROM Meals 
                                    INNER JOIN DType ON Meals.TID = DType.TID 
                                    WHERE Mid = $id";
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($row = $result->fetch_assoc()) {
                                    echo "<h2>Meal Details</h2>";
                                    echo "<p>Dish Name: " . $row['DishName'] . "</p>";
                                    echo "<p>Calories: " . $row['Calories'] . "</p>";
                                    echo "<p>Type: " . $row['DTypeName'] . "</p>";
                                } else {
                                    echo "No details found for this meal ID.";
                                }
                                $stmt->close();
                            }
                            break;
                
                        case 'workout_duration':
                            $sql = "SELECT * FROM WorkoutDurations WHERE DurID = $id";
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($row = $result->fetch_assoc()) {
                                    echo "<h2>Workout Duration Details</h2>";
                                    echo "<p>Duration Name: " . $row['DurationName'] . "</p>";
                                } else {
                                    echo "No details found for this workout duration ID.";
                                }
                                $stmt->close();
                            }
                            break;

                        default:
                            echo "Invalid type specified.";
                            break;
                    }
                } else {
                    echo "Invalid request.";
                }
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>