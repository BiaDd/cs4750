<!--

Shows recipes, reviews, and ingredients
If the user is the owner of the recipe, they can edit the recipe

-->

<?php
$res = [];
session_start();
require("../connect-db.php");      // include("connect-db.php");
require("../db-controller.php");

if (!isset($_SESSION['authenticated'])) {
	header("Location: login.php");
	exit;
}

$name = $_SESSION['username'];
$con=mysqli_connect("localhost","root","","recipen");

$list_of_recipes = getAllRecipes();
$recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(!empty($_POST['goToRecipe'])){
          $_SESSION['recipeID'] = $_POST['recipe_to_load'];
          header("Location: recipe.php");
      }
      if(!empty($_POST['addToCart'])){
        $recipeID = $_POST['recipe_to_use'];
        addRecipeToCart($_SESSION['uid'], $recipeID);
        $list_of_recipes = getAllRecipes();
        $recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
      }
      if(!empty($_POST['removeFromCart'])){
        $recipeID = $_POST['recipe_to_use'];
        removeRecipeFromCart($_SESSION['uid'], $recipeID);
        $list_of_recipes = getAllRecipes();
        $recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Recipen - Profile</title>
  </head>
  <?php include('../templates/header.php') ?>
  <body>
    <div class="m-3">
      <h3>Search for Recipes</h3>
    <div>
      <form action="search.php" method="post">
        <div class="py-2 row">
          <div class="input-group col">
              <input type="text" class="form-control" id="name" name="name" placeholder="Search by name or description"/>
              <button id="search" name="searchName" type="submit" value="Search" class="btn btn-primary">Search
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
              </button>
          </div>
          <div class="input-group col">
              <input type="text" class="form-control" id="name" name="price" placeholder="Filter by max price"/>
              <button id="search" name="filterPrice" type="submit" value="Search" class="btn btn-primary">Filter</button>
          </div>
          <div class="input-group col">
              <input type="text" class="form-control" id="name" name="rating" placeholder="Filter by min rating"/>
              <button id="search" name="filterRating" type="submit" value="Search" class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>
    </div>

    <div class="mt-3 mb-2">
      <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          if(isset($_POST['searchName'])){
            $key = mysqli_real_escape_string($con, $_POST['name']);
            echo "<h5>Search Results for '".$key."'</h5>";
            $sql="SELECT * FROM recipe WHERE recipeName LIKE '%$key%' OR description LIKE '%$key%'";
            $res = mysqli_query($con, $sql);
            $list_of_recipes = $res;
          }
          if(isset($_POST['filterPrice'])){
            $key = mysqli_real_escape_string($con, $_POST['price']);
            var_dump($key);
            echo "<h5>Search Results for price less than $".$key."</h5>";
            $sql="SELECT * FROM recipe WHERE price < $key";
            $res = mysqli_query($con, $sql);
            $list_of_recipes = $res;
          }
          if(isset($_POST['filterRating'])){
            $key = mysqli_real_escape_string($con, $_POST['rating']);
            echo "<h5>Search Results for rating greater than ".$key."</h5>";
            $sql="SELECT * FROM recipe WHERE rating >= $key";
            $res = mysqli_query($con, $sql);
            $list_of_recipes = $res;
          }
        }
      ?>
    </div>

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
						<form action="search.php" method="POST" class="align-middle mb-0">
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
						<form action="search.php" method="POST" class="mb-0">
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

    <h3 class='text-center'>Featured Recipes</h3>
    <div class="row row-cols-1 row-cols-md-2 g-4 mt-2" style="margin: 0px">
        <div class="col d-flex justify-content-center">
            <div class="card w-75 text-center centerCard">
                <a href="?command=userpage"><img src="../images/fries.jpg" class="card-img-top"
                        alt="Go to profile feature, rabbit picture" /></a>
                <br />
                <div class="card-body m-1">
                    <p class="card-title fw-bold">Cool french fries</p>
                    <p class="card-text" style="display:none;">
                      Morbi suscipit pellentesque dolor ac eleifend. In interdum nisi nulla, in mattis urna posuere eu.
                      Fusce eget nunc tempus mauris lacinia vehicula. Nulla tincidunt erat at finibus sagittis.
                      Nam id leo eget velit iaculis pharetra quis ac nulla. Quisque volutpat lectus consectetur lectus scelerisque elementum ac vel nulla.
                      Maecenas malesuada dui dictum nisl eleifend sodales. Cras justo orci, eleifend ac erat ac, dictum vehicula nibh.
                      In placerat eu velit ac dictum. Maecenas in porttitor leo.
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>

        <div class="col d-flex justify-content-center">
            <div class="card w-75 text-center centerCard">
                <a href="#"><img src="../images/pizza.jpg" class="card-img-top"
                        alt="Go to blog feature, cat with hairnet image" /></a>
                <br />

                <div class="card-body m-1">
                    <p class="card-title fw-bold">Pizza Party</p>
                    <p class="card-text" style="display:none;">
                        Aliquam erat volutpat. Phasellus non lobortis augue. Ut tincidunt scelerisque est id tincidunt. Fusce in nisl condimentum, condimentum massa vel, consequat nulla.
                        Duis diam eros, scelerisque in tristique eu, semper non erat. Nulla pharetra ac nulla vel consectetur. Quisque pharetra ex vitae odio rhoncus sollicitudin. Vivamus scelerisque non risus non vestibulum.
                        Cras interdum aliquam gravida. Praesent dapibus blandit ultrices. Sed feugiat rutrum luctus.
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
      // hover effect to display card text
      $(document).ready(function() {

        $('.centerCard').hover(
          function () {
            $(".card-text", this).show();
          },
          function () {
            $(".card-text", this).hide(); // hide card after hover
          }
        );

      });
    </script>



    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
  </body>
  <?php include('../templates/footer.html') ?>
</html>
