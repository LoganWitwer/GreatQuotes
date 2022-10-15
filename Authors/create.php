<?php

session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    if(count($_POST)>0) {    
        $error='';
        //Add the name to the csv file unless author is already in the file
        if(file_exists('../Data/authors.csv')) {
            $fh=fopen('../Data/authors.csv', 'r');
            while($line=fgets($fh)) {
                $name_pic=explode(';',trim($line));
                if($_POST['name']==$name_pic[0]) {
                    $error='The author already exists.';
                }
            }
            fclose($fh);
            if(strlen($error)>0) echo $error;
            else {
                $fh=fopen('../Data/authors.csv', 'a');
                fputs($fh,$_POST['name'].';'.$_POST['authorPic'].PHP_EOL);
                fclose($fh);
                echo 'Thanks for adding '.$_POST['name'].' to our quote collecting website!';
            }
        }
    }
    ?>
    <form method="POST">
        Enter the author's name<br />
        <input type="text" name="name" required/><br />
        Enter a link to a picture of this author.<br />
        <input type="url" name="authorPic" required><br />
        <button type="submit">Add Author</button>   <a href="index.php"><button type="button">Return</button></a>
    </form>
<?php
}
