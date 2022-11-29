<!DOCTYPE html>
<?php
session_start();
?>

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
    <link rel="stylesheet" href="styles.css">
    <title>Recipen - Home</title>
</head>

<body>

    <?php include('templates/header.php') ?>


    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/fries.jpg" class="" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Cool french fries</h5>
            <p>An easy recipe to make for friends</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/pizza.jpg" class="" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Pizza Party</h5>
            <p>No need to order takeout with this recipe</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="images/salmon.jpg" class="" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Fancy Salmon</h5>
            <p>The best way to impress a date</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <?php include('templates/footer.html') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
</body>

</html>
