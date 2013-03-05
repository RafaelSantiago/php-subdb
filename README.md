php-subdb
=========

PHP Script to search for subtitles in movies SubDB webservice and saves the file to disk

This script reads a directory to search for video files and then search on the webservice SubDB (thesubdb.com) for subtitle files for videos found.
The subtitles that were found will be written in the same folder as the video file with the same name.

This script is free to use, modification and distribution.
Please, if you make any improvements, share.


USAGE
=========
1. Edit the config.inc.php file with your settings
2. Run index.php


FEATURES
=========
- Configuration of allowed extensions
- Configuration of minimum file size
- Send Prowl push notifications (prowlapp.com)
- Choose the language of subtitle files


TO-DO
=========
- Option to ignore subtitles already downloaded
- Option to save the subtitle file in another directory
- Option to move the video file and subtitle to another directory
- Option to run the script from the command line, sending configuration parameters
- Log
- Debug