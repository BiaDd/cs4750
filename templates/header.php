
<?php

$authenticated = false;

if (isset($_SESSION['authenticated'])) {
  $authenticated = true;
}
?>


<header id="home">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom border-primary">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarItems"
                aria-controls="navbarItems" aria-expanded="false" aria-label="Navigation Toggler">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarItems">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($authenticated) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                          </svg>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if (!$authenticated) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/login.php">
                            Login
                        </a>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal
    I referenced the Bootstrap modal tutorial for this Modal
    -->
</header>
