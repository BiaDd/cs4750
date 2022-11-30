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
    } else if (!empty($user)) { // If there is a user:
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
      $_SESSION['logged_in'] = True;

      return;
    }
  }
  catch (PDOException $e){
    echo 'Error signing up';
  }
}

function getUser($userID) {
  global $db;
  $query = "SELECT * FROM user WHERE userID=$userID";

  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  return $result;

}

function setUser($userID, $username, $firstname, $lastname) {
  global $db;
  $query = "UPDATE `user` SET username=:username, firstName=:firstName, lastName=:lastName WHERE userID=:userID";

  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':firstName', $firstname);
  $statement->bindValue(':lastName', $lastname);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $statement->closeCursor();
  return;

}


function getEmails($userID) {
  global $db;
  $query = "SELECT * FROM email WHERE userID=$userID";

  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $statement->closeCursor();
  return $result;

}


function getReviews($recipeID) {
  global $db;
  $query = "SELECT * FROM review WHERE recipeID=$recipeID";

  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $statement->closeCursor();
  return $result;


}


function getIngredientsInCart($userID) {
  global $db;

  $query =
  "SELECT table1.ingredientID, table1.ingredientName, table1.ingredientType, SUM(table1.quantity) AS quantity, SUM(table1.totalPrice) AS price
  FROM
  (SELECT recipeingredient.ingredientID, recipeingredient.recipeID, ingredient.ingredientName, ingredient.ingredientType, recipeingredient.quantity, recipeingredient.quantity * ingredient.price AS totalPrice
  FROM ingredient, recipeingredient,
   (SELECT recipeID FROM recipecart WHERE cartID=:userID
   ) AS userrecipes
  WHERE recipeingredient.recipeID = userrecipes.recipeID AND ingredient.ingredientID = recipeingredient.ingredientID)
  AS table1 GROUP BY ingredientID";

  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $result = $statement->fetchAll();
  $statement->closeCursor();
  return $result;
}




function getRecipeIngredients($recipe_id) {
  global $db;
  $query = "SELECT ingredientName, quantity FROM ingredient NATURAL JOIN recipeingredient WHERE recipeID=:recipeID";
  $statement = $db->prepare($query);
  $statement->bindValue(':recipeID', $recipe_id);
  $statement->execute();
  $result = $statement->fetchAll();

  return $result;

}

