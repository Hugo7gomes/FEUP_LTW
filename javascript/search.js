var buttonSearch = document.getElementsByClassName("btn-search")[0];
buttonSearch.addEventListener("click",search);


async function search(event){
    var button = event.target
    var divSearch = document.getElementsByClassName("search-box")[0];
    var searchText = divSearch.getElementsByTagName("input")[0].value;
    
    var searchSideNav = document.getElementsByClassName("searchSideNav")[0];
    var selectSideNav = searchSideNav.querySelector("#searchType");
    var value = selectSideNav.value
    const response = await fetch('../apis/apiSearchBarRestaurants.php?searchType='+value+'&searchText='+searchText);
    const restaurants = await response.json();
    console.log(restaurants);
    closeSearchNav();

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
                <a href = "restaurant.php?id=${restaurant.id}"><img class = "restaurantImg" src = "https://picsum.photos/200?${restaurant.id}"></a>
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
}

function openSearchNav () {
    'use strict';
    closeCartSideNav()
    document.getElementsByClassName("searchSideNav")[0].style.height = "250px";
}

function closeSearchNav () {
    'use strict';
    document.getElementsByClassName("searchSideNav")[0].style.height = "0px";
}    

