<?php
class Blog
{
    public $title;
    public $author;
    public $description;
    public $id;

    public function __construct($title, $author, $description)
    {
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;

        $id = 0;
        $fileName = "blogs.csv";
        if (!file_exists($fileName)) {
            die("The file to save the data doesn't exist!");
        }

        $file = fopen($fileName, 'r+');
        $blogIds = [];
        if ($file) {
            while (($line = fgetcsv($file)) != false) {
                array_push($blogIds, $line[3]);
            }
            fclose($file);

            do {
                $id = mt_rand(0, 999999);
                echo $id . "<br>";
            } while (in_array($id, $blogIds));
        } else {
            die("Can't open the file!");
        }
        $this->id = $id;
    }

    public function submit()
    {
        $dataArr = array($this->title, $this->author, $this->description, $this->id);

        include_once "writeToAFile.php";
        writer("blogs.csv", $dataArr);
    }

    public static function deleteWithId($id)
    {
        $fileName = "blogs.csv";
        if (!file_exists($fileName)) {
            die("The file to save the data doesn't exist!");
        }

        $file = fopen($fileName, 'r+');
        $tempFile = fopen("temp.csv", 'w');
        if ($file) {
            while (($line = fgetcsv($file)) != false) {
                if ($line[3] == $id) {
                    continue;
                }
                fputcsv($tempFile, $line);
            }
            fclose($file);
            fclose($tempFile);
            rename("temp.csv", "blogs.csv");
        } else {
            die("Can't open the file!");
        }
    }
}
