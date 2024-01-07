#!/bin/bash

CWD=`pwd`
filename=todolist.html

firefox --headless --screenshot --window-size=800,480 file://$CWD/$filename
./displayImage.py screenshot.png
rm screenshot.png 
