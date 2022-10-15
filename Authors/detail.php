<a href="index.php">Go back to our index page.</a>
<hr />
<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    $fh=fopen('../Data/authors.csv', 'r');
    $line_counter=0;
    while($line=fgets($fh)){
        $author_pic=explode(';',trim($line));
        if($line_counter==$_GET['index']){
            echo $author_pic[0];
            ?>
            (<a href="modify.php?index=<?=$_GET['index'] ?>">Modify</a>)
            (<a href="delete.php?index=<?=$_GET['index'] ?>">Delete</a>)<br>
            <img src="<?= $author_pic[1]?>" alt="A picture of <?= $author_pic[0]?>" height="300" width="300">
            <?php
        }
        $line_counter++;
    }
    fclose($fh);
    
}
