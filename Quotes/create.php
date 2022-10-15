<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    ?>
    <form method="POST">
        Enter the quote and choose an author!<br />
        If your author is not shown, go to the author page and create your author.<br />
        <input type="text" name="name" />&nbsp;
        <?php
        $fh=fopen('../Data/authors.csv', 'r');
        $author_array=[];
        ?>
        <label for="authors">Choose an author:</label>
        <select name="author" id="author" required>
            <option disabled selected>-- select an author --</option>
        <?php
        $array_index=0;
        while($line=fgets($fh)){
            //Check if line is blank
            if(trim($line)==''){
            } else {
                $author_pic=explode(';',trim($line));
                //Add an option to the select box with the value of the index upped by one (undoes this later), and the name of the author from authors
                ?>
                <option value="<?=$array_index + 1?>"><?=$author_pic[0]?></option>
                <?php
                $author_array[$array_index]=$author_pic[0];//ensure the correct author is stored
                $array_index++;
            }
        }
        fclose($fh);
        ?>
        </select><hr />
        <button type="submit">Add Quote</button></a>   <a href="index.php"><button type="button">Return</button></a>
        <?php

        ?>
    </form>
    <?php
    if(count($_POST)>0) {    
        //Add the name to the csv file unless quote is already in the file
        if(file_exists('../Data/quotes.csv')) {
            $fh=fopen('../Data/quotes.csv', 'r');
            while($line=fgets($fh)) {
                if(strlen(trim($line))>0){
                $index_quote=explode(';',trim($line));
                if($_POST['name']==$index_quote[1]) {
                    die('The quote already exists.');
                }
                }
            }
            fclose($fh);

            $fh=fopen('../Data/quotes.csv', 'a');
            $array_index=0;
            while($array_index<count($author_array)){
                //writes in the author;quote to quotes.csv
                if(!empty($_POST['author'])) {
                    $test_variable=($_POST['author']) - 1;//lower the author value to account for the plus one earlier
                    fputs($fh,$test_variable.';'.$_POST['name'].PHP_EOL);
                    fclose($fh);
                    echo 'Thanks for adding "'.$_POST['name'].'" to our quote collecting website!';
                    break;
                }
            $array_index++;
            }
        }
    }
}
?>