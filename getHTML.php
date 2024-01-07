<?php
// Connects to database
include_once '../conn.php';

function update($conn) {
    // Read the contents of the file into a string
    $fileContents = file_get_contents("todolist.html");

    // Adds start of HTML file
    $fileString = "
    <!DOCTYPE html>
    <html>
        <head>
        <meta name='viewport' content='width=device-width, initial-scale=1' />
        <title>ToDo List</title>
        <link rel='stylesheet' href='../style.css' />
        </head>

        <body>
            <div class='container' style='width: 80%'>
                <h1>ToDo List</h1>
                <table>
    ";

    // Adds messages to table
    $sql = "SELECT message_text
    FROM todo t
    ORDER BY t.message_date ASC;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rowString = "\n" . "<tr><td>" . $row["message_text"] . "</td></tr>" . "\n";
            $fileString .= $rowString;
        }
    }

    // Adds end of HTML file
    $endString = "
                </table>
            </div>
        </body>
    </html>
    ";
    $fileString .= $endString;

    // Checks for database update
    if ($fileString != $fileContents) {
        // Opens html file
        $listFile = fopen("todolist.html", "w") or die("Unable to open file");
        // Writes to file
        fwrite($listFile, $fileString);
        fclose($listFile);

        // Executes script to update display
        echo "\n--Updating Display--\n";
        $output = shell_exec("bash updateDisplay.sh > /dev/null 2>&1");
        echo "\n--Display Successfully Updated--\n";
    }
}

// Updates consistantly
while (true) {
    update($conn);
    sleep(5);
}

// Closes connections
$conn->close();
?>
