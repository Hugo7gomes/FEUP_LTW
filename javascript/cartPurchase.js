var cartPurchaseButton = document.getElementsByClassName("purchaseButton")[0];
cartPurchaseButton.addEventListener("click",purchaseClick)


async function purchaseClick(event){
    var RestaurantId = document.getElementsByClassName("restaurantMainPage")[0].id
    
    var button = event.target;
    var cartNav = button.parentElement
    var cartItemsDiv = cartNav.getElementsByClassName("cartItems")[0]
    var items = cartItemsDiv.getElementsByClassName("cartRow")
    if(items.length == 0){
        return;
    }
    const response = await fetch('../apis/apiAddOrder.php?RestaurantId=' + RestaurantId)
    const order = await response.json()
    const orderId = order['max(OrderId)']

    for(var i = 0; i < items.length;i++){
        var divCartRow = items[i]
        var cartItemDiv = divCartRow.getElementsByClassName("cartItem")[0]
        var dishId = cartItemDiv.id
        const response1 = await fetch('../apis/apiAddDishToOrder.php?orderId=' + orderId + '&dishId='+dishId)
    }

    location.reload()
}
