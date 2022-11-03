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
    $user = $statement->fetchAll(); // just want 1 person

    if ($user === false) { // If there is an error:
        $error_msg = "Error occurred while logging in.";
    } else if (!empty($user)) { // If there is no error:
        if (password_verify($password, $user[0]["password"])) { // user[0] would be the only user if they exist
            $_SESSION["username"] = $data[0]["username"];
            $_SESSION["logged_in"] = true;
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
  $statement->closeCursor();


}


// function signup($username, $firstname, $lastname, $password, $password_check) {
//   #echo "yo";
//   // need to check if passwords match first
//   if ($password !== $password_check) {
//     echo 'Passwords do not match'
//   }
//   else {
//     // need to check if username already appears in the database
//     global $db;
//     $checkExists = "SELECT * FROM user WHERE username=:username";
//     $createUser = "INSERT INTO user VALUES (:username, :firstname, :lastname, :password)";
//     $uname = strtolower($username);
//     try {
//       $statement = $db->prepare($checkExists);
//       $statement->bindValue(':uname', $uname);
//       $statement->execute();
//       $statement->closeCursor();
//       $user = $statement->fetch();
//
//       // if user exists echo and return;
//       // else use create user query
//       // redirect to profile.html
//       $statement->closeCursor();
//
//
//       header("Location: pages/profile.php")
//       return;
//
//     }
//     catch (PDOException $e){
//       echo 'Error adding friend';
//     }
//
//   }
// }


 ?>
