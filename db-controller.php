<?php
function login($username, $password) {
  #echo "yo";
  global $db;
  $uname = strtolower($username);
  $query = "SELECT * FROM user WHERE username=:uname";
  try {
    $statement = $db->prepare($query);
    $statement->bindValue(':uname', $uname);
    $statement->execute();
    $user = $statement->fetch(); // just want 1 person
    #var_dump($user);
    if ($user === false) { // If there is an error:
        $error_msg = "Error occurred while logging in.";
    } else if (!empty($user)) { // If there is no error:
        if (password_verify($password, $user['password'])) { // only works with creating user through password hash
            $_SESSION["username"] = $user['username'];
            $_SESSION["logged_in"] = True;
            $statement->closeCursor();
            return;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username or password is incorrect. Have you registered?";

    }
  }
  catch (PDOException $e){
    echo 'Cannot find user';
  }
}


function signup($username, $firstname, $lastname, $password, $password_check) {
  #echo "yo";
  // need to check if passwords match first

  // need to check if username already appears in the database
  global $db;
  $checkExists = "SELECT * FROM user WHERE username=:username";
  $createUser = "INSERT INTO user (username, firstName, lastName, password) VALUES (:username, :firstName, :lastName, :password)";
  $uname = strtolower($username);
  try {
    $statement = $db->prepare($checkExists);

    $statement->bindValue(':username', $uname);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    // if user exists echo and return;

    if (!empty($user)) {
      echo "That username has already been taken";
    } else {
      $insert = $db->prepare($createUser);
      $insert->bindValue(':username', $uname);
      $insert->bindValue(':firstName', $firstname);
      $insert->bindValue(':lastName', $lastname);
      $insert->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
      $insert->execute();
      $insert->closeCursor();
      $_SESSION["username"] = $uname;
      $_SESSION["logged_in"] = True;

      return;
    }
  }
  catch (PDOException $e){
    echo 'Error adding friend';
  }
}


function getCart($username) {
  return [];
}

function getCartPrice($username) {
  global $db;
  $query = "SELECT totalPrice FROM grocerycart NATURAL JOIN usercart NATURAL JOIN user WHERE usercart.userID = user.userID AND user.username=:username";
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result['totalPrice'];
}

 ?>
