<?php

// ============== Includes ==============

// Include CSS.
echo '<link rel="stylesheet" type="text/css" href="css/styles.css"></script>';

// Allow anyone to view the login page.
$secured = false;

// Include Header
include("includes/header.php");

// Include bootstrap library.
include("includes/bootstrap.php");

// DB setup
require("includes/db_config.php");

// ============== Variables ==============


// ============== Operations ==============

// Make sure there is a session started.
if (!isset($_SESSION)) {
    session_start();
}

// If the user has just clicked submit...
if (isset($_POST['submit'])) {
    signUp($Database);
}

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <div class="container" style="max-width:500px;">
        <form class="form-signin" method="post">
            <br>
            <!-- Image -->
            <img class="mb-4" src="images/ImageNotFound.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Create an account</h1>
            <!-- First Name -->
            <div class="row">
                <div class="col">
                <input type="text" name="inputFirstName" class="form-control" placeholder="First name">
                </div>
                <div class="col">
                <input type="text" name="inputLastName" class="form-control" placeholder="Last name">
                </div>
            </div>
            <br>
            <!-- Email -->
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <br>
            <!-- Password -->
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required="">
            <br>
            <!-- Text Area -->
            <label for="aboutMe">About Me</label>
            <textarea class="form-control" id="aboutMe" name="aboutMe" rows="3"></textarea>
            <br>
            <!-- Submit -->
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign Up</button>
            <p class="mt-5 mb-3 text-muted">© 2020</p>
        </form>
    </div>

</body>

</html>
<?php
// Include Footer
include("includes/footer.php");
?>

<!-- PHP functions -->
<?php

// Create an account
function signUp($Database)
{
    // Define variables.
    $inputFirstName = "";
    $inputLastName = "";
    $inputEmail = "";
    $inputPassword = "";
    $aboutMe = "";
    $isAdmin = 0;

    // Collect input from the user.
    if (isset($_POST['inputFirstName'])) $inputFirstName = trim($_POST['inputFirstName']);
    if (isset($_POST['inputLastName'])) $inputLastName = trim($_POST['inputLastName']);
    if (isset($_POST['inputEmail'])) $inputEmail = trim($_POST['inputEmail']);
    if (isset($_POST['inputPassword'])) $inputPassword = trim($_POST['inputPassword']);
    if (isset($_POST['aboutMe'])) $aboutMe = trim($_POST['aboutMe']);

    // TODO: Input Regex Checking goes here.

    // Query the DB for that user.    
    $result = $Database->count_users_by_identity($inputEmail);
    if ($result->num_rows === 0) {
        $t = $Database->create_user($inputFirstName, $inputLastName, $inputEmail, $inputPassword, $isAdmin, $aboutMe);
        header("Location: login_form.php");

    // User input failed, but the query was succesful.
    }
    else
        $errorMessage = "User already exists";
}

?>