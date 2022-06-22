<?php
    declare(strict_types = 1);

    require_once(__DIR__ .'/../database/order.class.php');
    
?>

<?php function drawOrdersRestaurant(array $orders){?>
    <h2>Orders</h2>
    <section id = "orders">
        <?php foreach($orders as $order){ 
        if($order->state !== 'Ready'){ ?>
            <article class = "order">
                <form action = "../actions/actionChangeOrderState.php" method = "post">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <input type = "hidden" name = "OrderId" value = "<?=$order->id?>">
                    <input type = "hidden" name = "RestaurantId" value = "<?=$order->restaurantId?>">
                    <select class = "changeOrderState" name = "State">
                        <option value="" selected disabled hidden><?=$order->state?></option>
                        <option value = "Ready">Ready</option>
                        <option value = "Received">Received</option>
                        <option value = "Preparing">Preparing</option>
                        <option value = "Delivered">Delivered</option>
                    </select>
                    <button class = "buttonChangeOrderState" type = "submit">Change State</button>
                </form>
                <section class = "dishes">
                    <?php foreach ($order->dishes as $dish) { ?>
                    <article class = 'dishOrder'>
                        <div class = "dishContent">
                            <span class = "dishName"><?=$dish->name?></span>
                            <span class = "dishPrice"><?=$dish->price?>€</span>
                        </div>
                    </article>    
                    <?php } ?>
                </section>                   
            </article>
        <?php } } ?>
    </section>
<?php } ?>

<?php function drawOrdersUser(array $orders){?>
    <h2>Orders</h2>
    <section id = "orders">
        <?php foreach($orders as $order){ ?>
            <article class = "order">
                <span class = "orderNameRestaurant"><?=$order->restaurantName?></span>
                <span class = "orderState">State: <?=$order->state?></span>
                <section class = "dishes">
                    <?php foreach ($order->dishes as $dish) { ?>
                    <article class = 'dishOrder' >
                        <div class = "dishContent">
                            <span class = "dishName"><?=$dish->name?></span>
                            <span class = "dishPrice"><?=$dish->price?>€</span>
                        </div>
                    </article>    
                    <?php } ?>
                </section>
                <form action = "../pages/reviewRestaurant.php" method = "post">
                    <input type = "hidden" name = "RestaurantId" value = "<?=$order->restaurantId?>" >
                    <button id = "buttonReviewRestaurant">Review Restaurant</button>
                </form>
            </article>
        <?php } ?>
    </section>
<?php } ?>

