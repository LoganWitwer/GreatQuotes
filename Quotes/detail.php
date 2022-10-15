<a href="index.php">Go back to quotes index</a>
<hr />
<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    //Create an author array of each authors name
    $fh=fopen('../Data/authors.csv', 'r');
    $author_array=[];
    $index=0;
    while($line=fgets($fh)){
        if(strlen(trim($line))>0){
            $author_pic=explode(';',trim($line));
            $author_array[$index]=$author_pic[0];
            $index++;
        }
    }
    fclose($fh);

    $fh=fopen('../Data/quotes.csv', 'r');
    $line_counter=0;
    while($line=fgets($fh)){
        //If the line from quotes.csv if the line matching the index
        if($line_counter==$_GET['index']){
            $quote=explode(';', trim($line));
            //retrieves the author name from the author array using the index of the author stored in quotes.csv
            echo '<h1>"'.$quote[1].'" - '.$author_array[$quote[0]];
            $fh2=fopen('../Data/authors.csv', 'r');
            while($line=fgets($fh2)){
                $author_pic=explode(';',trim($line));
                //If the author name from the array for the index stored in quotes.csv matches the author name from authors.csv
                if($author_array[$quote[0]]==$author_pic[0]){
                    ?>
                    (<a href="modify.php?index=<?=$_GET['index'] ?>">Modify</a>)
                    (<a href="delete.php?index=<?=$_GET['index'] ?>">Delete</a>)<br />
                    <img src="<?=$author_pic[1]?>" height="300" width="300" alt="A picture of <?=$author_pic[0]?>"><hr />
                    <a href="../auth/members_page.php"><button type="button">Return to Home Page</button></a>
                    <?php
                }
            }
        }
        $line_counter++;
    }
    fclose($fh);
}

?>
