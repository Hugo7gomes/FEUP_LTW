var removeCartButtons = document.getElementsByClassName('removeButton');
for (var i = 0; i < removeCartButtons.length; i++){
    var button = removeCartButtons[i];
    button.addEventListener('click',removeFromCartClick);
}

var addToCartButtons = document.getElementsByClassName('buttonAddItemCart');
for(var i = 0; i < addToCartButtons.length; i++){
    var button = addToCartButtons[i];
    button.addEventListener('click',addToCartClick)
}

var inputQuantityButtons = document.getElementsByClassName('cartQuantityInput');
console.log(inputQuantityButtons.length)
for(var i = 0; i < inputQuantityButtons.length; i++){
    var input = inputQuantityButtons[i];
    input.addEventListener('change',quantityChangeClick)
}


function quantityChangeClick(event){
    var input = event.target
    if(isNaN(input.value) | input.value <= 0){
        input.value = 1;
    }
    updateTotalPrice();

}

function addToCartClick(event){
    openCartSideNav()
    var button = event.target
    var item = button.parentElement
    var dishId = item.getAttribute("id")
    var price = item.getElementsByClassName('dishPrice')[0].innerText
    var title = item.getElementsByClassName('dishName')[0].innerText
    addItemToCart(title, price, dishId);
    updateTotalPrice();
}

function removeFromCartClick(event){
    var button = event.target
    button.parentElement.parentElement.remove();
    updateTotalPrice();
}

function addItemToCart(title, price, dishId){
    var cartItemsContainer = document.getElementsByClassName("cartItems")[0];
    var cartItemsNames = document.getElementsByClassName("cartItemName");
    for(var i = 0; i < cartItemsNames.length; i++){
        if(title == cartItemsNames[i].innerText){
            alert('This item is already in the cart');
            return;
        }
    }
    var cartItemContent = `
            <div class = "cartItem cartColumn" id = ${dishId}>
                <img class = "cartItemImg" src = "https://picsum.photos/200?">
                <span class = "cartItemName">${title}</span>
            </div>
            <span class = "cartItemPrice cartColumn">${price}</span>
            <div class = "cartItemQuantity cartColumn">
                <input type = "number" class = "cartQuantityInput" value = "1">
                <button class = "removeButton">REMOVE</button>
            </div>`

    var cartItem = document.createElement('div');
    cartItem.classList.add('cartRow');
    cartItem.innerHTML = cartItemContent;
    cartItemsContainer.appendChild(cartItem);
    cartItem.getElementsByClassName("removeButton")[0].addEventListener("click",removeFromCartClick)
    cartItem.getElementsByClassName("cartQuantityInput")[0].addEventListener("change",quantityChangeClick)    
}

function updateTotalPrice(){
    var cartItemsContainer = document.getElementsByClassName('cartItems')[0]
    var cartItems = cartItemsContainer.getElementsByClassName('cartRow')
    var total = 0;
    for (var i = 0; i < cartItems.length; i++){
        var priceItem = cartItems[i].getElementsByClassName('cartItemPrice')[0].innerText //nao esquecer remover euro
        var quantity = cartItems[i].getElementsByClassName('cartQuantityInput')[0].value
        priceItem = parseFloat(priceItem.replace('€',''))
        total = total + (priceItem*quantity)
    }

    document.getElementsByClassName('cartTotalPrice')[0].innerText = total + '€';

}

function openCartSideNav(){
    'use strict';
    closeSearchNav();
    document.getElementById("cartSideNav").style.width = "500px";
}

function closeCartSideNav(){
    'use strict';
    document.getElementById("cartSideNav").style.width = "0";
}