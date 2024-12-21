<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: signUp.php");
} else {
    include "header.php";
}

$fileName = "blogs.csv";
if (!file_exists($fileName)) {
    die("The file to save the data doesn't exist!");
}

$file = fopen($fileName, 'r+');
$blog = [];
if ($file) {
    while (($line = fgetcsv($file)) != false) {
        if ($line[3] == $_SESSION["id"]) {
            array_push($blog, $line);
            break;
        }
    }
    fclose($file);

    $title = $line[0];
    $author = $line[1];
    $description = $line[2];
    $titleReq = $authorReq = $descriptionReq = "";
} else {
    die("Can't open the file!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "Blog.php";
    Blog::deleteWithId($_SESSION["id"]);


    require_once "inputsValidation.php";

    $title = validateInput($_POST["title"]);
    $author = validateInput($_POST["author"]);
    $description = validateInput($_POST["description"]);

    $wrongFormat = false;

    if (!preg_match('/^[a-zA-Z0-9\s\-_,\.!?]+$/', $title)) {
        $titleReq = "title is not in the right format";
        $wrongFormat = true;
    }
    if ($author != $_SESSION["author"]) {
        $authorReq = "you can't change name as author";
        $wrongFormat = true;
    }
    if (!preg_match('/^[a-zA-Z0-9\s\-_,\.!?]+$/', $description)) {
        $descriptionReq = "description is not in the right format";
        $wrongFormat = true;
    }

    if ($wrongFormat == false) {
        require_once "Blog.php";
        $blog = new Blog($title, $author, $description);
        $blog->submit();
        unset($blog);

        $title = $author = $description = "";

        header("location: allBlogs.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit a blog</title>
</head>

<body>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <fieldset>
                <legend>Edit Blog</legend>
                <div>
                    <label for="title">Title: </label>
                    <input type="text" id="title" name="title" value="<?php echo "$title"; ?>">
                    <span style="color: red;"><?php echo "* $titleReq"; ?></span>
                </div>
                <div>
                    <label for="author">Author: </label>
                    <input type="text" id="author" name="author" value="<?php echo "$author"; ?>" readonly>
                    <span style="color: red;"><?php echo "* $authorReq"; ?></span>
                </div>
                <div>
                    <label for="description">Description: </label>
                    <textarea cols="25" rows="5" id="description" name="description"><?php echo "$description"; ?></textarea>
                    <span style="color: red;"><?php echo "* $descriptionReq"; ?></span>
                </div>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>