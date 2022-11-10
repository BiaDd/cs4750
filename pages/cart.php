<?php
require("../connect-db.php");
require("../db-controller.php");
session_start();
$list_of_recipes = getCart($_SESSION['username']);
$cart_price = getCartPrice($_SESSION['username']);

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
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>Your Cart $<?php echo $cart_price ?></h1>

            </div>
            <div class="row justify-content-center">

            </div>
            <hr></hr>
            <div class="row mt-2 justify-content-center">

                <div class="col-4">
                    <h3>Your Recipes</h3>
                    <table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
                        <thead>
                            <tr style="background-color:#B0B0B0">
                              <th width="33%">Recipe Name
                              <th width="33%">Price
                              <th width="33%">Delete
                            </tr>
                        </thead>
                    <?php foreach ($list_of_recipes as $r): ?>
                      <tr>
                        <td><?php echo $r['recipeName']; ?></td>
                        <td><?php echo $r['price']; ?></td>
                        <td>
                          <form action="cart.php" method="post">
                            <input type ="submit" name="btnAction" value="Delete" class="btn btn-primary" title="click to remove recipe"/>
                            <input type="hidden" name="friend_to_remove"
                            value="<?php echo $r['recipeName'];?>"
                            />
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    </table>
              </div>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>
