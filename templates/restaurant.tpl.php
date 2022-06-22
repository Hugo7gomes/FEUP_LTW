<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/restaurant.class.php');
    require_once(__DIR__ .'/../templates/common.tpl.php');
?>

<?php function drawRestaurantsLogin(array $restaurants){ ?>
    <h2 class = "titleRestaurantLogin" >Restaurants</h2>
    <section id = "restaurants">
        <?php foreach($restaurants as $restaurant){ ?>
            <article class ="restaurant" id = <?=$restaurant->id?>>
                <div>
                    <a href = "../pages/restaurant.php?id=<?=$restaurant->id?>">
                        <img alt="Image restaurant <?=$restaurant->name?>" class = "restaurantImg" src = "https://picsum.photos/200?<?=$restaurant->id?>">
                    </a>    
                    <div class = "restaurantContent">
                        <div class = "restaurantName"><?=$restaurant->name?></div><br>
                        <div class = "ratingStar">
                            <div class = "restaurantRating"><?=$restaurant->rating?></div><br>
                            <button class='fa fa-star-o favoriteRestaurant'></button>
                        </div>
                    </div>
                </div>
            </article>
        <?php } ?>
    </section>
    <h2 class = "titleDishesLogin"></h2>
    <section id = "dishesFavorite"></section>
<?php } ?>

