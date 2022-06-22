var removeButtonsDishes = document.getElementsByClassName("removeDish")
for (var i = 0; i < removeButtonsDishes.length; i++) {
    var button = removeButtonsDishes[i];
    button.addEventListener('click', removeClick);
}

async function removeClick(event) {
    var button = event.target
    var article = button.parentElement
    var dishId = article.getAttribute('id')
    const response = await fetch('../apis/apiRemoveFromDishes.php?dishId=' + dishId)
    article.remove()
    location.reload();
}