function getAllIngredients() {
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

function addEmail($emailAddress, $userID){
  global $db;
  $insertEmail = "INSERT INTO email (emailAddress, userID) VALUES (:emailAddress, :userID)";
  $insert = $db->prepare($insertEmail);
  $insert->bindValue(':emailAddress', $emailAddress);
  $insert->bindValue(':userID', $userID);
  $insert->execute();

  $insert->closeCursor();
  $emailID = $db->lastInsertId();
  $_SESSION["emailID"] = $emailID;

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
  $_SESSION["recipeID"] = $recipeID;

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
  FROM
    (SELECT recipeingredient.ingredientID, recipeingredient.recipeID, recipeingredient.quantity * ingredient.price AS totalPrice
     FROM recipeingredient, ingredient, recipe
     WHERE ingredient.ingredientID = recipeingredient.ingredientID
    AND recipe.recipeID = recipeingredient.recipeID
    AND recipe.recipeID = $recipeID) AS table1
    GROUP BY recipeID;";
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

function getRecipe($recipeID) {
  global $db;
  $query = "SELECT * FROM recipe WHERE recipeID=:recipeID";
  $statement = $db->prepare($query);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();

  return $result;
}


function getCartPrice($userID) {
  global $db;

  $query =
  "SELECT recipecart.cartID, SUM(table2.price) AS cartPrice
  FROM recipecart,
    (SELECT table1.recipeID, SUM(table1.totalPrice) AS price
    FROM
      (SELECT recipeingredient.ingredientID, recipeingredient.recipeID, recipeingredient.quantity * ingredient.price AS totalPrice
      FROM recipeingredient, ingredient
      WHERE ingredient.ingredientID = recipeingredient.ingredientID)
      AS table1 GROUP BY recipeID)
    AS table2
  WHERE table2.recipeID = recipecart.recipeID AND recipecart.cartID=:userID
  GROUP BY cartID";

  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  if (!empty($result)) {
      return $result['cartPrice'];
  }
  else {
     return 0.00;
  }
}


function isRecipeOwner($userID, $recipeID) {
  global $db;
  $query = "SELECT * FROM recipe WHERE recipeID=$recipeID AND userID=$userID";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();
  $statement->closeCursor();
  //var_dump($result);
  return $result;

}

function deleteRecipe($recipeID) {
  global $db;

  // need to delete all reviews related to recipe
  $query = "DELETE FROM review WHERE recipeID=:recipeID";
  $statement = $db->prepare($query);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $statement->closeCursor();

  //delete recipe from all carts
  $query = "DELETE FROM recipecart WHERE recipeID=:recipeID";
  $statement = $db->prepare($query);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $statement->closeCursor();

  //delete all ingredient associations
  $query = "DELETE FROM recipeingredient WHERE recipeID=:recipeID";
  $statement = $db->prepare($query);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $statement->closeCursor();

  //delete the recipe itself
  $delete_from_recipe = "DELETE FROM recipe WHERE recipeID=:recipeID";
  $statement = $db->prepare($delete_from_recipe);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $statement->closeCursor();
}

function getAllRecipesForUser($userID) {
  global $db;
  $query = "SELECT * FROM recipe WHERE userID=:userID";
  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $result = $statement->fetchAll(); //fetch() only gives you 1 row
  $statement->closeCursor();
  return $result;
}

function addRecipeToCart($userID, $recipeID) {
  global $db;

  //get cartID for this user
  $cartID = $userID;

  //add recipe to that cart
  $query = "INSERT INTO recipecart (cartID, recipeID) VALUES (:cartID, :recipeID)";
  $statement = $db->prepare($query);
  $statement->bindValue(':cartID', $cartID);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $result = $statement->fetchAll(); //fetch() only gives you 1 row
  $statement->closeCursor();
  return $result;
}

function getRecipesInCart($userID){
  global $db;
  $cartID = $userID;

  $query = "SELECT * FROM recipe INNER JOIN recipecart
  WHERE recipecart.recipeID = recipe.recipeID
  AND recipecart.cartID=:cartID";
  $statement = $db->prepare($query);
  $statement->bindValue(':cartID', $cartID);
  $statement->execute();
  $result = $statement->fetchAll(); //fetch() only gives you 1 row
  $statement->closeCursor();
  return $result;
}

function getRecipesInCartArray($userID){
  global $db;
  $cartID = $userID;

  $query = "SELECT recipeID FROM recipecart WHERE cartID=:cartID";
  $statement = $db->prepare($query);
  $statement->bindValue(':cartID', $cartID);
  $statement->execute();
  $result = $statement->fetchAll(); //fetch() only gives you 1 row
  $statement->closeCursor();

  $result_array = [];
  foreach($result as $row){
    array_push($result_array, $row['recipeID']);
  }
  return $result_array;
}

function removeRecipeFromCart($userID, $recipeID) {
  global $db;

  //get cartID for this user
  $cartID = $userID;

  //remove recipe from that cart
  $query = "DELETE FROM recipecart WHERE cartID=:cartID AND recipeID=:recipeID";
  $statement = $db->prepare($query);
  $statement->bindValue(':cartID', $cartID);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $statement->closeCursor();
}


function leaveReview($recipeID, $userID, $rating, $comment) {
  global $db;
  // can probably change this whole thing to a trigger but im dumb

  $check_for_review = "SELECT * FROM review WHERE recipeID=:recipeID AND userID=:userID";
  $statement = $db->prepare($check_for_review);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->bindValue(':userID', $userID);
  $statement->execute();
  $review = $statement->fetch();
  $statement->closeCursor();

  if (!empty($review)) {
    $update_review = "UPDATE review SET rating=:rating, text=:comment WHERE recipeID=:recipeID AND userID=:userID";
    $statement = $db->prepare($update_review);
    $statement->bindValue(':recipeID', $recipeID);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':rating', $rating);
    $statement->bindValue(':comment', $comment);
    $statement->execute();
    $statement->closeCursor();

  } else {
    $insert_review = "INSERT INTO review (recipeID, userID, rating, text) VALUES (:recipeID, :userID, :rating, :comment)";
    $statement = $db->prepare($insert_review);
    $statement->bindValue(':recipeID', $recipeID);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':rating', $rating);
    $statement->bindValue(':comment', $comment);
    $statement->execute();
    $statement->closeCursor();
  }

  $get_average_rating = "SELECT AVG(rating) AS avg_rating FROM review WHERE recipeID=:recipeID";
  $statement = $db->prepare($get_average_rating);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->execute();
  $average_rating = $statement->fetch()['avg_rating'];
  $statement->closeCursor();

  $set_rating = "UPDATE recipe SET rating=:rating WHERE recipeID=:recipeID";
  $statement = $db->prepare($set_rating);
  $statement->bindValue(':recipeID', $recipeID);
  $statement->bindValue(':rating', $average_rating);
  $statement->execute();
  $statement->closeCursor();

}

function getAllRecipes(){
  global $db;
  $query = "SELECT * FROM recipe";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  return $result;
}


 ?>
