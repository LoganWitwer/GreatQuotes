<form method="POST">
	<input type="email" name="emailAddress" />
	<input type="password" name="passwordUnencrypted" />
	
	<input type="submit" value="Submit" />
</form><hr />
<a href="../auth/public.php"><button type="button">Return to our home page</button></a>
<?php
session_start();


require_once('auth.php');
// if the user is alreay signed in, redirect them to the members_page.php page
if($_SESSION['logged']=true){
	//REDIRECT TO MEMBERS PAGE
}
// use the following guidelines to create the function in auth.php
// instead of using "die", return a message that can be printed in the HTML page
if(count($_POST)>0){
    signup();
}
?>


