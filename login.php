<!DOCTYPE html>
<!--
*  REFERENCES
*  Title: Bootstrap 5 Forms
*  Author: MDBootstrap Team
*  Code version: Bootstrap 5.1.1
*  URL: https://mdbootstrap.com/docs/standard/forms/overview/
*  Software License: MIT license
-->

<?php
session_start();
require("connect-db.php");      // include("connect-db.php");
require("db-controller.php");
$error_msg = '';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  if (!empty($_POST['login']))
  {
    login($_POST['username'], $_POST['password']);

    if(isset($_SESSION['logged_in']))
    {
        header("Location: profile.php");
        exit;
    }
    else {
      $error_msg = "Error logging in";
    }
  }
}
?>


<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <title>Recipen - Login</title>
  </head>

  <body>
    <div class="container py-5 mt-5">
      <div class="row py-2 d-flex align-items-center justify-content-center">
        <h1 class="text-center fs-1">Recipen</h1>

        <div class="col-xl-6 mb-2 align-items-center justify-content-center">
          <?php
            if(!empty($error_msg)){
                echo '<div class="alert alert-danger">' . $error_msg . '</div>';
            }
          ?>

          <form action="login.php" method="post">

            <!-- Username input -->
            <!-- This regex pattern makes a username have to contrain only letters and numbers, 6-20 chars.
                   https://stackoverflow.com/q/52884164
              -->
            <div class="form-outline mb-4">
              <label class="form-label" for="username">Username</label>
              <input
                type="username"
                name="username"
                id="username"
                class="form-control form-control-lg"
                placeholder=""
                required
              />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <!-- This regex pattern makes a password have to contain one number one letter one special and 8 chars
                   https://stackoverflow.com/a/21456918
              -->
              <label class="form-label" for="password">Password</label>
              <input
                type="password"
                name="password"
                id="password"
                class="form-control form-control-lg"
                required
              />
            </div>


            <!-- Submit button -->
            <div class="col text-center">
              <input id="login" name="login" type="submit" value="Login" class="btn btn-primary btn-block btn-lg">

              </input>
            </div>

            <p class="text-center text-muted mt-5 mb-3">
              First visit?
              <a href="signup.php" class="fw-bold text-body"><u id="signUp">Register here</u></a>
            </p>
          </form>
        </div>
      </div>
    </div>


    <?php include('footer.html') ?>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
