#!/bin/bash

CWD=`pwd`
filename=todolist.html

echo "\t-Opening headless browser\n"
firefox --headless --screenshot --window-size=800,480 file://$CWD/$filename > /dev/null 2>&1
echo "\t-Screenshot taken\n"
./displayImage.py screenshot.png > /dev/null 2>&1
echo "\t-Display updated\n"
rm screenshot.png 
