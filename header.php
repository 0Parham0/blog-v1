<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("location: allBlogs.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <span><?php echo "Hello " . $_SESSION["fName"] . " " . $_SESSION["lName"] . "." ?></span>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <input type="submit" value="logout" name="logout">
    </form>
</body>

</html>