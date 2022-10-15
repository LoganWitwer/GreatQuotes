<a href="index.php">Return to our list of authors!</a>
<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    if(!isset($_GET['index'])) {
        die('Please enter the author you want to delete via their line in authors.csv.');
    }
    $fh=fopen('../Data/authors.csv', 'r');
    $authorArrayLine=[];
    $authorArrayName=[];
    $arrayIndex=0;
    $line_tracker=0;
    /*Creates two arrays, $authorArrayLine stores the author's name from authors.csv with an index that matches the line it is on.
    $authorArrayName stores the authors name from authors.csv with an index matching the author arrays used on others pages that skip blank lines.*/
    while($line=fgets($fh)){
        if(strlen(trim($line))>0){
            $authorNameString_URL=explode(';',trim($line));
            $authorArrayLine[$line_tracker]=$authorNameString_URL[0];
            $authorArrayName[$arrayIndex]=$authorNameString_URL[0];
            $arrayIndex++;
            $line_tracker++;
            
        } else {
            $authorArrayLine[$line_tracker]='Q';
            $line_tracker++;
        }
    }
    
    fclose($fh);
    /*Compares the author's name using the line the author is on from authors.csv with the author associated with the quotes in quotes.csv.
    This allows me to remove the quotes associated with a deleted author.*/
    if(file_exists('../Data/quotes.csv')){
        $fh2=fopen('../Data/quotes.csv', 'r');
        $new_file_content2='';
        $check=0;
        while($line=fgets($fh2)){
            if(strlen(trim($line))>0){
                $authorIndex_quote=explode(';',trim($line));
                $check=intval($authorIndex_quote[0]);
                if($check>array_search($authorArrayLine[$_GET['index']],$authorArrayName)){
                    $line=strval($check-1).';'.$authorIndex_quote[1].PHP_EOL;
                }
                if($authorArrayLine[$_GET['index']]==$authorArrayName[$authorIndex_quote[0]]){
                    $new_file_content2.=PHP_EOL;
                } else {
                    $new_file_content2.=$line;  
                }
            }
        }
        file_put_contents('../Data/quotes.csv', $new_file_content2);
    }

    fclose($fh2);
    if(file_exists('../Data/authors.csv')) {
        $author_to_be_deleted=$_GET['index'];//the line we need to delete
        $fh=fopen('../Data/authors.csv', 'r');
        $line_counter=0;
        $new_file_content='';
        while($line=fgets($fh)) {
            //Check if current line is the line we need to delete
            if($line_counter==$_GET['index']) $new_file_content.=PHP_EOL;
            else $new_file_content.=$line;
            $line_counter++;
        }
        fclose($fh);
        file_put_contents('../Data/authors.csv', $new_file_content);
        echo 'You have successfully removed the author.';
    }

}