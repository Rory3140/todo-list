#!/bin/bash

CWD=`pwd`
filename=./todolist.html

firefox --headless --screenshot --window-size=800,480 file://$CWD/$filename > /dev/null 2>&1

python3 scripts/displayImage.py screenshot.png > /dev/null 2>&1

rm screenshot.png 