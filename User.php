
<?php
class User
{
    public $fName;
    public $lName;
    public $author;
    public $email;
    public $password;

    public function __construct($fName, $lName, $author, $email, $password)
    {
        $this->fName = $fName;
        $this->lName = $lName;
        $this->author = $author;
        $this->email = $email;
        $this->password = $password;
    }
    public function register()
    {
        $dataArr = array($this->fName, $this->lName, $this->author, $this->email, $this->password);

        include_once "writeToAFile.php";
        writer("users.csv", $dataArr);
    }
    public static function isExistEmailPass($email, $password)
    {
        $exist = false;
        $fileName = "users.csv";
        if (!file_exists($fileName)) {
            die("The file to save the data doesn't exist!");
        }

        $file = fopen($fileName, 'r+');
        if ($file) {
            while (($userInfo = fgetcsv($file)) !== false) {
                $userEmail = $userInfo[3];
                $userPassword = $userInfo[4];

                if ($email == $userEmail && password_verify($password, $userPassword)) {
                    $_SESSION["email"] = $userEmail;
                    $_SESSION["fName"] = $userInfo[0];
                    $_SESSION["lName"] = $userInfo[1];
                    $_SESSION["author"] = $userInfo[2];
                    $exist = true;
                }
            }
            fclose($file);
        } else {
            die("Can't open the file!");
        }
        if ($exist) {
            return true;
        }
        return false;
    }
    public static function isExistEmail($email)
    {
        $exist = false;
        $fileName = "users.csv";
        if (!file_exists($fileName)) {
            die("The file to save the data doesn't exist!");
        }

        $file = fopen($fileName, 'r+');
        if ($file) {
            while (($userInfo = fgetcsv($file)) !== false) {
                $userEmail = $userInfo[3];

                if ($email == $userEmail) {
                    $exist = true;
                }
            }
            fclose($file);
        } else {
            die("Can't open the file!");
        }
        if ($exist) {
            return true;
        }
        return false;
    }
    public static function isExistAuthor($author)
    {
        $exist = false;
        $fileName = "users.csv";
        if (!file_exists($fileName)) {
            die("The file to save the data doesn't exist!");
        }

        $file = fopen($fileName, 'r+');
        if ($file) {
            while (($userInfo = fgetcsv($file)) !== false) {
                $userAuthor = $userInfo[2];

                if ($author == $userAuthor) {
                    $exist = true;
                }
            }
            fclose($file);
        } else {
            die("Can't open the file!");
        }
        if ($exist) {
            return true;
        }
        return false;
    }
}
