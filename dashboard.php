<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: allBlogs.php");
} else {
    include "header.php";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <div>
        <a href="allBlogs.php">🔙 All blogs</a>
    </div>
    <div>
        <a href="createABlog.php">Write a blog</a>
    </div>
    <hr>

    <?php
    $fileName = "blogs.csv";
    if (!file_exists($fileName)) {
        die("The file to save the data doesn't exist!");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["delete"])) {
            $id = $_POST["id"];
            require_once "Blog.php";
            Blog::deleteWithId($id);
        }
        if (isset($_POST["edit"])) {
            $id = $_POST["id"];
            $_SESSION["id"] = $id;
            header("location: editABlog.php");
        }
    }
    ?>

    <?php

    $file = fopen($fileName, 'r+');
    $blogs = [];
    if ($file) {
        while (($line = fgetcsv($file)) != false) {
            if ($line[1] == $_SESSION["author"]) {
                array_push($blogs, $line);
            }
        }
        fclose($file);

        if (count($blogs) == 0) {
            die("You have no blogs!");
        }

        foreach ($blogs as $key) {
            if ($key) {
                echo "<form action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "\" method=\"POST\"><fieldset><div>
                    <h3>$key[0]</h3>
                    <pre>$key[2]</pre>
                    <p>by: $key[1]</p>
                    <input type=\"hidden\" name=\"id\" value= $key[3] >
                    <input type=\"submit\" name=\"delete\" value=delete></input>
                    <input type=\"submit\" name=\"edit\" value=edit></input>
                    </div></fieldset></form>";
            }
        }
    } else {
        die("Can't open the file!");
    }
    ?>

</body>

</html>