<?php
    declare(strict_types = 1);
    require_once(__DIR__ .'/../database/session.class.php');

    require_once(__DIR__ .'/../database/user.class.php')
?>

<?php function drawEditProfileForm($user, Session $session) { ?>
    <?php 
    if($user->phoneNumber == ""){
        $user->phoneNumber = "No phoneNumber";
    }
    if($user->address == ""){
        $user->address = "No address";
    }?>
    <?php 
        if($session->getIsOwner()){ ?>
            <div id = "buttonsOwner"> 
                <form action = "../pages/showRestaurantsOwner.php">
                    <button id = "buttonRestaurantsOwner">See my restaurants</button>
                </form>
                <form action = "../pages/addRestaurant.php">                
                    <button id = "buttonAddRestaurant">Add Restaurant</button>
                </form>
                <form action = "../pages/showUserOrders.php">                
                    <button id = "buttonShowUserOrders">View my orders</button>
                </form>  
            </div>
            <?php } else { ?>
            <div id = "buttonsNotOwner">    
                <form action = "../pages/addRestaurant.php">                
                    <button id = "buttonBecomeOwner">Become a owner</button>
                </form>
                <form action = "../pages/showUserOrders.php">                
                        <button id = "buttonShowUserOrders">View my orders</button>
                </form>
            </div>              
        <?php }?>
        
    <form action = "../actions/actionEditProfile.php" method = "post" id = "editProfile">
        <h1>Update Profile</h1>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type = "text" placeholder = "<?=$user->name?>" id = "nameUpdate" name = "name" >
        <input type = "password" placeholder = "Enter new password" id = "passUpdate" name = "password" >
        <input type = "tel" placeholder = "<?=$user->phoneNumber?>" id = "phoneNumberUpdate" name = "phoneNumber" pattern = "9[0-9]{8}" >
        <input type = "text" placeholder = "<?=$user->address?>" id = "addressUpdate" name = "address" >
        
        <button type = "submit" id= "updateProfileButton" name = "updateProfile">Update Profile</button>
    </form>  
<?php } ?>
