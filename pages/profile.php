<?php
session_start();
require("../connect-db.php");
require("../db-controller.php");

$user = null;
?>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (!empty($_POST['btnAction'] && $_POST['btnAction'] == 'Update') ) {
      $user = getUser($_POST['friend_to_update']);
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
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>Your Profile</h1>
            </div>
            <div class="row justify-content-center">

                <form action="profile.php" method="post">
                    <div class="row mb-3 mx-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php if ($user!=null) echo $user['username'] ?>" required/>
                    </div>
                    <!-- Email input -->
                    <div class="row mb-3 mx-3">
                      <label class="form-label" for="email">Email Address</label>
                      <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        required
                      />
                    </div>
                    <div class="row mb-3 mx-3">
                        <label for="major" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="major" name="major" value="<?php if ($user!=null) echo $user['firstName'] ?>" required/>
                    </div>
                    <div class="row mb-3 mx-3">
                        <label for="major" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="major" name="major" value="<?php if ($user!=null) echo $user['lastName'] ?>" required/>
                    </div>
                    <div class="text-center mb-3 mx-3">
                    <input type="submit" value="Update" name="btnAction" class="btn btn-primary"
       title="Update a friend" />
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
    <?php include('../templates/footer.html') ?>
</html>
