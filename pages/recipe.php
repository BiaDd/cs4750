<?php
session_start();
require("../connect-db.php");
require("../db-controller.php");

$userID = $_SESSION['uid'];
$recipe_info = getRecipe($_SESSION['recipeID']);
$ingredients = getRecipeIngredients($_SESSION['recipeID']);
$is_user_owner = isRecipeOwner($userID, $_SESSION['recipeID']);
$recipes_in_cart = getRecipesInCartArray($_SESSION['uid']);
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  if (!empty($_POST['delete']))
  {
    if($is_user_owner == true)
    {
        deleteRecipe($_SESSION['recipeID']);
        header("Location: home.php");
        exit;
    }
  }
  if(!empty($_POST['addToCart'])){
    $recipeID = $_POST['recipe_to_use'];
    addRecipeToCart($_SESSION['uid'], $recipeID);
    $recipes_in_cart = getRecipesInCartArray($userID);
  }
  if(!empty($_POST['removeFromCart'])){
    $recipeID = $_POST['recipe_to_use'];
    removeRecipeFromCart($_SESSION['uid'], $recipeID);
    $recipes_in_cart = getRecipesInCartArray($userID);
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


    <title>Recipen - Recipe </title>
  </head>
  <?php include('../templates/header.php') ?>
  <body>

    <div class="card">
      <div class="card-body">
          <h3 class="text-capitalize"><?php echo $recipe_info['recipeName']?></h3>
          <div class="overflow-y">
            <p><?php echo $recipe_info['description']?></p>
          </div>

          <form action="recipe.php" method="post">
            <?php if(in_array($_SESSION['recipeID'], $recipes_in_cart)): ?>
            <input type="submit" name="removeFromCart" value="Remove from Cart" class="btn btn-sm btn-danger"
            title="Remove recipe from cart"/>
            <?php else : ?>
            <input type="submit" name="addToCart" value="Add to Cart" class="btn btn-sm btn-primary"
            title="Add recipe to cart"/>
            <?php endif; ?>
            <input type="hidden" name="recipe_to_use"
            value="<?php echo $_SESSION['recipeID'] ?>"/>
            
            <a href="#" class="btn btn-sm btn-warning" role="button"
                data-bs-toggle="modal" data-bs-target="#ratingModal">
                Rate
            </a>
            <a href="#" class="btn btn-sm btn-success" role="button"
                data-bs-toggle="modal" data-bs-target="#reviewModal">
                Review
            </a>
            <?php if ($is_user_owner): ?>
            <a href="#" class="btn btn-sm btn-danger" role="button"
                data-bs-toggle="modal" data-bs-target="#deleteModal">
                Delete
            </a>
            <?php endif; ?>
          </form>

          <div class="d-flex">
              <div class="p-2" style="width: 40%">
                  <h4>Ingredients</h4>
                  <table class="w3-table table shadow w3-bordered w3-card-4 center" style="width:70%">
                      <thead>
                          <tr style="background-color:#000000; color:#ffffff">
                            <th width="50%">Name</th>
                            <th width="50%">Quantity</th>
                          </tr>
                      </thead>
                  <?php foreach ($ingredients as $recipe_ingredients): ?>
                    <tr>
                      <td><?php echo $recipe_ingredients['ingredientName']; ?></td>
                      <td><?php echo $recipe_ingredients['quantity']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                  </table>
            </div>
          </div>

          <!-- bad way to do this, but i don't know how to make the stuff change depending
            on which button is clicked
          -->
          <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <p class="modal-title fw-bold" id="ratingModalLabel">
                              Rate <?php echo $recipe_info['recipeName']?> recipe
                          </p>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="recipe.php" method="POST">
                        <div class="modal-body">
                          <input type="number" id="rating" name='rating' min="1" max="5" value="1" style="width:50px;margin-left: 15px;">
                        </div>
                        <div class="modal-footer">
                          <input type ="submit" name="rate" value="Rate" class="btn btn-primary" title="Rate recipe"/>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                              Close
                          </button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>


          <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <p class="modal-title fw-bold" id="reviewModalLabel">
                              Write a review
                          </p>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="recipe.php" method="post">
                        <div class="modal-body">
                          <input type="text" id="review" name='review' style="width:100%">
                        </div>
                        <div class="modal-footer">
                          <input type ="submit" name="review" value="Review" class="btn btn-primary" title="Review the recipe"/>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                              Close
                          </button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>

          <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <p class="modal-title fw-bold" id="deleteModalLabel">
                              Are you sure you want to delete this recipe?
                          </p>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="recipe.php" method="post">
                        <div class="modal-footer">
                          <input type ="submit" name="delete" value="Delete" class="btn btn-danger" title="Delete the recipe"/>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                              Close
                          </button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>

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
