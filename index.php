<!DOCTYPE html>

<!--
*  REFERENCES
*  Title: Modal
*  Author: Bootstrap Team
*  Date: 11/23/2021
*  Code version: Bootstrapv5.0
*  URL: https://getbootstrap.com/docs/5.0/components/modal/
*  Software License: MIT license
-->

<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="organizer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Recipen - Home</title>
</head>

<body>

    <!-- CARDS -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3" style="margin: 0px">
        <div class="col d-flex justify-content-center">
            <div class="card w-75 text-center centerCard">
                <a href="login.php"><img src="images/fries.jpg" class="card-img-top"
                        alt="" /></a>
                <br />
                <div class="card-body m-1">
                    <p class="card-title fw-bold">Find Recipes</p>
                    <p class="card-text" style="display:none;">
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>
        <div class="col d-flex justify-content-center">
            <div class="card w-75 text-center centerCard">
                <a href="login.php"><img src="images/salmon.jpg" class="card-img-top"
                        alt="" /></a>
                <br />
                <div class="card-body m-1">
                    <p class="card-title fw-bold">Order Recipes</p>
                    <p class="card-text" style="display:none;">
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>
        <div class="col d-flex justify-content-center">
            <div class="card w-75 text-center centerCard">
                <a href="login.php"><img src="images/fries.jpg" class="card-img-top"
                        alt="" /></a>
                <br />

                <div class="card-body m-1">
                    <p class="card-title fw-bold">Share Recipes</p>
                    <p class="card-text" style="display:none;">
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"></small>
                </div>
            </div>
        </div>
    </div>


    <?php include('footer.html') ?>


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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
        integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"
        async></script>
</body>

</html>
