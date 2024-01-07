<?php
// Connects to database
include_once '../conn.php';

// Read the contents of the file into a string
$fileContents = file_get_contents("todolist.html");

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
        $fileString .= "\n" . "<tr><td>" . $row["message_text"] . "</td></tr>" . "\n";
    }
}

// Writes end of html file
$endString = "
            </table>
        </div>
    </body>
</html>
";
$fileString .= $endString;

if ($fileString != $fileContents) {
    // Opens html file
    echo "Updating HTML";
    $listFile = fopen("todolist.html", "w") or die("Unable to open file");
    fwrite($listFile, $endString);
}



// Closes file and connections
fclose($listFile);
$conn->close();
?>
