<?php
include_once '../loginPage/conn.php';

session_start(); // Start the session

// Check if the user is logged in (userid is stored in the session)
if (!isset($_SESSION['userid'])) {
    // User is not logged in, redirect to the login page
    header('Location: ../loginPage/login.php');
    exit;
}

// Access the userid and username from the session
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

if (isset($_POST['submitBtn']) && $_POST['randcheck'] == $_SESSION['rand']) {
    $message_text = $_POST['message_text'];

    $sql = "INSERT INTO todo (userid, message_text)
    VALUES ('$userid','$message_text');";

    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>";
    }
    
    echo 'running';
    shell_exec('./html.sh');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToDo List</title>
    <link rel="stylesheet" href="../loginPage/style.css">
    <link rel="icon" href="../loginPage/images/websiteIcon.ico">

</head>

<body>

    <nav id="navbar">
        <div id="menu-icon">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <a href="../loginPage/home.php" class="button">Home</a>
        <a href="" class="button">Profile</a>
        <a href="../loginPage/logout.php" class="button" id="logout">Logout</a>
    </nav>

    <div class="container">
        <h1>ToDo List</h1>

        <div class="default">
            <table>
                <?php

                $listFile = fopen("todolist.html", "w") or die("Unable to open file");

                $startString = "
                <!DOCTYPE html>
                <html>
                  <head>
                    <meta name='viewport' content='width=device-width, initial-scale=1' />
                    <title>ToDo List</title>
                    <link rel='stylesheet' href='../loginPage/style.css' />
                    <link rel='icon' href='../loginPage/images/websiteIcon.ico' />
                  </head>
                
                  <body>
                    <div class='container' style='width: 80%'>
                      <h1>ToDo List</h1>
                      <table>
                ";
                fwrite($listFile, $startString . "\n");


                $sql = "SELECT message_text
                FROM todo t
                JOIN users u ON t.userid = u.userid
                WHERE u.userid = '$userid'
                ORDER BY t.message_date ASC;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["message_text"] . "</td></tr>";
                        fwrite($listFile, "<tr><td>" . $row["message_text"] . "</td></tr>" . "\n");
                    }
                }

                $endString = "
                            </table>
                        </div>
                    </body>
                </html>
                ";
                fwrite($listFile, $endString . "\n");

                fclose($listFile);
                ?>
            </table>
        </div>

        <form action="" method="POST" name="todoForm" id="todoForm">

            <?php
            $rand = rand();
            $_SESSION['rand'] = $rand;
            ?>
            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

            <div>
                <input class="textbox" type="text" name="message_text" required>
            </div>
            <input class="button" type="submit" name="submitBtn" value="Add" onclick="executeScript()">

        </form>
    </div>

    <script src="../loginPage/script.js"></script>
    <script>
    function executeScript() {
        // Use AJAX to call a separate PHP file that runs the shell script
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Optional: You can handle the response from the server here
                console.log(this.responseText);
            }
        };
        xhttp.open("GET", "execute_script.php", true);
        xhttp.send();
    }
    </script>

</body>

</html>

<?php
$conn->close();
?>
