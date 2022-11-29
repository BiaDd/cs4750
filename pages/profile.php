<?php
session_start();
require("../connect-db.php");
require("../db-controller.php");

if (!isset($_SESSION['authenticated'])) {
	header("Location: login.php");
	exit;
}

$userID = $_SESSION['uid'];
$user = getUser($userID);
$email = getEmails($userID);


if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(!empty($_POST['update'])){
    $username =  $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $user = setUser($userID, $username, $firstname, $lastname);
    $user = getUser($userID);
  }
  else if(!empty($_POST['email_update'])){
    $emailAddress = $_POST['email'];
    addEmail($emailAddress, $userID);
  }
}

?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
        <meta name="description" content="">
        <title>Recipen</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    </head>
    <?php include('../templates/header.php') ?>

    <body>
    <table class="" style="width:70%">
              <h1>Your Profile</h1>        
              <ul>
              

                <dl class="row ml-2 pl-2">
                <dt class="col-sm-3 ml-2 pl-2">  <i class="bi bi-file-person"></i> Username</dt>
                <dd class="col-sm-9 ml-2 pl-2"><?php echo $user['username']?> </dd>
                <dt class="col-sm-3 ml-2 pl-2"> <i class="bi bi-envelope-fill"></i> First Name</dt>
                <dd class="col-sm-9 ml-2 pl-2"><?php echo $user['firstName']?> </dd>
                <dt class="col-sm-3 ml-2 pl-2"> <i class="bi bi-envelope-fill"></i> Last Name</dt>
                <dd class="col-sm-9 ml-2 pl-2"><?php echo $user['lastName']?> </dd>
                <?php foreach ($email as $address): ?>
                 <dt class="col-sm-3 ml-2 pl-2"> <i class="bi bi-envelope-fill"></i> Email</dt>
                 <dd class="col-sm-9 ml-2 pl-2"><?php if($email!=null) echo $address['emailAddress']?> </dd>
                 <?php endforeach; ?>
                <dd class="col-sm-9 ml-2 pl-2">
               </dd>
               </dl>
              
            </ul>
            <div class="row justify-content-center">
            <h1>Update Profile</h1>   

                <form name = update action="profile.php" method="post">
                    <div class="row mb-3 mx-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php if ($user!=null) echo $user['username'] ?>" required/>
                    </div>
  
                    <div class="row mb-3 mx-3">
                        <label for="major" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php if ($user!=null) echo $user['firstName'] ?>" required/>
                    </div>
                    <div class="row mb-3 mx-3">
                        <label for="major" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php if ($user!=null) echo $user['lastName'] ?>" required/>
                    </div>
                    <div class="text-center mb-3 mx-3">
                    <input type="submit" value="Update" name="update" class="btn btn-primary" title="Update user profile" />
                    </div>
                </form>
                <form name = email_update action="profile.php" method="post">
                  <!-- Email input -->
                  <div class="row mb-3 mx-3">
                      <label class="form-label" for="email">Email Address</label>
                      <input type="email" name="email" id="email" class="form-control" required/>
                </div>
                <div class="text-center mb-3 mx-3">
                    <input type="submit" value="Update Email" name="email_update" class="btn btn-primary" title="Update user email" />
                    </div>
                  </form>
                    </div>


            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
    <?php include('../templates/footer.html') ?>
</html>
