<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location: allBlogs.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <?php
    $email = $password = "";
    $emailReq = $passwordReq =  "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once "inputsValidation.php";
        $email = validateInput($_POST["email"]);
        $password = validateInput($_POST["password"]);

        require_once "User.php";
        if (User::isExistEmailPass($email, $password)) {
            header("location: allBlogs.php");
        } else {
            echo "Wrong email or password!";
        }
    }
    ?>

    <div>
        <a href="allBlogs.php">🔙 All blogs</a>
    </div>
    <div>
        <a href="signUp.php">Sign up</a>
    </div>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <fieldset>
                <legend>Login</legend>
                <div>
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" value="<?php echo "$email"; ?>">
                    <span style="color: red;">*</span>
                </div>
                <div>
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" minlength="8" placeholder="at least 8 characters">
                    <span style="color: red;">*</span>
                </div>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>