<?php
session_start();
require_once('auth.php');

if(!(is_logged())){
    header('location: public.php');
} else {

    ?>
    <a href="../Authors/index.php">Go to our list of Authors!</a><br />
    <a href="../Quotes/create.php">Add a new quote!</a>
    <hr />
    <?php

    $author_array=[];
    $fh2=fopen('../Data/authors.csv', 'r');
    while($line=fgets($fh2)){
        if(strlen(trim($line))>0){
            $author_pic=explode(';',trim($line));
            $author_array[]=$author_pic[0];
        }
    }
    fclose($fh2);
    
    $fh=fopen('../Data/quotes.csv', 'r');
    $index=0;

    while($line=fgets($fh)) {
        if(strlen(trim($line)) > 0){
            $quote=explode(';', trim($line));

            echo '<h1>"'.$quote[1].'" - '.$author_array[$quote[0]].' <a href="../Quotes/detail.php?index='.$index.'">Detail</a> (<a href="../Quotes/modify.php?index='.$index.'">Modify</a>) (<a href="../Quotes/delete.php?index='.$index.'" style="color:blue">Delete</a>)</h1>';
        }
        $index++;
    }
    fclose($fh);
}
?>
<a href="signout.php">Sign Out</a>
