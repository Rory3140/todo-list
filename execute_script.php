<?php
//Execute the shell script

$listFile = fopen("output.txt", "w") or die("Unable to open file");
$output = shell_exec('sudo ./html.sh');
fwrite($listFile, $output . "\n");
?>
