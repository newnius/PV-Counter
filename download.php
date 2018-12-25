<?php

$filename = isset($_GET['filepath']) ? $_GET['filepath'] : '404.html';

header('Content-Disposition: attachment; filename="' . $filename . '"');

echo $filename;