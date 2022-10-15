<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    if(!isset($_GET['index'])) {
        die('Please enter the quote you want to delete.');
    }
    if(file_exists('../Data/quotes.csv')) {
        $author_to_be_deleted=$_GET['index'];//the line we need to delete
        $fh=fopen('../Data/quotes.csv', 'r');
        $line_counter=0;
        $new_file_content='';
        while($line=fgets($fh)) {
            //Check if the line we are on in the loop is the line we need to delete
            if($line_counter==$_GET['index']) $new_file_content.=PHP_EOL;//if so, save a blank line to the new contents
            else $new_file_content.=$line;//if not, save the current line to the new contents
            $line_counter++;
        }
        fclose($fh);
        file_put_contents('../Data/quotes.csv', $new_file_content);
        echo 'You have successfully removed the quote.<br />';
    }
}
?>
<a href="index.php">Return to our quote collection!</a>