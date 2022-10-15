<a href="../Quotes/index.php">Check out quotes that have been submitted using these authors!</a><br>
<a href="create.php">Add a new author!</a>
<a href="../auth/members_page.php"><button type="button">Return to our home page</button></a>
<hr />
<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    $fh=fopen('../Data/authors.csv', 'r');
    $index=0;
    while($line=fgets($fh)) {
        //Check if the line contains an author
        if(strlen(trim($line)) > 0){
            $author_pic=explode(';',trim($line));
            echo '<h1>'.$author_pic[0].' <a href="detail.php?index='.$index.'">Detail</a> (<a href="modify.php?index='.$index.'">Modify</a>) (<a href="delete.php?index='.$index.'" style="color:blue">Delete</a>)</h1>';
        }
        $index++;
    }
    fclose($fh);
}

