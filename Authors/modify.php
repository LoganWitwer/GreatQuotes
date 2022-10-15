<a href="index.php">Return to our list of ever-growing authors!</a>
<hr />
<?php
session_start();
require_once('../auth/auth.php');
//Check if logged else redirect to public page
if(!(is_logged())){
    header('location: ../auth/public.php');
} else {
    if(count($_POST)>0){
        if(!isset($_GET['index'])){
            die('Please enter the author you want to modify');
        }
        //save author name into file along with a link to a photo
        $fh=fopen('../Data/authors.csv', 'r');
        $new_file_content='';
        $line_counter=0;
        while($line=fgets($fh)) {
            if($line_counter==$_GET['index']) $new_file_content.=$_POST['name'].';'.$_POST['url'].PHP_EOL;
            else $new_file_content.=$line;
            $line_counter++;
        }
        

        file_put_contents('../Data/authors.csv', $new_file_content);
        fclose($fh);
        echo 'You have successfully modified the author.';
        ?>

        <?php
    } else {
        $fh=fopen('../Data/authors.csv', 'r');
        $author_name='';
        $line_counter=0;
        while($line=fgets($fh)){
            if($line_counter==$_GET['index']){
                $author_name=explode(';',trim($line));
            }
            $line_counter++;
        }
        fclose($fh);
        ?>
        <form method="POST">
            Modify the author's name.<br />
            <input type="text" name="name" value="<?= $author_name[0]?>"/><br>
            Modify the authors linked image.<br>
            <input type="url" name="url" value="<?= $author_name[1]?>" required><br />
            <button type="submit">Modify Author</button>
        </form>
    <?php
    }
}
