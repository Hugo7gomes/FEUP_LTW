var categoriesButtons = document.getElementsByClassName('categoryButton');

for(var i=0; i<categoriesButtons.length; i++){
    var button = categoriesButtons[i];
    
    button.addEventListener('click',async function(){
        const response = await fetch('../apis/apiSearchRestaurantsByCategory.php?category='+this.innerText);
        const restaurants = await response.json();
    
        const section = document.querySelector('#restaurants');
        section.innerHTML = ''


        const sectionDishes = document.querySelector('#dishesFavorite');
        const dishesH2 = document.querySelector('.titleDishesLogin');

        if(dishesH2 != null){
            dishesH2.innerText = ""
        }

        if(sectionDishes != null){
            sectionDishes.innerHTML = ''
        }

        for(const restaurant of restaurants){
            var restaurantContent = `
                <div>
                    <a href = "../pages/restaurant.php?id=${restaurant.id}"><img class = "restaurantImg" src = "https://picsum.photos/200?${restaurant.id}"></a>
                    <div class = "restaurantContent">
                        <div class = "restaurantName">${restaurant.name}</div><br>
                        <div class = "ratingStar">
                            <div class = "restaurantRating">${restaurant.rating}</div><br>
                        </div>
                    </div>
                </div>                    
                `
            var article = document.createElement('article');
            article.classList.add('restaurant');
            article.setAttribute('id',restaurant.id);
            article.innerHTML = restaurantContent;
            
            var div = article.getElementsByClassName("ratingStar")[0];
            
            var buttonFavorite = document.createElement('button');
            buttonFavorite.classList.add('fa')
            buttonFavorite.classList.add('fa-star-o')
            buttonFavorite.classList.add('favoriteRestaurant')
            buttonFavorite.addEventListener('click',favoriteClick)
            div.appendChild(buttonFavorite);

            section.appendChild(article); 
        }
    });
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
