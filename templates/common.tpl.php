<?php declare(strict_types = 1);?>

<?php function drawHeader(Session $session) { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEALS on WHEELS</title> 
    <link href="../css/style.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script src = "../javascript/cart.js" async> </script>
    <script src = "../javascript/favoriteRestaurant.js" async> </script>
    <script src = "../javascript/searchByCategory.js" async> </script>
    <script src = "../javascript/searchFavorites.js" async> </script>
    <script src = "../javascript/removeDish.js" async> </script>
    <script src = "../javascript/favoriteDish.js" async> </script>
    <script src = "../javascript/cartPurchase.js" async> </script>
    <script src = "../javascript/search.js"async> </script>
</head>
<body>
    <header>
        
    <a href = "/">
        <h1>MEALS on WHEELS</h1>
    </a>
    <?php if($session->isLoggedIn() && $_SERVER['REQUEST_URI'] === '/pages')     { ?>            
        <div class="search-box">
            <button  class="btn-search"><i class="fas fa-search"></i></button>
            <input type="text" id = "searchBox" onclick="openSearchNav()" class="input-search" placeholder="Type to Search...">
        </div>
    <?php } ?>
    
    <?php
        if($session->isLoggedIn()){
            drawEditProfileButton();
            drawCartButton();
            drawLogoutForm();
        }
        else drawLoginForm();
    ?>
    </header>
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>        
    <main>
    <?php
        if($session->isLoggedIn()){
            drawCartSideNav();
            drawSearchTypeNav();
            if(($_SERVER['REQUEST_URI'] === '/pages')){
                drawCategoriesMenu(); 
            } 
        }
    ?>
<?php } ?>

<?php function drawFooter() { ?>
    </main>
    
    <footer>
        Meals on Wheels, 2022
    </footer>
</body>
</html>
<?php } ?>

<?php function drawLoginForm() { ?>
    <form action = "../actions/actionLogin.php" method = "post" class = "login">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type = "email" name = "email" placeholder = "Email">
        <input type = "password" name = "password" placeholder = "Password">
        <button type = "submit" class="fa-solid fa-arrow-right-to-bracket arrowLogin"></button> 
    </form>
    <a href = '../pages/register.php' class = "registerMainMenu">Register</a>
<?php } ?> 

<?php function drawLogoutForm() { ?>
    <a class = "LogOutButton" href = "../actions/actionLogout.php">Logout</a>
<?php }?>

<?php function drawRegisterForm() { ?>
    <form action = "../actions/actionRegister.php" method = "post" id = "register">
        <h1>Register</h1>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type = "text" placeholder = "Enter name" id = "nameReg" name = "name" required>
        <input type = "email" placeholder = "Enter email" id = "emailReg" name = "email" required>
        <input type = "password" placeholder = "Enter password" id = "passReg" name = "password" required>
        <button type = "submit" id= regButton name = "register">Register</button>
    </form>    
<?php } ?>

<?php function drawCartButton() { ?>
    <button onclick="openCartSideNav()"  class = "fa fa-shopping-cart" id ="faShoppingCart"></button>
<?php } ?>

<?php function drawCartSideNav() { ?>
    <div  id = "cartSideNav" class="sideNav">
        <a href="javascript:void(0)" class="closeButton" onclick="closeCartSideNav()">&times;</a>
        <h2 class="sectionHeader">CART</h2>
        <div class = "cartRowHeader">
            <span class="cartItem cartHeader cartColumn">ITEM</span>
            <span class="cartPrice cartHeader cartColumn">PRICE</span>
            <span class="cartQuantity cartHeader cartColumn">QUANTITY</span>
        </div>
        <div class = "cartItems"></div>
        <div class = "cartTotal">
            <h2 class = "cartTotalTitle">TOTAL:</h2>
            <span class="cartTotalPrice">0€</span>
        </div>
        <button class = "purchaseButton">Purchase</button>
    </div>
<?php } ?>

<?php function drawSearchTypeNav() { ?>
    <div  class = "searchSideNav" >
        <select id = "searchType" name = "searchType" multiple>
            <option selected="selected" value = "RestaurantName">Restaurant Name</option>
            <option value = "DishName">Dish Name</option>
            <option value = "Score">Score</option>
        </select>
        <a href="javascript:void(0)" class="closeSearchNavButton" onclick="closeSearchNav()">&times;</a> 
    </div>
<?php } ?>

<?php function drawEditProfileButton() { ?>
    <form action = "../pages/editProfile.php">
        <button type = "submit" class='fa-regular fa-user-circle-o' id = "profileButton"></button>
    </form>
<?php } ?>

<?php function drawCategoriesMenu() { ?>
    <section class = "categoriesMenu">
        <a href = "#" class = "categoryButton" id = "categoryPizza">Pizza</a>
        <a href = "#" class = "categoryButton" id = "categorySushi">Sushi</a>
        <a href = "#" class = "categoryButton" id = "categoryFastFood">Fast Food</a>
        <a href = "#" class = "categoryButton" id = "categoryItalian">Italian</a>
        <a href = "#" class = "categoryButton" id = "categoryChinese">Chinese</a>
        <a href = "#" class = "categoryButton" id = "categoryTraditional">Traditional</a>
        <a href = "#" class = "favoriteButton" id = "categoryFavorites">Favorites</a>
    </section>        
<?php } ?> 

<?php function drawEmptySectionReviews() { ?>
    <section class = "emptySection">There are no reviews yet</section>
<?php } ?>

<?php function drawEmptySectionDishes() { ?>
    <section class = "emptySection">There are no dishes yet</section>
<?php } ?>

