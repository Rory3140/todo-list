<?php
// Execute the shell script

$listFile = fopen("test.txt", "w") or die("Unable to open file");
$output = shell_exec('./html.sh');
echo $output;
?>
