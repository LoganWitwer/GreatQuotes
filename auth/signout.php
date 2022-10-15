<?php
session_start();
require_once('auth.php');
// if the user is not logged in, redirect them to the public page
if(!isset($_SESSION['logged'])){
    echo 'You cannot log out if you are not logged in.<br><a href="../Quotes/index.php>View our quotes.<a><br><a href="signin.php">Sign In</a>';
} else { 
    signout();
    // redirect the user to the public page.
    header('location: public.php');

}


