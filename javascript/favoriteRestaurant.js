var favoriteButtons = document.getElementsByClassName('favoriteRestaurant');
for (var i = 0; i < favoriteButtons.length; i++) {
    var button = favoriteButtons[i];
    button.addEventListener('click', favoriteClick);
}

async function favoriteClick(event) {
    var button = event.target
    var divRatingStar = button.parentElement
    var divRestaurantContent = divRatingStar.parentElement
    var div = divRestaurantContent.parentElement
    
    var article = div.parentElement
    var restaurantId = article.getAttribute('id')
    const response = await fetch('../apis/apiFavoriteRestaurant.php?restaurantId=' + restaurantId)
}