<?php function drawRestaurantsNotLogin(array $restaurants){ ?>
    <h2 class = "titleRestaurantNotLogin" >Restaurants</h2>
    <section id = "restaurants">
        <?php foreach($restaurants as $restaurant){ ?>
            <article class ="restaurantNotLogin">
                <img alt="Image restaurant <?=$restaurant->name?>" class = "restaurantImg" src = "https://picsum.photos/200?<?=$restaurant->id?>">
                <div class = "restaurantContent">
                    <div class = "restaurantName"><?=$restaurant->name?></div><br>
                    <div class = "restaurantRating"><?=$restaurant->rating?></div><br>
                    <i class='fa fa-star-o ' ></i>
                </div>
            </article>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawRestaurantsOwner(array $restaurants){ ?>
    <h2>Restaurants</h2>
    <section id = "restaurants">
        <?php foreach($restaurants as $restaurant){ ?>
            <article class ="restaurant" id = <?=$restaurant->id?>>
                <a href = "../pages/restaurantOwner.php?id=<?=$restaurant->id?>">
                    <img alt="Image restaurant <?=$restaurant->name?>" class = "restaurantImg" src = "https://picsum.photos/200?<?=$restaurant->id?>">
                    <div class = "restaurantContent">
                        <div class = "restaurantName"><?=$restaurant->name?></div><br>
                        <div class = "restaurantRating"><?=$restaurant->rating?></div><br>
                    </div>
                </a>
            </article>
        <?php } ?>
    </section>
<?php } ?>


<?php function drawRestaurant(Restaurant $restaurant, array $dishes ) { ?>
    <img alt="Main image restaurant <?=$restaurant->name?>" class = "imgPrincipal" src = "https://picsum.photos/200?<?=$dish->id?>">
    <div class = "restaurantMainPage" id = <?=$restaurant->id?>> 
        <h1><?=$restaurant->name?></h1>
        <div class = "pageRestaurantContent">
            <h3><?=$restaurant->address?></h3>
            <h3><?=$restaurant->categoryName?></h3>
            <h3><?=$restaurant->phoneNumber?></h3>
            <h2>Dishes</h2>
            <?php if(count($dishes) != 0) { ?>
            <section id = 'dishes'>
            <?php foreach ($dishes as $dish) { ?>
                <article class = 'dish' id = <?=$dish->id?> >
                    <img alt="Image dish <?=$dish->name?>" class = "dishImg" src = "https://picsum.photos/200?<?=$dish->id?>">
                    <div class = "dishContent">
                        <span class = "dishName"><?=$dish->name?></span>
                        <span class = "dishPrice"><?=$dish->price?>€</span>
                        <button class = "buttonFavoriteDish fa fa-star-o"></button>
                    </div>
                    <button class = "buttonAddItemCart fa-solid fa-circle-plus"></button>
                </article>    
            <?php } ?>
            </section>
            <?php }else{drawEmptySection();}?>        
<?php } ?>
            




<?php function drawReviews(array $reviews) { ?>
    <h2>Reviews</h2>
    <section id = 'reviews'>
        <?php foreach ($reviews as $review) { ?>
            <article class = "restaurantReview" id = <?=$review->id?>>
                <span class = "reviewUserName"><?=$review->userName?></span>
                <div class = "reviewContent">
                    <p class = "reviewText"><?=$review->comment?></p>
                    <div class = "reviewS">
                        <span class = "reviewScore"><?=$review->score?></span>
                        <i class='fa fa-star-o '></i>
                    </div>
                </div>
                <?php if ($review->answer != "") { ?> 
                    <p class = "reviewAnswer"><?=$review->answer?></p>
                <?php } ?>
            </article>
        <?php } ?>
    </section>
    </div>
    </div>
<?php } ?>

<?php function drawAddRestaurant () { ?>
    <form action = "../actions/actionAddRestaurant.php" method = "post" id = "createRestaurant">
        <h1>Create a new restaurant</h1>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type = "text" placeholder = "Name" id = "nameRestaurant" name = "name" >
        <input type = "tel" placeholder = "Phone Number" id = "phoneNumberRestaurant" name = "phoneNumber" pattern = "[0-9]{9}" >
        <input type = "email" placeholder = "Email" id = "emailRestaurant" name = "email" >
        
        <input type = "text" placeholder = "Address" id = "addressRestaurant" name = "address" >
        <select id = "categoryRestaurant" name = "category">
            <option value = "Pizza">Pizza</option>
            <option value = "Sushi">Sushi</option>
            <option value = "Fast Food">Fast Food</option>
            <option value = "Chinese">Chinese</option>
            <option value = "Italian">Italian</option>
            <option value = "Traditional">Traditional</option>
        </select>
        <button type = "submit" id = "addRestaurantSubmitButton"  name = "createRestaurant">Add Restaurant</button>
    </form>  
<?php } ?>

<?php function drawEditRestaurant($restaurant) { ?>
    <form action = "../actions/actionEditRestaurant.php?RestaurantId=<?=$restaurant->id?>" method = "post" id = "editRestaurant">
        <h1>Update Restaurant</h1>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type = "text" placeholder = "<?=$restaurant->name?>" id = "nameRestaurantUpdate" name = "name" >
        <input type = "tel" placeholder = "<?=$restaurant->phoneNumber?>" id = "phoneNumberRestaurantUpdate" name = "phoneNumber" pattern = "[0-9]{9}" >
        <input type = "text" placeholder = "<?=$restaurant->address?>" id = "addressRestaurantUpdate" name = "address" >
        <select  id = "categoryRestaurantUpdate" name = "category">
            <option value="" selected disabled hidden><?=$restaurant->categoryName?></option>
            <option value = "Pizza">Pizza</option>
            <option value = "Sushi">Sushi</option>
            <option value = "Fast Food">Fast Food</option>
            <option value = "Chinese">Chinese</option>
            <option value = "Italian">Italian</option>
            <option value = "Traditional">Traditional</option>
        </select>
        <button type = "submit" id = "editRestaurantSubmitButton" name = "updateProfile">Update Restaurant</button>
    </form>  
<?php } ?>

<?php function drawAddDish(int $restaurantId) { ?>
    <form action = "../actions/actionAddDish.php" method = "post" id = "createDish">
        <h1>Create a new dish</h1>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="hidden" id="id" name="restaurantId" value ="<?=$restaurantId?>">
        <input type = "text" placeholder = "Name" id = "nameDish" name = "name" required>
        <input type = "number" placeholder = "Price" id = "priceDish" name = "price" min = "1" required>
        <button type = "submit" id = "addDishSubmitButton"  name = "createDish">Add Dish</button>
    </form>  
<?php } ?>

<?php function drawRestaurantOwner(Restaurant $restaurant, array $dishes ) { ?>
    <img alt="Main image restaurant <?=$restaurant->name?>" class = "imgPrincipal" src = "https://picsum.photos/200?<?=$dish->id?>">
    <div class = "restaurantMainPage"> 
        <div class ="buttonsRestaurantOwner">
            <form action = "../pages/editRestaurant.php" method = "get">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <input type = "hidden" name = "RestaurantId" value = "<?=$restaurant->id?>" >
                    <button id = "buttonEditRestaurant">Edit Restaurant</button>
            </form>
            <form action = "../pages/showRestaurantOrders.php" method = "get">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <input type = "hidden" name = "RestaurantId" value = "<?=$restaurant->id?>" >
                    <button id = "buttonshowRestaurantOrders">View Orders</button>
            </form>
        </div>
        <h1><?=$restaurant->name?></h1>
        <div class = "pageRestaurantContent">
            <h3><?=$restaurant->address?></h3>
            <h3><?=$restaurant->categoryName?></h3>
            <h3><?=$restaurant->phoneNumber?></h3>      
            <h2>Dishes</h2>
            <?php if(count($dishes) != 0) {?>
            <section id = 'dishes'>
                <?php foreach ($dishes as $dish) { ?>
                <article class = 'dishOwner' id = <?=$dish->id?> >
                    <img class ='dishImgOwner' alt="Image dish <?=$dish->name?>" src = "https://picsum.photos/200?<?=$dish->id?>">
                    <div class = "dishContent">
                        <span class = "dishName"><?=$dish->name?></span>
                        <span class = "dishPrice"><?=$dish->price?>€</span>
                    </div>
                    <button class = "fa fa-circle-xmark removeDish"></button>
                </article>    
                <?php } ?>
            </section>
            <?php }else{drawEmptySectionDishes();} ?>    
            <form action = "../pages/addDish.php" method = "post">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input type = "hidden" id="idRestaurant" name="restaurantId" value = <?=$restaurant->id?>>
                <button type = "submit" id = "buttonAddDish">Add Dish</button>
            </form>         
<?php }?>

<?php function drawReviewsOwner(array $reviews) { ?>
    <h2>Reviews</h2>
    <?php if(count($reviews) != 0) {?>
    <section id = 'reviews'>
        <?php foreach ($reviews as $review) { ?>
            <article class = "restaurantReview" id = <?=$review->id?>>
                <span class = "reviewUserName"><?=$review->userName?></span>
                <div class = "reviewContent">
                    <p class = "reviewText"><?=$review->comment?></p>
                    <div class = "reviewS">
                        <span class = "reviewScore"><?=$review->score?></span>
                        <i class = 'fa fa-star-o '></i>
                    </div>
                </div>
                <?php if($review->answer != "") { ?>
                <p class = "reviewAnswer"><?=$review->answer?></p>
                <?php } else { ?>
                <form action = "../actions/actionAddAnswer.php" method = "post">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">    
                    <input type = "hidden" name="restaurantId" value = <?=$review->restaurantId?>>
                    <input type = "hidden" name="reviewId" value = <?=$review->id?>>
                    <input type = "text" placeholder = "Type your comment" class = "addAnswerForm" name = "answerText">
                    <button type = "submit" id = "buttonAddAnswer">Add Answer</button>
                </form>         
                <?php } ?>
            </article>
        <?php } ?>
    </section>
    <?php }else{drawEmptySectionReviews();} ?>
    </div>
    </div>
<?php } ?>


<?php function drawAddReview(int $restaurantId){ ?>
    <form action = "../actions/actionAddReview.php" method = "post" id = "createReview">
        <h1>Add a new review</h1>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="hidden" name="restaurantId" value=<?=$restaurantId?>>
        <input type = "text" placeholder = "Comment" id = "textReview" name = "comment" required>
        <input type = "number" placeholder = "Score" id = "scoreReview" name = "score" min = "0" max = "5" required>
        <button type = "submit" id = "addReviewButton" name = "createReview">Add Review</button>
    </form> 
<?php } ?>

