<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    $fh=fopen('../Data/quotes.csv', 'r');
    $author_name='';
    $line_counter=0;
    while($line=fgets($fh)){
        if($line_counter==$_GET['index']){
            $author_quote=explode(';', trim($line));
        }
        $line_counter++;
    }
    fclose($fh);
    if(count($_POST)>0){
        if(!isset($_GET['index'])){
            die('Please enter the quote you want to modify');
        }
        if(!isset($_POST['name1'])){
            die('Please enter a quote.');
        }
        if(!isset($_POST['author'])){
            ?>
            <a href="index.php">Return</a><br>
            <?php
            die('Please select an author.');
        }
        $fh=fopen('../Data/authors.csv', 'r');
        $author_array2=[];
        $author='';
        $array_index2=0;
        while($line=fgets($fh)){
            $author_array2[$array_index2]=trim($line);
            $array_index2++;
        }
        fclose($fh);

        $fh=fopen('../Data/quotes.csv', 'r+');
        $fh2=fopen('../Data/quotes.csv', 'r');
        $array_index3=0;
        $line_tracker=0;
        $value=$_POST['author'] - 1;
        $new='';
        while($array_index3<count($author_array2)){
                //writes in the author;quote to quotes.csv
                if(!empty($_POST['author'])) {
                    $fix_index=$_POST['author'] - 1;//- 1
                    while($line=fgets($fh2)){
                        if($line_tracker==$_GET['index']){ 
                            $array_index3=array_search($_POST['author'], $author_array2);
                            $new.=$value.';'.$_POST['name1'].PHP_EOL;
                            $line_tracker++;
                        } else {
                            $new.=$line;
                            $line_tracker++;
                        }
                    }
                break;
                }
            $array_index3++;
            
        }
        file_put_contents('../Data/quotes.csv', $new);
        fclose($fh);
        fclose($fh2);
        
        ?>

        <?php
        echo 'You have successfully modified the quote.<br><a href="index.php"><button type="button">Return</button></a>';
    } else {

        ?>
        <form method="POST">
            Modify the quote.<br />
            <input type="text" name="name1" value="<?=$author_quote[1]?>" required>&nbsp;
            <?php
            $fh=fopen('../Data/authors.csv', 'r');
            $author_array=[];
            $author='';
            $array_index=0;
            ?>
            <select name="author" id="author" required>
                <option disabled selected>-- select an author --</option>
            <?php
            while($line=fgets($fh)){
                ?>
                <?php
                if(strlen(trim($line))>0){
                    $author_index=explode(';',trim($line));
                
                    ?>
                    <option value="<?=($array_index) + 1?>"><?=$author_index[0]?></option><!--+1-->
                    <?php
                    $author_array[$array_index]=trim($line);
                    echo $author_array[$array_index];
                    $array_index++;
                }
            }
            fclose($fh);
            ?>
            </select><hr />
            <button type="submit" value="submit">Modify Quote</button>    <a href="index.php"><button type="button">Return</button></a>
        </form>
    <?php
    }
}
