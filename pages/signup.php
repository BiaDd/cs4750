<?php
session_start();
require("../connect-db.php");      // include("connect-db.php");
require("../db-controller.php");
$error_msg = '';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  if (!empty($_POST['signup']))
  {

      if ($_POST['password'] != $_POST['password_check']) {
        $error_msg = 'Passwords do not match';
      }
      else {
        signup($_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['password'], $_POST['password_check']);
        if(isset($_SESSION['logged_in']))
        {
            header("Location: home.php");
            exit;
        }
        else {
          $error_msg = "Error creating account";
        }
      }
  }
}
?>


<!DOCTYPE html>
<!--
*  REFERENCES
*  Title: Bootstrap 5 Forms
*  Author: MDBootstrap Team
*  Code version: Bootstrap 5.1.1
*  URL: https://mdbootstrap.com/docs/standard/forms/overview/
*  Software License: MIT license
-->

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

    <title>Recipen - Register</title>
  </head>

  <body>


    <div class="container py-5 mt-2">
      <div class="row py-3 d-flex align-items-center justify-content-center">
        <h1 class="text-center fs-2">Register for Recipen</h1>

        <div class="py-5 d-flex align-items-center justify-content-center">

          <form action="signup.php" method="post">
            <?php
              if (!empty($error_msg)) {
                echo "<div class='alert alert-danger'>$error_msg</div>";
              }
            ?>
            <!-- Username input -->
            <!-- This regex pattern makes a username have to contrain letters and numbers, 6-20 chars.
              -->
            <div class="form-outline mb-4">
              <label class="form-label" for="email">Username</label>
              <p class="signup-note"><em>Alphanumeric, 6-20 characters.</em></p>
              <input
                type="text"
                name="username"
                id="username"
                pattern="[A-Za-z0-9]{6,20}"
                class="form-control form-control-lg"
                required
              />
            </div>


            <!-- first name input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="firstname">First Name</label>
              <input
                type="text"
                name="firstname"
                id="firstname"
                pattern="[A-Za-z]{1,32}"
                class="form-control form-control-lg"
                required
              />
            </div>

            <!-- last name input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="lastname">Last Name</label>
              <input
                type="text"
                name="lastname"
                id="lastname"
                pattern="[A-Za-z]{1,32}"
                class="form-control form-control-lg"
                required
              />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <!-- This regex pattern makes a password have to contain one number one letter one special and 8 chars
                   https://stackoverflow.com/a/21456918
              -->
              <label class="form-label" for="password">Create Password</label>
              <p class="signup-note"><em>8 or more characters, must contain one number, one letter, and one special character.</em></p>
              <input
                type="password"
                name="password"
                id="password"
                pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
                class="form-control form-control-lg"
                required
              />
            </div>

            <div class="form-outline mb-4">
              <!-- This regex pattern makes a password have to contain one number one letter one special and 8 chars
                   https://stackoverflow.com/a/21456918
              -->
              <label class="form-label" for="password_check">Confirm Password</label>
              <input
                type="password"
                name="password_check"
                id="password_check"
                pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"
                class="form-control form-control-lg"
              />
            </div>

            <p class="text-center text-muted mt-5 mb-3">
              Already have an account?
              <a href="login.php" class="fw-bold text-body"><u id="loginHere">Login here</u></a>
            </p>

            <!-- Submit button -->
            <div class="col text-center">
              <input id="signup" name="signup" type="submit" value="Create Account" class="btn btn-primary btn-block btn-lg">
              </input>
            </div>
          </form>
        </div>
      </div>
    </div>


    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
