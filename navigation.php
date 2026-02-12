<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        <?php include 'styles/navigation.css' ?>
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body>
    
    <header class="header">
          <div class="hamburger-menu" onclick="menu_open()">
            <img src="images/hamb-menu.png" alt="" style="width: 32px" />
          </div>
    
          <div class="logo">
            <a href="home.php"><img src="images/logo.jpg" alt="" /></a>
          </div>

          <navigation class="links" id="navigation_links">
            <form class="header-search" method="get" action="search.php">
              <input type="search" name="q" placeholder="Search parts..." aria-label="Search components">
              <button type="submit">Search</button>
            </form>
            <a href="components.php">COMPONENTS</a>
            <a href="contact.php">CONTACT</a>
            <a href="about_us.php">ABOUT US</a>
          </navigation>
    
          <div class="kart">  
            <a class="active" href="dashboard.php" >
                <img src="images/user.png" alt="" style="width: 32px"/>
            </a>
            
            <a class="active" href="cart.php"
              ><img src="images/cart.png" alt="" style="width: 32px"/>
            </a>
          </div>
    </header>
    
    <script>
        <?php include 'script/navigation.js' ?>
    </script>
</body>
</html>