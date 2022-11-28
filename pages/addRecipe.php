<?php
session_start();
require("../connect-db.php");      // include("connect-db.php");
require("../db-controller.php");

$username = $_SESSION['username'];
$ingredients_used = array();
$ingredients = getAllIngredients();
?>

<!--
Used some of the code from
https://www.w3schools.com/howto/howto_js_form_steps.asp

#https://makitweb.com/get-checked-checkboxes-value-with-php/
-->


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction'] && $_POST['btnAction'] == 'Add') ) {
    #echo $_POST['rname'];
    #echo "\n";
    #echo $_POST['rdescription'];
    #echo "\n";
    if (!empty($_POST['recipe_ingredients'])) {
      foreach($_POST['recipe_ingredients'] as $key=>$value){
          if ($value == '0' || !is_numeric($value)) {
            unset($_POST['recipe_ingredients'][$key]);
          }
      }
      // foreach($_POST['recipe_ingredients'] as $key=>$value){
      //     echo $key.": Quantity ".$value.'<br/>';
      // }
    }
    addRecipe($_POST['rname'], $_POST['rdescription'], $_POST['recipe_ingredients']);
    // set the recipe in the db and redirect to recipe page
    // tbh the checkbox doesn't do anything

    // redirect to page of recipe
    header("Location: recipe.php");
    exit;
    // stuff
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

    <link rel="stylesheet" href="../styles/add_recipe.css" />

    <title>Recipen - Add Recipe </title>
  </head>
  <?php include('../templates/header.php') ?>
  <body>

    <div class="card">
      <div class="card-body">

        <form action="addRecipe.php" method="post">

          <h1>Add Recipe:</h1>
          <!-- One "tab" for each step in the form: -->
          <div class="tab">Name:
            <p><input placeholder="Recipe name..." name="rname" id="rname"></p>
          </div>
          <div class="tab">Recipe Instructions:
            <p><input name="rdescription" id="rdescription"></p>
          </div>
          <div class="tab">Ingredients:
            <!--
            Probably make several dropdown lists that shows different types of ingredients
            then can show different measurements
            for each list of ingredients
            Generate 2 side by side input boxes, one for checkboxes, one for quantity
            -->
            <div class="accordion" id="accordionExample">
              <?php foreach ($ingredients as $category => $ingredient_list): ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="<?php echo $category;?>Heading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $category;?>Collapse" aria-expanded="true" aria-controls="<?php echo $category;?>Collapse">
                      <?php echo $category;?>
                    </button>
                  </h2>
                  <div id="<?php echo $category;?>Collapse" class="accordion-collapse collapse " aria-labelledby="<?php echo $category;?>Heading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <?php foreach ($ingredient_list as $ingredient_name): ?>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" name='recipe_ingredients[]' id="<?php echo $ingredient_name;?>">
                          <label class="form-check-label" for="<?php echo $ingredient_name;?>"><?php echo $ingredient_name;?></label>
                        </div>
                        <input type="number" id="quantity" name='recipe_ingredients[<?php echo $ingredient_name;?>]' min="0" max="5" value="0" style="width:50px;margin-left: 15px;"> Grams
                        <br />
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div style="overflow:auto;">
            <div style="float:right;">
              <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
              <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
              <input name='btnAction' type="submit" id="submitBtn" class="btn btn-primary" value="Add" title="Add a friend"></input>
            </div>
          </div>
          <!-- Circles which indicates the steps of the form: -->
          <div style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
          </div>
        </form>

      </div>
    </div>
    <script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
      // This function will display the specified tab of the form...
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      //... and fix the Previous/Next buttons:
      if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
      } else {
        document.getElementById("prevBtn").style.display = "inline";
      }
      if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "inline";
      } else {
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("nextBtn").innerHTML = "Next";
        document.getElementById("submitBtn").style.display = "none";
      }
      //... and run a function that will display the correct step indicator:
      fixStepIndicator(n)
    }

    function nextPrev(n) {
      // This function will figure out which tab to display
      var x = document.getElementsByClassName("tab");
      // Exit the function if any field in the current tab is invalid:
      if (n == 1 && !validateForm()) return false;
      // Hide the current tab:
      x[currentTab].style.display = "none";
      // Increase or decrease the current tab by 1:
      currentTab = currentTab + n;
      // if you have reached the end of the form...
      if (currentTab >= x.length) {
        // ... the form gets submitted:
        document.getElementById("regForm").submit();
        return false;
      }
      // Otherwise, display the correct tab:
      showTab(currentTab);
    }

    function validateForm() {
      // This function deals with validation of the form fields
      var x, y, i, valid = true;
      x = document.getElementsByClassName("tab");
      y = x[currentTab].getElementsByTagName("input");
      // A loop that checks every input field in the current tab:
      for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
          // add an "invalid" class to the field:
          y[i].className += " invalid";
          // and set the current valid status to false
          valid = false;
        }
      }
      // If the valid status is true, mark the step as finished and valid:
      if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
      }
      return valid; // return the valid status
    }

    function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName("step");
      for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
      }
      //... and adds the "active" class on the current step:
      x[n].className += " active";
    }
    </script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
  </body>
  <?php include('../templates/footer.html') ?>
</html>
