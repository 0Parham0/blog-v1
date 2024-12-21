<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location: allBlogs.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign in</title>
    <meta charset="UTF-8">
</head>

<body>

    <?php
    $fName = $lName = $author = $email = $password = $conPassword = "";
    $fNameReq = $lNameReq = $authorReq = $emailReq = $passwordReq = $conPasswordReq = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once "inputsValidation.php";

        $fName = validateInput($_POST["fName"]);
        $lName = validateInput($_POST["lName"]);
        $author = validateInput($_POST["author"]);
        $email = validateInput($_POST["email"]);

        $wrongFormat = false;

        if (!preg_match("/^[a-zA-Z\s]+$/", $fName)) {
            $fNameReq = "first name is not in the right format";
            $wrongFormat = true;
        }
        if (!preg_match("/^[a-zA-Z\s]+$/", $lName)) {
            $lNameReq = "last name is not in the right format";
            $wrongFormat = true;
        }
        if (!preg_match('/^[a-zA-Z0-9\s_!?]+$/', $author)) {
            $authorReq = "author is not in the right format";
            $wrongFormat = true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailReq = "email is not in the right format";
            $wrongFormat = true;
        }
        if (($_POST["password"] != $_POST["conPassword"]) || strlen($_POST["password"]) < 8) {
            $passwordReq = $conPasswordReq = "password and confirm password are not the same or not in the right format";
            $wrongFormat = true;
        } else {
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }

        require_once "User.php";
        if (User::isExistAuthor($author)) {
            $authorReq = "The name as author already exists in the system.";
            $wrongFormat = true;
        }
        if (User::isExistEmail($email)) {
            echo "You have already signed up.";
            $wrongFormat = true;
        }

        if ($wrongFormat == false) {
            require_once "User.php";
            $user = new User($fName, $lName, $author, $email, $password);
            $user->register();
            unset($user);

            $fName = $lName = $author = $email = $password = $conPassword = "";

            header("location: login.php");
        }
    }



    ?>
    <div>
        <a href="allBlogs.php">🔙 All blogs</a>
    </div>
    <div>
        <a href="login.php">Login</a>
    </div>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <fieldset>
                <legend>Sign Up</legend>
                <div>
                    <label for="fName">First Name: </label>
                    <input type="text" id="fName" name="fName" value="<?php echo "$fName"; ?>">
                    <span style="color: red;"><?php echo "* $fNameReq"; ?></span>
                </div>
                <div>
                    <label for="lName">Last Name: </label>
                    <input type="text" id="lName" name="lName" value="<?php echo "$lName"; ?>">
                    <span style="color: red;"><?php echo "* $lNameReq"; ?></span>
                </div>
                <div>
                    <label for="author">Name As Author: </label>
                    <input type="text" id="author" name="author" value="<?php echo "$author"; ?>">
                    <span style="color: red;"><?php echo "* $authorReq"; ?></span>
                </div>
                <div>
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" value="<?php echo "$email"; ?>">
                    <span style="color: red;"><?php echo "* $emailReq"; ?></span>
                </div>
                <div>
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" minlength="8" placeholder="at least 8 characters">
                    <span style="color: red;"><?php echo "* $passwordReq"; ?></span>
                </div>
                <div>
                    <label for="conPassword">Confirm Password: </label>
                    <input type="password" name="conPassword" id="conPassword" minlength="8" placeholder="at least 8 characters">
                    <span style="color: red;"><?php echo "* $conPasswordReq"; ?></span>
                </div>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>