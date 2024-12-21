<?php
session_start();
if (isset($_SESSION["email"])) {
    include "header.php";
    echo "<a href=\"dashboard.php\">Dashboard</a>";
    echo "<hr>";
} else {
    echo "<a href=\"signUp.php\">Sign up</a>";
    echo "<p>  </p>";
    echo "<a href=\"login.php\">Login</a>";
    echo "<hr>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All blogs</title>
</head>

<body>
    <?php
    $fileName = "blogs.csv";
    if (!file_exists($fileName)) {
        die("The file to save the data doesn't exist!");
    }

    $file = fopen($fileName, 'r+');
    $blogs = [];
    if ($file) {
        while (($line = fgetcsv($file)) != false) {
            array_push($blogs, $line);
        }
        fclose($file);

        if (count($blogs) == 0) {
            die("There are no blogs!");
        }

        foreach ($blogs as $key) {
            if ($key) {
                echo "<fieldset><div>
                <h3>$key[0]</h3>
                <pre>$key[2]</pre>
                <p>by: $key[1]</p>
                </div></fieldset>";
            }
        }
    } else {
        die("Can't open the file!");
    }
    ?>

</body>

</html>