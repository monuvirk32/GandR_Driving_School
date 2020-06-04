<?php 
session_start();


//logout.php

include('googleconfig.php');
include('fbconfig.php');

//Reset OAuth access token
$google_client->revokeToken();

// Remove access token from session
unset($_SESSION['facebook_access_token']);

//Destroy entire session data.
session_destroy();

//redirect page to index.php
header('location:index.php');


?>