<?php
    declare(strict_types = 1);

    class Restaurant{
        public int $id;
        public string $name;
        public int $userId;
        public string $phoneNumber;
        public string $email;
        public string $categoryName;
        public string $address;
        public float $rating;

        public function __construct(int $id, int $userId, string $name , string $phoneNumber, string $email, string $categoryName, string $address, float $rating)
        {
            $this->id = $id;
            $this->name = $name;
            $this->userId = $userId;
            $this->phoneNumber = $phoneNumber;
            $this->email = $email;
            $this->categoryName = $categoryName;
            $this->address = $address;
            $this->rating = $rating;
        }

        
        static function getRestaurants (PDO $db) : array {
            $stmt = $db->prepare('Select * FROM Restaurant');
            $stmt->execute();

            $query = $db->prepare('SELECT * FROM Restaurant left join (SELECT RestaurantId, round(avg(Score),2) as rating FROM REVIEW GROUP BY RestaurantId ORDER BY RestaurantId) using (RestaurantId)');
            $query->execute();

            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                    if(!isset($restaurant)){
                        return null;
                    }
                    $ratingQuery = $query->fetch();
                    $rating;
                    if(intval($restaurant['RestaurantId']) === intval($ratingQuery['RestaurantId'])){
                        $rating = floatval($ratingQuery['rating']);
                    }else{
                        $rating = 0.0;
                    }
                    $restaurants[] = new Restaurant(
                    intval($restaurant['RestaurantId']),
                    intval($restaurant['UserId']),
                    htmlentities($restaurant['Name']),
                    htmlentities($restaurant['PhoneNumber']),
                    htmlentities($restaurant['Email']),
                    htmlentities($restaurant['CategoryName']),
                    htmlentities($restaurant['Address']),
                    $rating 
                );
            }

            return $restaurants;
        }

        static function getRestaurantsUserId (PDO $db, int $userId) : array {
            $stmt = $db->prepare('SELECT CategoryName,Email,rId, rating, Name,Address,PhoneNumber,uId FROM 
            (SELECT RestaurantId as rId,UserId as uId, Name, PhoneNumber, Email , CategoryName, Address, rating FROM Restaurant left Join 
                    (SELECT RestaurantId, round(avg(score),2) AS Rating FROM Review GROUP BY RestaurantId) using(RestaurantId))
            Where uId = ?');
            $stmt->execute(array($userId));


            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                    if($restaurant['rating'] == null){
                        $rating = 0.0;
                    }else{
                        $rating = floatval($restaurant['rating']);
                    }
                    $restaurants[] = new Restaurant(
                    intval($restaurant['rId']),
                    intval($restaurant['uId']),
                    htmlentities($restaurant['Name']),
                    htmlentities($restaurant['PhoneNumber']),
                    htmlentities($restaurant['Email']),
                    htmlentities($restaurant['CategoryName']),
                    htmlentities($restaurant['Address']),
                    $rating
                );
            }

            return $restaurants;
        }

        static function getRestaurant(PDO $db, int $id)  {
            $stmt = $db->prepare('Select * From Restaurant Where RestaurantId = ? ');
            $stmt->execute(array($id));

            if($restaurant = $stmt->fetch()){
                return new Restaurant(
                    intval($restaurant['RestaurantId']),
                    intval($restaurant['UserId']),
                    htmlentities($restaurant['Name']),
                    htmlentities($restaurant['PhoneNumber']),
                    htmlentities($restaurant['Email']),
                    htmlentities($restaurant['CategoryName']),
                    htmlentities($restaurant['Address']),
                    0.0
                );
            }else{
                return null;
            }
        }

        static function isRestaurantOwner(PDO $db, int $restaurantId, int $ownerId){
            $stmt = $db->prepare('Select * From Restaurant Where RestaurantId = ? ');
            $stmt->execute(array($restaurantId));

            if($restaurant = $stmt->fetch()){
               if(intval($restaurant['UserId']) === $ownerId){
                   return true;
               }    
            }else{
                return false;
            }
        }

        static function favoriteRestaurant(PDO $db, $restaurantId,$userId){
            $stmt = $db->prepare('INSERT INTO FavoriteRestaurant Values (?,?)');
            try{
                $stmt->execute(array($restaurantId,$userId));
            }catch(PDOException $e) {
                //Tentar dar favorito a um restaurant que já deu
            }
        }

        static function removeFavoriteRestaurant(PDO $db, int $restaurantId, int $userId){
            $stmt = $db->prepare('Delete From FavoriteRestaurant Where RestaurantId = ? AND UserId = ?');
            $stmt->execute(array($restaurantId,$userId));
        }

        static function searchRestaurantsByCategory(PDO $db, string $category){
            $stmt = $db->prepare('SELECT CategoryName,Email,RestaurantId, Rating, Name,Address,PhoneNumber,UserId FROM Restaurant left Join 
            (SELECT RestaurantId, round(avg(score),2) AS Rating FROM Review GROUP BY RestaurantId) using(RestaurantId) WHERE CategoryName = ?');
            
            $stmt->execute(array($category));
            

            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                    if($restaurant['Rating'] == null){
                        $rating = 0.0;
                    }else{
                        $rating = floatval(htmlentities(strval($restaurant['Rating'])));
                    }
                    $restaurants[] = new Restaurant(
                    intval($restaurant['RestaurantId']),
                    intval($restaurant['UserId']),
                    htmlentities($restaurant['Name']),
                    htmlentities($restaurant['PhoneNumber']),
                    htmlentities($restaurant['Email']),
                    htmlentities($restaurant['CategoryName']),
                    htmlentities($restaurant['Address']),
                    $rating
                ); 
            }
            return $restaurants;

        }

        static function searchRestaurantsFavorites(PDO $db, int $userId){
            $stmt = $db->prepare('SELECT CategoryName,Email,rId, rating, Name,Address,PhoneNumber,uId FROM FavoriteRestaurant, 
            (SELECT RestaurantId as rId,UserId as uId, Name, PhoneNumber, Email , CategoryName, Address, rating FROM Restaurant left Join 
                    (SELECT RestaurantId, round(avg(score),2) AS Rating FROM Review GROUP BY RestaurantId) using(RestaurantId))
            Where FavoriteRestaurant.UserId = ? AND FavoriteRestaurant.RestaurantId = rId');

            $stmt->execute(array($userId));

            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                    if($restaurant['rating'] == null){
                        $rating = 0.0;
                    }else{
                        $rating = floatval(htmlentities(strval($restaurant['rating'])));
                    }
                    $restaurants[] = new Restaurant(
                    intval($restaurant['rId']),
                    intval($restaurant['uId']),
                    htmlentities($restaurant['Name']),
                    htmlentities($restaurant['PhoneNumber']),
                    htmlentities($restaurant['Email']),
                    htmlentities($restaurant['CategoryName']),
                    htmlentities($restaurant['Address']),
                    $rating
                );
            }


            return $restaurants;

        }

        static function searchRestaurantsByName (PDO $db, string $restaurantName){
            $stmt = $db->prepare('SELECT CategoryName , Email,RestaurantId, rating,rName,Address,PhoneNumber,uId FROM (SELECT RestaurantId, UserId as uId, Name as rName, PhoneNumber, Email , CategoryName, Address, rating 
            FROM Restaurant left Join (SELECT RestaurantId, round(avg(score),2) AS Rating 
            FROM Review GROUP BY RestaurantId) 
            using(RestaurantId)) where rName LIKE ?');
            $stmt->execute(array("%".$restaurantName."%"));


            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                if($restaurant['rating'] == null){
                $rating = 0.0;
                }else{
                    $rating = floatval(htmlentities(strval($restaurant['rating'])));
                }
                $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                intval($restaurant['uId']),
                htmlentities($restaurant['rName']),
                htmlentities($restaurant['PhoneNumber']),
                htmlentities($restaurant['Email']),
                htmlentities($restaurant['CategoryName']),
                htmlentities($restaurant['Address']),
                $rating
                );
            }

        return $restaurants;
        }
       

        static function searchRestaurantsByDishName (PDO $db, string $dishName){
            $stmt = $db->prepare('SELECT DISTINCT RestaurantId, CategoryName,Email, rating,rName,Address,PhoneNumber,uId 
            FROM Dishes inner join(SELECT RestaurantId, UserId as uId, Name as rName, PhoneNumber, Email , CategoryName, Address, rating 
            FROM Restaurant left Join (SELECT RestaurantId, round(avg(score),2) AS Rating 
            FROM Review) 
            using(RestaurantId)) using (RestaurantId) where Dishes.name LIKE ?');
            $stmt->execute(array("%".$dishName."%"));


            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                if($restaurant['rating'] == null){
                $rating = 0.0;
                }else{
                    $rating = floatval(htmlentities(strval($restaurant['rating'])));
                }
                $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                intval($restaurant['uId']),
                htmlentities($restaurant['rName']),
                htmlentities($restaurant['PhoneNumber']),
                htmlentities($restaurant['Email']),
                htmlentities($restaurant['CategoryName']),
                htmlentities($restaurant['Address']),
                $rating
                );
            }

        return $restaurants;
        }

        static function searchRestaurantsByScore (PDO $db, float $score){
            $stmt = $db->prepare('SELECT RestaurantId, CategoryName , Email, rating, rName, Address, PhoneNumber, uId FROM (SELECT RestaurantId, UserId as uId, Name as rName, PhoneNumber, Email , CategoryName, Address, rating 
            FROM Restaurant left Join (SELECT RestaurantId, round(avg(score),2) AS Rating 
            FROM Review GROUP BY RestaurantId) 
            using(RestaurantId)) where rating >= round(?,2)');
            $stmt->execute(array($score));


            $restaurants = array();
            while($restaurant = $stmt->fetch()){
                if($restaurant['rating'] == null){
                $rating = 0.0;
                }else{
                    $rating = floatval(htmlentities(strval($restaurant['rating'])));
                }
                $restaurants[] = new Restaurant(
                intval($restaurant['RestaurantId']),
                intval($restaurant['uId']),
                htmlentities($restaurant['rName']),
                htmlentities($restaurant['PhoneNumber']),
                htmlentities($restaurant['Email']),
                htmlentities($restaurant['CategoryName']),
                htmlentities($restaurant['Address']),
                $rating
                );
            }

            return $restaurants;
        }
    }