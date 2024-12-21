<?php
function writer($fileName, $dataArr)
{
    if (!file_exists($fileName)) {
        die("The file to save the data doesn't exist!");
    }

    $file = fopen($fileName, 'a');
    if ($file) {
        fputcsv($file, $dataArr);
        fclose($file);
    } else {
        die("Can't open the file!");
    }
}
