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
            $_SESSION["uid"] = $user['userID'];
            $_SESSION["authenticated"] = true;
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
      $_SESSION["uid"] = $db->lastInsertId();
      $_SESSION["authenticated"] = True;

      return;
    }
  }
  catch (PDOException $e){
    echo 'Error signing up';
  }
}

function getUser($username) {

}


function getCart($username) {
  return [];
}

function getIngredients() {
  global $db;
  $ingredient_list = array("Additive"=>array(),"Baking"=>array(),"Cereal"=>array(),"Dairy"=>array(),"Fish"=>array(),"Fruits"=>array(),"Meats"=>array(),"Nuts"=>array(),"Seafood"=>array(), "Seasonings"=>array(),"Sauces"=>array(),"Vegetables"=>array());

  # need to have multiple select statements for each category of ingredients
  $ingredient_query = "SELECT ingredientName FROM ingredient WHERE ingredientType=:type";

  // append ingredients to whichever ingredients it corresponds with and return
  $selectID = $db->prepare($ingredient_query);
  foreach ($ingredient_list as $key=>$list) {
    $selectID->bindValue(':type', $key);
    $selectID->execute();
    $result = $selectID->fetchAll();

    foreach ($result as $ingredient) {
      //var_dump($ingredient[0]);
      array_push($list, $ingredient[0]);
    }
    $ingredient_list[$key] = $list;
    $selectID->closeCursor();
  }

  //var_dump($ingredient_list["Additive"]);

  return $ingredient_list;
}


// this function only runs after user is logged in
function addRecipe($rname, $rdescription, $ringredients) {
  global $db;

  // check for if recipe already exists?

  // insert recipe into recipe table with 0 as initial price and 0 as initial rating
  $insertRecipe = "INSERT INTO recipe (recipeName, description, userID, rating, price) VALUES (:rname, :rdescription, :userID, :rating, :price)";
  $insert = $db->prepare($insertRecipe);
  $insert->bindValue(':rname', $rname);
  $insert->bindValue(':rdescription', $rdescription);
  $insert->bindValue(':userID', $_SESSION["uid"]);
  $insert->bindValue(':rating', 0.0);
  $insert->bindValue(':price', 0.0);
  $insert->execute();
  $insert->closeCursor();
  $recipeID = $db->lastInsertId(); // primary key of inserted recipe

  // add ingredient recipe links to ingredient recipe table
  // need to get list of all ingredient ID in list
  $get_ingredientID = "SELECT ingredientID FROM ingredient WHERE ingredientName=:iname";
  $ingredientID_list = array();
  $selectID = $db->prepare($get_ingredientID);
  #var_dump($ringredients);
  #var_dump($ringredients);
  foreach ($ringredients as $ingredient=>$quantity) {
    #echo $ingredient;
    $selectID->bindValue(':iname', $ingredient);
    $selectID->execute();
    $id = $selectID->fetch();
    $ingredientID_list[$ingredient] = $id[0];
    #var_dump($ingredientID_list);
    $selectID->closeCursor();
  }


  $insertIngredientRecipe = "INSERT INTO recipeingredient (ingredientID, recipeID, quantity) VALUES (:ingredientID, :recipeID, :quantity)";
  $insert = $db->prepare($insertIngredientRecipe);
  foreach ($ringredients as $ingredient => $quantity) {
    // get id of ingredients in the ingredient list from ingredient name
    // bind values and insert into the thing
    $insert->bindValue(':ingredientID', $ingredientID_list[$ingredient]);
    $insert->bindValue(':recipeID', $recipeID);
    $insert->bindValue(':quantity', $quantity);
    $insert->execute();
    $insert->closeCursor(); // maybe have this line outside the loop?
  }

  $getPrice =
  "SELECT table1.recipeID, SUM(table1.totalPrice) AS price
  FROM (SELECT recipeingredient.ingredientID, recipeingredient.recipeID, recipeingredient.quantity * ingredient.price AS totalPrice FROM recipeingredient, ingredient WHERE ingredient.ingredientID = recipeingredient.ingredientID)
  AS table1 GROUP BY recipeID";
  $statement = $db->prepare($getPrice);
  $statement->execute();
  $price = number_format($statement->fetch()["price"], 2);
  #var_dump($price);
  $statement->closeCursor();

  //update price for sql table
  $changePrice = "UPDATE recipe SET price=$price WHERE recipeID=$recipeID";
  $statement = $db->prepare($changePrice);
  $statement->execute();
  $statement->closeCursor();
  return;
}



function getCartPrice($username) {
  global $db;

  // need to redo this
  $query =
  "SELECT recipecart.cartID, SUM(table2.price)
  AS cartPrice FROM recipecart, (SELECT table1.recipeID, SUM(table1.totalPrice) AS price FROM
  (SELECT recipeingredient.ingredientID, recipeingredient.recipeID, recipeingredient.quantity * ingredient.price AS totalPrice FROM recipeingredient, ingredient WHERE ingredient.ingredientID = recipeingredient.ingredientID)
  AS table1 GROUP BY recipeID) AS table2 WHERE table2.recipeID = recipecart.recipeID GROUP BY cartID";

  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  var_dump($result);
  return $result['totalPrice'];
}

 ?>
