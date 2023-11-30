<?php
//Execute the shell script

$listFile = fopen("output.txt", "w") or die("Unable to open file");
$output = shell_exec('firefox --headless --screenshot --window-size=800,480 todolist.html');
fwrite($listFile, $output . "\n");
?>
