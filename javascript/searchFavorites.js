var favoriteButtonCategory = document.querySelector('#categoryFavorites');
favoriteButtonCategory.addEventListener('click',favoriteCategoryClick);

async function favoriteCategoryClick(event){
    const response = await fetch('../apis/apiSearchRestaurantsByCategory.php?category='+this.innerText);
    const restaurants = await response.json();

    const sectionRestaurants = document.querySelector('#restaurants');

    sectionRestaurants.innerHTML = ''


    const sectionDishes = document.querySelector('#dishesFavorite');
    const dishesH2 = document.querySelector('.titleDishesLogin');

    if(dishesH2.innerText == ""){
        dishesH2.innerText = "Dishes"
    }

    if(sectionDishes != null){
        sectionDishes.innerHTML = ''
    }
    

    for(const restaurant of restaurants){
        var restaurantContent = `
                <a href = "../pages/restaurant.php?id=${restaurant.id}">
                    <img class = "restaurantImg" src = "https://picsum.photos/200?${restaurant.id}">
                </a>                    
                <div class = "restaurantContent">
                    <span class = "restaurantName">${restaurant.name}</span>
                    <span class = "restaurantRating">${restaurant.rating}</span>
                </div>
        `
        var article = document.createElement('article');
        article.classList.add('restaurant');
        article.setAttribute('id',restaurant.id);
        article.innerHTML = restaurantContent;

        var buttonRemoveFavorite = document.createElement('button');
        buttonRemoveFavorite.classList.add('fa');
        buttonRemoveFavorite.classList.add('fa-circle-xmark');
        buttonRemoveFavorite.classList.add('removeFavorite');
        article.appendChild(buttonRemoveFavorite);
        sectionRestaurants.appendChild(article); 
        buttonRemoveFavorite.addEventListener('click', removeFavoriteClick);
    }

    if(this.innerHTML == 'Favorites'){
        const responseDishes = await fetch('../apis/apiSearchFavoriteDishes.php');
        const dishes = await responseDishes.json();

        
        
        for(const dish of dishes){
            var dishContent = ` 
                <img class = "dishImg" src = "https://picsum.photos/200?${dish.id}">
                <div class = "dishContent">
                    <span class = "dishName">${dish.name}</span>
                    <span class = "dishPrice">${dish.price}€</span>
                </div>
            `
    
            var articleDish = document.createElement('article');
            articleDish.classList.add('dishFavorite');
            articleDish.setAttribute('id',dish.id);
            articleDish.innerHTML = dishContent;

            var buttonRemoveFavoriteDish = document.createElement('button');
            buttonRemoveFavoriteDish.classList.add('fa');
            buttonRemoveFavoriteDish.classList.add('fa-circle-xmark');
            buttonRemoveFavoriteDish.classList.add('dishRemoveFavorite');
            articleDish.appendChild(buttonRemoveFavoriteDish);
            
            
            sectionDishes.appendChild(articleDish)
       

            buttonRemoveFavoriteDish.addEventListener('click', removeFavoriteDishClick);
        }
    }
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

async function removeFavoriteClick(event) {
    var button = event.target
    var article = button.parentElement;
    var restaurantId = article.getAttribute('id');
    const response = await fetch('../apis/apiRemoveRestaurantFromFavorites.php?restaurantId='+restaurantId);
    var favoriteButtonCategory = document.querySelector('#categoryFavorites');
    favoriteButtonCategory.click();
}

async function removeFavoriteDishClick(event) {
    var button = event.target
    var article = button.parentElement;
    var dishId = article.getAttribute('id');
    const response = await fetch('../apis/apiRemoveDishFromFavorites.php?dishId='+dishId);
    var favoriteButtonCategory = document.querySelector('#categoryFavorites');
    favoriteButtonCategory.click();
}



