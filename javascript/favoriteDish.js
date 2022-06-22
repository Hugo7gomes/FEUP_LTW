var favoriteDishButtons = document.getElementsByClassName('buttonFavoriteDish');
for (var i = 0; i < favoriteDishButtons.length; i++) {
    var button = favoriteDishButtons[i];
    button.addEventListener('click', favoriteDishClick);
}

async function favoriteDishClick(event) {
    var button = event.target
    var div = button.parentElement
    var article = div.parentElement
    var dishId = article.getAttribute('id')
    const response = await fetch('../apis/apiFavoriteDishes.php?dishId=' + dishId)
}

