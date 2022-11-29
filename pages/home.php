<!--

User home page

-->

<?php
session_start();
require("../connect-db.php");      // include("connect-db.php");
require("../db-controller.php");

if (!isset($_SESSION['authenticated'])) {
	header("Location: login.php");
	exit;
}

$name = $_SESSION['username'];
$list_of_recipes = getAllRecipesForUser($_SESSION['uid']);
$recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['goToRecipe'])){
				$_SESSION['recipeID'] = $_POST['recipe_to_load'];
				header("Location: recipe.php");
    }
		if(!empty($_POST['addToCart'])){
			$recipeID = $_POST['recipe_to_use'];
			addRecipeToCart($_SESSION['uid'], $recipeID);
			$list_of_recipes = getAllRecipesForUser($_SESSION['uid']);
			$recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
		}
		if(!empty($_POST['removeFromCart'])){
			$recipeID = $_POST['recipe_to_use'];
			removeRecipeFromCart($_SESSION['uid'], $recipeID);
			$list_of_recipes = getAllRecipesForUser($_SESSION['uid']);
			$recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
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

    <title>Recipen - Homepage</title>
  </head>
  <?php include('../templates/header.php') ?>
  <body>
    <?php
      echo "<h3 class='text-center mt-2'>Hello Chef $name!</h3>";
    ?>

    <div class="m-3">
      <h4>Your Recipes <a href="addRecipe.php" class="btn btn-success">Add Recipe</a> </h4>
      <div class="list-group">
			<table class="w3-table table shadow w3-bordered w3-card-4 center" style="width:70%">
      <thead>
				<tr style="background-color:#000000; color:#ffffff">
					<th width="25%">Name</th>        
					<th width="40%">Description</th>    
					<th width="10%">Rating</th>
					<th width="10%">Price</th>
					<th width="15%">Cart</th>
				</tr>
			</thead>  
			<?php foreach ($list_of_recipes as $myrecipe_info): ?>
			<tr class="">
          <td>
						<form action="home.php" method="POST" class="align-middle">
								<input type="submit" name="goToRecipe" value="<?php echo $myrecipe_info['recipeName']; ?>" class="btn p-0 text-capitalize"
								title="<?php echo $myrecipe_info['recipeID']; ?>"/>
								<input type="hidden" name="recipe_to_load"
								value="<?php echo $myrecipe_info['recipeID']; ?>"/>
						</form>
					</td>
          <td><?php echo $myrecipe_info['description']; ?></td>
					<td><?php echo $myrecipe_info['rating']; ?></td>
					<td>$<?php echo $myrecipe_info['price']; ?></td>
					<td>
						<form action="home.php" method="POST">
							<?php if(in_array($myrecipe_info['recipeID'], $recipes_in_cart)): ?>
								<input type="submit" name="removeFromCart" value="Remove from Cart" class="btn btn-sm btn-danger"
								title="Remove recipe from cart"/>
							<?php else : ?>
								<input type="submit" name="addToCart" value="Add to Cart" class="btn btn-sm btn-primary"
								title="Add recipe to cart"/>
							<?php endif; ?>
								<input type="hidden" name="recipe_to_use"
								value="<?php echo $myrecipe_info['recipeID']; ?>"/>
						</form>
					</td>
			</tr>
      <?php endforeach; ?>
			</table>
      </div>

    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
  </body>
  <?php include('../templates/footer.html') ?>
</html>
