<?php

// add parameters
function signup(){
	// add the body of the function based on the guidelines of signup.php
	// check if the fields are empty
	if(!isset($_POST['emailAddress'])){
		echo 'Enter an email address signup.';
	}else if(!isset($_POST['passwordUnencrypted'])) {
		echo 'Enter a password signup.';
	} else if (isset($_POST['passwordUnencrypted'])){
		// check if the email is valid
		if(!filter_var($_POST['emailAddress'], FILTER_VALIDATE_EMAIL)) die('Your email is invalid');
		
		// check if password length is between 8 and 16 characters
		if(strlen($_POST['passwordUnencrypted'])<8){
			echo 'Please enter a password that is at least 8 characters';
			die();
		}
		// check if the password contains at least 2 special characters
		
		// check if the file containing banned users exists
		if(file_exists('data\banned.csv.php')){
			// check if the email has not been banned
			$fh=fopen('data\banned.csv.php', 'r');
			while($line=fgets($fh)){
				if(trim($line)==$_POST['emailAddress']){
					die('You are banned.');
				}
			}
			fclose($fh);
			// check if the file containing users exists
			if(file_exists('data\users.csv.php')){
				// check if the email is in the database already
				$fh=fopen('data\users.csv.php', 'r');
				while($line=fgets($fh)){
					$email_password=explode(';', trim($line));
					if(trim($email_password[0]==$_POST['emailAddress'])){
						die('An account already exists with this email.');
					}
				}
				fclose($fh);


				// save the user in the database
				$fh=fopen('data\users.csv.php', 'a');
				// encrypt password
				fputs($fh,$_POST['emailAddress'].';'.password_hash($_POST['passwordUnencrypted'],PASSWORD_DEFAULT).PHP_EOL);
				fclose($fh);
				// show them a success message and redirect them to the sign in page
				echo 'You have successfully created an account!<br><a href="signin.php">Sign In</a>';
			}
		}
	}
}

// add parameters
function signin(){
	// add the body of the function based on the guidelines of signin.php
	// 1. check if email and password have been submitted
	if(!isset($_POST['emailAddress2'])){
		echo 'Enter an email address signin.';
	}else if(!isset($_POST['passwordUnencrypted2'])) {
		echo 'Enter a password signin.';
	} else if (isset($_POST['passwordUnencrypted2'])){
		// 2. check if the email is well formatted
		if(!filter_var($_POST['emailAddress2'], FILTER_VALIDATE_EMAIL)) die('Your email is invalid');
		// 3. check if the password is well formatted

		// 4. check if the file containing banned users exists
		if(file_exists('data\banned.csv.php')){
			// 5. check if the email has been banned
			$fh=fopen('data\banned.csv.php', 'r');
			while($line=fgets($fh)){
				$email_password2=explode(';',trim($line));
				if($email_password2[0]==$_POST['emailAddress2']){
					echo $email_password2[0];
					die('You are banned.');
				}
			}
			fclose($fh);
		}
		// 6. check if the file containing users exists
		if(file_exists('data\users.csv.php')){
			// 7. check if the email is registered
			$fh=fopen('data\users.csv.php', 'r');
			while($line=fgets($fh)){
				$email_password2=explode(';',trim($line));
				if($email_password2[0]==$_POST['emailAddress2']){
					$registered=true;
					//$input=$_POST['passwordUnencrypted2'];
					// 8. check if the password is correct
					if(password_verify($_POST['passwordUnencrypted2'],$email_password2[1])){
						$correct_password=true;
						// 9. store session information
						$_SESSION['logged']=true;
						$_SESSION['user_name']=$email_password2[0];
						header('location: members_page.php');
						break;
					} else {
						$correct_password=false;
						?>
						<a href="signin.php">Try again.</a><br>
						<?php
						die('Incorrect password.');
					}

				} else {
					$registered=false;
				}
			}
			fclose($fh);
			if(!$registered){
				?>
				<a href="signin.php">Try again.</a><br>
				<?php
				die('This email does not have an account.');
			}

		}
		

		// 10. redirect the user to the members_page.php page //is the members_page.php just the index from Quotes and if they are not logged in they do not see create, modify, or delete?
		echo 'You are now signed in!';//test line

	}
}

function signout(){
	// add the body of the function based on the guidelines of signout.php
	// use the following guidelines to create the function in auth.php
	$_SESSION['logged']=false;
	session_destroy();
	echo 'You have signed out.<br><a href="members_page.php">View our quotes.<a><br><a href="signin.php">Sign In</a>';
}

function is_logged(){
	// check if the user is logged
	//return true|false
	if($_SESSION['logged']==false){
		return false;
	} else if ((isset($_SESSION['logged']))==true){
		return true;
	} 
}