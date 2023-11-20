#!/bin/bash

CWD=`pwd`
filename=todolist.php

firefox --headless --screenshot --window-size=600,448 file://$CWD/$filename
./displayImage.py screenshot.png
