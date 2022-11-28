<?php
require("../connect-db.php");
require("../db-controller.php");
session_start();

$recipes_in_cart = getRecipesInCart($_SESSION['uid']);
$cart_price = getCartPrice($_SESSION['uid']);
$ingredients_in_cart = getIngredientsInCart($_SESSION['uid']);

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Delete') {
    #echo "delete";
    deleteRecipe($_POST['recipeName']);
    $list_of_recipes = getCart($_SESSION['username']);
    $cart_price = getCartPrice($_SESSION['username']);
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
        <title>Cart</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    </head>
    
    <?php include('../templates/header.php') ?>
    
    <body>
      <div style="width: 100%" class="m-3">
        <h3 class="mb-4">Your Grocery Cart</h3>

        <h4>Cart Price: $<?php echo $cart_price; ?></h4>
        
        <div class="row">
          <div style="width:60%; float:left;">
            <h4 class="mt-2">Ingredients</h4>
            <table class="w3-table table shadow w3-bordered w3-card-4 center">
              <thead>
                <tr style="background-color:#000000; color:#ffffff">
                  <th width="30%">Name</th>        
                  <th width="30%">Type</th>
                  <th width="20%">Quantity</th>
                  <th width="20%">Total Price</th>
                </tr>
              </thead>  
              <?php foreach ($ingredients_in_cart as $ingredient_info): ?>
              <tr class="">
                  <td><?php echo $ingredient_info['ingredientName']; ?></td>
                  <td><?php echo $ingredient_info['ingredientType']; ?></td>
                  <td><?php echo $ingredient_info['quantity']; ?></td>
                  <td>$<?php echo $ingredient_info['price']; ?></td>
              </tr>
              <?php endforeach; ?>
            </table>
          </div>
          
          <div style="width: 30%; float:left;">
            <h4 class="mt-2">Recipes</h4>
            <table class="w3-table table shadow w3-bordered w3-card-4 center">
              <thead>
                <tr style="background-color:#000000; color:#ffffff">
                  <th width="70%">Name</th>
                  <th width="30%">Price</th>
                </tr>
              </thead>  
              <?php foreach ($recipes_in_cart as $myrecipe_info): ?>
              <tr class="">
                  <td>
                    <form action="home.php" method="POST" class="align-middle">
                        <input type="submit" name="goToRecipe" value="<?php echo $myrecipe_info['recipeName']; ?>" class="btn p-0 text-capitalize"
                        title="<?php echo $myrecipe_info['recipeID']; ?>"/>
                        <input type="hidden" name="recipe_to_load"
                        value="<?php echo $myrecipe_info['recipeID']; ?>"/>
                    </form>
                  </td>
                  <td>$<?php echo $myrecipe_info['price']; ?></td>
              </tr>
              <?php endforeach; ?>
              </table>
          </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>

    <?php include('../templates/footer.html') ?>
</html>
