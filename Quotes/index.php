<a href="../Authors/index.php">Switch to our list of Authors!</a><br />
<a href="create.php">Add a new quote!</a>
<hr />
<a href="../auth/members_page.php"><button type="button">Return to our home page</button></a>
<hr />
<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if((is_logged())==false){
    header('location: ..\auth\public.php');
} else {

    //Create an array that stores the authors with an index
    $author_array=[];
    $fh2=fopen('../Data/authors.csv', 'r');
    while($line=fgets($fh2)){
        if(strlen(trim($line))>0){
        $author_pic=explode(';',trim($line));
        $author_array[]=$author_pic[0];
        }
    }
    fclose($fh2);
    //Prints out the Quote in quotations followed by the authors name using the quotes.csv file
    $fh=fopen('../Data/quotes.csv', 'r');
    $index=0;
    while($line=fgets($fh)) {
        if(strlen(trim($line)) > 0){
            $quote=explode(';',trim($line));
            if($author_array[$quote[0]]==''){
                $line=PHP_EOL;
            } else {
                echo '<h1>"'.$quote[1].'" - '.$author_array[$quote[0]].' <a href="detail.php?index='.$index.'">Detail</a> (<a href="modify.php?index='.$index.'">Modify</a>) (<a href="delete.php?index='.$index.'" style="color:blue">Delete</a>)</h1>';
            }
        }
        $index++;
    }
    fclose($fh);
}
?>


