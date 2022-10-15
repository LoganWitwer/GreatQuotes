<h2>Want to become a member? Don't hesitate! <a href="signup.php">Sign up<a> today!</h2>
<p>Sign in to add quotes and authors.</p><a href="signin.php"><button type="button">Sign In</button></a>
<?php
session_start();
$_SESSION['logged']=false;

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

        echo '<p>"'.$quote[1].'" - '.$author_array[$quote[0]].'</p>';
    }
    $index++;
}
fclose($fh);